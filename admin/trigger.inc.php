<?php

namespace AdminNeo;

$TABLE = $_GET["trigger"];
$name = $_GET["name"];
$trigger_options = trigger_options();
$row = (array) trigger($name, $TABLE) + ["Trigger" => $TABLE . "_bi"];

if ($_POST) {
	if (in_array($_POST["Timing"], $trigger_options["Timing"]) && in_array($_POST["Event"], $trigger_options["Event"]) && in_array($_POST["Type"], $trigger_options["Type"])) {
		// don't use drop_create() because there may not be more triggers for the same action
		$on = " ON " . table($TABLE);
		$drop = "DROP TRIGGER " . idf_escape($name) . (DIALECT == "pgsql" ? $on : "");
		$location = ME . "table=" . urlencode($TABLE);
		if ($_POST["drop"]) {
			query_redirect($drop, $location, lang('Trigger has been dropped.'));
		} else {
			if ($name != "") {
				queries($drop);
			}
			queries_redirect(
				$location,
				($name != "" ? lang('Trigger has been altered.') : lang('Trigger has been created.')),
				queries(create_trigger($on, $_POST))
			);
			if ($name != "") {
				queries(create_trigger($on, $row + ["Type" => reset($trigger_options["Type"])]));
			}
		}
	}
	$row = $_POST;
}

if ($name != "") {
	page_header(lang('Alter trigger') . ": " . h($name), ["table" => $TABLE, h($name)]);
} else {
	page_header(lang('Create trigger'), ["table" => $TABLE, lang('Create trigger')]);
}

echo "<form action='' method='post' id='form'>\n";
echo "<table class='box box-light'>\n";

echo "<tr><th>", lang('Time'), "</th><td>";
echo html_select("Timing", $trigger_options["Timing"], $row["Timing"], "triggerChange(/^" . preg_quote($TABLE, "/") . "_[ba][iud]$/, '" . js_escape($TABLE) . "', this.form);");
echo "</td></tr>\n";

echo "<tr><th>", lang('Event'), "</th><td>";
echo html_select("Event", $trigger_options["Event"], $row["Event"], "this.form['Timing'].onchange();");
if (in_array("UPDATE OF", $trigger_options["Event"])) {
	echo " <input name='Of' value='" . h($row["Of"]) . "' class='input hidden'>";
}
echo "</td></tr>\n";

echo "<tr><th>", lang('Type'), "</th><td>";
echo html_select("Type", $trigger_options["Type"], $row["Type"]);
echo "</td></tr>\n";

echo "</table>\n";

echo "<p>", lang('Name');
echo "<input class='input' name='Trigger' value='", h($row["Trigger"]), "' data-maxlength='64' autocapitalize='off'>";
echo "</p>\n";
echo script("gid('form')['Timing'].onchange();");

echo "<p>";
textarea("Statement", $row["Statement"]);
echo "</p>\n";

echo "<p>";
echo "<input type='submit' class='button default' value='", lang('Save'), "'>";
if ($name != "") {
	echo "<input type='submit' class='button' name='drop' value='", lang('Drop'), "'>";
	echo confirm(lang('Drop %s?', $name));
}
echo "</p>\n";

echo input_token();
echo "</form>\n";
