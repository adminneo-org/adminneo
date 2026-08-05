<?php
// Updates the linked classes and functions in modules/jush-php.js and the tooltips in
// jush-api.js from a php.api file:
// https://github.com/moltenform/scite-files/blob/main/files/files/api_files/php.api
// Usage: php update/php.php [path/to/php.api]

require __DIR__ . '/functions.inc.php';

$api_file = ($argv[1] ?? 'php.api');
$jush_file = __DIR__ . '/../modules/jush-php.js';
$jush_api_file = __DIR__ . '/../jush-api.js';

$api = read_file($api_file);
$jush = read_file($jush_file);
$jush_api = read_file($jush_api_file);

// Join a signature ("(int $x): bool", "()" for a no-arg constructor) and a description
// into a JS-escaped tooltip.
function tooltip($signature, $description) {
	if ($signature == '' || $signature == '()') {
		return js_escape($description);
	}
	return js_escape($signature) . '\n' . js_escape($description); // '\n' is a literal backslash-n inside the JS string
}

$class_names = []; // for the linked lists in jush-php.js (methods and magic methods are not linked)
$function_names = [];
$api_php_new = []; // key => tooltip for the jush-api.js blocks
$api_php_fun = [];
$api_php2 = [];

foreach (preg_split('~\r?\n~', $api) as $line) {
	$line = rtrim($line);
	if ($line == '') {
		continue;
	}
	list($decl, $description) = array_pad(explode("\t", $line, 2), 2, '');

	// static method: "Class::method(signature): return\tdescription"
	if (preg_match('~^([\w\\\\]+)::(\w+)(\(.*)$~', $decl, $match)) {
		if (substr($match[2], 0, 2) != '__') {
			add_api($api_php2, js_escape("$match[1]::$match[2]"), tooltip($match[3], $description));
		}
		continue;
	}

	// class or function: "name(signature)\tdescription"
	if (!preg_match('~^([\w\\\\]+)(\(.*)$~', $decl, $match)) {
		continue; // keyword, method, $variable or constant, not a class or function
	}
	$name = $match[1];
	$js_name = js_escape($name);
	if (strpos($description, '(new)') === 0) { // class, interface or exception
		$class_names[$js_name] = true;
		add_api($api_php_new, $js_name, tooltip($match[2], trim(substr($description, strlen('(new)')))));
	} elseif ($name == 'clone') { // language construct, linked as a keyword instead of a function
		add_api($api_php2, $js_name, tooltip($match[2], $description));
	} elseif (substr($name, 0, 2) != '__') { // function
		$function_names[$js_name] = true;
		add_api($api_php2, $js_name, tooltip($match[2], $description));
	} elseif ($name != '__halt_compiler') { // magic method
		add_api($api_php_fun, $js_name, tooltip($match[2], $description));
	}
}

$jush = set_list($jush, 'const php_class = /(', ')/;', array_keys($class_names), 'classes');
$jush = set_list($jush, "'function.\$1': /(return|(?:include|require)(?:_once)?|(?:", ')(?=\s*\(|$))/,', array_keys($function_names), 'functions');

file_put_contents($jush_file, $jush);

$jush_api = set_block($jush_api, 'jush.api.php2 = jush.api.lowercase_keys({', "\n});", $api_php2);
$jush_api = set_block($jush_api, 'jush.api.php_fun = jush.api.lowercase_keys({', "\n});", $api_php_fun);
$jush_api = set_block($jush_api, 'jush.api.php_new = jush.api.lowercase_keys({', "\n});", $api_php_new);

file_put_contents($jush_api_file, $jush_api);
