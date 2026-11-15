<?php

namespace AdminNeo;

use DateTime;
use Exception;
use MongoDB\BSON;
use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Command;
use MongoDB\Driver\Cursor;
use MongoDB\Driver\Manager;
use MongoDB\Driver\Query;

Drivers::add("mongo", "MongoDB (alpha)", ["mongodb"]);

// Only one driver can be active.
if (isset($_GET["mongo"]) && !defined("AdminNeo\DRIVER")) {
	define("AdminNeo\DRIVER", "mongo");
	define("AdminNeo\DIALECT", "mongo");

	if (class_exists('MongoDB\Driver\Manager')) {
		define("AdminNeo\DRIVER_EXTENSION", "MongoDB");

		class MongoConnection extends Connection
		{
			/** @var Manager */
			private $manager;

			/** @var string */
			private $dbName;

			public function getDefaultServerName(): string
			{
				return "localhost:27017";
			}

			public function open(string $server, string $username, string $password, string $dbName = "", string $authSource = ""): bool
			{
				$this->version = MONGODB_VERSION;

				$options = [];
				if ($username . $password != "") {
					$options["username"] = $username;
					$options["password"] = $password;
				}

				if ($dbName != "") {
					$options["db"] = $dbName;
				}

				if ($authSource != "") {
					$options["authSource"] = $authSource;
				}

				try {
					$this->manager = new Manager($server, $options);
				} catch (\MongoDB\Driver\Exception\Exception $exception) {
					$this->error = $exception->getMessage();

					return false;
				}

				$this->dbName = $dbName ?: "default";

				return (bool)$this->executeCommand(['ping' => 1]);
			}

			public function executeCommand(array $command, bool $adminDb = false): ?Cursor
			{
				try {
					return $this->manager->executeCommand($adminDb ? "admin" : $this->dbName, new Command($command));
				} catch (\MongoDB\Driver\Exception\Exception $exception) {
					$this->error = $exception->getMessage();

					return null;
				}
			}

			public function executeQuery(string $namespace, Query $query, ?array $options = null): ?Cursor
			{
				try {
					return $this->manager->executeQuery($namespace, $query, $options);
				} catch (\MongoDB\Driver\Exception\Exception $exception) {
					$this->error = $exception->getMessage();

					return null;
				}
			}

			public function executeBulkWrite(string $namespace, BulkWrite $bulk, string $counter): bool
			{
				try {
					$results = $this->manager->executeBulkWrite($namespace, $bulk);
					$this->affectedRows = $results->$counter();

					return true;
				} catch (Exception $exception) {
					$this->error = $exception->getMessage();

					return false;
				}
			}

			public function query(string $query, bool $unbuffered = false): bool
			{
				return false;
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
				// There is no query language to quote the value for. It is quoted so that it can be told apart from the syntax of a condition.
				return "'" . str_replace("'", "''", $string) . "'";
			}
		}

		class MongoResult extends Result
		{
			/** @var array */
			private $rows;

			/** @var array */
			private $charset;

			/** @var int */
			private $offset = 0;

			/**
			 * @param Cursor|array $result
			 */
			public function __construct($result)
			{
				$this->rows = $this->charset = [];

				foreach ($result as $item) {
					$row = [];
					foreach ($item as $key => $val) {
						if (is_a($val, 'MongoDB\BSON\Binary')) {
							$this->charset[$key] = 63;
						}
						// A string in _id that looks like the printed ObjectID is marked by a backslash, otherwise it would identify another document.
						$row[$key] =
							(is_a($val, 'MongoDB\BSON\ObjectID') ? 'MongoDB\BSON\ObjectID("' . "$val\")" :
							($key === "_id" && is_string($val) && preg_match(MongoDriver::ObjectIdPattern, $val) ? "\\$val" :
							(is_a($val, 'MongoDB\BSON\UTCDatetime') ? $val->toDateTime()->format('Y-m-d H:i:s') :
							(is_a($val, 'MongoDB\BSON\Binary') ? $val->getData() : // TODO allow downloading
							(is_a($val, 'MongoDB\BSON\Regex') ? "$val" :
							(is_object($val) || is_array($val) ? json_encode($val, JSON_UNESCAPED_UNICODE) :
							$val // MongoMinKey, MongoMaxKey
						))))));
					}

					$this->rows[] = $row;

					foreach ($row as $key => $val) {
						if (!isset($this->rows[0][$key])) {
							$this->rows[0][$key] = null;
						}
					}
				}

				parent::__construct(count($this->rows));
			}

			public function fetchAssoc()
			{
				$row = current($this->rows);
				if (!$row) {
					return $row;
				}

				$data = [];
				foreach ($this->rows[0] as $key => $val) {
					$data[$key] = $row[$key];
				}

				next($this->rows);

				return $data;
			}

			public function fetchRow()
			{
				$data = $this->fetchAssoc();
				if (!$data) {
					return $data;
				}

				return array_values($data);
			}

			public function fetchField()
			{
				$keys = array_keys($this->rows[0]);
				$name = $keys[$this->offset++];

				return (object) [
					'name' => $name,
					'type' => 15,
					'charsetnr' => $this->charset[$name],
				];
			}

		}
	}



	class MongoDriver extends Driver
	{
		public const NULL = "\0";

		/** ObjectID as it is printed by MongoResult. The leading backslashes mark a string that only looks like it. */
		public const ObjectIdPattern = '~^(\\\\*)MongoDB\\\\BSON\\\\ObjectID\("([\da-f]{24})"\)$~i';

		public $primary = "_id";

		protected function __construct(Connection $connection, $admin)
		{
			parent::__construct($connection, $admin);

			$this->operators = [
				"=", "!=",
				">", "<", ">=", "<=",
				"regex",
				"(f)=", "(f)!=",
				"(f)>", "(f)<", "(f)>=", "(f)<=",
				"(date)=", "(date)!=",
				"(date)>", "(date)<", "(date)>=", "(date)<=",
			];

			$this->likeOperator = "=";

			$this->insertFunctions = ["json"];

			$this->systemDatabases = ["admin", "config", "local"];
		}

		public function select(string $table, array $select, array $where, array $group, array $order = [], int $limit = 1, int $page = 0, bool $print = false)
		{
			$filter = where_to_query($where);
			if ($filter === null) {
				return false;
			}

			$select = ($select == ["*"]
				? []
				: array_fill_keys(array_map('AdminNeo\idf_unescape', $select), 1)
			);
			if (count($select) && !isset($select['_id'])) {
				$select['_id'] = 0;
			}

			$options = $select ? ['projection' => $select] : [];

			$sort = [];
			foreach ($order as $val) {
				$val = preg_replace('~ DESC$~', '', $val, 1, $count);
				$sort[idf_unescape($val)] = ($count ? -1 : 1);
			}
			if ($sort) {
				$options['sort'] = $sort;
			}

			$limit = min(200, max(1, $limit));
			$skip = $page * $limit;
			$options += ['limit' => $limit, 'skip' => $skip];

			$query = new Query($filter, $options);

			$start = microtime(true);
			try {
				$result = new MongoResult(Connection::get()->executeQuery(Connection::get()->getDbName() . ".$table", $query));
			} catch (Exception $e) {
				Connection::get()->setError($e->getMessage());
				$result = false;
			}

			if ($print) {
				echo $this->admin->formatSelectQuery('find(' . json_encode(($filter ? ["filter" => $filter] : []) + $options) . ")", $start, !$result);
			}

			return $result;
		}

		public function update(string $table, array $record, string $queryWhere, int $limit = 0, string $separator = "\n")
		{
			$filter = sql_query_where_parser($queryWhere);
			if ($filter === null) {
				return false;
			}

			$set = $removeFields = [];
			foreach ($record as $key => $value) {
				$key = idf_unescape($key);

				if ($value == self::NULL) {
					$removeFields[$key] = 1;
				} elseif ($key != '_id') {
					$set[$key] = unquote($value);
				}
			}

			$object = ['$set' => $set];
			if (count($removeFields)) {
				$object['$unset'] = $removeFields;
			}

			$options = ['upsert' => false];

			// Save the query for later use in a flesh message. TODO: This is so ugly.
			queries('update(' . json_encode(($filter ? ["filter" => $filter] : []) + $object + $options) . ")");

			$bulk = new BulkWrite();
			$bulk->update($filter, $object, $options);

			return Connection::get()->executeBulkWrite(Connection::get()->getDbName() . ".$table", $bulk, 'getModifiedCount');
		}

		public function delete(string $table, string $queryWhere, int $limit = 0)
		{
			$filter = sql_query_where_parser($queryWhere);
			if ($filter === null) {
				return false;
			}

			$options = $limit ? ['limit' => $limit] : [];

			// Save the query for later use in a flesh message. TODO: This is so ugly.
			queries('delete(' . json_encode(($filter ? ["filter" => $filter] : []) + $options) . ")");

			$bulk = new BulkWrite();
			$bulk->delete($filter, $options);

			return Connection::get()->executeBulkWrite(Connection::get()->getDbName() . ".$table", $bulk, 'getDeletedCount');
		}

		public function insert(string $table, array $record)
		{
			$document = [];
			foreach ($record as $key => $value) {
				$key = idf_unescape($key);

				if ($value != self::NULL) {
					$value = unquote($value);
					if ($key != '_id') {
						$document[$key] = $value;
					} elseif ($value != '') {
						$document[$key] = (is_string($value) ? parse_id($value) : $value);
					}
				}
			}

			// Save the query for later use in a flesh message. TODO: This is so ugly.
			queries('insert(' . json_encode($document) . ")");

			$bulk = new BulkWrite();
			$bulk->insert($document);

			return Connection::get()->executeBulkWrite(Connection::get()->getDbName() . ".$table", $bulk, 'getInsertedCount');
		}

		public function getNull(): string
		{
			return self::NULL;
		}
	}

	function create_driver(Connection $connection): Driver
	{
		return MongoDriver::create($connection, Admin::get());
	}

	function get_databases(bool $flush): array
	{
		$cursor = Connection::get()->executeCommand(['listDatabases' => 1], true);
		if (!$cursor) {
			return [];
		}

		$databases = [];
		foreach ($cursor as $dbs) {
			foreach ($dbs->databases as $db) {
				$databases[] = $db->name;
			}
		}

		return $databases;
	}

	function count_tables(array $databases): array
	{
		$return = [];
		return $return;
	}

	function tables_list(): array
	{
		$cursor = Connection::get()->executeCommand(['listCollections' => 1]);
		if (!$cursor) {
			return [];
		}

		$collections = [];
		foreach ($cursor as $result) {
			$collections[$result->name] = 'table';
		}

		// listCollections has no server-side ordering.
		ksort($collections);

		return $collections;
	}

	function drop_databases(array $databases): bool
	{
		return false;
	}

	function indexes(string $table, ?Connection $connection = null): array
	{
		$cursor = Connection::get()->executeCommand(['listIndexes' => $table]);
		if (!$cursor) {
			return [];
		}

		$indexes = [];
		foreach ($cursor as $index) {
			$descs = [];
			$columns = [];
			foreach (get_object_vars($index->key) as $column => $type) {
				$descs[] = ($type == -1 ? '1' : null);
				$columns[] = $column;
			}

			$indexes[$index->name] = [
				"type" => ($index->name == "_id_" ? "PRIMARY" : (isset($index->unique) ? "UNIQUE" : "INDEX")),
				"columns" => $columns,
				"lengths" => [],
				"descs" => $descs,
			];
		}

		return $indexes;
	}

	function fields(string $table): array
	{
		$fields = fields_from_edit();
		if (!$fields) {
			$result = Driver::get()->select($table, ["*"], [], [], [], 10);
			if ($result) {
				while ($row = $result->fetchAssoc()) {
					foreach ($row as $key => $val) {
						$row[$key] = null;
						$fields[$key] = [
							"field" => $key,
							"full_type" => "varchar",
							"type" => "varchar",
							"null" => ($key != Driver::get()->primary),
							"auto_increment" => ($key == Driver::get()->primary),
							"privileges" => [
								"insert" => 1,
								"select" => 1,
								"update" => 1,
								"where" => 1,
								"order" => 1,
							],
						];
					}
				}
			}
		}
		return $fields;
	}

	function found_rows(array $table_status, array $where): ?int
	{
		$where = where_to_query($where);
		if ($where === null) {
			return null;
		}

		$cursor = Connection::get()->executeCommand(['count' => $table_status['Name'], 'query' => $where]);
		if (!$cursor) {
			return null;
		}

		return (int)$cursor->toArray()[0]->n;
	}

	/**
	 * Decodes a value quoted by Connection::quote().
	 *
	 * @param mixed $value Other values are returned as they are, e.g. a document entered as JSON.
	 *
	 * @return mixed
	 */
	function unquote($value)
	{
		if (is_string($value) && strlen($value) > 1 && $value[0] == "'" && substr($value, -1) == "'") {
			return str_replace("''", "'", substr($value, 1, -1));
		}

		return $value;
	}

	/**
	 * Converts the value of _id from the text printed by MongoResult.
	 *
	 * @return BSON\ObjectId|string
	 */
	function parse_id(string $value)
	{
		if (!preg_match(MongoDriver::ObjectIdPattern, $value, $match)) {
			return $value;
		}

		// The backslash marks a string that only looks like ObjectID.
		return ($match[1] != "" ? substr($value, 1) : new BSON\ObjectId($match[2]));
	}

	/**
	 * Converts the condition of an update or a delete to the filter.
	 *
	 * @param string $queryWhere Empty string or " WHERE ...".
	 *
	 * @return ?array Null if the condition is not understood.
	 */
	function sql_query_where_parser(string $queryWhere): ?array
	{
		// WHERE without a condition is not accepted, it would match all documents.
		return where_to_query($queryWhere != "" ? [preg_replace('~^\s*WHERE\s~', "", $queryWhere)] : []);
	}

	/**
	 * Converts the conditions generated by AdminNeo to the filter.
	 *
	 * Names and values are quoted by idf_escape() and Connection::quote(), so the text inside them is never taken as a part of the condition.
	 * A condition that is not understood must not be skipped, because the filter would match more documents then.
	 *
	 * @param string[] $where Conditions to join by AND, e.g. "`_id` = 'x'" or "((`_id` = 'x') OR (`_id` = 'y'))".
	 *
	 * @return ?array Null if a condition is not understood, the error is set to the connection.
	 */
	function where_to_query(array $where): ?array
	{
		$filters = [];

		foreach ($where as $expression) {
			$offset = 0;
			$filter = parse_where($expression, $offset);

			if ($filter === null || !preg_match('~\G\s*$~', $expression, $match, 0, $offset)) {
				Connection::get()->setError("Unsupported condition: " . trim($expression));

				return null;
			}

			$filters[] = $filter;
		}

		return (count($filters) > 1 ? ['$and' => $filters] : ($filters ? $filters[0] : []));
	}

	/**
	 * Parses the conditions joined by AND and OR, where AND takes precedence.
	 *
	 * @param int $offset Position in the expression, moved behind the parsed part.
	 *
	 * @return ?array Null if a condition is not understood.
	 */
	function parse_where(string $expression, int &$offset): ?array
	{
		$or = [];
		$and = [];

		do {
			$filter = parse_where_condition($expression, $offset);
			if ($filter === null) {
				return null;
			}
			$and[] = $filter;

			$operator = (preg_match('~\G\s+(AND|OR)\s+~', $expression, $match, 0, $offset) ? $match[1] : "");
			$offset += strlen($match[0] ?? "");

			if ($operator != "AND") {
				$or[] = (count($and) > 1 ? ['$and' => $and] : $and[0]);
				$and = [];
			}
		} while ($operator);

		return (count($or) > 1 ? ['$or' => $or] : $or[0]);
	}

	/**
	 * Parses a single condition or conditions in parentheses.
	 *
	 * @param int $offset Position in the expression, moved behind the parsed part.
	 *
	 * @return ?array Null if the condition is not understood.
	 */
	function parse_where_condition(string $expression, int &$offset): ?array
	{
		if (preg_match('~\G\s*\(~', $expression, $match, 0, $offset)) {
			$offset += strlen($match[0]);
			$filter = parse_where($expression, $offset);
			if ($filter === null || !preg_match('~\G\s*\)~', $expression, $match, 0, $offset)) {
				return null;
			}
			$offset += strlen($match[0]);

			return $filter;
		}

		// Searching anywhere without a column that could hold the value.
		if (preg_match('~\G\s*1 = 0~', $expression, $match, 0, $offset)) {
			$offset += strlen($match[0]);

			return ['_id' => ['$in' => []]];
		}

		$pattern = implode("|", array_map('preg_quote', Admin::get()->getOperators()));
		if (!preg_match("~\\G\\s*`((?:[^`]++|``)*+)` (?:IS NULL|($pattern) '((?:[^']++|'')*+)')~", $expression, $match, 0, $offset)) {
			return null;
		}
		$offset += strlen($match[0]);

		$col = str_replace("``", "`", $match[1]);
		if (!isset($match[2])) {
			// It matches also a document without the field.
			return [$col => null];
		}

		$op = $match[2];
		$val = str_replace("''", "'", $match[3]);

		if ($col == "_id") {
			$val = parse_id($val);
		}

		if (preg_match('~^\(f\)(.+)~', $op, $match)) {
			$val = (float) $val;
			$op = $match[1];
		} elseif (preg_match('~^\(date\)(.+)~', $op, $match)) {
			try {
				$dateTime = new DateTime($val);
			} catch (Exception $exception) {
				return null;
			}
			$val = new BSON\UTCDatetime($dateTime->getTimestamp() * 1000);
			$op = $match[1];
		}

		$operators = [
			'=' => '$eq',
			'!=' => '$ne',
			'>' => '$gt',
			'<' => '$lt',
			'>=' => '$gte',
			'<=' => '$lte',
			'regex' => '$regex',
		];

		if (!isset($operators[$op])) {
			return null;
		}
		$op = $operators[$op];

		return [$col => [$op => $val]];
	}

	function table(string $idf): string
	{
		return $idf;
	}

	function idf_escape(string $idf): string
	{
		// There is no query language to escape the name for. It is quoted so that it can be told apart from the syntax of a condition.
		return "`" . str_replace("`", "``", $idf) . "`";
	}

	function table_status(string $name = "", bool $fast = false): array
	{
		$return = [];
		foreach (($name != "" ? [$name => 1] : tables_list()) as $table => $type) {
			$return[$table] = ["Name" => $table, "Engine" => ""];
		}
		return $return;
	}

	function create_database(string $db, ?string $collation): bool
	{
		return true;
	}

	function last_id($result)
	{
		return 0;
	}

	function error(): string
	{
		return h(Connection::get()->getError());
	}

	function collations(): array
	{
		return [];
	}

	function logged_user(): string
	{
		$credentials = Admin::get()->getCredentials();
		return $credentials[1];
	}

	function connect(bool $primary = false, ?string &$error = null): ?Connection
	{
		$connection = $primary ? MongoConnection::create() : MongoConnection::createSecondary();

		list($server, $username, $password) = Admin::get()->getCredentials();
		$loginDbs = $_SESSION["db"][DRIVER][SERVER][$username];

		if ($server == "") {
			$server = "localhost:27017";
		}

		$dbName = Admin::get()->getDatabase();
		$authSource = getenv("MONGO_AUTH_SOURCE") ?: key($loginDbs);

		if (!$connection->open("mongodb://$server", $username, $password, $dbName, $authSource)) {
			$error = $connection->getError();
			return null;
		}

		return $connection;
	}

	function alter_indexes(string $table, array $alter): bool
	{
		foreach ($alter as $val) {
			list($type, $name, $set) = $val;

			if ($set == "DROP") {
				$cursor = Connection::get()->executeCommand(["dropIndexes" => $table, "index" => $name]);
			} else {
				$columns = [];
				foreach ($set as $column) {
					$column = preg_replace('~ DESC$~', '', $column, 1, $count);
					$columns[idf_unescape($column)] = $count ? -1 : 1;
				}

				$command = [
					"createIndexes" => $table,
					"indexes" => [[
						"key" => $columns,
						"name" => $name,
						"unique" => $type == "UNIQUE",
						// TODO "sparse"
					]],
				];
				$cursor = Connection::get()->executeCommand($command);
			}

			if (!$cursor) {
				return false;
			}
		}

		return true;
	}

	function support(string $feature): bool
	{
		return preg_match("~database|indexes|descidx~", $feature);
	}

	function db_collation(string $db, array $collations): ?string
	{
		return null;
	}

	function information_schema(?string $db, string $schema = ""): bool
	{
		return false;
	}

	function is_view(array $table_status): bool
	{
		return false;
	}

	function convert_field(array $field): ?string
	{
		return null;
	}

	function unconvert_field(array $field, string $return): string
	{
		return $return;
	}

	function foreign_keys(string $table): array
	{
		return [];
	}

	function backward_keys(string $table): array
	{
		return [];
	}

	function fk_support(array $table_status): bool
	{
		return false;
	}

	function auto_increment(): string
	{
		return "";
	}

	function alter_table(string $table, string $name, array $fields, array $foreign, ?string $comment, string $engine, string $collation, string $auto_increment, ?array $partitioning): bool
	{
		if ($table == "") {
			// Save the query for later use in a flesh message. TODO: This is so ugly.
			queries('createCollection(' . json_encode($name) . ")");

			return (bool)Connection::get()->executeCommand(["create" => $name]);
		}

		return false;
	}

	function drop_tables(array $tables): bool
	{
		foreach ($tables as $name) {
			if (!Connection::get()->executeCommand(["drop" => $name])) {
				return false;
			}
		}

		return true;
	}

	function truncate_tables(array $tables): bool
	{
		foreach ($tables as $name) {
			$command = [
				"delete" => $name,
				"deletes" => [[
					"q" => (object)[],
					"limit" => 0,
				]],
			];
			if (!Connection::get()->executeCommand($command)) {
				return false;
			}
		}

		return true;
	}
}
