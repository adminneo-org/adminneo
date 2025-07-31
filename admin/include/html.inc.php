<?php

namespace AdminNeo;

/**
 * Returns <script> element.
 */
function script(string $source, string $trailing = "\n"): string
{
	return "<script" . nonce() . ">$source</script>$trailing";
}

/**
 * Returns <script src> element.
 */
function script_src(string $url): string
{
	return "<script src='" . h($url) . "'" . nonce() . "></script>\n";
}

/**
 * Returns a nonce="" attribute with CSP nonce.
 *
 * @throws \Random\RandomException
 */
function nonce(): string
{
	return ' nonce="' . get_nonce() . '"';
}

/**
 * Returns a target="_blank" attribute with appropriate rel attribute.
 */
function target_blank(): string
{
	return ' target="_blank" rel="noreferrer noopener"';
}

/**
 * Escapes string for HTML.
 */
function h(?string $string): string
{
	return $string !== null && $string !== "" ? str_replace("\0", "&#0;", htmlspecialchars($string, ENT_QUOTES, 'utf-8')) : "";
}

/**
 * Returns HTML for solo icon with given ID.
 */
function icon_solo(string $id): string
{
	return icon($id, "solo");
}

/**
 * Returns HTML for chevron icon.
 */
function icon_chevron_down(): string
{
	return icon("chevron-down", "chevron");
}

/**
 * Returns HTML for chevron icon.
 */
function icon_chevron_right(): string
{
	return icon("chevron-down", "chevron-right");
}

/**
 * Returns HTML for an icon.
 */
function icon(string $id, ?string $class = null): string
{
	$id = h($id);

	return "<svg class='icon ic-$id $class'><use href='" . link_files("icons.svg", ["images/icons.svg"]) . "#$id'/></svg>";
}

/** Generate HTML checkbox
* @param string
* @param string
* @param bool
* @param string
* @param string
* @param string
* @param string
* @return string
*/
function checkbox($name, $value, $checked, $label = "", $onclick = "", $class = "", $labelled_by = "") {
	$return = "<input type='checkbox' name='$name' value='" . h($value) . "'"
		. ($checked ? " checked" : "")
		. ($labelled_by ? " aria-labelledby='$labelled_by'" : "")
		. ">"
		. ($onclick ? script("qsl('input').onclick = function () { $onclick };", "") : "");

	return ($label != "" || $class ? "<label" . ($class ? " class='$class'" : "") . ">$return" . h($label) . "</label>" : $return);
}

/** Generate list of HTML options
* @param array array of strings or arrays (creates optgroup)
* @param mixed
* @param bool always use array keys for value="", otherwise only string keys are used
* @return string
*/
function optionlist($options, $selected = null, $use_keys = false) {
	$return = "";
	foreach ($options as $k => $v) {
		$opts = [$k => $v];
		if (is_array($v)) {
			$return .= '<optgroup label="' . h($k) . '">';
			$opts = $v;
		}
		foreach ($opts as $key => $val) {
			$return .= '<option'
				. ($use_keys || is_string($key) ? ' value="' . h($key) . '"' : '')
				. ($selected !== null && ($use_keys || is_string($key) ? (string) $key : $val) === $selected ? ' selected' : '')
				. '>' . h($val)
			;
		}
		if (is_array($v)) {
			$return .= '</optgroup>';
		}
	}
	return $return;
}

/** Generate HTML <select>
* @param string
* @param array
* @param ?string
* @param string
* @param string
* @return string
*/
function html_select($name, $options, $value = "", $onchange = "", $labelled_by = "", bool $use_keys = false) {
	return "<select name='" . h($name) . "'"
		. ($labelled_by ? " aria-labelledby='$labelled_by'" : "")
		. ">" . optionlist($options, $value, $use_keys) . "</select>"
		. ($onchange ? script("qsl('select').onchange = function () { $onchange };", "") : "");
}

/** Generate HTML radio list
* @param string
* @param array
* @param string
* @return string
*/
function html_radios($name, $options, $value = "") {
	$result = "<span class='labels'>";
	foreach ($options as $key => $val) {
		$result .= "<label><input type='radio' name='" . h($name) . "' value='" . h($key) . "'" . ($key == $value ? " checked" : "") . ">" . h($val) . "</label>";
	}
	$result .= "</span>";

	return $result;
}

/** Get onclick confirmation
* @param string
* @param string
* @return string
*/
function confirm($message = "", $selector = "qsl('input')") {
	return script("$selector.onclick = function () { return confirm('" . ($message ? js_escape($message) : lang('Are you sure?')) . "'); };", "");
}

/**
 * Prints beginning for a fieldset.
 */
