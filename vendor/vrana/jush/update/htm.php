<?php
// Updates the linked tags and attributes in modules/jush-htm.js from a checkout of
// https://github.com/mdn/content
// Usage: php update/htm.php path/to/mdn-content

require __DIR__ . '/functions.inc.php';

if (!isset($argv[1])) {
	fwrite(STDERR, "Usage: php update/htm.php path/to/mdn-content\n");
	exit(1);
}
$reference = "$argv[1]/files/en-us/web/html/reference";
$jush_file = __DIR__ . '/../modules/jush-htm.js';

$tags = array_diff(read_dirs("$reference/elements"), ['heading_elements']); // h1 - h6 are linked by a static entry
$globals = array_diff(read_dirs("$reference/global_attributes"), ['data-_star_']); // data-* has a static entry

$atts = [];
foreach ($tags as $tag) {
	$section = mdn_section(read_file("$reference/elements/$tag/index.md"), 'Attributes');
	// definition lists ("- `alt`", "- [`crossorigin`](...)") and the <input> attribute table ("| [`accept`](#accept) |")
	preg_match_all('~^(?:- |\| )\[?`([-\w]+)`~m', $section, $matches);
	$atts = array_merge($atts, $matches[1]);
}
$atts = array_diff(array_unique($atts), $globals); // global attributes are linked by the entry above them
sort($atts);

$jush = read_file($jush_file);
$jush = set_list($jush, "jush.links.tag = {\n\t'Elements/Heading_Elements': /^(h[1-6])\$/i,\n\t'Elements/\$val': /^(", ")\$/i", $tags, 'tags');
$jush = set_list($jush, "jush.links.att = {\n\t'Global_attributes/\$val': /^(", ")\$/i", $globals, 'global attributes');
$jush = set_list($jush, "'Elements/\$tag#\$val': /^(", ")\$/i", $atts, 'attributes');
file_put_contents($jush_file, $jush);
