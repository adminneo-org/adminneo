<?php

namespace AdminNeo;

Drivers::add("oracle", "Oracle (beta)", ["OCI8", "PDO_OCI"]);

if (isset($_GET["oracle"])) {
	define("AdminNeo\DRIVER", "oracle");
	define("AdminNeo\DIALECT", "oracle");

	if (extension_loaded("oci8")) {
		define("AdminNeo\DRIVER_EXTENSION", "oci8");

		class OracleConnection extends Connection
		{
			/** @var resource|false */
			private $connection;

			/** @var ?string */
			private $dbName = null;

			public function open(string $server, string $username, string $password): bool
			{
				$this->connection = @oci_new_connect($username, $password, $server, "AL32UTF8");
				if ($this->connection) {
					$this->version = oci_server_version($this->connection);

					return true;
				}

				$error = oci_error();
				$this->error = $error["message"];

				return false;
			}

			public function quote(string $string): string
			{
				return "'" . str_replace("'", "''", $string) . "'";
			}

			public function selectDatabase(string $name): bool
			{
				$this->dbName = $name;

				return true;
			}

			public function getAndClearDbName(): ?string
			{
				$name = $this->dbName ?: DB;
				$this->dbName = null;

				return $name;
			}

			function query(string $query, bool $unbuffered = false)
			{
				$result = oci_parse($this->connection, $query);
				$this->error = "";

				if (!$result) {
					$error = oci_error($this->connection);
					$this->errno = $error["code"];
					$this->error = $error["message"];

					return false;
				}

				set_error_handler(function($errno, $error) {
					if (ini_bool("html_errors")) {
						$error = html_entity_decode(strip_tags($error));
					}

					$error = preg_replace('~^[^:]*: ~', '', $error);
					$this->error = $error;
				});

				$return = @oci_execute($result);
				restore_error_handler();

				if ($return) {
					if (oci_num_fields($result)) {
						return new OracleResult($result);
					}

					$this->affectedRows = oci_num_rows($result);
					oci_free_statement($result);
				}

				return $return;
			}

			public function getValue(string $query, int $fieldIndex = 0)
			{
				$result = $this->query($query);

				return is_object($result) ? $result->fetchValue($fieldIndex) : false;
			}
		}

		class OracleResult extends Result
		{
			/** @var resource */
			private $resource;

			/** @var int */
			private $offset = 1;

			/**
			 * @param resource $result
			 */
			public function __construct($result)
			{
				parent::__construct(0);

				$this->resource = $result;
			}

			public function __destruct()
			{
				oci_free_statement($this->resource);
			}

			public function fetchAssoc()
			{
				return $this->convertRow(oci_fetch_assoc($this->resource));
			}

			public function fetchRow()
			{
				return $this->convertRow(oci_fetch_row($this->resource));
			}

			/**
			 * @return mixed|false
			 */
			public function fetchValue(int $fieldIndex)
			{
				return oci_fetch($this->resource) ? oci_result($this->resource, $fieldIndex + 1) : false;
			}

			/**
			 * @param array|false $row
			 *
			 * @return array|false
			 */
			private function convertRow($row)
			{
				if (is_array($row)) {
					foreach ($row as $key => $val) {
						if (is_a($val, 'OCI-Lob')) {
							$row[$key] = $val->load();
						}
					}
				}

				return $row;
			}

			public function fetchField()
			{
				$column = $this->offset++;

				$name = oci_field_name($this->resource, $column);
				if ($name === false) {
					return false;
				}

				$type = oci_field_type($this->resource, $column);
				if ($type === false) {
					return false;
				}

				return (object) [
					'name' => $name,
					'orgname' => $name,
					'type' => $type,
					'charsetnr' => (preg_match("~raw|blob|bfile~", $type) ? 63 : 0), // 63 - binary
				];
			}
		}

	} elseif (extension_loaded("pdo_oci")) {
		define("AdminNeo\DRIVER_EXTENSION", "PDO_OCI");

		class OracleConnection extends PdoConnection
		{
			/** @var ?string */
			private $dbName = null;

			public function open(string $server, string $username, string $password): bool
			{
				return $this->dsn("oci:dbname=//$server;charset=AL32UTF8", $username, $password);
			}

			public function selectDatabase(string $name): bool
			{
				$this->dbName = $name;

				return true;
			}

			public function getAndClearDbName(): ?string
			{
				$name = $this->dbName ?: DB;
				$this->dbName = null;

				return $name;
			}
		}
	}



	class OracleDriver extends Driver
	{
		protected function __construct(Connection $connection, $admin)
		{
			parent::__construct($connection, $admin);

			$this->types = [
				lang('Numbers') => [
					"number" => 38, "binary_float" => 12, "binary_double" => 21,
				],
				lang('Date and time') => [
					"date" => 10, "timestamp" => 29, "interval year" => 12, "interval day" => 28, //! year(), day() to second()
				],
				lang('Strings') => [
					"char" => 2000, "varchar2" => 4000,
					"nchar" => 2000, "nvarchar2" => 4000,
					"clob" => 4294967295, "nclob" => 4294967295,
				],
				lang('Binary') => [
					"raw" => 2000, "long raw" => 2147483648,
					"blob" => 4294967295, "bfile" => 4294967296,
				],
			];

			$this->operators = [
				"=", "<", ">", "<=", ">=", "!=",
				"LIKE", "LIKE %%", "NOT LIKE",
				"IN", "NOT IN",
				"IS NULL", "IS NOT NULL",
				"SQL",
			];

			$this->likeOperator = "LIKE %%";

			$this->functions = [
				"length", "lower", "upper",
				"round",
			];

			$this->grouping = [
				"sum", "min", "max", "avg",
				"count", "count distinct",
			];

			$this->editFunctions = [
				[ //! no parentheses
					"date" => "current_date",
					"timestamp" => "current_timestamp",
				], [
					"number|float|double" => "+/-",
					"date|timestamp" => "+ interval/- interval",
					"char|clob" => "||",
				]
			];
		}

		//! support empty $set in insert()

		public function begin(): bool
		{
			return true; // automatic start
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

		public function hasCStyleEscapes(): bool
		{
			return true;
		}

	}



	function create_driver(Connection $connection): Driver
	{
		return OracleDriver::create($connection, Admin::get());
	}

	/**
	 * @param string $hostPath
	 * @return bool
	 */
	function is_server_host_valid($hostPath) {
		// EasyConnect host+path format: host[/[service_name][:server_type][/instance_name]]
		return (bool)preg_match('~^[^/]+(/([^/:]+)?(:[^/:]+)?(/[^/:]+)?)?$~', $hostPath);
	}

	function idf_escape($idf) {
		return '"' . str_replace('"', '""', $idf) . '"';
	}

	function table($idf) {
		return idf_escape($idf);
	}

	function connect(bool $primary = false, ?string &$error = null): ?Connection
	{
		$connection = $primary ? OracleConnection::create() : OracleConnection::createSecondary();

		$credentials = Admin::get()->getCredentials();

		if (!$connection->open($credentials[0], $credentials[1], $credentials[2])) {
			$error = $connection->getError();
			return null;
		}

		return $connection;
	}

	function get_databases() {
		return get_vals("SELECT DISTINCT tablespace_name FROM (
SELECT tablespace_name FROM user_tablespaces
UNION SELECT tablespace_name FROM all_tables WHERE tablespace_name IS NOT NULL
)
ORDER BY 1"
		);
	}

	function limit($query, $where, ?int $limit, $offset = 0, $separator = " ") {
		return ($offset ? " * FROM (SELECT t.*, rownum AS rnum FROM (SELECT $query$where) t WHERE rownum <= " . ($limit + $offset) . ") WHERE rnum > $offset"
			: ($limit !== null ? " * FROM (SELECT $query$where) WHERE rownum <= " . ($limit + $offset)
			: " $query$where"
		));
	}

	function limit1($table, $query, $where, $separator = "\n") {
		return " $query$where"; //! limit
	}

	function db_collation($db, $collations) {
		return Connection::get()->getValue("SELECT value FROM nls_database_parameters WHERE parameter = 'NLS_CHARACTERSET'"); //! respect $db
	}

	function logged_user() {
		return Connection::get()->getValue("SELECT USER FROM DUAL");
	}

	function where_owner($prefix, $owner = "owner") {
		if (!$_GET["ns"]) {
			return '';
		}
		return "$prefix$owner = sys_context('USERENV', 'CURRENT_SCHEMA')";
	}

	function views_table($columns) {
		$owner = where_owner('');
		return "(SELECT $columns FROM all_views WHERE " . ($owner ?: "rownum < 0") . ")";
	}

	function tables_list() {
		$view = views_table("view_name");
		$owner = where_owner(" AND ");
		return get_key_vals("SELECT table_name, 'table' FROM all_tables WHERE tablespace_name = " . q(DB) . "$owner
UNION SELECT view_name, 'view' FROM $view
ORDER BY 1"
		); //! views don't have schema
	}

	function count_tables($databases) {
		$return = [];
		foreach ($databases as $db) {
			$return[$db] = Connection::get()->getValue("SELECT COUNT(*) FROM all_tables WHERE tablespace_name = " . q($db));
		}
		return $return;
	}

	function table_status($name = "") {
		$return = [];
		$search = q($name);
		$db = Connection::get()->getAndClearDbName();
		$view = views_table("view_name");
		$owner = where_owner(" AND ");
		foreach (get_rows('SELECT table_name "Name", \'table\' "Engine", avg_row_len * num_rows "Data_length", num_rows "Rows" FROM all_tables WHERE tablespace_name = ' . q($db) . $owner . ($name != "" ? " AND table_name = $search" : "") . "
UNION SELECT view_name, 'view', 0, 0 FROM $view" . ($name != "" ? " WHERE view_name = $search" : "") . "
ORDER BY 1"
		) as $row) {
			if ($name != "") {
				return $row;
			}
			$return[$row["Name"]] = $row;
		}
		return $return;
	}

	function is_view($table_status) {
		return $table_status["Engine"] == "view";
	}

	function fk_support($table_status) {
		return true;
	}

	function fields($table) {
		$return = [];
		$owner = where_owner(" AND ");
		foreach (get_rows("SELECT * FROM all_tab_columns WHERE table_name = " . q($table) . "$owner ORDER BY column_id") as $row) {
			$type = $row["DATA_TYPE"];
			$length = "$row[DATA_PRECISION],$row[DATA_SCALE]";
			if ($length == ",") {
				$length = $row["CHAR_COL_DECL_LENGTH"];
			} //! int
			$return[$row["COLUMN_NAME"]] = [
				"field" => $row["COLUMN_NAME"],
				"full_type" => $type . ($length ? "($length)" : ""),
				"type" => strtolower($type),
				"length" => $length,
				"default" => $row["DATA_DEFAULT"],
				"null" => ($row["NULLABLE"] == "Y"),
				//! "auto_increment" => false,
				//! "collation" => $row["CHARACTER_SET_NAME"],
				"privileges" => ["insert" => 1, "select" => 1, "update" => 1, "where" => 1, "order" => 1],
				//! "comment" => $row["Comment"],
				//! "primary" => ($row["Key"] == "PRI"),
			];
		}
		return $return;
	}

	function indexes(string $table, ?Connection $connection = null): array
	{
		$return = [];
		$owner = where_owner(" AND ", "aic.table_owner");
		foreach (get_rows("SELECT aic.*, ac.constraint_type, atc.data_default
FROM all_ind_columns aic
LEFT JOIN all_constraints ac ON aic.index_name = ac.constraint_name AND aic.table_name = ac.table_name AND aic.index_owner = ac.owner
LEFT JOIN all_tab_cols atc ON aic.column_name = atc.column_name AND aic.table_name = atc.table_name AND aic.index_owner = atc.owner
WHERE aic.table_name = " . q($table) . "$owner
ORDER BY ac.constraint_type, aic.column_position", $connection) as $row) {
			$index_name = $row["INDEX_NAME"];
			$column_name = $row["DATA_DEFAULT"];
			$column_name = ($column_name ? trim($column_name, '"') : $row["COLUMN_NAME"]); // trim - possibly wrapped in quotes but never contains quotes inside
			$return[$index_name]["type"] = ($row["CONSTRAINT_TYPE"] == "P" ? "PRIMARY" : ($row["CONSTRAINT_TYPE"] == "U" ? "UNIQUE" : "INDEX"));
			$return[$index_name]["columns"][] = $column_name;
			$return[$index_name]["lengths"][] = ($row["CHAR_LENGTH"] && $row["CHAR_LENGTH"] != $row["COLUMN_LENGTH"] ? $row["CHAR_LENGTH"] : null);
			$return[$index_name]["descs"][] = ($row["DESCEND"] && $row["DESCEND"] == "DESC" ? '1' : null);
		}
		return $return;
	}

	function view($name) {
		$view = views_table("view_name, text");
		$rows = get_rows('SELECT text "select" FROM ' . $view . ' WHERE view_name = ' . q($name));
		return reset($rows);
	}

	function collations() {
		return []; //!
	}

	function information_schema($db) {
		return get_schema() == "INFORMATION_SCHEMA";
	}

	function error() {
		return h(Connection::get()->getError()); //! highlight sqltext from offset
	}

	function explain(Connection $connection, string $query)
	{
		$connection->query("EXPLAIN PLAN FOR $query");

		return $connection->query("SELECT * FROM plan_table");
	}

	function found_rows($table_status, $where) {
	}

	function auto_increment() {
		return "";
	}

	function alter_table($table, $name, $fields, $foreign, $comment, $engine, $collation, $auto_increment, $partitioning) {
		$alter = $drop = [];
		$orig_fields = ($table ? fields($table) : []);
		foreach ($fields as $field) {
			$val = $field[1];
			if ($val && $field[0] != "" && idf_escape($field[0]) != $val[0]) {
				queries("ALTER TABLE " . table($table) . " RENAME COLUMN " . idf_escape($field[0]) . " TO $val[0]");
			}
			$orig_field = $orig_fields[$field[0]];
			if ($val && $orig_field) {
				$old = process_field($orig_field, $orig_field);
				if ($val[2] == $old[2]) {
					$val[2] = "";
				}
			}
			if ($val) {
				$alter[] = ($table != "" ? ($field[0] != "" ? "MODIFY (" : "ADD (") : "  ") . implode($val) . ($table != "" ? ")" : ""); //! error with name change only
			} else {
				$drop[] = idf_escape($field[0]);
			}
		}
		if ($table == "") {
			return queries("CREATE TABLE " . table($name) . " (\n" . implode(",\n", $alter) . "\n)");
		}
		return (!$alter || queries("ALTER TABLE " . table($table) . "\n" . implode("\n", $alter)))
			&& (!$drop || queries("ALTER TABLE " . table($table) . " DROP (" . implode(", ", $drop) . ")"))
			&& ($table == $name || queries("ALTER TABLE " . table($table) . " RENAME TO " . table($name)))
		;
	}

	function alter_indexes($table, $alter) {
		$drop = [];
		$queries = [];
		foreach ($alter as $val) {
			if ($val[0] != "INDEX") {
				//! descending UNIQUE indexes results in syntax error
				$val[2] = preg_replace('~ DESC$~', '', $val[2]);
				$create = ($val[2] == "DROP"
					? "\nDROP CONSTRAINT " . idf_escape($val[1])
					: "\nADD" . ($val[1] != "" ? " CONSTRAINT " . idf_escape($val[1]) : "") . " $val[0] " . ($val[0] == "PRIMARY" ? "KEY " : "") . "(" . implode(", ", $val[2]) . ")"
				);
				array_unshift($queries, "ALTER TABLE " . table($table) . $create);
			} elseif ($val[2] == "DROP") {
				$drop[] = idf_escape($val[1]);
			} else {
				$queries[] = "CREATE INDEX " . idf_escape($val[1] != "" ? $val[1] : uniqid($table . "_")) . " ON " . table($table) . " (" . implode(", ", $val[2]) . ")";
			}
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

	function foreign_keys($table) {
		$return = [];
		$query = "SELECT c_list.CONSTRAINT_NAME as NAME,
c_src.COLUMN_NAME as SRC_COLUMN,
c_dest.OWNER as DEST_DB,
c_dest.TABLE_NAME as DEST_TABLE,
c_dest.COLUMN_NAME as DEST_COLUMN,
c_list.DELETE_RULE as ON_DELETE
FROM ALL_CONSTRAINTS c_list, ALL_CONS_COLUMNS c_src, ALL_CONS_COLUMNS c_dest
WHERE c_list.CONSTRAINT_NAME = c_src.CONSTRAINT_NAME
AND c_list.R_CONSTRAINT_NAME = c_dest.CONSTRAINT_NAME
AND c_list.CONSTRAINT_TYPE = 'R'
AND c_src.TABLE_NAME = " . q($table);
		foreach (get_rows($query) as $row) {
			$return[$row['NAME']] = [
				"db" => $row['DEST_DB'],
				"table" => $row['DEST_TABLE'],
				"source" => [$row['SRC_COLUMN']],
				"target" => [$row['DEST_COLUMN']],
				"on_delete" => $row['ON_DELETE'],
				"on_update" => null,
			];
		}
		return $return;
	}

	function truncate_tables($tables) {
		return apply_queries("TRUNCATE TABLE", $tables);
	}

	function drop_views($views) {
		return apply_queries("DROP VIEW", $views);
	}

	function drop_tables($tables) {
		return apply_queries("DROP TABLE", $tables);
	}

	function last_id($result)
	{
		return 0; //!
	}

	function schemas(): array
	{
		$return = get_vals("SELECT DISTINCT owner FROM dba_segments WHERE owner IN (SELECT username FROM dba_users WHERE default_tablespace NOT IN ('SYSTEM','SYSAUX')) ORDER BY 1");

		return $return ?: get_vals("SELECT DISTINCT owner FROM all_tables WHERE tablespace_name = " . q(DB) . " ORDER BY 1");
	}

	function get_schema(): string
	{
		return Connection::get()->getValue("SELECT sys_context('USERENV', 'SESSION_USER') FROM dual");
	}

	function set_schema(string $schema, ?Connection $connection = null): bool
	{
		if (!$connection) {
			$connection = Connection::get();
		}

		return (bool)$connection->query("ALTER SESSION SET CURRENT_SCHEMA = " . idf_escape($schema));
	}

	function show_variables() {
		return get_key_vals('SELECT name, display_value FROM v$parameter');
	}

	function process_list() {
		return get_rows('SELECT sess.process AS "process", sess.username AS "user", sess.schemaname AS "schema", sess.status AS "status", sess.wait_class AS "wait_class", sess.seconds_in_wait AS "seconds_in_wait", sql.sql_text AS "sql_text", sess.machine AS "machine", sess.port AS "port"
FROM v$session sess LEFT OUTER JOIN v$sql sql
ON sql.sql_id = sess.sql_id
WHERE sess.type = \'USER\'
ORDER BY PROCESS
');
	}

	function show_status() {
		$rows = get_rows('SELECT * FROM v$instance');
		return reset($rows);
	}

	function convert_field($field) {
	}

	function unconvert_field(array $field, $return) {
		return $return;
	}

	function support($feature) {
		return preg_match('~^(columns|database|drop_col|indexes|descidx|processlist|scheme|sql|status|table|variables|view)$~', $feature); //!
	}
}
