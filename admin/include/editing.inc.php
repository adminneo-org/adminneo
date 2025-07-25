<?php
// This file is not used in Editor.

namespace AdminNeo;

/** Print select result
*
* @param Result
* @param ?Connection connection to examine indexes
* @param array
* @param int
*
* @return array $orgtables
*/
function select(Result $result, ?Connection $connection = null, $orgtables = [], $limit = 0) {
	$links = []; // colno => orgtable - create links from these columns
	$indexes = []; // orgtable => array(column => colno) - primary keys
	$columns = []; // orgtable => array(column => ) - not selected columns in primary key
	$blobs = []; // colno => bool - display bytes for blobs
	$types = []; // colno => type - display char in <code>
	$return = []; // table => orgtable - mapping to use in EXPLAIN

	for ($i = 0; (!$limit || $i < $limit) && ($row = $result->fetchRow()); $i++) {
		if (!$i) {
			echo "<div class='scrollable'>\n";
			echo "<table class='nowrap'>\n";
			echo "<thead><tr>";
			for ($j=0; $j < count($row); $j++) {
				$field = (array)$result->fetchField();
				$name = $field["name"];
				$orgtable = $field["orgtable"];
				$orgname = $field["orgname"];
				$return[$field["table"]] = $orgtable;
				if ($orgtables && DIALECT == "sql") { // MySQL EXPLAIN
					$links[$j] = ($name == "table" ? "table=" : ($name == "possible_keys" ? "indexes=" : null));
				} elseif ($orgtable != "") {
					if (!isset($indexes[$orgtable])) {
						// find primary key in each table
						$indexes[$orgtable] = [];
						foreach (indexes($orgtable, $connection) as $index) {
							if ($index["type"] == "PRIMARY") {
								$indexes[$orgtable] = array_flip($index["columns"]);
								break;
							}
						}
						$columns[$orgtable] = $indexes[$orgtable];
					}
					if (isset($columns[$orgtable][$orgname])) {
						unset($columns[$orgtable][$orgname]);
						$indexes[$orgtable][$orgname] = $j;
						$links[$j] = $orgtable;
					}
				}
				if ($field["charsetnr"] == 63) { // 63 - binary
					$blobs[$j] = true;
				}
				$types[$j] = $field["type"];
				echo "<th" . ($orgtable != "" || $field["name"] != $orgname ? " title='" . h(($orgtable != "" ? "$orgtable." : "") . $orgname) . "'" : "") . ">" . h($name)
					. ($orgtables ? doc_link([
						'sql' => "explain-output.html#explain_" . strtolower($name),
						'mariadb' => "explain/#the-columns-in-explain-select",
					]) : "")
				;
			}
			echo "</thead>\n";
		}
		echo "<tr>";
		foreach ($row as $key => $val) {
			$link = "";
			if (isset($links[$key]) && !$columns[$links[$key]]) {
				if ($orgtables && DIALECT == "sql") { // MySQL EXPLAIN
					$table = $row[array_search("table=", $links)];
					$link = ME . $links[$key] . urlencode($orgtables[$table] != "" ? $orgtables[$table] : $table);
				} else {
					$link = ME . "edit=" . urlencode($links[$key]);
					foreach ($indexes[$links[$key]] as $col => $j) {
						$link .= "&where" . urlencode("[" . bracket_escape($col) . "]") . "=" . urlencode($row[$j]);
					}
				}
			} elseif (is_web_url($val)) {
				$link = $val;
			}
			if ($val === null) {
				$val = "<i>NULL</i>";
			} elseif ($blobs[$key] && !is_utf8($val)) {
				$val = "<i>" . lang('%d byte(s)', strlen($val)) . "</i>"; //! link to download
			} else {
				$val = h($val);
				if ($types[$key] == 254) { // 254 - char
					$val = "<code>$val</code>";
				}
			}
			if ($link) {
				$val = "<a href='" . h($link) . "'" . (is_web_url($link) ? target_blank() : '') . ">$val</a>";
			}
			// https://dev.mysql.com/doc/dev/mysql-server/latest/field__types_8h.html
			$class = $types[$key] <= 9 || $types[$key] == 246 ? "class='number'" : "";
			echo "<td $class>$val</td>";
		}
	}
	echo ($i ? "</table>\n</div>" : "<p class='message'>" . lang('No rows.')) . "\n";
	return $return;
}

