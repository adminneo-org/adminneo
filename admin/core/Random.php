<?php

namespace AdminNeo;

use RuntimeException;

class Random
{
	/**
	 * Returns requested amount of random bytes.
	 *
	 * @return string A binary string.
	 *
	 * @throws \Random\RandomException
	 * @throws RuntimeException
	 */
	public static function bytes(int $length): string
	{
		if (PHP_VERSION_ID >= 70000) {
			// There is an astronomically low chance of this throwing an exception. If it happens, the exception is
			// purposefully not caught, because it means that there is something very wrong in the system, and it cannot
			// be trusted to do TLS securely either.
			return random_bytes($length);
		}

		$result = self::tryAlternatives($length);
		if ($result === false) {
			$result = self::lastResortRandom($length);
		}

		if ($result === false) {
			throw new RuntimeException("Error generating random bytes");
		}

		return $result;
	}

	/**
	 * @return string|false
	 */
	private static function tryAlternatives(int $length)
	{
		if (extension_loaded('sodium') || extension_loaded('libsodium')) {
			if (function_exists('sodium_randombytes_buf')) {
				return sodium_randombytes_buf($length);
			}
			if (function_exists('\\Sodium\\randombytes_buf')) {
				return \Sodium\randombytes_buf($length);
			}
		}

		$unix = DIRECTORY_SEPARATOR === '/';

		if ($unix && @is_readable('/dev/urandom')) {
			$result = self::readDevUrandom($length);
			if ($result !== false) {
				return $result;
			}
		}

		// https://bugs.php.net/bug.php?id=69833
		$bug69833 = $unix && PHP_VERSION_ID > 50609 && PHP_VERSION_ID < 50613;

		if (extension_loaded('mcrypt') && !$bug69833) {
			// MCRYPT_DEV_URANDOM means "something secure" provided by the os.
			// It's something completely else on Windows.
			$out = mcrypt_create_iv($length, MCRYPT_DEV_URANDOM);
			if ($out !== false && strlen($out) == $length) {
				return $out;
			}
		}

		/* Commented out until tested
		if (!$unix && extension_loaded('com_dotnet') && class_exists('COM'))
		{
			return self::readCapicom($length);
		}
		*/

		// https://bugs.php.net/bug.php?id=70014
		$bug70014 = PHP_VERSION_ID < 50444 || (PHP_VERSION_ID > 50500 && PHP_VERSION_ID < 50528) || (PHP_VERSION_ID > 50600 && PHP_VERSION_ID < 50612);

		if (extension_loaded('openssl') && !$bug70014) {
			$out = openssl_random_pseudo_bytes($length, $wasSecure);
			if ($wasSecure) {
				return $out;
			}
		}

		// No reliable source of randomness was found.
		return false;
	}

	/**
	 * @return string|false
	 */
	private static function readDevUrandom(int $length)
	{
		static $handle = null;

		if ($handle === null) {
			$handle = fopen('/dev/urandom', 'rb');
		}
		if (!$handle) {
			return false;
		}

		$remaining = $length;
		$out = '';

		do {
			$in = fread($handle, $remaining);
			if ($in === false) {
				return false;
			}

			$remaining -= strlen($in);
			$out .= $in;
		} while ($remaining > 0);

		return substr($out, 0, $length);
	}

	/**
	 * @return string|false
	 */
	private static function readCapicom(int $length)
	{
		$com = new \COM('CAPICOM.Utilities.1');

		$remaining = $length;
		$out = '';

		do {
			$in = base64_decode((string)$com->GetRandom($length, 0));
			$remaining -= strlen($in);
			$out .= $in;
		} while ($remaining > 0);

		return substr($out, 0, $length);
	}

	/**
	 * @return string|false
	 */
	private static function lastResortRandom(int $length)
	{
		static $state = null;

		if ($state === null) {
			$a = $_SERVER;
			$a[] = uniqid('', true);
			shuffle($a);

			// See referenced bug 70014 above.
			if (extension_loaded('openssl')) {
				$b = openssl_random_pseudo_bytes(20);
			} else {
				$b = '';
				for ($i = 0; $i < 20; $i++) {
					$b .= chr((mt_rand() ^ mt_rand()) % 256);
				}
			}

			$state = [
				sha1(serialize($a), true),
				$b
			];
		} else {
			if ((ord($state[0]) % 2 === 0) === (ord($state[1]) % 2 === 0)) {
				$state[0] = Hash::hmacSha1($state[0], $state[1]);
			} else {
				$state[1] = Hash::hmacSha1($state[1], $state[0]);
			}
		}

		return Hash::hkdf($length, $state[0], (string)$length, $state[1]);
	}
}
