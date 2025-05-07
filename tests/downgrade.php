#!/usr/bin/env php
<?php

namespace AdminNeo;

include __DIR__ . "/../admin/include/compile.inc.php";

function check(string $code, string $expected): void
{
	$result = downgrade_php($code);

	if ($result != $expected) {
		$backtrace = debug_backtrace()[0];

		$file_path = basename($backtrace["file"]);
		echo "⚠️ $file_path:{$backtrace['line']} => $result\n";
	}
}

// Null coalescing.
check('$a ?? 1', 'isset($a) ? $a : 1');
check('$a[1] ?? 1', 'isset($a[1]) ? $a[1] : 1');
check('$a[1][1] ?? 1', 'isset($a[1][1]) ? $a[1][1] : 1');
check('$a[$b] ?? 1', 'isset($a[$b]) ? $a[$b] : 1');
check('$a[$b[1]] ?? 1', 'isset($a[$b[1]]) ? $a[$b[1]] : 1');
check('$a[$b[1] + 1] ?? 1', 'isset($a[$b[1] + 1]) ? $a[$b[1] + 1] : 1');

check('$this->a ?? 1', 'isset($this->a) ? $this->a : 1');
check('self::$a[1] ?? 1', 'isset(self::$a[1]) ? self::$a[1] : 1');
check('self::a[1] ?? 1', 'isset(self::a[1]) ? self::a[1] : 1');

check('f() ?? 1', '($_result = f()) !== null ? $_result : 1');
check('f($a) ?? 1', '($_result = f($a)) !== null ? $_result : 1');
check('f($a[1], $b) ?? 1', '($_result = f($a[1], $b)) !== null ? $_result : 1');

check('$this->f() ?? 1', '($_result = $this->f()) !== null ? $_result : 1');
check('self::f($a[1], $b) ?? 1', '($_result = self::f($a[1], $b)) !== null ? $_result : 1');

// Unsupported.
check('$a[$b[$c[1]]] ?? 1', '$a[$b[$c[1]]] ?? 1');
check('$a[f()] ?? 1', '$a[f()] ?? 1');
check('f(g()) ?? null', 'f(g()) ?? null');

// Constants.
check('public const A = 1; $a = self::A;', 'public static $A = 1; $a = self::$A;');
check('private const A = []; $a = self::A[1]; $a = self::A;', 'private static $A = []; $a = self::$A[1]; $a = self::$A;');

// Arrays unpacking.
check('[$a, $b] = $c', 'list($a, $b) = $c');
check('([$a, $b] = $c)', '(list($a, $b) = $c)');
