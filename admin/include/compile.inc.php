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
	switch (pathinfo($name, PATHINFO_EXTENSION)) {
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

	return base64_encode(lzw_compress($file));
}

function minify_css(string $file): string
{
	return preg_replace('~\s*([:;{},])\s*~', '\1', preg_replace('~/\*.*\*/~sU', '', $file));
}

function minify_js(string $file): string
{
	return jsShrink($file);
}

function lzw_compress(string $string): string
{
	// Compress.
	$dictionary = array_flip(range("\0", "\xFF"));
	$word = "";
	$codes = [];

	for ($i = 0; $i <= strlen($string); $i++) {
		$x = @$string[$i];
		if (strlen($x) && isset($dictionary[$word . $x])) {
			$word .= $x;
		} elseif ($i) {
			$codes[] = $dictionary[$word];
			$dictionary[$word . $x] = count($dictionary);
			$word = $x;
		}
	}

	// Convert codes to binary string.
	$dictionary_count = 256;
	$bits = 8; // ceil(log($dictionary_count, 2))
	$return = "";
	$rest = 0;
	$rest_length = 0;

	foreach ($codes as $code) {
		$rest = ($rest << $bits) + $code;
		$rest_length += $bits;

		$dictionary_count++;
		if ($dictionary_count >> $bits) {
			$bits++;
		}

		while ($rest_length > 7) {
			$rest_length -= 8;
			$return .= chr($rest >> $rest_length);
			$rest &= (1 << $rest_length) - 1;
		}
	}

	return $return . ($rest_length ? chr($rest << (8 - $rest_length)) : "");
}

function downgrade_php(string $code): string
{
	// Type declarations.
	$code = stripTypes($code);

	// Null coalescing - variables and constants.
	$coalescing = '\s?\?\?';

	$array_key = '[^](]+';
	$array_key2 = $array_key . '\[' . $array_key . ']' . '[^](]*';

	$code = preg_replace(
		'~((\$|\$\w+->|self::\$|self::)\w+' // name
		. '(\[(' . $array_key . '|' . $array_key2 . ')])*)' // array, max 2 levels
		. $coalescing
		. '~', 'isset(\1) ? \1 :', $code
	);

	// Null coalescing - function calls.
	$code = preg_replace(
		'~((\$\w+->|self::)?\w+' // name
		. '\([^)]*\))' // parameters
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
