<?php

namespace AdminNeo;

abstract class Driver
{
	public const EnumLengthPattern = "'(?:''|[^'\\\\]|\\\\.)*'";

	/** @var Connection */
	protected $connection;

	/** @var Origin|Pluginer */
	protected $admin;

	/** @var int[][] [$description => [$type => $maximum_unsigned_length, ...], ...] */
	protected $types = [];

	/** @var list<string> List of number variants. */
	protected $unsigned = [];

	/** @var list<string> */
	protected $generated = [];

	/** @var list<string> Operators used in select. */
	protected $operators = [];

	/** @var String Operator for LIKE condition. */
	protected $likeOperator = "LIKE %%";

	/** @var list<string> Functions used in select. */
	protected $functions = [];

	/** @var list<string> Grouping functions used in select. */
	protected $grouping = [];

	/** @var list<string> List of IN/OUT parameters for procedures. */
	protected $inOut = ["IN", "OUT", "INOUT"];

	/** @var list<string> List of actions used within the foreign keys. */
	protected $onActions = ["RESTRICT", "CASCADE", "SET NULL", "SET DEFAULT", "NO ACTION"];

	/** @var list<string> Supported partitioning types. */
	protected $partitionBy = [];

	/** @var string[] ["$type|$type2" => "$function/$function2"] Functions used in edit and insert. **/
	protected $insertFunctions = [];

	/** @var string[] ["$type|$type2" => "$function/$function2"] Functions used in edit only. **/
	protected $editFunctions = [];

	/** @var list<string> Array of internal system databases. */
	protected $systemDatabases = [];

	/** @var list<string> Array of internal system schemas. */
	protected $systemSchemas = [];

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
	 * @return int[] [$type => $maximum_unsigned_length, ...]
	 */
	public function getTypes(): array
	{
		return call_user_func_array("array_merge", array_values($this->types));
	}

	/**
	 * Returns structured types.
	 *
	 * @return list<string>[]|list<string> [$description => [$type, ...], ...]
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
		$key = lang('User types');

		return array_keys($this->types[$key] ?? []);
	}

	/**
	 * @return string[]
	 */
	public function getUnsigned(): array
	{
		return $this->unsigned;
	}

	/**
	 * @return string[]
	 */
	public function getGenerated(): array
	{
		return $this->generated;
	}

	/**
	 * @return string[]
	 */
	public function getOperators(): array
	{
		return $this->operators;
	}

	public function getLikeOperator(): ?string
	{
		return $this->likeOperator;
	}

	/**
	 * @return string[]
	 */
	public function getFunctions(): array
	{
		return $this->functions;
	}

	/**
	 * @return string[]
	 */
	public function getGrouping(): array
	{
		return $this->grouping;
	}

	/**
	 * @return string[]
	 */
	public function getInOut(): array
	{
		return $this->inOut;
	}

	/**
	 * @return string[]
	 */
	public function getOnActions(): array
	{
		return $this->onActions;
	}

	/**
	 * @return list<string>
	 */
	public function getPartitionBy(): array
	{
		return $this->partitionBy;
	}

	/**
	 * @return string[]
	 */
	public function getInsertFunctions(): array
	{
		return $this->insertFunctions;
	}

	/**
	 * @return string[]
	 */
	public function getEditFunctions(): array
	{
		return $this->editFunctions;
	}

	/**
	 * @return string[]
	 */
	public function getSystemDatabases(): array
	{
		return $this->systemDatabases;
	}

	/**
	 * @return string[]
	 */
	public function getSystemSchemas(): array
	{
		return $this->systemSchemas;
	}

	/**
	 * Returns function used to convert the value inserted by user.
	 */
	public function getUnconvertFunction(array $field): string
	{
		return "";
	}