/** Get referencable tables with single column primary key except self
* @param string
* @return array [$table_name => $field]
*/
function referencable_primary($self) {
	$return = []; // table_name => field
	foreach (table_status('', true) as $table_name => $table) {
		if ($table_name != $self && fk_support($table)) {
			foreach (fields($table_name) as $field) {
				if ($field["primary"]) {
					if ($return[$table_name]) { // multi column primary key
						unset($return[$table_name]);
						break;
					}
					$return[$table_name] = $field;
				}
			}
		}
	}
	return $return;
}

/** Print SQL <textarea> tag
* @param string
* @param string or array in which case [0] of every element is used
* @param int
* @param int
* @return null
*/
function textarea($name, $value, $rows = 10, $cols = 80) {
	echo "<textarea name='" . h($name) . "' rows='$rows' cols='$cols' class='sqlarea jush-" . DIALECT . "' spellcheck='false' wrap='off'>";
	if (is_array($value)) {
		foreach ($value as $val) { // not implode() to save memory
			echo h($val[0]) . "\n\n\n"; // $val == array($query, $time, $elapsed)
		}
	} else {
		echo h($value);
	}
	echo "</textarea>";
}

/** Generate HTML <select> or <input> if $options are empty
* @param string
* @param array
* @param string
* @param string
* @param string
* @return string
*/
function select_input($attrs, $options, $value = "", $onchange = "", $placeholder = "") {
	$tag = ($options ? "select" : "input");
	return "<$tag $attrs" . ($options
			? "><option value=''>$placeholder" . optionlist($options, $value, true) . "</select>"
			: " size='10' value='" . h($value) . "' placeholder='$placeholder'>"
		) . ($onchange ? script("qsl('$tag').onchange = $onchange;", "") : ""); //! use oninput for input
}

/** Print one row in JSON object
* @param string or "" to close the object
* @param string
* @return null
*/
function json_row($key, $val = null) {
	static $first = true;
	if ($first) {
		echo "{";
	}
	if ($key != "") {
		echo ($first ? "" : ",") . "\n\t\"" . addcslashes($key, "\r\n\t\"\\/") . '": ' . ($val !== null ? '"' . addcslashes($val, "\r\n\"\\/") . '"' : 'null');
		$first = false;
	} else {
		echo "\n}\n";
		$first = true;
	}
}

/** Print table columns for type edit
* @param string
* @param array
* @param array
* @param array returned by referencable_primary()
* @param array extra types to prepend
* @return null
*/
function edit_type($key, $field, $collations, $foreign_keys = [], $extra_types = []) {
	$type = $field["type"] ?? null;
	?>
<td><select name="<?php echo h($key); ?>[type]" class="type" aria-labelledby="label-type"><?php
if ($type && !isset(Driver::get()->getTypes()[$type]) && !isset($foreign_keys[$type]) && !in_array($type, $extra_types)) {
	$extra_types[] = $type;
}
$structured_types = Driver::get()->getStructuredTypes();
if ($foreign_keys) {
	$structured_types[lang('Foreign keys')] = $foreign_keys;
}
echo optionlist(array_merge($extra_types, $structured_types), $type);
?></select><td><input name="<?php echo h($key); ?>[length]" value="<?php echo h($field["length"] ?? null); ?>" size="3"<?php echo (!($field["length"] ?? null) && preg_match('~var(char|binary)$~', $type) ? " class='input required'" : " class='input'"); //! type="number" with enabled JavaScript ?> aria-labelledby="label-length"><td class="options"><?php
	echo ($collations ? "<select name='" . h($key) . "[collation]'" . (preg_match('~(char|text|enum|set)$~', $type) ? "" : " class='hidden'") . '><option value="">(' . lang('collation') . ')' . optionlist($collations, $field["collation"] ?? null) . '</select>' : '');
	echo (Driver::get()->getUnsigned() ? "<select name='" . h($key) . "[unsigned]'" . (!$type || preg_match(number_type(), $type) ? "" : " class='hidden'") . '><option>' . optionlist(Driver::get()->getUnsigned(), $field["unsigned"] ?? null) . '</select>' : '');
	echo (isset($field['on_update']) ? "<select name='" . h($key) . "[on_update]'" . (preg_match('~timestamp|datetime~', $type) ? "" : " class='hidden'") . '>' . optionlist(["" => "(" . lang('ON UPDATE') . ")", "CURRENT_TIMESTAMP"], (preg_match('~^CURRENT_TIMESTAMP~i', $field["on_update"]) ? "CURRENT_TIMESTAMP" : $field["on_update"])) . '</select>' : '');
	echo ($foreign_keys ? "<select name='" . h($key) . "[on_delete]'" . (preg_match("~`~", $type) ? "" : " class='hidden'") . "><option value=''>(" . lang('ON DELETE') . ")" . optionlist(Driver::get()->getOnActions(), $field["on_delete"] ?? null) . "</select> " : " "); // space for IE
}

