<?php

namespace AdminNeo;

$EVENT = $_GET["event"];
$intervals = ["YEAR", "QUARTER", "MONTH", "DAY", "HOUR", "MINUTE", "WEEK", "SECOND", "YEAR_MONTH", "DAY_HOUR", "DAY_MINUTE", "DAY_SECOND", "HOUR_MINUTE", "HOUR_SECOND", "MINUTE_SECOND"];
$statuses = ["ENABLED" => "ENABLE", "DISABLED" => "DISABLE", "SLAVESIDE_DISABLED" => "DISABLE ON SLAVE"];
$row = $_POST;

if ($_POST) {
	if ($_POST["drop"]) {
		query_redirect("DROP EVENT " . idf_escape($EVENT), substr(ME, 0, -1), lang('Event has been dropped.'));
	} elseif (in_array($row["INTERVAL_FIELD"], $intervals) && isset($statuses[$row["STATUS"]])) {
		$schedule = "\nON SCHEDULE " . ($row["INTERVAL_VALUE"]
			? "EVERY " . q($row["INTERVAL_VALUE"]) . " $row[INTERVAL_FIELD]"
			. ($row["STARTS"] ? " STARTS " . q($row["STARTS"]) : "")
			. ($row["ENDS"] ? " ENDS " . q($row["ENDS"]) : "") //! ALTER EVENT doesn't drop ENDS - MySQL bug #39173
			: "AT " . q($row["STARTS"])
			) . " ON COMPLETION" . ($row["ON_COMPLETION"] ? "" : " NOT") . " PRESERVE"
		;

		queries_redirect(substr(ME, 0, -1), ($EVENT != "" ? lang('Event has been altered.') : lang('Event has been created.')), queries(($EVENT != ""
			? "ALTER EVENT " . idf_escape($EVENT) . $schedule
			. ($EVENT != $row["EVENT_NAME"] ? "\nRENAME TO " . idf_escape($row["EVENT_NAME"]) : "")
			: "CREATE EVENT " . idf_escape($row["EVENT_NAME"]) . $schedule
			) . "\n" . $statuses[$row["STATUS"]] . " COMMENT " . q($row["EVENT_COMMENT"])
			. rtrim(" DO\n$row[EVENT_DEFINITION]", ";") . ";"
		));
	}
}

if ($EVENT != "") {
	page_header(lang('Alter event') . ": " . h($EVENT), [lang('Alter event')]);
} else {
	page_header(lang('Create event'), [lang('Create event')]);
}

if (!$row && $EVENT != "") {
	$rows = get_rows("SELECT * FROM information_schema.EVENTS WHERE EVENT_SCHEMA = " . q(DB) . " AND EVENT_NAME = " . q($EVENT));
	$row = reset($rows);
}

echo "<form action='' method='post'>\n";
echo "<table class='box box-light'>\n";

echo "<tr><th>", lang('Name'), "</th><td>";
echo "<input class='input' name='EVENT_NAME' value='", h($row["EVENT_NAME"]), "' data-maxlength='64' autocapitalize='off'>";
echo "</td></tr>\n";

echo "<tr><th title='datetime'>", lang('Start'), "</th><td>";
echo "<input class='input' name='STARTS' value='", h("$row[EXECUTE_AT]$row[STARTS]"), "'>";
echo "</td></tr>\n";

echo "<tr><th title='datetime'>", lang('End'), "</th><td>";
echo "<input class='input' name='ENDS' value='", h($row["ENDS"]), "'>";
echo "</td></tr>\n";

echo "<tr><th>", lang('Every'), "</th><td>";
echo "<input type='number' name='INTERVAL_VALUE' value='", h($row["INTERVAL_VALUE"]), "' class='input size'> ";
echo html_select("INTERVAL_FIELD", $intervals, $row["INTERVAL_FIELD"]);
echo "</td></tr>\n";

echo "<tr><th>", lang('Status'), "</th><td>";
echo html_select("STATUS", $statuses, $row["STATUS"]);
echo "</td></tr>\n";

echo "<tr><th>", lang('Comment'), "</th><td>";
echo "<input class='input' name='EVENT_COMMENT' value='", h($row["EVENT_COMMENT"]), "' data-maxlength='64'>";
echo "</td></tr>\n";

echo "<tr><th></th><td>";
echo checkbox("ON_COMPLETION", "PRESERVE", $row["ON_COMPLETION"] == "PRESERVE", lang('On completion preserve'));
echo "</td></tr>\n";

echo "</table>\n";

echo "<p>";
textarea("EVENT_DEFINITION", $row["EVENT_DEFINITION"]);
echo "</p>\n";

echo "<p>";
echo "<input type='submit' class='button default' value='", lang('Save'), "'>";
if ($EVENT != "") {
	echo "<input type='submit' class='button' name='drop' value='", lang('Drop'), "'>";
	echo confirm(lang('Drop %s?', $EVENT));
}
echo "</p>\n";

echo input_token();
echo "</form>\n";
