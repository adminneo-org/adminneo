<?php

namespace AdminNeo;

abstract class Driver
{
	/** @var Connection */
	protected $connection;

	/** @var Origin|Pluginer */
	protected $admin;

	/** @var array [$description => [$type => $maximum_unsigned_length, ...], ...] */
	protected $types = [];

	/** @var ?Driver */
	private static $instance = null;

	/**
	 * @param Origin|Pluginer $admin
	 */
	public static function create(Connection $connection, $admin): Driver
	{
		if (self::$instance) {
			die(__CLASS__ . " instance already exists.\n");
		}

		return self::$instance = new static($connection, $admin);
	}

	public static function get(): Driver
	{
		if (!self::$instance) {
			exit(__CLASS__ . " instance not found.\n");
		}

		return self::$instance;
	}

	/**
	 * @param Origin|Pluginer $admin
	 */
	protected function __construct(Connection $connection, $admin)
	{
		$this->connection = $connection;
		$this->admin = $admin;
	}

	/**
	 * Returns the list of all types.
	 *
	 * @return array [$type => $maximum_unsigned_length, ...]
	 */
	public function getTypes(): array
	{
		return call_user_func_array("array_merge", array_values($this->types));
	}

	/**
	 * Returns structured types.
	 *
	 * @return array [$description => [$type, ...], ...]
	 */
	public function getStructuredTypes(): array
	{
		return array_map("array_keys", $this->types);
	}

	public function setUserTypes(array $types): void
	{
		$this->types[lang('User types')] = array_flip($types);
	}

	public function getUserTypes(): array
	{
		return array_keys($this->types[lang('User types')] ?? []);
	}

	/**
	 * Selects data from a table.
	 *
	 * @param string $table Table name.
	 * @param array $select The result of Admin::get()->processSelectionColumns()[0].
	 * @param array $where The result of Admin::get()->processSelectionSearch().
	 * @param array $group The result of Admin::get()->processSelectionColumns()[1].
	 * @param array $order The result of Admin::get()->processSelectionOrder().
	 * @param ?int $limit The result of Admin::get()->processSelectionLimit().
	 * @param int $page Index of page starting at zero.
	 * @param bool $print Whether to print the query.
	 *
	 * @return Result|false
	 */
	public function select(string $table, array $select, array $where, array $group, array $order = [], ?int $limit = 1, int $page = 0, bool $print = false)
	{
		global $jush;
		$is_group = (count($group) < count($select));

		$query = "SELECT" . limit(
			($_GET["page"] != "last" && $limit !== null && $group && $is_group && $jush == "sql" ? "SQL_CALC_FOUND_ROWS " : "") . implode(", ", $select) . "\nFROM " . table($table),
			($where ? "\nWHERE " . implode(" AND ", $where) : "") . ($group && $is_group ? "\nGROUP BY " . implode(", ", $group) : "") . ($order ? "\nORDER BY " . implode(", ", $order) : ""),
			($limit !== null ? +$limit : null),
			($page ? $limit * $page : 0),
			"\n"
		);

		$start = microtime(true);
		$return = $this->connection->query($query);

		if ($print) {
			echo Admin::get()->formatSelectQuery($query, $start, !$return);
		}

		return $return;
	}

	/**
	 * Deletes data from a table.
	 *
	 * @param string $table Table name.
	 * @param string $queryWhere Where condition " WHERE ...".
	 * @param int $limit 0 or 1.
	 *
	 * @return Result|bool
	 */
	public function delete(string $table, string $queryWhere, int $limit = 0)
	{
		$query = "FROM " . table($table);

		return queries("DELETE" . ($limit ? limit1($table, $query, $queryWhere) : " $query$queryWhere"));
	}

	/**
	 * Updates data in a table.
	 *
	 * @param string $table Table name.
	 * @param array $record Escaped columns in keys, quoted data in values.
	 * @param string $queryWhere Where condition " WHERE ...".
	 * @param int $limit 0 or 1.
	 * @param string $separator Separator between parts of the query.
	 *
	 * @return Result|bool
	 */
	public function update(string $table, array $record, string $queryWhere, int $limit = 0, string $separator = "\n")
	{
		$values = [];
		foreach ($record as $key => $val) {
			$values[] = "$key = $val";
		}
		$query = table($table) . " SET$separator" . implode(",$separator", $values);

		return queries("UPDATE" . ($limit ? limit1($table, $query, $queryWhere, $separator) : " $query$queryWhere"));
	}

