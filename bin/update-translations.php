<?php

use function AdminNeo\find_available_languages;

include __DIR__ . "/../admin/include/debug.inc.php";
include __DIR__ . "/../admin/include/available.inc.php";
include __DIR__ . "/../admin/include/polyfill.inc.php";

$to_end = $clean = false;
$languages = [];

array_shift($argv);
foreach ($argv as $key => $option) {
	if ($option == "-h" || $option == "--help") {
		echo "Usage:\n";
		echo "  php bin/update-translations.php [-h] [-to-end] [--clean] [languages]\n";
		echo "\n";
		echo "Updates admin/translations/*.inc.php from the source code messages.\n";
		echo "\n";
		echo "OPTIONS:\n";
		echo "  --to-end    - group untranslated texts at the end of the list\n";
		echo "  --clean     - delete untranslated texts\n";
		echo "  -h, --help  - print help\n";
		echo "\n";
		echo "PARAMETERS:\n";
		echo "  languages   - comma-separated list of language codes (de,es)\n";
		exit;
	}

	if ($option == "--to-end") {
		$to_end = true;
		unset($argv[$key]);
	} elseif ($option == "--clean") {
		$clean = true;
		unset($argv[$key]);
	} elseif (!$languages) {
		$languages = explode(",", $option);
	}
}

$available_languages = find_available_languages();
$template = "_template";

$unknown = false;
foreach ($languages as $language) {
	if ($language != $template && !isset($available_languages[$language])) {
		echo "⚠️ Unknown language: $language\n";
		$unknown = true;
	}
}
if ($unknown) {
	exit(1);
}

if (isset($argv[1])) {
	echo "⚠️ Unknown argument: $argv[1]\n";
	echo "Run `php bin/update-translations.php -h` for help.\n";
	exit(1);
}

if ($languages) {
	$languages = array_fill_keys($languages, true);
} else {
	$languages = $available_languages;
}

// Always update the template at first.
$languages = [$template => true] + $languages;

// Get all texts from the source code.
$file_paths = glob(__DIR__ . "/../{admin,admin/core,admin/include,admin/drivers,editor,editor/core,editor/include,plugins}/*.php", GLOB_BRACE);

$all_texts = [];
foreach ($file_paths as $file_path) {
	$source_code = file_get_contents($file_path);

	// lang() always uses apostrophes.
	if (preg_match_all("~lang\\('([^\\\\']+|\\\\.)*'([),])~", $source_code, $matches)) {
		$all_texts += array_combine($matches[1], $matches[2]);
	}
}

// Generate language files.
foreach ($languages as $language => $dummy) {
	$file_path = __DIR__ . "/../admin/translations/$language.inc.php";
	$filename = basename($file_path);
	$period = ($language == "bn" || $language == 'hi' ? '।' : (preg_match('~^(ja|zh)~', $language) ? '。' : ($language == 'he' ? '' : '\.')));

	$texts = $all_texts;
	$translations = require $file_path;
	$old_content = str_replace("\r", "", file_get_contents($file_path));
	$content = file_get_contents(__DIR__ . "/../admin/translations/$template.inc.php");

	// Language files are regenerated from the template, so remember which texts are marked as machine translated.
	$marks = read_ai_marks($old_content);

	foreach ($translations as $en => $translation) {
		// Skip/remove the translation of nonexistent text.
		if (!isset($texts[$en])) {
			if ($language == $template) {
				delete_translation($content, $en);
			}
			continue;
		}

		// Keep current translated texts.
		if ($translation !== null || (!$to_end && !$clean)) {
			write_translation($content, $en, $translation, $language == $template);
			unset($texts[$en]);

			// Do not check untranslated texts and thousands separator.
			if ($translation === null || $en == ",") {
				continue;
			}

			$term = "'$en' => " . format_translation($translation, true);
			$variants = is_string($translation) ? [$translation] : $translation;

			foreach ($variants as $variant) {
				$endWithPeriod = substr($en, -1, 1) == ".";

				// Ignore periods in DB abbreviation.
				if (!$endWithPeriod) {
					$variant = preg_replace('~Β.Δ.$~', "ΒΔ", $variant);
				}

				// Check forbidden periods.
				if (!$period && preg_match("~\.$~", $variant)) {
					print_warning($filename, $term, "Period is forbidden");
				}

				// Check mismatched periods. Period is optional in 'ja' and can mismatch in date/time formatting.
				if ($period &&
					$language != "ja" &&
					!preg_match('~^[0-9.$YMD\-]+$~', $en) &&
					($endWithPeriod xor preg_match("~$period$~", $variant)))
				{
					print_warning($filename, $term, "Not matching period");
				}
			}

			// Check mismatched placeholders.
			foreach (placeholder_errors($language, $en, $translation, $language == $template) as $error) {
				print_warning($filename, $term, "Placeholders - $error");
			}
		}
	}

	// Process untranslated texts.
	$first = true;
	foreach ($texts as $en => $ending) {
		if ($to_end || $clean) {
			delete_translation($content, $en);
		} elseif ($language != $template) {
			write_translation($content, $en, null, false);
			continue;
		}

		if (!$clean && ($language != "en" || str_contains($en, "%d"))) {
			add_translation($content, $en, $first);
			$first = false;
		}
	}

	// Cleanup en file.
	if ($language == "en") {
		$content = preg_replace('~\t//.*~', "", $content);
		$content = preg_replace('~\n{2,}([\t\]])~', "\n$1", $content);
	}

	// Restore the marks of machine translated texts.
	foreach ($marks as $en => $mark) {
		$content = write_ai_mark($content, $en, $mark);
	}

	if ($content != $old_content) {
		file_put_contents($file_path, $content);

		echo "✳️ $filename updated\n";
	} elseif ($language != $template || count($languages) == 1) {
		echo "✔︎ $filename\n";
	}
}

