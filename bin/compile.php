<?php

namespace AdminNeo;

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
set_error_handler(function ($errno, $error) {
	return (bool)preg_match('~^Undefined array key~', $error);
}, E_WARNING);

include __DIR__ . "/../admin/include/version.inc.php";
include __DIR__ . "/../admin/include/debug.inc.php";
include __DIR__ . "/../admin/include/polyfill.inc.php";
include __DIR__ . "/../admin/include/available.inc.php";
include __DIR__ . "/../admin/include/compile.inc.php";
include __DIR__ . "/../vendor/vrana/phpshrink/phpShrink.php";

function is_dev_version(): bool
{
	global $VERSION;

	return (bool)preg_match('~-dev$~', $VERSION);
}

function add_apo_slashes(string $s): string
{
	return addcslashes($s, "\\'");
}

function replace_lang(array $match): string
{
	global $lang_ids;

	$text = stripslashes($match[1]);
	if (!isset($lang_ids[$text])) {
		$lang_ids[$text] = count($lang_ids);
	}

	return "lang($lang_ids[$text]$match[2]";
}

function append_linked_files_cases(string $name, string $files, string &$name_cases, string &$data_cases): void
{
	$file_paths = preg_split('~",\s+"~', $files);

	$linked_filename = linked_filename($name, $file_paths);
	if ($linked_filename) {
		$name_cases .= "case '$name': \$filename = '$linked_filename'; break;";
		$data_cases .= "case '$linked_filename': \$data = '" . compile_file($name, $file_paths) . "'; break;";
	}
}

function put_file(array $match, string $current_path = ""): string
{
	global $project, $selected_languages;

	$filename = basename($match[2]);
	$file_path = ltrim($match[2], "/");

	$content = file_get_contents(__DIR__ . "/../$project/" . ($current_path ? "$current_path/" : "") . $file_path);

	if ($filename == "Locale.php") {
		$content = str_replace(
			'return $key; // !compile: convert translation key',
			'static $en_translations = null;

			// Convert string key used in plugins to compiled numeric key.
			if (is_string($key)) {
				if (!$en_translations) {
					$en_translations = get_translations("en");
				}

				// Find text in English translations or plurals map.
				if (($index = array_search($key, $en_translations)) !== false) {
					$key = $index;
				} elseif (($index = get_plural_translation_id($key)) !== null) {
					$key = $index;
				}
			}

			return $key;',
			$content
		);
	} elseif ($filename == "lang.inc.php") {
		if ($selected_languages) {
			$available_languages = array_fill_keys($selected_languages, true);
		} else {
			$available_languages = find_available_languages();
		}

		$content = str_replace(
			'return find_available_languages(); // !compile: available languages',
			'return ' . var_export($available_languages, true) . ';',
			$content
		);
	}

	$tokens = token_get_all($content); // to find out the last token

	return "?>\n$content" . (in_array($tokens[count($tokens) - 1][0], [T_CLOSE_TAG, T_INLINE_HTML], true) ? "<?php" : "");
}

function put_translations(): string
{
	global $lang_ids, $selected_languages;

	$languages = array_map(function ($filename) {
		preg_match('~/([^/.]+)\.inc\.php$~', $filename, $matches);
		return $matches[1];
	}, glob(__DIR__ . "/../admin/translations/*.inc.php"));

	$cases = "";
	$plurals_map = [];

	foreach ($languages as $language) {
		// Include only selected language and "en" into single language compilation.
		// "en" is used for translations in plugins.
		if ($selected_languages && !in_array($language, $selected_languages) && $language != "en") {
			continue;
		}

		// Assign $translations
		$translations = include __DIR__ . "/../admin/translations/$language.inc.php";

		$translation_ids = array_flip($lang_ids); // default translation
		foreach ($translations as $key => $val) {
			if ($val !== null) {
				$translation_ids[$lang_ids[$key]] = $val;

				if ($language == "en" && is_array($val)) {
					$plurals_map[$key] = $lang_ids[$key];
				}
			}
		}

		$cases .= 'case "' . $language . '": $compressed = "' . base64_encode(lzw_compress(json_encode($translation_ids, JSON_UNESCAPED_UNICODE))) . '"; break;';
	}

	$translations_version = crc32($cases);

	return '
		function get_translations($lang) {
			switch ($lang) {' . $cases . '}

			return json_decode(lzw_decompress(base64_decode($compressed)), true);
		}

		function get_plural_translation_id($key) {
			$plurals_map = ' . var_export($plurals_map, true) . ';

			return isset($plurals_map[$key]) ? $plurals_map[$key] : null;
		}

		$translations = $_SESSION["translations"];
		$language = Locale::get()->getLanguage();

		if ($_SESSION["translations_version"] != ' . $translations_version . ') {
			$translations = [];
			$_SESSION["translations_version"] = ' . $translations_version . ';
		}
		if ($_SESSION["translations_language"] != $language) {
			$translations = [];
			$_SESSION["translations_language"] = $language;
		}

		if (!$translations) {
			$translations = get_translations($language);
			$_SESSION["translations"] = $translations;
		}
	';
}

