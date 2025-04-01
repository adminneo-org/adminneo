<?php

namespace AdminNeo;

/** Use <select><option> for enum edit instead of <input type="radio">
* @link https://www.adminer.org/plugins/#use
* @author Jakub Vrana, https://www.vrana.cz/
* @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
*/
class EnumOptionPlugin {
	public function getFieldInput(string $table, array $field, string $attrs, $value, ?string $function): ?string
	{
		if ($field["type"] == "enum") {
			$options = [];
			$selected = $value;
			preg_match_all("~'((?:[^']|'')*)'~", $field["length"], $matches);
			foreach ($matches[1] as $val) {
				$val = stripcslashes(str_replace("''", "'", $val));
				$options[$val] = admin()->formatFieldValue($val, $field);
			}
			return "<select$attrs>" . optionlist($options, $selected, 1) . "</select>"; // 1 - use keys
		}

		return null;
	}

}
