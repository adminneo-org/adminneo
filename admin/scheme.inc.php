<?php

namespace AdminNeo;

$row = $_POST;

if ($_POST) {
	$link = preg_replace('~ns=[^&]*&~', '', ME) . "ns=";
	if ($_POST["drop"]) {
		query_redirect("DROP SCHEMA " . idf_escape($_GET["ns"]), $link, lang('Schema has been dropped.'));
	} else {
		$name = trim($row["name"]);
		$link .= urlencode($name);
		if ($_GET["ns"] == "") {
			query_redirect("CREATE SCHEMA " . idf_escape($name), $link, lang('Schema has been created.'));
		} elseif ($_GET["ns"] != $name) {
			query_redirect("ALTER SCHEMA " . idf_escape($_GET["ns"]) . " RENAME TO " . idf_escape($name), $link, lang('Schema has been altered.')); //! sp_rename in MS SQL
		} else {
			redirect($link);
		}
	}
}

if ($_GET["ns"] != "") {
	page_header(lang('Alter schema') . ": " . h($_GET["ns"]), [lang('Alter schema')]);
} else {
	page_header(lang('Create schema'), [lang('Create schema')]);
}

if (!$row) {
	$row["name"] = $_GET["ns"];
}

echo "<form action='' method='post'>\n";

echo "<p>";
echo "<input class='input' name='name' id='name' value='", h($row["name"]), "' autocapitalize='off' autofocus>";
echo "<input type='submit' class='button default' value='", lang('Save'), "'>";
if ($_GET["ns"] != "") {
	echo "<input type='submit' class='button' name='drop' value='" . lang('Drop') . "'>" . confirm(lang('Drop %s?', $_GET["ns"])) . "\n";
}
echo input_token();
echo "</p>\n";

echo "</form>\n";