function print_fieldset_start(string $id, string $legend, string $icon, bool $visible = false, bool $sortable = false): void
{
	echo "<fieldset id='fieldset-$id' class='closable " . (!$visible ? " closed" : "") . "'>";
	echo "<legend><a href='#'>$legend</a></legend>";

	echo icon($icon, "fieldset-icon jsonly");
	echo "<div class='fieldset-content" . ($sortable ? " sortable" : "") . "'>";
}

/**
 * Prints ending for a fieldset.
 */
function print_fieldset_end(string $id, bool $sortable = false): void
{
	echo "</div>"; // fieldset-content
	echo script("initFieldset('$id');", "");

	if ($sortable) {
		echo script("initSortable('#fieldset-$id .fieldset-content');", "");
	}

	echo "</fieldset>\n";
}

/** Return class='active' if $bold is true
* @param bool
* @param string
* @return string
*/
function bold($bold, $class = "") {
	return ($bold ? " class='$class active'" : ($class ? " class='$class'" : ""));
}

/** Escape string for JavaScript apostrophes
* @param string
* @return string
*/
function js_escape($string) {
	return addcslashes($string, "\r\n'\\/"); // slash for <script>
}

/**
 * Generates page number for pagination.
 */
function pagination(int $page, int $current): string
{
	return "<li>" .
		($page == $current ?
			"<strong>" . ($page + 1) . "</strong>":
			'<a href="' . h(remove_from_uri("page") . ($page ? "&page=$page" . ($_GET["next"] ? "&next=" . urlencode($_GET["next"]) : "") : "")) . '">' . ($page + 1) . "</a>") .
		"</li>";
}

/** Print hidden fields
* @param array
* @param array
* @param string
* @return bool
*/
function hidden_fields($process, $ignore = [], $prefix = '') {
	$return = false;
	foreach ($process as $key => $val) {
		if (!in_array($key, $ignore)) {
			if (is_array($val)) {
				hidden_fields($val, [], $key);
			} else {
				$return = true;
				echo '<input type="hidden" name="' . h($prefix ? $prefix . "[$key]" : $key) . '" value="' . h($val) . '">';
			}
		}
	}
	return $return;
}

/** Print hidden fields for GET forms
* @return null
*/
function hidden_fields_get() {
	echo (sid() ? '<input type="hidden" name="' . session_name() . '" value="' . h(session_id()) . '">' : '');
	echo (SERVER !== null ? '<input type="hidden" name="' . DRIVER . '" value="' . h(SERVER) . '">' : "");
	echo '<input type="hidden" name="username" value="' . h($_GET["username"]) . '">';
}

/**
 * Returns input options for enum values.
 *
 * @param string|array $value
 */
function enum_input(string $attrs, array $field, $value, ?string $empty = null, bool $checkboxes = false): string
{
	preg_match_all("~'((?:[^']|'')*)'~", $field["length"], $matches);
	$values = $matches[1];

	$threshold = Admin::get()->getSettings()->getEnumAsSelectThreshold();
	$select = !$checkboxes && $threshold !== null && count($values) > $threshold;
	$type = $checkboxes ? "checkbox" : "radio";
	$active_param = $select ? "selected" : "checked";

	$result = $select ? "<select $attrs>" : "<span class='labels'>";

	if ($select && $field["null"] && $empty !== "") {
		$checked = $value === null ? $active_param : "";
		$result .= "<option value='__adminneo_empty__' disabled $checked></option>";
	}

	if ($empty !== null) {
		$checked = (is_array($value) ? in_array($empty, $value) : $value === $empty) ? $active_param : "";

		if ($select) {
			$result .= "<option value='$empty' $checked>" . lang('empty') . "</option>";
		} else {
			$result .= "<label><input type='$type' $attrs value='$empty' $checked><i>" . lang('empty') . "</i></label>";
		}
	}

	foreach ($values as $val) {
		// Do not display empty value from enum if additional empty option is set by $empty. This can happen in Editor
		// because it uses value "" for nullable enum.
		if ($empty === "" && $val === "") {
			continue;
		}

		$val = stripcslashes(str_replace("''", "'", $val));

		$checked = is_array($value) ? in_array($val, $value) : $value === $val;
		$checked = $checked ? $active_param : "";
		$formatted_value = $val === "" ? ("<i>" . lang('empty') . "</i>") : h(Admin::get()->formatFieldValue($val, $field));

		if ($select) {
			$result .= "<option value='" . h($val) . "' $checked>$formatted_value</option>";
		} else {
			$result .= " <label><input type='$type' $attrs value='" . h($val) . "' $checked>$formatted_value</label>";
		}
	}

	$result .= $select ? "</select>" : "</span>";

	return $result;
}

