<?php

namespace AdminNeo;

$TYPE = $_GET["type"];
$row = $_POST;

if ($_POST) {
	$link = substr(ME, 0, -1);
	if ($_POST["drop"]) {
		query_redirect("DROP TYPE " . idf_escape($TYPE), $link, lang('Type has been dropped.'));
	} else {
		query_redirect("CREATE TYPE " . idf_escape(trim($row["name"])) . " $row[as]", $link, lang('Type has been created.'));
	}
}

if ($TYPE != "") {
	page_header(lang('Alter type') . ": " . h($TYPE), [h($TYPE)]);
} else {
	page_header(lang('Create type'), [lang('Create type')]);
}

if (!$row) {
	$row["as"] = "AS ";
}
?>

<form action="" method="post">
<p>
<?php
if ($TYPE != "") {
	$types = Driver::get()->getTypes();
	$enums = type_values($types[$TYPE]);
	if ($enums) {
		echo "<code class='jush-" . DIALECT. "'>ENUM (" . h($enums) . ")</code>\n<p>";
	}
	echo "<input type='submit' class='button' name='drop' value='" . lang('Drop') . "'>" . confirm(lang('Drop %s?', $TYPE)) . "\n";
} else {
	echo lang('Name') . ": <input class='input' name='name' value='" . h($row['name']) . "' autocapitalize='off'>\n";
	echo doc_link([
		'pgsql' => "datatype-enum.html",
	], "?");
	textarea("as", $row["as"]);
	echo "<p><input type='submit' class='button default' value='" . lang('Save') . "'></p>\n";
}

echo input_token();
?>
</form>
