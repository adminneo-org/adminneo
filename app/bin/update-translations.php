<?php

use function AdminNeo\find_available_languages;

include __DIR__ . "/../admin/include/available.inc.php";

$languages = find_available_languages();

$lang = $argv[1] ?? null;
if (isset($argv[2]) || ($lang && $lang != "xx" && !isset($languages[$lang]))) {
	echo "Usage: php update-translations.php [lang]\nPurpose: Update admin/translations/*.inc.php from source code messages.\n";
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
	$messages = $all_messages;

	$old_content = str_replace("\r", "", file_get_contents($file_path));

	preg_match_all("~^(\\s*(?:// [^'].*\\s+)?)(?:// )?(('(?:[^\\\\']+|\\\\.)*') => .*[^,\n]),?~m", $old_content, $matches, PREG_SET_ORDER);

	// Keep current messages.
	$new_content = "";
	foreach ($matches as $match) {
		if (isset($messages[$match[3]])) {
			$new_content .= "$match[1]$match[2],\n";
			unset($messages[$match[3]]);
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
