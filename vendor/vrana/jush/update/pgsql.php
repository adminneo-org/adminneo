<?php
// Updates the linked statements, functions, keywords and config variables in modules/jush-pgsql.js
// from a checkout of the latest stable branch (REL_*_STABLE) of https://github.com/postgres/postgres

require __DIR__ . '/functions.inc.php';

if (!isset($argv[1])) {
	fwrite(STDERR, "Usage: php update/pgsql.php path/to/postgres\n");
	exit(1);
}
$sgml = "$argv[1]/doc/src/sgml";
$jush_file = __DIR__ . '/../modules/jush-pgsql.js';
$jush = read_file($jush_file);

// Get statement names from a regexp alternation, expanding ALTER\s+USER(?:\s+MAPPING)? style options
function statement_names($alternation) {
	$return = [];
	foreach (explode('|', str_replace('\\s+', ' ', $alternation)) as $alternative) {
		if (preg_match('~^([A-Z ]+)\(\?:( [A-Z ]+)\)\?$~', $alternative, $match)) {
			$return[] = $match[1];
			$return[] = $match[1] . $match[2];
		} else {
			$return[] = $alternative;
		}
	}
	return $return;
}

// Statements are documented one page per refentry; 'sql-$1.html' covers the pages whose name
// is the statement lowercased with spaces removed, 'sql$1.html' covers the pages with spaces
// turned into dashes (jush.js decides by the key), the rest needs explicit entries
$phrases = [];
$hyphens = [];
$explicit = [];
foreach (glob("$sgml/ref/*.sgml") as $file) {
	$ref = read_file($file);
	if (!preg_match('~<refentry id="(sql-[^"]+)"~', $ref, $match)) {
		continue; // client applications
	}
	$id = $match[1];
	preg_match_all('~<refname>([^<]+)</refname>~', $ref, $matches);
	foreach ($matches[1] as $name) {
		if ($id == 'sql-' . strtolower(str_replace(' ', '', $name))) {
			$phrases[] = $name;
		} elseif ($id == 'sql-' . strtolower(str_replace(' ', '-', $name))) {
			$hyphens[] = $name;
		} elseif (strpos($name, ' ')) {
			$explicit["$id.html"][] = $name; // abbreviated pages like sql-altertsconfig.html
		}
		// single-word aliases of another page (TABLE and WITH are described under sql-select) stay plain keywords
	}
}
if (!$phrases || !$hyphens || !$explicit) {
	fwrite(STDERR, "No statements found in $sgml/ref\n");
	exit(1);
}
$lines = '';
ksort($explicit);
foreach ($explicit as $page => $names) {
	$lines .= "\t'" . $page . "': /(" . phrases_regexp($names) . ")/,\n";
}
$lines .= "\t'sql\$1.html': /(" . phrases_regexp($hyphens) . ")/,\n";
$lines .= "\t'sql-\$1.html': /(" . phrases_regexp($phrases) . ")/,\n";

// Explicit entries go first so that e.g. ALTER\s+OPERATOR\s+CLASS wins over ALTER\s+OPERATOR
preg_match_all("~^\t'sql[^']*\.html': /\\((.*)\\)/,\n~m", $jush, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);
if (!$matches) {
	fwrite(STDERR, "Can't find statement entries\n");
	exit(1);
}
$old = [];
$start = $matches[0][0][1];
foreach (array_reverse($matches) as $match) {
	$old = array_merge($old, statement_names($match[1][0]));
	$jush = substr_replace($jush, '', $match[0][1], strlen($match[0][0]));
}
$jush = substr_replace($jush, $lines, $start, 0);
$new = array_merge($phrases, $hyphens, ...array_values($explicit));
sort($old);
sort($new);
report_diff('statements', $old, $new);

// Function names appear as <function>name</function>( in signature tables and synopses
function function_names($section) {
	preg_match_all('~<para role="func_signature">.*?</para>|<synopsis>.*?</synopsis>~s', $section, $matches);
	$return = [];
	foreach ($matches[0] as $block) {
		preg_match_all('~<function>(\w+)</function>\s*\(~', $block, $names);
		$return = array_merge($return, array_map('strtolower', $names[1]));
	}
	$return = array_unique($return);
	sort($return);
	return $return;
}

// Replace the function list in the (?:...)(?=\s*\(|$) group of a 'functions-*.html' entry,
// dropping names already linked by the keyword part of the entry (e.g. current_date)
function set_functions($jush, $page, array $names) {
	$start = strpos($jush, "'$page': /(");
	$end = strpos($jush, "\n", $start);
	$entry = substr($jush, $start, $end - $start);
	$keywords = explode('|', preg_replace('~\(\?:.*~s', '', $entry));
	$names = array_values(array_diff($names, $keywords));
	$entry = set_list($entry, '(?:', ')(?=', $names, "$page functions");
	return substr_replace($jush, $entry, $start, $end - $start);
}

