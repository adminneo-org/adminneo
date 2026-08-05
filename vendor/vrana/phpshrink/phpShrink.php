<?php

/** Minify PHP code. Based on http://latrine.dgx.cz/jak-zredukovat-php-skripty.
* @param string PHP code including <?php
* @return string
*/
function phpShrink($input) {
	/* normalize tokens - keep only the first open tag, change ?> to ';' and HTML to echo '' */
	$tokens = array();
	foreach (token_get_all($input) as $token) {
		if (!is_array($token)) {
			$token = array(0, $token);
		}
		if ($token[0] == T_OPEN_TAG) {
			if (!$tokens) {
				$tokens[] = array(T_OPEN_TAG, "<?php\n");
			}
		} elseif ($token[0] == T_OPEN_TAG_WITH_ECHO) {
			$tokens[] = array(T_ECHO, 'echo');
		} elseif ($token[0] == T_CLOSE_TAG) {
			for ($i = count($tokens) - 1; in_array($tokens[$i][0], array(T_WHITESPACE, T_COMMENT, T_DOC_COMMENT)); $i--) {
			}
			if ($tokens[$i][0] != T_OPEN_TAG && !in_array($tokens[$i][1], array(';', ':', '{', '}'))) {
				$tokens[] = array(0, ';'); /* ?> terminates a statement */
			}
		} elseif ($token[0] == T_INLINE_HTML) {
			// we do this even if the output is longer to profit from joining consecutive echos
			$tokens[] = array(T_ECHO, 'echo');
			$tokens[] = array(T_CONSTANT_ENCAPSED_STRING, "'" . addcslashes($token[1], "\\'") . "'");
			$tokens[] = array(0, ';');
		} elseif ($token[0] == T_WHITESPACE && $tokens[count($tokens) - 1][0] == T_OPEN_TAG) {
			// strip whitespace after <?php
		} else {
			$tokens[] = $token;
		}
	}

	// join consecutive echos
	$echo_after = 0; // how many semicolons do we need to start joining echos
	$in_echo = false;
	$next_pos = 0;
	foreach ($tokens as $i => $token) {
		if ($i < $next_pos) {
			unset($tokens[$i]);
			continue;
		}
		if (in_array($token[0], array(T_IF, T_ELSE, T_ELSEIF, T_WHILE, T_DO, T_FOR, T_FOREACH), true)) {
			$echo_after = ($token[0] == T_FOR ? 3 : 1);
		} elseif ($token[0] == T_ECHO) {
			if ($echo_after <= 0) {
				$in_echo = true;
			}
		} elseif ($token[1] == '{') {
			$echo_after = 0;
		} elseif ($token[1] == ';') {
			$echo_after--;
			if ($in_echo) {
				$next_echo = nextToken($tokens, $i, T_ECHO, array(T_WHITESPACE, T_COMMENT));
				if ($next_echo) {
					// join two consecutive echos
					$next_pos = $next_echo + 1;
					$tokens[$i][1] = ','; // '.' would conflict with "a".1+2 and would use more memory //! remove ',' and "," but not $var","
				} else {
					$in_echo = false;
				}
			}
		}
	}
	$tokens = array_values($tokens);

	// remove unnecessary { }
	//! change also `while () { if () {;} }` to `while () if () ;` but be careful about `if () { if () { } } else { }
	$shorten = 0;
	$opening = -1;
	$in_curly = false;
	foreach ($tokens as $i => $token) {
		if (in_array($token[0], array(T_IF, T_ELSE, T_ELSEIF, T_WHILE, T_DO, T_FOR, T_FOREACH))) {
			$shorten = ($token[0] == T_FOR ? 4 : 2);
			$opening = -1;
		} elseif (in_array($token[0], array(T_SWITCH, T_FUNCTION, T_CLASS, T_INTERFACE, T_TRAIT, T_TRY))) {
			$shorten = 0;
		} elseif ($token == array(0, ';')) {
			$shorten--;
		} elseif ($token == array(0, '{')) {
			if ($opening < 0) {
				$opening = $i;
			} elseif ($shorten > 1) {
				$shorten = 0;
			}
		} elseif ($token[0] == T_CURLY_OPEN || $token[0] == T_DOLLAR_OPEN_CURLY_BRACES) {
			$in_curly = true;
		} elseif ($token == array(0, '}')) {
			if ($in_curly) {
				$in_curly = false;
			} elseif ($opening >= 0 && $shorten > 0) {
				unset($tokens[$opening]);
				if ($shorten == 1) { // one command block: if (true) {;}
					unset($tokens[$i]);
				} else {
					$tokens[$i] = array(0, ';'); // empty block: if (true) {}
				}
				$shorten = 0;
				$opening = -1;
			}
		}
	}
	$tokens = array_values($tokens);

	// compute short version of variables
	$special_variables = array_flip(array('$this', '$GLOBALS', '$_GET', '$_POST', '$_FILES', '$_COOKIE', '$_SESSION', '$_SERVER', '$_ENV', '$_REQUEST', '$argc', '$argv', '$http_response_header', '$php_errormsg'));
	$short_variables = array();
	foreach ($tokens as $i => $token) {
		if ($token[0] === T_VARIABLE || $token[0] === T_STRING_VARNAME) {
			$name = ($token[0] === T_VARIABLE ? $token[1] : '$' . $token[1]); // T_STRING_VARNAME is in "${ab}"
			if (!isset($special_variables[$name])) {
				$short_variables[$name] = arrayIdx($short_variables, $name, 0) + 1;
			} elseif ($name == '$GLOBALS') {
				trigger_error('$GLOBALS is not supported, use global', E_USER_WARNING);
			}
		}
	}
	arsort($short_variables);
	$chars = implode(range('a', 'z')) . '_' . implode(range('A', 'Z'));
	//! preserve variable names between versions if possible
	$short_variables2 = array_splice($short_variables, strlen($chars));
	ksort($short_variables);
	ksort($short_variables2);
	$short_variables += $short_variables2;
	foreach (array_keys($short_variables) as $number => $key) {
		$short_variables[$key] = shortIdentifier($number, $chars); // could use also numbers and \x7f-\xff
	}

	// shorten variables and remove whitespace
	$shortening = true;
	$set = array_flip(preg_split('//', '!"#$%&\'()*+,-/:;<=>?@[]^`{|}'));
	$space = '';
	$output = '';
	$contexts = array(); // T_CLASS or T_FUNCTION for each open brace
	$pending = 0; // context opened by the next brace
	$doc_comment = false; // include only first /**
	foreach ($tokens as $i => $token) {
		if ($token[0] == T_COMMENT || $token[0] == T_WHITESPACE || ($token[0] == T_DOC_COMMENT && $doc_comment)) {
			$space = "\n";
		} else {
			if ($token[0] == T_DOC_COMMENT) {
				$doc_comment = true;
			}
			if (in_array($token[0], array(T_FUNCTION, T_CLASS, T_INTERFACE, T_TRAIT))) {
				$pending = ($token[0] == T_FUNCTION ? T_FUNCTION : T_CLASS);
			} elseif ($token[1] == ';') {
				$pending = 0; // method declaration without a body
			} elseif ($token[1] == '{' || $token[1] == '${') {
				$contexts[] = $pending;
				$pending = 0;
			} elseif ($token[1] == '}') {
				array_pop($contexts);
			}
			if ($token[0] == T_VAR || $token[0] == T_PUBLIC || $token[0] == T_PROTECTED || $token[0] == T_PRIVATE || ($token[0] == T_STATIC && inClass($contexts))) {
				if ($token[0] == T_PUBLIC) {
					$skip = array(T_WHITESPACE, T_COMMENT, T_DOC_COMMENT);
					// 'static $x' doesn't need var; 'static var $x' would be invalid
					$token[1] = (nextToken($tokens, $i, T_VARIABLE, $skip) && !prevToken($tokens, $i, T_STATIC, $skip) ? 'var' : '');
				}
				$shortening = false;
			} elseif (!$shortening) {
				if ($token[1] == ';' || $token[0] == T_FUNCTION || ($token[0] == T_STATIC && !inClass($contexts))) {
					$shortening = true;
				}
			} elseif ($token[0] === T_VARIABLE && !isset($special_variables[$token[1]]) && !prevToken($tokens, $i, T_DOUBLE_COLON, array(T_WHITESPACE, T_COMMENT, T_DOC_COMMENT))) {
				$token[1] = '$' . $short_variables[$token[1]];
			} elseif ($token[0] === T_STRING_VARNAME && !isset($special_variables['$' . $token[1]])) {
				$token[1] = $short_variables['$' . $token[1]];
			}
			if ($token[1] === '') { // public dropped before static or function
				continue;
			}
			$last = substr($output, -1);
			if (($last == '-' || $last == '+') && $token[1][0] == $last) {
				// keep space so that '$a - -1' doesn't merge into '$a--1'
			} elseif (isset($set[$last]) || isset($set[$token[1][0]])
				|| ($last == '.' && $token[0] != T_LNUMBER && $token[0] != T_DNUMBER)
				|| ($token[1] == '.' && !preg_match('~[0-9]~', $last))
			) {
				$space = '';
			}
			$output .= $space . $token[1];
			$space = '';
		}
	}

	return $output;
}