function get_absolute_path($file_path): string
{
	global $current_path;

	return $file_path[0] == "/" ? $file_path : "$current_path/$file_path";
}

function print_usage(): void
{
	echo "Usage:\n";
	echo "  php bin/compile.php [project] [drivers] [languages] [themes] [config-file] [-o output-file]\n";
	echo "\n";
	echo "Compile AdminNeo or EditorNeo together with all plugins.\n";
	echo "Files will be saved into the 'compiled' directory.\n";
	echo "\n";
	echo "PARAMETERS:\n";
	echo "  project     - `admin` or `editor`\n";
	echo "  drivers     - is a comma-separated list of database drivers or the value `all-drivers`\n";
	echo "  languages   - comma-separated list of languages\n";
	echo "  themes      - comma-separated list of themes together with specific color variant\n";
	echo "  config-file - path to the custom JSON configuration file\n";
	echo "  output-file - path where to save the compiled file\n";
	echo "\n";
	echo "More information at: https://github.com/adminneo-org/adminneo?tab=readme-ov-file#usage\n";
}

$current_path = getcwd();

// Parse script arguments.
$arguments = $argv;
array_shift($arguments);

if ($arguments && ($arguments[0] == "-h" || $arguments[0] == "--help")) {
	print_usage();
	exit;
}

// Project.
$project = "admin";
if ($arguments) {
	if ($arguments[0] == "editor") {
		$project = "editor";
		array_shift($arguments);
	} elseif ($arguments[0] == "admin") {
		array_shift($arguments);
	}
}

echo "project:   $project\n";

// Drivers.
$selected_drivers = [];
if ($arguments) {
	$params = explode(",", $arguments[0]);

	if (file_exists(__DIR__ . "/../admin/drivers/" . $params[0] . ".inc.php")) {
		$selected_drivers = $params;
		array_shift($arguments);
	}
}
$single_driver = count($selected_drivers) == 1 ? $selected_drivers[0] : null;

$compilation_info[] = $text = "drivers:   " . ($selected_drivers ? implode(", ", $selected_drivers) : "all") . "\n";
echo $text;

// Languages.
$selected_languages = [];
if ($arguments) {
	$params = explode(",", $arguments[0]);

	if (file_exists(__DIR__ . "/../admin/translations/" . $params[0] . ".inc.php")) {
		$selected_languages = $params;
		array_shift($arguments);
	}
}
$single_language = count($selected_languages) == 1 ? $selected_languages[0] : null;

$compilation_info[] = $text = "languages: " . ($selected_languages ? implode(", ", $selected_languages) : "all") . "\n";
echo $text;

// Themes.
$selected_themes = [];
if ($arguments) {
	$params = explode(",", $arguments[0]);

	if (file_exists(__DIR__ . "/../admin/themes/$params[0]")) {
		$themes_map = [];
		foreach ($params as $theme) {
			if (preg_match('~-(blue|green|red)$~', $theme)) {
				$dirNames = [$theme];
			} else {
				$dirNames = ["$theme-blue", "$theme-green", "$theme-red"];
			}

			// Collect unique themes, ensure to include the default color variant for every theme.
			foreach ($dirNames as $dirName) {
				$dirname = basename($dirName);

				preg_match('~-(blue|green|red)$~', $dirname, $matches);

				$themes_map["default-$matches[1]"] = true;
				$themes_map[$dirname] = true;
			}
		}

		$selected_themes = array_keys($themes_map);

		array_shift($arguments);
	}
}

