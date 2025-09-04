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

if (!function_exists('random_bytes') && extension_loaded('libsodium')) {

	if (function_exists('\\Sodium\\randombytes_buf'))
	{
		function random_bytes(int $bytes) : string
		{
			return Sodium\randombytes_buf($bytes);
		}
	}
	elseif (class_exists('Sodium') && method_exists('Sodium', 'randombytes_buf'))
	{
		function random_bytes(int $bytes) : string
		{
			return Sodium::randombytes_buf($bytes);
		}
	}
}

if (
	!function_exists('random_bytes')
	// https://www.youtube.com/watch?v=dFUlAQZB9Ng
	&& DIRECTORY_SEPARATOR === '/'
	&& is_readable('/dev/urandom')
) {

	function random_bytes(int $bytes) : string
	{
		static $handle;

		if (!is_resource($handle)) {
			$handle = fopen('/dev/urandom', 'rb');
		}
		if (!is_resource($handle)) {
			throw new Exception('failed to open /dev/urandom');
		}

		$remaining = $bytes;
		$out = '';

		do {
			$read = fread($handle, $remaining);

			// todo: make sure strlen is safe here
			$remaining -= strlen($read);

			$out .= $read;
		} while ($remaining > 0);

		return $out;
	}
}

if (!function_exists('random_bytes') && extension_loaded('openssl')) {

	openssl_random_pseudo_bytes(4, $wasSecure);

	if ($wasSecure) {
		function random_bytes(int $bytes) : string
		{
			return openssl_random_pseudo_bytes($bytes);
		}
	}
}

if (
	!function_exists('random_bytes')
	&& (DIRECTORY_SEPARATOR !== '/' || ( // Windows OR
		// https://bugs.php.net/bug.php?id=69833
		PHP_VERSION_ID <= 50609 || PHP_VERSION_ID >= 50613)
	)
	&& extension_loaded('mcrypt')
)  {
	function random_bytes(int $bytes) : string
	{
		return mcrypt_create_iv($bytes, MCRYPT_DEV_URANDOM);
	}
}

if (
	!function_exists('random_bytes')
	&& DIRECTORY_SEPARATOR !== '/' // Windows
	&& class_exists('COM')
) {

	function random_bytes(int $bytes) : string
	{
		$util = new COM('CAPICOM.Utilities.1');
		$out = '';

		do {
			$out .= base64_decode($com->GetRandom($bytes, 0));
		} while (strlen($out) < $bytes);

		return substr($out, $bytes);
	}
}

if (!function_exists('random_bytes')) {
	function random_bytes(int $bytes) : string
	{
		throw new Exception('Please do something');
	}
}
