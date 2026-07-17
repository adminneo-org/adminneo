<?php

namespace AdminNeo;

use Exception;

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

/** Remove non-digits from a string; used instead of intval() to not corrupt big numbers
* @param numeric-string
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
* @param mixed[] $values
* @param bool $filter whether to leave values as is
* @return mixed[]
*/
function remove_slashes(array $values, bool $filter = false): array {
	$return = [];
	foreach ($values as $key => $val) {
		$return[stripslashes($key)] = (is_array($val)
			? remove_slashes($val, $filter)
			: ($filter ? $val : stripslashes($val))
		);
	}
	return $return;
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

/**
 * Returns INI bytes value.
 */
function ini_bytes(string $ini): int
{
	$val = ini_get($ini);

	switch (strtolower(substr($val, -1))) {
		case 'g': $val = (int)$val * 1024; // no break
		case 'm': $val = (int)$val * 1024; // no break
		case 'k': $val = (int)$val * 1024;
	}

	return $val;
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

/**
 * Saves login into the session.
 *
 * @param string|false $password False in case of an encryption error.
 */
function save_login(string $driver, string $server, string $username, $password, string $db = ""): void
{
	$key = $_COOKIE["neo_key"] ?? null;
	$_SESSION["pwds"][$driver][$server][$username] = $key ? [encrypt_string($password, $key)] : $password;

	$_SESSION["db"][$driver][$server][$username][$db] = true;
}

/**
 * Deletes saved login in session.
 */
function delete_login(string $driver, string $server, string $username): void
{
	unset($_SESSION["pwds"][$driver][$server][$username]);
	unset($_SESSION["db"][$driver][$server][$username]);
}

/**
 * Returns password from session
 *
 * @return string|false|null null for missing password or false for expired password.
 */
function get_password()
{
	$password = get_session("pwds");

	if (is_array($password)) {
		return $_COOKIE["neo_key"] ? decrypt_string($password[0], $_COOKIE["neo_key"]) : false;
	}

	return $password;
}

/** Get list of values from database
* @param string
* @param array-key
* @return list<string>
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
* @return string[]
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
* @return list<string[]> of associative arrays
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

/**
 * Finds unique identifier of a row.
 *
 * @param string[] $row
 * @param array[] $indexes Result of indexes().
 *
 * @return string[]|null null if there is no unique identifier.
 */
function unique_array(array $row, array $indexes): ?array
{
	foreach ($indexes as $index) {
		if (!preg_match("~PRIMARY|UNIQUE~", $index["type"]) && !$index["partial"]) {
			continue;
		}

		$unique = [];
		foreach ($index["columns"] as $key) {
			if (!isset($row[$key])) { // NULL is ambiguous
				continue 2;
			}
			$unique[$key] = $row[$key];
		}

		return $unique;
	}

	return null;
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
* @param array[]
* @return string
*/
function where($where, $fields = []) {
	$conditions = [];

	foreach ((array) $where["where"] as $key => $val) {
		$key = bracket_escape($key, true);
		$column = escape_key($key);
		$field_type = $fields[$key]["type"] ?? null;
		$full_field_type = $fields[$key]["full_type"] ?? null;

		if (DIALECT == "sql" && $field_type == "json") {
			$conditions[] = "$column = CAST(" . q($val) . " AS JSON)";
		} elseif (DIALECT == "pgsql" && preg_match('~^jsonb?$~', $full_field_type)) {
			$conditions[] = "$column::jsonb = " . q($val) . "::jsonb";
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
* @param array[]
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

/**
 * Returns select clause for convertible fields.
 *
 * @param array $columns
 * @param array[] $fields
 * @param list<string> $select
 *
 * @return string
 */
function convert_fields(array $columns, array $fields, array $select = []): string
{
	$result = "";

	foreach ($columns as $key => $val) {
		if ($select && !in_array(idf_escape($key), $select)) {
			continue;
		}

		$as = convert_field($fields[$key]);
		if ($as) {
			$result .= ", $as AS " . idf_escape($key);
		}
	}

	return $result;
}

/**
 * Returns path for a cookie.
 */
function cookie_path(): string
{
	return strtr(preg_replace('~\?.*~', '', $_SERVER["REQUEST_URI"]), [";" => "%3B", "," => "%2C"]);
}

/**
 * Sets cookie valid on the current path.
 *
 * @param int $lifetime Number of seconds, 0 for session cookie, 2592000 = 30 days.
 */
function cookie(string $name, string $value, int $lifetime = 2592000): void
{
	header("Set-Cookie: $name=" . rawurlencode($value)
		. ($lifetime ? "; expires=" . gmdate("D, d M Y H:i:s", time() + $lifetime) . " GMT" : "")
		. "; path=" . cookie_path()
		. (HTTPS ? "; secure" : "")
		. "; HttpOnly; SameSite=lax",
		false);
}

/**
 * Returns contents from a URL.
 *
 * @param resource $context
 * @return array{0: string|false, 1: string[]} [$contents, $headers]
 */
function get_url(string $url, $context): array
{
	$return = @file_get_contents($url, false, $context);
	if (function_exists('http_get_last_response_headers')) {
		$http_response_header = http_get_last_response_headers() ?? [];
	}

	return [$return, $http_response_header ?? []];
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
*/
function restart_session(): void {
	if (!ini_bool("session.use_cookies") && session_status() == PHP_SESSION_NONE) {
		session_start();
	}
}

/** Stop session if possible
* @param bool
*/
function stop_session($force = false): void {
	$use_cookies = ini_bool("session.use_cookies");
	if (!$use_cookies || $force) {
		session_write_close(); // improves concurrency if a user opens several pages at once, may be restarted later
		if ($use_cookies && @ini_set("session.use_cookies", "0") === false) { // @ - may be disabled
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

/**
 * Redirects to location and/or set a message.
 *
 * @param ?string $location null to only set a message.
 */
function redirect(?string $location, ?string $message = null): void
{
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

/**
 * Executes SQL query and redirect if successful
 */
function query_redirect(string $query, ?string $location, string $message, bool $redirect = true, bool $execute = true, bool $failed = false, string $time = ""): bool
{
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

/**
 * Redirects by remembered queries.
 */
function queries_redirect(?string $location, string $message, bool $redirect): bool
{
	$queries = implode("\n", Queries::$queries);
	$time = format_time(Queries::$start);

	return query_redirect($queries, $location, $message, $redirect, false, !$redirect, $time);
}

class Queries {
	/** @var string[] */
	static $queries = [];

	/** @var float */
	static $start = 0.0;
}

/**
 * Executes and remembers SQL query.
 *
 * @param string $query Ends with ';' to use DELIMITER.
 *
 * @return Result|array|bool
 */
function queries(string $query)
{
	if (!Queries::$start) {
		Queries::$start = microtime(true);
	}

	if (support("sql")) {
		Queries::$queries[] = (preg_match('~;$~', $query) ? "DELIMITER ;;\n$query;\nDELIMITER " : $query) . ";";

		return Connection::get()->query($query);
	} else {
		// Save the query for later use in a flesh message. TODO: This is so ugly.
		Queries::$queries[] = $query;
		return [];
	}
}

/**
 * Applies SQL query to all array items (tables, views, databases, etc.).
 *
 * @param string $query
 * @param list<string> $tables
 * @param callable(string):string $escape
 *
 * @return bool
 */
function apply_queries(string $query, array $tables, $escape = 'AdminNeo\table'): bool
{
	foreach ($tables as $table) {
		if (!queries("$query " . $escape($table))) {
			return false;
		}
	}

	return true;
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

/** Format decimal number
* @param float|numeric-string
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
* @return array one element from table_status()
*/
function table_status1($table, $fast = false) {
	$return = table_status($table, $fast);
	return ($return ? reset($return) : ["Name" => $table]);
}

/** Find out foreign keys for each column
* @param string
* @return list<string>[] [$col => []]
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
* @return array[] same as fields()
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
		$name = bracket_escape($key, true);
		$return[$name] = [
			"field" => $name,
			"full_type" => "varchar",
			"type" => "varchar",
			"privileges" => ["insert" => 1, "update" => 1, "where" => 1, "order" => 1],
			"null" => true,
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
	if (!ob_get_level()) {
		ob_start(null, 4096);
	}
	ob_flush();
	flush();

	return $extension;
}

/** Print CSV row
* @param string[]
*/
function dump_csv($row): void {
	$tsv = $_POST["format"] == "tsv";
	foreach ($row as $key => $val) {
		if (preg_match('~["\n]|^0[^.]|\.\d*0$|' . ($tsv ? '\t' : '[,;]|^$') . '~', $val)) {
			$row[$key] = '"' . str_replace('"', '""', $val) . '"';
		}
	}
	echo implode(($_POST["format"] == "csv" ? "," : ($tsv ? "\t" : ";")), $row) . "\r\n";
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

	$file = @fopen($filename, "c+"); // @ - may not be writable
	if (!$file) {
		return null;
	}

	@chmod($filename, 0660); // @ - may not be permitted

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
 * Returns the first element of an array.
 *
 * @return mixed|false The value of the first array element, or false if the array is empty.
 */
function first(array $array)
{
	// reset(f()) triggers a notice
	return reset($array);
}

/**
 * Reads password from file adminneo.key in temporary directory or create one.
 *
 * @return string|false Returns false if the file can not be created.
 * @throws Exception
 */
function get_private_key(bool $create)
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
		$key = Random::strongKey();
		write_and_unlock_file($file, $key);
	} else {
		unlock_file($file);
	}

	return $key;
}

/**
 * @deprecated
 *
 * Returns a random string with 256 bits of entropy.

 * @throws Exception
 */
function get_random_string(): string
{
	return Random::strongKey();
}

/** Format value to use in select
* @param string|string[]|list<string[]>
* @param string
* @param array{type: string, full_type?: string}
* @param ?int
* @return string HTML
*/
function select_value($val, $link, $field, $text_length) {
	if (is_array($val)) {
		$return = "";
		if (array_filter($val, 'is_array') == array_values($val)) { // list of arrays
			$keys = [];
			foreach ($val as $v) {
				$keys += array_fill_keys(array_keys($v), null);
			}
			foreach (array_keys($keys) as $k) {
				$return .= "<th>" . h($k);
			}
			foreach ($val as $v) {
				$return .= "<tr>";
				foreach (array_merge($keys, $v) as $v2) {
					$return .= "<td>" . select_value($v2, $link, $field, $text_length);
				}
			}
		} else {
			foreach ($val as $k => $v) {
				$return .= "<tr>"
					. ($val != array_values($val) ? "<th>" . h($k) : "")
					. "<td>" . select_value($v, $link, $field, $text_length);
			}
		}
		return "<table>$return</table>";
	}

	$scalar_type = "";
	if ($field && $val !== null &&
		($text_length === null || strlen($val) <= $text_length) &&
		($values = Driver::get()->explodeArrayValue($val, $field["full_type"], $scalar_type))
	) {
		$scalar_field = $field;
		$scalar_field["type"] = $scalar_field["full_type"] = $scalar_type;

		$return = select_array_value($values, $val, $link, $scalar_field, $text_length);

		return Driver::get()->implodeArrayValues($return, $field["full_type"]);
	}

	if (!$link) {
		$link = Admin::get()->getFieldValueLink($val, $field);
	}
	if ($field) {
		$val = Connection::get()->formatValue($val, $field);
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

function select_array_value(array $values, string $val, string $link, array $field, ?int $text_length): array
{
	$result = [];

	foreach ($values as $value) {
		if (is_array($value)) {
			$result[] = select_array_value($value, $val, $link, $field, $text_length);
		} else {
			$l = preg_replace('~(where%5B\d+%5D%5Bval%5D=)' . preg_quote(urlencode($val)) . "~", '${1}' . urlencode($value), $link);
			$result[] = select_value($value, $l, $field, $text_length);
		}
	}

	return $result;
}

/**
 * Checks whether the field type is blob or equivalent.
 *
 * @param ?array $field Single field returned from fields().
 */
function is_blob(array $field): bool
{
	$types = Driver::get()->getStructuredTypes();
	$type = lang('User types');

	return preg_match('~blob|bytea|raw|file~', $field["type"]) && !in_array($field["type"], $types[$type] ?? []);
}

/**
 * Checks whether the string is e-mail address.
 *
 * @param mixed $value
 */
function is_mail($value): bool
{
	return is_string($value) && filter_var($value, FILTER_VALIDATE_EMAIL);
}

/**
 * Check whether the value is web URL address.
 */
function is_web_url($value): bool
{
	if (!is_string($value) || !preg_match('~^(https?:)?//~i', $value)) {
		return false;
	}

	$components = parse_url($value);
	if (!$components) {
		return false;
	}

	$url = $value;

	// Encode URL path. If path was encoded already, it will be encoded twice, but we are OK with that.
	if (isset($components['path'])) {
		$encodedParts = array_map('urlencode', explode('/', $components['path']));
		$url = str_replace($components['path'], implode('/', $encodedParts), $url);
	}

	if (isset($components['query'])) {
		parse_str($components['query'], $params);
		$url = str_replace($components['query'], http_build_query($params), $url);
	}

	// FILTER_VALIDATE_URL requires a scheme, add a dummy one for //domain.tld values.
	if (!isset($components['scheme'])) {
		$url = "https:$url";
	}

	return (bool)filter_var($url, FILTER_VALIDATE_URL);
}

/**
 * Checks whether field should be shortened.
 */
function is_shortable(?array $field): bool
{
	return $field && !preg_match('~' . number_type() . '|date|time|year~', $field["type"]);
}

/** Split server into host and (port or socket)
 * @return array{0: string, 1: string}
 */
function host_port(string $server) {
	return (preg_match('~^(\[(.+)]|([^:]*)):([^:]+)$~', $server, $match) // [a:b] - IPv6
		? [$match[2] . $match[3], $match[4]]
		: [$server, '']
	);
}

/** Get query to compute number of found rows
* @param string
* @param list<string>
* @param bool
* @param list<string>
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
* @return string[]
*/
function slow_query($query) {
	$db = Admin::get()->getDatabase();
	$timeout = Admin::get()->getQueryTimeout();
	$slow_query = Driver::get()->slowQuery($query, $timeout);
	$connection = null;
	if (!$slow_query && support("kill")) {
		$connection = connect();
		if ($connection && ($db == "" || $connection->selectDatabase($db))) {
			$kill = $connection->getValue(connection_id()); // MySQL and MySQLi can use thread_id but it's not in PDO_MySQL
			?>
<script<?php echo nonce(); ?>>
	const timeout = setTimeout(() => {
		ajax('<?php echo js_escape(ME); ?>script=kill', function() {
		}, 'kill=<?php echo $kill; ?>&token=<?php echo get_token(); ?>');
	}, <?php echo 1000 * $timeout; ?>);
</script>
<?php
		}
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
	return ($rand ^ $_SESSION["token"]) == $token && in_array($_SERVER["HTTP_SEC_FETCH_SITE"], ["", "same-origin"]);
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
