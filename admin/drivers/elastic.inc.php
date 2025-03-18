<?php

namespace AdminNeo;

Drivers::add("elastic", "Elasticsearch 7 (beta)", ["json + allow_url_fopen"]);

if (isset($_GET["elastic"])) {
	define("AdminNeo\DRIVER", "elastic");
	define("AdminNeo\DIALECT", "elastic");

	if (ini_bool('allow_url_fopen')) {
		define("AdminNeo\ELASTIC_DB_NAME", "elastic");
		define("AdminNeo\DRIVER_EXTENSION", "JSON");

		class ElasticConnection extends Connection
		{
			/** @var string */
			private $serviceUrl;

			/**
			 * @return array|false
			 */
			public function rootQuery(string $path, ?array $content = null, string $method = 'GET')
			{
				$options = [
					'http' => [
						'method' => $method,
						'content' => $content !== null ? json_encode($content) : null,
						'header' => $content !== null ? 'Content-Type: application/json' : [],
						'ignore_errors' => 1,
						'follow_location' => 0,
						'max_redirects' => 0,
					],
				];

				$trust = Admin::get()->getConfig()->getSslTrustServerCertificate();
				if ($trust) {
					$options["ssl"] = ["verify_peer" => false];
				}

				$file = @file_get_contents("$this->serviceUrl/" . ltrim($path, '/'), false, stream_context_create($options));

				if ($file === false) {
					$this->error = lang('Invalid server or credentials.');
					return false;
				}

				$return = json_decode($file, true);
				if ($return === null) {
					$this->error = lang('Invalid server or credentials.');
					return false;
				}

				if (!preg_match('~^HTTP/[0-9.]+ 2~i', $http_response_header[0])) {
					if (isset($return['error']['root_cause'][0]['type'])) {
						$this->error = $return['error']['root_cause'][0]['type'] . ": " . $return['error']['root_cause'][0]['reason'];
					} elseif (isset($return['status']) && isset($return['error']) && is_string($return['error'])) {
						$this->error = $return['error'];
					}

					return false;
				}

				return $return;
			}

			public function query(string $query, bool $unbuffered = false): bool
			{
				return false;
			}

			/**
			 * Performs query relative to actual selected DB.
			 *
			 * @return array|false
			 */
			public function sendRequest(string $path, ?array $content = null, string $method = 'GET')
			{
				// Support for global search through all tables
				if ($path != "" && $path[0] == "S" && preg_match('/SELECT 1 FROM ([^ ]+) WHERE (.+) LIMIT ([0-9]+)/', $path, $matches)) {
					$where = explode(" AND ", $matches[2]);

					return Driver::get()->select($matches[1], ["*"], $where, [], [], $matches[3]);
				}

				return $this->rootQuery($path, $content, $method);
			}

			public function open(string $server, string $username, string $password): bool
			{
				$this->serviceUrl = build_http_url($server, $username, $password, "localhost", 9200);
				if (!$this->serviceUrl) {
					$this->error = lang('Invalid server or credentials.');
					return false;
				}

				$return = $this->sendRequest('');
				if (!$return) {
					return false;
				}

				if (!isset($return['version']['number'])) {
					$this->error = lang('Invalid server or credentials.');
					return false;
				}

				$this->version = $return['version']['number'];
				return true;
			}

			public function selectDatabase(string $name): bool
			{
				return true;
			}

			public function quote(string $string): string
			{
				return $string;
			}
		}

		class ElasticResult extends Result
		{
			/** @var array */
			private $rows;

			public function __construct(array $rows) {
				parent::__construct(count($rows));

				$this->rows = $rows;

				reset($this->rows);
			}

			public function fetchAssoc()
			{
				$return = current($this->rows);
				next($this->rows);

				return $return;
			}

			public function fetchRow()
			{
				$row = $this->fetchAssoc();

				return $row ? array_values($row) : false;
			}

			public function fetchField()
			{
				// TODO: Implement fetch_field() method.
				return false;
			}
		}
	}

	class ElasticDriver extends Driver
	{
		protected function __construct(Connection $connection, $admin)
		{
			parent::__construct($connection, $admin);

			$this->types = [
				lang('Numbers') => [
					"long" => 3, "integer" => 5, "short" => 8, "byte" => 10,
					"double" => 20, "float" => 66, "half_float" => 12, "scaled_float" => 21,
					"boolean" => 1,
				],
				lang('Date and time') => [
					"date" => 10,
				],
				lang('Strings') => [
					"string" => 65535, "text" => 65535, "keyword" => 65535,
				],
				lang('Binary') => [
					"binary" => 255,
				],
			];

			$this->operators = [
				"must(term)", "must(match)", "must(regexp)",
				"should(term)", "should(match)", "should(regexp)",
				"must_not(term)", "must_not(match)", "must_not(regexp)",
			];

			$this->likeOperator = "should(match)";
			$this->regexpOperator = "should(regexp)";

			$this->editFunctions = [["json"]];
		}

		public function select(string $table, array $select, array $where, array $group, array $order = [], ?int $limit = 1, int $page = 0, bool $print = false)
		{
			$data = [];
			if ($select != ["*"]) {
				$data["fields"] = array_values($select);
			}

			if ($order) {
				$sort = [];
				foreach ($order as $col) {
					$col = preg_replace('~ DESC$~', '', $col, 1, $count);
					$sort[] = ($count ? [$col => "desc"] : $col);
				}
				$data["sort"] = $sort;
			}

			if ($limit !== null) {
				$data["size"] = +$limit;
				if ($page) {
					$data["from"] = ($page * $limit);
				}
			}

			foreach ($where as $val) {
				if (preg_match('~^\((.+ OR .+)\)$~', $val, $matches)) {
					$parts = explode(" OR ", $matches[1]);

					foreach ($parts as $part) {
						$this->addQueryCondition($part, $data);
					}
				} else {
					$this->addQueryCondition($val, $data);
				}
			}

			$query = "$table/_search";
			$start = microtime(true);
			$search = $this->connection->rootQuery($query, $data);

			if ($print) {
				echo $this->admin->formatSelectQuery("\"GET $query\": " . json_encode($data), $start, !$search);
			}
			if (empty($search)) {
				return false;
			}
			if ($select == ["*"]) {
				$tableFields = array_keys(fields($table));
			}

			$return = [];
			foreach ($search["hits"]["hits"] as $hit) {
				$row = [];
				if ($select == ["*"]) {
					$row["_id"] = $hit["_id"];
				}

				if ($select != ["*"]) {
					$fields = [];
					foreach ($select as $key) {
						$fields[$key] = $key == "_id" ? $hit["_id"] : $hit["_source"][$key];
					}
				} else {
					foreach ($tableFields as $key) {
						$fields[$key] = $key == "_id" ? $hit["_id"] : $hit["_source"][$key];
					}
				}
				foreach ($fields as $key => $val) {
					$row[$key] = (is_array($val) ? json_encode($val) : $val);
				}

				$return[] = $row;
			}

			return new ElasticResult($return);
		}

		private function addQueryCondition($val, &$data)
		{
			list($col, $op, $val) = explode(" ", $val, 3);

			if ($col == "_id" && $op == "=") {
				$data["query"]["bool"]["must"][] = [
					"term" => [$col => $val]
				];
				return;
			}

			if (!preg_match('~^([^(]+)\(([^)]+)\)$~', $op, $matches)) {
				return;
			}
			$queryType = $matches[1]; // must, should, must_not
			$matchType = $matches[2]; // term, match, regexp

			if ($matchType == "regexp") {
				$data["query"]["bool"][$queryType][] = [
					"regexp" => [
						$col => [
							"value" => $val,
							"flags" => "ALL",
							"case_insensitive" => true,
						]
					]
				];
			} else {
				$data["query"]["bool"][$queryType][] = [
					$matchType => [$col => $val]
				];
			}
		}

		public function update(string $table, array $record, string $queryWhere, int $limit = 0, string $separator = "\n")
		{
			//! use $limit
			$parts = preg_split('~ *= *~', $queryWhere);
			if (count($parts) != 2) {
				return false;
			}

			$id = trim($parts[1]);
			$query = "$table/_doc/$id";

			// Save the query for later use in a flesh message. TODO: This is so ugly.
			queries("\"POST $query\": " . json_encode($record));

			$response = $this->connection->sendRequest($query, $record, 'POST');
			if ($response) {
				$this->connection->sendRequest("$table/_refresh");
			}

			return $response;
		}

		public function insert(string $table, array $record)
		{
			$query = "$table/_doc/";

			if (isset($record["_id"]) && $record["_id"] != "NULL") {
				$query .= $record["_id"];
				unset($record["_id"]);
			}

			foreach ($record as $key => $value) {
				if ($value == "NULL") {
					unset($record[$key]);
				}
			}

			// Save the query for later use in a flesh message. TODO: This is so ugly.
			queries("\"POST $query\": " .json_encode($record));

			$response = $this->connection->sendRequest($query, $record, 'POST');
			if (!$response) {
				return false;
			}

			$this->connection->sendRequest("$table/_refresh");
			$this->connection->last_id = $response['_id'];

			return $response['result'];
		}

		public function delete(string $table, string $queryWhere, int $limit = 0)
		{
			//! use $limit
			$ids = [];
			if ($_GET["where"]["_id"] ?? null) {
				$ids[] = $_GET["where"]["_id"];
			}
			if (isset($_POST['check'])) {
				foreach ($_POST['check'] as $check) {
					$parts = preg_split('~ *= *~', $check);
					if (count($parts) == 2) {
						$ids[] = trim($parts[1]);
					}
				}
			}

			$affected_rows = 0;

			foreach ($ids as $id) {
				$query = "$table/_doc/$id";

				// Save the query for later use in a flesh message. TODO: This is so ugly.
				queries("\"DELETE $query\"");

				$response = $this->connection->sendRequest($query, null, 'DELETE');
				if (isset($response['result']) && $response['result'] == 'deleted') {
					$affected_rows++;
				}
			}

			$this->connection->sendRequest("$table/_refresh");

			$this->connection->setAffectedRows($affected_rows);

			return $affected_rows;
		}
	}



	function create_driver(Connection $connection): Driver
	{
		return ElasticDriver::create($connection, Admin::get());
	}

	function connect(bool $primary = false, ?string &$error = null): ?Connection
	{
		$connection = $primary ? ElasticConnection::create() : ElasticConnection::createSecondary();

		list($server, $username, $password) = Admin::get()->getCredentials();

		if ($password != "" && $connection->open($server, $username, "")) {
			$result = Admin::get()->verifyDefaultPassword($password);
			if ($result !== true) {
				$error = $result;
				return null;
			}

			return $connection;
		}

		if (!$connection->open($server, $username, $password)) {
			$error = $connection->getError();
			return null;
		}

		return $connection;
	}

	function support($feature) {
		return preg_match("~table|columns~", $feature);
	}

	function logged_user() {
		$credentials = Admin::get()->getCredentials();

		return $credentials[1];
	}

	function get_databases() {
		return [ELASTIC_DB_NAME];
	}

	function limit($query, $where, ?int $limit, $offset = 0, $separator = " ") {
		return " $query$where" . ($limit !== null ? $separator . "LIMIT $limit" . ($offset ? " OFFSET $offset" : "") : "");
	}

	function collations() {
		return [];
	}

	function db_collation($db, $collations) {
		//
	}

	function count_tables($databases) {
		$return = Connection::get()->rootQuery('_aliases');
		if (empty($return)) {
			return [
				ELASTIC_DB_NAME => 0
			];
		}

		return [
			ELASTIC_DB_NAME => count($return)
		];
	}

	function tables_list() {
		$aliases = Connection::get()->rootQuery('_aliases');
		if (empty($aliases)) {
			return [];
		}

		ksort($aliases);

		$tables = [];
		foreach ($aliases as $name => $index) {
			if ($name[0] == ".") {
				continue;
			}

			$tables[$name] = "table";

			ksort($index["aliases"]);
			$tables += array_fill_keys(array_keys($index["aliases"]), "view");
		}

		return $tables;
	}

	function table_status($name = "", $fast = false) {
		$stats = Connection::get()->rootQuery('_stats');
		$aliases = Connection::get()->rootQuery('_aliases');

		if (empty($stats) || empty($aliases)) {
			return [];
		}

		$result = [];

		if ($name != "") {
			if (isset($stats["indices"][$name])) {
				return format_index_status($name, $stats["indices"][$name]);
			} else foreach ($aliases as $index_name => $index) {
				foreach ($index["aliases"] as $alias_name => $alias) {
					if ($alias_name == $name) {
						return format_alias_status($alias_name, $stats["indices"][$index_name]);
					}
				}
			}
		}

		ksort($stats["indices"]);
		foreach ($stats["indices"] as $name => $index) {
			if ($name[0] == ".") {
				continue;
			}

			$result[$name] = format_index_status($name, $index);

			if (!empty($aliases[$name]["aliases"])) {
				ksort($aliases[$name]["aliases"]);
				foreach ($aliases[$name]["aliases"] as $alias_name => $alias) {
					$result[$alias_name] = format_alias_status($alias_name, $stats["indices"][$name]);
				}
			}
		}

		return $result;
	}

	function format_index_status($name, $index) {
		return [
			"Name" => $name,
			"Engine" => "Lucene",
			"Oid" => $index["uuid"],
			"Rows" => $index["total"]["docs"]["count"],
			"Auto_increment" => 0,
			"Data_length" => $index["total"]["store"]["size_in_bytes"],
			"Index_length" => 0,
			"Data_free" => $index["total"]["store"]["reserved_in_bytes"],
		];
	}

	function format_alias_status($name, $index) {
		return [
			"Name" => $name,
			"Engine" => "view",
			"Rows" => $index["total"]["docs"]["count"],
		];
	}

	function is_view($table_status) {
		return $table_status["Engine"] == "view";
	}

	function error() {
		return h(Connection::get()->getError());
	}

	function information_schema() {
		//
	}

	function indexes(string $table, ?Connection $connection = null): array
	{
		return [
			["type" => "PRIMARY", "columns" => ["_id"]],
		];
	}

	function fields($table) {
		$mapping = Connection::get()->rootQuery("_mapping");

		if (!isset($mapping[$table])) {
			$aliases = Connection::get()->rootQuery('_aliases');

			foreach ($aliases as $index_name => $index) {
				foreach ($index["aliases"] as $alias_name => $alias) {
					if ($alias_name == $table) {
						$table = $index_name;
						break;
					}
				}
			}
		}

		$mappings = $mapping[$table]["mappings"]["properties"] ?? [];

		$result = [
			"_id" => [
				"field" => "_id",
				"full_type" => "_id",
				"type" => "_id",
				"null" => true,
				"privileges" => ["insert" => 1, "select" => 1, "where" => 1, "order" => 1],
			]
		];

		foreach ($mappings as $name => $field) {
			$result[$name] = [
				"field" => $name,
				"full_type" => $field["type"],
				"type" => $field["type"],
				"null" => true,
				"privileges" => [
					"insert" => 1,
					"select" => 1,
					"update" => 1,
					"where" => !isset($field["index"]) || $field["index"] ?: null,
					"order" => $field["type"] != "text" ?: null
				],
			];
		}

		return $result;
	}

	function foreign_keys($table) {
		return [];
	}

	function table($idf) {
		return $idf;
	}

	function idf_escape($idf) {
		return $idf;
	}

	function convert_field($field) {
		//
	}

	function unconvert_field(array $field, $return) {
		return $return;
	}

	function fk_support($table_status) {
		//
	}

	function found_rows($table_status, $where) {
		return null;
	}

	/** Alter type
	 * @param array
	 * @return mixed
	 */
	function alter_table($table, $name, $fields, $foreign, $comment, $engine, $collation, $auto_increment, $partitioning) {
		$properties = [];

		foreach ($fields as $field) {
			if (!isset($field[1])) {
				continue;
			}

			$field_name = trim($field[1][0]);
			$field_type = trim($field[1][1] ?: "text");

			$properties[$field_name] = [
				"type" => $field_type,
			];
		}

		$mappings = $properties ? ["properties" => $properties] : new \stdClass();

		if ($table != "") {
			// Save the query for later use in a flesh message. TODO: This is so ugly.
			queries("\"POST $name/_mapping\": " . json_encode($mappings));

			return Connection::get()->rootQuery("$name/_mapping", $mappings, "POST");
		} else {
			$content = ["mappings" => $mappings];

			// Save the query for later use in a flesh message. TODO: This is so ugly.
			queries("\"PUT $name\": " . json_encode($content));

			return Connection::get()->rootQuery($name, $content, "PUT");
		}
	}

	/** Drop types
	 * @param array
	 * @return bool
	 */
	function drop_tables($tables) {
		$return = true;
		foreach ($tables as $table) { //! convert to bulk api
			$table = urlencode($table);

			// Save the query for later use in a flesh message. TODO: This is so ugly.
			queries("\"DELETE $table\"");

			$return = $return && Connection::get()->sendRequest($table, null, 'DELETE');
		}

		return $return;
	}

	function last_id($result)
	{
		return Connection::get()->last_id;
	}
}
