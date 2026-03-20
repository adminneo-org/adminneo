<?php

namespace AdminNeo;

/**
* @author Jakub Cernohuby
* @author Vladimir Stastka
* @author Jakub Vrana
*/

Drivers::add("mssql", "MS SQL", ["SQLSRV", "PDO_SQLSRV", "PDO_DBLIB"]);

if (isset($_GET["mssql"])) {
	define("AdminNeo\DRIVER", "mssql");
	define("AdminNeo\DIALECT", "mssql");

	if (extension_loaded("sqlsrv") && $_GET["ext"] != "pdo" && $_GET["ext"] != "dblib") {
		define("AdminNeo\DRIVER_EXTENSION", "sqlsrv");

		class MsSqlConnection extends Connection
		{
			/** @var resource|false */
			private $connection;

			/** @var resource|false */
			protected $multiResult;

			public function open(string $server, string $username, string $password): bool
			{
				$connectionInfo = [
					"UID" => $username,
					"PWD" => $password,
					"CharacterSet" => "UTF-8",
				];

				$encrypt = Admin::get()->getConfig()->getSslEncrypt();
				if ($encrypt !== null) {
					$connectionInfo["Encrypt"] = $encrypt;
				}

				$trust = Admin::get()->getConfig()->getSslTrustServerCertificate();
				if ($trust !== null) {
					$connectionInfo["TrustServerCertificate"] = $trust;
				}

				$db = Admin::get()->getDatabase();
				if ($db != "") {
					$connectionInfo["Database"] = $db;
				}

				$this->connection = @sqlsrv_connect(preg_replace('~:~', ',', $server), $connectionInfo);
				if ($this->connection) {
					$info = sqlsrv_server_info($this->connection);
					$this->version = $info['SQLServerVersion'];
				} else {
					$this->resolveError();
				}

				return (bool) $this->connection;
			}

			private function resolveError() {
				$this->error = "";

				foreach (sqlsrv_errors() as $error) {
					$this->errno = $error["code"];
					$this->error .= "$error[message]\n";
				}

				$this->error = rtrim($this->error);
			}

			public function quote(string $string): string
			{
				return (contains_unicode($string) ? "N" : "") . "'" . str_replace("'", "''", $string) . "'";
			}

			public function selectDatabase(string $name): bool
			{
				return (bool)$this->query(use_sql($name));
			}

			function query(string $query, bool $unbuffered = false)
			{
				$result = sqlsrv_query($this->connection, $query); //! , [], ($unbuffered ? [] : ["Scrollable" => "keyset"])
				$this->error = "";

				if (!$result) {
					$this->resolveError();

					return false;
				}

				return $this->storeResult($result);
			}

			public function multiQuery(string $query): bool
			{
				$this->multiResult = sqlsrv_query($this->connection, $query);
				$this->error = "";

				if (!$this->multiResult) {
					$this->resolveError();

					return false;
				}

				return true;
			}

			public function storeResult($result = null)
			{
				if (!$result) {
					$result = $this->multiResult;
					if (!$result) {
						return false;
					}
				}

				if (sqlsrv_field_metadata($result)) {
					return new MsSqlResult($result);
				}

				$this->affectedRows = sqlsrv_rows_affected($result);

				return true;
			}

			public function nextResult(): bool
			{
				return $this->multiResult && sqlsrv_next_result($this->multiResult);
			}
		}

		class MsSqlResult extends Result
		{
			/** @var resource */
			private $resource;

			/** @var array|false */
			private $fields = false;

			/** @var int */
			private $offset = 0;

			/**
			 * @param resource $resource
			 */
			public function __construct($resource)
			{
				// sqlsrv_num_rows($result); // available only in scrollable results
				parent::__construct(0);

				$this->resource = $resource;
			}

			public function __destruct()
			{
				sqlsrv_free_stmt($this->resource);
			}

			public function fetchAssoc()
			{
				return $this->convertRow(sqlsrv_fetch_array($this->resource, SQLSRV_FETCH_ASSOC));
			}

			public function fetchRow()
			{
				return $this->convertRow(sqlsrv_fetch_array($this->resource, SQLSRV_FETCH_NUMERIC));
			}

			/**
			 * @param ?array|false $row
			 *
			 * @return ?array|false
			 */
			private function convertRow($row)
			{
				if (is_array($row)) {
					foreach ($row as $key => $val) {
						if (is_a($val, 'DateTime')) {
							$row[$key] = $val->format("Y-m-d H:i:s");
						}
						// TODO stream
					}
				}

				return $row;
			}

			public function fetchField()
			{
				if (!$this->fields) {
					$this->fields = sqlsrv_field_metadata($this->resource);
					if (!$this->fields) {
						return false;
					}
				}

				$field = $this->fields[$this->offset++];

				return (object) [
					'name' => $field["Name"],
					'type' => ($field["Type"] == 1 ? 254 : 15),
					'charsetnr' => 0,
				];
			}

			public function seek(int $offset): bool
			{
				for ($i = 0; $i < $offset; $i++) {
					// TODO SQLSRV_SCROLL_ABSOLUTE added in sqlsrv 1.1
					if (!sqlsrv_fetch($this->resource)) {
						return false;
					}
				}

				return true;
			}
		}

		function last_id($result) {
			return Connection::get()->getValue("SELECT SCOPE_IDENTITY()"); // @@IDENTITY can return trigger INSERT
		}

		function explain(Connection $connection, string $query)
		{
			$connection->query("SET SHOWPLAN_ALL ON");
			$return = $connection->query($query);
			$connection->query("SET SHOWPLAN_ALL OFF"); // connection is used also for indexes

			return $return;
		}

	} else {
		abstract class MsSqlPdoConnection extends PdoConnection
		{
			public function selectDatabase(string $name): bool
			{
				// database selection is separated from the connection so dbname in DSN can't be used
				return (bool)$this->query(use_sql($name));
			}

			public function quote(string $string): string
			{
				return (contains_unicode($string) ? "N" : "") . parent::quote($string);
			}

			public function lastInsertId()
			{
				return $this->pdo->lastInsertId();
			}
		}

		if (extension_loaded("pdo_sqlsrv") && $_GET["ext"] != "dblib") {
			define("AdminNeo\DRIVER_EXTENSION", "PDO_SQLSRV");

			class MsSqlConnection extends MsSqlPdoConnection
			{
				public function open(string $server, string $username, string $password): bool
				{
					$options = [];

					$encrypt = Admin::get()->getConfig()->getSslEncrypt();
					if ($encrypt !== null) {
						$options[] = "Encrypt=$encrypt";
					}

					$trust = Admin::get()->getConfig()->getSslTrustServerCertificate();
					if ($trust !== null) {
						$options[] = "TrustServerCertificate=$trust";
					}

					$optionsString = $options ? (";" . implode(";", $options)) : "";

					return $this->dsn("sqlsrv:Server=" . str_replace(":", ",", $server) . $optionsString, $username, $password);
				}
			}
		} elseif (extension_loaded("pdo_dblib")) {
			define("AdminNeo\DRIVER_EXTENSION", "PDO_DBLIB");

			class MsSqlConnection extends MsSqlPdoConnection
			{
				public function open(string $server, string $username, string $password): bool
				{
					$result = $this->dsn("dblib:charset=utf8;host=" . str_replace(":", ";unix_socket=", preg_replace('~:(\d)~', ';port=\1', $server)), $username, $password);
					if ($result) {
						$this->query("SET ANSI_NULLS ON; SET ANSI_PADDING ON; SET CONCAT_NULL_YIELDS_NULL ON; SET ANSI_WARNINGS ON;");
					}

					return $result;
				}
			}
		}

		function last_id($result) {
			/** @var MsSqlPdoConnection $connection */
			$connection = Connection::get();

			return $connection->lastInsertId();
		}

		function explain(Connection $connection, string $query)
		{
			//
		}
	}


	class MsSqlDriver extends Driver
	{
		protected function __construct(Connection $connection, $admin)
		{
			parent::__construct($connection, $admin);

			//! use sys.types
			$this->types = [
				lang('Numbers') => [
					"tinyint" => 3, "smallint" => 5, "int" => 10, "bigint" => 20,
					"bit" => 1, "decimal" => 0, "real" => 12, "float" => 53,
					"smallmoney" => 10, "money" => 20,
				],
				lang('Date and time') => [
					"date" => 10, "smalldatetime" => 19, "datetime" => 19, "datetime2" => 19, "time" => 8,
					"datetimeoffset" => 10,
				],
				lang('Strings') => [
					"char" => 8000, "varchar" => 8000, "text" => 2147483647,
					"nchar" => 4000, "nvarchar" => 4000, "ntext" => 1073741823,
				],
				lang('Binary') => [
					"binary" => 8000, "varbinary" => 8000, "image" => 2147483647,
				],
			];

			$this->generated = ["PERSISTED", "VIRTUAL"];

			$this->operators = [
				"=", "<", ">", "<=", ">=", "!=",
				"LIKE", "LIKE %%", "NOT LIKE",
				"IN", "NOT IN",
				"IS NULL", "IS NOT NULL",
			];

			$this->likeOperator = "LIKE %%";

			$this->functions = [
				"len", "lower", "upper",
				"round",
			];

			$this->grouping = [
				"sum", "min", "max", "avg",
				"count", "count distinct",
			];

			$this->onActions = ["CASCADE", "SET NULL", "SET DEFAULT", "NO ACTION"];

			$this->insertFunctions = [
				"date|time" => "getdate"
			];

			$this->editFunctions = [
				"int|decimal|real|float|money|datetime" => "+/-",
				"char|text" => "+",
			];

			$this->systemDatabases = ["INFORMATION_SCHEMA", "guest", "sys", "db_*"];
		}

		public function insertUpdate(string $table, array $records, array $primary)
        {
			$fields = fields($table);
			$update = [];
			$where = [];
			$record = reset($records);
			$columns = "c" . implode(", c", range(1, count($record)));
			$c = 0;
			$insert = [];
			foreach ($record as $key => $val) {
				$c++;
				$name = idf_unescape($key);
				if (!$fields[$name]["auto_increment"]) {
					$insert[$key] = "c$c";
				}
				if (isset($primary[$name])) {
					$where[] = "$key = c$c";
				} else {
					$update[] = "$key = c$c";
				}
			}
			$values = [];
			foreach ($records as $record) {
				$values[] = "(" . implode(", ", $record) . ")";
			}
			if ($where) {
				$identity = queries("SET IDENTITY_INSERT " . table($table) . " ON");
				$return = queries("MERGE " . table($table) . " USING (VALUES\n\t" . implode(",\n\t", $values) . "\n) AS source ($columns) ON " . implode(" AND ", $where) //! source, c1 - possible conflict
					. ($update ? "\nWHEN MATCHED THEN UPDATE SET " . implode(", ", $update) : "")
					. "\nWHEN NOT MATCHED THEN INSERT (" . implode(", ", array_keys($identity ? $record : $insert)) . ") VALUES (" . ($identity ? $columns : implode(", ", $insert)) . ");" // ; is mandatory
				);
				if ($identity) {
					queries("SET IDENTITY_INSERT " . table($table) . " OFF");
				}
			} else {
				$return = queries("INSERT INTO " . table($table) . " (" . implode(", ", array_keys($record)) . ") VALUES\n" . implode(",\n", $values));
			}
			return $return;
		}

		public function begin()
        {
			return queries("BEGIN TRANSACTION");
		}

		public function tableHelp(string $name, bool $isView = false): ?string
        {
			$links = [
				"sys" => "catalog-views/sys-",
				"INFORMATION_SCHEMA" => "information-schema-views/",
			];
			$link = $links[get_schema()];
			if ($link) {
				return "relational-databases/system-$link" . preg_replace('~_~', '-', strtolower($name)) . "-transact-sql";
			}

            return null;
		}

	}



	function create_driver(Connection $connection): Driver
	{
		return MsSqlDriver::create($connection, Admin::get());
	}

	/**
	 * @param string $string
	 * @return bool
	 */
	function contains_unicode(string $string): bool
	{
		return strlen($string) != strlen(utf8_decode($string));
	}

	function idf_escape($idf) {
		return "[" . str_replace("]", "]]", $idf) . "]";
	}

	function table($idf) {
		return ($_GET["ns"] != "" ? idf_escape($_GET["ns"]) . "." : "") . idf_escape($idf);
	}

	function connect(bool $primary = false, ?string &$error = null): ?Connection
	{
		$connection = $primary ? MsSqlConnection::create() : MsSqlConnection::createSecondary();

		$credentials = Admin::get()->getCredentials();
		if ($credentials[0] == "") {
			$credentials[0] = "localhost:1433";
		}

		if (!$connection->open($credentials[0], $credentials[1], $credentials[2])) {
			$error = $connection->getError();
			return null;
		}

		return $connection;
	}

	function get_databases(bool $flush): array
	{
		return get_vals("SELECT name FROM sys.databases WHERE name NOT IN ('master', 'tempdb', 'model', 'msdb') ORDER BY name");
	}

	function limit($query, $where, int $limit, $offset = 0, $separator = " ") {
		return ($limit ? " TOP (" . ($limit + $offset) . ")" : "") . " $query$where"; // seek later
	}

	function limit1($table, $query, $where, $separator = "\n") {
		return limit($query, $where, 1, 0, $separator);
	}

	function db_collation($db, $collations) {
		return Connection::get()->getValue("SELECT collation_name FROM sys.databases WHERE name = " . q($db));
	}

	function logged_user() {
		return Connection::get()->getValue("SELECT SUSER_NAME()");
	}

	function tables_list() {
		return get_key_vals("SELECT name, type_desc FROM sys.all_objects WHERE schema_id = SCHEMA_ID(" . q(get_schema()) . ") AND type IN ('S', 'U', 'V') ORDER BY name");
	}

	function count_tables($databases) {
		$return = [];
		foreach ($databases as $db) {
			Connection::get()->selectDatabase($db);
			$return[$db] = Connection::get()->getValue("SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLES");
		}
		return $return;
	}

	function table_status($name = "") {
		$return = [];
		foreach (get_rows("SELECT ao.name AS Name, ao.type_desc AS Engine, (SELECT value FROM fn_listextendedproperty(default, 'SCHEMA', schema_name(schema_id), 'TABLE', ao.name, null, null)) AS Comment FROM sys.all_objects AS ao WHERE schema_id = SCHEMA_ID(" . q(get_schema()) . ") AND type IN ('S', 'U', 'V') " . ($name != "" ? "AND name = " . q($name) : "ORDER BY name")) as $row) {
			$return[$row["Name"]] = $row;
		}
		return $return;
	}

	function is_view($table_status) {
		return $table_status["Engine"] == "VIEW";
	}

	function fk_support($table_status) {
		return true;
	}

	function fields($table) {
		$comments = get_key_vals("SELECT objname, cast(value as varchar(max)) FROM fn_listextendedproperty('MS_DESCRIPTION', 'schema', " . q(get_schema()) . ", 'table', " . q($table) . ", 'column', NULL)");
		$return = [];
		$table_id = Connection::get()->getValue("SELECT object_id FROM sys.all_objects WHERE schema_id = SCHEMA_ID(" . q(get_schema()) . ") AND type IN ('S', 'U', 'V') AND name = " . q($table));
		foreach (
			get_rows("SELECT c.max_length, c.precision, c.scale, c.name, c.is_nullable, c.is_identity, c.collation_name, t.name type, d.definition [default], d.name default_constraint, i.is_primary_key
FROM sys.all_columns c
JOIN sys.types t ON c.user_type_id = t.user_type_id
LEFT JOIN sys.default_constraints d ON c.default_object_id = d.object_id
LEFT JOIN sys.index_columns ic ON c.object_id = ic.object_id AND c.column_id = ic.column_id
LEFT JOIN sys.indexes i ON ic.object_id = i.object_id AND ic.index_id = i.index_id
WHERE c.object_id = " . q($table_id)) as $row
		) {
			$type = $row["type"];
			$length = (preg_match("~char|binary~", $type)
				? intval($row["max_length"]) / ($type[0] == 'n' ? 2 : 1)
				: ($type == "decimal" ? "$row[precision],$row[scale]" : "")
			);
			$return[$row["name"]] = [
				"field" => $row["name"],
				"full_type" => $type . ($length ? "($length)" : ""),
				"type" => $type,
				"length" => $length,
				"default" => (preg_match("~^\('(.*)'\)$~", $row["default"], $match) ? str_replace("''", "'", $match[1]) : $row["default"]),
				"default_constraint" => $row["default_constraint"],
				"null" => $row["is_nullable"],
				"auto_increment" => $row["is_identity"],
				"collation" => $row["collation_name"],
				"privileges" => ["insert" => 1, "select" => 1, "update" => 1, "where" => 1, "order" => 1],
				"primary" => $row["is_primary_key"],
				"comment" => $comments[$row["name"]],
			];
		}
		foreach (get_rows("SELECT * FROM sys.computed_columns WHERE object_id = " . q($table_id)) as $row) {
			$return[$row["name"]]["generated"] = ($row["is_persisted"] ? "PERSISTED" : "VIRTUAL");
			$return[$row["name"]]["default"] = $row["definition"];
		}
		return $return;
	}

	function indexes(string $table, ?Connection $connection = null): array
	{
		$return = [];
		// sp_statistics doesn't return information about primary key
		foreach (get_rows("SELECT i.name, key_ordinal, is_unique, is_primary_key, c.name AS column_name, is_descending_key
FROM sys.indexes i
INNER JOIN sys.index_columns ic ON i.object_id = ic.object_id AND i.index_id = ic.index_id
INNER JOIN sys.columns c ON ic.object_id = c.object_id AND ic.column_id = c.column_id
WHERE OBJECT_NAME(i.object_id) = " . q($table)
		, $connection) as $row) {
			$name = $row["name"];
			$return[$name]["type"] = ($row["is_primary_key"] ? "PRIMARY" : ($row["is_unique"] ? "UNIQUE" : "INDEX"));
			$return[$name]["lengths"] = [];
			$return[$name]["columns"][$row["key_ordinal"]] = $row["column_name"];
			$return[$name]["descs"][$row["key_ordinal"]] = ($row["is_descending_key"] ? '1' : null);
		}
		return $return;
	}

	function view($name) {
		return ["select" => preg_replace('~^(?:[^[]|\[[^]]*])*\s+AS\s+~isU', '', Connection::get()->getValue("SELECT VIEW_DEFINITION FROM INFORMATION_SCHEMA.VIEWS WHERE TABLE_SCHEMA = SCHEMA_NAME() AND TABLE_NAME = " . q($name)))];
	}

	function collations() {
		$return = [];
		foreach (get_vals("SELECT name FROM fn_helpcollations()") as $collation) {
			$return[preg_replace('~_.*~', '', $collation)][] = $collation;
		}
		return $return;
	}

	function information_schema(?string $db): bool
	{
		return get_schema() == "INFORMATION_SCHEMA";
	}

	function error() {
		return nl2br(h(preg_replace('~^(\[[^]]*])+~m', '', Connection::get()->getError())));
	}

	function create_database($db, $collation): bool
	{
		return (bool)queries("CREATE DATABASE " . idf_escape($db) . (preg_match('~^[a-z0-9_]+$~i', $collation) ? " COLLATE $collation" : ""));
	}

	function drop_databases($databases): bool
	{
		return (bool)queries("DROP DATABASE " . implode(", ", array_map('AdminNeo\idf_escape', $databases)));
	}

	function rename_database($name, $collation): bool
	{
		if (preg_match('~^[a-z0-9_]+$~i', $collation)) {
			queries("ALTER DATABASE " . idf_escape(DB) . " COLLATE $collation");
		}
		queries("ALTER DATABASE " . idf_escape(DB) . " MODIFY NAME = " . idf_escape($name));
		return true; //! false negative "The database name 'test2' has been set."
	}

	function auto_increment(): string
	{
		return " IDENTITY" . ($_POST["Auto_increment"] != "" ? "(" . number($_POST["Auto_increment"]) . ",1)" : "") . " PRIMARY KEY";
	}

	function alter_table($table, $name, $fields, $foreign, $comment, $engine, $collation, $auto_increment, $partitioning): bool
	{
		$alter = [];
		$comments = [];
		$orig_fields = fields($table);
		foreach ($fields as $field) {
			$column = idf_escape($field[0]);
			$val = $field[1];
			if (!$val) {
				$alter["DROP"][] = " COLUMN $column";
			} else {
				$val[1] = preg_replace("~( COLLATE )'(\\w+)'~", '\1\2', $val[1]);
				$comments[$field[0]] = $val[5];
				unset($val[5]);
				if (preg_match('~ AS ~', $val[3])) {
					unset($val[1], $val[2]);
				}
				if ($field[0] == "") {
					$alter["ADD"][] = "\n  " . implode("", $val) . ($table == "" ? substr($foreign[$val[0]], 16 + strlen($val[0])) : ""); // 16 - strlen("  FOREIGN KEY ()")
				} else {
					$default = $val[3];
					unset($val[3]); // default values are set separately
					unset($val[6]); //! identity can't be removed
					if ($column != $val[0]) {
						queries("EXEC sp_rename " . q(table($table) . ".$column") . ", " . q(idf_unescape($val[0])) . ", 'COLUMN'");
					}
					$alter["ALTER COLUMN " . implode("", $val)][] = "";
					$orig_field = $orig_fields[$field[0]];
					if (default_value($orig_field) != $default) {
						if ($orig_field["default"] !== null) {
							$alter["DROP"][] = " " . idf_escape($orig_field["default_constraint"]);
						}
						if ($default) {
							$alter["ADD"][] = "\n $default FOR $column";
						}
					}
				}
			}
		}
		if ($table == "") {
			return (bool)queries("CREATE TABLE " . table($name) . " (" . implode(",", (array) $alter["ADD"]) . "\n)");
		}
		if ($table != $name) {
			queries("EXEC sp_rename " . q(table($table)) . ", " . q($name));
		}
		if ($foreign) {
			$alter[""] = $foreign;
		}
		foreach ($alter as $key => $val) {
			if (!queries("ALTER TABLE " . table($name) . " $key" . implode(",", $val))) {
				return false;
			}
		}
		foreach ($comments as $key => $val) {
			$comment = substr($val, 9); // 9 - strlen(" COMMENT ")
			queries("EXEC sp_dropextendedproperty @name = N'MS_Description', @level0type = N'Schema', @level0name = " . q(get_schema()) . ", @level1type = N'Table', @level1name = " . q($name) . ", @level2type = N'Column', @level2name = " . q($key));
			queries("EXEC sp_addextendedproperty @name = N'MS_Description', @value = " . $comment . ", @level0type = N'Schema', @level0name = " . q(get_schema()) . ", @level1type = N'Table', @level1name = " . q($name) . ", @level2type = N'Column', @level2name = " . q($key));
		}
		return true;
	}

	function alter_indexes($table, $alter): bool
	{
		$index = [];
		$drop = [];
		foreach ($alter as $val) {
			if ($val[2] == "DROP") {
				if ($val[0] == "PRIMARY") { //! sometimes used also for UNIQUE
					$drop[] = idf_escape($val[1]);
				} else {
					$index[] = idf_escape($val[1]) . " ON " . table($table);
				}
			} elseif (!queries(($val[0] != "PRIMARY"
				? "CREATE $val[0] " . ($val[0] != "INDEX" ? "INDEX " : "") . idf_escape($val[1] != "" ? $val[1] : uniqid($table . "_")) . " ON " . table($table)
				: "ALTER TABLE " . table($table) . " ADD PRIMARY KEY"
			) . " (" . implode(", ", $val[2]) . ")")) {
				return false;
			}
		}
		return (!$index || queries("DROP INDEX " . implode(", ", $index)))
			&& (!$drop || queries("ALTER TABLE " . table($table) . " DROP " . implode(", ", $drop)))
		;
	}

	function found_rows(array $table_status, array $where): ?int
	{
		return null;
	}

	function foreign_keys($table) {
		$return = [];
		$onActions = Driver::get()->getOnActions();

		foreach (get_rows("EXEC sp_fkeys @fktable_name = " . q($table) . ", @fktable_owner = " . q(get_schema())) as $row) {
			$foreign_key = &$return[$row["FK_NAME"]];
			$foreign_key["db"] = $row["PKTABLE_QUALIFIER"];
			$foreign_key["ns"] = $row["PKTABLE_OWNER"];
			$foreign_key["table"] = $row["PKTABLE_NAME"];
			$foreign_key["on_update"] = $onActions[$row["UPDATE_RULE"]];
			$foreign_key["on_delete"] = $onActions[$row["DELETE_RULE"]];
			$foreign_key["source"][] = $row["FKCOLUMN_NAME"];
			$foreign_key["target"][] = $row["PKCOLUMN_NAME"];
		}
		return $return;
	}

	function backward_keys(string $table): array
	{
		$query = "SELECT fk.name AS constraint_name,
OBJECT_SCHEMA_NAME(fkc.parent_object_id) AS table_schema,
OBJECT_NAME(fkc.parent_object_id) AS table_name,
COL_NAME(fkc.parent_object_id, fkc.parent_column_id) AS column_name,
COL_NAME(fkc.referenced_object_id, fkc.referenced_column_id) AS referenced_column_name
FROM sys.foreign_key_columns fkc
JOIN sys.foreign_keys fk ON fkc.constraint_object_id = fk.object_id
WHERE OBJECT_SCHEMA_NAME(fkc.referenced_object_id) = " . q($_GET["ns"]) . "
AND OBJECT_NAME(fkc.referenced_object_id) = " . q($table) . "
ORDER BY table_schema, table_name";

		return get_rows($query, null, "");
	}

	function truncate_tables($tables): bool
	{
		return apply_queries("TRUNCATE TABLE", $tables);
	}

	function drop_views($views): bool
	{
		return (bool)queries("DROP VIEW " . implode(", ", array_map('AdminNeo\table', $views)));
	}

	function drop_tables($tables): bool
	{
		return (bool)queries("DROP TABLE " . implode(", ", array_map('AdminNeo\table', $tables)));
	}

	function move_tables($tables, $views, $target): bool
	{
		return apply_queries("ALTER SCHEMA " . idf_escape($target) . " TRANSFER", array_merge($tables, $views));
	}

	function trigger(string $name, string $table): array
	{
		if ($name == "") {
			return [];
		}

		// Triggers are not schema-scoped.
		$rows = get_rows("SELECT s.name [Trigger],
CASE WHEN OBJECTPROPERTY(s.id, 'ExecIsInsertTrigger') = 1 THEN 'INSERT' WHEN OBJECTPROPERTY(s.id, 'ExecIsUpdateTrigger') = 1 THEN 'UPDATE' WHEN OBJECTPROPERTY(s.id, 'ExecIsDeleteTrigger') = 1 THEN 'DELETE' END [Event],
CASE WHEN OBJECTPROPERTY(s.id, 'ExecIsInsteadOfTrigger') = 1 THEN 'INSTEAD OF' ELSE 'AFTER' END [Timing],
c.text
FROM sysobjects s
JOIN syscomments c ON s.id = c.id
WHERE s.xtype = 'TR' AND s.name = " . q($name)
		);

		$trigger = reset($rows);
		if ($trigger) {
			$trigger["Statement"] = preg_replace('~^.+\s+AS\s+~isU', '', $trigger["text"]); //! identifiers, comments
		}

		return $trigger;
	}

	function triggers($table) {
		$return = [];
		foreach (get_rows("SELECT sys1.name,
CASE WHEN OBJECTPROPERTY(sys1.id, 'ExecIsInsertTrigger') = 1 THEN 'INSERT' WHEN OBJECTPROPERTY(sys1.id, 'ExecIsUpdateTrigger') = 1 THEN 'UPDATE' WHEN OBJECTPROPERTY(sys1.id, 'ExecIsDeleteTrigger') = 1 THEN 'DELETE' END [Event],
CASE WHEN OBJECTPROPERTY(sys1.id, 'ExecIsInsteadOfTrigger') = 1 THEN 'INSTEAD OF' ELSE 'AFTER' END [Timing]
FROM sysobjects sys1
JOIN sysobjects sys2 ON sys1.parent_obj = sys2.id
WHERE sys1.xtype = 'TR' AND sys2.name = " . q($table)
		) as $row) { // triggers are not schema-scoped
			$return[$row["name"]] = [$row["Timing"], $row["Event"]];
		}
		return $return;
	}

	function trigger_options() {
		return [
			"Timing" => ["AFTER", "INSTEAD OF"],
			"Event" => ["INSERT", "UPDATE", "DELETE"],
			"Type" => ["AS"],
		];
	}

	function schemas(): array
	{
		return get_vals("SELECT name FROM sys.schemas");
	}

	function get_schema(): string
	{
		if ($_GET["ns"] != "") {
			return $_GET["ns"];
		}
		return Connection::get()->getValue("SELECT SCHEMA_NAME()");
	}

	function set_schema(string $schema, ?Connection $connection = null): bool
	{
		$_GET["ns"] = $schema;

		return true; // ALTER USER is permanent
	}

	function create_sql($table, $auto_increment, $style) {
		if (is_view(table_status1($table))) {
			$view = view($table);
			return "CREATE VIEW " . table($table) . " AS $view[select]";
		}
		$fields = [];
		$primary = false;
		foreach (fields($table) as $name => $field) {
			$val = process_field($field, $field);
			if ($val[6]) {
				$primary = true;
			}
			$fields[] = implode("", $val);
		}
		foreach (indexes($table) as $name => $index) {
			if (!$primary || $index["type"] != "PRIMARY") {
				$columns = [];
				foreach ($index["columns"] as $key => $val) {
					$columns[] = idf_escape($val) . ($index["descs"][$key] ? " DESC" : "");
				}
				$name = idf_escape($name);
				$fields[] = ($index["type"] == "INDEX" ? "INDEX $name" : "CONSTRAINT $name " . ($index["type"] == "UNIQUE" ? "UNIQUE" : "PRIMARY KEY")) . " (" . implode(", ", $columns) . ")";
			}
		}
		foreach (Driver::get()->checkConstraints($table) as $name => $check) {
			$fields[] = "CONSTRAINT " . idf_escape($name) . " CHECK ($check)";
		}
		return "CREATE TABLE " . table($table) . " (\n\t" . implode(",\n\t", $fields) . "\n)";
	}

	function foreign_keys_sql($table) {
		$fields = [];
		foreach (foreign_keys($table) as $foreign) {
			$fields[] = ltrim(format_foreign_key($foreign));
		}
		return ($fields ? "ALTER TABLE " . table($table) . " ADD\n\t" . implode(",\n\t", $fields) . ";\n\n" : "");
	}

	function truncate_sql($table) {
		return "TRUNCATE TABLE " . table($table);
	}

	function use_sql($database) {
		return "USE " . idf_escape($database);
	}

	function trigger_sql(string $table): string
	{
		$sql = "";
		foreach (triggers($table) as $name => $trigger) {
			$sql .= create_trigger(" ON " . table($table), trigger($name, $table)) . ";";
		}

		return $sql;
	}

	function convert_field(array $field): ?string
	{
		return null;
	}

	function unconvert_field(array $field, string $return): string
	{
		return $return;
	}

	function support($feature) {
		return preg_match('~^(check|comment|columns|database|drop_col|dump|indexes|descidx|scheme|sql|table|trigger|view|view_trigger)$~', $feature); //! routine|
	}
}