/**
 * @param string $table
 * @return array
 */
function get_partitions_info($table) {
	$from = "FROM information_schema.PARTITIONS WHERE TABLE_SCHEMA = " . q(DB) . " AND TABLE_NAME = " . q($table);

	$result = Connection::get()->query("SELECT PARTITION_METHOD, PARTITION_EXPRESSION, PARTITION_ORDINAL_POSITION $from ORDER BY PARTITION_ORDINAL_POSITION DESC LIMIT 1");

	$info = [];
	list($info["partition_by"], $info["partition"],  $info["partitions"]) = $result->fetchRow();

	$partitions = get_key_vals("SELECT PARTITION_NAME, PARTITION_DESCRIPTION $from AND PARTITION_NAME != '' ORDER BY PARTITION_ORDINAL_POSITION");
	$info["partition_names"] = array_keys($partitions);
	$info["partition_values"] = array_values($partitions);

	return $info;
}

/** Filter length value including enums
* @param string
* @return string
*/
function process_length($length) {
	$enumLengthPattern = Driver::EnumLengthPattern;

	return (preg_match("~^\\s*\\(?\\s*$enumLengthPattern(?:\\s*,\\s*$enumLengthPattern)*+\\s*\\)?\\s*\$~", $length) && preg_match_all("~$enumLengthPattern~", $length, $matches)
		? "(" . implode(",", $matches[0]) . ")"
		: preg_replace('~^[0-9].*~', '(\0)', preg_replace('~[^-0-9,+()[\]]~', '', $length))
	);
}

/** Create SQL string from field type
* @param array
* @param string
* @return string
*/
function process_type($field, $collate = "COLLATE") {
	return " $field[type]"
		. process_length($field["length"])
		. (preg_match(number_type(), $field["type"]) && in_array($field["unsigned"], Driver::get()->getUnsigned()) ? " $field[unsigned]" : "")
		. (preg_match('~char|text|enum|set~', $field["type"]) && $field["collation"] ? " $collate " . (DIALECT == "mssql" ? $field["collation"] : q($field["collation"])) : "")
	;
}

/** Create SQL string from field
* @param array basic field information
* @param array information about field type
* @return array ["field", "type", "NULL", "DEFAULT", "ON UPDATE", "COMMENT", "AUTO_INCREMENT"]
*/
function process_field($field, $type_field) {
	// MariaDB exports CURRENT_TIMESTAMP as a function.
	if ($field["on_update"]) {
		$field["on_update"] = str_ireplace("current_timestamp()", "CURRENT_TIMESTAMP", $field["on_update"]);
	}
	return [
		idf_escape(trim($field["field"])),
		process_type($type_field),
		($field["null"] ? " NULL" : " NOT NULL"), // NULL for timestamp
		default_value($field),
		(preg_match('~timestamp|datetime~', $field["type"]) && $field["on_update"] ? " ON UPDATE " . $field["on_update"] : ""),
		(support("comment") && $field["comment"] != "" ? " COMMENT " . q($field["comment"]) : ""),
		($field["auto_increment"] ? auto_increment() : null),
	];
}

