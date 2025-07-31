<?php
namespace AdminNeo;

$config = Admin::get()->getConfig();
$settings = Admin::get()->getSettings();

if ($_POST) {
	$paramKeys = ["colorMode", "navigationMode"];

	$params = [];
	foreach ($paramKeys as $key) {
		if (isset($_POST[$key])) {
			$params[$key] = $_POST[$key] !== "" ? $_POST[$key] : null;
		}
	}

	$settings->updateParameters($params);
	redirect(remove_from_uri());
}

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
	Settings::ColorModeLight => lang('Light'),
	Settings::ColorModeDark => lang('Dark')
];
echo html_radios("colorMode", $options, $settings->getParameter("colorMode") ?? "");
echo "</td></tr>\n";

// Navigation mode.
echo "<tr><th>", lang('Navigation mode'), "</th>";
echo "<td>";
$options = [
	"" => lang('Default'),
	Config::NavigationSimple => lang('Simple'),
	Config::NavigationDual => lang('Dual'),
	Config::NavigationReversed => lang('Reversed')
];
$default = $options[$config->getNavigationMode()];
$options[""] .= " ($default)";

echo html_radios("navigationMode", $options, $settings->getParameter("navigationMode") ?? "");
echo "<span class='input-hint'>", lang('Layout of main navigation with table links.'), "</span>";
echo "</td></tr>\n";

// Form end.
echo "</table>\n";

echo "<p><input type='submit' value='" . lang('Save'), "' class='button default hidden'>\n";
echo "<input type='hidden' name='token' value='", get_token(), "'></p>\n";
echo "</form>\n";
echo script("initSettingsForm();");

page_footer();
exit;
