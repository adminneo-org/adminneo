/** Remove spaces and comments from JavaScript code
* @param string code with commands terminated by semicolon
* @return string shrinked code
* @link https://vrana.github.io/JsShrink/
* @author Jakub Vrana, https://www.vrana.cz/
* @copyright 2007 Jakub Vrana
* @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
*/
function jsShrink(input) {
	var last = '';
	return ('\n' + input + '\n').replace(/(?:(^|[-+\([{}=,:;!%^&*|?~]|\/(?![/*])|return|throw)(?:\s|\/\/[^\n]*\n|\/\*(?:[^*]|\*(?!\/))*\*\/)*(\/(?![/*])(?:\\[^\n]|[^[\n\/\\]|\[(?:\\[^\n]|[^\]])+)+\/)|(^|'(?:\\[\s\S]|[^\n'\\])*'|"(?:\\[\s\S]|[^\n"\\])*"|([0-9A-Za-z_$]+)|([-+]+)|.))(?:\s|\/\/[^\n]*\n|\/\*(?:[^*]|\*(?!\/))*\*\/)*/g, function (str, context, regexp, result, word, operator) {
		if (word) {
			result = (last == 'word' ? '\n' : (last == 'return' ? ' ' : '')) + result;
			last = (word == 'return' || word == 'throw' || word == 'break' || word == 'async' ? 'return' : 'word');
		} else if (operator) {
			result = (last == operator.charAt(0) ? '\n' : '') + result;
			last = operator.charAt(0);
		} else {
			if (regexp) {
				result = context + (context == '/' ? '\n' : '') + regexp;
			}
			last = '';
		}
		return result;
	});
}
