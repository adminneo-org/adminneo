<?php

namespace AdminNeo;

$TABLE = $_GET["create"];
$partition_by = [];
foreach (['HASH', 'LINEAR HASH', 'KEY', 'LINEAR KEY', 'RANGE', 'LIST'] as $key) {
	$partition_by[$key] = $key;
}

$referencable_primary = referencable_primary($TABLE);
$foreign_keys = [];
foreach ($referencable_primary as $table_name => $field) {
	$foreign_keys[str_replace("`", "``", $table_name) . "`" . str_replace("`", "``", $field["field"])] = $table_name; // not idf_escape() - used in JS
}

$orig_fields = [];
$table_status = [];
if ($TABLE != "") {
	$orig_fields = fields($TABLE);
	$table_status = table_status($TABLE);
	if (!$table_status) {
		Admin::get()->addError(lang('No tables.'));
	}
}

$row = $_POST;
$row["fields"] = (array) $row["fields"];
if ($row["auto_increment_col"]) {
	$row["fields"][$row["auto_increment_col"]]["auto_increment"] = true;
}

if ($_POST) {
	Admin::get()->getSettings()->updateParameter("commentsOpened", $_POST["comments"] ?? null);
}

if ($_POST && !process_fields($row["fields"]) && !Admin::get()->getErrors()) {
	if ($_POST["drop"]) {
		queries_redirect(substr(ME, 0, -1), lang('Table has been dropped.'), drop_tables([$TABLE]));
	} else {
		$fields = [];
		$all_fields = [];
		$use_all_fields = false;
		$foreign = [];
		$orig_field = reset($orig_fields);
		$after = " FIRST";

		foreach ($row["fields"] as $key => $field) {
			$foreign_key = $foreign_keys[$field["type"]];
			$type_field = ($foreign_key !== null ? $referencable_primary[$foreign_key] : $field); //! can collide with user defined type
			if ($field["field"] != "") {
				if (!$field["generated"]) {
					$field["default"] = null;
				}
				$process_field = process_field($field, $type_field);
				$all_fields[] = [$field["orig"], $process_field, $after];
				if (!$orig_field || $process_field !== process_field($orig_field, $orig_field)) {
					$fields[] = [$field["orig"], $process_field, $after];
					if ($field["orig"] != "" || $after) {
						$use_all_fields = true;
					}
				}
				if ($foreign_key !== null) {
					$foreign[idf_escape($field["field"])] = ($TABLE != "" && DIALECT != "sqlite" ? "ADD" : " ") . format_foreign_key([
						'table' => $foreign_keys[$field["type"]],
						'source' => [$field["field"]],
						'target' => [$type_field["field"]],
						'on_delete' => $field["on_delete"],
					]);
				}
				$after = " AFTER " . idf_escape($field["field"]);
			} elseif ($field["orig"] != "") {
				$use_all_fields = true;
				$fields[] = [$field["orig"]];
			}
			if ($field["orig"] != "") {
				$orig_field = next($orig_fields);
				if (!$orig_field) {
					$after = "";
				}
			}
		}

		$partitioning = "";
		if (support("partitioning")) {
			if (isset($partition_by[$row["partition_by"]])) {
				$params = [];
				foreach ($row as $key => $val) {
					if (preg_match('~^partition~', $key)) {
						$params[$key] = $val;
					}
				}

				foreach ($params["partition_names"] as $key => $name) {
					if ($name === "") {
						unset($params["partition_names"][$key]);
						unset($params["partition_values"][$key]);
					}
				}

				if ($params != get_partitions_info($TABLE)) {
					$partitions = [];
					if ($params["partition_by"] == 'RANGE' || $params["partition_by"] == 'LIST') {
						foreach ($params["partition_names"] as $key => $name) {
							$value = $params["partition_values"][$key];
							$partitions[] = "\n  PARTITION " . idf_escape($name) . " VALUES " . ($params["partition_by"] == 'RANGE' ? "LESS THAN" : "IN") . ($value != "" ? " ($value)" : " MAXVALUE"); //! SQL injection
						}
					}

					// $params["partition"] can be expression, not only column
					$partitioning .= "\nPARTITION BY {$params["partition_by"]}({$params["partition"]})";
					if ($partitions) {
						$partitioning .= " (" . implode(",", $partitions) . "\n)";
					} elseif ($params["partitions"]) {
						$partitioning .= " PARTITIONS " . (int)$params["partitions"];
					}
				}
			} elseif (preg_match("~partitioned~", $table_status["Create_options"])) {
				$partitioning .= "\nREMOVE PARTITIONING";
			}
		}

		$message = lang('Table has been altered.');
		if ($TABLE == "") {
			cookie("neo_engine", $row["Engine"] ?? "");
			$message = lang('Table has been created.');
		}
		$name = trim($row["name"]);

		queries_redirect(ME . (support("table") ? "table=" : "select=") . urlencode($name), $message, alter_table(
			$TABLE,
			$name,
			(DIALECT == "sqlite" && ($use_all_fields || $foreign) ? $all_fields : $fields),
			$foreign,
			($row["Comment"] != $table_status["Comment"] ? $row["Comment"] : null),
			($row["Engine"] && $row["Engine"] != $table_status["Engine"] ? $row["Engine"] : ""),
			($row["Collation"] && $row["Collation"] != $table_status["Collation"] ? $row["Collation"] : ""),
			($row["Auto_increment"] != "" ? number($row["Auto_increment"]) : ""),
			$partitioning
		));
	}
}

