<?php

namespace AdminNeo;

require __DIR__ . "/../../vendor/vrana/jsshrink/jsShrink.php";

function read_compiled_file(string $filename): ?string
{
	$file_path = get_temp_dir() . "/adminneo/$filename";

	return file_exists($file_path) ? file_get_contents($file_path) : null;
}

function generate_linked_file(string $name, array $file_paths): ?string
{
	static $links = [];

	if (array_key_exists($name, $links)) {
		return $links[$name];
	}

	$linked_filename = linked_filename($name, $file_paths);
	if (!$linked_filename) {
		return $links[$name] = null;
	}

	$temp_dir = get_temp_dir() . "/adminneo";
	if (!is_dir($temp_dir) && !@mkdir($temp_dir)) {
		return $links[$name] = null;
	}

	if (!file_exists("$temp_dir/$linked_filename")) {
		// Delete old compiled files.
		$name_pattern = preg_replace('~\.[^.]+$~', "__*$0", $name);
		foreach (glob("$temp_dir/$name_pattern") as $filename) {
			unlink($filename);
		}

		// Compile and save the file.
		if ($data = compile_file($name, $file_paths)) {
			file_put_contents("$temp_dir/$linked_filename", $data);
		}
	}

	return $links[$name] = $linked_filename;
}

function linked_filename(string $name, array $file_paths): ?string
{
	$pathString = $timeString = "";

	foreach ($file_paths as $file_path) {
		$full_path = realpath(getcwd() . "/$file_path");

		if (file_exists($full_path)) {
			$pathString .= $full_path;
			$timeString .= filemtime($full_path);
		} elseif (PHP_SAPI == "cli") {
			echo "⚠️ File does not exist: $file_path\n";
		}
	}
	if (!$pathString) {
		return null;
	}

	$version = md5($pathString) . "__" . substr(md5($timeString), 0, 8);

	return preg_replace('~\.[^.]+$~', "-$version$0", $name);
}

function compile_file(string $name, array $file_paths): ?string
{
	$extension = pathinfo($name, PATHINFO_EXTENSION);
	switch ($extension) {
		case "css":
			$shrink_function = "AdminNeo\\minify_css";
			break;
		case "js":
			$shrink_function = "AdminNeo\\minify_js";
			break;
		default:
			$shrink_function = null;
			break;
	}

	$file = "";
	foreach ($file_paths as $file_path) {
		$full_path = getcwd() . "/$file_path";

		if (file_exists($full_path)) {
			$file .= file_get_contents(getcwd() . "/$file_path");
		} elseif (PHP_SAPI == "cli") {
			echo "⚠️ File does not exist: $full_path\n";
		}
	}
	if (!$file) {
		return null;
	}

	if ($shrink_function) {
		$file = call_user_func($shrink_function, $file);
	}

	if (in_array($extension, ["png", "ico"])) {
		return base64_encode($file);
	} else {
		return compress_string($file);
	}
}

function minify_css(string $file): string
{
	return preg_replace('~\s*([:;{},])\s*~', '\1', preg_replace('~/\*.*\*/~sU', '', $file));
}

function minify_js(string $file): string
{
	// Keep only the first 'use strict'.
	$file = preg_replace("~(.)'use strict';~s", "$1", $file);

	return jsShrink($file);
}

/**
 * Compresses string with deflate to characters from compress_alphabet().
 */
function compress_string(string $string): string
{
	$binary = ($string != "" ? gzdeflate($string, 9) : "");
	// convert bytes to string; 2 chars from a 93-symbol alphabet hold 13 bits
	$alphabet = compress_alphabet();
	$return = "";
	$rest = 0;
	$rest_length = 0;

	for ($i = 0; $i < strlen($binary); $i++) {
		$rest = ($rest << 8) + ord($binary[$i]);
		$rest_length += 8;

		if ($rest_length >= 13) {
			$rest_length -= 13;
			$chunk = $rest >> $rest_length;
			$return .= $alphabet[(int) ($chunk / 93)] . $alphabet[$chunk % 93];
			$rest &= (1 << $rest_length) - 1;
		}
	}

	$padding = 0;
	if ($rest_length) {
		$padding = 13 - $rest_length;
		$chunk = $rest << $padding;
		$return .= $alphabet[(int) ($chunk / 93)] . $alphabet[$chunk % 93];
	}

	return ($binary != "" ? $alphabet[$padding] . $return : "");
}

function downgrade_php(string $code): string
{
	// Type declarations.
	$code = stripTypes($code);

	// Null coalescing - variables and constants.
	$coalescing = '\s*\?\?';

	$class = '\\\\?(\w+\\\\)*\w+::'; // self, parent, static or a class name, optionally fully qualified
	$array_key = '[^](]+';
	$array_key2 = $array_key . '\[' . $array_key . ']' . '[^](]*';

	$code = preg_replace(
		'~((\$|\$(\w+->)+|' . $class . '\$?)\w+' // name
		. '(\[(' . $array_key . '|' . $array_key2 . ')])*)' // array, max 2 levels
		. $coalescing
		. '~', 'isset(\1) ? \1 :', $code
	);

	// Null coalescing - function calls.
	$code = preg_replace(
		'~((\$(\w+->)+|' . $class . ')?\w+' // name
		. '\([^()]*\))' // parameters
		. $coalescing
		. '~', '($_result = \1) !== null ? $_result :', $code);

	// Constants.
	if (preg_match_all('~(public|private|protected)\sconst\s+(\w+)\s?=\s?~', $code, $matches)) {
		foreach ($matches[2] as $name) {
			$code = preg_replace("~const\s+($name)\b~", 'static $\1', $code);
			$code = preg_replace("~::($name)\b~", '::$\1', $code);
		}
	}

	// Arrays unpacking.
	$code = preg_replace('~(^|\s|\()\[(.+?)]\s*=~', '\1list(\2) =', $code);

	// Class names.
	$code = preg_replace('~\\\\([\w\\\\]+)::class\b~', '\'\\\\$1\'', $code);
	$code = preg_replace('~\b(\w+)::class\b~', '\'\\\\AdminNeo\\\\$1\'', $code);

	// Constants.
	$code = preg_replace('~\bMYSQLI_CLIENT_SSL_DONT_VERIFY_SERVER_CERT\b~', '64', $code);

	return $code;
}
