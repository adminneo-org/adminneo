<?php

namespace AdminNeo;

require __DIR__ . "/../../admin/include/functions.inc.php";

$errors = 0;

$tests = [
	'a + b' => '(a + b)', // MariaDB, SQLite
	'(a + b)' => '(a + b)', // PostgreSQL
	'(`a` + `b`)' => '(`a` + `b`)', // MySQL
	'([a]+[b])' => '([a]+[b])', // MS SQL
	'coalesce(a, 0)' => '(coalesce(a, 0))',
	'(a) + (b)' => '((a) + (b))',
	'((a) + (b))' => '((a) + (b))',
	// parentheses in string literals and quoted identifiers
	"(a || ')')" => "(a || ')')",
	"concat('(', a, ')')" => "(concat('(', a, ')'))",
	"('it''s)')" => "('it''s)')",
	'("x)" + 1)' => '("x)" + 1)',
	'(`x)` + 1)' => '(`x)` + 1)',
	'([x)]+1)' => '([x)]+1)',
];

foreach ($tests as $expression => $expected) {
	$actual = parenthesize_expression($expression);
	if ($actual !== $expected) {
		echo "⚠️ $expression results in $actual\n";
		$errors++;
	}
}

exit($errors ? 1 : 0);
