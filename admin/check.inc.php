<?php

namespace AdminNeo;

$TABLE = $_GET["check"];
$name = $_GET["name"];
$row = $_POST;

if ($row) {
	if (DIALECT == "sqlite") {
		$success = recreate_table($TABLE, $TABLE, [], [], [], "", [], "$name", ($row["drop"] ? "" : $row["clause"]));
	} else {
		$success = ($name == "" || queries("ALTER TABLE " . table($TABLE) . " DROP CONSTRAINT " . idf_escape($name)));
		if (!$row["drop"]) {
			$success = (bool)queries("ALTER TABLE " . table($TABLE) . " ADD" . ($row["name"] != "" ? " CONSTRAINT " . idf_escape($row["name"]) : "") . " CHECK ($row[clause])"); //! SQL injection
		}
	}
	queries_redirect(
		ME . "table=" . urlencode($TABLE),
		($row["drop"] ? lang('Check has been dropped.') : ($name != "" ? lang('Check has been altered.') : lang('Check has been created.'))),
		$success
	);
}

if ($name != "") {
	page_header(lang('Alter check') . ": " . h($name), ["table" => $TABLE, lang('Alter check')]);
} else {
	page_header(lang('Create check') . ": " . h($TABLE), ["table" => $TABLE, lang('Create check')]);
}

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
	'mariadb' => "reference/sql-statements/data-definition/constraint",
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
