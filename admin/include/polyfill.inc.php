<?php

if (!function_exists("str_starts_with")) {
	function str_starts_with(string $haystack, string $needle): bool
	{
		return strpos($haystack, $needle) === 0;
	}
}

if (!function_exists("str_contains")) {
	function str_contains(string $haystack, string $needle): bool
	{
		return strpos($haystack, $needle) !== false;
	}
}

if (!function_exists("password_verify")) {
	function password_verify(string $password, string $hash): bool
	{
		return false;
	}
}

// ini_set() can be disabled by disable_functions.
if (!function_exists("ini_set")) {
	function ini_set(string $option, $value): bool
	{
		return false;
	}
}