preg_match_all('~<sect1 id="(functions-[\w-]+)"(.*?)</sect1>~s', read_file("$sgml/func.sgml"), $matches, PREG_SET_ORDER);
if (!$matches) {
	fwrite(STDERR, "Can't find function sections in func.sgml\n");
	exit(1);
}
$append = '';
foreach ($matches as $match) {
	$page = "$match[1].html";
	$names = function_names($match[2]);
	if (!$names) {
		continue; // keyword-only pages like functions-logical
	}
	if (strpos($jush, "'$page': /(") !== false) {
		$jush = set_functions($jush, $page, $names);
	} else {
		$append .= "\t'$page': /((?:" . implode('|', $names) . ")(?=\\s*\\(|\$))/,\n";
		fwrite(STDERR, "Added $page: " . implode(', ', $names) . "\n");
	}
}
if ($append != '') {
	// Append new pages last so that already linked names (e.g. length in functions-string) keep their entry
	$start = strpos($jush, "\n});", strpos($jush, "jush.build_links2('pgsql',"));
	$jush = substr_replace($jush, $append, $start + 1, 0);
}

// Only reserved and type/function-name keywords are highlighted, others can be used as identifiers
preg_match_all('~^PG_KEYWORD\("(\w+)", \w+, (?:RESERVED|TYPE_FUNC_NAME)_KEYWORD~m', read_file("$argv[1]/src/include/parser/kwlist.h"), $matches);
if (!$matches[1]) {
	fwrite(STDERR, "Can't find keywords in kwlist.h\n");
	exit(1);
}
$keywords = array_map('strtoupper', $matches[1]);
sort($keywords);

// The '' entry holds keywords with no doc page: subtract single words linked by other entries
// (e.g. SELECT or BETWEEN) but keep words linked only as part of a phrase (e.g. TO in SET\s+ROLE)
// and words linked only as function calls (e.g. LEFT is a keyword but left( links to functions-string)
if (!preg_match("~jush\\.build_links2\\('pgsql'.*?\n\\}\\);~s", $jush, $match)) {
	fwrite(STDERR, "Can't find build_links2 block\n");
	exit(1);
}
$covered = [];
preg_match_all("~^\t'([^']*)': /\\((.*)\\)/~m", $match[0], $matches, PREG_SET_ORDER);
foreach ($matches as $entry) {
	if ($entry[1] != '') {
		foreach (explode('|', preg_replace('~\(\?:.*~s', '', $entry[2])) as $alternative) {
			if (preg_match('~^\w+$~', $alternative)) {
				$covered[] = strtoupper($alternative);
			}
		}
	}
}
$keywords = array_values(array_diff($keywords, $covered));
$jush = set_list($jush, "'': /(", ")/,", $keywords, 'keywords');

// Config variables are grouped by the runtime-config-* page; the ssl_ciphers value descriptions
// also have a guc- id but no xreflabel
preg_match_all('~<sect1 id="runtime-config-([\w-]+)"(.*?)</sect1>~s', read_file("$sgml/config.sgml"), $matches, PREG_SET_ORDER);
$sections = [];
foreach ($matches as $match) {
	preg_match_all('~<varlistentry id="guc-[\w-]+"\s+xreflabel="(\w+)"~', $match[2], $names);
	if ($names[1]) {
		$list = array_unique($names[1]);
		sort($list);
		$sections[$match[1]] = $list;
	}
}
if (!$sections) {
	fwrite(STDERR, "Can't find config variables in config.sgml\n");
	exit(1);
}
ksort($sections);

$start = strpos($jush, "jush.build_links2('pgsqlset'");
$start = strpos($jush, "{\n", $start) + 2;
$end = strpos($jush, "});", $start);
preg_match_all("~^\t'([\w-]+)': /\\((.*)\\)/~m", substr($jush, $start, $end - $start), $matches, PREG_SET_ORDER);
$old = [];
foreach ($matches as $entry) {
	$old[$entry[1]] = explode('|', $entry[2]);
}
report_diff('config sections', array_keys($old), array_keys($sections));
report_diff('config variables', array_merge(...array_values($old)), array_merge(...array_values($sections)));
$lines = '';
foreach ($sections as $key => $names) {
	$lines .= "\t'$key': /(" . implode('|', $names) . ")/,\n";
}
$jush = substr_replace($jush, $lines, $start, $end - $start);

file_put_contents($jush_file, $jush);
