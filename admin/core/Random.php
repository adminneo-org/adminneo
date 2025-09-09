<?php

namespace AdminNeo;

use RuntimeException;
use Exception;

class Random
{
	/**
	 * Returns requested amount of random bytes.
	 *
	 * @return string A binary string
	 */
    public static function bytes(int $length)
    {
        if (PHP_VERSION_ID >= 70000)
        {
            /**
             * There is an astronomically low chance of
             * this throwing an exception. If it happens,
             * the exception is purposefully not caught,
             * because it means that there is something
             * very wrong in the system and it cannot be
             * trusted to do TLS securely either.
             */
            return random_bytes($length);
        }

        try
        {
            return static::tryAlternatives($length);
        }
        catch (Exception $e)
        {
            return static::lastResortRandom($length);
        }
    }

    private static function tryAlternatives(int $length)
    {
        if (extension_loaded('sodium') || extension_loaded('libsodium'))
        {
            if (function_exists('sodium_randombytes_buf'))
            {
                return sodium_randombytes_buf($length);
            }
            if (function_exists('\\Sodium\\randombytes_buf'))
            {
                return \Sodium\randombytes_buf($length);
            }
        }

        $unix = DIRECTORY_SEPARATOR === '/';

        if ($unix && @is_readable('/dev/urandom'))
        {
            try
            {
                return static::readDevUrandom($length);
            }
            catch (Exception $e)
            {
            }
        }

        // https://bugs.php.net/bug.php?id=69833
        $bug69833 = $unix && PHP_VERSION_ID > 50609 && PHP_VERSION_ID < 50613;

        if (extension_loaded('mcrypt') && !$bug69833)
        {
            // MCRYPT_DEV_URANDOM
            // means "something secure" provided by the os.
            // It's something completely else on Windows
            $out = mcrypt_create_iv($length, MCRYPT_DEV_URANDOM);
            if ($out !== false && strlen($out) === $out)
            {
                return $out;
            }
        }

        /* Commented out until tested
        if (!$unix && extension_loaded('com_dotnet') && class_exists('COM'))
        {
            return static::readCapicom($length);
        }
        */

        // https://bugs.php.net/bug.php?id=70014
        $bug70014 = PHP_VERSION_ID < 50444;

        if (extension_loaded('openssl') && !$bug70014)
        {
            $out = openssl_random_pseudo_bytes($length, $wasSecure);
            if ($wasSecure)
            {
                return $out;
            }
        }

        throw new RuntimeException("A reliable source of randomness wansn't found");
    }

    private static function readDevUrandom(int $length)
    {
        static $handle;

        if (!is_resource($handle))
        {
            $handle = fopen('/dev/urandom', 'rb');
        }
        if (!is_resource($handle))
        {
            throw new RuntimeException("/dev/urandon cannot be read");
        }

        $remaining = $length;
        $out = '';

        do
        {
            $in = fread($handle, $remaining);

            if (!is_string($in))
            {
                throw new RuntimeException("/dev/urandon cannot be read");
            }

            $remaining -= strlen($in);
            $out .= $in;
        } while ($remaining > 0);

        return substr($out, 0, $length);
    }

    private static function readCapicom(int $length)
    {
        $com = new \COM('CAPICOM.Utilities.1');

        $remaining = $length;
        $out = '';

        do
        {
            $in = base64_decode((string) $com->GetRandom($length, 0));
            $remaining -= strlen($in);
            $out .= $in;
        } while ($remaining > 0);

        return substr($out, 0, $length);
    }

    private static function lastResortRandom(int $length)
    {
        static $state;

        if (null === $state)
        {
            $a = $_SERVER;
            $a[] = uniqid('', true);
            shuffle($a);

            // see referenced bug 70014 above
            if (extension_loaded('openssl'))
            {
                $b = openssl_random_pseudo_bytes(20);
            }
            else
            {
                $b = '';
                for ($i = 0; $i < 20; $i++)
                {
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

        return Hash::hkdf($length, $state[0], (string) $length, $state[1]);
    }
}
