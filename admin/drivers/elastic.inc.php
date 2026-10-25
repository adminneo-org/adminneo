<?php

namespace AdminNeo;

Drivers::add("elastic", "Elasticsearch", ["json + allow_url_fopen"]);

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

			/** @var array[] Results of cachedQuery(). */
			private $cache = [];

			public function getDefaultServerName(): string
			{
				return "localhost:9200";
			}

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
					'ssl' => $this->getSslOptions(),
				];

				[$file, $headers, $error] = get_url("$this->serviceUrl/" . ltrim($path, '/'), stream_context_create($options));

				if ($file === false) {
					// The error is created by PHP, the response of the server is never printed.
					$this->error = $error ?: lang('Invalid server or credentials.');
					return false;
				}

				$isElastic = false;
				foreach ($headers as $header) {
					// X-elastic-product is available from Elasticsearch 7.10.
					if (!strcasecmp($header, "X-elastic-product: Elasticsearch")) {
						$isElastic = true;
						break;
					}
				}
				if (!$isElastic) {
					$this->error = lang('Invalid server or credentials.');
					return false;
				}

				$return = json_decode($file, true);
				if ($return === null) {
					$this->error = lang('Invalid server or credentials.');
					return false;
				}

				if (!preg_match('~^HTTP/[0-9.]+ 2~i', $headers[0] ?? '')) {
					if (isset($return['error']['root_cause'][0]['type'])) {
						$this->error = $return['error']['root_cause'][0]['type'] . ": " . $return['error']['root_cause'][0]['reason'];
					} elseif (isset($return['status']) && isset($return['error']) && is_string($return['error'])) {
						$this->error = $return['error'];
					}

					return false;
				}

				return $return;
			}

			/**
			 * Performs a GET request and caches its result.
			 *
			 * @return array|false
			 */
			public function cachedQuery(string $path)
			{
				// The indexes can be altered only by a request which redirects afterward.
				if (!array_key_exists($path, $this->cache)) {
					$this->cache[$path] = $this->rootQuery($path);
				}

				return $this->cache[$path];
			}

			/**
			 * Returns SSL options for the stream context.
			 */
			private function getSslOptions(): array
			{
				$config = Admin::get()->getConfig();
				$options = [];

				if ($config->getSslCaCertificate()) {
					$options["cafile"] = $config->getSslCaCertificate();
				}
				if ($config->getSslCertificate()) {
					$options["local_cert"] = $config->getSslCertificate();
				}
				if ($config->getSslKey()) {
					$options["local_pk"] = $config->getSslKey();
				}
				if ($config->getSslTrustServerCertificate()) {
					$options["verify_peer"] = false;
					$options["verify_peer_name"] = false;
				}

				return $options;
			}

			/**
			 * @return Result|bool
			 */
			public function query(string $query, bool $unbuffered = false)
			{
				// Global search through all tables, built by search_tables().
				if (preg_match('~^SELECT 1 FROM (\S+) WHERE (.+) LIMIT (\d+)$~s', $query, $matches)) {
					return Driver::get()->select($matches[1], ["*"], explode(" AND ", $matches[2]), [], [], (int)$matches[3]);
				}

				// Number of rows in select, built by count_rows().
				if (preg_match('~^SELECT COUNT\(\*\) FROM (\S+)( WHERE (.+))?$~s', $query, $matches)) {
					$count = Driver::get()->countRows($matches[1], isset($matches[3]) ? explode(" AND ", $matches[3]) : []);

					return $count === false ? false : new ElasticResult([[$count]]);
				}

				return false;
			}

			public function open(string $server, string $username, string $password): bool
			{
				$this->serviceUrl = build_http_url($server, $username, $password, "localhost", 9200);
				if (!$this->serviceUrl) {
					$this->error = lang('Invalid server or credentials.');
					return false;
				}

				$return = $this->rootQuery('');
				if (!$return) {
					return false;
				}

				if (!isset($return['version']['number'])) {
					$this->error = lang('Invalid server or credentials.');
					return false;
				}

				$version = $return['version']['number'];
				if (version_compare($version, '7') < 0) {
					$this->error = lang('%s requires at least %s.', "AdminNeo", "Elasticsearch 7");
					return false;
				}

				$this->version = $version;
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
					"text" => 65535, "keyword" => 65535,
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

			$this->insertFunctions = ["json"];
		}

		public function select(string $table, array $select, array $where, array $group, array $order = [], int $limit = 1, int $page = 0, bool $print = false)
		{
			$fields = fields($table);

			$data = [];
			if ($select != ["*"]) {
				$data["_source"] = array_values($select);
			}

			if ($order) {
				$sort = [];
				foreach ($order as $col) {
					$col = preg_replace('~ DESC$~', '', $col, 1, $count);
					$col = ($fields[$col]["sort"] ?? "") ?: $col; // Text fields are sortable only by their keyword sub-field.
					$sort[] = ($count ? [$col => "desc"] : $col);
				}
				$data["sort"] = $sort;
			}

			if ($limit) {
				$data["size"] = $limit;
				if ($page) {
					$data["from"] = ($page * $limit);
				}
			}

			$query = $this->buildQuery($where);
			if ($query) {
				$data["query"] = $query;
			}

			$path = urlencode($table) . "/_search";
			$start = microtime(true);
			$search = $this->connection->rootQuery($path, $data ?: null);

			if ($print) {
				echo $this->admin->formatSelectQuery("\"GET $path\": " . json_encode($data), $start, !$search);
			}
			if (empty($search)) {
				return false;
			}

			$columns = $select == ["*"] ? array_keys($fields) : $select;

			$return = [];
			foreach ($search["hits"]["hits"] as $hit) {
				$row = [];
				foreach ($columns as $key) {
					$val = $key == "_id" ? $hit["_id"] : elastic_value($hit["_source"], $key);
					$row[$key] = is_bool($val) ? ($val ? "true" : "false") : (is_array($val) ? json_encode($val) : $val);
				}

				$return[] = $row;
			}

			return new ElasticResult($return);
		}

		/**
		 * Returns number of rows matching the conditions.
		 *
		 * @param string[] $where
		 * @return int|false
		 */
		public function countRows(string $table, array $where)
		{
			$query = $this->buildQuery($where);
			$return = $this->connection->rootQuery(urlencode($table) . "/_count", $query ? ["query" => $query] : null);

			return $return === false ? false : $return["count"];
		}

		/**
		 * Builds the search query from the conditions.
		 *
		 * @param string[] $where
		 */
		private function buildQuery(array $where): array
		{
			$query = [];

			foreach ($where as $val) {
				if ($val == "1 = 0") { // No field can match the searched value.
					$query["bool"]["must_not"][] = ["match_all" => new \stdClass()];
				} elseif (preg_match('~^\((.+ OR .+)\)$~', $val, $matches)) {
					$parts = explode(" OR ", $matches[1]);

					foreach ($parts as $part) {
						$this->addQueryCondition($part, $query);
					}
				} else {
					$this->addQueryCondition($val, $query);
				}
			}

			return $query;
		}

		private function addQueryCondition(string $val, array &$query): void
		{
			list($col, $op, $val) = explode(" ", $val, 3);

			if ($col == "_id" && $op == "=") {
				$query["bool"]["must"][] = [
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
				$query["bool"][$queryType][] = [
					"regexp" => [
						$col => [
							"value" => $val,
							"flags" => "ALL",
							"case_insensitive" => true,
						]
					]
				];
			} else {
				$query["bool"][$queryType][] = [
					$matchType => [$col => $val]
				];
			}
		}

		/**
		 * Converts the values to the types expected by Elasticsearch.
		 *
		 * @param string[] $record
		 */
		private function castRecord(string $table, array $record): array
		{
			$fields = fields($table);
			$return = [];

			foreach ($record as $key => $val) {
				$type = $fields[$key]["type"] ?? null;

				if ($val === "NULL") {
					$val = null;
				} elseif ($type == "boolean") {
					$val = ($val && $val !== "false"); // The checkbox sends 1 or 0.
				} elseif (preg_match('~^(long|integer|short|byte|double|float|half_float|scaled_float)$~', (string)$type) && is_numeric($val) && (string)($val + 0) === (string)$val) {
					$val += 0; // Store the number as a number, unless the conversion would lose precision.
				}

				// The columns of object fields are named by their path.
				$target = &$return;
				foreach (explode(".", $key) as $part) {
					$target = &$target[$part];
				}
				$target = $val;
				unset($target);
			}

			return $return;
		}

		public function update(string $table, array $record, string $queryWhere, int $limit = 0, string $separator = "\n")
		{
			// TODO use $limit
			$parts = preg_split('~ *= *~', $queryWhere);
			if (count($parts) != 2) {
				return false;
			}

			$id = trim($parts[1]);
			$query = urlencode($table) . "/_update/" . urlencode($id);
			// A partial update keeps the fields missing in the form, e.g. the nested ones.
			$content = ["doc" => $this->castRecord($table, $record)];

			// Save the query for later use in a flesh message. TODO: This is so ugly.
			queries("\"POST $query\": " . json_encode($content));

			$response = $this->connection->rootQuery($query, $content, 'POST');
			if ($response) {
				$this->connection->rootQuery(urlencode($table) . "/_refresh");
			}

			return $response;
		}

		public function insert(string $table, array $record)
		{
			$query = urlencode($table) . "/_doc/";

			if (isset($record["_id"]) && $record["_id"] != "NULL") {
				$query .= urlencode($record["_id"]);
			}
			unset($record["_id"]);

			foreach ($record as $key => $value) {
				if ($value == "NULL") {
					unset($record[$key]);
				}
			}
			$record = $this->castRecord($table, $record);

			// Save the query for later use in a flesh message. TODO: This is so ugly.
			queries("\"POST $query\": " . json_encode($record));

			$response = $this->connection->rootQuery($query, $record, 'POST');
			if (!$response) {
				return false;
			}

			$this->connection->rootQuery(urlencode($table) . "/_refresh");
			$this->connection->last_id = $response['_id'];

			return $response['result'];
		}

		public function delete(string $table, string $queryWhere, int $limit = 0)
		{
			// TODO use $limit
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
				$query = urlencode($table) . "/_doc/" . urlencode($id);

				// Save the query for later use in a flesh message. TODO: This is so ugly.
				queries("\"DELETE $query\"");

				$response = $this->connection->rootQuery($query, null, 'DELETE');
				if (isset($response['result']) && $response['result'] == 'deleted') {
					$affected_rows++;
				}
			}

			$this->connection->rootQuery(urlencode($table) . "/_refresh");

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

		[$server, $username, $password] = Admin::get()->getCredentials();

		if (!$connection->openPasswordless($server, $username, $password)) {
			$error = $connection->getError();
			return null;
		}

		return $connection;
	}

	function support(string $feature): bool
	{
		return preg_match('~^(table|columns)$~', $feature);
	}

	function logged_user(): string
	{
		$credentials = Admin::get()->getCredentials();

		return $credentials[1];
	}

	function get_databases(bool $flush): array
	{
		return [ELASTIC_DB_NAME];
	}

	function limit(string $query, string $where, int $limit, int $offset = 0, string $separator = " "): string
	{
		return " $query$where" . ($limit ? $separator . "LIMIT $limit" . ($offset ? " OFFSET $offset" : "") : "");
	}

	function collations(): array
	{
		return [];
	}

	function db_collation(string $db, array $collations): ?string
	{
		return null;
	}

	function count_tables(array $databases): array
	{
		$return = Connection::get()->cachedQuery('_aliases');
		if (empty($return)) {
			return [
				ELASTIC_DB_NAME => 0
			];
		}

		return [
			ELASTIC_DB_NAME => count($return)
		];
	}

	function tables_list(): array
	{
		$aliases = Connection::get()->cachedQuery('_aliases');
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

	function table_status(string $name = "", bool $fast = false): array
	{
		$stats = Connection::get()->cachedQuery('_stats');
		$aliases = Connection::get()->cachedQuery('_aliases');

		if (empty($stats) || empty($aliases)) {
			return [];
		}

		$result = [];

		if ($name != "") {
			if (isset($stats["indices"][$name])) {
				return [format_index_status($name, $stats["indices"][$name])];
			} else foreach ($aliases as $index_name => $index) {
				foreach ($index["aliases"] as $alias_name => $alias) {
					if ($alias_name == $name) {
						return [format_alias_status($alias_name, $stats["indices"][$index_name])];
					}
				}
			}

			return [];
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

	function format_index_status(string $name, array $index): array
	{
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

	function format_alias_status(string $name, array $index): array
	{
		return [
			"Name" => $name,
			"Engine" => "view",
			"Rows" => $index["total"]["docs"]["count"],
		];
	}

	function is_view(array $table_status): bool
	{
		return $table_status["Engine"] == "view";
	}

	function view(string $name): array
	{
		$return = Connection::get()->rootQuery("_alias/" . urlencode($name));

		return ["select" => implode("\n", array_keys($return))];
	}

	function error(): string
	{
		return h(Connection::get()->getError());
	}

	function information_schema(?string $db, string $schema = ""): bool
	{
		return false;
	}

	function indexes(string $table, ?Connection $connection = null): array
	{
		return [
			["type" => "PRIMARY", "columns" => ["_id"]],
		];
	}

	function fields(string $table): array
	{
		$result = [
			"_id" => [
				"field" => "_id",
				"full_type" => "_id",
				"type" => "_id",
				"null" => true,
				"sort" => "_id",
				"privileges" => ["insert" => 1, "select" => 1, "where" => 1, "order" => 1],
			]
		];

		// The response is keyed by the index name, an alias is resolved by the server.
		$mapping = Connection::get()->cachedQuery(urlencode($table) . "/_mapping");
		$index = $mapping ? first($mapping) : [];

		elastic_fields($index["mappings"]["properties"] ?? [], "", $result);

		return $result;
	}

	/**
	 * Adds fields of the mapping to the result, recurses into object and nested fields.
	 */
	function elastic_fields(array $properties, string $prefix, array &$result, bool $nested = false): void
	{
		foreach ($properties as $name => $field) {
			$name = "$prefix$name";
			$type = $field["type"] ?? "";

			if (isset($field["properties"])) {
				elastic_fields($field["properties"], "$name.", $result, $nested || $type == "nested");
				continue;
			}

			// Text fields are not sortable, their keyword sub-field is.
			$sort = $type != "text" ? $name : "";
			foreach ($field["fields"] ?? [] as $sub_name => $sub_field) {
				if ($sort == "" && ($sub_field["type"] ?? "") == "keyword") {
					$sort = "$name.$sub_name";
				}
			}

			$result[$name] = [
				"field" => $name,
				"full_type" => $type,
				"type" => $type,
				"null" => true,
				"sort" => $sort,
				"privileges" => [
					// A nested field holds a list of objects, so a single column can't be edited, searched or sorted.
					"insert" => !$nested ?: null,
					"select" => 1,
					"update" => !$nested ?: null,
					"where" => !$nested && (!isset($field["index"]) || $field["index"]) ?: null,
					"order" => !$nested && $sort != "" ?: null,
				],
			];
		}
	}

	/**
	 * Returns value of a field from the source of a document.
	 *
	 * @param mixed $source
	 * @param string $path Dot separated.
	 * @return mixed
	 */
	function elastic_value($source, string $path)
	{
		if ($path == "" || !is_array($source)) {
			return $source;
		}
		if (array_key_exists($path, $source)) { // The document can use the dotted name directly.
			return $source[$path];
		}
		if (array_key_exists(0, $source)) { // List of objects in a nested field.
			$return = [];
			foreach ($source as $item) {
				$return[] = elastic_value($item, $path);
			}

			return $return;
		}

		list($key, $rest) = explode(".", $path, 2) + [1 => ""];

		return array_key_exists($key, $source) ? elastic_value($source[$key], $rest) : null;
	}

	function foreign_keys(string $table): array
	{
		return [];
	}

	function backward_keys(string $table): array
	{
		return [];
	}

	function table(string $idf): string
	{
		return $idf;
	}

	function idf_escape(string $idf): string
	{
		return $idf;
	}

	function convert_field(array $field): ?string
	{
		return null;
	}

	function unconvert_field(array $field, string $return): string
	{
		return $return;
	}

	function fk_support(array $table_status): bool
	{
		return false;
	}

	function found_rows(array $table_status, array $where): ?int
	{
		return null;
	}

	function auto_increment(): string
	{
		return "";
	}

	function alter_table(string $table, string $name, array $fields, array $foreign, ?string $comment, string $engine, string $collation, string $auto_increment, ?array $partitioning): bool
	{
		$properties = [];

		foreach ($fields as $field) {
			if (!isset($field[1])) {
				continue; // The columns of the original mapping are sent without a name because they can be neither dropped nor altered.
			}

			$field_name = trim($field[1][0]);
			$field_type = trim($field[1][1] ?: "text");

			$properties[$field_name] = [
				"type" => $field_type,
			];
		}

		$mappings = $properties ? ["properties" => $properties] : new \stdClass();

		if ($table != "") {
			if ($name != $table) {
				Connection::get()->setError('Elasticsearch does not support renaming indexes.');
				return false;
			}
			if (!$properties) {
				return true;
			}

			$path = urlencode($name) . "/_mapping";

			// Save the query for later use in a flesh message. TODO: This is so ugly.
			queries("\"POST $path\": " . json_encode($mappings));

			return (bool)Connection::get()->rootQuery($path, $mappings, "POST");
		} else {
			$content = ["mappings" => $mappings];
			$path = urlencode($name);

			// Save the query for later use in a flesh message. TODO: This is so ugly.
			queries("\"PUT $path\": " . json_encode($content));

			return (bool)Connection::get()->rootQuery($path, $content, "PUT");
		}
	}

	function drop_views(array $tables): bool
	{
		$return = Connection::get()->rootQuery('_aliases', ['actions' => array_map(function ($table) {
			return ['remove' => ['index' => '*', 'alias' => $table]];
		}, $tables)], 'POST');

		return $return && !$return['errors'];
	}

	function drop_tables(array $tables): bool
	{
		$return = true;
		foreach ($tables as $table) { // TODO convert to bulk api
			$table = urlencode($table);

			// Save the query for later use in a flesh message. TODO: This is so ugly.
			queries("\"DELETE $table\"");

			$return = $return && Connection::get()->rootQuery($table, null, 'DELETE');
		}

		return $return;
	}

	function last_id($result)
	{
		return Connection::get()->last_id;
	}
}
