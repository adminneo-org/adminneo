<?php

namespace AdminNeo;

abstract class AdminBase
{
	/** @var Config */
	protected $config;

	/** @var array */
	private $systemDatabases;

	/** @var array */
	private $systemSchemas;

	public function __construct(array $config = [])
	{
		$this->config = new Config($config);
	}

	public function getConfig(): Config
	{
		return $this->config;
	}

	public abstract function setOperators(?array $operators, ?string $likeOperator, ?string $regexpOperator): void;

	public abstract function getOperators(): ?array;

	public abstract function getLikeOperator(): ?string;

	public abstract function getRegexpOperator(): ?string;

	public function setSystemObjects(array $databases, array $schemas): void
	{
		$this->systemDatabases = $databases;
		$this->systemSchemas = $schemas;
	}

	public abstract function name();

	/**
	 * Returns connection parameters.
	 *
	 * @return string[] array($server, $username, $password)
	 */
	public function getCredentials(): array
	{
		$server = $this->config->getServer(SERVER);

		return [$server ? $server->getServer() : SERVER, $_GET["username"], get_password()];
	}

	/**
	 * Verifies given password if database itself does not require any password.
	 *
	 * @return true|string true for success, string for error message
	 */
	public function verifyDefaultPassword(string $password)
	{
		$hash = $this->config->getDefaultPasswordHash();
		if ($hash === null || $hash === "") {
			return lang('Database does not support password.');
		} elseif (!password_verify($password, $hash)) {
			return lang('Invalid server or credentials.');
		}

		return true;
	}

	/**
	 * Authenticate the user.
	 *
	 * @return bool|string true for success, string for error message, false for unknown error.
	 */
	public function authenticate(string $username, string $password)
	{
		if ($password == "") {
			$hash = $this->config->getDefaultPasswordHash();

			if ($hash === null) {
				return lang('AdminNeo does not support accessing a database without a password, <a href="https://www.adminer.org/en/password/"%s>more information</a>.', target_blank());
			} else {
				return $hash === "";
			}
		}

		return true;
	}

	public abstract function connectSsl();

	/**
	 * Gets a private key used for permanent login.
	 *
	 * @return string|false Cryptic string which gets combined with password or false in case of an error.
	 * @throws \Random\RandomException
	 */
	public function permanentLogin(bool $create = false)
	{
		return get_private_key($create);
	}

	public abstract function bruteForceKey();

	/**
	 * Returns server name displayed in breadcrumbs. Can be empty string.
	 */
	function getServerName(string $server): string
	{
		if ($server == "") {
			return "";
		}

		$serverObj = $this->config->getServer($server);

		return $serverObj ? $serverObj->getName() : $server;
	}

	public abstract function database();

	/**
	 * Returns cached list of databases.
	 */
	public function databases($flush = true): array
	{
		return $this->filterListWithWildcards(get_databases($flush), $this->config->getHiddenDatabases(), false, $this->systemDatabases);
	}

	/**
	 * Returns list of schemas.
	 */
	public function schemas(): array
	{
		return $this->filterListWithWildcards(schemas(), $this->config->getHiddenSchemas(), false, $this->systemSchemas);
	}

	public function collations(array $keepValues = []): array
	{
		$visibleCollations = $this->config->getVisibleCollations();
		$filterList = $visibleCollations ? array_merge($visibleCollations, $keepValues) : [];

		return $this->filterListWithWildcards(collations(), $filterList, true);
	}

	/**
	 * @param string[] $values
	 * @param string[] $filterList
	 * @param string[] $systemObjects
	 */
	private function filterListWithWildcards(array $values, array $filterList, bool $keeping, array $systemObjects = []): array
	{
		if (!$values || !$filterList) {
			return $values;
		}

		$index = array_search("__system", $filterList);
		if ($index !== false) {
			unset($filterList[$index]);
			$filterList = array_merge($filterList, $systemObjects);
		}

		array_walk($filterList, function (&$value) {
			$value = str_replace('\\*', ".*", preg_quote($value, "~"));
		});
		$pattern = '~^(' . implode("|", $filterList) . ')$~';

		return $this->filterListWithPattern($values, $pattern, $keeping);
	}

	private function filterListWithPattern(array $values, string $pattern, bool $keeping): array
	{
		$result = [];

		foreach ($values as $key => $value) {
			if (is_array($value)) {
				if ($subValues = $this->filterListWithPattern($value, $pattern, $keeping)) {
					$result[$key] = $subValues;
				}
			} elseif (($keeping && preg_match($pattern, $value)) || (!$keeping && !preg_match($pattern, $value))) {
				$result[$key] = $value;
			}
		}

		return $result;
	}

	public abstract function queryTimeout();

	public abstract function headers();

	/**
	 * Returns lists of directives for Content-Security-Policy HTTP header.
	 *
	 * @return string[] [directive name => allowed sources].
	 * @throws \Random\RandomException
	 */
	public function getCspHeader(): array
	{
		$frameAncestors = array_map(function ($source) {
			return $source == Config::SelfSource ? "'self'" : $source;
		}, $this->config->getFrameAncestors());

		return [
			// 'self' is a fallback for browsers not supporting 'strict-dynamic', 'unsafe-inline' is a fallback for browsers not supporting 'nonce-'
			"script-src" => "'self' 'unsafe-inline' 'nonce-" . get_nonce() . "' 'strict-dynamic'",
			"connect-src" => "'self' https://api.github.com/repos/adminneo-org/adminneo/releases/latest",
			"frame-src" => "'self'",
			"object-src" => "'none'",
			"base-uri" => "'none'",
			"form-action" => "'self'",
			"frame-ancestors" => $frameAncestors ? implode(" ", $frameAncestors) : "'none'",
		];
	}

