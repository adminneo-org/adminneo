<?php
namespace AdminNeo;

if ($_POST) {
	$settings = [];
	if (isset($_POST["color_mode"])) {
		$settings["color_mode"] = $_POST["color_mode"];
	}

	save_settings($settings);
	redirect(remove_from_uri());
}

$settings = get_settings();

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

// Color mode.
echo "<tr><th>", lang('Color mode'), "</th>";
echo "<td>";
$options = [
	"" => lang('System'),
	"light" => lang('Light'),
	"dark" => lang('Dark')
];
echo html_radios("color_mode", $options, $settings["color_mode"] ?? "");
echo "</td></tr>\n";

// Form end.
echo "</table>\n";

echo "<p><input type='submit' value='" . lang('Save'), "' class='button default hidden'>\n";
echo "<input type='hidden' name='token' value='", get_token(), "'></p>\n";
echo "</form>\n";
echo script("initSettingsForm();");

page_footer();
exit;