/** Print edit input field
* @param array one field from fields()
* @param mixed
* @param string
* @param bool
* @return null
*/
function input($field, $value, $function, $autofocus = false) {
	$name = h(bracket_escape($field["field"]));

	$types = Driver::get()->getTypes();
	$json_type = isset($field["type"]) && Admin::get()->detectJson($field["type"], $value, true);

	$reset = (DIALECT == "mssql" && $field["auto_increment"]);
	if ($reset && !$_POST["save"]) {
		$function = null;
	}

	if (in_array($field["type"], Driver::get()->getUserTypes())) {
		$enums = type_values($types[$field["type"]]);
		if ($enums) {
			$field["type"] = "enum";
			$field["length"] = $enums;
		}
	}

	// Attributes.
	$disabled = stripos($field["default"], "GENERATED ALWAYS AS ") === 0 ? " disabled=''" : "";
	$attrs = " name='fields[$name]' $disabled" . ($autofocus ? " autofocus" : "");

	// Function list.
	$functions = (isset($_GET["select"]) || $reset ? ["orig" => lang('original')] : []) + Admin::get()->getFieldFunctions($field);
	$has_function = (in_array($function, $functions) || isset($functions[$function]));

	echo "<td class='function'>";
	echo Driver::get()->getUnconvertFunction($field) . " ";

	if (count($functions) > 1) {
		$selected = $function === null || $has_function ? $function : "";
		echo "<select name='function[$name]' $disabled>" . optionlist($functions, $selected) . "</select>";

		echo help_script_command("value.replace(/^SQL\$/, '')", true);
		echo script("qsl('select').onchange = functionChange;", "");
	} else {
		echo h(reset($functions));
	}

	echo "</td><td>";

	// Input field.
	$input = Admin::get()->getFieldInput($_GET["edit"] ?? null, $field, $attrs, $value, $function);

	if ($input != "") {
		echo $input;
	} elseif (preg_match('~bool~', $field["type"])) {
		echo "<input type='hidden'$attrs value='0'>" .
			"<input type='checkbox'" . (preg_match('~^(1|t|true|y|yes|on)$~i', $value) ? " checked='checked'" : "") . "$attrs value='1'>";
	} elseif ($field["type"] == "enum") {
		echo enum_input($attrs, $field, $value);
	} elseif ($field["type"] == "set") {
		preg_match_all("~'((?:[^']|'')*)'~", $field["length"], $matches);

		echo "<span class='labels'>";

		foreach ($matches[1] as $val) {
			$val = stripcslashes(str_replace("''", "'", $val));
			$checked = $value !== null && in_array($val, explode(",", $value), true);
			$checked = $checked ? "checked" : "";
			$formatted_value = $val === "" ? ("<i>" . lang('empty') . "</i>") : h(Admin::get()->formatFieldValue($val, $field));

			echo " <label><input type='checkbox' name='fields[$name][]' value='" . h($val) . "' $checked>$formatted_value</label>";
		}

		echo "</span>";
	} elseif (preg_match('~blob|bytea|raw|file~', $field["type"]) && ini_bool("file_uploads")) {
		echo "<input type='file' name='fields-$name'>";
	} elseif ($json_type) {
		echo "<textarea$attrs cols='50' rows='12' class='jush-js'>" . h($value) . '</textarea>';
	} elseif (($text = preg_match('~text|lob|memo~i', $field["type"])) || preg_match("~\n~", $value)) {
		if ($text && DIALECT != "sqlite") {
			$attrs .= " cols='50' rows='12'";
		} else {
			$rows = min(12, substr_count($value, "\n") + 1);
			$attrs .= " cols='30' rows='$rows'";
		}
		echo "<textarea$attrs>" . h($value) . '</textarea>';
	} else {
		// int(3) is only a display hint
		$maxlength = !preg_match('~int~', $field["type"]) && preg_match('~^(\d+)(,(\d+))?$~', $field["length"], $match)
			? ((preg_match("~binary~", $field["type"]) ? 2 : 1) * $match[1] + ($match[3] ? 1 : 0) + ($match[2] && !$field["unsigned"] ? 1 : 0))
			: ($types && $types[$field["type"]] ? $types[$field["type"]] + ($field["unsigned"] ? 0 : 1) : 0);
		if (DIALECT == 'sql' && Connection::get()->isMinVersion("5.6") && preg_match('~time~', $field["type"])) {
			$maxlength += 7; // microtime
		}
		// type='date' and type='time' display localized value which may be confusing, type='datetime' uses 'T' as date and time separator
		echo "<input class='input'"
			. ((!$has_function || $function === "") && preg_match('~(?<!o)int(?!er)~', $field["type"]) && !preg_match('~\[\]~', $field["full_type"]) ? " type='number'" : "")
			. ($function != "now" ? " value='" . h($value) . "'" : " data-last-value='" . h($value) . "'")
			. ($maxlength ? " data-maxlength='$maxlength'" : "")
			. (preg_match('~char|binary~', $field["type"]) && $maxlength > 20 ? " size='40'" : "")
			. "$attrs>"
		;
	}

	// Hint.
	$hint = Admin::get()->getFieldInputHint($_GET["edit"], $field, $value);
	if ($hint != "") {
		echo " <span class='input-hint'>$hint</span>";
	}

	// Change scripts.
	$first_function = 0;
	foreach ($functions as $key => $val) {
		if ($key === "" || !$val) {
			break;
		}
		$first_function++;
	}

	echo script("mixin(qsl('td'), {onchange: partial(skipOriginal, $first_function), oninput: function () { this.onchange(); }});");
}