/**
 * Checks that printf placeholders in the translation match the English original.
 *
 * @param string|array $translation Translated text or the list of its plural forms.
 * @return string[] Found problems.
 */
function placeholder_errors(string $language, string $en, $translation, bool $is_template): array
{
	$errors = [];
	$spec = '%(\d+\$)?(?:\.\d+)?([dsf])'; // %2$s is positional, %.3f is used for time.

	preg_match_all("~$spec~", $en, $matches);
	$types = $matches[2]; // Types of arguments passed to lang().

	$variants = is_string($translation) ? [$translation] : $translation;

	if (is_array($translation)) {
		$forms = get_plural_forms_count($language);
		if (count($variants) != $forms) {
			$errors[] = "expected $forms plural forms"; // A missing form renders as an empty message.
		}

		// The template keeps the arrays as it is a base for new translations.
		if (!$is_template && count(array_unique($variants)) == 1) {
			$errors[] = "identical plural forms"; // Could be a plain string.
		}
	}

	foreach ($variants as $variant) {
		preg_match_all("~$spec~", $variant, $specs, PREG_SET_ORDER);

		$sequential = 0;
		$positional = 0;
		$missing = $types;

		foreach ($specs as $match) {
			$position = ($match[1] != "" ? intval($match[1]) : ++$sequential);
			$positional += ($match[1] != "");

			if ($position > count($types)) {
				$errors[] = "extra %$match[2]"; // Would throw ValueError in vsprintf().
			} elseif ($types[$position - 1] != $match[2]) {
				$errors[] = "%$match[2] instead of %" . $types[$position - 1];
			}

			unset($missing[$position - 1]);
		}

		if ($positional && $sequential) {
			$errors[] = "mixed positional and sequential placeholders"; // %s after %2$s would still print the first argument.
		}
		if (array_diff($missing, ["d"])) {
			$errors[] = "missing %s"; // %d may be omitted e.g. in singular forms.
		}
		if (str_contains(preg_replace(["~$spec~", '~%%~'], "", $variant), "%")) {
			$errors[] = "invalid %"; // '% d' prints the number with a space flag and eats the following letter.
		}
	}

	return array_unique($errors);
}

/**
 * Returns the number of plural forms selected by Locale::translate().
 */
function get_plural_forms_count(string $language): int
{
	return $language == "sl" ? 4 : (preg_match('~^(cs|sk|pl|lt|lv|bs|hr|ru|sr|uk)$~', $language) ? 3 : 2);
}

/**
 * Returns texts whose translations are marked as machine translated.
 *
 * @return array<string, true> Keys are texts in the same escaping as they are written in the file.
 */
function read_ai_marks(string $content): array
{
	$marks = [];
	$en = null;

	foreach (explode("\n", $content) as $line) {
		if (preg_match('~^\t\'(.+)\' => ~', $line, $matches)) {
			$en = $matches[1];
		}

		if ($en != null && preg_match('~ +// (by .+)$~', $line, $matches2)) {
			$marks[$en] = $matches2[1];
			$en = null;
		}
	}

	return $marks;
}

/**
 * Marks the translation as machine translated. Multiline translations are marked at their last line.
 */
function write_ai_mark(string $content, string $en, string $mark): string
{
	$lines = explode("\n", $content);
	$found = $multiline = false;

	foreach ($lines as $key => $line) {
		if (!$found) {
			if (!preg_match('~^\t\'' . preg_quote($en, '~') . '\' => (.+)$~', $line, $matches)) {
				continue;
			}

			$found = true;

			$multiline = ($matches[1] == "[");
			if ($multiline) {
				continue;
			}
		} elseif ($multiline && !preg_match('~^\t],~', $line)) {
			continue;
		}

		$lines[$key] = rtrim($line) . " // $mark";

		return implode("\n", $lines);
	}

	return $content;
}

/**
 * @param string|array|null $translation
 */
function write_translation(string &$content, string $en, $translation, bool $single_line): void
{
	$content = preg_replace(
		'~^(\t\'' . preg_quote($en) . '\' => ).+?,( +//.*)?$~m',
		"$1" . format_translation($translation, $single_line, true) . ",$2",
		$content
	);
}

function delete_translation(string &$content, string $en): void
{
	$content = preg_replace(
		'~\t+\'' . preg_quote($en) . '\' => [^\n]+\n~',
		"",
		$content
	);
}

function add_translation(string &$content, string $en, bool $first = false): void
{
	if ($first) {
		$content = preg_replace(
			'~];~',
			"\n\t// TODO New texts\n];",
			$content
		);
	}

	$content = preg_replace(
		'~];~',
		"\t'$en' => null,\n];",
		$content
	);
}

/**
 * @param string|array|null $translation
 */
function format_translation($translation, bool $single_line = false, bool $escape_dollars = false): string
{
	$result = $translation === null ? "null" : var_export($translation, true);

	if (is_array($translation)) {
		$result = preg_replace('~\n\s+\d+ => ~', "\n\t\t", $result);
		$result = preg_replace('~^array \(~', "[", $result);
		$result = preg_replace('~,?\n\)$~', ",\n\t]", $result);

		if ($single_line) {
			$result = preg_replace('~,\n\s*~', ", ", $result);
			$result = preg_replace('~\n\s*~', "", $result);
			$result = str_replace(", ]", "]", $result);
		}
	}

	if ($escape_dollars) {
		$result = str_replace('$', '\$', $result);
	}

	return $result;
}

function print_warning(string $filename, string $term, string $message): void
{
	echo "⚠️ $filename | $message: $term\n";
}
