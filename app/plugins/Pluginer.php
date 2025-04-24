<?php

namespace AdminNeo;

/**
 * Admin/Editor customization allowing usage of plugins.
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 * @author Peter Knut
 *
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class Pluginer extends Admin
{
	/** @var array|null */
	private $plugins;

	/**
	 * @param array $plugins List of plugin instances.
	 */
	public function __construct(array $plugins, array $config = [])
	{
		parent::__construct($config);

		$this->plugins = $plugins;

		//! it is possible to use ReflectionObject to find out which plugins defines which methods at once
	}

	// appendPlugin

	public function editRowPrint($table, $fields, $row, $update)
	{
		return $this->appendPlugin(__FUNCTION__, func_get_args());
	}

	public function editFunctions($field)
	{
		return $this->appendPlugin(__FUNCTION__, func_get_args());
	}

	// applyPlugin

	public function init(): void
	{
		$this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function name()
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function getCredentials(): array
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function authenticate(string $username, string $password)
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function getPrivateKey(bool $create = false)
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function getBruteForceKey(): string
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function getServerName(string $server): string
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function getDatabase(): ?string
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function getDatabases($flush = true): array
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function getSchemas(): array
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function getCollations(array $keepValues = []): array
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function queryTimeout()
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function sendHeaders(): void
	{
		$this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function updateCspHeader(array &$csp): void
	{
		$args = func_get_args();
		$this->applyPluginRef(__FUNCTION__, $args);

		$csp = $args[0];
	}

	public function printFavicons(): void
	{
		$this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function printToHead(): void
	{
		$this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function printLoginForm(): void
	{
		$this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function getLoginFormRow(string $fieldName, string $label, string $field): string
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function printLogout(): void
	{
		$this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function getTableName(array $tableStatus): string
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function getFieldName(array $field, int $order = 0): string
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function formatComment(?string $comment): string
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function printTableMenu(array $tableStatus, ?string $set = ""): void
	{
		$this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function getForeignKeys(string $table): array
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function getBackwardKeys(string $table, string $tableName): array
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function printBackwardKeys(array $backwardKeys, array $row): void
	{
		$this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function formatSelectQuery(string $query, float $start, bool $failed = false): string
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function formatMessageQuery(string $query, string $time, bool $failed = false): string
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function formatSqlCommandQuery(string $query): string
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function getTableDescriptionFieldName(string $table): string
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function fillForeignDescriptions(array $rows, array $foreignKeys): array
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function getFieldValueLink($val, ?array $field): ?string
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function formatSelectionValue(?string $val, ?string $link, ?array $field, ?string $original): string
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function formatFieldValue($value, array $field): ?string
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function printTableStructure(array $fields): void
	{
		$this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function printTablePartitions(array $partitionInfo): void
	{
		$this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function printTableIndexes(array $indexes): void
	{
		$this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function printSelectionColumns(array $select, array $columns): void
	{
		$this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function printSelectionSearch(array $where, array $columns, array $indexes): void
	{
		$this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function printSelectionOrder(array $order, array $columns, array $indexes): void
	{
		$this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function printSelectionLimit(?int $limit): void
	{
		$this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function printSelectionLength(?string $textLength): void
	{
		$this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function printSelectionAction(array $indexes): void
	{
		$this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function isDataEditAllowed(): bool
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function processSelectionColumns(array $columns, array $indexes): array
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function processSelectionSearch(array $fields, array $indexes): array
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function processSelectionOrder(array $fields, array $indexes): array
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function processSelectionLimit(): ?int
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function processSelectionLength(): string
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function getFieldInput(string $table, array $field, string $attrs, $value, ?string $function): string
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function getFieldInputHint(string $table, array $field, ?string $value): string
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function processFieldInput(?array $field, string $value, string $function = ""): string
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function getDumpOutputs(): array
	{
		return $this->appendPlugin(__FUNCTION__, func_get_args());
	}

	public function getDumpFormats(): array
	{
		return $this->appendPlugin(__FUNCTION__, func_get_args());
	}

	public function sendDumpHeaders(string $identifier, bool $multiTable = false): string
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function dumpDatabase(string $database): void
	{
		$this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function dumpTable(string $table, string $style, int $viewType = 0): void
	{
		$this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function dumpData(string $table, string $style, string $query): void
	{
		$this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function getImportFilePath(): string
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function printDatabaseMenu(): void
	{
		$this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function printNavigation(?string $missing): void
	{
		$this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function printDatabaseSwitcher(?string $missing): void
	{
		$this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function printTablesFilter(): void
	{
		$this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function printTableList(array $tables): void
	{
		$this->applyPlugin(__FUNCTION__, func_get_args());
	}

	public function getForeignColumnInfo(array $foreignKeys, string $column): ?array
	{
		return $this->applyPlugin(__FUNCTION__, func_get_args());
	}

	private function appendPlugin(string $function, array $args)
	{
		$return = $this->callParent($function, $args);

		foreach ($this->plugins as $plugin) {
			if (!method_exists($plugin, $function)) {
				continue;
			}

			$value = call_user_func_array([$plugin, $function], $args);
			if ($value) {
				$return += $value;
			}
		}

		return $return;
	}

	private function applyPlugin(string $function, array $args)
	{
		return $this->applyPluginRef($function, $args);
	}

	private function applyPluginRef(string $function, array &$args)
	{
		if (count($args) > 6) {
			trigger_error('Too many parameters.', E_USER_WARNING);
		}

		foreach ($this->plugins as $plugin) {
			if (!method_exists($plugin, $function)) {
				continue;
			}

			// Method call_user_func_array() doesn't work well with references.
			switch (count($args)) {
				case 0:
					$return = $plugin->$function();
					break;
				case 1:
					$return = $plugin->$function($args[0]);
					break;
				case 2:
					$return = $plugin->$function($args[0], $args[1]);
					break;
				case 3:
					$return = $plugin->$function($args[0], $args[1], $args[2]);
					break;
				case 4:
					$return = $plugin->$function($args[0], $args[1], $args[2], $args[3]);
					break;
				case 5:
					$return = $plugin->$function($args[0], $args[1], $args[2], $args[3], $args[4]);
					break;
				case 6:
					$return = $plugin->$function($args[0], $args[1], $args[2], $args[3], $args[4], $args[5]);
					break;
				default:
					$return = null;
					break;
			}

			if ($return !== null) {
				return $return;
			}
		}

		return $this->callParent($function, $args);
	}

	public function callParent(string $function, array &$args = [])
	{
		// Method call_user_func_array() doesn't work well with references.
		switch (count($args)) {
			case 0:
				return parent::$function();
			case 1:
				return parent::$function($args[0]);
			case 2:
				return parent::$function($args[0], $args[1]);
			case 3:
				return parent::$function($args[0], $args[1], $args[2]);
			case 4:
				return parent::$function($args[0], $args[1], $args[2], $args[3]);
			case 5:
				return parent::$function($args[0], $args[1], $args[2], $args[3], $args[4]);
			case 6:
				return parent::$function($args[0], $args[1], $args[2], $args[3], $args[4], $args[5]);
			default:
				return null;
		}
	}
}
