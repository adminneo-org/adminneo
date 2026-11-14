<?php

namespace AdminNeo;

require __DIR__ . "/../../admin/include/functions.inc.php";

$errors = 0;

$valid = ["col" => "id", "op" => "=", "val" => "1"];
$list = ["col" => "kind", "val" => ["a", "b"]];

// [conditions, list columns, expected]
$tests = [
	'not sent' => [null, [], []],
	'empty' => [[], [], []],
	'valid' => [[$valid], [], [$valid]],
	'anywhere' => [[["col" => "", "op" => "LIKE %%", "val" => "a"]], [], [["col" => "", "op" => "LIKE %%", "val" => "a"]]],
	'missing keys' => [[["val" => "a"], []], [], [["val" => "a"], []]],
	'preserved keys' => [[-1 => $valid, 5 => $valid, "x" => $valid], [], [-1 => $valid, 5 => $valid, "x" => $valid]],
	'scalar where' => ["abc", [], []],
	'scalar row' => [["abc", $valid], [], [1 => $valid]],
	'array col' => [[["col" => ["a"], "op" => "=", "val" => "1"]], [], []],
	'array op' => [[["col" => "id", "op" => ["="], "val" => "1"]], [], []],
	'list val' => [[$list], [], []],
	'list val in a list column' => [[$list], ["kind"], [$list]],
	'list val in a numeric list column' => [[["col" => "1", "val" => ["a"]]], [1], [["col" => "1", "val" => ["a"]]]],
	'list val in another column' => [[$list], ["other"], []],
	'list val anywhere' => [[["col" => "", "val" => ["a"]]], ["kind"], []],
	'nested list val' => [[["col" => "kind", "val" => [["a"]]]], ["kind"], []],
];

foreach ($tests as $name => list($conditions, $list_columns, $expected)) {
	$actual = validate_search_conditions($conditions, $list_columns);
	if ($actual !== $expected) {
		echo "⚠️ $name results in " . json_encode($actual) . "\n";
		$errors++;
	}
}

exit($errors ? 1 : 0);
