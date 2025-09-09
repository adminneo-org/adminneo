<?php

namespace AdminNeo;

$status = isset($_GET["status"]);
$title = $status ? lang('Status') : lang('Variables');

page_header($title, [$title]);

$variables = ($status ? show_status() : show_variables());
if (!$variables) {
	echo "<p class='message'>", lang('No rows.'), "</p>\n";
} else {
	echo "<div class='scrollable'><table>\n";
	foreach ($variables as $row) {
		echo "<tr>";
		$key = array_shift($row);
		echo "<th><code class='jush-" . DIALECT . ($status ? "status" : "set") . "'>" . h($key) . "</code></th>";
		foreach ($row as $val) {
			echo "<td>", nl2br(h($val)), "</td>";
		}
		echo "</tr>\n";
	}
	echo "</table></div>\n";
}
