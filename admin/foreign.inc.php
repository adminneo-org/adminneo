<?php

namespace AdminNeo;

$TABLE = $_GET["foreign"];
$name = $_GET["name"];
$row = $_POST;

if ($_POST && !$_POST["add"] && !$_POST["change"] && !$_POST["change-js"]) {
	if (!$_POST["drop"]) {
		$row["source"] = array_filter($row["source"], 'strlen');
		ksort($row["source"]); // enforce input order
		$target = [];
		foreach ($row["source"] as $key => $val) {
			$target[$key] = $row["target"][$key];
		}
		$row["target"] = $target;
	}

	if (DIALECT == "sqlite") {
		$result = recreate_table($TABLE, $TABLE, [], [], [" $name" => ($row["drop"] ? "" : " " . format_foreign_key($row))]);
	} else {
		$alter = "ALTER TABLE " . table($TABLE);
		$result = ($name == "" || queries("$alter DROP " . (DIALECT == "sql" ? "FOREIGN KEY " : "CONSTRAINT ") . idf_escape($name)));
		if (!$row["drop"]) {
			$result = queries("$alter ADD" . format_foreign_key($row));
		}
	}
	queries_redirect(
		ME . "table=" . urlencode($TABLE),
		($row["drop"] ? lang('Foreign key has been dropped.') : ($name != "" ? lang('Foreign key has been altered.') : lang('Foreign key has been created.'))),
		$result
	);
	if (!$row["drop"]) {
		Admin::get()->addError(lang('Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.')); //! no partitioning
	}
}

page_header(lang('Foreign key') . ": " . h($TABLE), ["table" => $TABLE, lang('Foreign key')]);

if ($_POST) {
	ksort($row["source"]);
	if ($_POST["add"]) {
		$row["source"][] = "";
	} elseif ($_POST["change"] || $_POST["change-js"]) {
		$row["target"] = [];
	}
} elseif ($name != "") {
	$foreign_keys = foreign_keys($TABLE);
	$row = $foreign_keys[$name];
	$row["source"][] = "";
} else {
	$row["table"] = $TABLE;
	$row["source"] = [""];
}

echo "<form action='' method='post'>\n";

$source = array_keys(fields($TABLE)); //! no text and blob
if ($row["db"] != "") {
	Connection::get()->selectDatabase($row["db"]);
}
if ($row["ns"] != "") {
	$orig_schema = get_schema();
	set_schema($row["ns"]);
}
$referencable = array_keys(array_filter(table_status('', true), 'AdminNeo\fk_support'));
$target = array_keys(fields(in_array($row["table"], $referencable) ? $row["table"] : reset($referencable)));
$onchange = "this.form['change-js'].value = '1'; this.form.submit();";

echo "<p>";
echo lang('Target table'), ": ", html_select("table", $referencable, $row["table"], $onchange);

if (support("scheme")) {
	$schemas = array_filter(Admin::get()->getSchemas(), function ($schema) {
		return !preg_match('~^information_schema$~i', $schema);
	});
	echo lang('Schema'), ": ", html_select("ns", $schemas, $row["ns"] != "" ? $row["ns"] : $_GET["ns"], $onchange);
	if ($row["ns"] != "") {
		set_schema($orig_schema);
	}
} elseif (DIALECT != "sqlite") {
	$dbs = [];
	foreach (Admin::get()->getDatabases() as $db) {
		if (!information_schema($db)) {
			$dbs[] = $db;
		}
	}
	echo lang('DB'), ": ", html_select("db", $dbs, $row["db"] != "" ? $row["db"] : $_GET["db"], $onchange);
}

echo input_hidden("change-js");
echo "<noscript><input type='submit' class='button' name='change' value='", lang('Change'), "'></noscript>";
echo "</p>\n";

echo "<table>";
echo "<thead><tr><th id='label-source'>", lang('Source'), "<th id='label-target'>", lang('Target'), "</thead>\n";

$j = 0;
foreach ($row["source"] as $key => $val) {
	echo "<tr>";
	echo "<td>" . html_select("source[" . (+$key) . "]", [-1 => ""] + $source, $val, ($j == count($row["source"]) - 1 ? "foreignAddRow.call(this);" : ""), "label-source");
	echo "<td>" . html_select("target[" . (+$key) . "]", $target, $row["target"][$key] ?? null, "", "label-target");
	$j++;
}

echo "</table>\n";
echo "<noscript><p><input type='submit' class='button' name='add' value='", lang('Add column'), "'></p></noscript>";

echo "<p>\n";
echo lang('ON DELETE'), ": ", html_select("on_delete", [-1 => ""] + Driver::get()->getOnActions(), $row["on_delete"]);
echo lang('ON UPDATE'), ": ", html_select("on_update", [-1 => ""] + Driver::get()->getOnActions(), $row["on_update"]);
echo doc_link([
	'sql' => "innodb-foreign-key-constraints.html",
	'mariadb' => "foreign-keys/",
	'pgsql' => "sql-createtable.html#SQL-CREATETABLE-REFERENCES",
	'mssql' => "t-sql/statements/create-table-transact-sql",
	'oracle' => "SQLRF01111",
]);

echo "</p>\n<p>";
echo "<input type='submit' class='button default' value='", lang('Save'), "'>";

if ($name != "") {
	echo "<input type='submit' class='button' name='drop' value='", lang('Drop'), "'>";
	echo confirm(lang('Drop %s?', $name));
}

echo input_token();
echo "</p>\n";

echo "</form>\n";
