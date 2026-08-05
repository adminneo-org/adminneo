<?php
// Updates the linked JSDoc tags in modules/jush-js.js from a checkout of
// https://github.com/jsdoc/jsdoc.github.io (the source of https://jsdoc.app/)
// Usage: php update/js_doc.php path/to/jsdoc.github.io

require __DIR__ . '/functions.inc.php';

if (!isset($argv[1])) {
	fwrite(STDERR, "Usage: php update/js_doc.php path/to/jsdoc.github.io\n");
	exit(1);
}
$content = "$argv[1]/content";
$jush_file = __DIR__ . '/../modules/jush-js.js';

// Get the items of a front matter list ("synonyms:\n- arg\n- argument"), [] if there is no such field
function front_matter_list($markdown, $field) {
	preg_match("~^$field:\n((?:-.*\n)+)~m", $markdown, $match);
	preg_match_all('~^-\s*(\S+)~m', ($match[1] ?? ''), $matches);
	return $matches[1];
}

// Replace the single page entries between $prefix and $suffix, reporting the diff
function set_entries($subject, $prefix, $suffix, array $entries, $label) {
	$start = strpos($subject, $prefix);
	if ($start === false) {
		fwrite(STDERR, "Can't find start of $label\n");
		exit(1);
	}
	$start += strlen($prefix);
	$end = strpos($subject, $suffix, $start);
	if ($end === false) {
		fwrite(STDERR, "Can't find end of $label\n");
		exit(1);
	}
	$old = [];
	preg_match_all('~/\((.*)\)/~', substr($subject, $start, $end - $start), $matches);
	foreach ($matches[1] as $names) {
		$old = array_merge($old, explode('|', $names));
	}
	$new = [];
	$lines = '';
	foreach ($entries as $page => $names) {
		$new = array_merge($new, $names);
		$lines .= "\t'$page': /(" . implode('|', $names) . ")/,\n";
	}
	report_diff($label, $old, $new);
	return substr_replace($subject, $lines, $start, $end - $start);
}

$tags = []; // block tags linked by the '$1' entry, e.g. param
$entries = []; // page => tags linked by their own entry, e.g. tags-param => ['@arg', '@argument']

foreach (glob("$content/tags-*.md") as $file) {
	$md = read_file($file);
	$name = front_matter($md, 'tag');
	if (!preg_match('~^\w+$~', $name)) {
		continue;
	}
	// check for the inline value, tags-callback.md has a typo in the block one ("blockTagss")
	$inline = (front_matter($md, 'tags') == 'inlineTags');
	$names = front_matter_list($md, 'synonyms');
	if ($inline) {
		array_unshift($names, $name); // inline tags are not in the '$1' entry, they need the "{@" prefix
	} else {
		$tags[] = $name;
	}
	foreach ($names as $synonym) {
		if (preg_match('~^\w+$~', $synonym)) { // e.g. "memberof!"
			$entries[basename($file, '.md')][] = ($inline ? '\\{@' : '@') . $synonym;
		}
	}
}
if (!$tags) {
	fwrite(STDERR, "No tags found in $content\n");
	exit(1);
}
sort($tags);
ksort($entries);

$jush = read_file($jush_file);
// tags first so that e.g. @returns wins over the @return synonym
$jush = set_list($jush, "'tags-\$1': /(@(?:", "))/,", $tags, 'tags');
$jush = set_entries($jush, "'tags-\$1': /(@(?:" . implode('|', $tags) . "))/,\n", '});', $entries, 'synonyms');
file_put_contents($jush_file, $jush);