$compilation_info[] = $text = "themes:    " . ($selected_themes ? implode(", ", $selected_themes) : "all") . "\n";
echo $text;

if (!$selected_themes) {
	foreach (find_available_themes() as $theme => $colors) {
		foreach ($colors as $color => $available) {
			$selected_themes[] = "$theme-$color";
		}
	}
}

// Custom config.
$custom_config = [];
if ($arguments && preg_match('~\.json$~i', $arguments[0])) {
	$file_path = get_absolute_path($arguments[0]);
	$custom_config = @file_get_contents($file_path);

	if ($custom_config) {
		$custom_config = json_decode($custom_config, true);
		if (!is_array($custom_config)) {
			echo "⚠️ Wrong format of configuration file: $file_path\n";
			exit(1);
		}
	} else {
		echo "⚠️ Error reading configuration file: $file_path\n";
		exit(1);
	}

	array_shift($arguments);
}

$compilation_info[] = $text = "config:    " . ($custom_config ? "yes" : "no") . "\n";
echo $text;

// Output file path and/or name.
$output_file_path = null;
if ($arguments && ($arguments[0] == "-o" || $arguments[0] == "--output") && isset($arguments[1])) {
	$output_file_path = $arguments[1];

	array_shift($arguments);
	array_shift($arguments);
}

// Check if all arguments were consumed.
if ($arguments) {
	echo "\n⚠️ Unknown argument: $arguments[0]\n";
	echo "Run `php bin/compile.php -h` for help.\n";
	exit(1);
}

// Check function definition in drivers.
/* Disabled for now because it reports too many warnings.
$file = file_get_contents(__DIR__ . "/../admin/drivers/mysql.inc.php");
$file = preg_replace('~class Min_Driver.*\n\t}~sU', '', $file);
preg_match_all('~\bfunction ([^(]+)~', $file, $matches); //! respect context (extension, class)
$functions = array_combine($matches[1], $matches[0]);
//! do not warn about functions without declared support()
unset($functions["__construct"], $functions["__destruct"], $functions["set_charset"]);

foreach (glob(__DIR__ . "/../admin/drivers/*.inc.php") as $filename) {
	preg_match('~/([^/.]+)\.inc\.php$~', $filename, $matches);
	if ($matches[1] == "mysql" || ($selected_drivers && !in_array($matches[1], $selected_drivers))) {
		continue;
	}

	$file = file_get_contents($filename);
	foreach ($functions as $function) {
		if (!strpos($file, "$function(")) {
			fprintf(STDERR, "Missing $function in $filename\n");
		}
	}
}
*/

$features = ["check", "call" => "routine", "dump", "event", "privileges", "procedure" => "routine", "processlist", "routine", "scheme", "sequence", "status", "trigger", "type", "user" => "privileges", "variables", "view"];
$lang_ids = []; // global variable simplifies usage in a callback functions

// Change current directory to the project's root. This is required for generating static files.
chdir(__DIR__ . "/../$project");

// Start with index.php.
$file = file_get_contents(__DIR__ . "/../$project/index.php");

// Remove including source code for unsupported features in single-driver file.
if ($single_driver) {
	include __DIR__ . "/../admin/core/Connection.php";
	include __DIR__ . "/../admin/core/DummyConnection.php";
	include __DIR__ . "/../admin/core/Result.php";
	include __DIR__ . "/../admin/include/pdo.inc.php";
	include __DIR__ . "/../admin/core/Drivers.php";
	include __DIR__ . "/../admin/core/Driver.php";

	$_GET[$single_driver] = true; // to load the driver
	include __DIR__ . "/../admin/drivers/$single_driver.inc.php";

	DummyConnection::create(); // to make support() work

	foreach ($features as $key => $feature) {
		if (!support($feature)) {
			if (is_string($key)) {
				$feature = $key;
			}
			$file = str_replace("} elseif (isset(\$_GET[\"$feature\"])) {\n\tinclude \"$feature.inc.php\";\n", "", $file);
		}
	}
	if (!support("routine")) {
		$file = str_replace("if (isset(\$_GET[\"callf\"])) {\n\t\$_GET[\"call\"] = \$_GET[\"callf\"];\n}\nif (isset(\$_GET[\"function\"])) {\n\t\$_GET[\"procedure\"] = \$_GET[\"function\"];\n}\n", "", $file);
	}
}

