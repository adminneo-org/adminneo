<?php
// Updates the linked methods and headers in modules/jush-http.js from a
// checkout of https://github.com/mdn/content
// Usage: php update/http.php path/to/mdn-content

require __DIR__ . '/functions.inc.php';

if (!isset($argv[1])) {
	fwrite(STDERR, "Usage: php update/http.php path/to/mdn-content\n");
	exit(1);
}
$reference = "$argv[1]/files/en-us/web/http/reference";
$jush_file = __DIR__ . '/../modules/jush-http.js';

// Get canonical-case names from the front matter slugs (dir names are lowercased)
function read_slugs($path) {
	$return = [];
	foreach (read_dirs($path) as $dir) {
		$return[] = basename(front_matter(read_file("$path/$dir/index.md"), 'slug'));
	}
	sort($return);
	return $return;
}

$methods = read_slugs("$reference/methods");
$headers = read_slugs("$reference/headers");

$jush = read_file($jush_file);
$jush = set_list($jush, "'Methods/\$1': /(", ")/,", $methods, 'methods');
$jush = set_list($jush, "'Headers/\$1': /(", ")/,", $headers, 'headers');
file_put_contents($jush_file, $jush);