/** Get default value clause
* @param array
* @return string
*/
function default_value($field) {
	$default = $field["default"];
	if ($default === null) return "";

	$generated = $field["generated"];
	if (in_array($generated, Driver::get()->getGenerated())) {
		if (DIALECT == "mssql") {
			return " AS ($default)" . ($generated == "VIRTUAL" ? "" : " $generated");
		} else {
			return " GENERATED ALWAYS AS ($default) $generated";
		}
	}

	if (stripos($default, "GENERATED ") === 0) {
		return " $default";
	}

	if (preg_match('~char|binary|text|json|enum|set~', $field["type"]) || preg_match('~^(?![a-z])~i', $default)) {
		// MySQL requires () around default value of text and json column.
		if (DIALECT == "sql" && preg_match('~text|json~', $field["type"])) {
			return " DEFAULT (" . q($default) . ")";
		} else {
			return " DEFAULT " . q($default);
		}
	} else {
		// MariaDB exports CURRENT_TIMESTAMP as a function.
		$default = str_ireplace("current_timestamp()", "CURRENT_TIMESTAMP", $default);

		return " DEFAULT " . (DIALECT == "sqlite" ? "($default)" : $default);
	}
}

/** Get type class to use in CSS
* @param string
* @return string class=''
*/
function type_class($type) {
	foreach ([
		'char' => 'text',
		'date' => 'time|year',
		'binary' => 'blob',
		'enum' => 'set',
	] as $key => $val) {
		if (preg_match("~$key|$val~", $type)) {
			return " class='$key'";
		}
	}
}

/**
 * Prints table interior for fields editing.
 *
 * @param string $type TABLE, FUNCTION or PROCEDURE
 * @param array $foreign_keys returned by referencable_primary()
 */
function edit_fields(array $fields, array $collations, $type = "TABLE", $foreign_keys = []) {
	$fields = array_values($fields);
	$comment_class = ($_POST ? $_POST["comments"] : get_setting("comments")) ? "" : "class='hidden'";
	?>

<thead><tr>
	<?php
		if (support("move_col")) {
			echo "<td class='jsonly'></td>";
		}
		if ($type == "PROCEDURE") {
			echo "<td></td>";
		}
	?>
	<th id="label-name"><?php echo ($type == "TABLE" ? lang('Column name') : lang('Parameter name')); ?></th>
	<td id="label-type"><?php echo lang('Type'); ?><textarea id="enum-edit" rows="4" cols="12" wrap="off" style="display: none;"></textarea><?php echo script("gid('enum-edit').onblur = onFieldLengthBlur;"); ?></td>
	<td id="label-length"><?php echo lang('Length'); ?></td>
	<td><?php echo lang('Options'); /* no label required, options have their own label */ ?></td>
	<?php if ($type == "TABLE") { ?>
		<td id="label-null">NULL</td>
		<td><input type="radio" name="auto_increment_col" value=""><abbr id="label-ai" title="<?php echo lang('Auto Increment'); ?>">AI</abbr><?php echo doc_link([
			'sql' => "example-auto-increment.html",
			'mariadb' => "auto_increment/",
			'sqlite' => "autoinc.html",
			'pgsql' => "datatype-numeric.html#DATATYPE-SERIAL",
			'mssql' => "t-sql/statements/create-table-transact-sql-identity-property",
		]); ?>
		</td>
		<td id="label-default"><?php echo lang('Default value'); ?></td>
		<?php echo (support("comment") ? "<td id='label-comment' $comment_class>" . lang('Comment') . "</td>" : ""); ?>
	<?php } ?>
	<td><?php
		echo "<button name='add[" . (support("move_col") ? 0 : count($fields)) . "]' value='1' title='" . h(lang('Add next')) . "' class='button light'>", icon_solo("add"), "</button>",
			script("row_count = " . count($fields) . ";");
	?></td>
</tr></thead>
<?php
	$class = support("move_col") ? "class='sortable'" : "";
	echo "<tbody $class>\n";

	foreach ($fields as $i => $field) {
		$i++;
		$orig = $field[($_POST ? "orig" : "field")];
		$display = (isset($_POST["add"][$i-1]) || (isset($field["field"]) && !($_POST["drop_col"][$i] ?? null))) && (support("drop_col") || $orig == "");

		$style = $display ? "" : "style='display: none;'";
		echo "<tr $style>\n";

		if (support("move_col")) {
			echo "<td class='handle jsonly'>", icon_solo("handle"), "</td>";
		}
		if ($type == "PROCEDURE") {
			echo "<td>", html_select("fields[$i][inout]", Driver::get()->getInOut(), $field["inout"]), "</td>\n";
		}

		echo "<th>";
		if ($display) {
			echo "<input class='input' name='fields[$i][field]' value='", h($field["field"]), "' data-maxlength='64' autocapitalize='off' aria-labelledby='label-name'>";
		}
		echo "<input type='hidden' name='fields[$i][orig]' value='",  h($orig), "'>";
		edit_type("fields[$i]", $field, $collations, $foreign_keys);
		echo "</th>\n";

		if ($type == "TABLE") {
			echo "<td>", checkbox("fields[$i][null]", 1, $field["null"], "", "", "block", "label-null"), "</td>\n";

			$checked = $field["auto_increment"] ? "checked" : "";
			echo "<td><label class='block'><input type='radio' name='auto_increment_col' value='$i' $checked aria-labelledby='label-ai'></label></td>\n";

			echo "<td class='default-value'>";
			if (Driver::get()->getGenerated()) {
				echo html_select("fields[$i][generated]", array_merge(["", "DEFAULT"], Driver::get()->getGenerated()), $field["generated"]);
			} else {
				echo checkbox("fields[$i][generated]", 1, $field["generated"], "", "", "", "label-default");
			}
			echo "<input class='input' name='fields[$i][default]' value='", h($field["default"]), "' aria-labelledby='label-default'>";
			echo "</td>\n";

			if (support("comment")) {
				$max_length = Connection::get()->isMinVersion("5.5") ? 1024 : 255;
				echo "<td $comment_class>",
					"<input class='input' name='fields[$i][comment]' value='", h($field["comment"]), "' data-maxlength='$max_length' aria-labelledby='label-comment'>",
					"</td>\n";
			}
		}

		echo "<td>";
		if (support("move_col")) {
			echo "<button name='add[$i]' value='1' title='" . h(lang('Add next')) . "' class='button light'>", icon_solo("add"), "</button>",
				"<button name='up[$i]' value='1' title='" . h(lang('Move up')) . "' class='button light hidden'>", icon_solo("arrow-up"), "</button>",
				"<button name='down[$i]' value='1' title='" . h(lang('Move down')) . "' class='button light hidden'>", icon_solo("arrow-down"), "</button>";
		}
		if ($orig == "" || support("drop_col")) {
			echo "<button name='drop_col[$i]' value='1' title='" . h(lang('Remove')) . "' class='button light'>", icon_solo("remove"), "</button>";
		}
		echo "</td>\n</tr>\n";
	}

	echo "</tbody>";
}

