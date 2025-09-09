<?php

namespace AdminNeo;

class Hash
{
    private static $test = false;

    /**
     * HKDF function. To make sure that this is
     * always available, algo cannot be chosen.
     * 
     * @see https://www.rfc-editor.org/rfc/rfc5869
     * 
     * @param int $size Output size.
     * @param string $ikm Input keying material
     * @param string $info Optional context and application specific information
     * @param string $salt Optional salt value (a non-secret random value)
     *
     * @return string Derived key
     */
    public static function hkdf(int $size, string $ikm, string $info = '', string $salt = '')
    {
        if (extension_loaded('hash') && PHP_VERSION_ID >= 70120 && !static::$test)
        {
            return hash_hkdf('sha1', $ikm, $size, $info, $salt);
        }

        isset($salt[0]) || $salt = str_repeat("\x0", 20);

        $prk = self::hmacSha1($ikm, $salt);
        $okm = '';

        for ($keyBlock = '', $blockIndex = 1; !isset($okm[$size - 1]); $blockIndex++)
        {
            $keyBlock = self::hmacSha1($keyBlock.$info.chr($blockIndex), $prk);
            $okm .= $keyBlock;
        }

        return substr($okm, 0, $size);
    }

    /**
     * Always available HMAC-SHA1 function.
     * Binary-only output by design. If hex
     * is desired, just bin2hex the output.
     * 
     * @see https://www.rfc-editor.org/rfc/rfc2104
     * 
     * @param string $data Messgae to be hashed
     * @param string $key hashing key
     * @return string Calulated message
     */
    public static function hmacSha1(string $data, string $key)
    {
        if (extension_loaded('hash') && !static::$test)
        {
            return hash_hmac('sha1', $data, $key, true);
        }

        if (strlen($key) > 64)
        {
            $key = sha1($data, true);
        }

        $key = str_pad($key, 64, chr(0));

        $ipad = (substr($key, 0, 64) ^ str_repeat(chr(0x36), 64));
        $opad = (substr($key, 0, 64) ^ str_repeat(chr(0x5C), 64));

        return sha1($opad . sha1($ipad . $data, true), true);
    }
}
