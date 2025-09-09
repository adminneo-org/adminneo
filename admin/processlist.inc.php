<?php

namespace AdminNeo;

if (support("kill")) {
	if ($_POST) {
		$killed = 0;
		foreach ((array) $_POST["kill"] as $val) {
			if (kill_process($val)) {
				$killed++;
			}
		}
		queries_redirect(ME . "processlist=", lang('%d process(es) have been killed.', $killed), $killed || !$_POST["kill"]);
	}
}

page_header(lang('Process list'), [lang('Process list')]);

echo "<form action='' method='post'>\n";
echo "<div class='scrollable'>\n";
echo "<table class='nowrap checkable'>\n";
echo script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});");

// HTML valid because there is always at least one process
$i = -1;
foreach (process_list() as $i => $row) {

	if (!$i) {
		echo "<thead><tr lang='en'>" . (support("kill") ? "<th>" : "");
		foreach ($row as $key => $val) {
			echo "<th>$key" . doc_link([
				'sql' => "show-processlist.html#processlist_" . strtolower($key),
				'pgsql' => "monitoring-stats.html#PG-STAT-ACTIVITY-VIEW",
				'oracle' => "REFRN30223",
			]);
		}
		echo "</thead>\n";
	}
	echo "<tr>" . (support("kill") ? "<td>" . checkbox("kill[]", $row[DIALECT == "sql" ? "Id" : "pid"], 0) : "");
	foreach ($row as $key => $val) {
		echo "<td>" . (
			(DIALECT == "sql" && $key == "Info" && preg_match("~Query|Killed~", $row["Command"]) && $val != "") ||
			(DIALECT == "pgsql" && $key == "current_query" && $val != "<IDLE>") ||
			(DIALECT == "oracle" && $key == "sql_text" && $val != "")
			? "<code class='jush-" . DIALECT . "'>" . truncate_utf8($val, 100) . '</code> <a href="' . h(ME . ($row["db"] != "" ? "db=" . urlencode($row["db"]) . "&" : "") . "sql=" . urlencode($val)) . '">' . icon("edit") . lang('Clone') . '</a>'
			: h($val)
		);
	}
	echo "\n";
}

echo "</table>\n";
echo "</div>\n";

echo "<p>";
if (support("kill")) {
	echo ($i + 1) . "/" . lang('%d in total', max_connections());
	echo "<p><input type='submit' class='button' value='" . lang('Kill') . "'>\n";
}

echo input_token();
echo "</p>\n";

echo "</form>\n";
echo script("tableCheck();");