/** Move fields up and down or add field
* @param array
* @return bool
*/
function process_fields(&$fields) {
	$offset = 0;
	if ($_POST["up"]) {
		$last = 0;
		foreach ($fields as $key => $field) {
			if (key($_POST["up"]) == $key) {
				unset($fields[$key]);
				array_splice($fields, $last, 0, [$field]);
				break;
			}
			if (isset($field["field"])) {
				$last = $offset;
			}
			$offset++;
		}
	} elseif ($_POST["down"]) {
		$found = false;
		foreach ($fields as $key => $field) {
			if (isset($field["field"]) && $found) {
				unset($fields[key($_POST["down"])]);
				array_splice($fields, $offset, 0, [$found]);
				break;
			}
			if (key($_POST["down"]) == $key) {
				$found = $field;
			}
			$offset++;
		}
	} elseif ($_POST["add"]) {
		$fields = array_values($fields);
		array_splice($fields, key($_POST["add"]), 0, [[]]);
	} elseif (!$_POST["drop_col"]) {
		return false;
	}
	return true;
}

/** Callback used in routine()
* @param array
* @return string
*/
function normalize_enum($match) {
	return "'" . str_replace("'", "''", addcslashes(stripcslashes(str_replace($match[0][0] . $match[0][0], $match[0][0], substr($match[0], 1, -1))), '\\')) . "'";
}

/**
 * Issue grant or revoke commands.
 *
 * @param bool $grant
 * @param array $privileges
 * @param string $columns
 * @param string $on
 * @param string $user
 *
 * @return bool
 */
