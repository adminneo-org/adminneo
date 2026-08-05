<?php
// Updates the linked functions, keywords and pragmas in modules/jush-sqlite.js
// from a checkout of https://sqlite.org/docsrc/

require __DIR__ . '/functions.inc.php';

if (!isset($argv[1])) {
	fwrite(STDERR, "Usage: php update/sqlite.php path/to/sqlite-docsrc\n");
	exit(1);
}
$pages = "$argv[1]/pages";
$jush_file = __DIR__ . '/../modules/jush-sqlite.js';

// Get function names from the funcdef calls; one syntax may define several variants, e.g. sum(X) total(X)
function funcdef_names($file) {
	preg_match_all('~^funcdef\s+\{([^}]*)\}~m', read_file($file), $matches);
	$return = [];
	foreach ($matches[1] as $syntax) {
		preg_match_all('~([a-z_][a-z0-9_]*)\(~', $syntax, $names);
		$return = array_merge($return, $names[1]);
	}
	$return = array_unique($return);
	sort($return);
	return $return;
}

$core = funcdef_names("$pages/lang_corefunc.in");
$math = funcdef_names("$pages/lang_mathfunc.in");
$aggregate = funcdef_names("$pages/lang_aggfunc.in");

// Date functions have no funcdef, each is introduced by hd_fragment with a {date() SQL function} keyword
preg_match_all('~^<tcl>hd_fragment \w+ \{(\w+)\(\) SQL function}~m', read_file("$pages/lang_datefunc.in"), $matches);
$date = array_unique($matches[1]);
sort($date);

// JSON functions use tabentry (tabentryop defines the -> and ->> operators)
preg_match_all('~^tabentry \{([^}]*)\}~m', read_file("$pages/json1.in"), $matches);
$json = [];
foreach ($matches[1] as $syntax) {
	preg_match_all('~(\w+)\(~', $syntax, $names);
	$json = array_merge($json, $names[1]);
}
$json = array_unique($json);
sort($json);

// Built-in window functions are a <dl> list after the biwinfunc fragment
$window_page = read_file("$pages/windowfunctions.in");
preg_match_all('~<dt><p><b>(\w+)\(~', substr($window_page, strpos($window_page, 'hd_fragment biwinfunc')), $matches);
$window = array_unique($matches[1]);
sort($window);

// Pragmas are defined by Pragma, LegacyPragma, TestPragma, DebugPragma and DangerousPragma
preg_match_all('~^\w*Pragma\s+\{?(\w+)~m', read_file("$pages/pragma.in"), $matches);
$pragmas = array_unique($matches[1]);
sort($pragmas);

preg_match('~set keyword_list \[lsort \{(.*?)\}~s', read_file("$pages/lang_keywords.in"), $match);
if (!$match) {
	fwrite(STDERR, "Can't find keyword_list in lang_keywords.in\n");
	exit(1);
}
preg_match_all('~[A-Z][A-Z_0-9]*~', $match[1], $matches);
$keywords = array_merge($matches[0], ['EXCLUDED', 'FALSE', 'TRUE']); // not official keywords but the upsert alias and literals are highlighted too
sort($keywords);

$jush = read_file($jush_file);
$jush = set_list($jush, "'windowfunctions.html#\$1': /(", ")(?=", $window, 'window functions');
$jush = set_list($jush, "'lang_corefunc.html#\$1': /(", ")(?=", $core, 'core functions');
$jush = set_list($jush, "'lang_mathfunc.html#\$1': /(", ")(?=", $math, 'math functions');
$jush = set_list($jush, "'lang_datefunc.html#\$1': /(", ")(?=", $date, 'date functions');
$jush = set_list($jush, "'lang_aggfunc.html#\$1': /(", ")(?=", $aggregate, 'aggregate functions');
$jush = set_list($jush, "'json1.html#\$1': /(", ")(?=", $json, 'JSON functions');

// The '' entry holds keywords with no doc page: subtract single words linked by other entries
// (e.g. STRICT, not) but keep words linked only as part of a phrase (e.g. BY in PARTITION\s+BY)
// and words linked only as function calls (e.g. IF is a keyword but if( links to lang_corefunc)
if (!preg_match("~jush\\.build_links2\\('sqlite'.*?\n\\}\\);~s", $jush, $match)) {
	fwrite(STDERR, "Can't find build_links2 block\n");
	exit(1);
}
$covered = [];
preg_match_all("~^\t'([^']*)': /\\((.*)\\)/~m", $match[0], $matches, PREG_SET_ORDER);
foreach ($matches as $entry) {
	if ($entry[1] != '' && strpos($entry[2], '(?=') === false) {
		foreach (explode('|', $entry[2]) as $alternative) {
			if (preg_match('~^\w+$~', $alternative)) {
				$covered[] = strtoupper($alternative);
			}
		}
	}
}
$keywords = array_values(array_diff($keywords, $covered));
$jush = set_list($jush, "'': /(", ")/,", $keywords, 'keywords');

$jush = set_list($jush, "jush.links2.sqliteset = /(\\b)(", ")(\\b)/gi", $pragmas, 'pragmas');
file_put_contents($jush_file, $jush);