/** Process edit input field
 * @param array $field one field from fields()
 * @return string|array|false|null False to leave the original value (copy original while cloning), null to skip the column
 */
function process_input($field) {
	if (stripos($field["default"], "GENERATED ALWAYS AS ") === 0) {
		return null;
	}

	$idf = bracket_escape($field["field"]);
	$function = $_POST["function"][$idf] ?? "";
	// Value can miss if strict mode is turned off and enum field has no value.
	$value = $_POST["fields"][$idf] ?? "";

	if ($field["auto_increment"] && $value == "") {
		return null;
	}
	if ($function == "orig") {
		return (preg_match('~^CURRENT_TIMESTAMP~i', $field["on_update"]) ? idf_escape($field["field"]) : false);
	}
	if ($function == "NULL") {
		return "NULL";
	}
	if ($field["type"] == "set") {
		$value = implode(",", (array) $value);
	}
	if ($function == "json") {
		$value = json_decode($value, true);
		if (!is_array($value)) {
			return false; //! report errors
		}
		return $value;
	}
	if (preg_match('~blob|bytea|raw|file~', $field["type"]) && ini_bool("file_uploads")) {
		$file = get_file("fields-$idf");
		if (!is_string($file)) {
			return false; //! report errors
		}
		return Driver::get()->quoteBinary($file);
	}
	return Admin::get()->processFieldInput($field, $value, $function);
}

/**
 * Search in tables and prints links to tables containing searched expression.
 *
 * @uses $_GET["where"][0]
 * @uses $_POST["tables"]
 */
function search_tables(): void
{
	$_GET["where"][0]["val"] = $_POST["query"];

	$results = $errors = [];

	foreach (table_status("", true) as $table => $table_status) {
		$table_name = Admin::get()->getTableName($table_status);

		if (!isset($table_status["Engine"]) || $table_name == "" || ($_POST["tables"] && !in_array($table, $_POST["tables"]))) {
			continue;
		}

		$result = Connection::get()->query("SELECT" . limit("1 FROM " . table($table), " WHERE " . implode(" AND ", Admin::get()->processSelectionSearch(fields($table), [])), 1));
		if ($result && !$result->fetchRow()) {
			continue;
		}

		$link = h(ME . "select=" . urlencode($table) . "&where[0][op]=" . urlencode($_GET["where"][0]["op"]) . "&where[0][val]=" . urlencode($_GET["where"][0]["val"]));
		if ($result) {
			$results[] = "<li><a href='$link'>" . icon("search") . "$table_name</a></li>";
		} else {
			$errors[] = "<div class='error'><a href='$link'>$table_name</a>: " . error() . "</div>";
		}
	}

	if ($results) {
		echo "<ul class='links'>\n", implode("\n", $results), "</ul>\n";
	}
	if ($errors) {
		echo implode("\n", $errors), "\n";
	}
	if (!$results && !$errors) {
		echo "<p class='message'>" . lang('No tables.') . "</p>\n";
	}
}

/**
 * Returns initializing <script> for help popup with given text.
 *
 * @param string $text Help text.
 * @param bool $side Side position.
 */
function help_script(string $text, bool $side = false): string
{
	return script("initHelpFor(qsl('select, input'), '" . h($text) . "', $side);", "");
}

/**
 * Returns initializing <script> for help popup with text resolved by JavaScript expression.
 *
 * @param string $command JS expression for returning the help text.
 * @param bool $side Side position.
 */
function help_script_command(string $command, bool $side = false): string
{
	return script("initHelpFor(qsl('select, input'), (value) => { return $command; }, $side);", "");
}

