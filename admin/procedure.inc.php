<?php

namespace AdminNeo;

$PROCEDURE = ($_GET["name"] ?: $_GET["procedure"]);
$routine = (isset($_GET["function"]) ? "FUNCTION" : "PROCEDURE");
$row = $_POST;
$row["fields"] = (array) $row["fields"];

if ($_POST && !process_fields($row["fields"])) {
	foreach ($row["fields"] as $key => $field) {
		if ($field["field"] == "") {
			unset($row["fields"][$key]);
		}
	}

	$old_id = routine_id($PROCEDURE, routine($_GET["procedure"], $routine));
	$new_id = routine_id($row["name"], $row);
	$create = create_routine($routine, $row);
	$location = substr(ME, 0, -1);
	$message = lang('Routine has been altered.');

	if (!$_POST["drop"] && $old_id == $new_id && (DIALECT != "sql" || Connection::get()->isMariaDB())) {
		query_redirect(substr_replace($create, ' OR REPLACE', 6, 0), $location, $message); // 6 - strlen('CREATE')
	} else {
		$temp_name = "$row[name]_adminer_" . uniqid();
		drop_create(
			"DROP $routine $old_id",
			$create,
			"DROP $routine $new_id",
			create_routine($routine, ["name" => $temp_name] + $row),
			"DROP $routine " . routine_id($temp_name, $row),
			$location,
			lang('Routine has been dropped.'),
			$message,
			lang('Routine has been created.'),
			$PROCEDURE,
			$row["name"]
		);
	}
}

if ($PROCEDURE != "") {
	$title = isset($_GET["function"]) ? lang('Alter function') : lang('Alter procedure');
	page_header($title . ": " . h($PROCEDURE), [$title]);
} else {
	$title = isset($_GET["function"]) ? lang('Create function') : lang('Create procedure');
	page_header($title, [$title]);
}

if (!$_POST) {
	if ($PROCEDURE == "") {
		$row["language"] = "sql";
	} else {
		$row = routine($_GET["procedure"], $routine);
		$row["name"] = $PROCEDURE;
	}
}

$charsets = get_vals("SHOW CHARACTER SET");
sort($charsets);
$routine_languages = routine_languages();

echo "<form action='' method='post' id='form'>\n";
echo "<p>", lang('Name'), ": ";
echo "<input class='input' name='name' value='", h($row["name"]), "' data-maxlength='64' autocapitalize='off'>";
if ($routine_languages) {
	echo "<span id='label-language'>" , lang('Language'), ":</span> ", html_select("language", $routine_languages, $row["language"], "", "label-language");
}
echo "<input type='submit' class='button default' value='", lang('Save'), "'>";
echo "</p>\n";

echo "<div class='scrollable'>\n";
echo "<table class='nowrap' id='edit-fields'>\n";

edit_fields($row["fields"], $charsets, $routine);
if (isset($_GET["function"])) {
	echo "<tbody><tr>";
	if (support("move_col")) {
		echo "<th></th>";
	}
	echo "<th>", lang('Return type'), "</th>";

	edit_type("returns", (array) $row["returns"], $charsets, [], (DIALECT == "pgsql" ? ["void", "trigger"] : []));

	echo "<td></td>";
	echo "</tr></tbody>\n";
}

echo "</table>\n";

echo script("initFieldsEditing(gid('edit-fields'));");
if (support("move_col")) {
	echo script("initSortable('#edit-fields tbody');");
}

echo "</div>\n";

echo "<p>";
textarea("definition", $row["definition"], 20);

echo "</p>\n<p>";
echo "<input type='submit' class='button default' value='", lang('Save'), "'>";

if ($PROCEDURE != "") {
	echo "<input type='submit' class='button' name='drop' value='", lang('Drop'), "'>";
	echo confirm(lang('Drop %s?', $PROCEDURE));
}

echo input_token();
echo "</p>\n";

echo "</form>\n";