	/**
	 * Inserts data into a table.
	 *
	 * @param string $table Table name.
	 * @param array $record Escaped columns in keys, quoted data in values.
	 *
	 * @return Result|bool
	 */
	public function insert(string $table, array $record)
	{
		return queries("INSERT INTO " . table($table) . ($record
			? " (" . implode(", ", array_keys($record)) . ")\nVALUES (" . implode(", ", $record) . ")"
			: " DEFAULT VALUES"
		));
	}

	/**
	 * Inserts or updates data in a table.
	 *
	 * @param string $table Table name.
	 * @param array $records List of records.
	 * @param array[] $primary Array of arrays with escaped columns in keys and quoted data in values.
	 *
	 * @return Result|bool
	 */
	public function insertUpdate(string $table, array $records, array $primary)
	{
		return false;
	}

	/**
	 * Begins new transaction.
	 *
	 * @return Result|bool
	 */
	public function begin()
	{
		return queries("BEGIN");
	}

	/**
	 * Commits transaction.
	 *
	 * @return Result|bool
	 */
	public function commit()
	{
		return queries("COMMIT");
	}

	/**
	 * Rollback transaction.
	 *
	 * @return Result|bool
	 */
	public function rollback()
	{
		return queries("ROLLBACK");
	}

	/**
	 * Returns query with a timeout.
	 *
	 * @return ?string Null if the driver doesn't support query timeouts.
	 */
	public function slowQuery(string $query, int $timeout): ?string
	{
		return null;
	}

	/**
	 * Converts column to be searchable.
	 *
	 * @param string $idf Escaped column name.
	 * @param array $where ["op" => , "val" => ]
	 * @param array $field Single field returned from fields().
	 */
	public function convertSearch(string $idf, array $where, array $field): string
	{
		return $idf;
	}

	/**
	 * Converts value returned by database to actual value.
	 *
	 * @param ?string $val Value.
	 * @param array $field Single field returned from fields().
	 */
	public function value(?string $val, array $field): ?string
	{
		return (method_exists($this->connection, 'value')
			? $this->connection->value($val, $field)
			: (is_resource($val) ? stream_get_contents($val) : $val)
		);
	}

	/**
	 * Quotes binary string.
	 */
	public function quoteBinary(string $string): string
	{
		return q($string);
	}

	/**
	 * Returns warnings about the last command.
	 *
	 * @return string HTML
	 */
	public function warnings(): ?string
	{
		return null;
	}

	/**
	 * Returns help link for a table.
	 *
	 * @param string $name Table name.
	 *
	 * @return ?string Relative URL or null.
	 */
	public function tableHelp(string $name, bool $isView = false): ?string
	{
		return null;
	}

	/**
	 * Checks if C-style escapes are supported.
	 */
	public function hasCStyleEscapes(): bool
	{
		return false;
	}

	/**
	 * Returns defined check constraints.
	 *
	 * @param string $table Table name.
	 *
	 * @return array [$name => $clause]
	 */
	public function checkConstraints(string $table): array
	{
		// MariaDB contains CHECK_CONSTRAINTS.TABLE_NAME, MySQL and PostgreSQL not.
		return get_key_vals("SELECT c.CONSTRAINT_NAME, CHECK_CLAUSE
FROM INFORMATION_SCHEMA.CHECK_CONSTRAINTS c
JOIN INFORMATION_SCHEMA.TABLE_CONSTRAINTS t ON c.CONSTRAINT_SCHEMA = t.CONSTRAINT_SCHEMA AND c.CONSTRAINT_NAME = t.CONSTRAINT_NAME
WHERE c.CONSTRAINT_SCHEMA = " . q($_GET["ns"] != "" ? $_GET["ns"] : DB) . "
AND t.TABLE_NAME = " . q($table) . "
AND CHECK_CLAUSE NOT LIKE '% IS NOT NULL'"); // ignore default IS NOT NULL checks in PostgreSQL
	}
}
