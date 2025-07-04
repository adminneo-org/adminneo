<?php
// This file is used in both Admin and Editor.

namespace AdminNeo;

/** Get AdminNeo version
* @return string
*/
function version() {
	global $VERSION;
	return $VERSION;
}

/** Unescape database identifier
* @param string text inside ``
* @return string
*/
function idf_unescape($idf) {
	if (!preg_match('~^[`\'"[]~', $idf)) {
		return $idf;
	}
	$last = substr($idf, -1);
	return str_replace($last . $last, $last, substr($idf, 1, -1));
}

/** Escape string to use inside ''
* @param string
* @return string
*/
function escape_string($val) {
	return substr(q($val), 1, -1);
}

/** Remove non-digits from a string
* @param string
* @return string
*/
function number($val) {
	return preg_replace('~[^0-9]+~', '', $val);
}

/** Get regular expression to match numeric types
* @return string
*/
function number_type() {
	return '((?<!o)int(?!er)|numeric|real|float|double|decimal|money)'; // not point, not interval
}

/** Disable magic_quotes_gpc
* @param array e.g. (&$_GET, &$_POST, &$_COOKIE)
* @param bool whether to leave values as is
* @return null modified in place
*/
function remove_slashes($process, $filter = false) {
	if (function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc()) {
		while (list($key, $val) = each($process)) {
			foreach ($val as $k => $v) {
				unset($process[$key][$k]);
				if (is_array($v)) {
					$process[$key][stripslashes($k)] = $v;
					$process[] = &$process[$key][stripslashes($k)];
				} else {
					$process[$key][stripslashes($k)] = ($filter ? $v : stripslashes($v));
				}
			}
		}
	}
}

/** Escape or unescape string to use inside form []
* @param string
* @param bool
* @return string
*/
function bracket_escape($idf, $back = false) {
	// escape brackets inside name="x[]"
	static $trans = [':' => ':1', ']' => ':2', '[' => ':3', '"' => ':4'];
	return strtr($idf, ($back ? array_flip($trans) : $trans));
}

/** Check if connection has at least the given version
*
* @param string required version
* @param string required MariaDB version
* @param ?Connection defaults to $connection
*
* @return bool
*/
function min_version($version, $maria_db = "", ?Connection $connection = null) {
	if (!$connection) {
		$connection = Connection::get();
	}
	$server_info = $connection->getServerInfo();
	if ($maria_db && preg_match('~([\d.]+)-MariaDB~', $server_info, $match)) {
		$server_info = $match[1];
		$version = $maria_db;
	}
	if ($version == "") {
		return false;
	}
	return (version_compare($server_info, $version) >= 0);
}

/**
 * Returns connection charset.
 */
function charset(Connection $connection): string
{
	// Note: SHOW CHARSET would require an extra query
	return (min_version("5.5.3", 0, $connection) ? "utf8mb4" : "utf8");
}

/** Return <script> element
* @param string
* @param string
* @return string
*/
function script($source, $trailing = "\n") {
	return "<script" . nonce() . ">$source</script>$trailing";
}

/** Return <script src> element
* @param string
* @return string
*/
function script_src($url) {
	return "<script src='" . h($url) . "'" . nonce() . "></script>\n";
}

/** Get a nonce="" attribute with CSP nonce
* @return string
*/
function nonce() {
	return ' nonce="' . get_nonce() . '"';
}

/** Get a target="_blank" attribute
* @return string
*/
function target_blank() {
	return ' target="_blank" rel="noreferrer noopener"';
}

/**
 * Escapes string for HTML.
 */
function h(?string $string): string
{
	return $string !== null && $string !== "" ? str_replace("\0", "&#0;", htmlspecialchars($string, ENT_QUOTES, 'utf-8')) : "";
}

function link_files(string $name, array $file_paths): ?string
{
	$filename = generate_linked_file($name, $file_paths); // !compile: generate linked file
	if (!$filename) {
		return null;
	}

	return BASE_URL . "?file=" . urldecode($filename);
}

function icon_solo(string $id): string
{
	return icon($id, "solo");
}

function icon_chevron_down(): string
{
	return icon("chevron-down", "chevron");
}

