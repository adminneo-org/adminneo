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
