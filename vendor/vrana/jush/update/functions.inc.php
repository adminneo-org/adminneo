<?php
// Common functions for the update scripts

// Get sorted names of the subdirectories of $path
function read_dirs($path) {
	$dirs = glob("$path/*", GLOB_ONLYDIR);
	if (!$dirs) {
		fwrite(STDERR, "No subdirectories in $path\n");
		exit(1);
	}
	$return = array_map('basename', $dirs);
	sort($return);
	return $return;
}

// Get the value of a front matter field
function front_matter($markdown, $field) {
	preg_match("~^$field: (.*)~m", $markdown, $match);
	return trim($match[1] ?? '');
}

// Read a file or exit with an error
function read_file($file) {
	$return = file_get_contents($file);
	if ($return === false) {
		fwrite(STDERR, "Can't read $file\n");
		exit(1);
	}
	return $return;
}

// Get the body of a "## $title" Markdown section, "" if there is no such section
function mdn_section($markdown, $title) {
	preg_match('~^## ' . preg_quote($title, '~') . '\n(.*?)(?=^## |\z)~msi', $markdown, $match);
	return ($match[1] ?? '');
}

// Escape a string to be used in a single-quoted JS string
function js_escape($s) {
	return str_replace(['\\', "'"], ['\\\\', "\\'"], $s);
}

// Store a tooltip in a jush.api block, skipping empty ones
function add_api(array &$block, $key, $tooltip) {
	if ($tooltip != '') {
		$block[$key] = $tooltip;
	}
}

// Turn statement names into regexp alternatives, a phrase before its own prefix (SELECT\s+INTO before SELECT, RESTORE-ASKING before RESTORE)
function phrases_regexp(array $names) {
	usort($names, function ($a, $b) {
		if (strpos($a, "$b ") === 0 || strpos($a, "$b-") === 0) {
			return -1;
		}
		if (strpos($b, "$a ") === 0 || strpos($b, "$a-") === 0) {
			return 1;
		}
		return strcmp($a, $b);
	});
	return str_replace(' ', '\\s+', implode('|', $names));
}

// Replace the |-separated list between $prefix and $suffix in $subject, reporting the diff
function set_list($subject, $prefix, $suffix, array $names, $label) {
	$start = strpos($subject, $prefix);
	if ($start === false) {
		fwrite(STDERR, "Can't find start of $label list\n");
		exit(1);
	}
	$start += strlen($prefix);
	$end = strpos($subject, $suffix, $start);
	if ($end === false) {
		fwrite(STDERR, "Can't find end of $label list\n");
		exit(1);
	}
	$old_names = explode('|', substr($subject, $start, $end - $start));
	report_diff($label, $old_names, $names);
	return substr_replace($subject, implode('|', $names), $start, $end - $start);
}

// Report added and removed names of a wholesale regenerated list
function report_diff($label, array $old, array $new) {
	if (array_diff($new, $old)) {
		fwrite(STDERR, "Added $label: " . implode(', ', array_diff($new, $old)) . "\n");
	}
	if (array_diff($old, $new)) {
		fwrite(STDERR, "Removed $label: " . implode(', ', array_diff($old, $new)) . "\n");
	}
}

// Replace all entries in a jush.api block between $prefix and $suffix
function set_block($subject, $prefix, $suffix, array $entries) {
	$start = strpos($subject, $prefix);
	if ($start === false) {
		fwrite(STDERR, "Can't find $prefix\n");
		exit(1);
	}
	$start += strlen($prefix);
	$end = strpos($subject, $suffix, $start);
	if ($end === false) {
		fwrite(STDERR, "Can't find end of $prefix block\n");
		exit(1);
	}
	$lines = '';
	foreach ($entries as $name => $tooltip) {
		$lines .= "\n\t'$name': '$tooltip',";
	}
	return substr_replace($subject, $lines, $start, $end - $start);
}