if ($TABLE != "") {
	page_header(lang('Alter table') . ": " . h($TABLE), ["table" => $TABLE, lang('Alter table')]);
} else {
	page_header(lang('Create table'), [lang('Create table')]);
}

if (!$_POST) {
	$types = Driver::get()->getTypes();

	$row = [
		"Engine" => $_COOKIE["neo_engine"],
		"fields" => [["field" => "", "type" => (isset($types["int"]) ? "int" : (isset($types["integer"]) ? "integer" : "")), "on_update" => ""]],
		"partition_names" => [""],
	];

	if ($TABLE != "") {
		$row = $table_status;
		$row["name"] = $TABLE;
		$row["fields"] = [];
		if (!$_GET["auto_increment"]) { // don't prefill by original Auto_increment for the sake of performance and not reusing deleted ids
			$row["Auto_increment"] = "";
		}
		foreach ($orig_fields as $field) {
			$field["generated"] = $field["generated"] ?: (isset($field["default"]) ? "DEFAULT" : "");
			$row["fields"][] = $field;
		}

		if (support("partitioning")) {
			$row += get_partitions_info($TABLE);
			$row["partition_names"][] = "";
			$row["partition_values"][] = "";
		}
	}
}

$keep_collations = [];
if ($row["Collation"]) {
	$keep_collations[$row["Collation"]] = true;
}
foreach ($row["fields"] as $field) {
	if ($field["collation"]) {
		$keep_collations[$field["collation"]] = true;
	}
}

$collations = Admin::get()->getCollations(array_keys($keep_collations));

$engines = Driver::get()->engines();
// case of engine may differ
foreach ($engines as $engine) {
	if (!strcasecmp($engine, $row["Engine"])) {
		$row["Engine"] = $engine;
		break;
	}
}

echo "<form action='' method='post' id='form'>\n";

if (support("columns") || $TABLE == "") {
	echo "<p>";
	echo lang('Table name'), ": ";

	echo "<input class='input' name='name' data-maxlength='64' value='", h($row["name"]), "' autocapitalize='off'", (($TABLE == "" && !$_POST) ? " autofocus" : ""), ">";

	if ($engines) {
		echo " ", html_select("Engine", ["" => "(" . lang('engine') . ")"] + $engines, $row["Engine"]);
		echo help_script_command("value", true);
	}

	if ($collations && !preg_match("~sqlite|mssql~", DIALECT)) {
		echo " ", html_select("Collation", ["" => "(" . lang('collation') . ")"] + $collations, $row["Collation"]);
	}

	echo " <input type='submit' class='button default' value='", lang('Save'), "'>";
	echo "</p>";
}

