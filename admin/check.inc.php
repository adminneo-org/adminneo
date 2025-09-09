<?php

namespace AdminNeo;

$TABLE = $_GET["check"];
$name = $_GET["name"];
$row = $_POST;

if ($row) {
	if (DIALECT == "sqlite") {
		$result = recreate_table($TABLE, $TABLE, [], [], [], 0, [], $name, ($row["drop"] ? "" : $row["clause"]));
	} else {
		$result = ($name == "" || queries("ALTER TABLE " . table($TABLE) . " DROP CONSTRAINT " . idf_escape($name)));
		if (!$row["drop"]) {
			$result = queries("ALTER TABLE " . table($TABLE) . " ADD" . ($row["name"] != "" ? " CONSTRAINT " . idf_escape($row["name"]) : "") . " CHECK ($row[clause])"); //! SQL injection
		}
	}
	queries_redirect(
		ME . "table=" . urlencode($TABLE),
		($row["drop"] ? lang('Check has been dropped.') : ($name != "" ? lang('Check has been altered.') : lang('Check has been created.'))),
		$result
	);
}

page_header(($name != "" ? lang('Alter check') . ": " . h($name) : lang('Create check')), ["table" => $TABLE]);

if (!$row) {
	$checks = Driver::get()->checkConstraints($TABLE);
	$row = ["name" => $name, "clause" => $checks[$name]];
}

echo "<form action='' method='post'>\n";
echo "<p>";

if (DIALECT != "sqlite") {
	echo lang('Name') . ': <input name="name" value="' . h($row["name"]) . '" class="input" data-maxlength="64" autocapitalize="off"> ';
}
echo doc_link([
	'sql' => "create-table-check-constraints.html",
	'mariadb' => "constraint/",
	'pgsql' => "ddl-constraints.html#DDL-CONSTRAINTS-CHECK-CONSTRAINTS",
	'mssql' => "relational-databases/tables/create-check-constraints",
	'sqlite' => "lang_createtable.html#check_constraints",
], "?");

echo "</p>\n<p>";
textarea("clause", $row["clause"]);

echo "</p>\n<p>";
echo "<input type='submit' class='button default' value='", lang('Save'), "'>";
if ($name != "") {
	echo "<input type='submit' class='button' name='drop' value='", lang('Drop'), "'>";
	echo confirm(lang('Drop %s?', $name));
}
echo input_token();
echo "</p>\n";

echo "</form>\n";
