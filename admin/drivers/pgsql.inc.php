<?php

namespace AdminNeo;

Drivers::add("pgsql", "PostgreSQL", ["PgSQL", "PDO_PgSQL"]);

if (isset($_GET["pgsql"])) {
	define("AdminNeo\DRIVER", "pgsql");
	define("AdminNeo\DIALECT", "pgsql");

	if (extension_loaded("pgsql")) {
		define("AdminNeo\DRIVER_EXTENSION", "PgSQL");

		class PgSqlConnection extends Connection
		{
			/** @var int */
			public $timeout = 0;

			/** @var resource|false */
			private $connection;

			/** @var string */
			private $connectionString;

			/** @var bool */
			private $hasDefaultDatabase = true;

			public function open(string $server, string $username, string $password): bool
			{
				$db = Admin::get()->getDatabase();
				set_error_handler(function($errno, $error) {
					if (ini_bool("html_errors")) {
						$error = html_entity_decode(strip_tags($error));
					}

					$error = preg_replace('~^[^:]*: ~', '', $error);
					$this->error = $error;
				});

				$this->connectionString = "host='" . str_replace(":", "' port='", addcslashes($server, "'\\")) . "' user='" . addcslashes($username, "'\\") . "' password='" . addcslashes($password, "'\\") . "'";

				$ssl_mode = Admin::get()->getConfig()->getSslMode();
				if ($ssl_mode) {
					$this->connectionString .= " sslmode='$ssl_mode'";
				}

				$this->connection = @pg_connect("$this->connectionString dbname='" . ($db != "" ? addcslashes($db, "'\\") : "postgres") . "'", PGSQL_CONNECT_FORCE_NEW);
				if (!$this->connection && $db != "") {
					// try to connect directly with database for performance
					$this->hasDefaultDatabase = false;
					$this->connection = @pg_connect("$this->connectionString dbname='postgres'", PGSQL_CONNECT_FORCE_NEW);
				}

				restore_error_handler();

				if ($this->connection) {
					$versionInfo = $this->getValue("SELECT version()");

					$this->flavor = str_contains($versionInfo, "CockroachDB") ? "cockroach" : null;
					$this->version = preg_replace('~^\D*([\d.]+).*~', "$1", $versionInfo);

					pg_set_client_encoding($this->connection, "UTF8");
				}

				return (bool) $this->connection;
			}

			public function quote(string $string): string
			{
				return (function_exists('pg_escape_literal')
					? pg_escape_literal($this->connection, $string) // available since PHP 5.4.4
					: "'" . pg_escape_string($this->connection, $string) . "'"
				);
			}

			public function formatValue(?string $value, array $field): ?string
			{
				if ($field["type"] == "bytea" && $value !== null) {
					return pg_unescape_bytea($value);
				}

				return parent::formatValue($value, $field);
			}

			public function selectDatabase(string $name): bool
			{
				if ($name == Admin::get()->getDatabase()) {
					return $this->hasDefaultDatabase;
				}

				$return = @pg_connect("$this->connectionString dbname='" . addcslashes($name, "'\\") . "'", PGSQL_CONNECT_FORCE_NEW);
				if ($return) {
					$this->connection = $return;
				}

				return $return;
			}

			public function close(): void
			{
				$this->connection = @pg_connect("$this->connectionString dbname='postgres'");
			}

			public function query(string $query, bool $unbuffered = false)
			{
				if (!$this->connection) {
					$this->error = "Invalid connection.";
					return false;
				}

				$result = @pg_query($this->connection, $query);
				$this->error = "";

				if (!$result) {
					$this->error = pg_last_error($this->connection);
					$return = false;
				} elseif (!pg_num_fields($result)) {
					$this->affectedRows = pg_affected_rows($result);
					$return = true;
				} else {
					$return = new PgSqlResult($result);
				}

				if ($this->timeout) {
					$this->timeout = 0;
					$this->query("RESET statement_timeout");
				}

				return $return;
			}

			public function getValue(string $query, int $fieldIndex = 0)
			{
				$result = $this->query($query);

				return is_object($result) ? $result->fetchValue($fieldIndex) : false;
			}

			public function warnings(): ?string
			{
				$result = pg_last_notice($this->connection);

				return $result ? h($result) : null;
			}
		}

		class PgSqlResult extends Result
		{
			/** @var resource */
			private $resource;

			/** @var int */
			private $offset = 0;

			/**
			 * @param resource $resource
			 */
			public function __construct($resource)
			{
				parent::__construct(pg_num_rows($resource));

				$this->resource = $resource;
			}

			public function __destruct()
			{
				pg_free_result($this->resource);
			}

			public function fetchAssoc()
			{
				return pg_fetch_assoc($this->resource);
			}

			public function fetchRow()
			{
				return pg_fetch_row($this->resource);
			}

			/**
			 * @return ?string|false
			 */
			public function fetchValue(int $fieldIndex)
			{
				return $this->getRowsCount() ? pg_fetch_result($this->resource, 0, $fieldIndex) : false;
			}

			public function fetchField()
			{
				$column = $this->offset++;

				$orgtable = pg_field_table($this->resource, $column);
				if ($orgtable === false) {
					return false;
				}

				$name = pg_field_name($this->resource, $column);
				if ($name === false) {
					return false;
				}

				$type = pg_field_type($this->resource, $column);
				if ($type === false) {
					return false;
				}

				return (object) [
					'orgtable' => $orgtable,
					'name' => $name,
					'orgname' => $name,
					'type' => $type,
					'charsetnr' => ($type == "bytea" ? 63 : 0), // 63 - binary
				];
			}
		}

	} elseif (extension_loaded("pdo_pgsql")) {
		define("AdminNeo\DRIVER_EXTENSION", "PDO_PgSQL");

		class PgSqlConnection extends PdoConnection
		{
			public $timeout = 0;

			public function open(string $server, string $username, string $password): bool
			{
				$db = Admin::get()->getDatabase();

				//! client_encoding is supported since 9.1, but we can't yet use minVersion() here
				$dsn = "pgsql:host='" . str_replace(":", "' port='", addcslashes($server, "'\\")) . "' client_encoding=utf8 dbname='" . ($db != "" ? addcslashes($db, "'\\") : "postgres") . "'";

				$ssl_mode = Admin::get()->getConfig()->getSslMode();
				if ($ssl_mode) {
					$dsn .= " sslmode='$ssl_mode'";
				}

				if (!$this->dsn($dsn, $username, $password)) {
					return false;
				}

				$versionInfo = $this->getValue("SELECT version()");
				$this->flavor = str_contains($versionInfo, "CockroachDB") ? "cockroach" : null;

				return true;
			}

			public function selectDatabase(string $name): bool
			{
				return Admin::get()->getDatabase() == $name;
			}

			public function query(string $query, bool $unbuffered = false)
			{
				$return = parent::query($query, $unbuffered);

				if ($this->timeout) {
					$this->timeout = 0;
					parent::query("RESET statement_timeout");
				}

				return $return;
			}

			public function warnings(): ?string
			{
				return null; // not implemented in PDO_PgSQL as of PHP 7.2.1
			}

			public function close(): void
			{
				//
			}
		}
	}



	class PgSqlDriver extends Driver
	{
		protected function __construct(Connection $connection, $admin)
		{
			parent::__construct($connection, $admin);

			//! arrays
			$this->types = [
				lang('Numbers') => [
					"smallint" => 5, "integer" => 10, "bigint" => 19,
					"boolean" => 1, "numeric" => 0,
					"real" => 7, "double precision" => 16, "money" => 20,
				],
				lang('Date and time') => [
					"date" => 13, "time" => 17, "timestamp" => 20, "timestamptz" => 21,
					"interval" => 0,
				],
				lang('Strings') => [
					"character" => 0, "character varying" => 0, "text" => 0,
					"tsquery" => 0, "tsvector" => 0,
					"uuid" => 0, "xml" => 0,
				],
				lang('Binary') => [
					"bit" => 0, "bit varying" => 0, "bytea" => 0,
				],
				lang('Network') => [
					"cidr" => 43, "inet" => 43,
					"macaddr" => 17, "macaddr8" => 23,
					"txid_snapshot" => 0,
				],
				lang('Geometry') => [
					"box" => 0, "circle" => 0, "line" => 0,
					"lseg" => 0, "path" => 0,
					"point" => 0, "polygon" => 0,
				],
			];

			if ($connection->isMinVersion("9.2")) {
				$this->types[lang('Strings')]["json"] = 4294967295;

				if ($connection->isMinVersion("9.4")) {
					$this->types[lang('Strings')]["jsonb"] = 4294967295;
				}
			}

			if ($connection->isMinVersion("12")) {
				$this->generated = ["STORED"];
			}

			// No "SQL" to avoid CSRF.
			$this->operators = [
				"=", "<", ">", "<=", ">=", "!=",
				"~", "~*", "!~", "!~*",
				"LIKE", "LIKE %%", "ILIKE", "ILIKE %%", "NOT LIKE",
				"IN", "NOT IN",
				"IS NULL", "IS NOT NULL",
			];

			$this->likeOperator = "LIKE %%";
			$this->regexpOperator = "~*";

			$this->functions = [
				"char_length", "lower", "upper",
				"round",
				"to_hex", "to_timestamp",
			];

			$this->grouping = [
				"sum", "min", "max", "avg",
				"count", "count distinct",
			];

			$this->editFunctions = [
				[
					"char" => "md5",
					"date|time" => "now",
				], [
					number_type() => "+/-",
					"date|time" => "+ interval/- interval", //! escape
					"char|text" => "||",
				]
			];

			$this->systemDatabases = ["template1"];
			$this->systemSchemas = ["information_schema", "pg_catalog", "pg_toast", "pg_temp_*", "pg_toast_temp_*"];
		}

		public function getInsertReturningSql(string $table): string
		{
			$autoIncrement = array_filter(fields($table), function ($field) {
				return $field['auto_increment'];
			});

			return count($autoIncrement) == 1 ? " RETURNING " . idf_escape(key($autoIncrement)) : "";
		}

		public function insertUpdate(string $table, array $records, array $primary): bool
		{
			foreach ($records as $record) {
				$update = [];
				$where = [];
				foreach ($record as $key => $val) {
					$update[] = "$key = $val";
					if (isset($primary[idf_unescape($key)])) {
						$where[] = "$key = $val";
					}
				}
				if (!(($where && queries("UPDATE " . table($table) . " SET " . implode(", ", $update) . " WHERE " . implode(" AND ", $where)) && Connection::get()->getAffectedRows())
					|| queries("INSERT INTO " . table($table) . " (" . implode(", ", array_keys($record)) . ") VALUES (" . implode(", ", $record) . ")")
				)) {
					return false;
				}
			}
			return true;
		}

		public function slowQuery(string $query, int $timeout): ?string
		{
			$this->connection->query("SET statement_timeout = " . (1000 * $timeout));
			$this->connection->timeout = 1000 * $timeout;

			return $query;
		}

		public function convertSearch(string $idf, array $where, array $field): string
		{
			$textTypes = "char|text";
			if (strpos($where["op"], "LIKE") === false) {
				$textTypes .= "|date|time(stamp)?|boolean|uuid|inet|cidr|macaddr|" . number_type();
			}

			return (preg_match("~$textTypes~", $field["type"]) ? $idf : "CAST($idf AS text)");
		}

		public function quoteBinary(string $string): string
		{
			return "'\\x" . bin2hex($string) . "'"; // available since PostgreSQL 8.1
		}

		public function warnings(): ?string
		{
			return $this->connection->warnings();
		}

		public function tableHelp(string $name, bool $isView = false): ?string
		{
			$links = [
				"information_schema" => "infoschema",
				"pg_catalog" => ($isView ? "view" : "catalog"),
			];
			$link = $links[$_GET["ns"]];
			if ($link) {
				return "$link-" . str_replace("_", "-", $name) . ".html";
			}

			return null;
		}

		public function supportsIndex(array $tableStatus): bool
		{
			// Returns true for "materialized view".
			return $tableStatus["Engine"] != "view";
		}

		public function hasCStyleEscapes(): bool
		{
			static $c_style;
			if ($c_style === null) {
				$c_style = ($this->connection->getValue("SHOW standard_conforming_strings") == "off");
			}
			return $c_style;
		}

	}



	function create_driver(Connection $connection): Driver
	{
		return PgSqlDriver::create($connection, Admin::get());
	}

	function idf_escape($idf) {
		return '"' . str_replace('"', '""', $idf) . '"';
	}

	function table($idf) {
		return idf_escape($idf);
	}

	function connect(bool $primary = false, ?string &$error = null): ?Connection
	{
		$connection = $primary ? PgSqlConnection::create() : PgSqlConnection::createSecondary();

		$credentials = Admin::get()->getCredentials();
		if (!$connection->open($credentials[0], $credentials[1], $credentials[2])) {
			$error = $connection->getError();
			return null;
		}

		if ($connection->isMinVersion("9")) {
			$connection->query("SET application_name = 'AdminNeo'");
		}

		if ($primary && $connection->isCockroachDB()) {
			Drivers::setName(DRIVER, "CockroachDB");
			save_driver_name(DRIVER, $credentials[0], "CockroachDB");
		}

		return $connection;
	}

	function get_databases() {
		return get_vals("SELECT datname FROM pg_database
WHERE datallowconn = TRUE AND has_database_privilege(datname, 'CONNECT')
ORDER BY datname");
	}

	function limit($query, $where, ?int $limit, $offset = 0, $separator = " ") {
		return " $query$where" . ($limit !== null ? $separator . "LIMIT $limit" . ($offset ? " OFFSET $offset" : "") : "");
	}

	function limit1($table, $query, $where, $separator = "\n") {
		return (preg_match('~^INTO~', $query)
			? limit($query, $where, 1, 0, $separator)
			: " $query" . (is_view(table_status1($table)) ? $where : $separator . "WHERE ctid = (SELECT ctid FROM " . table($table) . $where . $separator . "LIMIT 1)")
		);
	}

	function db_collation($db, $collations) {
		return Connection::get()->getValue("SELECT datcollate FROM pg_database WHERE datname = " . q($db));
	}

	function logged_user() {
		return Connection::get()->getValue("SELECT user");
	}

	function tables_list() {
		$query = "SELECT table_name, table_type FROM information_schema.tables WHERE table_schema = current_schema()";
		if (support("materializedview")) {
			$query .= "
UNION ALL
SELECT matviewname, 'MATERIALIZED VIEW'
FROM pg_matviews
WHERE schemaname = current_schema()";
		}
		$query .= "
ORDER BY 1";
		return get_key_vals($query);
	}

	function count_tables($databases) {
		$return = [];
		foreach ($databases as $db) {
			if (Connection::get()->selectDatabase($db)) {
				$return[$db] = count(tables_list());
			}
		}
		return $return;
	}

	function table_status($name = "") {
		static $has_size;
		if ($has_size === null) {
			// https://github.com/cockroachdb/cockroach/issues/40391
			$has_size = Connection::get()->getValue("SELECT 'pg_table_size'::regproc");
		}
		$return = [];
		foreach (
			get_rows("SELECT
	c.relname AS \"Name\",
	CASE c.relkind WHEN 'r' THEN 'table' WHEN 'm' THEN 'materialized view' ELSE 'view' END AS \"Engine\"" . ($has_size ? ",
	pg_table_size(c.oid) AS \"Data_length\",
	pg_indexes_size(c.oid) AS \"Index_length\"" : "") . ",
	obj_description(c.oid, 'pg_class') AS \"Comment\",
	" . (Connection::get()->isMinVersion("12") ? "''" : "CASE WHEN c.relhasoids THEN 'oid' ELSE '' END") . " AS \"Oid\",
	c.reltuples as \"Rows\",
	n.nspname
FROM pg_class c
JOIN pg_namespace n ON(n.nspname = current_schema() AND n.oid = c.relnamespace)
WHERE relkind IN ('r', 'm', 'v', 'f', 'p')
" . ($name != "" ? "AND relname = " . q($name) : "ORDER BY relname")
		) as $row) { //! Index_length, Auto_increment
			$return[$row["Name"]] = $row;
		}
		return ($name != "" ? $return[$name] : $return);
	}

	function is_view($table_status) {
		return in_array($table_status["Engine"], ["view", "materialized view"]);
	}

	function fk_support($table_status) {
		return true;
	}

	function fields($table) {
		$return = [];
		$aliases = [
			'timestamp without time zone' => 'timestamp',
			'timestamp with time zone' => 'timestamptz',
		];
		foreach (get_rows("SELECT a.attname AS field, format_type(a.atttypid, a.atttypmod) AS full_type, pg_get_expr(d.adbin, d.adrelid) AS default, a.attnotnull::int, col_description(c.oid, a.attnum) AS comment" . (Connection::get()->isMinVersion("10") ? ", a.attidentity" . (Connection::get()->isMinVersion("12") ? ", a.attgenerated" : "") : "") . "
FROM pg_class c
JOIN pg_namespace n ON c.relnamespace = n.oid
JOIN pg_attribute a ON c.oid = a.attrelid
LEFT JOIN pg_attrdef d ON c.oid = d.adrelid AND a.attnum = d.adnum
WHERE c.relname = " . q($table) . "
AND n.nspname = current_schema()
AND NOT a.attisdropped
AND a.attnum > 0
ORDER BY a.attnum"
		) as $row) {
			//! collation, primary
			preg_match('~([^([]+)(\((.*)\))?([a-z ]+)?((\[[0-9]*])*)$~', $row["full_type"], $match);
			list(, $type, $length, $row["length"], $addon, $array) = $match;
			$row["length"] .= $array;
			$check_type = $type . $addon;
			if (isset($aliases[$check_type])) {
				$row["type"] = $aliases[$check_type];
				$row["full_type"] = $row["type"] . $length . $array;
			} else {
				$row["type"] = $type;
				$row["full_type"] = $row["type"] . $length . $addon . $array;
			}
			if (in_array($row['attidentity'], ['a', 'd'])) {
				$row['default'] = 'GENERATED ' . ($row['attidentity'] == 'd' ? 'BY DEFAULT' : 'ALWAYS') . ' AS IDENTITY';
			}
			$row["generated"] = ($row["attgenerated"] == "s" ? "STORED" : "");
			$row["null"] = !$row["attnotnull"];
			$row["auto_increment"] = $row['attidentity'] || preg_match('~^nextval\(~i', $row["default"])
				|| preg_match('~^unique_rowid\(~', $row["default"]); // CockroachDB
			$row["privileges"] = ["insert" => 1, "select" => 1, "update" => 1, "where" => 1, "order" => 1];
			if (preg_match('~(.+)::[^,)]+(.*)~', $row["default"], $match)) {
				$row["default"] = ($match[1] == "NULL" ? null : idf_unescape($match[1]) . $match[2]);
			}
			$return[$row["field"]] = $row;
		}
		return $return;
	}

	function indexes(string $table, ?Connection $connection = null): array
	{
		if (!is_object($connection)) {
			$connection = Connection::get();
		}
		$return = [];
		$table_oid = $connection->getValue("SELECT oid FROM pg_class WHERE relnamespace = (SELECT oid FROM pg_namespace WHERE nspname = current_schema()) AND relname = " . q($table));
		$columns = get_key_vals("SELECT attnum, attname FROM pg_attribute WHERE attrelid = $table_oid AND attnum > 0", $connection);
		foreach (get_rows("SELECT relname, indisunique::int, indisprimary::int, indkey, indoption, (indpred IS NOT NULL)::int as indispartial FROM pg_index i, pg_class ci WHERE i.indrelid = $table_oid AND ci.oid = i.indexrelid ORDER BY indisprimary DESC, indisunique DESC", $connection) as $row) {
			$relname = $row["relname"];
			$return[$relname]["type"] = ($row["indispartial"] ? "INDEX" : ($row["indisprimary"] ? "PRIMARY" : ($row["indisunique"] ? "UNIQUE" : "INDEX")));
			$return[$relname]["columns"] = [];
			$return[$relname]["descs"] = [];
			if ($row["indkey"]) {
				foreach (explode(" ", $row["indkey"]) as $indkey) {
					$return[$relname]["columns"][] = $columns[$indkey];
				}
				foreach (explode(" ", $row["indoption"]) as $indoption) {
					$return[$relname]["descs"][] = ($indoption & 1 ? '1' : null); // 1 - INDOPTION_DESC
				}
			}
			$return[$relname]["lengths"] = [];
		}
		return $return;
	}

	function foreign_keys($table) {
		$onActions = implode("|", Driver::get()->getOnActions());

		$return = [];
		foreach (get_rows("SELECT conname, condeferrable::int AS deferrable, pg_get_constraintdef(oid) AS definition
FROM pg_constraint
WHERE conrelid = (SELECT pc.oid FROM pg_class AS pc INNER JOIN pg_namespace AS pn ON (pn.oid = pc.relnamespace) WHERE pc.relname = " . q($table) . " AND pn.nspname = current_schema())
AND contype = 'f'::char
ORDER BY conkey, conname") as $row) {
			if (preg_match('~FOREIGN KEY\s*\((.+)\)\s*REFERENCES (.+)\((.+)\)(.*)$~iA', $row['definition'], $match)) {
				$row['source'] = array_map('AdminNeo\idf_unescape', array_map('trim', explode(',', $match[1])));
				if (preg_match('~^(("([^"]|"")+"|[^"]+)\.)?"?("([^"]|"")+"|[^"]+)$~', $match[2], $match2)) {
					$row['ns'] = idf_unescape($match2[2]);
					$row['table'] = idf_unescape($match2[4]);
				}
				$row['target'] = array_map('AdminNeo\idf_unescape', array_map('trim', explode(',', $match[3])));
				$row['on_delete'] = (preg_match("~ON DELETE ($onActions)~", $match[4], $match2) ? $match2[1] : 'NO ACTION');
				$row['on_update'] = (preg_match("~ON UPDATE ($onActions)~", $match[4], $match2) ? $match2[1] : 'NO ACTION');
				$return[$row['conname']] = $row;
			}
		}
		return $return;
	}

	function view($name) {
		return ["select" => trim(Connection::get()->getValue("SELECT pg_get_viewdef(" . Connection::get()->getValue("SELECT oid FROM pg_class WHERE relnamespace = (SELECT oid FROM pg_namespace WHERE nspname = current_schema()) AND relname = " . q($name)) . ")"))];
	}

	function collations() {
		//! supported in CREATE DATABASE
		return [];
	}

	function information_schema($db) {
		return get_schema() == "information_schema";
	}

	function error() {
		$return = h(Connection::get()->getError());
		if (preg_match('~^(.*\n)?([^\n]*)\n( *)\^(\n.*)?$~s', $return, $match)) {
			$return = $match[1] . preg_replace('~((?:[^&]|&[^;]*;){' . strlen($match[3]) . '})(.*)~', '\1<b>\2</b>', $match[2]) . $match[4];
		}
		return nl2br($return);
	}

	function create_database($db, $collation) {
		return queries("CREATE DATABASE " . idf_escape($db) . ($collation ? " ENCODING " . idf_escape($collation) : ""));
	}

	function drop_databases($databases) {
		Connection::get()->close();

		return apply_queries("DROP DATABASE", $databases, 'AdminNeo\idf_escape');
	}

	function rename_database($name, $collation) {
		Connection::get()->close();

		return queries("ALTER DATABASE " . idf_escape(DB) . " RENAME TO " . idf_escape($name));
	}

	function auto_increment() {
		return "";
	}

	function alter_table($table, $name, $fields, $foreign, $comment, $engine, $collation, $auto_increment, $partitioning) {
		$alter = [];
		$queries = [];
		if ($table != "" && $table != $name) {
			$queries[] = "ALTER TABLE " . table($table) . " RENAME TO " . table($name);
		}
		$sequence = "";
		foreach ($fields as $field) {
			$column = idf_escape($field[0]);
			$val = $field[1];
			if (!$val) {
				$alter[] = "DROP $column";
			} else {
				$val5 = $val[5];
				unset($val[5]);
				if ($field[0] == "") {
					if (isset($val[6])) { // auto_increment
						$val[1] = ($val[1] == " bigint" ? " big" : ($val[1] == " smallint" ? " small" : " ")) . "serial";
					}
					$alter[] = ($table != "" ? "ADD " : "  ") . implode($val);
					if (isset($val[6])) {
						$alter[] = ($table != "" ? "ADD" : " ") . " PRIMARY KEY ($val[0])";
					}
				} else {
					if ($column != $val[0]) {
						$queries[] = "ALTER TABLE " . table($name) . " RENAME $column TO $val[0]";
					}
					$alter[] = "ALTER $column TYPE$val[1]";
					$sequence_name = $table . "_" . idf_unescape($val[0]) . "_seq";
					$alter[] = "ALTER $column " . ($val[3] ? "SET" . preg_replace('~GENERATED ALWAYS(.*) STORED~', 'EXPRESSION\1', $val[3])
						: (isset($val[6]) ? "SET DEFAULT nextval(" . q($sequence_name) . ")"
						: "DROP DEFAULT" //! change to DROP EXPRESSION with generated columns
					));
					if (isset($val[6])) {
						$sequence = "CREATE SEQUENCE IF NOT EXISTS " . idf_escape($sequence_name) . " OWNED BY " . idf_escape($table) . ".$val[0]";
					}
					$alter[] = "ALTER $column " . ($val[2] == " NULL" ? "DROP NOT" : "SET") . $val[2];
				}
				if ($field[0] != "" || $val5 != "") {
					$queries[] = "COMMENT ON COLUMN " . table($name) . ".$val[0] IS " . ($val5 != "" ? substr($val5, 9) : "''");
				}
			}
		}
		$alter = array_merge($alter, $foreign);
		if ($table == "") {
			array_unshift($queries, "CREATE TABLE " . table($name) . " (\n" . implode(",\n", $alter) . "\n)");
		} elseif ($alter) {
			array_unshift($queries, "ALTER TABLE " . table($table) . "\n" . implode(",\n", $alter));
		}
		if ($sequence) {
			array_unshift($queries, $sequence);
		}
		if ($comment !== null) {
			$queries[] = "COMMENT ON TABLE " . table($name) . " IS " . q($comment);
		}
		if ($auto_increment != "") {
			//! $queries[] = "SELECT setval(pg_get_serial_sequence(" . q($name) . ", ), $auto_increment)";
		}
		foreach ($queries as $query) {
			if (!queries($query)) {
				return false;
			}
		}
		return true;
	}

	function alter_indexes($table, $alter) {
		$create = [];
		$drop = [];
		$queries = [];
		foreach ($alter as $val) {
			if ($val[0] != "INDEX") {
				//! descending UNIQUE indexes results in syntax error
				$create[] = ($val[2] == "DROP"
					? "\nDROP CONSTRAINT " . idf_escape($val[1])
					: "\nADD" . ($val[1] != "" ? " CONSTRAINT " . idf_escape($val[1]) : "") . " $val[0] " . ($val[0] == "PRIMARY" ? "KEY " : "") . "(" . implode(", ", $val[2]) . ")"
				);
			} elseif ($val[2] == "DROP") {
				$drop[] = idf_escape($val[1]);
			} else {
				$queries[] = "CREATE INDEX " . idf_escape($val[1] != "" ? $val[1] : uniqid($table . "_")) . " ON " . table($table) . " (" . implode(", ", $val[2]) . ")";
			}
		}
		if ($create) {
			array_unshift($queries, "ALTER TABLE " . table($table) . implode(",", $create));
		}
		if ($drop) {
			array_unshift($queries, "DROP INDEX " . implode(", ", $drop));
		}
		foreach ($queries as $query) {
			if (!queries($query)) {
				return false;
			}
		}
		return true;
	}

	function truncate_tables($tables) {
		return queries("TRUNCATE " . implode(", ", array_map('AdminNeo\table', $tables)));
	}

	function drop_views($views) {
		return drop_tables($views);
	}

	function drop_tables($tables) {
		foreach ($tables as $table) {
				$status = table_status($table);
				if (!queries("DROP " . strtoupper($status["Engine"]) . " " . table($table))) {
					return false;
				}
		}
		return true;
	}

	function move_tables($tables, $views, $target) {
		foreach (array_merge($tables, $views) as $table) {
			$status = table_status($table);
			if (!queries("ALTER " . strtoupper($status["Engine"]) . " " . table($table) . " SET SCHEMA " . idf_escape($target))) {
				return false;
			}
		}
		return true;
	}

	function trigger($name, $table) {
		if ($name == "") {
			return ["Statement" => "EXECUTE PROCEDURE ()"];
		}
		$columns = [];
		$where = "WHERE trigger_schema = current_schema() AND event_object_table = " . q($table) . " AND trigger_name = " . q($name);
		foreach (get_rows("SELECT * FROM information_schema.triggered_update_columns $where") as $row) {
			$columns[] = $row["event_object_column"];
		}
		$return = [];
		foreach (get_rows('SELECT trigger_name AS "Trigger", action_timing AS "Timing", event_manipulation AS "Event", \'FOR EACH \' || action_orientation AS "Type", action_statement AS "Statement" FROM information_schema.triggers ' . "$where ORDER BY event_manipulation DESC") as $row) {
			if ($columns && $row["Event"] == "UPDATE") {
				$row["Event"] .= " OF";
			}
			$row["Of"] = implode(", ", $columns);
			if ($return) {
				$row["Event"] .= " OR $return[Event]";
			}
			$return = $row;
		}
		return $return;
	}

	function triggers($table) {
		$return = [];
		foreach (get_rows("SELECT * FROM information_schema.triggers WHERE trigger_schema = current_schema() AND event_object_table = " . q($table)) as $row) {
			$trigger = trigger($row["trigger_name"], $table);
			$return[$trigger["Trigger"]] = [$trigger["Timing"], $trigger["Event"]];
		}
		return $return;
	}

	function trigger_options() {
		return [
			"Timing" => ["BEFORE", "AFTER"],
			"Event" => ["INSERT", "UPDATE", "UPDATE OF", "DELETE", "INSERT OR UPDATE", "INSERT OR UPDATE OF", "DELETE OR INSERT", "DELETE OR UPDATE", "DELETE OR UPDATE OF", "DELETE OR INSERT OR UPDATE", "DELETE OR INSERT OR UPDATE OF"],
			"Type" => ["FOR EACH ROW", "FOR EACH STATEMENT"],
		];
	}

	function routine($name, $type) {
		$info = get_rows('SELECT routine_definition, external_language, type_udt_name
			FROM information_schema.routines
			WHERE routine_schema = current_schema() AND specific_name = ' . q($name))[0];

		$fields = get_rows('SELECT parameter_name AS field, data_type AS type, character_maximum_length AS length, parameter_mode AS inout
			FROM information_schema.parameters
			WHERE specific_schema = current_schema() AND specific_name = ' . q($name) . '
			ORDER BY ordinal_position');

		return [
			"fields" => $fields,
			"returns" => ["type" => $info["type_udt_name"]],
			"definition" => $info["routine_definition"],
			"language" => strtolower($info["external_language"]),
			"comment" => null, // Comments are not supported.
		];
	}

	function routines() {
		return get_rows('SELECT specific_name AS "SPECIFIC_NAME", routine_name AS "ROUTINE_NAME", routine_type AS "ROUTINE_TYPE", type_udt_name AS "DTD_IDENTIFIER", null AS ROUTINE_COMMENT
			FROM information_schema.routines
			WHERE routine_schema = current_schema()
			ORDER BY SPECIFIC_NAME');
	}

	function routine_languages() {
		return get_vals("SELECT LOWER(lanname) FROM pg_catalog.pg_language");
	}

	function routine_id($name, $row) {
		$return = [];
		foreach ($row["fields"] as $field) {
			$length = $field["length"];
			$return[] = $field["type"] . ($length ? "($length)" : "");
		}
		return idf_escape($name) . "(" . implode(", ", $return) . ")";
	}

	function last_id($result)
	{
		$row = $result instanceof Result ? $result->fetchRow() : [];

		return $row ? $row[0] : 0;
	}

	function explain(Connection $connection, string $query)
	{
		return $connection->query("EXPLAIN $query");
	}

	function found_rows($table_status, $where) {
		if (preg_match(
			"~ rows=([0-9]+)~",
			Connection::get()->getValue("EXPLAIN SELECT * FROM " . idf_escape($table_status["Name"]) . ($where ? " WHERE " . implode(" AND ", $where) : "")),
			$regs
		)) {
			return $regs[1];
		}
		return false;
	}

	function types() {
		return get_key_vals("SELECT oid, typname
FROM pg_type
WHERE typnamespace = (SELECT oid FROM pg_namespace WHERE nspname = current_schema())
AND typtype IN ('b','d','e')
AND typelem = 0"
		);
	}

	function type_values($id) {
		// to get values from type string: unnest(enum_range(NULL::"$type"))
		$enums = get_vals("SELECT enumlabel FROM pg_enum WHERE enumtypid = $id ORDER BY enumsortorder");
		return ($enums ? "'" . implode("', '", array_map('addslashes', $enums)) . "'" : "");
	}

	function schemas(): array
	{
		return get_vals("SELECT nspname FROM pg_namespace ORDER BY nspname");
	}

	function get_schema(): string
	{
		return Connection::get()->getValue("SELECT current_schema()");
	}

	function set_schema(string $schema, ?Connection $connection = null): bool
	{
		if (!$connection) {
			$connection = Connection::get();
		}

		$result = (bool)$connection->query("SET search_path TO " . idf_escape($schema));

		//! get types from current_schemas('t')
		Driver::get()->setUserTypes(types());

		return $result;
	}

	// create_sql() produces CREATE TABLE without FK CONSTRAINTs
	// foreign_keys_sql() produces all FK CONSTRAINTs as ALTER TABLE ... ADD CONSTRAINT
	// so that all FKs can be added after all tables have been created, avoiding any need to reorder CREATE TABLE statements in order of their FK dependencies
	function foreign_keys_sql($table) {
		$return = "";

		$status = table_status($table);
		$fkeys = foreign_keys($table);
		ksort($fkeys);

		foreach ($fkeys as $fkey_name => $fkey) {
			$return .= "ALTER TABLE ONLY " . idf_escape($status['nspname']) . "." . idf_escape($status['Name']) . " ADD CONSTRAINT " . idf_escape($fkey_name) . " $fkey[definition] " . ($fkey['deferrable'] ? 'DEFERRABLE' : 'NOT DEFERRABLE') . ";\n";
		}

		return ($return ? "$return\n" : $return);
	}

	function create_sql($table, $auto_increment, $style) {
		$return_parts = [];
		$sequences = [];

		$status = table_status($table);
		if (is_view($status)) {
			$view = view($table);
			return rtrim("CREATE VIEW " . idf_escape($table) . " AS $view[select]", ";");
		}
		$fields = fields($table);

		if (!$status || empty($fields)) {
			return false;
		}

		$return = "CREATE TABLE " . idf_escape($status['nspname']) . "." . idf_escape($status['Name']) . " (\n    ";

		// fields' definitions
		foreach ($fields as $field) {
			$part = idf_escape($field['field']) . ' ' . $field['full_type']
				. default_value($field)
				. ($field['attnotnull'] ? " NOT NULL" : "");
			$return_parts[] = $part;

			// sequences for fields
			if (preg_match('~nextval\(\'([^\']+)\'\)~', $field['default'], $matches)) {
				$sequence_name = $matches[1];
				$rows = get_rows((Connection::get()->isMinVersion("10")
					? "SELECT *, cache_size AS cache_value FROM pg_sequences WHERE schemaname = current_schema() AND sequencename = " . q(idf_unescape($sequence_name))
					: "SELECT * FROM $sequence_name"
				), null, "-- ");
				$sq = reset($rows);

				$sequences[] = ($style == "DROP+CREATE" ? "DROP SEQUENCE IF EXISTS $sequence_name;\n" : "") .
					"CREATE SEQUENCE $sequence_name INCREMENT $sq[increment_by] MINVALUE $sq[min_value] MAXVALUE $sq[max_value]" .
					($auto_increment && $sq['last_value'] ? " START " . ($sq["last_value"] + 1) : "") .
					" CACHE $sq[cache_value];";
			}
		}

		// adding sequences before table definition
		if (!empty($sequences)) {
			$return = implode("\n\n", $sequences) . "\n\n$return";
		}

		$primary = "";
		foreach (indexes($table) as $index_name => $index) {
			if ($index['type'] == 'PRIMARY') {
				$primary = $index_name;
				$return_parts[] = "CONSTRAINT " . idf_escape($index_name) . " PRIMARY KEY (" . implode(', ', array_map('AdminNeo\idf_escape', $index['columns'])) . ")";
			}
		}

		foreach (Driver::get()->checkConstraints($table) as $conname => $consrc) {
			$return_parts[] = "CONSTRAINT " . idf_escape($conname) . " CHECK $consrc";
		}

		$return .= implode(",\n    ", $return_parts) . "\n) WITH (oids = " . ($status['Oid'] ? 'true' : 'false') . ");";

		// comments for table & fields
		if ($status['Comment']) {
			$return .= "\n\nCOMMENT ON TABLE " . idf_escape($status['nspname']) . "." . idf_escape($status['Name']) . " IS " . q($status['Comment']) . ";";
		}

		foreach ($fields as $field_name => $field) {
			if ($field['comment']) {
				$return .= "\n\nCOMMENT ON COLUMN " . idf_escape($status['nspname']) . "." . idf_escape($status['Name']) . "." . idf_escape($field_name) . " IS " . q($field['comment']) . ";";
			}
		}

		foreach (get_rows("SELECT indexdef FROM pg_catalog.pg_indexes WHERE schemaname = current_schema() AND tablename = " . q($table) . ($primary ? " AND indexname != " . q($primary) : ""), null, "-- ") as $row) {
			$return .= "\n\n$row[indexdef];";
		}

		return rtrim($return, ';');
	}

	function truncate_sql($table) {
		return "TRUNCATE " . table($table);
	}

	function trigger_sql($table) {
		$status = table_status($table);
		$return = "";
		foreach (triggers($table) as $trg_id => $trg) {
			$trigger = trigger($trg_id, $status['Name']);
			$return .= "\nCREATE TRIGGER " . idf_escape($trigger['Trigger']) . " $trigger[Timing] $trigger[Event] ON " . idf_escape($status["nspname"]) . "." . idf_escape($status['Name']) . " $trigger[Type] $trigger[Statement];;\n";
		}
		return $return;
	}


	function use_sql($database) {
		return "\connect " . idf_escape($database);
	}

	function show_variables() {
		return get_rows("SHOW ALL");
	}

	function process_list() {
		return get_rows("SELECT * FROM pg_stat_activity ORDER BY " . (Connection::get()->isMinVersion("9.2") ? "pid" : "procpid"));
	}

	function convert_field($field) {
	}

	function unconvert_field(array $field, $return) {
		return $return;
	}

	function support($feature) {
		if ($feature == "processlist") {
			// https://github.com/cockroachdb/cockroach/issues/24745
			return !Connection::get()->isCockroachDB();
		} elseif ($feature == "materializedview") {
			return Connection::get()->isMinVersion("9.3");
		}

		return preg_match('~^(check|database|table|columns|sql|indexes|descidx|comment|view|scheme|routine|sequence|trigger|type|variables|drop_col|kill|dump)$~', $feature);
	}

	function kill_process($val) {
		return queries("SELECT pg_terminate_backend(" . number($val) . ")");
	}

	function connection_id(){
		return "SELECT pg_backend_pid()";
	}

	function max_connections() {
		return Connection::get()->getValue("SHOW max_connections");
	}
}