// Compile files included into the index.php.
$file = preg_replace_callback('~\binclude (__DIR__ \. )?"([^"]+)";~', 'AdminNeo\put_file', $file);

// Remove including unneeded code.
$file = str_replace('include __DIR__ . "/debug.inc.php"', '', $file);
$file = str_replace('include __DIR__ . "/available.inc.php";', '', $file);
$file = str_replace('include __DIR__ . "/compile.inc.php";', '', $file);
$file = str_replace('include __DIR__ . "/coverage.inc.php";', '', $file);

// Remove including unwanted drivers.
if ($selected_drivers) {
	$file = preg_replace_callback('~\binclude __DIR__ \. "/../drivers/([^.]+).*\n~', function ($match) use ($selected_drivers) {
		return in_array($match[1], $selected_drivers) ? $match[0] : "";
	}, $file);
}

// Change plugins directory.
$file = str_replace(
	'$plugins_dir = __DIR__ . "/../../plugins"; // !compile: plugins directory',
	'$plugins_dir = "adminneo-plugins";',
	$file
);

// Compile files included into the /admin/include/bootstrap.inc.php.
$file = preg_replace_callback('~\binclude (__DIR__ \. )?"([^"]+)";~', function ($match) {
	return put_file($match, "../admin/include");
}, $file);

if ($single_driver) {
	// Remove source code for unsupported features.
	foreach ($features as $feature) {
		if (!support($feature)) {
			$file = preg_replace("((\t*)" . preg_quote('if (support("' . $feature . '")') . ".*?\n\\1\\}( else)?)s", '', $file);
		}
	}

	// Remove Jush modules for other drivers.
	$file = preg_replace('~"\.\./vendor/vrana/jush/modules/jush-(?!textarea\.|txt\.|js\.|' . ($single_driver == "mysql" ? "sql" : preg_quote($single_driver)) . '\.)[^.]+.js",\n~', '', $file);

	$file = preg_replace_callback('~doc_link\(\[(.*)]\)~sU', function ($match) use ($single_driver) {
		list(, $links) = $match;
		$links = preg_replace("~'(?!(" . ($single_driver == "mysql" ? "sql|mariadb" : $single_driver) . ")')[^']*' => [^,]*,?~", '', $links);
		return (trim($links) ? "doc_link([$links])" : "''");
	}, $file);

	//! strip doc_link() definition
}

// Compile language files.
$file = preg_replace_callback("~lang\\('((?:[^\\\\']+|\\\\.)*)'([,)])~s", 'AdminNeo\replace_lang', $file);
$file = preg_replace_callback('~\$translations = .* // !compile: translations~', 'AdminNeo\put_translations', $file);

$file = str_replace("\r", "", $file);

// Clean up namespaces.
preg_match_all('~^use ([^; ]+);~m', $file, $matches);
$file = preg_replace('~^use ([^; ]+);~m', "", $file);
$usages = implode("\n", array_combine($matches[1], $matches[0]));

$namespace_string = "namespace AdminNeo;\n";
$pos = strpos($file, $namespace_string) + strlen($namespace_string);
$file = substr($file, 0, $pos) . $usages . str_replace($namespace_string, "", substr($file, $pos));

// Integrate static files.
preg_match_all('~link_files\("([^"]+)", \[([^]]+)]\)~', $file, $matches);

$name_cases = "";
$data_cases = "";
$available_themes = [];

