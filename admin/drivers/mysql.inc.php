<?php

namespace AdminNeo;

use mysqli;
use mysqli_result;
use PDO;

Drivers::add("mysql", "MySQL", ["MySQLi", "PDO_MySQL"]);

if (isset($_GET["mysql"])) {
	define("AdminNeo\DRIVER", "mysql");
	define("AdminNeo\DIALECT", "sql");

	// MySQLi supports everything, PDO_MySQL doesn't support orgtable
	if (extension_loaded("mysqli")) {
		define("AdminNeo\DRIVER_EXTENSION", "MySQLi");

		class MySqlConnection extends Connection
		{
			/** @var mysqli */
			private $mysqli;

			protected function __construct()
			{
				parent::__construct();

				$this->mysqli = new mysqli();
				$this->mysqli->init();
			}

			public function open(string $server, string $username, string $password, $database = null, $port = null, $socket = null): bool
			{
				mysqli_report(MYSQLI_REPORT_OFF);
				list($host, $port) = explode(":", $server, 2); // part after : is used for port or socket

				$key = Admin::get()->getConfig()->getSslKey();
				$certificate = Admin::get()->getConfig()->getSslCertificate();
				$ca_certificate = Admin::get()->getConfig()->getSslCaCertificate();
				$ssl_defined = $key || $certificate || $ca_certificate;

				if ($ssl_defined) {
					$this->mysqli->ssl_set($key, $certificate, $ca_certificate, null, null);
					$flags = Admin::get()->getConfig()->getSslTrustServerCertificate() ? MYSQLI_CLIENT_SSL_DONT_VERIFY_SERVER_CERT : MYSQLI_CLIENT_SSL;
				} else {
					$flags = 0;
				}

				$connected = @$this->mysqli->real_connect(
					($server != "" ? $host : ini_get("mysqli.default_host")),
					($server . $username != "" ? $username : ini_get("mysqli.default_user")),
					($server . $username . $password != "" ? $password : ini_get("mysqli.default_pw")),
					$database,
					(is_numeric($port) ? $port : ini_get("mysqli.default_port")),
					(!is_numeric($port) ? $port : $socket),
					$flags
				);

				$this->mysqli->options(MYSQLI_OPT_LOCAL_INFILE, false);

				if ($connected) {
					$info = $this->mysqli->get_server_info();

					$this->version = str_replace("-MariaDB", "", $info);
					$this->flavor = str_contains($info, "MariaDB") ? "mariadb" : null;
				}

				return $connected;
			}

			/**
			 * @return int
			 */
			public function getAffectedRows(): int
			{
				return $this->mysqli->affected_rows;
			}

			public function getErrno(): int
			{
				return $this->mysqli->errno;
			}

			public function getError(): string
			{
				return $this->mysqli->error;
			}

			public function selectDatabase(string $name): bool
			{
				return $this->mysqli->select_db($name);
			}

			public function setCharset(string $charset): bool
			{
				if ($this->mysqli->set_charset($charset)) {
					return true;
				}

				// The client library may not support utf8mb4.
				$this->mysqli->set_charset('utf8');

				return (bool)$this->query("SET NAMES $charset");
			}

			public function quote(string $string): string
			{
				return "'" . $this->mysqli->escape_string($string) . "'";
			}

			public function query(string $query, bool $unbuffered = false)
			{
				$result = $this->mysqli->query($query);

				return is_object($result) ? new MySqlResult($result) : $result;
			}

			public function multiQuery(string $query): bool
			{
				return $this->mysqli->multi_query($query);
			}

			public function storeResult($result = null)
			{
				$result = $this->mysqli->store_result();
				if (!$result) {
					return false;
				}

				return new MySqlResult($result);
			}

			public function nextResult(): bool
			{
				return $this->mysqli->more_results() && $this->mysqli->next_result();
			}
		}

		class MySqlResult extends Result
		{
			/** @var mysqli_result */
			private $resource;

			public function __construct(mysqli_result $resource)
			{
				parent::__construct($resource->num_rows);

				$this->resource = $resource;
			}

			public function fetchAssoc()
			{
				return $this->resource->fetch_assoc();
			}

			public function fetchRow()
			{
				return $this->resource->fetch_row();
			}

			public function fetchField()
			{
				return $this->resource->fetch_field();
			}

			public function seek(int $offset): bool
			{
				return $this->resource->data_seek($offset);
			}
		}

	} elseif (extension_loaded("pdo_mysql")) {
		define("AdminNeo\DRIVER_EXTENSION", "PDO_MySQL");

		class MySqlConnection extends PdoConnection
		{
			public function open(string $server, string $username, string $password): bool
			{
				$dsn = "mysql:charset=utf8;host=" . str_replace(":", ";unix_socket=", preg_replace('~:(\d)~', ';port=\1', $server));

				$options = [PDO::MYSQL_ATTR_LOCAL_INFILE => false];

				$key = Admin::get()->getConfig()->getSslKey();
				if ($key) {
					$options[PDO::MYSQL_ATTR_SSL_KEY] = $key;
				}

				$certificate = Admin::get()->getConfig()->getSslCertificate();
				if ($certificate) {
					$options[PDO::MYSQL_ATTR_SSL_CERT] = $certificate;
				}

				$ca_certificate = Admin::get()->getConfig()->getSslCaCertificate();
				if ($ca_certificate) {
					$options[PDO::MYSQL_ATTR_SSL_CA] = $ca_certificate;
				}

				// MYSQL_ATTR_SSL_VERIFY_SERVER_CERT is defined only with mysqlnd.
				$trustServerCertificate = Admin::get()->getConfig()->getSslTrustServerCertificate();
				if ($trustServerCertificate !== null && defined('\PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT')) {
					$options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = !$trustServerCertificate;
				}

				if (!$this->dsn($dsn, $username, $password, $options)) {
					return false;
				}

				$versionInfo = @$this->pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
				$this->flavor = str_contains($versionInfo, "MariaDB") ? "mariadb" : null;

				return true;
			}

			public function setCharset(string $charset): bool
			{
				return (bool)$this->query("SET NAMES $charset");
			}

			public function selectDatabase(string $name): bool
			{
				// database selection is separated from the connection so dbname in DSN can't be used
				return (bool)$this->query("USE " . idf_escape($name));
			}

			public function query(string $query, bool $unbuffered = false)
			{
				$this->pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, !$unbuffered);

				return parent::query($query, $unbuffered);
			}
		}
	}



	class MySqlDriver extends Driver
	{
		protected function __construct(Connection $connection, $admin)
		{
			parent::__construct($connection, $admin);

			$this->types = [
				lang('Numbers') => [
					"tinyint" => 3, "smallint" => 5, "mediumint" => 8, "int" => 10, "bigint" => 20,
					"decimal" => 66, "float" => 12, "double" => 21,
				],
				lang('Date and time') => [
					"date" => 10, "datetime" => 19, "timestamp" => 19, "time" => 10, "year" => 4,
				],
				lang('Strings') => [
					"char" => 255, "varchar" => 65535,
					"tinytext" => 255, "text" => 65535, "mediumtext" => 16777215, "longtext" => 4294967295,
				],
				lang('Lists') => [
					"enum" => 65535, "set" => 64,
				],
				lang('Binary') => [
					"bit" => 20, "binary" => 255, "varbinary" => 65535,
					"tinyblob" => 255, "blob" => 65535, "mediumblob" => 16777215, "longblob" => 4294967295,
				],
				lang('Geometry') => [
					"geometry" => 0, "point" => 0, "linestring" => 0, "polygon" => 0,
					"multipoint" => 0, "multilinestring" => 0, "multipolygon" => 0, "geometrycollection" => 0,
				],
			];

			$this->unsigned = ["unsigned", "zerofill", "unsigned zerofill"];

			$maria = $connection->isMariaDB();
			if ($connection->isMinVersion($maria ? "10.2" : "5.7")) {
				$this->generated = ["STORED", "VIRTUAL"];
			}

			$this->operators = [
				"=", "<", ">", "<=", ">=", "!=",
				"LIKE", "LIKE %%", "NOT LIKE",
				"IN", "NOT IN", "FIND_IN_SET",
				"IS NULL", "IS NOT NULL",
				"REGEXP", "NOT REGEXP",
				"SQL",
			];

			$this->likeOperator = "LIKE %%";
			$this->regexpOperator = "REGEXP";

			$this->functions = [
				"char_length", "lower", "upper",
				"round", "floor", "ceil",
				"date", "from_unixtime", "unix_timestamp",
				"sec_to_time", "time_to_sec",
			];

			$this->grouping = [
				"sum", "min", "max", "avg",
				"count", "count distinct",
				"group_concat",
			];

			$this->editFunctions = [
				[
					"char" => "md5/sha1/password/encrypt/uuid",
					"binary" => "md5/sha1",
					"date|time" => "now",
				], [
					number_type() => "+/-",
					"date" => "+ interval/- interval",
					"time" => "addtime/subtime",
					"char|text" => "concat",
				]
			];

			if ($connection->isMinVersion($maria ? "10.2" : "5.7.8")) {
				$this->types[lang('Strings')]["json"] = 4294967295;
			}

			// UUID data type for Mariadb >= 10.7
			if ($maria && $connection->isMinVersion("10.7")) {
				$this->types[lang('Strings')]["uuid"] = 128;
				$this->editFunctions[0]['uuid'] = 'uuid';
			}

			if ($connection->isMinVersion("9")) {
				$this->types[lang('Numbers')]["vector"] = 16383;
				$this->editFunctions[0]['vector'] = 'string_to_vector';
			}

			$this->systemDatabases = ["mysql", "information_schema", "performance_schema", "sys"];
		}

		public function insert(string $table, array $record)
        {
			return ($record ? parent::insert($table, $record) : queries("INSERT INTO " . table($table) . " ()\nVALUES ()"));
		}

		public function getUnconvertFunction(array $field): string
		{
			if (preg_match("~binary~", $field["type"])) {
				return "<code class='jush-sql'>UNHEX</code>";
			} elseif ($field["type"] == "bit") {
				return doc_link(array('sql' => 'bit-value-literals.html'), "<code>b''</code>");
			} elseif (preg_match("~geometry|point|linestring|polygon~", $field["type"])) {
				return "<code class='jush-sql'>GeomFromText</code>";
			} else {
				return "";
			}
		}

		public function insertUpdate(string $table, array $records, array $primary)
        {
			$columns = array_keys(reset($records));
			$prefix = "INSERT INTO " . table($table) . " (" . implode(", ", $columns) . ") VALUES\n";
			$values = [];
			foreach ($columns as $key) {
				$values[$key] = "$key = VALUES($key)";
			}
			$suffix = "\nON DUPLICATE KEY UPDATE " . implode(", ", $values);
			$values = [];
			$length = 0;
			foreach ($records as $record) {
				$value = "(" . implode(", ", $record) . ")";
				if ($values && (strlen($prefix) + $length + strlen($value) + strlen($suffix) > 1e6)) { // 1e6 - default max_allowed_packet
					if (!queries($prefix . implode(",\n", $values) . $suffix)) {
						return false;
					}
					$values = [];
					$length = 0;
				}
				$values[] = $value;
				$length += strlen($value) + 2; // 2 - strlen(",\n")
			}
			return queries($prefix . implode(",\n", $values) . $suffix);
		}

		public function slowQuery(string $query, int $timeout): ?string
        {
			$maria = $this->connection->isMariaDB();

			if (!$this->connection->isMinVersion($maria ? "10.1.2" : "5.7.8")) {
				return null;
			}

			if ($maria) {
				return "SET STATEMENT max_statement_time=$timeout FOR $query";
			} elseif (preg_match('~^(SELECT\b)(.+)~is', $query, $match)) {
				return "$match[1] /*+ MAX_EXECUTION_TIME(" . ($timeout * 1000) . ") */ $match[2]";
			} else {
				return null;
			}
		}

		public function convertSearch(string $idf, array $where, array $field): string
        {
			return (preg_match('~char|text|enum|set~', $field["type"]) && !preg_match("~^utf8~", $field["collation"]) && preg_match('~[\x80-\xFF]~', $where['val'])
				? "CONVERT($idf USING " . charset($this->connection) . ")"
				: $idf
			);
		}

		public function warnings(): ?string
        {
			$result = $this->connection->query("SHOW WARNINGS");
			if ($result && $result->getRowsCount()) {
				ob_start();
				select($result); // select() usually needs to print a big table progressively
				return ob_get_clean();
			}

            return null;
		}

		public function tableHelp(string $name, bool $isView = false): ?string
        {
			$maria = $this->connection->isMariaDB();
			if (information_schema(DB)) {
				return strtolower("information-schema-" . ($maria ? "$name-table/" : str_replace("_", "-", $name) . "-table.html"));
			}
			if (DB == "mysql") {
				return ($maria ? "mysql$name-table/" : "system-schema.html"); //! more precise link
			}

            return null;
		}

		public function hasCStyleEscapes(): bool
        {
			static $c_style;
			if ($c_style === null) {
				$sql_mode = $this->connection->getValue("SHOW VARIABLES LIKE 'sql_mode'", 1);
				$c_style = (strpos($sql_mode, 'NO_BACKSLASH_ESCAPES') === false);
			}
			return $c_style;
		}

		public function engines(): array
		{
			$engines = [];

			foreach (get_rows("SHOW ENGINES") as $row) {
				if (preg_match("~YES|DEFAULT~", $row["Support"])) {
					$engines[] = $row["Engine"];
				}
			}

			return $engines;
		}
	}



	function create_driver(Connection $connection): Driver
	{
		return MySqlDriver::create($connection, Admin::get());
	}

	/** Escape database identifier
	* @param string
	* @return string
	*/
	function idf_escape($idf) {
		return "`" . str_replace("`", "``", $idf) . "`";
	}

	/** Get escaped table name
	* @param string
	* @return string
	*/
	function table($idf) {
		return idf_escape($idf);
	}

	/**
	 * Connects to the database with given credentials.
	 *
	 * @param ?string $error Plain text error message.
	 */
	function connect(bool $primary = false, ?string &$error = null): ?Connection
	{
		$connection = $primary ? MySqlConnection::create() : MySqlConnection::createSecondary();
		$credentials = Admin::get()->getCredentials();

		if (!$connection->open($credentials[0], $credentials[1], $credentials[2])) {
			$error = $connection->getError();

			if (function_exists('iconv') && !is_utf8($error) && strlen($s = iconv("windows-1250", "utf-8", $error)) > strlen($error)) { // windows-1250 - most common Windows encoding
				$error = $s;
			}

			return null;
		}

		$connection->setCharset(charset($connection));
		$connection->query("SET sql_quote_show_create = 1, autocommit = 1");

		if ($primary && $connection->isMariaDB()) {
			Drivers::setName(DRIVER, "MariaDB");
			save_driver_name(DRIVER, $credentials[0], "MariaDB");
		}

		return $connection;
	}

	/** Get cached list of databases
	* @param bool
	* @return array
	*/
	function get_databases($flush) {
		// SHOW DATABASES can take a very long time so it is cached
		$return = get_session("dbs");
		if ($return === null) {
			$query = "SELECT SCHEMA_NAME FROM information_schema.SCHEMATA ORDER BY SCHEMA_NAME"; // SHOW DATABASES can be disabled by skip_show_database
			$return = ($flush ? slow_query($query) : get_vals($query));
			restart_session();
			set_session("dbs", $return);
			stop_session();
		}
		return $return;
	}

	/** Formulate SQL query with limit
	* @param string everything after SELECT
	* @param string including WHERE
	* @param ?int
	* @param int
	* @param string
	* @return string
	*/
	function limit($query, $where, ?int $limit, $offset = 0, $separator = " ") {
		return " $query$where" . ($limit !== null ? $separator . "LIMIT $limit" . ($offset ? " OFFSET $offset" : "") : "");
	}

	/** Formulate SQL modification query with limit 1
	* @param string
	* @param string everything after UPDATE or DELETE
	* @param string
	* @param string
	* @return string
	*/
	function limit1($table, $query, $where, $separator = "\n") {
		return limit($query, $where, 1, 0, $separator);
	}

	/** Get database collation
	* @param string
	* @param array result of collations()
	* @return string
	*/
	function db_collation($db, $collations) {
		$return = null;
		$create = Connection::get()->getValue("SHOW CREATE DATABASE " . idf_escape($db), 1);
		if (preg_match('~ COLLATE ([^ ]+)~', $create, $match)) {
			$return = $match[1];
		} elseif (preg_match('~ CHARACTER SET ([^ ]+)~', $create, $match)) {
			// default collation
			$return = $collations[$match[1]][-1];
		}
		return $return;
	}

	/** Get logged user
	* @return string
	*/
	function logged_user() {
		return Connection::get()->getValue("SELECT USER()");
	}

	/** Get tables list
	* @return array [$name => $type]
	*/
	function tables_list() {
		return get_key_vals("SELECT TABLE_NAME, TABLE_TYPE FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ORDER BY TABLE_NAME");
	}

	/** Count tables in all databases
	* @param array
	* @return array [$db => $tables]
	*/
	function count_tables($databases) {
		$return = [];
		foreach ($databases as $db) {
			$return[$db] = count(get_vals("SHOW TABLES IN " . idf_escape($db)));
		}
		return $return;
	}

	/** Get table status
	* @param string
	* @param bool return only "Name", "Engine" and "Comment" fields
	* @return array [$name => ["Name" => , "Engine" => , "Comment" => , "Oid" => , "Rows" => , "Collation" => , "Auto_increment" => , "Data_length" => , "Index_length" => , "Data_free" => ]] or only inner array with $name
	*/
	function table_status($name = "", $fast = false) {
		if ($fast) {
			$query = "SELECT TABLE_NAME AS Name, ENGINE AS Engine, CREATE_OPTIONS AS Create_options, TABLES.TABLE_COLLATION AS Collation, TABLE_COMMENT AS Comment FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() " . ($name != "" ? "AND TABLE_NAME = " . q($name) : "ORDER BY Name");
		} else {
			$query = "SHOW TABLE STATUS" . ($name != "" ? " LIKE " . q(addcslashes($name, "%_\\")) : "");
		}

		$tables = [];
		foreach (get_rows($query) as $row) {
			if ($row["Engine"] == "InnoDB") {
				// ignore internal comment, unnecessary since MySQL 5.1.21
				$row["Comment"] = preg_replace('~(?:(.+); )?InnoDB free: .*~', '\1', $row["Comment"]);
			}
			if (!isset($row["Engine"])) {
				$row["Comment"] = "";
			}
			if ($name != "") {
				// MariaDB: Table name is returned as lowercase on macOS, so we fix it here.
				$row["Name"] = $name;
				return $row;
			}

			$tables[$row["Name"]] = $row;
		}

		return $tables;
	}

	/** Find out whether the identifier is view
	* @param array
	* @return bool
	*/
	function is_view($table_status) {
		return $table_status["Engine"] === null;
	}

	/** Check if table supports foreign keys
	* @param array result of table_status
	* @return bool
	*/
	function fk_support($table_status) {
		return preg_match('~InnoDB|IBMDB2I~i', $table_status["Engine"])
			|| (preg_match('~NDB~i', $table_status["Engine"]) && Connection::get()->isMinVersion("5.6"));
	}

	/** Get information about fields
	* @param string
	* @return array [$name => ["field" => , "full_type" => , "type" => , "length" => , "unsigned" => , "default" => , "null" => , "auto_increment" => , "on_update" => , "collation" => , "privileges" => , "comment" => , "primary" => , "generated" => ]]
	*/
	function fields($table) {
		$maria = Connection::get()->isMariaDB();

		$return = [];
		foreach (get_rows("SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = " . q($table) . " ORDER BY ORDINAL_POSITION") as $row) {
			$field = $row["COLUMN_NAME"];

			// Type definition can contain a comment in MariaDB.
			// For example: timestamp /* mariadb-5.3 */
			// Produced by: CREATE VIEW test_view AS SELECT from_unixtime(min(`start`)) AS `start` FROM test GROUP BY col;
			$type = preg_replace('~\s?/\*.+\*/~U', "", $row["COLUMN_TYPE"]);

			$extra = $row["EXTRA"];

			// https://mariadb.com/kb/en/library/show-columns/, https://github.com/vrana/adminer/pull/359#pullrequestreview-276677186
			preg_match('~^(VIRTUAL|PERSISTENT|STORED)~', $extra, $generated);
			preg_match('~^([^( ]+)(?:\((.+)\))?( unsigned)?( zerofill)?$~', $type, $type_matches);

			$default = $maria && $row["COLUMN_DEFAULT"] == "NULL" ? null : $row["COLUMN_DEFAULT"];
			if ($default !== null) {
				$is_text = preg_match('~(text|json)~', $type_matches[1]);

				// MariaDB: texts are escaped with slashes, chars with double apostrophe.
				// MySQL: default value a'b of text column is stored as _utf8mb4\'a\\\'b\'.
				if (!$maria && $is_text) {
					$default = preg_replace("~^(_\w+)?('.*')$~", '\2', stripslashes($default));
				}
				if ($maria || $is_text) {
					$default = preg_replace_callback("~^'(.*)'$~", function ($matches) {
						return stripslashes(str_replace("''", "'", $matches[1]));
					}, $default);
				}

				// MySQL: Convert binary default value.
				if (!$maria && preg_match('~binary~', $type_matches[1]) && preg_match('~^0x(\w*)$~', $default, $matches)) {
					$default = pack("H*", $matches[1]);
				}
			}

			$generated_expression = $row["GENERATION_EXPRESSION"];
			// MySQL:
			//   - concat(`name`,' ',`surname`) is stored as concat(`name`,_utf8mb4\\\' \\\',`surname`)
			//   - length('test') is stored as length(_utf8mb4\'test\')
			if (!$maria) {
				$generated_expression = preg_replace("~(^|,|\()(_\w+)?('.*')($|,|\))~", '\1\3\4', stripslashes($generated_expression));
			}

			$return[$field] = [
				"field" => $field,
				"full_type" => $type,
				"type" => $type_matches[1],
				"length" => $type_matches[2],
				"unsigned" => ltrim($type_matches[3] . $type_matches[4]),
				"default" => ($generated ? $generated_expression : $default),
				"null" => ($row["IS_NULLABLE"] == "YES"),
				"auto_increment" => ($extra == "auto_increment"),
				"on_update" => (preg_match('~\bon update (\w+)~i', $extra, $type_matches) ? $type_matches[1] : ""), //! available since MySQL 5.1.23
				"collation" => $row["COLLATION_NAME"],
				"privileges" => array_flip(explode(",", $row["PRIVILEGES"])) + ["where" => 1, "order" => 1],
				"comment" => $row["COLUMN_COMMENT"],
				"primary" => ($row["COLUMN_KEY"] == "PRI"),
				"generated" => ($generated[1] == "PERSISTENT" ? "STORED" : $generated[1]),
			];
		}
		return $return;
	}

	/**
	 * Returns table indexes.
	 *
	 * @return array [$key_name => ["type" => , "columns" => [], "lengths" => [], "descs" => []]]
	 */
	function indexes(string $table, ?Connection $connection = null): array
	{
		$return = [];
		foreach (get_rows("SHOW INDEX FROM " . table($table), $connection) as $row) {
			$name = $row["Key_name"];
			$return[$name]["type"] = ($name == "PRIMARY" ? "PRIMARY" : ($row["Index_type"] == "FULLTEXT" ? "FULLTEXT" : ($row["Non_unique"] ? ($row["Index_type"] == "SPATIAL" ? "SPATIAL" : "INDEX") : "UNIQUE")));
			$return[$name]["columns"][] = $row["Column_name"];
			$return[$name]["lengths"][] = ($row["Index_type"] == "SPATIAL" ? null : $row["Sub_part"]);
			$return[$name]["descs"][] = null;
		}
		return $return;
	}

	/** Get foreign keys in table
	* @param string
	* @return array [$name => ["db" => , "ns" => , "table" => , "source" => [], "target" => [], "on_delete" => , "on_update" => ]]
	*/
	function foreign_keys($table) {
		static $pattern = '(?:`(?:[^`]|``)+`|"(?:[^"]|"")+")';
		$return = [];
		$create_table = Connection::get()->getValue("SHOW CREATE TABLE " . table($table), 1);
		if ($create_table) {
			$onActions = implode("|", Driver::get()->getOnActions());
			preg_match_all("~CONSTRAINT ($pattern) FOREIGN KEY ?\\(((?:$pattern,? ?)+)\\) REFERENCES ($pattern)(?:\\.($pattern))? \\(((?:$pattern,? ?)+)\\)(?: ON DELETE ($onActions))?(?: ON UPDATE ($onActions))?~", $create_table, $matches, PREG_SET_ORDER);
			foreach ($matches as $match) {
				preg_match_all("~$pattern~", $match[2], $source);
				preg_match_all("~$pattern~", $match[5], $target);
				$return[idf_unescape($match[1])] = [
					"db" => idf_unescape($match[4] != "" ? $match[3] : $match[4]),
					"table" => idf_unescape($match[4] != "" ? $match[4] : $match[3]),
					"source" => array_map('AdminNeo\idf_unescape', $source[0]),
					"target" => array_map('AdminNeo\idf_unescape', $target[0]),
					"on_delete" => ($match[6] ?: "RESTRICT"),
					"on_update" => ($match[7] ?: "RESTRICT"),
				];
			}
		}
		return $return;
	}

	/** Get view SELECT
	* @param string
	* @return array ["select" => ]
	*/
	function view($name) {
		return ["select" => preg_replace('~^(?:[^`]|`[^`]*`)*\s+AS\s+~isU', '', Connection::get()->getValue("SHOW CREATE VIEW " . table($name), 1))];
	}

	/** Get sorted grouped list of collations
	* @return array
	*/
	function collations() {
		$return = [];

		// Since MariaDB 10.10, one collation can be compatible with more character sets, so collations no longer have unique IDs.
		// All combinations can be selected from information_schema.COLLATION_CHARACTER_SET_APPLICABILITY table.
		$query = Connection::get()->isMariaDB() && Connection::get()->isMinVersion("10.10") ?
			"SELECT CHARACTER_SET_NAME AS Charset, FULL_COLLATION_NAME AS Collation, IS_DEFAULT AS `Default` FROM information_schema.COLLATION_CHARACTER_SET_APPLICABILITY" :
			"SHOW COLLATION";

		foreach (get_rows($query) as $row) {
			if ($row["Default"]) {
				$return[$row["Charset"]][-1] = $row["Collation"];
			} else {
				$return[$row["Charset"]][] = $row["Collation"];
			}
		}
		ksort($return);

		foreach ($return as $key => $val) {
			asort($return[$key]);
		}

		return $return;
	}

	/** Find out if database is information_schema
	* @param string
	* @return bool
	*/
	function information_schema($db) {
		return ($db == "information_schema")
			|| (Connection::get()->isMinVersion("5.5") && $db == "performance_schema");
	}

	/** Get escaped error message
	* @return string
	*/
	function error() {
		return h(preg_replace('~^You have an error.*syntax to use~U', "Syntax error", Connection::get()->getError()));
	}

	/** Create database
	* @param string
	* @param string
	* @return string
	*/
	function create_database($db, $collation) {
		return queries("CREATE DATABASE " . idf_escape($db) . ($collation ? " COLLATE " . q($collation) : ""));
	}

	/** Drop databases
	* @param array
	* @return bool
	*/
	function drop_databases($databases) {
		$return = apply_queries("DROP DATABASE", $databases, 'AdminNeo\idf_escape');
		restart_session();
		set_session("dbs", null);
		return $return;
	}

	/** Rename database from DB
	* @param string new name
	* @param string
	* @return bool
	*/
	function rename_database($name, $collation) {
		$return = false;
		if (create_database($name, $collation)) {
			$tables = [];
			$views = [];
			foreach (tables_list() as $table => $type) {
				if ($type == 'VIEW') {
					$views[] = $table;
				} else {
					$tables[] = $table;
				}
			}
			$return = (!$tables && !$views) || move_tables($tables, $views, $name);
			drop_databases($return ? [DB] : []);
		}
		return $return;
	}

	/** Generate modifier for auto increment column
	* @return string
	*/
	function auto_increment() {
		$auto_increment_index = " PRIMARY KEY";
		// don't overwrite primary key by auto_increment
		if ($_GET["create"] != "" && $_POST["auto_increment_col"]) {
			foreach (indexes($_GET["create"]) as $index) {
				if (in_array($_POST["fields"][$_POST["auto_increment_col"]]["orig"], $index["columns"], true)) {
					$auto_increment_index = "";
					break;
				}
				if ($index["type"] == "PRIMARY") {
					$auto_increment_index = " UNIQUE";
				}
			}
		}
		return " AUTO_INCREMENT$auto_increment_index";
	}

	/** Run commands to create or alter table
	* @param string "" to create
	* @param string new name
	* @param array of [$orig, $process_field, $after]
	* @param array of strings
	* @param string
	* @param string
	* @param string
	* @param string number
	* @param string
	* @return bool
	*/
	function alter_table($table, $name, $fields, $foreign, $comment, $engine, $collation, $auto_increment, $partitioning) {
		$alter = [];
		foreach ($fields as $field) {
			if ($field[1]) {
				$default = $field[1][3];
				if (str_contains($default, " GENERATED")) {
					// Swap DEFAULT and NULL. MariaDB doesn't support NULL on generated columns.
					$field[1][3] = Connection::get()->isMariaDB() ? "" : $field[1][2];
					$field[1][2] = $default;
				}
				$alter[] = ($table != "" ? ($field[0] != "" ? "CHANGE " . idf_escape($field[0]) : "ADD") : " ") . " " . implode($field[1]) . ($table != "" ? $field[2] : "");
			} else {
				$alter[] = "DROP " . idf_escape($field[0]);
			}
		}
		$alter = array_merge($alter, $foreign);
		$status = ($comment !== null ? " COMMENT=" . q($comment) : "")
			. ($engine ? " ENGINE=" . q($engine) : "")
			. ($collation ? " COLLATE " . q($collation) : "")
			. ($auto_increment != "" ? " AUTO_INCREMENT=$auto_increment" : "")
		;
		if ($table == "") {
			return queries("CREATE TABLE " . table($name) . " (\n" . implode(",\n", $alter) . "\n)$status$partitioning");
		}
		if ($table != $name) {
			$alter[] = "RENAME TO " . table($name);
		}
		if ($status) {
			$alter[] = ltrim($status);
		}
		return ($alter || $partitioning ? queries("ALTER TABLE " . table($table) . "\n" . implode(",\n", $alter) . $partitioning) : true);
	}

	/** Run commands to alter indexes
	* @param string escaped table name
	* @param array of ["index type", "name", ["column definition", ...]] or ["index type", "name", "DROP"]
	* @return bool
	*/
	function alter_indexes($table, $alter) {
		foreach ($alter as $key => $val) {
			$alter[$key] = ($val[2] == "DROP"
				? "\nDROP INDEX " . idf_escape($val[1])
				: "\nADD $val[0] " . ($val[0] == "PRIMARY" ? "KEY " : "") . ($val[1] != "" ? idf_escape($val[1]) . " " : "") . "(" . implode(", ", $val[2]) . ")"
			);
		}
		return queries("ALTER TABLE " . table($table) . implode(",", $alter));
	}

	/** Run commands to truncate tables
	* @param array
	* @return bool
	*/
	function truncate_tables($tables) {
		return apply_queries("TRUNCATE TABLE", $tables);
	}

	/** Drop views
	* @param array
	* @return bool
	*/
	function drop_views($views) {
		return queries("DROP VIEW " . implode(", ", array_map('AdminNeo\table', $views)));
	}

	/** Drop tables
	* @param array
	* @return bool
	*/
	function drop_tables($tables) {
		return queries("DROP TABLE " . implode(", ", array_map('AdminNeo\table', $tables)));
	}

	/** Move tables to other schema
	* @param array
	* @param array
	* @param string
	* @return bool
	*/
	function move_tables($tables, $views, $target) {
		$rename = [];
		foreach ($tables as $table) {
			$rename[] = table($table) . " TO " . idf_escape($target) . "." . table($table);
		}
		if (!$rename || queries("RENAME TABLE " . implode(", ", $rename))) {
			$definitions = [];
			foreach ($views as $table) {
				$definitions[table($table)] = view($table);
			}
			Connection::get()->selectDatabase($target);
			$db = idf_escape(DB);
			foreach ($definitions as $name => $view) {
				if (!queries("CREATE VIEW $name AS " . str_replace(" $db.", " ", $view["select"])) || !queries("DROP VIEW $db.$name")) {
					return false;
				}
			}
			return true;
		}
		//! move triggers
		return false;
	}

	/** Copy tables to other schema
	* @param array
	* @param array
	* @param string
	* @return bool
	*/
	function copy_tables($tables, $views, $target) {
		queries("SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO'");
		foreach ($tables as $table) {
			$name = ($target == DB ? table("copy_$table") : idf_escape($target) . "." . table($table));
			if (($_POST["overwrite"] && !queries("\nDROP TABLE IF EXISTS $name"))
				|| !queries("CREATE TABLE $name LIKE " . table($table))
				|| !queries("INSERT INTO $name SELECT * FROM " . table($table))
			) {
				return false;
			}
			foreach (get_rows("SHOW TRIGGERS LIKE " . q(addcslashes($table, "%_\\"))) as $row) {
				$trigger = $row["Trigger"];
				if (!queries("CREATE TRIGGER " . ($target == DB ? idf_escape("copy_$trigger") : idf_escape($target) . "." . idf_escape($trigger)) . " $row[Timing] $row[Event] ON $name FOR EACH ROW\n$row[Statement];")) {
					return false;
				}
			}
		}
		foreach ($views as $table) {
			$name = ($target == DB ? table("copy_$table") : idf_escape($target) . "." . table($table));
			$view = view($table);
			if (($_POST["overwrite"] && !queries("DROP VIEW IF EXISTS $name"))
				|| !queries("CREATE VIEW $name AS $view[select]")) { //! USE to avoid db.table
				return false;
			}
		}
		return true;
	}

	/** Get information about trigger
	* @param string trigger name
	* @return array ["Trigger" => , "Timing" => , "Event" => , "Of" => , "Type" => , "Statement" => ]
	*/
	function trigger($name) {
		if ($name == "") {
			return [];
		}
		$rows = get_rows("SHOW TRIGGERS WHERE `Trigger` = " . q($name));
		return reset($rows);
	}

	/** Get defined triggers
	* @param string
	* @return array [$name => [$timing, $event]]
	*/
	function triggers($table) {
		$return = [];
		foreach (get_rows("SHOW TRIGGERS LIKE " . q(addcslashes($table, "%_\\"))) as $row) {
			$return[$row["Trigger"]] = [$row["Timing"], $row["Event"]];
		}
		return $return;
	}

	/** Get trigger options
	* @return array ["Timing" => [], "Event" => [], "Type" => []]
	*/
	function trigger_options() {
		return [
			"Timing" => ["BEFORE", "AFTER"],
			"Event" => ["INSERT", "UPDATE", "DELETE"],
			"Type" => ["FOR EACH ROW"],
		];
	}

	/**
	 * Gets information about stored routine.
	 *
	 * @param string $name
	 * @param string $type "FUNCTION" or "PROCEDURE"
	 *
	 * @return array ["fields" => ["field" => , "type" => , "length" => , "unsigned" => , "inout" => , "collation" => ], "returns" => , "definition" => , "language" => ]
	 */
	function routine($name, $type) {
		$info = get_rows("SELECT ROUTINE_BODY, ROUTINE_COMMENT FROM information_schema.ROUTINES WHERE ROUTINE_SCHEMA = " . q(DB) . " AND ROUTINE_NAME = " . q($name))[0];

		$aliases = ["bool", "boolean", "integer", "double precision", "real", "dec", "numeric", "fixed", "national char", "national varchar"];
		$space = "(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";
		$enumLengthPattern = Driver::EnumLengthPattern;
		$type_pattern = "((" . implode("|", array_merge(array_keys(Driver::get()->getTypes()), $aliases)) . ")\\b(?:\\s*\\(((?:[^'\")]|$enumLengthPattern)++)\\))?\\s*(zerofill\\s*)?(unsigned(?:\\s+zerofill)?)?)(?:\\s*(?:CHARSET|CHARACTER\\s+SET)\\s*['\"]?([^'\"\\s,]+)['\"]?)?";
		$inOut = implode("|", Driver::get()->getInOut());
		$pattern = "$space*(" . ($type == "FUNCTION" ? "" : $inOut) . ")?\\s*(?:`((?:[^`]|``)*)`\\s*|\\b(\\S+)\\s+)$type_pattern";
		$create = Connection::get()->getValue("SHOW CREATE $type " . idf_escape($name), 2);
		preg_match("~\\(((?:$pattern\\s*,?)*)\\)\\s*" . ($type == "FUNCTION" ? "RETURNS\\s+$type_pattern\\s+" : "") . "(.*)~is", $create, $match);
		$fields = [];
		preg_match_all("~$pattern\\s*,?~is", $match[1], $matches, PREG_SET_ORDER);

		foreach ($matches as $param) {
			$fields[] = [
				"field" => str_replace("``", "`", $param[2]) . $param[3],
				"type" => strtolower($param[5]),
				"length" => preg_replace_callback("~$enumLengthPattern~s", 'AdminNeo\normalize_enum', $param[6]),
				"unsigned" => strtolower(preg_replace('~\s+~', ' ', trim("$param[8] $param[7]"))),
				"null" => 1,
				"full_type" => $param[4],
				"inout" => strtoupper($param[1]),
				"collation" => strtolower($param[9]),
			];
		}

		return $type == "FUNCTION" ? [
			"fields" => $fields,
			"returns" => ["type" => $match[12], "length" => $match[13], "unsigned" => $match[15], "collation" => $match[16]],
			"definition" => $match[17],
			"language" => $info["ROUTINE_BODY"],
			"comment" => $info["ROUTINE_COMMENT"],
		] : [
			"fields" => $fields,
			"returns" => null,
			"definition" => $match[11],
			"language" => $info["ROUTINE_BODY"],
			"comment" => $info["ROUTINE_COMMENT"],
		];
	}

	/** Get list of routines
	* @return array ["SPECIFIC_NAME" => , "ROUTINE_NAME" => , "ROUTINE_TYPE" => , "DTD_IDENTIFIER" => ]
	*/
	function routines() {
		return get_rows("SELECT ROUTINE_NAME AS SPECIFIC_NAME, ROUTINE_NAME, ROUTINE_TYPE, DTD_IDENTIFIER, ROUTINE_COMMENT FROM information_schema.ROUTINES WHERE ROUTINE_SCHEMA = " . q(DB));
	}

	/** Get list of available routine languages
	* @return array
	*/
	function routine_languages() {
		return []; // "SQL" not required
	}

	/** Get routine signature
	* @param string
	* @param array result of routine()
	* @return string
	*/
	function routine_id($name, $row) {
		return idf_escape($name);
	}

	/**
	 * Returns last auto-increment ID.
	 *
	 * @param $result Result|bool
	 *
	 * @return string|int|false
	 */
	function last_id($result)
	{
		return Connection::get()->getValue("SELECT LAST_INSERT_ID()"); // mysql_insert_id() truncates bigint
	}

	/**
	 * Explains select query.
	 *
	 * @return Result|bool
	 */
	function explain(Connection $connection, string $query)
	{
		return $connection->query("EXPLAIN " . (Connection::get()->isMinVersion("5.1") && !Connection::get()->isMinVersion("5.7") ? "PARTITIONS " : "") . $query);
	}

	/** Get approximate number of rows
	* @param array
	* @param array
	* @return int or null if approximate number can't be retrieved
	*/
	function found_rows($table_status, $where) {
		return ($where || $table_status["Engine"] != "InnoDB" ? null : $table_status["Rows"]);
	}

	/** Get SQL command to create table
	* @param string
	* @param bool
	* @param string
	* @return string
	*/
	function create_sql($table, $auto_increment, $style) {
		$return = Connection::get()->getValue("SHOW CREATE TABLE " . table($table), 1);
		if (!$auto_increment) {
			$return = preg_replace('~ AUTO_INCREMENT=\d+~', '', $return); //! skip comments
		}
		return $return;
	}

	/** Get SQL command to truncate table
	* @param string
	* @return string
	*/
	function truncate_sql($table) {
		return "TRUNCATE " . table($table);
	}

	/** Get SQL command to change database
	* @param string
	* @return string
	*/
	function use_sql($database) {
		return "USE " . idf_escape($database);
	}

	/** Get SQL commands to create triggers
	* @param string
	* @return string
	*/
	function trigger_sql($table) {
		$return = "";
		foreach (get_rows("SHOW TRIGGERS LIKE " . q(addcslashes($table, "%_\\")), null, "-- ") as $row) {
			$return .= "\nCREATE TRIGGER " . idf_escape($row["Trigger"]) . " $row[Timing] $row[Event] ON " . table($row["Table"]) . " FOR EACH ROW\n$row[Statement];;\n";
		}
		return $return;
	}

	/** Get server variables
	* @return array [[$name, $value]]
	*/
	function show_variables() {
		return get_rows("SHOW VARIABLES");
	}

	/** Get status variables
	* @return array [[$name, $value]]
	*/
	function show_status() {
		return get_rows("SHOW STATUS");
	}

	/** Get process list
	* @return array [$row]
	*/
	function process_list() {
		return get_rows("SHOW FULL PROCESSLIST");
	}

	/** Convert field in select and edit
	* @param array one element from fields()
	* @return string
	*/
	function convert_field($field) {
		if (preg_match("~binary~", $field["type"])) {
			return "HEX(" . idf_escape($field["field"]) . ")";
		}
		if ($field["type"] == "bit") {
			return "BIN(" . idf_escape($field["field"]) . " + 0)"; // + 0 is required outside MySQLnd
		}
		if (preg_match("~geometry|point|linestring|polygon~", $field["type"])) {
			return (Connection::get()->isMinVersion("8") ? "ST_" : "") . "AsWKT(" . idf_escape($field["field"]) . ")";
		}
	}

	/** Convert value in edit after applying functions back
	* @param array one element from fields()
	* @param string
	* @return string
	*/
	function unconvert_field(array $field, $return) {
		if (preg_match("~binary~", $field["type"])) {
			$return = "UNHEX($return)";
		}
		if ($field["type"] == "bit") {
			$return = "CONVERT(b$return, UNSIGNED)";
		}
		if (preg_match("~geometry|point|linestring|polygon~", $field["type"])) {
			$prefix = (Connection::get()->isMinVersion("8") ? "ST_" : "");
			$return = $prefix . "GeomFromText($return, $prefix" . "SRID($field[field]))";
		}

		return $return;
	}

	/** Check whether a feature is supported
	* @param string "check", "comment", "copy", "database", "descidx", "drop_col", "dump", "event", "indexes", "kill", "materializedview", "partitioning", "privileges", "procedure", "processlist", "routine", "scheme", "sequence", "status", "table", "trigger", "type", "variables", "view", "view_trigger"
	* @return bool
	*/
	function support($feature) {
		return !preg_match("~scheme|sequence|type|view_trigger|materializedview" . (Connection::get()->isMinVersion("8") ? "" : "|descidx" . (Connection::get()->isMinVersion("5.1") ? "" : "|event|partitioning")) . (Connection::get()->isMinVersion(Connection::get()->isMariaDB() ? "10.2.1" : "8.0.16") ? "" : "|check") . "~", $feature);
	}

	/** Kill a process
	* @param int
	* @return bool
	*/
	function kill_process($val) {
		return queries("KILL " . number($val));
	}

	/** Return query to get connection ID
	* @return string
	*/
	function connection_id(){
		return "SELECT CONNECTION_ID()";
	}

	/** Get maximum number of connections
	* @return int
	*/
	function max_connections() {
		return Connection::get()->getValue("SELECT @@max_connections");
	}
}
