<?php

namespace AdminNeo;

use Exception;

const ENCRYPTION_GCM = 'aes-256-gcm';
const ENCRYPTION_CBC = 'aes-256-cbc';
const ENCRYPTION_TAG_LENGTH = 16;
const ENCRYPTION_HMAC_LENGTH = 64;

/**
 * Generates a secure IV compatible with PHP 5 and PHP 7+.
 *
 * @param int $length IV length.
 *
 * @return string Generated IV.
 */
function generate_iv(int $length): string
{
	if (function_exists('random_bytes')) {
		try {
			return random_bytes($length);
		} catch (Exception $e) {
			// Fallback to OpenSSL.
		}
	}

	return openssl_random_pseudo_bytes($length);
}

/**
 * Generates a 256-bit (32-byte) key from the SHA-512 hash.
 *
 * @param string $key
 *
 * @return string
 */
function hash_key(string $key): string
{
	return substr(hash('sha512', $key, true), 0, 32);
}

/**
 * Encrypts a string using AES-256-CBC.
 *
 * @param string $plaintext Plain text to encrypt.
 * @param string $key Encryption key.
 *
 * @return string|false Encrypted binary data or false.
 */
function aes_encrypt_string(string $plaintext, string $key)
{
	$method = in_array(ENCRYPTION_GCM, openssl_get_cipher_methods()) ? ENCRYPTION_GCM : ENCRYPTION_CBC;
	$key = hash_key($key);
	$iv = generate_iv(openssl_cipher_iv_length($method) ?: 16);

	// Encrypts the text.
	if ($method === ENCRYPTION_GCM) {
		$ciphertext = openssl_encrypt($plaintext, $method, $key, OPENSSL_RAW_DATA, $iv, $tag, "", ENCRYPTION_TAG_LENGTH);
	} else {
		$ciphertext = openssl_encrypt($plaintext, $method, $key, OPENSSL_RAW_DATA, $iv);
		$tag = hash_hmac("sha512", $iv . $ciphertext, $key, true);
	}

	if ($ciphertext === false) {
		return false;
	}

	return $iv . $tag . $ciphertext;
}

/**
 * Decrypts an AES-256-CBC encrypted string.
 *
 * @param string $data Encrypted binary data.
 * @param string $key Decryption key.
 *
 * @return string|false Decrypted plain text or false.
 */
function aes_decrypt_string(string $data, string $key)
{
	$method = in_array(ENCRYPTION_GCM, openssl_get_cipher_methods()) ? ENCRYPTION_GCM : ENCRYPTION_CBC;
	$iv_length = openssl_cipher_iv_length($method) ?: 16;
	$tag_length = $method === ENCRYPTION_GCM ? ENCRYPTION_TAG_LENGTH : ENCRYPTION_HMAC_LENGTH;

	// IV (16) + TAG (16) minimum
	if (strlen($data) < $iv_length + $tag_length) {
		return false;
	}

	$key = hash_key($key);

	// Extracts IV (16 bytes), HMAC (64 bytes), and encrypted text.
	$iv = substr($data, 0, $iv_length);
	$tag = substr($data, $iv_length, $tag_length);
	$ciphertext = substr($data, $iv_length + $tag_length);

	if ($iv === false || $tag === false || $ciphertext === false) {
		return false;
	}

	if ($method === ENCRYPTION_GCM) {
		// Decrypts the text.
		return openssl_decrypt($ciphertext, $method, $key, OPENSSL_RAW_DATA, $iv, $tag);
	} else {
		// Verifies the integrity.
		$hmac = hash_hmac('sha512', $iv . $ciphertext, $key, true);
		if (!hash_equals($tag, $hmac)) {
			return false;
		}

		// Decrypts the text.
		return openssl_decrypt($ciphertext, $method, $key, OPENSSL_RAW_DATA, $iv);
	}
}
