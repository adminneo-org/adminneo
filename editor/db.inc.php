<?php

namespace AdminNeo;

page_header(lang('Server'), false);

Admin::get()->printDatabaseMenu();

echo "<form action='' method='post'>\n";
echo "<p>" . lang('Search data in tables') . ": <input type='search' class='input' name='query' value='" . h($_POST["query"]) . "'> " .
	"<input type='submit' class='button' value='" . lang('Search') . "'>\n";
echo input_token();
if ($_POST["query"] != "") {
	search_tables();
}

echo "<div class='scrollable'>\n";
echo "<table class='nowrap checkable'>\n";

echo "<thead>\n";
echo "<tr class='wrap'>";
echo "<td class='actions'>";
echo "<input id='check-all' type='checkbox' class='input jsonly' title='" . lang('All') . "'>";
echo script("gid('check-all').onclick = partial(formCheck, /^tables\[/);", "");
echo "</td>";
echo "<th>", lang('Table'), "</th>";
echo "<td>", lang('Rows'), "</td>";
echo "</tr>\n";
echo "</thead>\n";
echo "<tbody>\n";

foreach (table_status() as $table => $status) {
	$name = Admin::get()->getTableName($status);
	if ($name != "") {
		echo "<tr>";
		echo "<td class='actions'>";
		echo checkbox("tables[]", $table, in_array($table, (array) $_POST["tables"], true));
		echo "</td>";

		echo "<th><a href='", h(ME), "select=", urlencode($table), "'>$name</a></th>";

		echo "<td class='number'>";
		echo "<a href='", h(ME . "edit="), urlencode($table), "'>", format_rows($status), "</a>";
		echo "</td>";
		echo "</tr>\n";
	}
}

echo "</tbody>\n";
echo script("mixin(qsl('tbody'), {onclick: tableClick, ondblclick: event => tableClick(event, true)});");

echo "</table>\n";
echo "</div>\n";
echo "</form>\n";

echo script("tableCheck();");
