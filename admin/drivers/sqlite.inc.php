<?php

namespace AdminNeo;

use Exception;
use SQLite3;

Drivers::add("sqlite", "SQLite");

if (isset($_GET["sqlite"])) {
	define("AdminNeo\DRIVER", "sqlite");

	if (class_exists("SQLite3")) {
		define("AdminNeo\DRIVER_EXTENSION", "SQLite3");

		abstract class SqLiteConnectionBase extends Connection
		{
			/** @var SQLite3 */
			private $sqlite;

			public function open(string $server, string $username, string $password): bool
			{
				$this->sqlite = new SQLite3($server);

				$version = $this->sqlite->version();
				$this->server_info = $version["versionString"];

				return true;
			}

			public function query(string $query, bool $unbuffered = false)
			{
				$result = @$this->sqlite->query($query);
				$this->error = "";

				if (!$result) {
					$this->errno = $this->sqlite->lastErrorCode();
					$this->error = $this->sqlite->lastErrorMsg();

					return false;
				} elseif ($result->numColumns()) {
					return new Result($result);
				}

				$this->affected_rows = $this->sqlite->changes();

				return true;
			}

			public function quote(string $string): string
			{
				if (is_utf8($string)) {
					return "'" . $this->sqlite->escapeString($string) . "'";
				} else {
					$data = unpack('H*', $string);

					return "x'" . reset($data) . "'";
				}
			}
		}

		class Result {
			var $_result, $_offset = 0, $num_rows;

			function __construct($result) {
				$this->_result = $result;
			}

			function fetch_assoc() {
				return $this->_result->fetchArray(SQLITE3_ASSOC);
			}

			function fetch_row() {
				return $this->_result->fetchArray(SQLITE3_NUM);
			}

			function fetch_field() {
				$column = $this->_offset++;
				$type = $this->_result->columnType($column);
				return (object) [
					"name" => $this->_result->columnName($column),
					"type" => $type,
					"charsetnr" => ($type == SQLITE3_BLOB ? 63 : 0), // 63 - binary
				];
			}

			function __destruct() {
				return $this->_result->finalize();
			}
		}

	} elseif (extension_loaded("pdo_sqlite")) {
		define("AdminNeo\DRIVER_EXTENSION", "PDO_SQLite");

		abstract class SqLiteConnectionBase extends PdoConnection
		{
			public function open(string $server, string $username, string $password): bool
			{
				$this->dsn(DRIVER . ":$server", "", "");

				return true;
			}
		}
	}

	if (class_exists('AdminNeo\SqLiteConnectionBase')) {
		class SqLiteConnection extends SqLiteConnectionBase
		{
			protected function __construct()
			{
				parent::__construct();

				$this->open(":memory:", "", "");
			}

			public function open(string $server, string $username, string $password): bool
			{
				if (!parent::open($server, $username, $password)) {
					return false;
				}

				$this->query("PRAGMA foreign_keys = 1");
				$this->query("PRAGMA busy_timeout = 500");

				return true;
			}

			public function close(): void
			{
				$this->open(":memory:", "", "");
			}

			public function selectDatabase(string $name): bool
			{
				if (is_readable($name) && $this->query("ATTACH " . $this->quote(preg_match("~(^[/\\\\]|:)~", $name) ? $name : dirname($_SERVER["SCRIPT_FILENAME"]) . "/$name") . " AS a")) { // is_readable - SQLite 3
					return self::open($name, "", "");
				}

				return false;
			}
		}
	}



	class SqliteDriver extends Driver
	{
		protected function __construct(Connection $connection, $admin)
		{
			parent::__construct($connection, $admin);

			$this->types = [
				[
					"integer" => 0, "real" => 0, "numeric" => 0,
					"text" => 0, "blob" => 0,
				]
			];
		}

		public function getStructuredTypes(): array
		{
			return parent::getStructuredTypes()[0];
		}

		public function insertUpdate(string $table, array $records, array $primary)
		{
			$values = [];
			foreach ($records as $record) {
				$values[] = "(" . implode(", ", $record) . ")";
			}
			return queries("REPLACE INTO " . table($table) . " (" . implode(", ", array_keys(reset($records))) . ") VALUES\n" . implode(",\n", $values));
		}

		public function tableHelp(string $name, bool $isView = false): ?string
		{
			if ($name == "sqlite_sequence") {
				return "fileformat2.html#seqtab";
			}
			if ($name == "sqlite_master") {
				return "fileformat2.html#$name";
			}

			return null;
		}

		public function checkConstraints(string $table): array
		{
			preg_match_all('~ CHECK *(\( *(((?>[^()]*[^() ])|(?1))*) *\))~', $this->connection->getResult("SELECT sql FROM sqlite_master WHERE type = 'table' AND name = " . q($table)), $matches); //! could be inside a comment
			return array_combine($matches[2], $matches[2]);
		}

	}



	function create_driver(Connection $connection): Driver
	{
		return SqliteDriver::create($connection, Admin::get());
	}

	function idf_escape($idf) {
		return '"' . str_replace('"', '""', $idf) . '"';
	}

	function table($idf) {
		return idf_escape($idf);
	}

	/**
	 * @return Connection|string
	 */
	function connect(bool $primary = false)
	{
		$connection = $primary ? SqLiteConnection::create() : SqLiteConnection::createSecondary();

		$password = Admin::get()->getCredentials()[2];
		if ($password != "") {
			$result = Admin::get()->verifyDefaultPassword($password);
			if ($result !== true) {
				return $result;
			}
		}

		return $connection;
	}

	function get_databases() {
		return [];
	}

	function limit($query, $where, ?int $limit, $offset = 0, $separator = " ") {
		return " $query$where" . ($limit !== null ? $separator . "LIMIT $limit" . ($offset ? " OFFSET $offset" : "") : "");
	}

	function limit1($table, $query, $where, $separator = "\n") {
		return (preg_match('~^INTO~', $query) || Connection::get()->getResult("SELECT sqlite_compileoption_used('ENABLE_UPDATE_DELETE_LIMIT')")
			? limit($query, $where, 1, 0, $separator)
			: " $query WHERE rowid = (SELECT rowid FROM " . table($table) . $where . $separator . "LIMIT 1)" //! use primary key in tables with WITHOUT rowid
		);
	}

	function db_collation($db, $collations) {
		return Connection::get()->getResult("PRAGMA encoding"); // there is no database list so $db == DB
	}

	function engines() {
		return [];
	}

	function logged_user() {
		return get_current_user(); // should return effective user
	}

	function tables_list() {
		return get_key_vals("SELECT name, type FROM sqlite_master WHERE type IN ('table', 'view') ORDER BY (name = 'sqlite_sequence'), name");
	}

	function count_tables($databases) {
		return [];
	}

	function table_status($name = "") {
		$return = [];
		foreach (get_rows("SELECT name AS Name, type AS Engine, 'rowid' AS Oid, '' AS Auto_increment FROM sqlite_master WHERE type IN ('table', 'view') " . ($name != "" ? "AND name = " . q($name) : "ORDER BY name")) as $row) {
			$row["Rows"] = Connection::get()->getResult("SELECT COUNT(*) FROM " . idf_escape($row["Name"]));
			$return[$row["Name"]] = $row;
		}
		foreach (get_rows("SELECT * FROM sqlite_sequence", null, "") as $row) {
			$return[$row["name"]]["Auto_increment"] = $row["seq"];
		}
		return ($name != "" ? $return[$name] : $return);
	}

	function is_view($table_status) {
		return $table_status["Engine"] == "view";
	}

	function fk_support($table_status) {
		return !Connection::get()->getResult("SELECT sqlite_compileoption_used('OMIT_FOREIGN_KEY')");
	}

	function fields($table) {
		$return = [];
		$primary = "";
		foreach (get_rows("PRAGMA table_info(" . table($table) . ")") as $row) {
			$name = $row["name"];
			$type = strtolower($row["type"]);
			$default = $row["dflt_value"];
			$return[$name] = [
				"field" => $name,
				"type" => (preg_match('~int~i', $type) ? "integer" : (preg_match('~char|clob|text~i', $type) ? "text" : (preg_match('~blob~i', $type) ? "blob" : (preg_match('~real|floa|doub~i', $type) ? "real" : "numeric")))),
				"full_type" => $type,
				"default" => (preg_match("~^'(.*)'$~", $default, $match) ? str_replace("''", "'", $match[1]) : ($default == "NULL" ? null : $default)),
				"null" => !$row["notnull"],
				"privileges" => ["select" => 1, "insert" => 1, "update" => 1, "where" => 1, "order" => 1],
				"primary" => $row["pk"],
			];
			if ($row["pk"]) {
				if ($primary != "") {
					$return[$primary]["auto_increment"] = false;
				} elseif (preg_match('~^integer$~i', $type)) {
					$return[$name]["auto_increment"] = true;
				}
				$primary = $name;
			}
		}
		$sql = Connection::get()->getResult("SELECT sql FROM sqlite_master WHERE type = 'table' AND name = " . q($table));
		preg_match_all('~(("[^"]*+")+|[a-z0-9_]+)\s+text\s+COLLATE\s+(\'[^\']+\'|\S+)~i', $sql, $matches, PREG_SET_ORDER);
		foreach ($matches as $match) {
			$name = str_replace('""', '"', preg_replace('~^"|"$~', '', $match[1]));
			if ($return[$name]) {
				$return[$name]["collation"] = trim($match[3], "'");
			}
		}
		return $return;
	}

	function indexes(string $table, ?Connection $connection = null): array
	{
		if (!is_object($connection)) {
			$connection = Connection::get();
		}
		$return = [];
		$sql = $connection->getResult("SELECT sql FROM sqlite_master WHERE type = 'table' AND name = " . q($table));
		if (preg_match('~\bPRIMARY\s+KEY\s*\((([^)"]+|"[^"]*"|`[^`]*`)++)~i', $sql, $match)) {
			$return[""] = ["type" => "PRIMARY", "columns" => [], "lengths" => [], "descs" => []];
			preg_match_all('~((("[^"]*+")+|(?:`[^`]*+`)+)|(\S+))(\s+(ASC|DESC))?(,\s*|$)~i', $match[1], $matches, PREG_SET_ORDER);
			foreach ($matches as $match) {
				$return[""]["columns"][] = idf_unescape($match[2]) . $match[4];
				$return[""]["descs"][] = (preg_match('~DESC~i', $match[5]) ? '1' : null);
			}
		}
		if (!$return) {
			foreach (fields($table) as $name => $field) {
				if ($field["primary"]) {
					$return[""] = ["type" => "PRIMARY", "columns" => [$name], "lengths" => [], "descs" => [null]];
				}
			}
		}
		$sqls = get_key_vals("SELECT name, sql FROM sqlite_master WHERE type = 'index' AND tbl_name = " . q($table), $connection);
		foreach (get_rows("PRAGMA index_list(" . table($table) . ")", $connection) as $row) {
			$name = $row["name"];
			$index = ["type" => ($row["unique"] ? "UNIQUE" : "INDEX")];
			$index["lengths"] = [];
			$index["descs"] = [];
			foreach (get_rows("PRAGMA index_info(" . idf_escape($name) . ")", $connection) as $row1) {
				$index["columns"][] = $row1["name"];
				$index["descs"][] = null;
			}
			if (preg_match('~^CREATE( UNIQUE)? INDEX ' . preg_quote(idf_escape($name) . ' ON ' . idf_escape($table), '~') . ' \((.*)\)$~i', $sqls[$name], $regs)) {
				preg_match_all('/("[^"]*+")+( DESC)?/', $regs[2], $matches);
				foreach ($matches[2] as $key => $val) {
					if ($val) {
						$index["descs"][$key] = '1';
					}
				}
			}
			if (!$return[""] || $index["type"] != "UNIQUE" || $index["columns"] != $return[""]["columns"] || $index["descs"] != $return[""]["descs"] || !preg_match("~^sqlite_~", $name)) {
				$return[$name] = $index;
			}
		}
		return $return;
	}

	function foreign_keys($table) {
		$return = [];
		foreach (get_rows("PRAGMA foreign_key_list(" . table($table) . ")") as $row) {
			$foreign_key = &$return[$row["id"]];
			if (!$foreign_key) {
				$foreign_key = $row;
			}
			$foreign_key["source"][] = $row["from"];
			$foreign_key["target"][] = $row["to"];
		}
		return $return;
	}

	function view($name) {
		return ["select" => preg_replace('~^(?:[^`"[]+|`[^`]*`|"[^"]*")* AS\s+~iU', '', Connection::get()->getResult("SELECT sql FROM sqlite_master WHERE type = 'view' AND name = " . q($name)))]; //! identifiers may be inside []
	}

	function collations() {
		return (isset($_GET["create"]) ? get_vals("PRAGMA collation_list", 1) : []);
	}

	function information_schema($db) {
		return false;
	}

	function error() {
		return h(Connection::get()->getError());
	}

	function check_sqlite_name($name) {
		// avoid creating PHP files on unsecured servers
		$extensions = "db|sdb|sqlite";
		if (!preg_match("~^[^\\0]*\\.($extensions)\$~", $name)) {
			Connection::get()->setError(lang('Please use one of the extensions %s.', str_replace("|", ", ", $extensions)));
			return false;
		}
		return true;
	}

	function create_database($db, $collation) {
		if (file_exists($db)) {
			Connection::get()->setError(lang('File exists.'));
			return false;
		}
		if (!check_sqlite_name($db)) {
			return false;
		}
		try {
			$link = SqLiteConnection::createSecondary();
			$link->open($db, "", "");
		} catch (Exception $ex) {
			Connection::get()->setError($ex->getMessage());
			return false;
		}
		$link->query('PRAGMA encoding = "UTF-8"');
		$link->query('CREATE TABLE adminneo (i)'); // otherwise creates empty file
		$link->query('DROP TABLE adminneo');
		return true;
	}

	function drop_databases($databases) {
		Connection::get()->close(); // to unlock file, doesn't work in PDO on Windows
		foreach ($databases as $db) {
			if (!@unlink($db)) {
				Connection::get()->setError(lang('File exists.'));
				return false;
			}
		}
		return true;
	}

	function rename_database($name, $collation) {
		if (!check_sqlite_name($name)) {
			return false;
		}
		Connection::get()->close();
		Connection::get()->setError(lang('File exists.'));
		return @rename(DB, $name);
	}

	function auto_increment() {
		return " PRIMARY KEY AUTOINCREMENT";
	}

	function alter_table($table, $name, $fields, $foreign, $comment, $engine, $collation, $auto_increment, $partitioning) {
		$use_all_fields = ($table == "" || $foreign);
		foreach ($fields as $field) {
			if ($field[0] != "" || !$field[1] || $field[2]) {
				$use_all_fields = true;
				break;
			}
		}

		$alter_fields = [];
		$originals = [];

		foreach ($fields as $field) {
			if (!$field[1]) continue;

			if ($field[0] != "") {
				$originals[$field[0]] = $field[1][0];
			}

			$alter_fields[] = ($use_all_fields ? $field[1] : "ADD " . implode($field[1]));
		}

		if (!$use_all_fields) {
			foreach ($alter_fields as $val) {
				if (!queries("ALTER TABLE " . table($table) . " $val")) {
					return false;
				}
			}

			if ($table != $name && !queries("ALTER TABLE " . table($table) . " RENAME TO " . table($name))) {
				return false;
			}
		} elseif (!recreate_table($table, $name, $alter_fields, $originals, $foreign, $auto_increment)) {
			return false;
		}

		if ($auto_increment) {
			queries("BEGIN");
			queries("UPDATE sqlite_sequence SET seq = $auto_increment WHERE name = " . q($name)); // ignores error

			if (!Connection::get()->getAffectedRows()) {
				queries("INSERT INTO sqlite_sequence (name, seq) VALUES (" . q($name) . ", $auto_increment)");
			}

			queries("COMMIT");
		}

		return true;
	}

	/** Recreate table
	* @param string original name
	* @param string new name
	* @param array [process_field()], empty to preserve
	* @param array [$original => idf_escape($new_column)], empty to preserve
	* @param string [format_foreign_key()], empty to preserve
	* @param int set auto_increment to this value, 0 to preserve
	* @param array [[$type, $name, $columns]], empty to preserve
	* @param string CHECK constraint to drop
	* @param string CHECK constraint to add
	* @return bool
	*/
	function recreate_table($table, $name, $fields, $originals, $foreign, $auto_increment = 0, $indexes = [], $drop_check = "", $add_check = "") {
		if ($table != "") {
			if (!$fields) {
				foreach (fields($table) as $key => $field) {
					if ($indexes) {
						$field["auto_increment"] = 0;
					}

					$fields[] = process_field($field, $field);
					$originals[$key] = idf_escape($key);
				}
			}

			$primary_key = false;
			foreach ($fields as $field) {
				if ($field[6]) {
					$primary_key = true;
				}
			}

			$drop_indexes = [];
			foreach ($indexes as $key => $val) {
				if ($val[2] == "DROP") {
					$drop_indexes[$val[1]] = true;
					unset($indexes[$key]);
				}
			}

			foreach (indexes($table) as $key_name => $index) {
				$columns = [];
				foreach ($index["columns"] as $key => $column) {
					if (!isset($originals[$column])) {
						continue 2;
					}
					$columns[] = $originals[$column] . ($index["descs"][$key] ? " DESC" : "");
				}

				if (!$drop_indexes[$key_name]) {
					if ($index["type"] != "PRIMARY" || !$primary_key) {
						// Remove sqlite_ prefix from internal index created by UNIQUE column constraint.
						// This will transform column constrain to basic index.
						$key_name = preg_replace('~^sqlite_~', "", $key_name);

						$indexes[] = [$index["type"], $key_name, $columns];
					}
				}
			}

			foreach ($indexes as $key => $val) {
				if ($val[0] == "PRIMARY") {
					unset($indexes[$key]);
					$foreign[] = "  PRIMARY KEY (" . implode(", ", $val[2]) . ")";
				}
			}

			foreach (foreign_keys($table) as $key_name => $foreign_key) {
				foreach ($foreign_key["source"] as $key => $column) {
					if (!$originals[$column]) {
						continue 2;
					}
					$foreign_key["source"][$key] = idf_unescape($originals[$column]);
				}

				if (!isset($foreign[" $key_name"])) {
					$foreign[] = " " . format_foreign_key($foreign_key);
				}
			}

			queries("BEGIN");
		}

		foreach ($fields as $key => $field) {
			$fields[$key] = "  " . implode($field);
		}

		$fields = array_merge($fields, array_filter($foreign));
		foreach (Driver::get()->checkConstraints($table) as $check) {
			if ($check != $drop_check) {
				$fields[] = "  CHECK ($check)";
			}
		}
		if ($add_check) {
			$fields[] = "  CHECK ($add_check)";
		}
		$temp_name = ($table == $name ? "adminneo_$name" : $name);
		if (!queries("CREATE TABLE " . table($temp_name) . " (\n" . implode(",\n", $fields) . "\n)")) {
			// implicit ROLLBACK to not overwrite $connection->error
			return false;
		}

		if ($table != "") {
			if ($originals && !queries("INSERT INTO " . table($temp_name) . " (" . implode(", ", $originals) . ") SELECT " . implode(", ", array_map('AdminNeo\idf_escape', array_keys($originals))) . " FROM " . table($table))) {
				return false;
			}

			$triggers = [];
			foreach (triggers($table) as $trigger_name => $timing_event) {
				$trigger = trigger($trigger_name);
				$triggers[] = "CREATE TRIGGER " . idf_escape($trigger_name) . " " . implode(" ", $timing_event) . " ON " . table($name) . "\n$trigger[Statement]";
			}

			$auto_increment = $auto_increment ? 0 : Connection::get()->getResult("SELECT seq FROM sqlite_sequence WHERE name = " . q($table)); // if $auto_increment is set then it will be updated later
			if (!queries("DROP TABLE " . table($table)) // drop before creating indexes and triggers to allow using old names
				|| ($table == $name && !queries("ALTER TABLE " . table($temp_name) . " RENAME TO " . table($name)))
				|| !alter_indexes($name, $indexes)
			) {
				return false;
			}

			if ($auto_increment) {
				queries("UPDATE sqlite_sequence SET seq = $auto_increment WHERE name = " . q($name)); // ignores error
			}

			foreach ($triggers as $trigger) {
				if (!queries($trigger)) {
					return false;
				}
			}

			queries("COMMIT");
		}

		return true;
	}

	function index_sql($table, $type, $name, $columns) {
		return "CREATE $type " . ($type != "INDEX" ? "INDEX " : "")
			. idf_escape($name != "" ? $name : uniqid($table . "_"))
			. " ON " . table($table)
			. " $columns"
		;
	}

	function alter_indexes($table, $alter) {
		foreach ($alter as $index) {
			if ($index[0] == "PRIMARY" || (preg_match('~^sqlite_~', $index[1]))) {
				return recreate_table($table, $table, [], [], [], 0, $alter);
			}
		}

		foreach (array_reverse($alter) as $val) {
			if (!queries($val[2] == "DROP"
				? "DROP INDEX " . idf_escape($val[1])
				: index_sql($table, $val[0], $val[1], "(" . implode(", ", $val[2]) . ")")
			)) {
				return false;
			}
		}

		return true;
	}

	function truncate_tables($tables) {
		return apply_queries("DELETE FROM", $tables);
	}

	function drop_views($views) {
		return apply_queries("DROP VIEW", $views);
	}

	function drop_tables($tables) {
		return apply_queries("DROP TABLE", $tables);
	}

	function move_tables($tables, $views, $target) {
		return false;
	}

	function trigger($name) {
		if ($name == "") {
			return ["Statement" => "BEGIN\n\t;\nEND"];
		}
		$idf = '(?:[^`"\s]+|`[^`]*`|"[^"]*")+';
		$trigger_options = trigger_options();
		preg_match(
			"~^CREATE\\s+TRIGGER\\s*$idf\\s*(" . implode("|", $trigger_options["Timing"]) . ")\\s+([a-z]+)(?:\\s+OF\\s+($idf))?\\s+ON\\s*$idf\\s*(?:FOR\\s+EACH\\s+ROW\\s)?(.*)~is",
			Connection::get()->getResult("SELECT sql FROM sqlite_master WHERE type = 'trigger' AND name = " . q($name)),
			$match
		);
		$of = $match[3];
		return [
			"Timing" => strtoupper($match[1]),
			"Event" => strtoupper($match[2]) . ($of ? " OF" : ""),
			"Of" => idf_unescape($of),
			"Trigger" => $name,
			"Statement" => $match[4],
		];
	}

	function triggers($table) {
		$return = [];
		$trigger_options = trigger_options();
		foreach (get_rows("SELECT * FROM sqlite_master WHERE type = 'trigger' AND tbl_name = " . q($table)) as $row) {
			preg_match('~^CREATE\s+TRIGGER\s*(?:[^`"\s]+|`[^`]*`|"[^"]*")+\s*(' . implode("|", $trigger_options["Timing"]) . ')\s*(.*?)\s+ON\b~i', $row["sql"], $match);
			$return[$row["name"]] = [$match[1], $match[2]];
		}
		return $return;
	}

	function trigger_options() {
		return [
			"Timing" => ["BEFORE", "AFTER", "INSTEAD OF"],
			"Event" => ["INSERT", "UPDATE", "UPDATE OF", "DELETE"],
			"Type" => ["FOR EACH ROW"],
		];
	}

	function begin() {
		return queries("BEGIN");
	}

	function last_id() {
		return Connection::get()->getResult("SELECT LAST_INSERT_ROWID()");
	}

	function explain(Connection $connection, string $query)
	{
		return $connection->query("EXPLAIN QUERY PLAN $query");
	}

	function found_rows($table_status, $where) {
	}

	function types() {
		return [];
	}

	function create_sql($table, $auto_increment, $style) {
		$return = Connection::get()->getResult("SELECT sql FROM sqlite_master WHERE type IN ('table', 'view') AND name = " . q($table));
		foreach (indexes($table) as $name => $index) {
			// Skip primary key and internal indexes.
			if ($name == '' || strpos($name, "sqlite_") === 0) {
				continue;
			}

			$return .= ";\n\n" . index_sql($table, $index['type'], $name, "(" . implode(", ", array_map('AdminNeo\idf_escape', $index['columns'])) . ")");
		}

		return $return;
	}

	function truncate_sql($table) {
		return "DELETE FROM " . table($table);
	}

	function use_sql($database) {
	}

	function trigger_sql($table) {
		return implode(get_vals("SELECT sql || ';;\n' FROM sqlite_master WHERE type = 'trigger' AND tbl_name = " . q($table)));
	}

	function show_variables() {
		$return = [];
		foreach (get_rows("PRAGMA pragma_list") as $row) {
			$name = $row["name"];
			if ($name != "pragma_list" && $name != "compile_options") {
				foreach (get_rows("PRAGMA $name") as $row) {
					$return[$name] .= implode(", ", $row) . "\n";
				}
			}
		}
		return $return;
	}

	function show_status() {
		$return = [];
		foreach (get_vals("PRAGMA compile_options") as $option) {
			list($key, $val) = explode("=", $option, 2);
			$return[$key] = $val;
		}
		return $return;
	}

	function convert_field($field) {
	}

	function unconvert_field(array $field, $return) {
		return $return;
	}

	function support($feature) {
		return preg_match('~^(check|columns|database|drop_col|dump|indexes|descidx|move_col|sql|status|table|trigger|variables|view|view_trigger)$~', $feature);
	}

	function driver_config() {
		return [
			'possible_drivers' => [(isset($_GET["sqlite"]) ? "SQLite3" : "SQLite"), "PDO_SQLite"],
			'jush' => "sqlite",
			'unsigned' => [],
			'operators' => ["=", "<", ">", "<=", ">=", "!=", "LIKE", "LIKE %%", "IN", "IS NULL", "NOT LIKE", "NOT IN", "IS NOT NULL", "SQL"], // REGEXP can be user defined function
			'operator_like' => "LIKE %%",
			'functions' => ["hex", "length", "lower", "round", "unixepoch", "upper"],
			'grouping' => ["avg", "count", "count distinct", "group_concat", "max", "min", "sum"],
			'edit_functions' => [
				[
					// "text" => "date('now')/time('now')/datetime('now')",
				], [
					"integer|real|numeric" => "+/-",
					// "text" => "date/time/datetime",
					"text" => "||",
				]
			],
		];
	}
}
