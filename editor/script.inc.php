<?php

namespace AdminNeo;

if ($_GET["script"] == "kill") {
	Connection::get()->query("KILL " . number($_POST["kill"]));

} elseif (list($table, $id, $name) = Admin::get()->getForeignColumnInfo(column_foreign_keys($_GET["source"]), $_GET["field"])) { // complete
	$limit = 11;
	$result = Connection::get()->query("SELECT $id, $name FROM " . table($table) . " WHERE " . (preg_match('~^[0-9]+$~', $_GET["value"]) ? "$id = $_GET[value] OR " : "") . "$name LIKE " . q("$_GET[value]%") . " ORDER BY 2 LIMIT $limit");
	for ($i=1; ($row = $result->fetchRow()) && $i < $limit; $i++) {
		echo "<a href='" . h(ME . "edit=" . urlencode($table) . "&where" . urlencode("[" . bracket_escape(idf_unescape($id)) . "]") . "=" . urlencode($row[0])) . "'>" . h($row[1]) . "</a><br>\n";
	}
	if ($row) {
		echo "...\n";
	}
}

exit; // don't print footer