function grant($grant, array $privileges, $columns, $on, $user) {
	if (!$privileges) return true;

	if ($privileges == ["ALL PRIVILEGES", "GRANT OPTION"]) {
		if ($grant) {
			return (bool) queries("GRANT ALL PRIVILEGES ON $on TO $user WITH GRANT OPTION");
		} else {
			return queries("REVOKE ALL PRIVILEGES ON $on FROM $user") &&
				queries("REVOKE GRANT OPTION ON $on FROM $user");
		}
	}

	if ($privileges == ["GRANT OPTION", "PROXY"]) {
		if ($grant) {
			return (bool) queries("GRANT PROXY ON $on TO $user WITH GRANT OPTION");
		} else {
			return (bool) queries("REVOKE PROXY ON $on FROM $user");
		}
	}

	return (bool) queries(
		($grant ? "GRANT " : "REVOKE ") .
		preg_replace('~(GRANT OPTION)\([^)]*\)~', '$1', implode("$columns, ", $privileges) . $columns) .
		" ON $on " .
		($grant ? "TO " : "FROM ") . $user
	);
}

/** Drop old object and create a new one
* @param string drop old object query
* @param string create new object query
* @param string drop new object query
* @param string create test object query
* @param string drop test object query
* @param string
* @param string
* @param string
* @param string
* @param string
* @param string
* @return null redirect in success
*/
function drop_create($drop, $create, $drop_created, $test, $drop_test, $location, $message_drop, $message_alter, $message_create, $old_name, $new_name) {
	if ($_POST["drop"]) {
		query_redirect($drop, $location, $message_drop);
	} elseif ($old_name == "") {
		query_redirect($create, $location, $message_create);
	} elseif ($old_name != $new_name) {
		$created = queries($create);
		queries_redirect($location, $message_alter, $created && queries($drop));
		if ($created) {
			queries($drop_created);
		}
	} else {
		queries_redirect(
			$location,
			$message_alter,
			queries($test) && queries($drop_test) && queries($drop) && queries($create)
		);
	}
}

/** Generate SQL query for creating trigger
* @param string
* @param array result of trigger()
* @return string
*/
function create_trigger($on, $row) {
	$timing_event = " $row[Timing] $row[Event]" . (preg_match('~ OF~', $row["Event"]) ? " $row[Of]" : ""); // SQL injection
	return "CREATE TRIGGER "
		. idf_escape($row["Trigger"])
		. (DIALECT == "mssql" ? $on . $timing_event : $timing_event . $on)
		. rtrim(" $row[Type]\n$row[Statement]", ";")
		. ";"
	;
}

/** Generate SQL query for creating routine
* @param string "PROCEDURE" or "FUNCTION"
* @param array result of routine()
* @return string
*/
function create_routine($routine, $row) {
	$set = [];
	$fields = (array) $row["fields"];
	ksort($fields); // enforce fields order
	$inOut = implode("|", Driver::get()->getInOut());
	foreach ($fields as $field) {
		if ($field["field"] != "") {
			$set[] = (preg_match("~^($inOut)\$~", $field["inout"]) ? "$field[inout] " : "") . idf_escape($field["field"]) . process_type($field, "CHARACTER SET");
		}
	}
	$definition = rtrim($row["definition"], ";");
	return "CREATE $routine "
		. idf_escape(trim($row["name"]))
		. " (" . implode(", ", $set) . ")"
		. ($routine == "FUNCTION" ? " RETURNS" . process_type($row["returns"], "CHARACTER SET") : "")
		. ($row["language"] ? " LANGUAGE $row[language]" : "")
		. (DIALECT == "pgsql" ? " AS " . q($definition) : "\n$definition;")
	;
}

/** Remove current user definer from SQL command
* @param string
* @return string
*/
function remove_definer($query) {
	return preg_replace('~^([A-Z =]+) DEFINER=`' . preg_replace('~@(.*)~', '`@`(%|\1)', logged_user()) . '`~', '\1', $query); //! proper escaping of user
}