	public abstract function head();

	/**
	 * Returns configured URLs of the CSS files together with autoloaded adminneo.css if exists.
	 *
	 * @return string[]
	 */
	public function getCssUrls(): array
	{
		$urls = $this->config->getCssUrls();

		foreach (["adminneo.css", "adminneo-light.css", "adminneo-dark.css"] as $filename) {
			if (file_exists($filename)) {
				$urls[] = "$filename?v=" . filemtime($filename);
			}
		}

		return $urls;
	}

	public function isLightModeForced(): bool
	{
		return file_exists("adminneo-light.css") && !file_exists("adminneo-dark.css");
	}

	public function isDarkModeForced(): bool
	{
		return file_exists("adminneo-dark.css") && !file_exists("adminneo-light.css");
	}

	/**
	 * Returns configured URLs of the JS files together with autoloaded adminneo.js if exists.
	 *
	 * @return string[]
	 */
	public function getJsUrls(): array
	{
		$urls = $this->config->getJsUrls();

		$filename = "adminneo.js";
		if (file_exists($filename)) {
			$urls[] = "$filename?v=" . filemtime($filename);
		}

		return $urls;
	}

	public abstract function loginForm();

	/**
	 * Returns composed row for login form field.
	 */
	public function composeLoginFormRow(string $fieldName, string $label, string $field): string
	{
		if ($label) {
			return "<tr><th>$label</th><td>$field</td></tr>\n";
		} else {
			return "$field\n";
		}
	}

	public abstract function tableName($tableStatus);

	public abstract function fieldName($field, $order = 0);

	public abstract function selectLinks($tableStatus, $set = "");

	/**
	 * Returns foreign keys for table.
	 */
	public function getForeignKeys(string $table): array
	{
		return foreign_keys($table);
	}

	public abstract function backwardKeys($table, $tableName);

	public abstract function backwardKeysPrint($backwardKeys, $row);

	public abstract function selectQuery($query, $start, $failed = false);

	public abstract function sqlCommandQuery($query);

	public abstract function rowDescription($table);

	public abstract function rowDescriptions($rows, $foreignKeys);

	public abstract function selectLink($val, $field);

	public abstract function selectVal($val, $link, $field, $original);

	public abstract function editVal($val, $field);

	public abstract function tableStructurePrint($fields);

	public abstract function tablePartitionsPrint($partition_info);

	public abstract function tableIndexesPrint($indexes);

	public abstract function selectColumnsPrint(array $select, array $columns);

	public abstract function selectSearchPrint(array $where, array $columns, array $indexes);

	public abstract function selectOrderPrint(array $order, array $columns, array $indexes);

	public abstract function selectLimitPrint(?int $limit): void;

	public abstract function selectLengthPrint($text_length);

	public abstract function selectActionPrint($indexes);

	public abstract function selectCommandPrint();

	public abstract function selectImportPrint();

	public abstract function selectEmailPrint($emailFields, $columns);

	public abstract function selectColumnsProcess($columns, $indexes);

	public abstract function selectSearchProcess($fields, $indexes);

	public abstract function selectOrderProcess($fields, $indexes);

	/**
	 * Processed limit box in select.
	 *
	 * @return ?int Expression to use in LIMIT, will be escaped.
	 */
	public function selectLimitProcess(): ?int
	{
		if (!isset($_GET["limit"])) {
			return $this->config->getRecordsPerPage();
		}

		return $_GET["limit"] != "" ? (int)$_GET["limit"] : null;
	}

	public abstract function selectLengthProcess();

	public abstract function selectEmailProcess($where, $foreignKeys);

	public abstract function messageQuery($query, $time, $failed = false);

	public abstract function editRowPrint($table, $fields, $row, $update);

	public abstract function editFunctions($field);

	public abstract function editInput($table, $field, $attrs, $value, $function);

	public abstract function editHint($table, $field, $value);

	public abstract function processInput(?array $field, $value, $function = "");

	public abstract function getDumpOutputs(): array;

	public abstract function getDumpFormats(): array;

	public abstract function sendDumpHeaders(string $identifier, bool $multiTable = false): string;

	/**
	 * Exports database structure.
	 */
	public function dumpDatabase(string $database): void
	{
		//
	}

	public abstract function dumpTable(string $table, string $style, int $viewType = 0): void;

	public abstract function dumpData(string $table, string $style, string $query): void;

	public abstract function importServerPath();

	public abstract function homepage();

	public abstract function navigation($missing);

	public abstract function databasesPrint($missing);

	public function printTablesFilter(): void
	{
		echo "<div class='tables-filter jsonly'>"
			. "<input id='tables-filter' type='search' class='input' autocomplete='off' placeholder='" . lang('Table') . "'>"
			. script("initTablesFilter(" . json_encode($this->database()) . ");")
			. "</div>\n";
	}

	public abstract function tablesPrint(array $tables);

	public abstract function foreignColumn($foreignKeys, $column): ?array;
}
