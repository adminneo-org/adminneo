<?php
namespace AdminNeo;

$title = lang('Settings');
page_header($title, [$title]);

// Form begin.
echo "<form id='settings' action='' method='post'>\n";
echo "<table class='box'>\n";

// Language.
$options = get_language_options();
if ($options) {
	echo "<tr><th>", lang('Language'), "</th>";
	echo "<td>";
	echo html_select("lang", get_language_options(), Locale::get()->getLanguage());
	echo "</td></tr>\n";
}

// Form end.
echo "</table>\n";

echo "<p><input type='submit' value='" . lang('Save'), "' class='button default hidden'>\n";
echo "<input type='hidden' name='token' value='", get_token(), "'></p>\n";
echo "</form>\n";
echo script("initSettingsForm();");

page_footer();
exit;
