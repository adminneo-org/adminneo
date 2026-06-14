<?php

namespace AdminNeo;

Drivers::add("clickhouse", "ClickHouse (alpha)", ["allow_url_fopen"]);

if (isset($_GET["clickhouse"])) {
	define("AdminNeo\DRIVER", "clickhouse");
	define("AdminNeo\DIALECT", "clickhouse");

	if (ini_bool('allow_url_fopen')) {
		define("AdminNeo\DRIVER_EXTENSION", "JSON");

		class ClickHouseConnection extends Connection
		{
			/** @var string */
			private $serviceUrl;

			/** @var string */
			private $dbName = 'default';

			/**
			 * @return Result|bool
			 */
			function rootQuery(string $db, string $query)
			{
				$file = @file_get_contents("$this->serviceUrl/?database=$db", false, stream_context_create(['http' => [
					'method' => 'POST',
					'content' => $query,
					'header' => [
						'Content-Type: application/x-www-form-urlencoded',
						'X-ClickHouse-Format: JSONCompact',
					],
					'ignore_errors' => 1,
					'follow_location' => 0,
					'max_redirects' => 0,
				]]));

				if ($file === false) {
					$this->error = lang('Invalid server or credentials.');

					return false;
				}

				$isClickHouse = false;
				foreach ($http_response_header as $header) {
					if (preg_match('~^X-ClickHouse-Summary:~i', $header)) {
						$isClickHouse = true;
						break;
					}
				}
				if (!$isClickHouse) {
					$this->error = lang('Invalid server or credentials.');

					return false;
				}

				if (!preg_match('~^HTTP/[0-9.]+ 2~i', $http_response_header[0])) {
					$this->error = preg_replace('~\(version [^(]+\(.+$~', '', $file);

					return false;
				}

				if (!$this->isQuerySelectLike($query) && $file === '') {
					return true;
				}

				$return = json_decode($file, true);
				if ($return === null) {
					$this->error = lang('Invalid server or credentials.');

					return false;
				}

				if (!isset($return['rows']) || !isset($return['data']) || !isset($return['meta'])) {
					$this->error = lang('Invalid server or credentials.');

					return false;
				}

				return new ClickHouseResult($return['rows'], $return['data'], $return['meta']);
			}

			private function isQuerySelectLike($query): bool
			{
				return (bool)preg_match('~^\s*(select|show|with)~i', $query);
			}

			function query(string $query, bool $unbuffered = false)
			{
				return $this->rootQuery($this->dbName, $query);
			}

			public function open(string $server, string $username, string $password): bool
			{
				$this->serviceUrl = build_http_url($server, $username, $password, "localhost", 8123);
				if (!$this->serviceUrl) {
					$this->error = lang('Invalid server or credentials.');
					return false;
				}

				$result = $this->query("SELECT version()");
				if (!$result) {
					return false;
				}

				$this->version = $result->fetchRow()[0];

				return true;
			}

			public function selectDatabase(string $name): bool
			{
				$this->dbName = $name;

				return true;
			}

			public function getDbName(): string
			{
				return $this->dbName;
			}

			public function quote(string $string): string
			{
				return "'" . addcslashes($string, "\\'") . "'";
			}

			public function getValue(string $query, int $fieldIndex = 0)
			{
				$result = $this->query($query);

				return $result['data'];
			}
		}

		class ClickHouseResult extends Result
		{
			/** @var array */
			private $rows;

			/** @var array */
			private $columns;

			/** @var array */
			private $meta;

			/** @var int */
			private $offset = 0;

			public function __construct(int $rowsCount, array $data, array $meta)
			{
				parent::__construct($rowsCount);

				$this->rows = [];
				foreach ($data as $item) {
					$this->rows[] = array_map(function ($val) {
						return is_scalar($val) ? $val : json_encode($val, JSON_UNESCAPED_UNICODE);
					}, $item);
				}

				$this->meta = $meta;
				$this->columns = array_column($meta, 'name');

				reset($this->rows);
			}

			public function fetchAssoc()
			{
				$row = current($this->rows);
				next($this->rows);

				return $row !== false ? array_combine($this->columns, $row) : false;
			}

			public function fetchRow()
			{
				$row = current($this->rows);
				next($this->rows);

				return $row;
			}

			public function fetchField()
			{
				$column = $this->offset++;
				if ($column >= count($this->columns)) {
					return false;
				}

				$column = $this->meta[$column];

				return (object) [
					'name' => $column['name'],
					'type' => $column['type'], //! map to MySQL numbers
					'charsetnr' => 0,
				];
			}
		}
	}


	class ClickHouseDriver extends Driver
	{
		protected function __construct(Connection $connection, $admin)
		{
			parent::__construct($connection, $admin);

			//! arrays
			$this->types = [
				lang('Numbers') => [
					"Int8" => 3, "Int16" => 5, "Int32" => 10, "Int64" => 19,
					"UInt8" => 3, "UInt16" => 5, "UInt32" => 10, "UInt64" => 20,
					"Float32" => 7, "Float64" => 16,
					'Decimal' => 38, 'Decimal32' => 9, 'Decimal64' => 18, 'Decimal128' => 38,
				],
				lang('Date and time') => [
					"Date" => 13, "DateTime" => 20,
				],
				lang('Strings') => [
					"String" => 0,
				],
				lang('Binary') => [
					"FixedString" => 0,
				],
			];

			$this->operators = [
				"=", "<", ">", "<=", ">=", "!=",
				"~", "!~",
				"LIKE", "LIKE %%", "NOT LIKE",
				"IN", "NOT IN",
				"IS NULL", "IS NOT NULL",
				"SQL",
			];

			$this->grouping = [
				"sum", "min", "max", "avg",
				"count", "count distinct",
			];

			$this->systemDatabases = ["INFORMATION_SCHEMA", "information_schema", "system"];
		}

		public function delete(string $table, string $queryWhere, int $limit = 0)
        {
			if ($queryWhere === '') {
				$queryWhere = 'WHERE 1=1';
			}
			return queries("ALTER TABLE " . table($table) . " DELETE $queryWhere");
		}

		public function update(string $table, array $record, string $queryWhere, int $limit = 0, string $separator = "\n")
        {
			$values = [];
			foreach ($record as $key => $val) {
				$values[] = "$key = $val";
			}
			$query = $separator . implode(",$separator", $values);
			return queries("ALTER TABLE " . table($table) . " UPDATE $query$queryWhere");
		}

		public function engines(): array
		{
			return ['MergeTree'];
		}
	}



	function create_driver(Connection $connection): Driver
	{
		return ClickHouseDriver::create($connection, Admin::get());
	}

	function idf_escape($idf) {
		return "`" . str_replace("`", "``", $idf) . "`";
	}

	function table($idf) {
		return idf_escape($idf);
	}

	function explain(Connection $connection, string $query): bool
	{
		return false;
	}

	function found_rows(array $table_status, array $where): ?int
	{
		$rows = get_vals("SELECT COUNT(*) FROM " . idf_escape($table_status["Name"]) . ($where ? " WHERE " . implode(" AND ", $where) : ""));

		return $rows ? (int)$rows[0] : null;
	}

	function alter_table($table, $name, $fields, $foreign, $comment, $engine, $collation, $auto_increment, $partitioning): bool
	{
		$alter = $order = [];
		foreach ($fields as $field) {
			if ($field[1][2] === " NULL") {
				$field[1][1] = " Nullable(" . (ltrim($field[1][1])) . ")";
				$field[1][2] = '';
			} elseif ($field[1][2] === ' NOT NULL') {
				$field[1][2] = '';
			}

			if ($field[1][3]) {
				$field[1][3] = '';
			}

			$alter[] = ($field[1]
				? ($table != "" ? ($field[0] != "" ? "MODIFY COLUMN " : "ADD COLUMN ") : " ") . implode($field[1])
				: "DROP COLUMN " . idf_escape($field[0])
			);

			$order[] = $field[1][0];
		}

		$alter = array_merge($alter, $foreign);
		$status = ($engine ? " ENGINE " . $engine : "");
		if ($table == "") {
			return (bool)queries("CREATE TABLE " . table($name) . " (\n" . implode(",\n", $alter) . "\n)$status" . ' ORDER BY (' . implode(',', $order) . ')');
		}
		if ($table != $name) {
			$result = (bool)queries("RENAME TABLE " . table($table) . " TO " . table($name));
			if ($alter) {
				$table = $name;
			} else {
				return $result;
			}
		}
		if ($status) {
			$alter[] = ltrim($status);
		}
		return !$alter || queries("ALTER TABLE " . table($table) . "\n" . implode(",\n", $alter));
	}

	function truncate_tables($tables): bool
	{
		return apply_queries("TRUNCATE TABLE", $tables);
	}

	function drop_views($views): bool
	{
		return drop_tables($views);
	}

	function drop_tables($tables): bool
	{
		return apply_queries("DROP TABLE", $tables);
	}

	function is_server_host_valid(string $hostPath): bool
	{
		return strpos(rtrim($hostPath, '/'), '/') === false;
	}

	function connect(bool $primary = false, ?string &$error = null): ?Connection
	{
		$connection = $primary ? ClickHouseConnection::create() : ClickHouseConnection::createSecondary();

		$credentials = Admin::get()->getCredentials();

		if (!$connection->open($credentials[0], $credentials[1], $credentials[2])) {
			$error = $connection->getError();
			return null;
		}

		return $connection;
	}

	function get_databases(bool $flush): array
	{
		$result = get_rows('SHOW DATABASES');

		$databases = [];
		foreach ($result as $row) {
			$databases[] = $row['name'];
		}

		sort($databases);

		return $databases;
	}

	function limit($query, $where, int $limit, $offset = 0, $separator = " ") {
		return " $query$where" . ($limit ? $separator . "LIMIT " . ($offset ? "$offset, " : "") . $limit : "");
	}

	function limit1($table, $query, $where, $separator = "\n") {
		return limit($query, $where, 1, 0, $separator);
	}

	function db_collation($db, $collations) {
	}

	function logged_user() {
		$credentials = Admin::get()->getCredentials();

		return $credentials[1];
	}

	function tables_list() {
		$result = get_rows('SHOW TABLES');
		$return = [];
		foreach ($result as $row) {
			$return[$row['name']] = 'table';
		}
		ksort($return);
		return $return;
	}

	function count_tables($databases) {
		return [];
	}

	function table_status($name = "", $fast = false) {
		$return = [];
		$tables = get_rows("SELECT name, engine FROM system.tables WHERE database = " . q(Connection::get()->getDbName()) . ($name != "" ? " AND name = " . q($name) : ""));
		foreach ($tables as $table) {
			$return[$table['name']] = [
				'Name' => $table['name'],
				'Engine' => $table['engine'],
			];
		}
		return $return;
	}

	function is_view($table_status) {
		return false;
	}

	function fk_support($table_status) {
		return false;
	}

	function convert_field(array $field): ?string
	{
		return null;
	}

	function unconvert_field(array $field, string $return): string
	{
		if (in_array($field['type'], ["Int8", "Int16", "Int32", "Int64", "UInt8", "UInt16", "UInt32", "UInt64", "Float32", "Float64"])) {
			return "to$field[type]($return)";
		}

		return $return;
	}

	function fields($table) {
		$return = [];
		$result = get_rows("SELECT name, type, default_expression FROM system.columns WHERE " . idf_escape('table') . " = " . q($table));
		foreach ($result as $row) {
			$type = $row['type'];
			$nullable = str_contains($type, 'Nullable(');
			$type = preg_replace('~Nullable\(([^)]+)\)~', "$1", $type);

			$return[$row['name']] = [
				"field" => $row['name'],
				"full_type" => $type,
				"type" => $type,
				"default" => $row['default_expression'],
				"null" => $nullable,
				"auto_increment" => '0',
				"privileges" => ["insert" => 1, "select" => 1, "update" => 0, "where" => 1, "order" => 1],
			];
		}

		return $return;
	}

	function indexes(string $table, ?Connection $connection = null): array
	{
		return [];
	}

	function foreign_keys($table) {
		return [];
	}

	function backward_keys(string $table): array
	{
		return [];
	}

	function collations() {
		return [];
	}

	function information_schema(?string $db): bool
	{
		return false;
	}

	function error() {
		return h(Connection::get()->getError());
	}

	function types(): array
	{
		return [];
	}

	function auto_increment(): string
	{
		return "";
	}

	function last_id($result)
	{
		return 0; // ClickHouse doesn't have it
	}

	function support($feature) {
		return preg_match("~^(columns|sql|status|table|drop_col)$~", $feature);
	}
}