/** Format foreign key to use in SQL query
* @param array ["db" => string, "ns" => string, "table" => string, "source" => array, "target" => array, "on_delete" => one of Driver::$onActions, "on_update" => one of $on_actions]
* @return string
*/
function format_foreign_key($foreign_key) {
	$onActions = implode("|", Driver::get()->getOnActions());

	$db = $foreign_key["db"];
	$ns = $foreign_key["ns"];
	return " FOREIGN KEY (" . implode(", ", array_map('AdminNeo\idf_escape', $foreign_key["source"])) . ") REFERENCES "
		. ($db != "" && $db != $_GET["db"] ? idf_escape($db) . "." : "")
		. ($ns != "" && $ns != $_GET["ns"] ? idf_escape($ns) . "." : "")
		. idf_escape($foreign_key["table"])
		. " (" . implode(", ", array_map('AdminNeo\idf_escape', $foreign_key["target"])) . ")" //! reuse $name - check in older MySQL versions
		. (preg_match("~^($onActions)\$~", $foreign_key["on_delete"]) ? " ON DELETE $foreign_key[on_delete]" : "")
		. (preg_match("~^($onActions)\$~", $foreign_key["on_update"]) ? " ON UPDATE $foreign_key[on_update]" : "")
	;
}

/** Add a file to TAR
* @param string
* @param TmpFile
* @return null prints the output
*/
function tar_file($filename, $tmp_file) {
	$return = pack("a100a8a8a8a12a12", $filename, 644, 0, 0, decoct($tmp_file->size), decoct(time()));
	$checksum = 8*32; // space for checksum itself
	for ($i=0; $i < strlen($return); $i++) {
		$checksum += ord($return[$i]);
	}
	$return .= sprintf("%06o", $checksum) . "\0 ";
	echo $return;
	echo str_repeat("\0", 512 - strlen($return));
	$tmp_file->send();
	echo str_repeat("\0", 511 - ($tmp_file->size + 511) % 512);
}

/** Get INI bytes value
* @param string
* @return int
*/
function ini_bytes($ini) {
	$val = ini_get($ini);
	switch (strtolower(substr($val, -1))) {
		case 'g': $val = (int)$val * 1024; // no break
		case 'm': $val = (int)$val * 1024; // no break
		case 'k': $val = (int)$val * 1024;
	}
	return $val;
}

/**
 * Creates link to database documentation.
 *
 * @param ?string[] $paths $jush => $path
 * @param string $text HTML code.
 *
 * @return string HTML code.
 */
function doc_link(array $paths, string $text = "<sup>?</sup>"): string
{
	if (!($paths[DIALECT] ?? null)) {
		return "";
	}

	$version = preg_replace('~^(\d\.?\d).*~s', '\1', Connection::get()->getVersion()); // two most significant digits

	$urls = [
		'sql' => "https://dev.mysql.com/doc/refman/$version/en/",
		'sqlite' => "https://www.sqlite.org/",
		'pgsql' => "https://www.postgresql.org/docs/$version/",
		'mssql' => "https://learn.microsoft.com/en-us/sql/",
		'oracle' => "https://www.oracle.com/pls/topic/lookup?ctx=db" . str_replace(".", "", $version) . "&id=",
		'elastic' => "https://www.elastic.co/guide/en/elasticsearch/reference/$version/",
	];

	if (Connection::get()->isMariaDB()) {
		$urls['sql'] = "https://mariadb.com/kb/en/";
		$paths['sql'] = $paths['mariadb'] ?? str_replace(".html", "/", $paths['sql']);
	}

	return "<a href='" . h($urls[DIALECT] . $paths[DIALECT] . (DIALECT == 'mssql' ? "?view=sql-server-ver$version" : "")) . "'" . target_blank() . ">$text</a>";
}

/** Compute size of database
* @param string
* @return string formatted
*/
function db_size($db) {
	if (!Connection::get()->selectDatabase($db)) {
		return "?";
	}
	$return = 0;
	foreach (table_status() as $table_status) {
		$return += $table_status["Data_length"] + $table_status["Index_length"];
	}
	return format_number($return);
}

/** Print SET NAMES if utf8mb4 might be needed
* @param string
* @return null
*/
function set_utf8mb4($create) {
	static $set = false;
	if (!$set && preg_match('~\butf8mb4~i', $create)) { // possible false positive
		$set = true;
		echo "SET NAMES " . charset(Connection::get()) . ";\n\n";
	}
}
