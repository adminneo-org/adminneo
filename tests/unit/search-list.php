<?php

namespace AdminNeo;

require __DIR__ . "/../../admin/include/functions.inc.php";

$errors = 0;

// [list, expected]
$tests = [
	'empty' => ["", []],
	'spaces' => ["  ", []],
	'number' => ["1", ["1"]],
	'numbers' => ["1,-2.5", ["1", "-2.5"]],
	'spaces around' => [" 1 , 2 ", ["1", "2"]],
	'parentheses' => ["(1,2)", ["1", "2"]],
	'spaces around parentheses' => [" ( 1, 2 ) ", ["1", "2"]],
	'empty parentheses' => ["()", []],
	'unpaired parenthesis' => ["(1,2", ["(1", "2"]],
	'parentheses inside' => ["(1),(2)", ["1)", "(2"]],
	'bare words' => ["a, b c", ["a", "b c"]],
	'empty elements' => ["1,,2,", ["1", "2"]],
	'quoted' => ["'a','b'", ["a", "b"]],
	'quoted in parentheses' => ["('a', 'b')", ["a", "b"]],
	'quoted empty' => ["'',''", ["", ""]],
	'quoted comma and spaces' => ["' a,b ',c", [" a,b ", "c"]],
	'quoted parentheses' => ["'(a)','b)'", ["(a)", "b)"]],
	'doubled apostrophe' => ["'it''s','''',''''''", ["it's", "'", "''"]],
	'quoted new line' => ["'a\nb'", ["a\nb"]],
	'mixed' => ["1, 'a', b", ["1", "a", "b"]],
	'backslash is not special' => ["'C:\\','a\\\\b'", ["C:\\", "a\\\\b"]],
	'backslash before apostrophe' => ["'x\\') OR 1=1 --'", ["'x\\') OR 1=1 --'"]],
	'backslash before apostrophe in list' => ["'a\\','b' OR 1=1 --", ["a\\", "'b' OR 1=1 --"]],
	'unclosed apostrophe' => ["'a,b", ["'a", "b"]],
	'text after apostrophe' => ["'a'b,c", ["'a'b", "c"]],
	'bare apostrophe' => ["O'Brien,Smith", ["O'Brien", "Smith"]],
];

foreach ($tests as $name => list($list, $expected)) {
	$actual = parse_search_list($list);
	if ($actual !== $expected) {
		echo "⚠️ $name results in " . json_encode($actual) . "\n";
		$errors++;
	}
}

// Every part of the list must end up in a value, whatever is sent.
$long = str_repeat("a" . str_repeat(" ", 5000) . "'", 20);
if (parse_search_list($long) !== [trim($long)]) {
	echo "⚠️ long value is not parsed\n";
	$errors++;
}

exit($errors ? 1 : 0);
