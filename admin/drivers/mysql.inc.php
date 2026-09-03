<?php

namespace AdminNeo;

use mysqli;
use mysqli_result;
use PDO;
use stdClass;

Drivers::add("mysql", "MySQL", ["MySQLi", "PDO_MySQL"]);

if (isset($_GET["mysql"])) {
	define("AdminNeo\DRIVER", "mysql");
	define("AdminNeo\DIALECT", "sql");

	// MySQLi supports everything, PDO_MySQL doesn't support orgtable
	if (extension_loaded("mysqli") && $_GET["ext"] != "pdo") {
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

			public function getDefaultServerName(): string
			{
				return "localhost";
			}

			/** @see https://php.net/mysqli.construct */
			public function open(string $server, string $username, string $password): bool
			{
				mysqli_report(MYSQLI_REPORT_OFF);
				list($host, $port) = host_port($server);

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
					null,
					(is_numeric($port) ? (int)$port : ini_get("mysqli.default_port")),
					(!is_numeric($port) ? $port : null),
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

			public function getQueryInfo(): ?string
			{
				return $this->mysqli->info;
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
			public function getDefaultServerName(): string
			{
				return "localhost";
			}

			public function open(string $server, string $username, string $password): bool
			{
				list($host, $port) = host_port($server);
				$dsn = "mysql:charset=utf8" . ($host != "" ? ";host=$host" : "") . ($port ? (is_numeric($port) ? ";port=" : ";unix_socket=") . $port : "");

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

			$this->partitionBy = ["RANGE", "LIST", "HASH", "LINEAR HASH", "KEY", "LINEAR KEY"];

			$this->insertFunctions = [
				"char" => "md5/sha1/password/encrypt/uuid",
				"binary" => "md5/sha1",
				"date|time" => "now",
			];

			$this->editFunctions = [
				number_type() => "+/-",
				"date" => "+ interval/- interval",
				"time" => "addtime/subtime",
				"char|text" => "concat",
			];

			if ($connection->isMinVersion($maria ? "10.2" : "5.7.8")) {
				$this->types[lang('Strings')]["json"] = 4294967295;
			}

			// UUID data type for Mariadb >= 10.7
			if ($maria && $connection->isMinVersion("10.7")) {
				$this->types[lang('Strings')]["uuid"] = 128;
				$this->insertFunctions['uuid'] = 'uuid';
			}

			if ($maria && $connection->isMinVersion("10.5")) {
				$this->types[lang('Network')]["inet6"] = 39;
				if ($connection->isMinVersion("10.10")) {
					$this->types[lang('Network')]["inet4"] = 15;
				}
			}

			if ($connection->isMinVersion($maria ? "11.7" : "9")) {
				$this->types[lang('Numbers')]["vector"] = 16383;
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
				return doc_link(['sql' => 'bit-value-literals.html', 'mariadb' => "reference/sql-structure/sql-language-structure/binary-literals"], "<code>b''</code>");
			} elseif ($field["type"] == "vector") {
				return "<code class='jush-sql'>" . ($this->connection->isMariaDB() ? "VEC_FromText" : "STRING_TO_VECTOR") . "</code>";
			} elseif (preg_match("~geometry|point|linestring|polygon~", $field["type"])) {
				return "<code class='jush-sql'>GeomFromText</code>";
			} else {
				return "";
			}
		}

		public function getTypeName(stdClass $field): string
		{
			// https://dev.mysql.com/doc/dev/mysql-server/latest/field__types_8h.html
			$types = [
				"decimal", "tinyint", "smallint", "int", "float", "double", 7 => "timestamp",
				"bigint", "mediumint", "date", "time", "datetime", "year", 15 => "varchar", "bit",
				242 => "vector", 245 => "json", "decimal", "enum", "set",
				"tinytext", "mediumtext", "longtext", "text", "varchar", "char", "geometry",
			];

			$type = $types[$field->type] ?? "";

			return parent::getTypeName($field) ?: ($field->charsetnr == 63 // 63 - binary
				? str_replace(["text", "varchar", "char"], ["blob", "varbinary", "binary"], $type)
				: $type
			);
		}

		public function quoteBinary(string $string): string
		{
			return "X" . q(bin2hex($string));
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
				print_select_result($result); // print_select_result() usually needs to print a big table progressively
				return ob_get_clean();
			}

            return null;
		}

		public function tableHelp(string $name, bool $isView = false): ?string
        {
			$maria = $this->connection->isMariaDB();
			if (DB == "information_schema") {
				$name = strtolower($name);

				return $maria ?
					"reference/system-tables/information-schema/information-schema-tables/" . (str_starts_with($name, "innodb_") ? "information-schema-innodb-tables/" : "") . "information-schema-$name-table" :
					"information-schema-" . str_replace("_", "-", $name). "-table.html";
			}
	        if (DB == "performance_schema") {
		        return $maria ?
			        "reference/system-tables/performance-schema/performance-schema-tables/performance-schema-$name-table" :
			        "performance-schema-" . str_replace("_", "-", $name). "-table.html";
	        }
			if (DB == "sys") {
				//! MariaDB documents each view but the URL is not derivable.
				if ($maria) {
					return "reference/system-tables/sys-schema/";
				}

				// The x$ views are documented together with the views they are based on.
				return "sys-" . strtolower(str_replace("_", "-", preg_replace('~^x\$~', '', $name))) . ".html";
			}
			if (DB == "mysql") {
				return $maria ?
					"reference/system-tables/the-mysql-database-tables/mysql-$name" . str_starts_with($name, "innodb_") ? "" : "-table" :
					"system-schema.html"; //! more precise link
			}

            return null;
		}

		public function getPartitionsInfo(string $table): array
		{
			$from = "FROM information_schema.PARTITIONS WHERE TABLE_SCHEMA = " . q(DB) . " AND TABLE_NAME = " . q($table);

			$result = Connection::get()
				->query("SELECT PARTITION_METHOD, PARTITION_EXPRESSION, PARTITION_ORDINAL_POSITION $from ORDER BY PARTITION_ORDINAL_POSITION DESC LIMIT 1")
				->fetchRow();

			if (!$result) {
				return [];
			}

			$info = [
				"partition_by" => $result[0],
				"partition" => $result[1],
				"partitions" => $result[2],
			];

			$partitions = get_key_vals("SELECT PARTITION_NAME, PARTITION_DESCRIPTION $from AND PARTITION_NAME != '' ORDER BY PARTITION_ORDINAL_POSITION");
			$info["partition_names"] = array_keys($partitions);
			$info["partition_values"] = array_values($partitions);

			return $info;
		}

		public function getIndexAlgorithms(array $tableStatus): array
		{
			return preg_match('~^(MEMORY|NDB)$~', $tableStatus["Engine"]) ? ["BTREE", "HASH"] : ["BTREE"];
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

	/**
	 * Escapes database identifier.
	 */
	function idf_escape(string $idf): string
	{
		return "`" . str_replace("`", "``", $idf) . "`";
	}

	/**
	 * Returns escaped table name.
	 */
	function table(string $idf): string
	{
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
		[$server, $username, $password] = Admin::get()->getCredentials();

		if (!$connection->openPasswordless($server, $username, $password, false)) {
			$error = $connection->getError();

			if (function_exists('iconv') && !is_utf8($error) && strlen($s = iconv("windows-1252", "utf-8//IGNORE", $error)) > strlen($error)) { // windows-1252 - the same as MySQL latin1
				$error = $s;
			}

			return null;
		}

		$connection->setCharset(charset($connection));
		$connection->query("SET sql_quote_show_create = 1, autocommit = 1");

		if ($primary && $connection->isMariaDB()) {
			Drivers::setName(DRIVER, "MariaDB");
			save_driver_name(DRIVER, $server, "MariaDB");
		}

		return $connection;
	}

	/**
	 * Returns list of databases, cached if getting it is slow.
	 *
	 * @return list<string>
	 */
	function get_databases(bool $flush): array
	{
		$databases = get_session("dbs");

		if ($databases === null) {
			// SHOW DATABASES can be disabled by skip_show_database
			$query = "SELECT SCHEMA_NAME FROM information_schema.SCHEMATA ORDER BY SCHEMA_NAME";
			$start = microtime(true);
			$databases = ($flush ? slow_query($query) : get_vals($query));

			// Cache only a slow list, otherwise it would just get stale.
			if (microtime(true) - $start > 0.1) {
				restart_session();
				set_session("dbs", $databases);
				stop_session();
			}
		}

		return $databases;
	}

	/**
	 * Formulates SQL query with limit.
	 *
	 * @param string $query Everything after SELECT.
	 * @param string $where Including WHERE.
	 */
	function limit(string $query, string $where, int $limit, int $offset = 0, string $separator = " "): string
	{
		return " $query$where" . ($limit ? $separator . "LIMIT $limit" . ($offset ? " OFFSET $offset" : "") : "");
	}

	/**
	 * Formulates SQL modification query with limit 1.
	 *
	 * @param string $query Everything after UPDATE or DELETE.
	 */
	function limit1(string $table, string $query, string $where, string $separator = "\n"): string
	{
		return limit($query, $where, 1, 0, $separator);
	}

	/**
	 * Returns database collation.
	 *
	 * @param string[][] $collations Result of collations().
	 */
	function db_collation(string $db, array $collations): ?string
	{
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

	/**
	 * Returns logged user.
	 */
	function logged_user(): string
	{
		return Connection::get()->getValue("SELECT USER()");
	}

	/**
	 * Returns list of tables.
	 *
	 * @return string[] [$name => $type]
	 */
	function tables_list(): array
	{
		return get_key_vals("SELECT TABLE_NAME, TABLE_TYPE FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ORDER BY TABLE_NAME");
	}

	/**
	 * Counts tables in all databases.
	 *
	 * @param list<string> $databases
	 *
	 * @return int[] [$db => $tables]
	 */
	function count_tables(array $databases): array
	{
		$return = [];
		foreach ($databases as $db) {
			$return[$db] = count(get_vals("SHOW TABLES IN " . idf_escape($db)));
		}
		return $return;
	}

	/**
	 * Returns table status.
	 *
	 * @param bool $fast Return only "Name", "Engine" and "Comment" fields.
	 *
	 * @return array{Name:string, Engine?:?string, Comment?:string, Oid?:numeric-string, Rows?:numeric-string, Collation?:string, Auto_increment?:numeric-string, Data_length?:numeric-string, Index_length?:numeric-string, Data_free?:numeric-string, Create_options?:string, nspname?:string}[]
	 */
	function table_status(string $name = "", bool $fast = false): array
	{
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
			}

			$tables[$row["Name"]] = $row;
		}

		return $tables;
	}

	/**
	 * Finds out whether the identifier is a view.
	 *
	 * @param array $table_status Array returned by table_status().
	 */
	function is_view(array $table_status): bool
	{
		return $table_status["Engine"] === null;
	}

	/**
	 * Checks if table supports foreign keys.
	 *
	 * @param array $table_status Array returned by table_status().
	 */
	function fk_support(array $table_status): bool
	{
		return preg_match('~InnoDB|IBMDB2I' . (Connection::get()->isMinVersion("5.6") ? '|NDB' : '') . '~i', $table_status["Engine"]);
	}

	/**
	 * Returns information about fields.
	 *
	 * @return array{field:string, full_type:string, type:string, length:int, unsigned:string, default:string, null:bool, auto_increment:bool, on_update:string, collation:string, privileges:int[], comment:string, primary:bool, generated:string}[]
	 */
	function fields(string $table): array
	{
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
	 * @return array{type:string, columns:list<string>, lengths:list<int>, descs:list<?string>}[]
	 */
	function indexes(string $table, ?Connection $connection = null): array
	{
		$return = [];
		foreach (get_rows("SHOW INDEX FROM " . table($table), $connection) as $row) {
			$name = $row["Key_name"];
			$return[$name]["type"] = ($name == "PRIMARY" ? "PRIMARY" : ($row["Index_type"] == "FULLTEXT" ? "FULLTEXT" : ($row["Non_unique"] ? (preg_match('~^(SPATIAL|VECTOR)$~', $row["Index_type"]) ? $row["Index_type"] : "INDEX") : "UNIQUE")));
			$return[$name]["columns"][] = $row["Column_name"];
			$return[$name]["lengths"][] = ($row["Index_type"] == "SPATIAL" ? null : $row["Sub_part"]);
			$return[$name]["descs"][] = ($row["Collation"] == "D" ? '1' : null);
			$return[$name]["algorithm"] = $row["Index_type"];
		}
		return $return;
	}

	/**
	 * Returns foreign keys in table.
	 *
	 * @return array{db:string, ns:string, table:string, source:list<string>, target:list<string>, on_delete:string, on_update:string}[]
	 */
	function foreign_keys(string $table): array
	{
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

	function backward_keys(string $table): array
	{
		$query = "SELECT CONSTRAINT_NAME AS constraint_name, TABLE_SCHEMA AS table_schema, TABLE_NAME AS table_name,
COLUMN_NAME AS column_name, REFERENCED_COLUMN_NAME AS referenced_column_name
FROM information_schema.KEY_COLUMN_USAGE
WHERE TABLE_SCHEMA = " . q(Admin::get()->getDatabase()) . "
AND REFERENCED_TABLE_SCHEMA = " . q(Admin::get()->getDatabase()) . "
AND REFERENCED_TABLE_NAME = " . q($table) . "
ORDER BY ORDINAL_POSITION";

		return get_rows($query, null, "");
	}

	/**
	 * Returns view SELECT.
	 *
	 * @return array{select:string}
	 */
	function view(string $name): array
	{
		$select = Connection::get()->getValue("SHOW CREATE VIEW " . table($name), 1);

		// Extract definition query.
		$literals = '(?:[^`\']|`[^`]*`|\'[^\']*\')*';
		$select = preg_replace("~^$literals\\s+AS\\s+~isU", "", $select);

		// MySQL/MariaDB does not keep formatting, so we improve readability by adding new lines and indents.
		return ["select" => format_sql($select)];
	}

	/**
	 * Returns sorted grouped list of collations.
	 *
	 * @return string[][]
	 */
	function collations(): array
	{
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
			sort($return[$key]);
		}

		return $return;
	}

	/**
	 * Finds out if the database or schema is a read-only system catalog.
	 */
	function information_schema(?string $db, string $schema = ""): bool
	{
		return ($db == "information_schema")
			|| (Connection::get()->isMinVersion("5.5") && $db == "performance_schema");
	}

	/**
	 * Returns escaped error message.
	 */
	function error(): string
	{
		return h(preg_replace('~^You have an error.*syntax to use~U', "Syntax error", Connection::get()->getError()));
	}

	/**
	 * Creates database.
	 */
	function create_database(string $db, string $collation): bool
	{
		return (bool)queries("CREATE DATABASE " . idf_escape($db) . ($collation ? " COLLATE " . q($collation) : ""));
	}

	/**
	 * Drops databases.
	 *
	 * @param list<string> $databases
	 */
	function drop_databases(array $databases): bool
	{
		$return = apply_queries("DROP DATABASE", $databases, 'AdminNeo\idf_escape');
		restart_session();
		set_session("dbs", null);
		return $return;
	}

	/**
	 * Renames current database.
	 *
	 * @param string $name New name.
	 */
	function rename_database(string $name, string $collation): bool
	{
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

	/**
	 * Generates modifier for auto increment column.
	 */
	function auto_increment(): string
	{
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

	/**
	 * Runs commands to create or alter table.
	 *
	 * @param string $table "" to create.
	 * @param string $name New name.
	 * @param array $fields Array of [$orig, $process_field, $after].
	 * @param list<string> $foreign
	 * @param numeric-string|'' $auto_increment
	 * @param ?array $partitioning Null means remove partitioning.
	 */
	function alter_table(string $table, string $name, array $fields, array $foreign, ?string $comment, string $engine, string $collation, string $auto_increment, ?array $partitioning): bool
	{
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

		if ($partitioning) {
			$partitions = [];
			if ($partitioning["partition_by"] == 'RANGE' || $partitioning["partition_by"] == 'LIST') {
				foreach ($partitioning["partition_names"] as $key => $val) {
					$value = $partitioning["partition_values"][$key];
					$partitions[] = "\n  PARTITION " . idf_escape($val) . " VALUES " . ($partitioning["partition_by"] == 'RANGE' ? "LESS THAN" : "IN") . ($value != "" ? " ($value)" : " MAXVALUE"); //! SQL injection
				}
			}

			// $partitioning["partition"] can be expression, not only column
			$status .= "\nPARTITION BY {$partitioning["partition_by"]}({$partitioning["partition"]})";
			if ($partitions) {
				$status .= " (" . implode(",", $partitions) . "\n)";
			} elseif ($partitioning["partitions"]) {
				$status .= " PARTITIONS " . (int)$partitioning["partitions"];
			}
		} elseif ($partitioning === null) {
			$status .= "\nREMOVE PARTITIONING";
		}

		if ($table == "") {
			return (bool)queries("CREATE TABLE " . table($name) . " (\n" . implode(",\n", $alter) . "\n)$status");
		}
		if ($table != $name) {
			$alter[] = "RENAME TO " . table($name);
		}
		if ($status) {
			$alter[] = ltrim($status);
		}
		return !$alter || queries("ALTER TABLE " . table($table) . "\n" . implode(",\n", $alter));
	}

	/**
	 * Runs commands to alter indexes.
	 *
	 * @param string $table Escaped table name.
	 * @param list<array{string, string, 'DROP'|list<string>, 3?: string, 4?: string}> $alter Array of ["index type", "name", ["column definition", ...], "algorithm", "condition"] or ["index type", "name", "DROP"].
	 */
	function alter_indexes(string $table, array $alter): bool
	{
		$changes = [];
		foreach ($alter as $key => $val) {
			$changes[] = ($val[2] == "DROP"
				? "\nDROP INDEX " . idf_escape($val[1])
				: "\nADD $val[0] " . ($val[0] == "PRIMARY" ? "KEY " : "") . ($val[1] != "" ? idf_escape($val[1]) . " " : "") . "(" . implode(", ", $val[2]) . ")"
			);
		}
		return (bool)queries("ALTER TABLE " . table($table) . implode(",", $changes));
	}

	/**
	 * Runs commands to truncate tables.
	 *
	 * @param list<string> $tables
	 */
	function truncate_tables(array $tables, bool $cascade = false): bool
	{
		return apply_queries("TRUNCATE TABLE", $tables);
	}

	/**
	 * Drops views.
	 *
	 * @param list<string> $views
	 */
	function drop_views(array $views): bool
	{
		return (bool)queries("DROP VIEW " . implode(", ", array_map('AdminNeo\table', $views)));
	}

	/**
	 * Drops tables.
	 *
	 * @param list<string> $tables
	 */
	function drop_tables(array $tables): bool
	{
		return (bool)queries("DROP TABLE " . implode(", ", array_map('AdminNeo\table', $tables)));
	}

	/**
	 * Moves tables to other schema.
	 *
	 * @param list<string> $tables
	 * @param list<string> $views
	 */
	function move_tables(array $tables, array $views, string $target): bool
	{
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

	/**
	 * Copies tables to other schema.
	 *
	 * @param list<string> $tables
	 * @param list<string> $views
	 */
	function copy_tables(array $tables, array $views, string $target): bool
	{
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

	/**
	 * Returns information about a trigger.
	 *
	 * @return array{Trigger:string, Timing:string, Event:string, Of:string, Type:string, Statement:string}
	 */
	function trigger(string $name, string $table): array
	{
		if ($name == "") {
			return [];
		}

		$rows = get_rows("SHOW TRIGGERS WHERE `Trigger` = " . q($name));

		return reset($rows);
	}

	/**
	 * Returns defined triggers.
	 *
	 * @return array{string, string}[]
	 */
	function triggers(string $table): array
	{
		$return = [];
		foreach (get_rows("SHOW TRIGGERS LIKE " . q(addcslashes($table, "%_\\"))) as $row) {
			$return[$row["Trigger"]] = [$row["Timing"], $row["Event"]];
		}
		return $return;
	}

	/**
	 * Returns trigger options.
	 *
	 * @return array{Timing: list<string>, Event: list<string>, Type: list<string>}
	 */
	function trigger_options(): array
	{
		return [
			"Timing" => ["BEFORE", "AFTER"],
			"Event" => ["INSERT", "UPDATE", "DELETE"],
			"Type" => ["FOR EACH ROW"],
		];
	}

	/**
	 * Returns information about stored routine.
	 *
	 * @param 'FUNCTION'|'PROCEDURE' $type
	 *
	 * @return array{fields:list<array{field:string, type:string, length:string, unsigned:string, null:bool, full_type:string, inout:string, collation:string}>, comment:string, returns:array, definition:string, language:string}
	 */
	function routine(string $name, string $type): array
	{
		if ($name == "") {
			return [];
		}

		$fields = get_rows("SELECT
	PARAMETER_NAME field,
	DATA_TYPE type,
	REGEXP_REPLACE(DTD_IDENTIFIER, '^[^(]+\\\\(?|\\\\)$', '') length,
	REGEXP_REPLACE(DTD_IDENTIFIER, '^[^ ]+ ', '') `unsigned`,
	1 `null`,
	DTD_IDENTIFIER full_type,
	" . ($type == "FUNCTION" ? "''" : "PARAMETER_MODE") . " `inout`,
	CHARACTER_SET_NAME collation
FROM information_schema.PARAMETERS
WHERE SPECIFIC_SCHEMA = DATABASE() AND ROUTINE_TYPE = '$type' AND SPECIFIC_NAME = " . q($name) . "
ORDER BY ORDINAL_POSITION");

		$return = Connection::get()->query("SELECT
	ROUTINE_COMMENT comment,
	CONCAT(IF(IS_DETERMINISTIC = 'YES', 'DETERMINISTIC\\n', ''), IF(SQL_DATA_ACCESS != 'CONTAINS SQL', CONCAT(SQL_DATA_ACCESS, '\\n'), ''), ROUTINE_DEFINITION) definition,
	'SQL' language
FROM information_schema.ROUTINES
WHERE ROUTINE_SCHEMA = DATABASE() AND ROUTINE_TYPE = '$type' AND ROUTINE_NAME = " . q($name))->fetchAssoc();

		if ($fields && $fields[0]['field'] == '') {
			$return['returns'] = array_shift($fields);
		}
		$return['fields'] = $fields;

		return $return;
	}

	/**
	 * Returns list of routines.
	 *
	 * @return list<string[]> ["SPECIFIC_NAME" => , "ROUTINE_NAME" => , "ROUTINE_TYPE" => , "DTD_IDENTIFIER" => ]
	 */
	function routines(): array
	{
		return get_rows("SELECT SPECIFIC_NAME, ROUTINE_NAME, ROUTINE_TYPE, DTD_IDENTIFIER, ROUTINE_COMMENT FROM information_schema.ROUTINES WHERE ROUTINE_SCHEMA = DATABASE()");
	}

	/**
	 * Returns list of available routine languages.
	 *
	 * @return list<string>
	 */
	function routine_languages(): array
	{
		return []; // "SQL" not required
	}

	/**
	 * Returns routine signature.
	 *
	 * @param array $row Result of routine().
	 */
	function routine_id(string $name, array $row): string
	{
		return idf_escape($name);
	}

	/**
	 * Returns last auto-increment ID.
	 *
	 * @param Result|bool $result
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
		return $connection->query("EXPLAIN " . (Connection::get()->isMinVersion("5.7") ? "" : "PARTITIONS ") . $query);
	}

	/**
	 * Returns approximate number of rows.
	 *
	 * @param list<string> $where
	 *
	 * @return ?int null if approximate number can't be retrieved.
	 */
	function found_rows(array $table_status, array $where): ?int
	{
		return $table_status["Engine"] == "InnoDB" && !$where ? (int)$table_status["Rows"] : null;
	}

	function format_sql(string $query): string
	{
		$literals = '(?:[^`\']|`[^`]*`|\'[^\']*\')*';
		$keywords = 'FROM|WHERE|HAVING|GROUP\s+BY|ORDER\s+BY|(NATURAL\s+)?((LEFT|RIGHT)\s+)?((INNER|OUTER|CROSS)\s+)?JOIN';

		$query = preg_replace("~($literals)\\s+(AS\\s+SELECT)~isU", "$1 AS\nSELECT", $query);
		$query = preg_replace("~($literals)\\s+($keywords)~isU", "$1\n$2", $query);
		$query = preg_replace("~($literals),~isU", "$1,\n  ", $query);

		return $query;
	}

	/**
	 * Returns SQL command to create table.
	 */
	function create_sql(string $table, ?bool $auto_increment, string $style): string
	{
		$query = Connection::get()->getValue("SHOW CREATE TABLE " . table($table), 1);
		if (!$auto_increment) {
			$query = preg_replace('~ AUTO_INCREMENT=\d+~', '', $query); //! skip comments
		}

		return !str_contains($query, "\n") ? format_sql($query) : $query;
	}

	/**
	 * Returns SQL command to truncate table.
	 */
	function truncate_sql(string $table): string
	{
		return "TRUNCATE " . table($table);
	}

	/**
	 * Returns SQL command to create database.
	 */
	function create_database_sql(string $database, string $style = ""): string
	{
		$name = idf_escape($database);

		$command = "";
		if (str_contains($style, "CREATE") && ($create = Connection::get()->getValue("SHOW CREATE DATABASE $name", 1))) {
			set_utf8mb4($create);
			if ($style == "DROP+CREATE") {
				$command = "DROP DATABASE IF EXISTS $name;\n";
			}
			$command .= "$create;\n";
		}

		return $command;
	}

	/**
	 * Returns SQL command to change database.
	 */
	function use_sql(string $database, string $style = ""): string
	{
		return "USE " . idf_escape($database) . ";\n";
	}

	/**
	 * Returns SQL commands to create triggers.
	 */
	function trigger_sql(string $table): string
	{
		$sql = "";
		foreach (get_rows("SHOW TRIGGERS LIKE " . q(addcslashes($table, "%_\\")), null, "-- ") as $row) {
			$sql .= "\nCREATE TRIGGER " . idf_escape($row["Trigger"]) . " $row[Timing] $row[Event] ON " . table($row["Table"]) . " FOR EACH ROW\n$row[Statement];;\n";
		}

		return $sql;
	}

	/**
	 * Returns server variables.
	 *
	 * @return list<string[]> [[$name, $value]]
	 */
	function show_variables(): array
	{
		return get_rows("SHOW VARIABLES");
	}

	/**
	 * Returns status variables.
	 *
	 * @return list<string[]> [[$name, $value]]
	 */
	function show_status(): array
	{
		return get_rows("SHOW STATUS");
	}

	/**
	 * Returns process list.
	 *
	 * @return list<string[]> [$row]
	 */
	function process_list(): array
	{
		return get_rows("SHOW FULL PROCESSLIST");
	}

	/**
	 * Returns expression for field conversion in select and edit.
	 *
	 * @param array $field One element from fields().
	 *
	 * @return ?string Null if conversion is not necessary.
	 */
	function convert_field(array $field): ?string
	{
		if (preg_match("~binary~", $field["type"])) {
			return "HEX(" . idf_escape($field["field"]) . ")";
		}
		if ($field["type"] == "bit") {
			return "BIN(" . idf_escape($field["field"]) . " + 0)"; // + 0 is required outside MySQLnd
		}
		if ($field["type"] == "vector") {
			return (Connection::get()->isMariaDB() ? "VEC_ToText" : "VECTOR_TO_STRING") . "(" . idf_escape($field["field"]) . ")";
		}
		if (preg_match("~geometry|point|linestring|polygon~", $field["type"])) {
			return (Connection::get()->isMinVersion("8") ? "ST_" : "") . "AsWKT(" . idf_escape($field["field"]) . ")";
		}

		return null;
	}

	/**
	 * Converts value in edit after applying functions back.
	 *
	 * @param array $field One element from fields().
	 */
	function unconvert_field(array $field, string $return): string
	{
		if (preg_match("~binary~", $field["type"])) {
			$return = "UNHEX($return)";
		}
		if ($field["type"] == "bit") {
			$return = "CONVERT(b$return, UNSIGNED)";
		}
		if ($field["type"] == "vector") {
			$return = (Connection::get()->isMariaDB() ? "VEC_FromText" : "STRING_TO_VECTOR") . "($return)";
		}
		if (preg_match("~geometry|point|linestring|polygon~", $field["type"])) {
			$prefix = (Connection::get()->isMinVersion("8") ? "ST_" : "");
			$return = $prefix . "GeomFromText($return, $prefix" . "SRID($field[field]))";
		}

		return $return;
	}

	/**
	 * Checks whether a feature is supported.
	 *
	 * @param literal-string $feature check|comment|copy|database|descidx|drop_col|dump|event|fast_status|indexes|kill|materializedview|
	 * privileges|move_col|procedure|processlist|routine|scheme|sequence|status|table|trigger|type|variables|view|view_trigger
	 */
	function support(string $feature): bool
	{
		return preg_match(
			'~^(comment|columns|copy|database|drop_col|dump|event|indexes|kill|privileges|move_col|procedure|processlist|routine|sql|status|table|trigger|variables|view'
			. (Connection::get()->isMinVersion(Connection::get()->isMariaDB() ? "10.8.1" : "8") ? '|descidx' : '')
			. (Connection::get()->isMinVersion(Connection::get()->isMariaDB() ? "10.2.1" : "8.0.16") ? '|check' : '')
			// MySQL 8 reads table stats from the data dictionary; MariaDB still opens all tables.
			. (!Connection::get()->isMariaDB() && Connection::get()->isMinVersion("8") ? '|fast_status' : '')
			. ')$~',
			$feature
		);
	}

	/**
	 * Kills a process.
	 *
	 * @param numeric-string $val
	 *
	 * @return Result|bool
	 */
	function kill_process(string $val)
	{
		return queries("KILL " . number($val));
	}

	/**
	 * Returns query to get connection ID.
	 */
	function connection_id(): string
	{
		return "SELECT CONNECTION_ID()";
	}

	/**
	 * Returns maximum number of connections.
	 */
	function max_connections(): int
	{
		return (int)Connection::get()->getValue("SELECT @@max_connections");
	}
}
