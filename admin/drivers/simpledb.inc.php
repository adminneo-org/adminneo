<?php

namespace AdminNeo;

add_driver("simpledb", "SimpleDB");

if (isset($_GET["simpledb"])) {
	define("AdminNeo\DRIVER", "simpledb");

	if (class_exists('SimpleXMLElement') && ini_bool('allow_url_fopen')) {
		class Min_DB {
			var $extension = "SimpleXML", $server_info = '2009-04-15', $error, $timeout, $next, $affected_rows, $_url, $_result;

			function connect(string $server): bool
			{
				if ($server == '') {
					$this->error = lang('Invalid server or credentials.');
					return false;
				}

				$parts = parse_url($server);

				if (!$parts || !isset($parts['host']) || !preg_match('~^sdb\.([a-z0-9-]+\.)?amazonaws\.com$~i', $parts['host']) ||
					isset($parts['port'])
				) {
					$this->error = lang('Invalid server or credentials.');
					return false;
				}

				$this->_url = build_http_url($server, '', '', '');

				return (bool) $this->workaroundLoginRequest('ListDomains', ['MaxNumberOfDomains' => 1]);
			}

			// FIXME: This is so wrong :-( Move sdb_request to Min_DB!
			private function workaroundLoginRequest($action, $params = []) {
				global $connection;

				$connection = $this;
				$result = sdb_request($action, $params);
				$connection = null;

				return $result;
			}

			function select_db($database) {
				return ($database == "domain");
			}

			function query($query) {
				$params = ['SelectExpression' => $query, 'ConsistentRead' => 'true'];
				if ($this->next) {
					$params['NextToken'] = $this->next;
				}
				$result = sdb_request_all('Select', 'Item', $params, $this->timeout); //! respect $unbuffered
				$this->timeout = 0;
				if ($result === false) {
					return $result;
				}
				if (preg_match('~^\s*SELECT\s+COUNT\(~i', $query)) {
					$sum = 0;
					foreach ($result as $item) {
						$sum += $item->Attribute->Value;
					}
					$result = [(object) ['Attribute' => [(object) [
						'Name' => 'Count',
						'Value' => $sum,
					]]]];
				}
				return new Min_Result($result);
			}

			function multi_query($query) {
				return $this->_result = $this->query($query);
			}

			function store_result() {
				return $this->_result;
			}

			function next_result() {
				return false;
			}

			function quote($string) {
				return "'" . str_replace("'", "''", $string) . "'";
			}

		}

		class Min_Result {
			var $num_rows, $_rows = [], $_offset = 0;

			function __construct($result) {
				foreach ($result as $item) {
					$row = [];
					if ($item->Name != '') { // SELECT COUNT(*)
						$row['itemName()'] = (string) $item->Name;
					}
					foreach ($item->Attribute as $attribute) {
						$name = $this->_processValue($attribute->Name);
						$value = $this->_processValue($attribute->Value);
						if (isset($row[$name])) {
							$row[$name] = (array) $row[$name];
							$row[$name][] = $value;
						} else {
							$row[$name] = $value;
						}
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

			function _processValue($element) {
				return (is_object($element) && $element['encoding'] == 'base64' ? base64_decode($element) : (string) $element);
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
				return (object) ['name' => $keys[$this->_offset++]];
			}

		}
	}



	class Min_Driver extends Min_SQL {
		public $primary = "itemName()";

		function _chunkRequest($ids, $action, $params, $expand = []) {
			global $connection;
			foreach (array_chunk($ids, 25) as $chunk) {
				$params2 = $params;
				foreach ($chunk as $i => $id) {
					$params2["Item.$i.ItemName"] = $id;
					foreach ($expand as $key => $val) {
						$params2["Item.$i.$key"] = $val;
					}
				}
				if (!sdb_request($action, $params2)) {
					return false;
				}
			}
			$connection->affected_rows = count($ids);
			return true;
		}

		function _extractIds($table, $queryWhere, $limit) {
			$return = [];
			if (preg_match_all("~itemName\(\) = (('[^']*+')+)~", $queryWhere, $matches)) {
				$return = array_map('AdminNeo\idf_unescape', $matches[1]);
			} else {
				foreach (sdb_request_all('Select', 'Item', ['SelectExpression' => 'SELECT itemName() FROM ' . table($table) . $queryWhere . ($limit ? " LIMIT 1" : "")]) as $item) {
					$return[] = $item->Name;
				}
			}
			return $return;
		}

		function select($table, $select, $where, $group, $order = [], ?int $limit = 1, $page = 0, $print = false) {
			global $connection;
			$connection->next = $_GET["next"];
			$return = parent::select($table, $select, $where, $group, $order, $limit, $page, $print);
			$connection->next = 0;
			return $return;
		}

		function delete($table, $queryWhere, $limit = 0) {
			return $this->_chunkRequest(
				$this->_extractIds($table, $queryWhere, $limit),
				'BatchDeleteAttributes',
				['DomainName' => $table]
			);
		}

		function update($table, $set, $queryWhere, $limit = 0, $separator = "\n") {
			$delete = [];
			$insert = [];
			$i = 0;
			$ids = $this->_extractIds($table, $queryWhere, $limit);
			$id = idf_unescape($set["`itemName()`"]);
			unset($set["`itemName()`"]);
			foreach ($set as $key => $val) {
				$key = idf_unescape($key);
				if ($val == "NULL" || ($id != "" && [$id] != $ids)) {
					$delete["Attribute." . count($delete) . ".Name"] = $key;
				}
				if ($val != "NULL") {
					foreach ((array) $val as $k => $v) {
						$insert["Attribute.$i.Name"] = $key;
						$insert["Attribute.$i.Value"] = (is_array($val) ? $v : idf_unescape($v));
						if (!$k) {
							$insert["Attribute.$i.Replace"] = "true";
						}
						$i++;
					}
				}
			}
			$params = ['DomainName' => $table];
			return (!$insert || $this->_chunkRequest(($id != "" ? [$id] : $ids), 'BatchPutAttributes', $params, $insert))
				&& (!$delete || $this->_chunkRequest($ids, 'BatchDeleteAttributes', $params, $delete))
			;
		}

		function insert($table, $set) {
			$params = ["DomainName" => $table];
			$i = 0;
			foreach ($set as $name => $value) {
				if ($value != "NULL") {
					$name = idf_unescape($name);
					if ($name == "itemName()") {
						$params["ItemName"] = idf_unescape($value);
					} else {
						foreach ((array) $value as $val) {
							$params["Attribute.$i.Name"] = $name;
							$params["Attribute.$i.Value"] = (is_array($value) ? $val : idf_unescape($value));
							$i++;
						}
					}
				}
			}
			return sdb_request('PutAttributes', $params);
		}

		function insertUpdate($table, $rows, $primary) {
			//! use one batch request
			foreach ($rows as $set) {
				if (!$this->update($table, $set, "WHERE `itemName()` = " . q($set["`itemName()`"]))) {
					return false;
				}
			}
			return true;
		}

		function begin() {
			return false;
		}

		function commit() {
			return false;
		}

		function rollback() {
			return false;
		}

		function slowQuery($query, $timeout) {
			$this->_conn->timeout = $timeout;
			return $query;
		}

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
	 * @return Min_DB|string
	 */
	function connect()
	{
		$connection = new Min_DB();

		list($server, , $password) = Admin::get()->getCredentials();
		if ($password != "") {
			$result = Admin::get()->verifyDefaultPassword($password);
			if ($result !== true) {
				return $result;
			}
		}

		if (!$connection->connect($server)) {
			return $connection->error;
		}

		return $connection;
	}

	function support($feature) {
		return preg_match('~sql~', $feature);
	}

	function logged_user() {
		$credentials = Admin::get()->getCredentials();
		return $credentials[1];
	}

	function get_databases() {
		return ["domain"];
	}

	function collations() {
		return [];
	}

	function db_collation($db, $collations) {
	}

	function tables_list() {
		global $connection;
		$return = [];
		foreach (sdb_request_all('ListDomains', 'DomainName') as $table) {
			$return[(string) $table] = 'table';
		}
		if ($connection->error && defined("AdminNeo\PAGE_HEADER")) {
			echo "<p class='error'>" . error() . "\n";
		}
		return $return;
	}

	function table_status($name = "", $fast = false) {
		$return = [];
		foreach (($name != "" ? [$name => true] : tables_list()) as $table => $type) {
			$row = ["Name" => $table, "Auto_increment" => ""];
			if (!$fast) {
				$meta = sdb_request('DomainMetadata', ['DomainName' => $table]);
				if ($meta) {
					foreach ([
						"Rows" => "ItemCount",
						"Data_length" => "ItemNamesSizeBytes",
						"Index_length" => "AttributeValuesSizeBytes",
						"Data_free" => "AttributeNamesSizeBytes",
					] as $key => $val) {
						$row[$key] = (string) $meta->$val;
					}
				}
			}
			if ($name != "") {
				return $row;
			}
			$return[$table] = $row;
		}
		return $return;
	}

	function explain($connection, $query) {
	}

	function error() {
		global $connection;
		return h($connection->error);
	}

	function information_schema() {
	}

	function indexes($table, $connection2 = null) {
		return [
			["type" => "PRIMARY", "columns" => ["itemName()"]],
		];
	}

	function fields($table) {
		return fields_from_edit();
	}

	function foreign_keys($table) {
		return [];
	}

	function table($idf) {
		return idf_escape($idf);
	}

	function idf_escape($idf) {
		return "`" . str_replace("`", "``", $idf) . "`";
	}

	function limit($query, $where, ?int $limit, $offset = 0, $separator = " ") {
		return " $query$where" . ($limit !== null ? $separator . "LIMIT $limit" : "");
	}

	function unconvert_field(array $field, $return) {
		return $return;
	}

	function fk_support($table_status) {
	}

	function engines() {
		return [];
	}

	function alter_table($table, $name, $fields, $foreign, $comment, $engine, $collation, $auto_increment, $partitioning) {
		return ($table == "" && sdb_request('CreateDomain', ['DomainName' => $name]));
	}

	function drop_tables($tables) {
		foreach ($tables as $table) {
			if (!sdb_request('DeleteDomain', ['DomainName' => $table])) {
				return false;
			}
		}
		return true;
	}

	function count_tables($databases) {
		foreach ($databases as $db) {
			return [$db => count(tables_list())];
		}
	}

	function found_rows($table_status, $where) {
		return ($where ? null : $table_status["Rows"]);
	}

	function last_id() {
	}

	function sdb_request($action, $params = []) {
		global $connection;
		list($host, $params['AWSAccessKeyId'], $secret) = Admin::get()->getCredentials();
		$params['Action'] = $action;
		$params['Timestamp'] = gmdate('Y-m-d\TH:i:s+00:00');
		$params['Version'] = '2009-04-15';
		$params['SignatureVersion'] = 2;
		$params['SignatureMethod'] = 'HmacSHA1';
		ksort($params);
		$query = '';
		foreach ($params as $key => $val) {
			$query .= '&' . rawurlencode($key) . '=' . rawurlencode($val);
		}
		$query = str_replace('%7E', '~', substr($query, 1));
		$query .= "&Signature=" . urlencode(base64_encode(hash_hmac('sha1', "POST\n" . preg_replace('~^https?://~', '', $host) . "\n/\n$query", $secret, true)));

		$file = @file_get_contents($connection->_url, false, stream_context_create(['http' => [
			'method' => 'POST', // may not fit in URL with GET
			'content' => $query,
			'ignore_errors' => 1,
			'follow_location' => 0,
			'max_redirects' => 0,
		]]));
		if (!$file) {
			$connection->error = error_get_last()['message'];
			return false;
		}
		libxml_use_internal_errors(true);
		libxml_disable_entity_loader();
		$xml = simplexml_load_string($file);
		if (!$xml) {
			$error = libxml_get_last_error();
			$connection->error = $error->message;
			return false;
		}
		if ($xml->Errors) {
			$error = $xml->Errors->Error;
			$connection->error = "$error->Message ($error->Code)";
			return false;
		}
		$connection->error = '';
		$tag = $action . "Result";
		return ($xml->$tag ? $xml->$tag : true);
	}

	function sdb_request_all($action, $tag, $params = [], $timeout = 0) {
		$return = [];
		$start = ($timeout ? microtime(true) : 0);
		$limit = (preg_match('~LIMIT\s+(\d+)\s*$~i', $params['SelectExpression'], $match) ? $match[1] : 0);
		do {
			$xml = sdb_request($action, $params);
			if (!$xml) {
				break;
			}
			foreach ($xml->$tag as $element) {
				$return[] = $element;
			}
			if ($limit && count($return) >= $limit) {
				$_GET["next"] = $xml->NextToken;
				break;
			}
			if ($timeout && microtime(true) - $start > $timeout) {
				return false;
			}
			$params['NextToken'] = $xml->NextToken;
			if ($limit) {
				$params['SelectExpression'] = preg_replace('~\d+\s*$~', $limit - count($return), $params['SelectExpression']);
			}
		} while ($xml->NextToken);
		return $return;
	}

	function driver_config() {
		return [
			'possible_drivers' => ["SimpleXML + allow_url_fopen"],
			'jush' => "simpledb",
			'operators' => ["=", "<", ">", "<=", ">=", "!=", "LIKE", "LIKE %%", "IN", "IS NULL", "NOT LIKE", "IS NOT NULL"],
			'operator_like' => "LIKE %%",
			'functions' => [],
			'grouping' => ["count"],
			'edit_functions' => [["json"]],
		];
	}
}