function icon_chevron_right(): string
{
	return icon("chevron-down", "chevron-right");
}

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
		. ($onclick ? script("qsl('input').onclick = function () { $onclick };", "") : "")
	;
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
* @param string
* @param string
* @param string
* @return string
*/
function html_select($name, $options, $value = "", $onchange = "", $labelled_by = "") {
	return "<select name='" . h($name) . "'"
		. ($labelled_by ? " aria-labelledby='$labelled_by'" : "")
		. ">" . optionlist($options, $value) . "</select>"
		. ($onchange ? script("qsl('select').onchange = function () { $onchange };", "") : "")
	;
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
 * Prints header for hidden fieldset (close by </div></fieldset>).
 */
function print_fieldset_start(string $id, string $legend, string $icon, bool $visible = false, bool $sortable = false): void
{
	echo "<fieldset id='fieldset-$id' class='closable " . (!$visible ? " closed" : "") . "'>";
	echo "<legend><a href='#'>$legend</a></legend>";

	echo icon($icon, "fieldset-icon jsonly");
	echo "<div class='fieldset-content" . ($sortable ? " sortable" : "") . "'>";
}

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
 * Returns INI boolean value.
 */
function ini_bool(string $option): bool
{
	$val = ini_get($option);

	// boolean values set by php_value are strings
	return preg_match('~^(on|true|yes)$~i', $val) || (int) $val;
}

/** Check if SID is necessary
* @return bool
*/
function sid() {
	static $return;
	if ($return === null) { // restart_session() defines SID
		$return = (session_id() && !($_COOKIE && ini_bool("session.use_cookies"))); // $_COOKIE - don't pass SID with permanent login
	}
	return $return;
}

/** Set password to session
* @param string
* @param string
* @param string
* @param string
* @return null
*/
function set_password($vendor, $server, $username, $password) {
	$_SESSION["pwds"][$vendor][$server][$username] = ($_COOKIE["neo_key"] && is_string($password)
		? [encrypt_string($password, $_COOKIE["neo_key"])]
		: $password
	);
}

/** Get password from session
* @return string or null for missing password or false for expired password
*/
function get_password() {
	$return = get_session("pwds");
	if (is_array($return)) {
		$return = ($_COOKIE["neo_key"]
			? decrypt_string($return[0], $_COOKIE["neo_key"])
			: false
		);
	}
	return $return;
}

/** Shortcut for Database::get()->quote($string)
* @param string
* @return string
*/
function q($string) {
	return Connection::get()->quote($string);
}

/** Get list of values from database
* @param string
* @param mixed
* @return array
*/
function get_vals($query, $column = 0) {
	$return = [];
	$result = Connection::get()->query($query);
	if (is_object($result)) {
		while ($row = $result->fetchRow()) {
			$return[] = $row[$column];
		}
	}
	return $return;
}

/** Get keys from first column and values from second
*
* @param string
* @param ?Connection
* @param bool
*
* @return array
*/
function get_key_vals($query, ?Connection $connection = null, $set_keys = true) {
	if (!$connection) {
		$connection = Connection::get();
	}
	$return = [];
	$result = $connection->query($query);
	if (is_object($result)) {
		while ($row = $result->fetchRow()) {
			if ($set_keys) {
				$return[$row[0]] = $row[1];
			} else {
				$return[] = $row[0];
			}
		}
	}
	return $return;
}

/** Get all rows of result
*
* @param string
 * @param Connection
* @param string
*
* @return array of associative arrays
*/
function get_rows($query, ?Connection $connection = null, $error = "<p class='error'>") {
	if (!$connection) {
		$connection = Connection::get();
	}
	$return = [];
	$result = $connection->query($query);
	if (is_object($result)) { // can return true
		while ($row = $result->fetchAssoc()) {
			$return[] = $row;
		}
	} elseif (!$result && !is_object($connection) && $error && (defined("AdminNeo\PAGE_HEADER") || $error == "-- ")) {
		echo $error . error() . "\n";
	}
	return $return;
}

/** Find unique identifier of a row
* @param array
* @param array result of indexes()
* @return array or null if there is no unique identifier
*/
function unique_array($row, $indexes) {
	foreach ($indexes as $index) {
		if (preg_match("~PRIMARY|UNIQUE~", $index["type"])) {
			$return = [];
			foreach ($index["columns"] as $key) {
				if (!isset($row[$key])) { // NULL is ambiguous
					continue 2;
				}
				$return[$key] = $row[$key];
			}
			return $return;
		}
	}
}

/** Escape column key used in where()
* @param string
* @return string
*/
function escape_key($key) {
	if (preg_match('(^([\w(]+)(' . str_replace("_", ".*", preg_quote(idf_escape("_"))) . ')([ \w)]+)$)', $key, $match)) { //! columns looking like functions
		return $match[1] . idf_escape(idf_unescape($match[2])) . $match[3]; //! SQL injection
	}
	return idf_escape($key);
}

/** Create SQL condition from parsed query string
* @param array parsed query string
* @param array
* @return string
*/
function where($where, $fields = []) {
	$conditions = [];

	foreach ((array) $where["where"] as $key => $val) {
		$key = bracket_escape($key, 1); // 1 - back
		$column = escape_key($key);
		$field_type = $fields[$key]["type"] ?? null;

		if (DIALECT == "sql" && $field_type == "json") {
			$conditions[] = "$column = CAST(" . q($val) . " AS JSON)";
		} elseif (DIALECT == "sql" && is_numeric($val) && strpos($val, ".") !== false) {
			// LIKE because of floats but slow with ints.
			$conditions[] = "$column LIKE " . q($val);
		} elseif (DIALECT == "mssql" && strpos($field_type, "datetime") === false) {
			// LIKE because of text. But it does not work with datetime, datetime2 and smalldatetime.
			$conditions[] = "$column LIKE " . q(preg_replace('~[_%[]~', '[\0]', $val));
		} else {
			$conditions[] = "$column = " . (isset($fields[$key]) ? unconvert_field($fields[$key], q($val)) : q($val));
		}

		// Not just [a-z] to catch non-ASCII characters.
		if (DIALECT == "sql" && preg_match('~char|text~', $field_type) && preg_match("~[^ -@]~", $val)) {
			$conditions[] = "$column = " . q($val) . " COLLATE " . charset(Connection::get()) . "_bin";
		}
	}

	foreach ((array) $where["null"] as $key) {
		$conditions[] = escape_key($key) . " IS NULL";
	}

	return implode(" AND ", $conditions);
}

/** Create SQL condition from query string
* @param string
* @param array
* @return string
*/
function where_check($val, $fields = []) {
	parse_str($val, $check);
	remove_slashes([&$check]);
	return where($check, $fields);
}

/** Create query string where condition from value
* @param int condition order
* @param string column identifier
* @param string
* @param string
* @return string
*/
function where_link($i, $column, $value, $operator = "=") {
	return "&where%5B$i%5D%5Bcol%5D=" . urlencode($column) . "&where%5B$i%5D%5Bop%5D=" . urlencode(($value !== null ? $operator : "IS NULL")) . "&where%5B$i%5D%5Bval%5D=" . urlencode($value);
}

/** Get select clause for convertible fields
* @param array
* @param array
* @param array
* @return string
*/
function convert_fields($columns, $fields, $select = []) {
	$return = "";
	foreach ($columns as $key => $val) {
		if ($select && !in_array(idf_escape($key), $select)) {
			continue;
		}
		$as = convert_field($fields[$key]);
		if ($as) {
			$return .= ", $as AS " . idf_escape($key);
		}
	}
	return $return;
}

/** Set cookie valid on current path
* @param string
* @param string
* @param int number of seconds, 0 for session cookie
* @return bool
*/
function cookie($name, $value, $lifetime = 2592000) { // 2592000 - 30 days
	global $HTTPS;
	return header("Set-Cookie: $name=" . urlencode($value)
		. ($lifetime ? "; expires=" . gmdate("D, d M Y H:i:s", time() + $lifetime) . " GMT" : "")
		. "; path=" . preg_replace('~\?.*~', '', $_SERVER["REQUEST_URI"])
		. ($HTTPS ? "; secure" : "")
		. "; HttpOnly; SameSite=lax",
		false);
}

/** Restart stopped session
* @return null
*/
function restart_session() {
	if (!ini_bool("session.use_cookies")) {
		session_start();
	}
}

/** Stop session if possible
* @param bool
* @return null
*/
function stop_session($force = false) {
	$use_cookies = ini_bool("session.use_cookies");
	if (!$use_cookies || $force) {
		session_write_close(); // improves concurrency if a user opens several pages at once, may be restarted later
		if ($use_cookies && @ini_set("session.use_cookies", false) === false) { // @ - may be disabled
			session_start();
		}
	}
}

/** Get session variable for current server
* @param string
* @return mixed
*/
function &get_session($key) {
	return $_SESSION[$key][DRIVER][SERVER][$_GET["username"]];
}

/** Set session variable for current server
* @param string
* @param mixed
* @return mixed
*/
function set_session($key, $val) {
	$_SESSION[$key][DRIVER][SERVER][$_GET["username"]] = $val; // used also in auth.inc.php
}

/** Get authenticated URL
* @param string
* @param string
* @param string
* @param string
* @return string
*/
function auth_url($vendor, $server, $username, $db = null) {
	preg_match('~([^?]*)\??(.*)~', remove_from_uri(implode("|", array_keys(Drivers::getList())) . "|username|" . ($db !== null ? "db|" : "") . session_name()), $match);
	return "$match[1]?"
		. (sid() ? session_name() . "=" . urlencode(session_id()) . "&" : "")
		. urlencode($vendor) . "=" . urlencode($server) . "&"
		. "username=" . urlencode($username)
		. ($db != "" ? "&db=" . urlencode($db) : "")
		. ($match[2] ? "&$match[2]" : "")
	;
}

/** Find whether it is an AJAX request
* @return bool
*/
function is_ajax() {
	return ($_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest");
}

/** Send Location header and exit
* @param string null to only set a message
* @param string
* @return null
*/
function redirect($location, $message = null) {
	if ($message !== null) {
		restart_session();
		$_SESSION["messages"][preg_replace('~^[^?]*~', '', ($location !== null ? $location : $_SERVER["REQUEST_URI"]))][] = $message;
	}
	if ($location !== null) {
		if ($location == "") {
			$location = ".";
		}
		header("Location: $location");
		exit;
	}
}

/** Execute query and redirect if successful
* @param string
* @param string
* @param string
* @param bool
* @param bool
* @param bool
* @param string
* @return bool
*/
function query_redirect($query, $location, $message, $redirect = true, $execute = true, $failed = false, $time = "") {
	global $error;
	if ($execute) {
		$start = microtime(true);
		$failed = !Connection::get()->query($query);
		$time = format_time($start);
	}
	$sql = "";
	if ($query) {
		$sql = Admin::get()->formatMessageQuery($query, $time, $failed);
	}
	if ($failed) {
		$error = error() . $sql . script("initToggles();");
		return false;
	}
	if ($redirect) {
		redirect($location, $message . $sql);
	}
	return true;
}

/** Execute and remember query
* @param string or null to return remembered queries, end with ';' to use DELIMITER
* @return Result|array|bool or [$queries, $time] if $query = null
*/
function queries($query) {
	static $queries = [];
	static $start;
	if (!$start) {
		$start = microtime(true);
	}
	if ($query === null) {
		// return executed queries
		return [implode("\n", $queries), format_time($start)];
	}

	if (support("sql")) {
		$queries[] = (preg_match('~;$~', $query) ? "DELIMITER ;;\n$query;\nDELIMITER " : $query) . ";";

		return Connection::get()->query($query);
	} else {
		// Save the query for later use in a flesh message. TODO: This is so ugly.
		$queries[] = $query;
		return [];
	}
}

/** Apply command to all array items
* @param string
* @param array
* @param callback
* @return bool
*/
function apply_queries($query, $tables, $escape = 'AdminNeo\table') {
	foreach ($tables as $table) {
		if (!queries("$query " . $escape($table))) {
			return false;
		}
	}
	return true;
}

/** Redirect by remembered queries
* @param string
* @param string
* @param bool
* @return bool
*/
function queries_redirect($location, $message, $redirect) {
	list($queries, $time) = queries(null);
	return query_redirect($queries, $location, $message, $redirect, false, !$redirect, $time);
}

/** Format elapsed time
* @param float output of microtime(true)
* @return string HTML code
*/
function format_time($start) {
	return lang('%.3f s', max(0, microtime(true) - $start));
}

/** Get relative REQUEST_URI
* @return string
*/
function relative_uri() {
	return str_replace(":", "%3a", preg_replace('~^[^?]*/([^?]*)~', '\1', $_SERVER["REQUEST_URI"]));
}

/** Remove parameter from query string
* @param string
* @return string
*/
function remove_from_uri($param = "") {
	return substr(preg_replace("~(?<=[?&])($param" . (sid() ? "" : "|" . session_name()) . ")=[^&]*&~", '', relative_uri() . "&"), 0, -1);
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

/** Get file contents from $_FILES
* @param string
* @param bool
* @param string
* @return mixed int for error, string otherwise
*/
function get_file($key, $decompress = false, $delimiter = "") {
	$file = $_FILES[$key];
	if (!$file) {
		return null;
	}
	foreach ($file as $key => $val) {
		$file[$key] = (array) $val;
	}
	$return = '';
	foreach ($file["error"] as $key => $error) {
		if ($error) {
			return $error;
		}
		$name = $file["name"][$key];
		$tmp_name = $file["tmp_name"][$key];
		$content = file_get_contents($decompress && preg_match('~\.gz$~', $name)
			? "compress.zlib://$tmp_name"
			: $tmp_name
		); //! may not be reachable because of open_basedir

		if ($decompress) {
			$start = substr($content, 0, 3);
			if (function_exists("iconv") && preg_match("~^\xFE\xFF|^\xFF\xFE~", $start)) {
				$content = iconv("utf-16", "utf-8", $content);
			} elseif ($start == "\xEF\xBB\xBF") { // UTF-8 BOM
				$content = substr($content, 3);
			}
		}

		if ($delimiter) {
			if (!preg_match("~$delimiter\\s*\$~", $content)) {
				$content .= ";";
			}
			$content .= "\n\n";
		}

		$return .= $content;
	}

	return $return;
}

/** Determine upload error
* @param int
* @return string
*/
function upload_error($error) {
	$max_size = ($error == UPLOAD_ERR_INI_SIZE ? ini_get("upload_max_filesize") : 0); // post_max_size is checked in index.php
	return ($error ? lang('Unable to upload a file.') . ($max_size ? " " . lang('Maximum allowed file size is %sB.', $max_size) : "") : lang('File does not exist.'));
}

/** Create repeat pattern for preg
* @param string
* @param int
* @return string
*/
function repeat_pattern($pattern, $length) {
	// fix for Compilation failed: number too big in {} quantifier
	return str_repeat("$pattern{0,65535}", $length / 65535) . "$pattern{0," . ($length % 65535) . "}"; // can create {0,0} which is OK
}

/** Check whether the string is in UTF-8
* @param string
* @return bool
*/
function is_utf8($val) {
	// don't print control chars except \t\r\n
	return (preg_match('~~u', $val) && !preg_match('~[\0-\x8\xB\xC\xE-\x1F]~', $val));
}

/**
 * Truncates UTF-8 string.
 *
 * @return string Escaped string with appended ellipsis.
 */
function truncate_utf8(string $string, int $length = 80): string
{
	if ($string == "") return "";

	// ~s causes trash in $match[2] under some PHP versions, (.|\n) is slow.
	if (!preg_match("(^(" . repeat_pattern("[\t\r\n -\x{10FFFF}]", $length) . ")($)?)u", $string, $match)) {
		preg_match("(^(" . repeat_pattern("[\t\r\n -~]", $length) . ")($)?)", $string, $match);
	}

	// Tag <i> is required for inline editing of long texts (see strpos($val, "<i>…</i>");).
	return h($match[1]) . (isset($match[2]) ? "" : "<i>…</i>");
}

/** Format decimal number
* @param int
* @return string
*/
function format_number($val) {
	return strtr(number_format($val, 0, ".", lang(',')), preg_split('~~u', lang('0123456789'), -1, PREG_SPLIT_NO_EMPTY));
}

/** Generate friendly URL
* @param string
* @return string
*/
function friendly_url($val) {
	// used for blobs and export
	return preg_replace('~\W~i', '-', $val);
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

/** Get status of a single table and fall back to name on error
* @param string
* @param bool
* @return array
*/
function table_status1($table, $fast = false) {
	$return = table_status($table, $fast);
	return ($return ?: ["Name" => $table]);
}

/** Find out foreign keys for each column
* @param string
* @return array [$col => []]
*/
function column_foreign_keys($table) {
	$return = [];
	foreach (Admin::get()->getForeignKeys($table) as $foreign_key) {
		foreach ($foreign_key["source"] as $val) {
			$return[$val][] = $foreign_key;
		}
	}
	return $return;
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

	$threshold = Admin::get()->getConfig()->getEnumAsSelectThreshold();
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
* @return null
*/
function input($field, $value, $function) {
	$name = h(bracket_escape($field["field"]));

	$types = Driver::get()->getTypes();
	$json_type = Admin::get()->detectJson($field["type"], $value, true);

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
	$attrs = " name='fields[$name]' $disabled";

	// Function list.
	$functions = (isset($_GET["select"]) || $reset ? ["orig" => lang('original')] : []) + Admin::get()->getFieldFunctions($field);
	$has_function = (in_array($function, $functions) || isset($functions[$function]));

	echo "<td class='function'>";

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
		if (DIALECT == 'sql' && min_version(5.6) && preg_match('~time~', $field["type"])) {
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

/** Compute fields() from $_POST edit data
* @return array
*/
function fields_from_edit() {
	$return = [];
	foreach ((array) $_POST["field_keys"] as $key => $val) {
		if ($val != "") {
			$val = bracket_escape($val);
			$_POST["function"][$val] = $_POST["field_funs"][$key];
			$_POST["fields"][$val] = $_POST["field_vals"][$key];
		}
	}
	foreach ((array) $_POST["fields"] as $key => $val) {
		$name = bracket_escape($key, 1); // 1 - back
		$return[$name] = [
			"field" => $name,
			"privileges" => ["insert" => 1, "update" => 1, "where" => 1, "order" => 1],
			"null" => 1,
			"auto_increment" => ($key == Driver::get()->primary),
		];
	}
	return $return;
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
 * Sends headers for export.
 *
 * @return string Extension.
 */
function dump_headers(string $identifier, bool $multi_table = false): string
{
	$identifier = friendly_url($identifier) . date("-Ymd-His");

	$extension = Admin::get()->sendDumpHeaders($identifier, $multi_table);

	$output = $_POST["output"];
	if ($output != "text") {
		header("Content-Disposition: attachment; filename=$identifier.$extension" . ($output != "file" && preg_match('~^[0-9a-z]+$~', $output) ? ".$output" : ""));
	}

	session_write_close();
	ob_flush();
	flush();

	return $extension;
}

/** Print CSV row
* @param array
* @return null
*/
function dump_csv($row) {
	foreach ($row as $key => $val) {
		if (preg_match('~["\n,;\t]|^0|\.\d*0$~', $val) || $val === "") {
			$row[$key] = '"' . str_replace('"', '""', $val) . '"';
		}
	}
	echo implode(($_POST["format"] == "csv" ? "," : ($_POST["format"] == "tsv" ? "\t" : ";")), $row) . "\r\n";
}

/** Apply SQL function
* @param string
* @param string escaped column identifier
* @return string
*/
function apply_sql_function($function, $column) {
	return ($function ? ($function == "unixepoch" ? "DATETIME($column, '$function')" : ($function == "count distinct" ? "COUNT(DISTINCT " : strtoupper("$function(")) . "$column)") : $column);
}

/**
 * Returns a path of the temporary directory.
 */
function get_temp_dir(): string
{
	$path = ini_get("upload_tmp_dir"); // session_save_path() may contain other storage path
	if (!$path) {
		$path = sys_get_temp_dir();
	}

	return $path;
}

/**
 * Opens and exclusively lock a file.
 *
 * @param string $filename
 * @return resource|null
 */
function open_file_with_lock($filename)
{
	// Avoid symlink following (https://cwe.mitre.org/data/definitions/61.html).
	if (is_link($filename)) {
		return null;
	}

	$file = fopen($filename, "c+");
	if (!$file) {
		return null;
	}

	chmod($filename, 0660);

	if (!flock($file, LOCK_EX)) {
		fclose($file);
		return null;
	}

	return $file;
}

/**
 * Writes and unlocks a file.
 *
 * @param resource $file
 * @param string $data
 */
function write_and_unlock_file($file, $data)
{
	rewind($file);
	fwrite($file, $data);
	ftruncate($file, strlen($data));

	unlock_file($file);
}

/**
 * Unlocks and closes the file.
 *
 * @param resource $file
 */
function unlock_file($file)
{
	flock($file, LOCK_UN);
	fclose($file);
}

/**
 * Reads password from file adminneo.key in temporary directory or create one.
 *
 * @param $create bool
 * @return string|false Returns false if the file can not be created.
 * @throws \Random\RandomException
 */
function get_private_key($create)
{
	$filename = get_temp_dir() . "/adminneo.key";

	if (!$create && !file_exists($filename)) {
		return false;
	}

	$file = open_file_with_lock($filename);
	if (!$file) {
		return false;
	}

	$key = stream_get_contents($file);
	if (!$key) {
		$key = get_random_string();
		write_and_unlock_file($file, $key);
	} else {
		unlock_file($file);
	}

	return $key;
}

/**
 * Returns a random 32 characters long string.
 *
 * @param $binary bool
 * @return string
 * @throws \Random\RandomException
 */
function get_random_string($binary = false)
{
	$bytes = function_exists('random_bytes') ? random_bytes(32) : uniqid(mt_rand(), true);

	return $binary ? $bytes : md5($bytes);
}

/** Format value to use in select
* @param string
* @param string
* @param ?array
* @param int
* @return string HTML
*/
function select_value($val, $link, $field, $text_length) {
	if (is_array($val)) {
		$return = "";
		foreach ($val as $k => $v) {
			$return .= "<tr>"
				. ($val != array_values($val) ? "<th>" . h($k) : "")
				. "<td>" . select_value($v, $link, $field, $text_length)
			;
		}
		return "<table>$return</table>";
	}
	if (!$link) {
		$link = Admin::get()->getFieldValueLink($val, $field);
	}
	$return = $field ? Admin::get()->formatFieldValue($val, $field) : $val;
	if ($return !== null) {
		if (!is_utf8($return)) {
			$return = "\0"; // htmlspecialchars of binary data returns an empty string
		} elseif ($text_length != "" && is_shortable($field)) {
			$return = truncate_utf8($return, max(0, +$text_length)); // usage of LEFT() would reduce traffic but complicate query - expected average speedup: .001 s VS .01 s on local network
		} else {
			$return = h($return);
		}
	}
	return Admin::get()->formatSelectionValue($return, $link, $field, $val);
}

/** Check whether the string is e-mail address
* @param string
* @return bool
*/
function is_mail($value) {
	return is_string($value) && filter_var($value, FILTER_VALIDATE_EMAIL);
}

/** Check whether the string is web URL address
* @param string
* @return bool
*/
function is_web_url($value) {
	if (!is_string($value) || !preg_match('~^https?://~i', $value)) {
		return false;
	}

	$components = parse_url($value);
    if (!$components) {
        return false;
    }

    // Encode URL path. If path was encoded already, it will be encoded twice, but we are OK with that.
	$encodedParts = array_map('urlencode', explode('/', $components['path']));
	$url = str_replace($components['path'], implode('/', $encodedParts), $value);

	parse_str($components['query'], $params);
	$url = str_replace($components['query'], http_build_query($params), $url);

	return (bool)filter_var($url, FILTER_VALIDATE_URL);
}

/**
 * Checks whether field should be shortened.
 */
function is_shortable(?array $field): bool
{
	return $field ? preg_match('~char|text|json|lob|geometry|point|linestring|polygon|string|bytea~', $field["type"]) : false;
}

/** Get query to compute number of found rows
* @param string
* @param array
* @param bool
* @param array
* @return string
*/
function count_rows($table, $where, $is_group, $group) {
	$query = " FROM " . table($table) . ($where ? " WHERE " . implode(" AND ", $where) : "");
	return ($is_group && (DIALECT == "sql" || count($group) == 1)
		? "SELECT COUNT(DISTINCT " . implode(", ", $group) . ")$query"
		: "SELECT COUNT(*)" . ($is_group ? " FROM (SELECT 1$query GROUP BY " . implode(", ", $group) . ") x" : $query)
	);
}

/** Run query which can be killed by AJAX call after timing out
* @param string
* @return array of strings
*/
function slow_query($query) {
	global $token;
	$db = Admin::get()->getDatabase();
	$timeout = Admin::get()->getQueryTimeout();
	$slow_query = Driver::get()->slowQuery($query, $timeout);
	if (!$slow_query && support("kill") && ($connection = connect()) && ($db == "" || $connection->selectDatabase($db))) {
		$kill = $connection->getValue(connection_id()); // MySQL and MySQLi can use thread_id but it's not in PDO_MySQL
		?>
<script<?php echo nonce(); ?>>
var timeout = setTimeout(function () {
	ajax('<?php echo js_escape(ME); ?>script=kill', function () {
	}, 'kill=<?php echo $kill; ?>&token=<?php echo $token; ?>');
}, <?php echo 1000 * $timeout; ?>);
</script>
<?php
	} else {
		$connection = null;
	}
	ob_flush();
	flush();
	$return = @get_key_vals(($slow_query ?: $query), $connection, false); // @ - may be killed
	if ($connection) {
		echo script("clearTimeout(timeout);");
		ob_flush();
		flush();
	}
	return $return;
}

/** Generate BREACH resistant CSRF token
* @return string
*/
function get_token() {
	$rand = rand(1, 1e6);
	return ($rand ^ $_SESSION["token"]) . ":$rand";
}

/** Verify if supplied CSRF token is valid
* @return bool
*/
function verify_token() {
	list($token, $rand) = explode(":", $_POST["token"]);
	return ($rand ^ $_SESSION["token"]) == $token;
}

function lzw_decompress(string $binary): string
{
	// Convert binary string to codes.
	$dictionary_count = 256;
	$bits = 8; // ceil(log($dictionary_count, 2))
	$codes = [];
	$rest = 0;
	$rest_length = 0;

	for ($i = 0; $i < strlen($binary); $i++) {
		$rest = ($rest << 8) + ord($binary[$i]);
		$rest_length += 8;

		if ($rest_length >= $bits) {
			$rest_length -= $bits;
			$codes[] = $rest >> $rest_length;
			$rest &= (1 << $rest_length) - 1;

			$dictionary_count++;
			if ($dictionary_count >> $bits) {
				$bits++;
			}
		}
	}

	// Decompress.
	$dictionary = range("\0", "\xFF");
	$return = $word = "";

	foreach ($codes as $i => $code) {
		$element = $dictionary[$code];
		if (!isset($element)) {
			$element = $word . $word[0];
		}

		$return .= $element;

		if ($i) {
			$dictionary[] = $word . $element[0];
		}
		$word = $element;
	}

	return $return;
}

/**
 * @param string $text Help text.
 * @param bool $side Side position.
 *
 * @return string
 */
function help_script($text, $side = false)
{
	return script("initHelpFor(qsl('select, input'), '" . h($text) . "', $side);", "");
}

/**
 * @param string $command JS expression for returning the help text.
 * @param bool $side Side position.
 *
 * @return string
 */
function help_script_command($command, $side = false)
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
	global $token, $error;
	$table_name = Admin::get()->getTableName(table_status1($table, true));
	$title = $update ? lang('Edit') : lang('Insert');

	page_header("$title: $table_name", $error, ["select" => [$table, $table_name], $title]);
	if ($row === false) {
		echo "<p class='error'>" . lang('No rows.') . "\n";
		return;
	}
	?>
<form action="" method="post" enctype="multipart/form-data" id="form">
<?php
	if (!$fields) {
		echo "<p class='error'>" . lang('You have no privileges to update this table.') . "\n";
	} else {
		echo "<table class='box'>" . script("qsl('table').onkeydown = onEditingKeydown;");

		$first = 0;
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
			if ($field["auto_increment"] || $function == "now" || $function == "uuid") {
				$first++;
			}
			input($field, $value, $function);
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
	echo ($update ? "<input type='submit' class='button' name='delete' value='" . lang('Delete') . "'>" . confirm() . "\n"
		: ($_POST || !$fields ? "" : script("qsa('td', gid('form'))[2*$first+1].firstChild.focus();"))
	);
	if (isset($_GET["select"])) {
		hidden_fields(["check" => (array) $_POST["check"], "clone" => $_POST["clone"], "all" => $_POST["all"]]);
	}
	?>
<input type="hidden" name="referer" value="<?php echo h($_POST["referer"] ?? $_SERVER["HTTP_REFERER"]); ?>">
<input type="hidden" name="save" value="1">
<input type="hidden" name="token" value="<?php echo $token; ?>">
</form>
<?php
}