// find out if the innermost named context in $contexts is a class
function inClass($contexts) {
	for ($i = count($contexts) - 1; $i >= 0; $i--) {
		if ($contexts[$i]) {
			return ($contexts[$i] == T_CLASS);
		}
	}
	return false;
}

function nextToken($tokens, $i, $search, $allowed = array()) {
	for ($i++; isset($tokens[$i]) && in_array($tokens[$i][0], $allowed); $i++) {
	}
	return (isset($tokens[$i]) && $tokens[$i][0] === $search ? $i : 0);
}

function prevToken($tokens, $i, $search, $allowed = array()) {
	for ($i--; isset($tokens[$i]) && in_array($tokens[$i][0], $allowed); $i--) {
	}
	return (isset($tokens[$i]) && $tokens[$i][0] === $search ? $i : 0);
}

function shortIdentifier($number, $chars) {
	$return = '';
	while ($number >= 0) {
		$return .= $chars[$number % strlen($chars)];
		$number = floor($number / strlen($chars)) - 1;
	}
	return $return;
}

function arrayIdx($array, $key, $default = null) {
	return (array_key_exists($key, $array) ? $array[$key] : $default);
}

/** Replace strings, comments and inline HTML by placeholders so that they are not modified as code
* @param string
* @param array output, texts of the masked tokens
* @return string
*/
function maskStrings($input, &$masked) {
	$masked = array();
	$tokens = token_get_all($input);
	$open = false;
	foreach ($tokens as $token) {
		if (is_array($token) && ($token[0] == T_OPEN_TAG || $token[0] == T_OPEN_TAG_WITH_ECHO)) {
			$open = true;
			break;
		}
	}
	if (!$open) { // allow processing code snippets without <?php
		$tokens = token_get_all("<?php " . $input);
		array_shift($tokens);
	}
	$return = '';
	$mask = array(T_CONSTANT_ENCAPSED_STRING, T_ENCAPSED_AND_WHITESPACE, T_INLINE_HTML, T_COMMENT, T_DOC_COMMENT);
	foreach ($tokens as $token) {
		if (is_array($token) && in_array($token[0], $mask)) {
			$return .= "\0" . count($masked) . "\0"; // \0 is not allowed in PHP code so it can't come from the input
			$masked[] = $token[1];
		} else {
			$return .= (is_array($token) ? $token[1] : $token);
		}
	}
	return $return;
}

