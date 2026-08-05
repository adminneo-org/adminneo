<?php
// Updates the linked objects, functions and statements in modules/jush-js.js and the
// tooltips in jush-api.js from a checkout of https://github.com/mdn/content
// Usage: php update/js.php path/to/mdn-content

require __DIR__ . '/functions.inc.php';

if (!isset($argv[1])) {
	fwrite(STDERR, "Usage: php update/js.php path/to/mdn-content\n");
	exit(1);
}
$reference = "$argv[1]/files/en-us/web/javascript/reference";
$jush_file = __DIR__ . '/../modules/jush-js.js';
$jush_api_file = __DIR__ . '/../jush-api.js';

// Get the summary paragraph of a page as a plain-text JS-escaped tooltip
function description($markdown) {
	$markdown = preg_replace('~\A---.*?\n---\n~s', '', $markdown);
	foreach (preg_split('~\n{2,}~', $markdown) as $paragraph) {
		$paragraph = trim($paragraph);
		// skip notes and warnings, and lines with macros only, e.g. {{APIRef("XMLHttpRequest API")}}
		if ($paragraph == '' || $paragraph[0] == '>' || trim(preg_replace('~\{\{.*?\}\}~s', '', $paragraph)) == '') {
			continue;
		}
		$text = preg_replace_callback('~\{\{.*?\}\}~s', function ($match) {
			preg_match_all('~"([^"]*)"~', $match[0], $args); // {{jsxref("Statements/let", "let", "", 1)}} - the last non-empty argument is the label
			$args = array_filter($args[1], 'strlen');
			return ($args ? end($args) : '');
		}, $paragraph);
		$text = preg_replace('~\[([^\]]*)\]\([^)]*\)~', '$1', $text); // links
		$text = str_replace(['**', '`'], '', $text);
		$text = preg_replace('~<sup>(.*?)</sup>~', '^$1', $text); // HTML tags are not supported in titles
		$text = trim(preg_replace('~\s+~', ' ', $text));
		if ($text != '') {
			return js_escape($text);
		}
	}
	return '';
}

$objects = []; // proper-case names for the main list, e.g. parseInt, Array
$statics = []; // static members for the main list, e.g. Math\.abs
$instances = []; // object name => instance members, e.g. Array => [pop, push]
$api = []; // key => tooltip for the jush.api.js block

foreach (read_dirs("$reference/global_objects") as $dir) {
	$md = read_file("$reference/global_objects/$dir/index.md");
	$name = basename(front_matter($md, 'slug')); // dir names are lowercased, slugs keep case
	if (!preg_match('~^\w+$~', $name)) {
		continue;
	}
	$objects[] = $name;
	add_api($api, $name, description($md));
	foreach (glob("$reference/global_objects/$dir/*", GLOB_ONLYDIR) as $subdir) {
		$sub_md = read_file("$subdir/index.md");
		$member = basename(front_matter($sub_md, 'slug'));
		$page_type = front_matter($sub_md, 'page-type');
		if (!preg_match('~^\w+$~', $member)) { // e.g. Symbol.iterator
			continue;
		}
		if (strpos($page_type, 'javascript-static-') === 0) {
			$statics[] = "$name\\.$member";
			add_api($api, "$name.$member", description($sub_md));
		} elseif (strpos($page_type, 'javascript-instance-') === 0) {
			$instances[$name][] = $member;
		}
	}
}
sort($objects);
sort($statics);

$statements = [];
foreach (read_dirs("$reference/statements") as $dir) {
	// multi-keyword statements (do...while, if...else, try...catch) have static entries
	if (preg_match('~^[a-z]+$~', $dir) && !in_array($dir, ['block', 'empty', 'label'])) { // pages not named after a keyword
		$statements[] = $dir;
	}
}

$xhr_methods = []; // XMLHttpRequest instance methods, e.g. send
$xhr_path = "$argv[1]/files/en-us/web/api/xmlhttprequest";
add_api($api, 'XMLHttpRequest', description(read_file("$xhr_path/index.md")));
foreach (read_dirs($xhr_path) as $dir) {
	$md = read_file("$xhr_path/$dir/index.md");
	$member = basename(front_matter($md, 'slug'));
	// open collides with window.open
	if (front_matter($md, 'page-type') == 'web-api-instance-method' && $member != 'open') {
		$xhr_methods[] = $member;
	}
}
sort($xhr_methods);

$jush = read_file($jush_file);
// static members first so that e.g. Math\.abs wins over Math
$jush = set_list($jush, "'JavaScript/Reference/Global_Objects/\$1': /(", ")/,", array_merge($statics, $objects), 'globals');
$jush = set_list($jush, "'JavaScript/Reference/Statements/\$1': /(", ")/,", $statements, 'statements');
$jush = set_list($jush, "'Web/API/XMLHttpRequest/\$1': /(\\.)(", ")/,", $xhr_methods, 'XMLHttpRequest methods');
preg_match_all("~'JavaScript/Reference/Global_Objects/(\w+)/\\\$1'~", $jush, $matches);
foreach ($matches[1] as $object) {
	sort($instances[$object]);
	$jush = set_list($jush, "'JavaScript/Reference/Global_Objects/$object/\$1': /(\\.)(", ")/,", $instances[$object], "$object members");
}
file_put_contents($jush_file, $jush);

ksort($api);
$jush_api = read_file($jush_api_file);
$jush_api = set_block($jush_api, 'jush.api.js = {', "\n};", $api);
file_put_contents($jush_api_file, $jush_api);
