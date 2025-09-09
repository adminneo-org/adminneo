<?php

namespace AdminNeo;

$title2 = DB != "" ? h(": " . DB) : "";
page_header(lang('Privileges') . $title2, [lang('Privileges')]);
echo '<p class="links top-links"><a href="', h(ME), 'user=">', icon("user-add"), lang('Create user'), "</a>";

$result =  Connection::get()->query("SELECT User, Host FROM mysql." . (DB == "" ? "user" : "db WHERE " . q(DB) . " LIKE Db") . " ORDER BY Host, User");
$grant = $result;
if (!$result) {
	// list logged user, information_schema.USER_PRIVILEGES lists just the current user too
	$result =  Connection::get()->query("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', 1) AS User, SUBSTRING_INDEX(CURRENT_USER, '@', -1) AS Host");
}

echo "<form action=''><p>\n";
hidden_fields_get();
echo "<input type='hidden' name='db' value='" . h(DB) . "'>\n";
echo ($grant ? "" : "<input type='hidden' name='grant' value=''>\n");
echo "<div class='scrollable'>\n";

echo "<table class='checkable'>\n";
echo "<thead><tr><th>" . lang('Username') . "<th>" . lang('Server') . "<th></thead>\n";

while ($row = $result->fetchAssoc()) {
	echo '<tr><td>' . h($row["User"]) . "<td>" . h($row["Host"]) . '<td><a href="' . h(ME . 'user=' . urlencode($row["User"]) . '&host=' . urlencode($row["Host"])) . '">' . lang('Edit') . "</a>\n";
}

if (!$grant || DB != "") {
	echo "<tr><td><input class='input' name='user' autocapitalize='off'><td><input class='input' name='host' value='localhost' autocapitalize='off'><td><input type='submit' class='button' value='" . lang('Edit') . "'>\n";
}

echo "</table>\n";

echo "</div>\n";
echo "</form>\n";
