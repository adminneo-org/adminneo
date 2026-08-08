<?php

namespace AdminNeo;

require __DIR__ . "/../../vendor/vrana/phpshrink/phpShrink.php";
require __DIR__ . "/../../admin/include/compile.inc.php";

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
check('$a  ??1', 'isset($a) ? $a :1');
check('$a[1] ?? 1', 'isset($a[1]) ? $a[1] : 1');
check('$a[1][1] ?? 1', 'isset($a[1][1]) ? $a[1][1] : 1');
check('$a[$b] ?? 1', 'isset($a[$b]) ? $a[$b] : 1');
check('$a[$b[1]] ?? 1', 'isset($a[$b[1]]) ? $a[$b[1]] : 1');
check('$a[$b[1] + 1] ?? 1', 'isset($a[$b[1] + 1]) ? $a[$b[1] + 1] : 1');

check('$a->a ?? 1', 'isset($a->a) ? $a->a : 1');
check('$a->a->a ?? 1', 'isset($a->a->a) ? $a->a->a : 1');
check('self::$a[1] ?? 1', 'isset(self::$a[1]) ? self::$a[1] : 1');
check('self::a[1] ?? 1', 'isset(self::a[1]) ? self::a[1] : 1');
check('A::$a ?? 1', 'isset(A::$a) ? A::$a : 1');
check('A::a ?? 1', 'isset(A::a) ? A::a : 1');
check('A::a[1] ?? 1', 'isset(A::a[1]) ? A::a[1] : 1');
check('static::a ?? 1', 'isset(static::a) ? static::a : 1');
check('parent::a ?? 1', 'isset(parent::a) ? parent::a : 1');
check('\A::a ?? 1', 'isset(\A::a) ? \A::a : 1');
check('\A\B::a ?? 1', 'isset(\A\B::a) ? \A\B::a : 1');

check('f() ?? 1', '($_result = f()) !== null ? $_result : 1');
check('f($a) ?? 1', '($_result = f($a)) !== null ? $_result : 1');
check('f($a[1], $b) ?? 1', '($_result = f($a[1], $b)) !== null ? $_result : 1');

check('$a->f() ?? 1', '($_result = $a->f()) !== null ? $_result : 1');
check('$a->p->f() ?? 1', '($_result = $a->p->f()) !== null ? $_result : 1');
check('self::f($a[1], $b) ?? 1', '($_result = self::f($a[1], $b)) !== null ? $_result : 1');
check('A::f() ?? 1', '($_result = A::f()) !== null ? $_result : 1');
check('A::f($a[1], $b) ?? 1', '($_result = A::f($a[1], $b)) !== null ? $_result : 1');
check('static::f() ?? 1', '($_result = static::f()) !== null ? $_result : 1');
check('parent::f() ?? 1', '($_result = parent::f()) !== null ? $_result : 1');
check('\A::f() ?? 1', '($_result = \A::f()) !== null ? $_result : 1');
check('\A\B::f() ?? 1', '($_result = \A\B::f()) !== null ? $_result : 1');

check('f($a ?? 1)', 'f(isset($a) ? $a : 1)');
check('f($a->f() ?? 1, 2)', 'f(($_result = $a->f()) !== null ? $_result : 1, 2)');

// Null coalescing chains - the tail must be parenthesized, the ternary operator is left associative.
check('$a ?? $b ?? null', 'isset($a) ? $a : (isset($b) ? $b : null)');
check('$a ?? $b ?? $c ?? null', 'isset($a) ? $a : (isset($b) ? $b : (isset($c) ? $c : null))');
check('$a ?? $b ?? $c ?? $d ?? 0', 'isset($a) ? $a : (isset($b) ? $b : (isset($c) ? $c : (isset($d) ? $d : 0)))');
check('$a[1] ?? $b->c ?? A::d ?? \'\'', 'isset($a[1]) ? $a[1] : (isset($b->c) ? $b->c : (isset(A::d) ? A::d : \'\'))');
check('A::f() ?? $a ?? null', '($_result = A::f()) !== null ? $_result : (isset($a) ? $a : null)');
check('f($a) ?? g() ?? false', '($_result = f($a)) !== null ? $_result : (($_result = g()) !== null ? $_result : false)');

// Already parenthesized chains are not changed.
check('$a ?? ($b ?? null)', 'isset($a) ? $a : (isset($b) ? $b : null)');

// Unsupported.
check('$a[$b[$c[1]]] ?? 1', '$a[$b[$c[1]]] ?? 1');
check('$a[f()] ?? 1', '$a[f()] ?? 1');
check('$a->a[b()] ?? 1', '$a->a[b()] ?? 1');
check('f(g()) ?? null', 'f(g()) ?? null');

// Constants.
check('public const A = 1; $a = self::A;', 'public static $A = 1; $a = self::$A;');
check('private const A = []; $a = self::A[1]; $a = self::A;', 'private static $A = []; $a = self::$A[1]; $a = self::$A;');

// Arrays unpacking.
check('[$a, $b] = $c', 'list($a, $b) = $c');
check('([$a, $b] = $c)', '(list($a, $b) = $c)');

// Class names.
check('A::class', '\'\AdminNeo\A\'');
check('\A::class', '\'\A\'');
check('\A\B::class', '\'\A\B\'');
