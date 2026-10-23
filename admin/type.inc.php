<?php

namespace AdminNeo;

$TYPE = $_GET["type"];
$row = $_POST;

$type = ($TYPE != "" ? type_definition((int)Driver::get()->getUserTypeId($TYPE)) : ["kind" => "", "definition" => ""]);
$object = ($type["kind"] == 'd' ? "DOMAIN" : "TYPE"); // domains are created, altered and dropped as DOMAIN

if ($_POST) {
	$link = substr(ME, 0, -1);
	$name = trim($row["name"]);
	$as = trim($row["as"]);
	// CREATE TYPE accepts AS ENUM (...), AS RANGE (...), AS (...) and (INPUT = ...), anything else after AS is a base type of a domain
	$new_object = (preg_match('~^AS\s+(?!ENUM\b|RANGE\b|\()~i', $as) ? "DOMAIN" : "TYPE");
	$message = lang('Type has been altered.');

	if (!$_POST["drop"] && $TYPE != "" && $as == $type["definition"] && $new_object == $object) {
		if ($TYPE == $name) {
			redirect($link);
		}
		query_redirect("ALTER $object " . idf_escape($TYPE) . " RENAME TO " . idf_escape($name), $link, $message);
	} else {
		// There's no CREATE OR REPLACE TYPE, drop_create() verifies the new definition before dropping the original type.
		$temp_name = $name . "_adminer_" . uniqid();
		drop_create(
			"DROP $object " . idf_escape($TYPE),
			"CREATE $new_object " . idf_escape($name) . " $as",
			"DROP $new_object " . idf_escape($name),
			"CREATE $new_object " . idf_escape($temp_name) . " $as",
			"DROP $new_object " . idf_escape($temp_name),
			$link,
			lang('Type has been dropped.'),
			$message,
			lang('Type has been created.'),
			$TYPE,
			$name
		);
	}
}

if ($TYPE != "") {
	page_header(lang('Alter type') . ": " . h($TYPE), [h($TYPE)]);
} else {
	page_header(lang('Create type'), [lang('Create type')]);
}

if (!$row) {
	$row["name"] = $TYPE;
	$row["as"] = ($TYPE != "" ? $type["definition"] : "AS ");
}

echo "<form action='' method='post'>\n";

echo "<p>";
echo lang('Name') . ": <input class='input' name='name' value='" . h($row['name']) . "' autocapitalize='off'>\n";
echo doc_link([
	'pgsql' => "sql-createtype.html",
], "?");

echo "</p>\n<p>";
textarea("as", $row["as"]);
echo "</p>\n<p>";
echo "<input type='submit' class='button default' value='", lang('Save'), "'>";
if ($TYPE != "") {
	echo "<input type='submit' class='button' name='drop' value='", lang('Drop'), "'>";
	echo confirm(lang('Drop %s?', $TYPE));
}
echo input_token();
echo "</p>\n";

echo "</form>\n";