/** Put back the texts masked by maskStrings()
* @param string
* @param array
* @return string
*/
function unmaskStrings($input, $masked) {
	$return = '';
	foreach (preg_split('~\0([0-9]+)\0~', $input, -1, PREG_SPLIT_DELIM_CAPTURE) as $i => $part) {
		$return .= ($i % 2 ? $masked[$part] : $part);
	}
	return $return;
}

/** Strip type declarations not supported by PHP 5
* @param string
* @return string
*/
function stripTypes($input) {
	// this uses simple regular expressions on code with strings and comments masked out
	// anything more complicated should be done using https://github.com/nikic/PHP-Parser
	$return = maskStrings($input, $masked);
	$return = preg_replace(
		'~([(,]\s*)(' // only match after ( or ,
		. '\?[\w\\\\]+' // nullable
		// . '|\S+[&|(]\S+' // union, intersection, DNF not supported
		. '|bool|int|float|string|object|resource|self|parent|static|true|false|null|callable|iterable'
		. ')\s*(&?\s*\$)~', '\1\3', $return
	);
	$return = preg_replace('~(((public|protected|private|var|static)\b\s*)++)\??\s*[\w\\\\]+\s*(\$)~', '\1\4', $return);
	// anchor on the whole signature so that a ternary like '$a ? f($b) : false' doesn't match
	$return = preg_replace(
		'~(\bfunction\s*&?\s*\w*\s*(\(((?>[^()]+)|(?2))*\))(\s*use\s*\([^()]*\))?)\s*:\s*\??\s*[\w\\\\]+~',
		'\1',
		$return
	);
	return unmaskStrings($return, $masked);
}
