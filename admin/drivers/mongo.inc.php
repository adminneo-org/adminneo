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

Drivers::add("mongo", "MongoDB (alpha)");

if (isset($_GET["mongo"])) {
	define("AdminNeo\DRIVER", "mongo");

	if (class_exists('MongoDB\Driver\Manager')) {
		define("AdminNeo\DRIVER_EXTENSION", "MongoDB");

		class MongoConnection extends Connection
		{
			/** @var Manager */
			private $manager;

			/** @var string */
			private $dbName;

			public function open(string $server, string $username, string $password, string $dbName = "", ?string $authSource = null): bool
			{
				$this->server_info = MONGODB_VERSION;

				$options = [];
				if ($username . $password != "") {
					$options["username"] = $username;
					$options["password"] = $password;
				}

				if ($dbName != "") {
					$options["db"] = $dbName;
				}

				if ($authSource) {
					$options["authSource"] = $authSource;
				}

				$this->manager = new Manager($server, $options);
				$this->dbName = $dbName;

				$this->executeCommand(['ping' => 1]);

				return true;
			}

			/**
			 * @return Cursor|array
			 */
			public function executeCommand(array $command)
			{
				try {
					return $this->manager->executeCommand($this->dbName, new Command($command));
				} catch (\MongoDB\Driver\Exception\Exception $exception) {
					$this->error = $exception->getMessage();

					return [];
				}
			}

			/**
			 * @return Cursor|array
			 */
			public function executeQuery(string $namespace, Query $query, ?array $options = null)
			{
				try {
					return $this->manager->executeQuery($namespace, $query, $options);
				} catch (\MongoDB\Driver\Exception\Exception $exception) {
					$this->error = $exception->getMessage();

					return [];
				}
			}

			public function executeBulkWrite(string $namespace, BulkWrite $bulk, string $counter): bool
			{
				try {
					$results = $this->manager->executeBulkWrite($namespace, $bulk);
					$this->affected_rows = $results->$counter();

					return true;
				} catch (Exception $e) {
					$this->error = $e->getMessage();

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
				return $string;
			}
		}

		class Result {
			var $num_rows, $_rows = [], $_offset = 0, $_charset = [];

			function __construct($result) {
				foreach ($result as $item) {
					$row = [];
					foreach ($item as $key => $val) {
						if (is_a($val, 'MongoDB\BSON\Binary')) {
							$this->_charset[$key] = 63;
						}
						$row[$key] =
							(is_a($val, 'MongoDB\BSON\ObjectID') ? 'MongoDB\BSON\ObjectID("' . "$val\")" :
							(is_a($val, 'MongoDB\BSON\UTCDatetime') ? $val->toDateTime()->format('Y-m-d H:i:s') :
							(is_a($val, 'MongoDB\BSON\Binary') ? $val->getData() : //! allow downloading
							(is_a($val, 'MongoDB\BSON\Regex') ? "$val" :
							(is_object($val) || is_array($val) ? json_encode($val, 256) : // 256 = JSON_UNESCAPED_UNICODE
							$val // MongoMinKey, MongoMaxKey
						)))));
					}
					$this->_rows[] = $row;
					foreach ($row as $key => $val) {
						if (!isset($this->_rows[0][$key])) {
							$this->_rows[0][$key] = null;
						}
					}
				}
				$this->num_rows = count($this->_rows);
			}

			function fetch_assoc() {
				$row = current($this->_rows);
				if (!$row) {
					return $row;
				}
				$return = [];
				foreach ($this->_rows[0] as $key => $val) {
					$return[$key] = $row[$key];
				}
				next($this->_rows);
				return $return;
			}

			function fetch_row() {
				$return = $this->fetch_assoc();
				if (!$return) {
					return $return;
				}
				return array_values($return);
			}

			function fetch_field() {
				$keys = array_keys($this->_rows[0]);
				$name = $keys[$this->_offset++];
				return (object) [
					'name' => $name,
					'charsetnr' => $this->_charset[$name],
				];
			}

		}


		class MongoDriver extends Driver {
			public $primary = "_id";

			public function select(string $table, array $select, array $where, array $group, array $order = [], ?int $limit = 1, int $page = 0, bool $print = false)
			{
				$select = ($select == ["*"]
					? []
					: array_fill_keys($select, 1)
				);
				if (count($select) && !isset($select['_id'])) {
					$select['_id'] = 0;
				}

				$where = where_to_query($where);
				$sort = [];
				foreach ($order as $val) {
					$val = preg_replace('~ DESC$~', '', $val, 1, $count);
					$sort[$val] = ($count ? -1 : 1);
				}

				$limit = min(200, max(1, (int) $limit));
				$skip = $page * $limit;

				$query = new Query($where, ['projection' => $select, 'limit' => $limit, 'skip' => $skip, 'sort' => $sort]);

				try {
					return new Result(Connection::get()->executeQuery(Connection::get()->getDbName() . ".$table", $query));
				} catch (Exception $e) {
					Connection::get()->setError($e->getMessage());
					return false;
				}
			}

			public function update(string $table, array $record, string $queryWhere, int $limit = 0, string $separator = "\n")
			{
				$db = Connection::get()->getDbName();
				$where = sql_query_where_parser($queryWhere);
				$bulk = new BulkWrite([]);
				if (isset($record['_id'])) {
					unset($record['_id']);
				}
				$removeFields = [];
				foreach ($record as $key => $value) {
					if ($value == 'NULL') {
						$removeFields[$key] = 1;
						unset($record[$key]);
					}
				}
				$update = ['$set' => $record];
				if (count($removeFields)) {
					$update['$unset'] = $removeFields;
				}
				$bulk->update($where, $update, ['upsert' => false]);

				return Connection::get()->executeBulkWrite("$db.$table", $bulk, 'getModifiedCount');
			}

			public function delete(string $table, string $queryWhere, int $limit = 0)
			{
				$bulk = new BulkWrite([]);
				$bulk->delete(sql_query_where_parser($queryWhere), ['limit' => $limit]);

				return Connection::get()->executeBulkWrite(Connection::get()->getDbName() . ".$table", $bulk, 'getDeletedCount');
			}

			public function insert(string $table, array $record)
			{
				if ($record['_id'] == '') {
					unset($record['_id']);
				}

				$bulk = new BulkWrite([]);
				$bulk->insert($record);

				return Connection::get()->executeBulkWrite(Connection::get()->getDbName() . "$table", $bulk, 'getInsertedCount');
			}
		}



		function create_driver(Connection $connection): Driver
		{
			return MongoDriver::create($connection, Admin::get());
		}

		function get_databases($flush) {
			$return = [];
			foreach (Connection::get()->executeCommand(['listDatabases' => 1]) as $dbs) {
				foreach ($dbs->databases as $db) {
					$return[] = $db->name;
				}
			}
			return $return;
		}

		function count_tables($databases) {
			$return = [];
			return $return;
		}

		function tables_list() {
			$collections = [];
			foreach (Connection::get()->executeCommand(['listCollections' => 1]) as $result) {
				$collections[$result->name] = 'table';
			}
			return $collections;
		}

		function drop_databases($databases) {
			return false;
		}

		function indexes($table, $connection2 = null) {
			$return = [];
			foreach (Connection::get()->executeCommand(['listIndexes' => $table]) as $index) {
				$descs = [];
				$columns = [];
				foreach (get_object_vars($index->key) as $column => $type) {
					$descs[] = ($type == -1 ? '1' : null);
					$columns[] = $column;
				}
				$return[$index->name] = [
					"type" => ($index->name == "_id_" ? "PRIMARY" : (isset($index->unique) ? "UNIQUE" : "INDEX")),
					"columns" => $columns,
					"lengths" => [],
					"descs" => $descs,
				];
			}
			return $return;
		}

		function fields($table) {
			$fields = fields_from_edit();
			if (!$fields) {
				$result = Driver::get()->select($table, ["*"], [], [], [], 10);
				if ($result) {
					while ($row = $result->fetch_assoc()) {
						foreach ($row as $key => $val) {
							$row[$key] = null;
							$fields[$key] = [
								"field" => $key,
								"type" => "string",
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

		function found_rows($table_status, $where) {
			$where = where_to_query($where);
			$toArray = Connection::get()->executeCommand(['count' => $table_status['Name'], 'query' => $where])->toArray();
			return $toArray[0]->n;
		}

		function sql_query_where_parser($queryWhere) {
			$queryWhere = preg_replace('~^\s*WHERE\s*~', "", $queryWhere);
			while ($queryWhere[0] == "(") {
				$queryWhere = preg_replace('~^\((.*)\)$~', "$1", $queryWhere);
			}

			$wheres = explode(' AND ', $queryWhere);
			$wheresOr = explode(') OR (', $queryWhere);
			$where = [];
			foreach ($wheres as $whereStr) {
				$where[] = trim($whereStr);
			}
			if (count($wheresOr) == 1) {
				$wheresOr = [];
			} elseif (count($wheresOr) > 1) {
				$where = [];
			}
			return where_to_query($where, $wheresOr);
		}

		function where_to_query($whereAnd = [], $whereOr = []) {
			$data = [];
			foreach (['and' => $whereAnd, 'or' => $whereOr] as $type => $where) {
				if (is_array($where)) {
					foreach ($where as $expression) {
						list($col, $op, $val) = explode(" ", $expression, 3);
						if ($col == "_id" && preg_match('~^(MongoDB\\\\BSON\\\\ObjectID)\("(.+)"\)$~', $val, $match)) {
							list(, $class, $val) = $match;
							$val = new $class($val);
						}
						if (!in_array($op, Admin::get()->getOperators())) {
							continue;
						}
						if (preg_match('~^\(f\)(.+)~', $op, $match)) {
							$val = (float) $val;
							$op = $match[1];
						} elseif (preg_match('~^\(date\)(.+)~', $op, $match)) {
							$dateTime = new DateTime($val);
							$val = new BSON\UTCDatetime($dateTime->getTimestamp() * 1000);
							$op = $match[1];
						}
						switch ($op) {
							case '=':
								$op = '$eq';
								break;
							case '!=':
								$op = '$ne';
								break;
							case '>':
								$op = '$gt';
								break;
							case '<':
								$op = '$lt';
								break;
							case '>=':
								$op = '$gte';
								break;
							case '<=':
								$op = '$lte';
								break;
							case 'regex':
								$op = '$regex';
								break;
							default:
								continue 2;
						}
						if ($type == 'and') {
							$data['$and'][] = [$col => [$op => $val]];
						} elseif ($type == 'or') {
							$data['$or'][] = [$col => [$op => $val]];
						}
					}
				}
			}
			return $data;
		}
	}

	function table($idf) {
		return $idf;
	}

	function idf_escape($idf) {
		return $idf;
	}

	function table_status($name = "", $fast = false) {
		$return = [];
		foreach (tables_list() as $table => $type) {
			$return[$table] = ["Name" => $table];
			if ($name == $table) {
				return $return[$table];
			}
		}
		return $return;
	}

	function create_database($db, $collation) {
		return true;
	}

	function last_id() {
		return 0;
	}

	function error() {
		return h(Connection::get()->getError());
	}

	function collations() {
		return [];
	}

	function logged_user() {
		$credentials = Admin::get()->getCredentials();
		return $credentials[1];
	}

	/**
	 * @return Connection|string
	 */
	function connect(bool $primary = false)
	{
		$connection = $primary ? MongoConnection::create() : MongoConnection::createSecondary();

		list($server, $username, $password) = Admin::get()->getCredentials();

		if ($server == "") {
			$server = "localhost:27017";
		}

		$dbName = Admin::get()->getDatabase();
		$authSource = getenv("MONGO_AUTH_SOURCE") ?: null;

		$connection->open("mongodb://$server", $username, $password, $dbName, $authSource);
		if ($connection->getError()) {
			return $connection->getError();
		}

		return $connection;
	}

	function alter_indexes($table, $alter) {
		foreach ($alter as $val) {
			list($type, $name, $set) = $val;
			if ($set == "DROP") {
				$return =  Connection::get()->executeCommand(["deleteIndexes" => $table, "index" => $name]);
			} else {
				$columns = [];
				foreach ($set as $column) {
					$column = preg_replace('~ DESC$~', '', $column, 1, $count);
					$columns[$column] = ($count ? -1 : 1);
				}
				$return =  Connection::get()->_db->selectCollection($table)->ensureIndex($columns, [
					"unique" => ($type == "UNIQUE"),
					"name" => $name,
					//! "sparse"
				]);
			}
			if ($return['errmsg']) {
				Connection::get()->setError($return['errmsg']);
				return false;
			}
		}
		return true;
	}

	function support($feature) {
		return preg_match("~database|indexes|descidx~", $feature);
	}

	function db_collation($db, $collations) {
	}

	function information_schema() {
	}

	function is_view($table_status) {
	}

	function convert_field($field) {
	}

	function unconvert_field(array $field, $return) {
		return $return;
	}

	function foreign_keys($table) {
		return [];
	}

	function fk_support($table_status) {
	}

	function engines() {
		return [];
	}

	function alter_table($table, $name, $fields, $foreign, $comment, $engine, $collation, $auto_increment, $partitioning) {
		if ($table == "") {
			Connection::get()->_db->createCollection($name);
			return true;
		}
	}

	function drop_tables($tables) {
		foreach ($tables as $table) {
			$response = Connection::get()->_db->selectCollection($table)->drop();
			if (!$response['ok']) {
				return false;
			}
		}
		return true;
	}

	function truncate_tables($tables) {
		foreach ($tables as $table) {
			$response =  Connection::get()->_db->selectCollection($table)->remove();
			if (!$response['ok']) {
				return false;
			}
		}
		return true;
	}

	function driver_config() {
		return [
			'possible_drivers' => ["mongodb"],
			'jush' => "mongo",
			'operators' => [
				"=",
				"!=",
				">",
				"<",
				">=",
				"<=",
				"regex",
				"(f)=",
				"(f)!=",
				"(f)>",
				"(f)<",
				"(f)>=",
				"(f)<=",
				"(date)=",
				"(date)!=",
				"(date)>",
				"(date)<",
				"(date)>=",
				"(date)<=",
			],
			'operator_like' => "LIKE %%", // TODO: LIKE operator is not listed in operators.
			'operator_regexp' => 'regex',
			'functions' => [],
			'grouping' => [],
			'edit_functions' => [["json"]],
		];
	}
}
