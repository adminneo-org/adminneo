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

	/**
	 * Sends additional HTTP headers.
	 */
	public function sendHeaders(): void
	{
		//
	}

	/**
	 * Returns lists of directives for Content-Security-Policy HTTP header.
	 *
	 * @var string[] $csp [directive name => allowed sources].
	 */
	public function updateCspHeader(array &$csp): void
	{
		//
	}

	public function printFavicons(): void
	{
		$colorVariant = $this->getConfig()->getColorVariant();

		// https://evilmartians.com/chronicles/how-to-favicon-in-2021-six-files-that-fit-most-needs
		// Converting PNG to ICO: https://redketchup.io/icon-converter
		echo "<link rel='icon' type='image/x-icon' href='", link_files("favicon-$colorVariant.ico", ["../admin/images/variants/favicon-$colorVariant.ico"]), "' sizes='32x32'>\n";
		echo "<link rel='icon' type='image/svg+xml' href='", link_files("favicon-$colorVariant.svg", ["../admin/images/variants/favicon-$colorVariant.svg"]), "'>\n";
		echo "<link rel='apple-touch-icon' href='", link_files("apple-touch-icon-$colorVariant.png", ["../admin/images/variants/apple-touch-icon-$colorVariant.png"]), "'>\n";
	}


	public abstract function printToHead(): void;

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

	/**
	 * Returns table name used in navigation and headings.
	 *
	 * @param array $tableStatus The result of SHOW TABLE STATUS.
	 *
	 * @return string HTML code, "" to ignore table
	 */
	public function getTableName(array $tableStatus): string
	{
		return h($tableStatus["Name"]);
	}

	public abstract function getFieldName(array $field, int $order = 0): string;

	/**
	 * Returns formatted comment.
	 *
	 * @return string HTML to be printed.
	 */
	public function formatComment(?string $comment): string
	{
		return h($comment);
	}

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

	public abstract function formatSelectQuery(string $query, float $start, bool $failed = false): string;

	public abstract function formatMessageQuery(string $query, string $time, bool $failed = false): string;

	public abstract function formatSqlCommandQuery(string $query): string;

	public abstract function rowDescription($table);

	public abstract function rowDescriptions($rows, $foreignKeys);

	/**
	 * Returns a link to use in select table.
	 *
	 * @param string|int|null $val Raw value of the field.
	 * @param ?array $field Single field returned from fields(). Null for aggregated field.
	 */
	public function getFieldValueLink($val, ?array $field): ?string
	{
		if (is_mail($val)) {
			return "mailto:$val";
		}
		if (is_web_url($val)) {
			return $val;
		}

		return null;
	}

	public abstract function selectVal($val, $link, $field, $original);

	public abstract function formatFieldValue($value, array $field): ?string;

	public abstract function printTableStructure(array $fields): void;

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

	public abstract function editRowPrint($table, $fields, $row, $update);

	public abstract function editFunctions($field);

	public abstract function getFieldInput(string $table, array $field, string $attrs, $value, ?string $function): string;

	/**
	 * Returns hint for edit field.
	 *
	 * @param string $table Table name.
	 * @param array $field Single field from fields().
	 * @param string $value Field value.
	 *
	 * @return string HTML code.
	 */
	public function getFieldInputHint(string $table, array $field, ?string $value): string
	{
		return support("comment") ? $this->formatComment($field["comment"]) : "";
	}

	public abstract function processInput(?array $field, $value, $function = "");

	/**
	 * Detect JSON field or value and optionally reformat the value.
	 *
	 * @param string $fieldType
	 * @param mixed $value
	 * @param bool|null $pretty True to pretty format, false to compact format, null to skip formatting.
	 *
	 * @return bool Whether field or value are detected as JSON.
	 */
	public function detectJson(string $fieldType, &$value, ?bool $pretty = null): bool
	{
		if (is_array($value)) {
			$flags = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | ($this->getConfig()->isJsonValuesAutoFormat() ? JSON_PRETTY_PRINT : 0);
			$value = json_encode($value, $flags);
			return true;
		}

		$flags = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | ($pretty ? JSON_PRETTY_PRINT : 0);

		if (str_contains($fieldType, "json")) {
			if ($pretty !== null && $this->getConfig()->isJsonValuesAutoFormat()) {
				$value = json_encode(json_decode($value), $flags);
			}

			return true;
		}

		if (!$this->config->isJsonValuesDetection()) {
			return false;
		}

		if (
			$value != "" &&
			preg_match('~varchar|text|character varying|String~', $fieldType) &&
			($value[0] == "{" || $value[0] == "[") &&
			($json = json_decode($value))
		) {
			if ($pretty !== null && $this->getConfig()->isJsonValuesAutoFormat()) {
				$value = json_encode($json, $flags);
			}

			return true;
		}

		return false;
	}

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
