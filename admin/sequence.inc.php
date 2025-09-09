<?php

namespace AdminNeo;

$SEQUENCE = $_GET["sequence"];
$row = $_POST;

if ($_POST) {
	$link = substr(ME, 0, -1);
	$name = trim($row["name"]);
	if ($_POST["drop"]) {
		query_redirect("DROP SEQUENCE " . idf_escape($SEQUENCE), $link, lang('Sequence has been dropped.'));
	} elseif ($SEQUENCE == "") {
		query_redirect("CREATE SEQUENCE " . idf_escape($name), $link, lang('Sequence has been created.'));
	} elseif ($SEQUENCE != $name) {
		query_redirect("ALTER SEQUENCE " . idf_escape($SEQUENCE) . " RENAME TO " . idf_escape($name), $link, lang('Sequence has been altered.'));
	} else {
		redirect($link);
	}
}

if ($SEQUENCE != "") {
	page_header(lang('Alter sequence') . ": " . h($SEQUENCE), [h($SEQUENCE)]);
} else {
	page_header(lang('Create sequence'), [lang('Create type')]);
}

if (!$row) {
	$row["name"] = $SEQUENCE;
}

echo "<form action='' method='post'>\n";

echo "<p>";
echo "<input class='input' name='name' value='", h($row["name"]), "' autocapitalize='off'>";
echo "<input type='submit' class='button default' value='", lang('Save'), "'>";
if ($SEQUENCE != "") {
	echo "<input type='submit' class='button' name='drop' value='" . lang('Drop') . "'>" . confirm(lang('Drop %s?', $SEQUENCE)) . "\n";
}
echo input_token();
echo "</p>\n";

echo "</form>\n";
