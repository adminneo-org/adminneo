<?php

namespace AdminNeo;

require __DIR__ . "/../../admin/include/functions.inc.php";

$errors = 0;

// [description => [names, references, expected]]
$tests = [
	'no references' => [
		['zebra', 'apple'],
		[],
		['zebra', 'apple'], // original order is kept
	],
	'child before parent' => [
		['aaa_child', 'zzz_parent'],
		['aaa_child' => ['zzz_parent']],
		['zzz_parent', 'aaa_child'],
	],
	'parent before child' => [
		['aaa_parent', 'zzz_child'],
		['zzz_child' => ['aaa_parent']],
		['aaa_parent', 'zzz_child'],
	],
	'chain' => [
		['c', 'b', 'a'],
		['c' => ['b'], 'b' => ['a']],
		['a', 'b', 'c'],
	],
	'diamond' => [
		['d', 'c', 'b', 'a'],
		['d' => ['b', 'c'], 'b' => ['a'], 'c' => ['a']],
		['a', 'b', 'c', 'd'],
	],
	'several references to the same table' => [
		['b', 'a'],
		['b' => ['a', 'a']],
		['a', 'b'],
	],
	'reference to an unknown table' => [
		['b', 'a'],
		['b' => ['unknown'], 'a' => ['unknown']],
		['b', 'a'],
	],
	'reference to a table in a different schema is ignored' => [
		['b', 'a'],
		['b' => ['other.a'], 'a' => []],
		['b', 'a'],
	],
	// Cyclic references - the tables cannot be ordered.
	'self reference' => [
		['a'],
		['a' => ['a']],
		null,
	],
	'self reference among orderable tables' => [
		['c', 'b', 'a'],
		['c' => ['b'], 'b' => ['a'], 'a' => ['a']],
		null,
	],
	'cycle of two tables' => [
		['a', 'b'],
		['a' => ['b'], 'b' => ['a']],
		null,
	],
	'cycle of three tables' => [
		['a', 'b', 'c'],
		['a' => ['b'], 'b' => ['c'], 'c' => ['a']],
		null,
	],
	// Only the exported tables have references, so a cycle outside of them is not detected.
	'cycle without references' => [
		['a', 'b'],
		[],
		['a', 'b'],
	],
];

foreach ($tests as $description => $test) {
	list($names, $references, $expected) = $test;

	$actual = dump_table_order($names, $references);
	if ($actual !== $expected) {
		echo "⚠️ $description results in " . ($actual === null ? "null" : implode(", ", $actual)) . "\n";
		$errors++;
	}
}

exit($errors ? 1 : 0);