/** Print edit data form
* @param string
* @param array
* @param mixed
* @param bool
* @return null
*/
function edit_form($table, $fields, $row, $update) {
	$table_name = Admin::get()->getTableName(table_status1($table, true));
	$title = $update ? lang('Edit') : lang('Insert');

	page_header("$title: $table_name", ["select" => [$table, $table_name], $title]);
	if ($row === false) {
		echo "<p class='error'>" . lang('No rows.') . "\n";
		return;
	}
	?>
	<form action="" method="post" enctype="multipart/form-data" id="form">
		<?php
		$first = 0;
		if (!$fields) {
			echo "<p class='error'>" . lang('You have no privileges to update this table.') . "\n";
		} else {
			echo "<table class='box'>" . script("qsl('table').onkeydown = onEditingKeydown;");

			$autofocus = !$_POST;

			foreach ($fields as $name => $field) {
				echo "<tr><th>" . Admin::get()->getFieldName($field);
				$key = bracket_escape($name);
				$default = $_GET["set"][$key] ?? null;
				if ($default === null) {
					$default = $field["default"];
					if ($field["type"] == "bit" && preg_match("~^b'([01]*)'\$~", $default, $regs)) {
						$default = $regs[1];
					}
					if (DIALECT == "sql" && preg_match('~binary~', $field["type"])) {
						$default = bin2hex($default); // same as UNHEX
					}
				}
				$value = ($row !== null
					? ($row[$name] != "" && DIALECT == "sql" && preg_match("~enum|set~", $field["type"]) && is_array($row[$name])
						? implode(",", $row[$name])
						: (is_bool($row[$name]) ? +$row[$name] : $row[$name])
					)
					: (!$update && $field["auto_increment"]
						? ""
						: (isset($_GET["select"]) ? false : $default)
					)
				);
				if (!$_POST["save"] && is_string($value)) {
					$value = Admin::get()->formatFieldValue($value, $field);
				}
				$function = ($_POST["save"]
					? $_POST["function"][$name] ?? ""
					: ($update && preg_match('~^CURRENT_TIMESTAMP~i', $field["on_update"])
						? "now"
						: ($value === false ? null : ($value !== null ? '' : 'NULL'))
					)
				);
				if (!$_POST && !$update && $value == $field["default"] && preg_match('~^[\w.]+\(~', $value)) {
					$function = "SQL";
				}
				if (preg_match("~time~", $field["type"]) && preg_match('~^CURRENT_TIMESTAMP~i', $value)) {
					$value = "";
					$function = "now";
				}
				if ($field["type"] == "uuid" && $value == "uuid()") {
					$value = "";
					$function = "uuid";
				}
				if ($autofocus !== false) {
					$autofocus = ($field["auto_increment"] || $function == "now" || $function == "uuid" ? null : true); // null - don't autofocus this input but check the next one
				}
				input($field, $value, $function, $autofocus);
				if ($autofocus) {
					$autofocus = false;
				}
				echo "\n";
			}
			if (!support("table")) {
				echo "<tr>"
					. "<th><input class='input' name='field_keys[]'>"
					. script("qsl('input').oninput = fieldChange;")
					. "<td class='function'>" . html_select("field_funs[]", Admin::get()->getFieldFunctions(["null" => isset($_GET["select"])]))
					. "<td><input class='input' name='field_vals[]'>"
					. "\n"
				;
			}
			echo "</table>\n";
			echo script("initToggles(gid('form'));");
		}
		echo "<p>\n";
		if ($fields) {
			echo "<input type='submit' class='button default' value='" . lang('Save') . "'>\n";
			if (!isset($_GET["select"])) {
				echo "<input type='submit' class='button' name='insert' value='" . ($update
						? lang('Save and continue edit')
						: lang('Save and insert next')
					) . "' title='Ctrl+Shift+Enter'>\n";
				echo ($update ? script("qsl('input').onclick = function () { return !ajaxForm(this.form, '" . lang('Saving') . "…', this); };") : "");
			}
		}
		echo ($update ? "<input type='submit' class='button' name='delete' value='" . lang('Delete') . "'>" . confirm() . "\n" : "");
		if (isset($_GET["select"])) {
			hidden_fields(["check" => (array) $_POST["check"], "clone" => $_POST["clone"], "all" => $_POST["all"]]);
		}
		?>
		<input type="hidden" name="referer" value="<?php echo h($_POST["referer"] ?? $_SERVER["HTTP_REFERER"]); ?>">
		<input type="hidden" name="save" value="1">
		<input type="hidden" name="token" value="<?php echo get_token(); ?>">
	</form>
	<?php
}