if (support("columns")) {
	echo "<div class='scrollable'>\n";
	echo "<table id='edit-fields' class='nowrap'>\n";
	edit_fields($row["fields"], $collations, "TABLE", $foreign_keys);
	echo "</table>\n";
	echo script("initFieldsEditing(gid('edit-fields'));");
	if (support("move_col")) {
		echo script("initSortable('#edit-fields tbody');");
	}
	echo "</div>\n";

	echo "<p>";
	echo lang('Auto Increment'), ": ";
	echo "<input type='number' class='input size' name='Auto_increment' size='6' value='", h($row["Auto_increment"]), "'>";

	$comments_opened = $_POST ? $_POST["comments"] : Admin::get()->getSettings()->getParameter("commentsOpened");
	$comment_class = $comments_opened ? "" : "hidden";

	if (support("comment")) {
		echo checkbox("comments", 1, $comments_opened, lang('Comment'), "editingCommentsClick(this, true);", "jsonly");
		echo " ";
		if (preg_match('~\n~', $row["Comment"])) {
			echo "<textarea name='Comment' rows='2' cols='20'", ($comment_class ? " class='$comment_class'" : ""), ">", h($row["Comment"]), "</textarea>";
		} else {
			echo "<input name='Comment' value='", h($row["Comment"]), "' data-maxlength='", (Connection::get()->isMinVersion("5.5") ? 2048 : 60), "' class='input $comment_class'>";
		}
	}

	echo "</p>\n<p>";
	echo "<input type='submit' class='button default' value='", lang('Save'), "'>";
} elseif ($TABLE != "") {
	echo "<p>";
}

if ($TABLE != "") {
	echo "<input type='submit' class='button' name='drop' value='", lang('Drop'), "'>";
	echo confirm(lang('Drop %s?', $TABLE));
	echo "</p>\n";
}

if (support("partitioning")) {
	echo "<div class='field-sets'>\n";
	$partition_table = preg_match('~RANGE|LIST~', $row["partition_by"]);
	print_fieldset_start("partition", lang('Partition by'), "split", (bool)$row["partition_by"]);

	echo "<p>";
	echo html_select("partition_by", ["" => ""] + $partition_by, $row["partition_by"]);
	echo help_script_command("value.replace(/./, 'PARTITION BY \$&')", true);
	echo script("qsl('select').onchange = partitionByChange;");

	echo "(<input class='input' name='partition' value='", h($row["partition"]), "'>) ";
	echo lang('Partitions'), ": ";
	echo "<input type='number' name='partitions' class='input size ", ($partition_table || !$row["partition_by"] ? "hidden" : ""), "' value='", h($row["partitions"]), "'>";
	echo "</p>\n";

	echo "<table id='partition-table'", ($partition_table ? "" : " class='hidden'"), ">\n";
	echo "<thead><tr><th>", lang('Partition name'), "</th><th>", lang('Values'), "</th></tr></thead>\n";

	foreach ($row["partition_names"] as $key => $val) {
		echo "<tr>";
		echo "<td><input class='input' name='partition_names[]' value='", h($val), "' autocapitalize='off'>";
		if ($key == count($row["partition_names"]) - 1) {
			echo script("qsl('input').oninput = partitionNameChange;");
		}
		echo "</td>";
		echo "<td><input class='input' name='partition_values[]' value='", h($row["partition_values"][$key]), "'></td>";
		echo "</tr>\n";
	}

	echo "</table>\n";

	echo "</p>\n";
	print_fieldset_end("partition");
	echo "</div>\n";
}

echo input_token();
echo "</form>\n";
