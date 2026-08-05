<?php
// Updates the linked at-rules, properties and selectors in modules/jush-css.js from a
// checkout of https://github.com/mdn/content
// Usage: php update/css.php path/to/mdn-content

require __DIR__ . '/functions.inc.php';

if (!isset($argv[1])) {
	fwrite(STDERR, "Usage: php update/css.php path/to/mdn-content\n");
	exit(1);
}
$reference = "$argv[1]/files/en-us/web/css/reference";
$jush_file = __DIR__ . '/../modules/jush-css.js';

$ats = [];
foreach (read_dirs("$reference/at-rules") as $dir) {
	if ($dir[0] == '@') { // skips at-rule_functions
		$ats[] = substr($dir, 1);
	}
}

$properties = array_diff(read_dirs("$reference/properties"), ['--_star_']); // custom properties are not linked

$classes = [];
$elements = [];
foreach (read_dirs("$reference/selectors") as $dir) {
	// _ encodes arguments, e.g. _colon_host_function or _colon_-moz-locale-dir_ltr - these forms never match plain text
	if (preg_match('~^_colon_([^_]+)$~', $dir, $match)) {
		$classes[] = $match[1];
	} elseif (preg_match('~^_doublecolon_([^_]+)$~', $dir, $match)) {
		$elements[] = $match[1];
	}
}

$jush = read_file($jush_file);
$jush = set_list($jush, "jush.links.css_at = {\n\t'@\$val': /^(", ")\$/i", $ats, 'at-rules');
$jush = set_list($jush, "jush.links.css_val = {\n\t'\$val': /^(", ")\$/i", $properties, 'properties');
$jush = set_list($jush, "':\$1': /(", ")/,", $classes, 'pseudo-classes');
$jush = set_list($jush, "'::\$1': /(:)(", ")/,", $elements, 'pseudo-elements');
file_put_contents($jush_file, $jush);
