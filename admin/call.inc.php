<?php

namespace AdminNeo;

$PROCEDURE = $_GET["name"] ?: $_GET["call"];
page_header(lang('Call') . ": " . h($PROCEDURE), [lang('Call')]);

$routine = routine($_GET["call"], (isset($_GET["callf"]) ? "FUNCTION" : "PROCEDURE"));
$in = [];
$out = [];
foreach ($routine["fields"] as $i => $field) {
	if (substr($field["inout"], -3) == "OUT") {
		$out[$i] = "@" . idf_escape($field["field"]) . " AS " . idf_escape($field["field"]);
	}
	if (!$field["inout"] || substr($field["inout"], 0, 2) == "IN") {
		$in[] = $i;
	}
}

if ($_POST) {
	$call = [];
	foreach ($routine["fields"] as $key => $field) {
		if (in_array($key, $in)) {
			$val = process_input($field);
			if ($val === false) {
				$val = "''";
			}
			if (isset($out[$key])) {
				Connection::get()->query("SET @" . idf_escape($field["field"]) . " = $val");
			}
		}
		$call[] = (isset($out[$key]) ? "@" . idf_escape($field["field"]) : $val);
	}

	$query = (isset($_GET["callf"]) ? "SELECT" : "CALL") . " " . table($PROCEDURE) . "(" . implode(", ", $call) . ")";
	$start = microtime(true);
	$result = Connection::get()->multiQuery($query);
	$affected = Connection::get()->getAffectedRows(); // getting warnings overwrites this
	echo Admin::get()->formatSelectQuery($query, $start, !$result);

	if (!$result) {
		echo "<p class='error'>" . error() . "\n";
	} else {
		$connection2 = connect();
		if ($connection2) {
			$connection2->selectDatabase(DB);
		}

		do {
			$result = Connection::get()->storeResult();
			if (is_object($result)) {
				select($result, $connection2);
			} else {
				echo "<p class='message'>" . lang('Routine has been called, %d row(s) affected.', $affected)
					. " <span class='time'>" . @date("H:i:s") . "</span>\n" // @ - time zone may be not set
				;
			}
		} while (Connection::get()->nextResult());

		if ($out) {
			select(Connection::get()->query("SELECT " . implode(", ", $out)));
		}
	}
}

echo "<form action='' method='post'>\n";

if ($in) {
	echo "<table class='box'>\n";
	foreach ($in as $key) {
		$field = $routine["fields"][$key];
		$name = $field["field"];
		echo "<tr><th>" . Admin::get()->getFieldName($field);
		$value = $_POST["fields"][$name] ?? "";
		if ($value != "") {
			if ($field["type"] == "set") {
				$value = implode(",", $value);
			}
		}
		input($field, $value, (string) ($_POST["function"][$name] ?? "")); // param name can be empty
		echo "\n";
	}
	echo "</table>\n";
}

echo "<p>\n";
echo "<input type='submit' class='button' value='", lang('Call'), "'>\n";
echo input_token();
echo "</p>\n";
echo "</form>\n";

$comment = $routine["comment"];
if ($comment !== null && $comment !== "") {
	$comment = h(trim($routine["comment"], "\n"));

	// Remove indenting of all lines (used in MySQL routines in 'sys' database).
	if (preg_match('~^ +~', $comment, $matches)) {
		preg_match_all("~^($matches[0]|$)~m", $comment, $linesWithIndent);

		if (count($linesWithIndent[0]) == substr_count($comment, "\n")) {
			$comment = preg_replace("~^($matches[0])~m", "", $comment);
		}
	}

	// Format common headlines (used in MySQL routines in 'sys' database).
	$comment = preg_replace('~(^|[^\n]\n)(Description|Parameters|Example)\n~', "$1\n<strong>$2</strong>\n", $comment);

	echo "<pre class='comment'>$comment</pre>\n";
}
