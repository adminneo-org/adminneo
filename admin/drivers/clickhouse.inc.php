<?php

namespace AdminNeo;

Drivers::add("clickhouse", "ClickHouse (alpha)");

if (isset($_GET["clickhouse"])) {
	define("AdminNeo\DRIVER", "clickhouse");
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
				'content' => $this->isQuerySelectLike($query) ? "$query FORMAT JSONCompact" : $query,
				'header' => 'Content-type: application/x-www-form-urlencoded',
				'ignore_errors' => 1,
				'follow_location' => 0,
				'max_redirects' => 0,
			]]));

			if ($file === false) {
				$this->error = lang('Invalid server or credentials.');
				return false;
			}

			if (!preg_match('~^HTTP/[0-9.]+ 2~i', $http_response_header[0])) {
				foreach ($http_response_header as $header) {
					if (preg_match('~^X-ClickHouse-Exception-Code:~i', $header)) {
						$this->error = preg_replace('~\(version [^(]+\(.+$~', '', $file);
						return false;
					}
				}

				$this->error = lang('Invalid server or credentials.');
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

			return new Result($return['rows'], $return['data'], $return['meta']);
		}

		private function isQuerySelectLike($query): bool
		{
			return (bool) preg_match('~^(select|show)~i', $query);
		}

		function query(string $query, bool $unbuffered = false)
		{
			return $this->rootQuery($this->dbName, $query);
		}

		public function open(string $server, string $username, string $password): bool
		{
			$this->serviceUrl = build_http_url($server, $username, $password, "localhost", 8123);

			$return = $this->query('SELECT 1');
			return (bool) $return;
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

		public function getResult(string $query, int $field = 0)
		{
			$result = $this->query($query);

			return $result['data'];
		}
	}

	class Result {
		var $num_rows, $_rows, $columns, $meta, $_offset = 0;

		/**
		 * @param int $rows
		 * @param array[] $data
		 * @param array[] $meta
		 */
		function __construct($rows, array $data, array $meta) {
			$this->_rows = [];
			foreach ($data as $item) {
				$this->_rows[] = array_map(function ($val) {
					return is_scalar($val) ? $val : json_encode($val, JSON_UNESCAPED_UNICODE);
				}, $item);
			}

			$this->num_rows = $rows;
			$this->meta = $meta;
			$this->columns = array_column($meta, 'name');

			reset($this->_rows);
		}

		function fetch_assoc() {
			$row = current($this->_rows);
			next($this->_rows);
			return $row === false ? false : array_combine($this->columns, $row);
		}

		function fetch_row() {
			$row = current($this->_rows);
			next($this->_rows);
			return $row;
		}

		function fetch_field() {
			$column = $this->_offset++;
			$return = new \stdClass;
			if ($column < count($this->columns)) {
				$return->name = $this->meta[$column]['name'];
				$return->orgname = $return->name;
				$return->type = $this->meta[$column]['type'];
			}
			return $return;
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

			$this->likeOperator = "LIKE %%";

			$this->grouping = [
				"sum", "min", "max", "avg",
				"count", "count distinct",
			];
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

	function found_rows($table_status, $where) {
		$rows = get_vals("SELECT COUNT(*) FROM " . idf_escape($table_status["Name"]) . ($where ? " WHERE " . implode(" AND ", $where) : ""));
		return empty($rows) ? false : $rows[0];
	}

	function alter_table($table, $name, $fields, $foreign, $comment, $engine, $collation, $auto_increment, $partitioning) {
		$alter = $order = [];
		foreach ($fields as $field) {
			if ($field[1][2] === " NULL") {
				$field[1][1] = " Nullable({$field[1][1]})";
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
			return queries("CREATE TABLE " . table($name) . " (\n" . implode(",\n", $alter) . "\n)$status$partitioning" . ' ORDER BY (' . implode(',', $order) . ')');
		}
		if ($table != $name) {
			$result = queries("RENAME TABLE " . table($table) . " TO " . table($name));
			if ($alter) {
				$table = $name;
			} else {
				return $result;
			}
		}
		if ($status) {
			$alter[] = ltrim($status);
		}
		return ($alter || $partitioning ? queries("ALTER TABLE " . table($table) . "\n" . implode(",\n", $alter) . $partitioning) : true);
	}

	function truncate_tables($tables) {
		return apply_queries("TRUNCATE TABLE", $tables);
	}

	function drop_views($views) {
		return drop_tables($views);
	}

	function drop_tables($tables) {
		return apply_queries("DROP TABLE", $tables);
	}

	/**
	 * @param string $hostPath
	 * @return bool
	 */
	function is_server_host_valid($hostPath)
	{
		return strpos(rtrim($hostPath, '/'), '/') === false;
	}

	/**
	 * @return Connection|string
	 */
	function connect(bool $primary = false)
	{
		$connection = $primary ? ClickHouseConnection::create() : ClickHouseConnection::createSecondary();

		$credentials = Admin::get()->getCredentials();
		if (!$connection->open($credentials[0], $credentials[1], $credentials[2])) {
			return $connection->getError();
		}

		return $connection;
	}

	function get_databases($flush) {
		$result = get_rows('SHOW DATABASES');

		$return = [];
		foreach ($result as $row) {
			$return[] = $row['name'];
		}
		sort($return);
		return $return;
	}

	function limit($query, $where, ?int $limit, $offset = 0, $separator = " ") {
		return " $query$where" . ($limit !== null ? $separator . "LIMIT $limit" . ($offset ? ", $offset" : "") : "");
	}

	function limit1($table, $query, $where, $separator = "\n") {
		return limit($query, $where, 1, 0, $separator);
	}

	function db_collation($db, $collations) {
	}

	function engines() {
		return ['MergeTree'];
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
		$tables = get_rows("SELECT name, engine FROM system.tables WHERE database = " . q(Connection::get()->getDbName()));
		foreach ($tables as $table) {
			$return[$table['name']] = [
				'Name' => $table['name'],
				'Engine' => $table['engine'],
			];
			if ($name === $table['name']) {
				return $return[$table['name']];
			}
		}
		return $return;
	}

	function is_view($table_status) {
		return false;
	}

	function fk_support($table_status) {
		return false;
	}

	function convert_field($field) {
	}

	function unconvert_field(array $field, $return) {
		if (in_array($field['type'], ["Int8", "Int16", "Int32", "Int64", "UInt8", "UInt16", "UInt32", "UInt64", "Float32", "Float64"])) {
			return "to$field[type]($return)";
		}
		return $return;
	}

	function fields($table) {
		$return = [];
		$result = get_rows("SELECT name, type, default_expression FROM system.columns WHERE " . idf_escape('table') . " = " . q($table));
		foreach ($result as $row) {
			$type = trim($row['type']);
			$nullable = strpos($type, 'Nullable(') === 0;
			$return[trim($row['name'])] = [
				"field" => trim($row['name']),
				"full_type" => $type,
				"type" => $type,
				"default" => trim($row['default_expression']),
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

	function collations() {
		return [];
	}

	function information_schema($db) {
		return false;
	}

	function error() {
		return h(Connection::get()->getError());
	}

	function types() {
		return [];
	}

	function auto_increment() {
		return '';
	}

	function last_id() {
		return 0; // ClickHouse doesn't have it
	}

	function support($feature) {
		return preg_match("~^(columns|sql|status|table|drop_col)$~", $feature);
	}

	function driver_config() {
		return [
			'jush' => "clickhouse",
			'unsigned' => [],
			"system_databases" => ["INFORMATION_SCHEMA", "information_schema", "system"],
		];
	}
}
