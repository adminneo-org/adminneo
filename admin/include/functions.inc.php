<?php

namespace AdminNeo;

/**
 * @deprecated
 */
function version(): string
{
	return VERSION;
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

/** Shortcut for Database::get()->quote($string)
* @param string
* @return string
*/
function q($string) {
	return Connection::get()->quote($string);
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

/**
 * @deprecated
 *
 * Checks if connection has at least the given version.
 */
function min_version(?string $version, ?string $maria_db = null, ?Connection $connection = null): bool
{
	if (!$connection) {
		$connection = Connection::get();
	}

	if ($maria_db && $connection->isMariaDB()) {
		$version = $maria_db;
	}

	return $version && $connection->isMinVersion($version);
}

/**
 * Returns connection charset.
 */
function charset(Connection $connection): string
{
	// Note: SHOW CHARSET would require an extra query
	return ($connection->isMinVersion("5.5.3") ? "utf8mb4" : "utf8");
}

function link_files(string $name, array $file_paths): ?string
{
	$filename = generate_linked_file($name, $file_paths); // !compile: generate linked file
	if (!$filename) {
		return null;
	}

	return BASE_URL . "?file=" . urldecode($filename);
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

/**
 * Saves driver name for given server.
 */
function save_driver_name(string $driver, string $server, string $name): void
{
	restart_session();
	$_SESSION["drivers"][$driver][$server] = $name;
	stop_session();
}

/**
 * Returns driver name for the given server.
 */
function get_driver_name(string $driver, ?string $server = null): string
{
	return $_SESSION["drivers"][$driver][$server] ?? Drivers::get($driver);
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

/**
 * Sets cookie valid on the current path.
 *
 * @param int $lifetime Number of seconds, 0 for session cookie, 2592000 = 30 days.
 */
function cookie(string $name, string $value, int $lifetime = 2592000): void
{
	header("Set-Cookie: $name=" . urlencode($value)
		. ($lifetime ? "; expires=" . gmdate("D, d M Y H:i:s", time() + $lifetime) . " GMT" : "")
		. "; path=" . preg_replace('~\?.*~', '', $_SERVER["REQUEST_URI"])
		. (HTTPS ? "; secure" : "")
		. "; HttpOnly; SameSite=lax",
		false);
}

/**
 * @deprecated
 *
 * Returns settings stored in a cookie.
 */
function get_settings(string $cookie = "neo_settings"): array
{
	parse_str($_COOKIE[$cookie] ?? "", $settings);

	return $settings;
}

/**
 * @deprecated
 *
 * Returns setting stored in a cookie.
 */
function get_setting(string $key, string $cookie = "neo_settings"): ?string
{
	$settings = get_settings($cookie);

	return $settings[$key] ?? null;
}

/**
 * @deprecated
 *
 * Stores settings to a cookie.
 */
function save_settings(array $settings, string $cookie = "neo_settings"): void
{
	cookie($cookie, http_build_query($settings + get_settings($cookie)));
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
	$uri = remove_from_uri(implode("|", array_keys(Drivers::getList()))
		. "|username|ext|"
		. ($db !== null ? "db|" : "")
		. ($vendor == 'mssql' || $vendor == 'pgsql' ? "" : "ns|") // we don't have access to support() here
		. session_name())
	;
	preg_match('~([^?]*)\??(.*)~', $uri, $match);
	return "$match[1]?"
		. (sid() ? session_name() . "=" . urlencode(session_id()) . "&" : "")
		. urlencode($vendor) . "=" . urlencode($server) . "&"
		. ($_GET["ext"] ? "ext=" . urlencode($_GET["ext"]) . "&" : "")
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
	if ($execute) {
		$start = microtime(true);
		$failed = !Connection::get()->query($query);
		$time = format_time($start);
	}

	$sql = $query ? Admin::get()->formatMessageQuery($query, $time, $failed) : "";

	if ($failed) {
		Admin::get()->addError(error() . $sql . script("initToggles();"));
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
	$db = Admin::get()->getDatabase();
	$timeout = Admin::get()->getQueryTimeout();
	$slow_query = Driver::get()->slowQuery($query, $timeout);
	if (!$slow_query && support("kill") && ($connection = connect()) && ($db == "" || $connection->selectDatabase($db))) {
		$kill = $connection->getValue(connection_id()); // MySQL and MySQLi can use thread_id but it's not in PDO_MySQL
		?>
<script<?php echo nonce(); ?>>
	const timeout = setTimeout(() => {
		ajax('<?php echo js_escape(ME); ?>script=kill', function() {
		}, 'kill=<?php echo $kill; ?>&token=<?php echo get_token(); ?>');
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
