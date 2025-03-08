<?php

use function AdminNeo\find_available_languages;

include __DIR__ . "/../admin/include/debug.inc.php";
include __DIR__ . "/../admin/include/available.inc.php";

$languages = find_available_languages();

$param = $argv[1] ?? null;
if ($param && ($param == "-h" || $param == "--help")) {
	echo "Usage:\n";
	echo "  php bin/update-translations.php [language]\n";
	echo "\n";
	echo "Update admin/translations/*.inc.php from source code messages.\n";
	exit;
}

$lang = $param;
if ($lang && $lang != "xx" && !isset($languages[$lang])) {
	echo "⚠️ Unknown language: $lang\n";
	exit(1);
}

if (isset($argv[2])) {
	echo "⚠️ Unknown argument: $argv[2]\n";
	echo "Run `php bin/update-translations.php -h` for help.\n";
	exit(1);
}

if ($lang) {
	$languages = [
		$lang => true,
	];
}

// Get all texts from the source code.
$file_paths = array_merge(
	glob(__DIR__ . "/../admin/*.php"),
	glob(__DIR__ . "/../admin/core/*.php"),
	glob(__DIR__ . "/../admin/include/*.php"),
	glob(__DIR__ . "/../admin/drivers/*.php"),
	glob(__DIR__ . "/../editor/*.php"),
	glob(__DIR__ . "/../editor/core/*.php"),
	glob(__DIR__ . "/../editor/include/*.php"),
	glob(__DIR__ . "/../plugins/*.php")
);
$all_messages = [];
foreach ($file_paths as $file_path) {
	$source_code = file_get_contents($file_path);

	// lang() always uses apostrophes.
	if (preg_match_all("~lang\\(('(?:[^\\\\']+|\\\\.)*')([),])~", $source_code, $matches)) {
		$all_messages += array_combine($matches[1], $matches[2]);
	}
}

// Generate language files.
foreach ($languages as $language => $dummy) {
	$file_path = __DIR__ . "/../admin/translations/$language.inc.php";
	$filename = basename($file_path);
	$lang = basename($filename, ".inc.php");
	$period = ($lang == "bn" ? '।' : (substr($lang, 0, 2) == 'zh' ? '。' : ($lang == 'he' || $lang == 'ja' ? '' : '\.')));

	$messages = $all_messages;

	$old_content = str_replace("\r", "", file_get_contents($file_path));

	preg_match_all("~^(\\s*(?:// [^'].*\\s+)?)(?:// )?(('(?:[^\\\\']+|\\\\.)*') => (.*[^,\n])),?~m", $old_content, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE);

	// Keep current messages.
	$new_content = "";
	foreach ($matches as $match) {
		$indent = $match[1][0];
		$line = $match[2][0];
		$offset = $match[2][1];
		$en = $match[3][0];
		$translation = $match[4][0];

		if (isset($messages[$en])) {
			$new_content .= "$indent$line,\n";
			unset($messages[$en]);

			// Check mismatched periods.
			if ($en != "','" && $period && !preg_match('~(null|\[])$~', $line) && (substr($en, -2, 1) == "." xor preg_match("~$period']?$~", $line))) {
				echo "⚠️ $filename:" . (substr_count($old_content, "\n", 0, $offset) + 1) . " | Not matching period: $line\n";
			}

			// Check mismatched placeholders.
			if (preg_match('~%~', $en) xor preg_match('~%~', $translation)) {
				echo "⚠️ $filename:" . (substr_count($old_content, "\n", 0, $offset) + 1) . " | Not matching placeholder.\n";
			}
		}
	}

	// Add new messages.
	if ($messages) {
		if ($filename != "en.inc.php") {
			$new_content .= "\n";
		}

		foreach ($messages as $id => $text) {
			if ($text == "," && strpos($id, "%d")) {
				$new_content .= "\t$id => [],\n";
			} elseif ($filename != "en.inc.php") {
				$new_content .= "\t$id => null,\n";
			}
		}
	}

	$new_content = "<?php\n\nnamespace AdminNeo;\n\n\$translations = [\n$new_content];\n";

	if ($new_content != $old_content) {
		file_put_contents($file_path, $new_content);

		echo "$filename updated\n";
	}
}
