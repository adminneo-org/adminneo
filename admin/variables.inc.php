<?php

namespace AdminNeo;

$status = isset($_GET["status"]);
$title = $status ? lang('Status') : lang('Variables');

page_header($title, [$title]);

$variables = ($status ? show_status() : show_variables());
if (!$variables) {
	echo "<p class='message'>" . lang('No rows.') . "\n";
} else {
	echo "<div class='scrollable'><table>\n";
	foreach ($variables as $key => $val) {
		echo "<tr>";
		echo "<th><code class='jush-" . DIALECT . ($status ? "status" : "set") . "'>" . h($key) . "</code>";
		echo "<td>" . nl2br(h($val));
	}
	echo "</table></div>\n";
}
