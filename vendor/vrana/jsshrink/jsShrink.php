<?php
/** Remove spaces and comments from JavaScript code
* @param string code with commands terminated by semicolon
* @return string shrinked code
* @link https://vrana.github.io/JsShrink/
* @author Jakub Vrana, https://www.vrana.cz/
* @copyright 2007 Jakub Vrana
* @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
*/
function jsShrink($input) {
	return preg_replace_callback('(
		(?:
			(^|=>|[-+\([{}=,:;!%^&*|?~]|/(?![/*])|return|throw) # context before regexp
			(?:\s|//[^\n]*+\n|/\*(?:[^*]|\*(?!/))*+\*/)* # optional space
			(/(?![/*])(?:
				\\\\[^\n]
				|[^[\n/\\\\]++
				|\[(?:\\\\[^\n]|[^]])++
			)+/[\w$]*) # regexp with flags
			|(^
				|\'(?:\\\\.|[^\n\'\\\\])*\'
				|"(?:\\\\.|[^\n"\\\\])*"
				|`(?:\\\\.|[^`\\\\])*` # template literal, ${} is kept verbatim
				|([\w$]+)
				|([-+]+)
				|.
			)
		)(?:\s|//[^\n]*+\n|/\*(?:[^*]|\*(?!/))*+\*/)* # optional space
	)sx', 'jsShrinkCallback', "$input\n");
}

function jsShrinkCallback($match) {
	static $last = '';
	$match += array_fill(1, 5, null); // avoid E_NOTICE
	list(, $context, $regexp, $result, $word, $operator) = $match;
	if ($word != '') {
		$result = ($last == 'word' ? "\n" : ($last == 'return' ? " " : "")) . $result;
		$last = ($word == 'return' || $word == 'throw' || $word == 'break' || $word == 'continue' || $word == 'yield' || $word == 'async' ? 'return' : 'word');
	} elseif ($operator) {
		$result = ($last == $operator[0] ? "\n" : "") . $result;
		$last = $operator[0];
	} else {
		if ($regexp) {
			$separator = '';
			if ($context == 'return' || $context == 'throw') {
				$separator = ($last == 'word' ? "\n" : ($last == 'return' ? " " : ""));
			} elseif ($last != '' && $last == $context) {
				$separator = "\n";
			}
			$result = $separator . $context . ($context == '/' ? "\n" : "") . $regexp;
			$last = 'word'; // separate a following identifier from the regexp
		} else {
			$last = '';
		}
	}
	return $result;
}