	/**
	 * Selects data from a table.
	 *
	 * @param string $table Table name.
	 * @param list<string> $select The result of Admin::get()->processSelectionColumns()[0].
	 * @param list<string> $where The result of Admin::get()->processSelectionSearch().
	 * @param list<string> $group The result of Admin::get()->processSelectionColumns()[1].
	 * @param list<string> $order The result of Admin::get()->processSelectionOrder().
	 * @param int $limit The result of Admin::get()->processSelectionLimit().
	 * @param int $page Index of page starting at zero.
	 * @param bool $print Whether to print the query.
	 *
	 * @return Result|false
	 */
	public function select(string $table, array $select, array $where, array $group, array $order = [], int $limit = 1, int $page = 0, bool $print = false)
	{
		$is_group = (count($group) < count($select));

		$query = "SELECT" . limit(
			($_GET["page"] != "last" && $limit && $group && $is_group && DIALECT == "sql" ? "SQL_CALC_FOUND_ROWS " : "") . implode(", ", $select) . "\nFROM " . table($table),
			($where ? "\nWHERE " . implode(" AND ", $where) : "") . ($group && $is_group ? "\nGROUP BY " . implode(", ", $group) : "") . ($order ? "\nORDER BY " . implode(", ", $order) : ""),
			$limit,
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
	 * @param string[] $record Escaped columns in keys, quoted data in values.
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
	 * @param string[] $record Escaped columns in keys, quoted data in values.
	 *
	 * @return Result|bool
	 */
	public function insert(string $table, array $record)
	{
		return queries("INSERT INTO " . table($table) . (
			$record ?
				" (" . implode(", ", array_keys($record)) . ")\nVALUES (" . implode(", ", $record) . ")" :
				" DEFAULT VALUES"
			) . $this->getInsertReturningSql($table));
	}

	/**
	 * Returns RETURNING clause for INSERT queries (PostgreSQL specific).
	 *
	 * @param string $table Table name.
	 */
	public function getInsertReturningSql(string $table): string
	{
		return "";
	}

	/**
	 * Inserts or updates data in a table.
	 *
	 * @param string $table Table name.
	 * @param list<string[]> $records Array of arrays with escaped columns in keys and quoted data in values.
	 * @param int[] $primary List of records.
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
	 * Returns NULL expression.
	 */
	public function getNull(): string
	{
		return "NULL";
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
	 * Checks whether table supports indexes.
	 *
	 * @param array $tableStatus The result of table_status1().
	 */
	public function supportsIndex(array $tableStatus): bool
	{
		return !is_view($tableStatus);
	}

	/**
	 * Returns list of supported index algorithms, first one is the default.
	 *
	 * @return list<string>
	 */
	public function getIndexAlgorithms(array $tableStatus): array
	{
		return [];
	}

	/**
	 * Returns inherited tables.
	 *
	 * @return list<array{table: string, ns: string}>
	 */
	public function getInheritedTables(string $table): array
	{
		return [];
	}

	/**
	 * Returns tables this table inherits from.
	 *
	 * @return list<array{table: string, ns: string}>
	 */
	public function getParentTables(string $table): array
	{
		return [];
	}

	/**
	 * Returns whether this table is a partition.
	 */
	public function isPartition(string $table): bool
	{
		return false;
	}

	/**
	 * Returns partitions info.
	 *
	 * @return array{partition_by?:string, partition?:string, partitions?:string, partition_names?:list<string>, partition_values?:list<string>}
	 */
	public function getPartitionsInfo(string $table): array
	{
		return [];
	}

	/**
	 * Checks if C-style escapes are supported.
	 */
	public function hasCStyleEscapes(): bool
	{
		return false;
	}

	/**
	 * Returns supported engines.
	 *
	 * @return string[]
	 */
	public function engines(): array
	{
		return [];
	}

	public function explodeArrayValue(string $value, string $type, string &$scalarType): array
	{
		return [];
	}

	public function implodeArrayValues(array $values, string $type): string
	{
		return "";
	}

	/**
	 * Returns defined check constraints.
	 *
	 * @param string $table Table name.
	 *
	 * @return string[] [$name => $clause]
	 */
	public function checkConstraints(string $table): array
	{
		// MariaDB contains CHECK_CONSTRAINTS.TABLE_NAME, MySQL and PostgreSQL not.
		return get_key_vals("SELECT c.CONSTRAINT_NAME, CHECK_CLAUSE
FROM INFORMATION_SCHEMA.CHECK_CONSTRAINTS c
JOIN INFORMATION_SCHEMA.TABLE_CONSTRAINTS t ON c.CONSTRAINT_SCHEMA = t.CONSTRAINT_SCHEMA AND c.CONSTRAINT_NAME = t.CONSTRAINT_NAME" . ($this->connection->isMariaDB() ? " AND c.TABLE_NAME = " . q($table) : "") . "
WHERE c.CONSTRAINT_SCHEMA = " . q($_GET["ns"] != "" ? $_GET["ns"] : DB) . "
AND t.TABLE_NAME = " . q($table) . "
AND t.TABLE_NAME = " . q($table) . (DIALECT == "pgsql" ? "
AND CHECK_CLAUSE NOT LIKE '% IS NOT NULL'" : ""), $this->connection); // ignore default IS NOT NULL checks in PostgreSQL
	}

	/**
	 * Returns all fields in the current schema.
	 *
	 * @return array<list<array{field:string, null:bool, type:string, length:?numeric-string, primary?:numeric-string}>>
	 */
	function getAllFields(): array
	{
		if (DB == "") {
			return [];
		}

		$allFields = [];

		$rows = get_rows("SELECT TABLE_NAME AS tab, COLUMN_NAME AS field, IS_NULLABLE AS nullable, DATA_TYPE AS type, CHARACTER_MAXIMUM_LENGTH AS length" . (DIALECT == 'sql' ? ", COLUMN_KEY = 'PRI' AS `primary`" : "") . "
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_SCHEMA = " . q($_GET["ns"] != "" ? $_GET["ns"] : DB) . "
ORDER BY TABLE_NAME, ORDINAL_POSITION", $this->connection);

		foreach ($rows as $row) {
			$row["null"] = ($row["nullable"] == "YES");
			$allFields[$row["tab"]][] = $row;
		}

		return $allFields;
	}
}
