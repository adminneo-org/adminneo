<?php

namespace AdminNeo;

$TABLE = $_GET["indexes"];
$index_types = ["PRIMARY", "UNIQUE", "INDEX"];
$table_status = table_status1($TABLE, true);
$index_algorithms = Driver::get()->getIndexAlgorithms($table_status);
$connection = Connection::get();
$maria = $connection->isMariaDB();
if (preg_match('~MyISAM|M?aria' . ($connection->isMinVersion($maria ? "10.0.5" : "5.6") ? '|InnoDB' : '') . '~i', $table_status["Engine"])) {
	$index_types[] = "FULLTEXT";
}
if (preg_match('~MyISAM|M?aria' . ($connection->isMinVersion($maria ? "10.2.2" : "5.7") ? '|InnoDB' : '') . '~i', $table_status["Engine"])) {
	$index_types[] = "SPATIAL";
}
$indexes = indexes($TABLE);
$fields = fields($TABLE);
$primary = [];
if (DIALECT == "mongo") { // doesn't support primary key
	$primary = $indexes["_id_"];
	unset($index_types[0]);
	unset($indexes["_id_"]);
}
$row = $_POST;
if ($row) {
	Admin::get()->getSettings()->updateParameter("indexOptions", $row["options"] ?? null);
}
if ($_POST && !$_POST["add"] && !$_POST["drop_col"]) {
	$alter = [];
	foreach ($row["indexes"] as $index) {
		$name = $index["name"];
		if (in_array($index["type"], $index_types)) {
			$columns = [];
			$lengths = [];
			$descs = [];
			$index_algorithm = $index_algorithms ? (in_array($index["algorithm"], $index_algorithms) ? $index["algorithm"] : first($index_algorithms)) : "";
			$index_condition = (support("partial_indexes") ? $index["partial"] : "");
			$set = [];
			ksort($index["columns"]);
			foreach ($index["columns"] as $key => $column) {
				if ($column != "") {
					$length = $index["lengths"][$key] ?? null;
					$desc = $index["descs"][$key] ?? null;
					$set[] = ($fields[$column] ? idf_escape($column) : $column) . ($length ? "(" . (+$length) . ")" : "") . ($desc ? " DESC" : "");
					$columns[] = $column;
					$lengths[] = ($length ?: null);
					$descs[] = $desc;
				}
			}

			$existing = $indexes[$name];
			if ($existing) {
				ksort($existing["columns"]);
				ksort($existing["lengths"]);
				ksort($existing["descs"]);
				if ($index["type"] == $existing["type"]
					&& array_values($existing["columns"]) === $columns
					&& (!$existing["lengths"] || array_values($existing["lengths"]) === $lengths)
					&& array_values($existing["descs"]) === $descs
					&& (!$index_algorithms || $existing["algorithm"] === $index_algorithm)
					&& $existing["partial"] == $index_condition
				) {
					// skip existing index
					unset($indexes[$name]);
					continue;
				}
			}
			if ($columns) {
				$alter[] = [$index["type"], $name, $set, $index_algorithm, $index_condition];
			}
		}
	}

	// drop removed indexes
	foreach ($indexes as $name => $existing) {
		$alter[] = [$existing["type"], $name, "DROP"];
	}
	if (!$alter) {
		redirect(ME . "table=" . urlencode($TABLE));
	}
	queries_redirect(ME . "table=" . urlencode($TABLE), lang('Indexes have been altered.'), alter_indexes($TABLE, $alter));
}

page_header(lang('Alter indexes'), ["table" => $TABLE, lang('Alter indexes')], h($TABLE));

$fields_keys = array_keys($fields);
if ($_POST["add"]) {
	foreach ($row["indexes"] as $key => $index) {
		if ($index["columns"][count($index["columns"])] != "") {
			$row["indexes"][$key]["columns"][] = "";
		}
	}
	$index = end($row["indexes"]);
	if ($index["type"] || array_filter($index["columns"], 'strlen')) {
		$row["indexes"][] = ["columns" => [1 => ""]];
	}
}
if (!$row) {
	foreach ($indexes as $key => $index) {
		$indexes[$key]["name"] = $key;
		$indexes[$key]["columns"][] = "";
	}
	$indexes[] = ["columns" => [1 => ""]];
	$row["indexes"] = $indexes;
}
$lengths = (DIALECT == "sql" || DIALECT == "mssql");
$show_options = $_POST ? $_POST["options"] : Admin::get()->getSettings()->getParameter("indexOptions");

