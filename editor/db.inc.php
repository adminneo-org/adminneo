<?php

namespace AdminNeo;

page_header(lang('Server'), false);

Admin::get()->printDatabaseMenu();

echo "<form action='' method='post'>\n";
echo "<p>" . lang('Search data in tables') . ": <input type='search' class='input' name='query' value='" . h($_POST["query"]) . "'> <input type='submit' class='button' value='" . lang('Search') . "'>\n";
if ($_POST["query"] != "") {
	search_tables();
}

echo "<div class='scrollable'>\n";
echo "<table class='nowrap checkable'>\n";
echo script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});");

echo "<thead>\n";
echo "<tr class='wrap'>";
echo "<td class='actions'>";
echo "<input id='check-all' type='checkbox' class='input jsonly'>";
echo script("gid('check-all').onclick = partial(formCheck, /^tables\[/);", "");
echo "</td>";
echo "<th>", lang('Table'), "</th>";
echo "<td>", lang('Rows'), "</td>";
echo "</tr>\n";
echo "</thead>\n";

foreach (table_status() as $table => $status) {
	$name = Admin::get()->getTableName($status);
	if ($name != "") {
		echo "<tr>";
		echo "<td class='actions'>";
		echo checkbox("tables[]", $table, in_array($table, (array) $_POST["tables"], true));
		echo "</td>";

		echo "<th><a href='", h(ME), "select=", urlencode($table), "'>$name</a></th>";

		$val = format_number($status["Rows"]);
		if ($status["Engine"] == "InnoDB" && $val) {
			$val = "~ $val";
		}

		echo "<td class='number'>";
		echo "<a href='", h(ME . "edit="), urlencode($table), "'>$val</a>";
		echo "</td>";
		echo "</tr>\n";
	}
}

echo "</table>\n";
echo "</div>\n";
echo "</form>\n";

echo script("tableCheck();");