for ($i = 0; $i < count($matches[0]); $i++) {
	$name = $matches[1][$i];
	$files = trim($matches[2][$i], " \n\r\t\",");

	// Default theme.
	if (str_starts_with($name, 'default-$color_variant')) {
		foreach ($selected_themes as $theme) {
			if (preg_match('~^default-(blue|green|red)$~', $theme, $matches2)) {
				$name2 = str_replace('default-$color_variant', $theme, $name);
				$files2 = str_replace('default-$color_variant', $theme, $files);

				append_linked_files_cases($name2, $files2, $name_cases, $data_cases);

				$available_themes["default"][$matches2[1]] = true;
			}
		}

		continue;
	}

	// Non-default themes.
	if (str_starts_with($name, '$theme-$color_variant')) {
		foreach ($selected_themes as $theme) {
			if (!str_starts_with($theme, "default-")) {
				preg_match('~^(.*)-(blue|green|red)$~', $theme, $matches2);

				$name2 = str_replace('$theme-$color_variant', $theme, $name);
				$files2 = str_replace('$theme-$color_variant', $theme, $files);
				$files2 = str_replace('$theme', $matches2[1], $files2);

				append_linked_files_cases($name2, $files2, $name_cases, $data_cases);

				$available_themes[$matches2[1]][$matches2[2]] = true;
			}
		}

		continue;
	}

	// Favicons.
	if (str_contains($name, 'icon-$colorVariant.')) {
		foreach ($selected_themes as $theme) {
			if (preg_match('~^default-(blue|green|red)$~', $theme, $matches2)) {
				$name2 = str_replace('$colorVariant', $matches2[1], $name);
				$files2 = str_replace('$colorVariant', $matches2[1], $files);

				append_linked_files_cases($name2, $files2, $name_cases, $data_cases);
			}
		}

		continue;
	}

	append_linked_files_cases($name, $files, $name_cases, $data_cases);
}

$file = str_replace(
	'$filename = generate_linked_file($name, $file_paths); // !compile: generate linked file',
	'switch ($name) {' . $name_cases . ' default: $filename = null; break; }',
	$file
);

$file = str_replace(
	'$data = read_compiled_file($filename); // !compile: get compiled file',
	'switch ($filename) {' . $data_cases . ' default: $data = null; break; }',
	$file
);

$file = str_replace(
	'return find_available_themes(); // !compile: available themes',
	'return ' . var_export($available_themes, true) . ';',
	$file
);

// Simplify links to static files, second parameter with the file list can (and should) be erased.
$file = preg_replace('~link_files\("([^"]+)", \[([^]]+)]\)~', 'link_files("$1", [])', $file);

// Custom configuration.
if ($custom_config) {
	$file = str_replace(
		'$this->params = $params; // !compile: custom config',
		'$this->params = array_merge(' . var_export($custom_config, true) . ', $params);',
		$file
	);
} else {
	$file = str_replace('// !compile: custom config', '', $file);
}

// Print version and compilation parameters.
$file = str_replace("!compile: version", "v$VERSION", $file);

$file = str_replace(
	"!compile: parameters\n",
	"Compiled with\n * " . implode(" * ", $compilation_info),
	$file
);

// Check whether all code replacements have been done.
if (preg_match_all('~\n\s*(.+!compile:.+)\n~', $file, $matches)) {
	foreach ($matches[1] as $match) {
		echo "⚠️ unresolved code replacement: $match\n";
	}
}

// Remove superfluous PHP tags.
$file = preg_replace("~<\\?php\\s*\\?>\n?|\\?>\n?<\\?php~", '', $file);

// PHP 5.6 compatibility.
$file = downgrade_php($file);

// Shrink final file.
$file = phpShrink($file);

// Save file to the output directory.
if ($output_file_path) {
	if (is_dir($output_file_path)) {
		$output_dir = get_absolute_path(rtrim($output_file_path, "/"));
		$output_name = null;
	} else {
		$output_dir = get_absolute_path(dirname($output_file_path));
		$output_name = basename($output_file_path);

		@mkdir($output_dir, 0777, true);
	}
} else {
	$output_dir = __DIR__ . "/../compiled";
	$output_name = null;

	@mkdir($output_dir);
}

if (!$output_name) {
	$output_name = "{$project}neo"
		. (is_dev_version() ? "" : "-$VERSION")
		. ($single_driver ? "-$single_driver" : "")
		. ($single_language ? "-$single_language" : "")
		. ".php";
}

$filename = "$output_dir/$output_name";

file_put_contents($filename, $file);

$short_filename = preg_replace('~^' . preg_quote("$current_path/") . '~', "", realpath($filename));
echo "output:    $short_filename (" . strlen($file) . " B)\n";

// Compile plugins.
$output_dir = "$output_dir/adminneo-plugins";
@mkdir($output_dir);

foreach (glob(__DIR__ . "/../plugins/*") as $file_path) {
	$file = file_get_contents($file_path);

	$file = downgrade_php($file);

	$filename = "$output_dir/" . basename($file_path);
	file_put_contents($filename, $file);
}