echo "<form action='' method='post'>\n";
echo "<div class='scrollable'>\n";

echo "<table class='nowrap'>\n";
echo "<thead><tr>";
echo "<th id='label-type'>", lang('Index Type'), "</th>";
$options_class = "class='idxopts" . ($show_options ? "" : " hidden") . "'";
if (count($index_algorithms) > 1) {
	echo "<th id='label-method' $options_class>", lang('Algorithm');
	echo doc_link([
		'sql' => 'create-index.html#create-index-storage-engine-index-types',
		'mariadb' => 'ha-and-performance/optimization-and-tuning/optimization-and-indexes/storage-engine-index-types',
		'pgsql' => 'indexes-types.html',
	]);
	echo "</th>";
}

echo "<th><input type='submit' class='button invisible'>";
echo lang('Columns') . ($lengths ? "<span $options_class> (" . lang('length') . ")</span>" : "");
if ($lengths || support("descidx")) {
	echo checkbox("options", 1, $show_options, lang('Options'), "indexOptionsShow(this.checked)", "jsonly") . "\n";
}
echo "</th>";

echo "<th id='label-name'>", lang('Name'), "</th>";
if (support("partial_indexes")) {
	echo "<th id='label-condition' $options_class>", lang('Condition'), "</th>";
}
echo "<th>";
echo "<button name='add[0]' value='1' title='", lang('Add next'), "' class='button light hidden'>", icon_solo("add"), "</button>";
echo "</th>";

echo "</tr></thead>\n";

if ($primary) {
	echo "<tr><td>PRIMARY<td>";
	foreach ($primary["columns"] as $column) {
		echo select_input(" disabled", $fields_keys, $column);
		echo "<label><input type='checkbox' disabled>" . lang('descending') . "</label> ";
	}
	echo "<td><td>\n";
}
$j = 1;
foreach ($row["indexes"] as $index) {
	if (!$_POST["drop_col"] || $j != key($_POST["drop_col"])) {
		echo "<tr><td>",
			html_select("indexes[$j][type]", [-1 => ""] + $index_types, $index["type"], ($j == count($row["indexes"]) ? "indexesAddRow.call(this);" : ""), "label-type"),
			"</td>";

		if (count($index_algorithms) > 1) {
			echo "<td $options_class>",
				html_select("indexes[$j][algorithm]", array_merge([""], $index_algorithms), $index['algorithm'], "label-method"),
				"</td>";
		}

		echo "<td>";
		ksort($index["columns"]);
		$i = 1;
		foreach ($index["columns"] as $key => $column) {
			echo "<span>" . select_input(
				" name='indexes[$j][columns][$i]' title='" . lang('Column') . "'",
				($fields && ($column == "" || $fields[$column]) ? array_combine($fields_keys, $fields_keys) : []),
				$column,
				"partial(" . ($i == count($index["columns"]) ? "indexesAddColumn" : "indexesChangeColumn") . ", '" . js_escape(DIALECT == "sql" ? "" : $_GET["indexes"] . "_") . "')"
			);
			echo "<span $options_class>";
			if ($lengths) {
				echo "<input type='number' name='indexes[$j][lengths][$i]' class='input size' value='". (h($index["lengths"][$key] ?? "")), "' title='" . lang('Length'), "'>";
			}
			if (support("descidx")) {
				echo checkbox("indexes[$j][descs][$i]", 1, $index["descs"][$key] ?? false, lang('descending'));
			}
			echo "</span> </span>";
			$i++;
		}
		echo "</td>";

		echo "<td><input name='indexes[$j][name]' value='", h($index["name"]), "' class='input' autocapitalize='off' aria-labelledby='label-name'></td>\n";
		if (support("partial_indexes")) {
			echo "<td $options_class><input name='indexes[$j][partial]' value='" . h($index["partial"]) . "' autocapitalize='off' aria-labelledby='label-condition'>\n";
		}
		echo "<td>",
			"<button name='drop_col[$j]' value='1' title='", h(lang('Remove')), "' class='button light'>", icon_solo("remove"), "</button>",
			script("qsl('button').onclick = onRemoveIndexRowClick;"),
			"</td>\n";
	}
	$j++;
}

echo "</table>\n";
echo "</div>\n";

echo "<p>";
echo "<input type='submit' class='button default' value='", lang('Save'), "'>";
echo input_token();
echo "</p>\n";

echo "</form>\n";
