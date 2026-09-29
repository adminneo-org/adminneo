<?php

namespace AdminNeo;

/**
 * Adds option to export database structure and data to Markdown format. The export is meant for documentation
 * and not for importing back.
 *
 * Last changed in release: !compile: version
 *
 * @link https://www.adminneo.org/plugins/#usage
 *
 * @author Peter Knut
 *
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class MarkdownDumpPlugin extends Plugin
{
	/** @var string|null Currently exported database. */
	private $database = null;

	/** @var bool Whether the "Tables" heading was printed for the current database. */
	private $tablesHeading = false;

	/** @var bool Whether the "Views" heading was printed for the current database. */
	private $viewsHeading = false;

	/** @var string|null Table whose heading was printed last. */
	private $table = null;

	public function getDumpFormats(): array
	{
		return ['md' => 'Markdown'];
	}

	public function sendDumpFormatHeaders(string $identifier, bool $multiTable = false): ?string
	{
		if ($_POST["format"] != "md") {
			return null;
		}

		header("Content-Type: text/markdown; charset=utf-8");

		return "md";
	}

	public function dumpDatabase(string $database): ?bool
	{
		if ($_POST["format"] != "md") {
			return null;
		}

		$this->database = $database;
		$this->tablesHeading = false;
		$this->viewsHeading = false;
		$this->table = null;

		if ($_POST["db_style"]) {
			echo "# " . lang('Database') . " `$database`\n\n";
		}

		if ($_POST["types"]) {
			$this->dumpTypes();
		}
		if ($_POST["routines"]) {
			$this->dumpRoutines();
		}
		if ($_POST["events"]) {
			$this->dumpEvents();
		}

		return true;
	}

	private function dumpTypes(): void
	{
		$types = types();
		if (!$types) {
			return;
		}

		echo "## " . lang('User types') . "\n\n";
		echo "| " . lang('Name') . " | " . lang('Values') . " |\n";
		echo "| --- | --- |\n";

		foreach ($types as $id => $type) {
			echo "| " . $this->escape($type) . " | " . $this->escape(type_values($id)) . " |\n";
		}

		echo "\n";
	}

	private function dumpRoutines(): void
	{
		$routines = routines();
		if (!$routines) {
			return;
		}

		echo "## " . lang('Routines') . "\n\n";

		foreach ($routines as $row) {
			$name = $row["ROUTINE_NAME"];
			$type = $row["ROUTINE_TYPE"];

			echo "### " . lang('Routine') . " `$name`\n\n";
			if ($row["ROUTINE_COMMENT"] != "") {
				echo $this->paragraph($row["ROUTINE_COMMENT"]) . "\n\n";
			}

			$this->printCode(create_routine($type, ["name" => $name] + routine($row["SPECIFIC_NAME"], $type)));
		}
	}

	private function dumpEvents(): void
	{
		$events = get_rows("SHOW EVENTS");
		if (!$events) {
			return;
		}

		echo "## " . lang('Events') . "\n\n";

		foreach ($events as $row) {
			echo "### " . lang('Event') . " `$row[Name]`\n\n";

			$this->printCode(remove_definer(Connection::get()->getValue("SHOW CREATE EVENT " . idf_escape($row["Name"]), 3)));
		}
	}

	public function dumpTable(string $table, string $style, int $viewType = 0): ?bool
	{
		if ($_POST["format"] != "md") {
			return null;
		}

		// Views are exported at the end of the database, after all tables.
		if (!$style || $viewType == 2) {
			return true;
		}

		$isView = ($viewType == 1);
		$tableStatus = table_status1($table, !$_POST["auto_increment"]);

		$this->printTableHeading($table, $isView);

		if ($tableStatus["Comment"] != "") {
			echo $this->paragraph($tableStatus["Comment"]) . "\n\n";
		}

		$info = [];
		if (!preg_match("~sqlite|mssql|pgsql~", DIALECT) && isset($tableStatus["Engine"])) {
			$info[] = lang('Engine') . ": " . $tableStatus["Engine"];
		}
		if (isset($tableStatus["Collation"])) {
			$info[] = lang('Collation') . ": " . $tableStatus["Collation"];
		}
		if ($_POST["auto_increment"] && $tableStatus["Auto_increment"] != "") {
			$info[] = lang('Auto Increment') . ": " . $tableStatus["Auto_increment"];
		}
		if ($info) {
			echo implode(", ", $info) . "\n\n";
		}

		$this->printFields(fields($table));

		if ($isView && function_exists('AdminNeo\view')) {
			$this->printCode(view($table)["select"]);
		}

		if (support("indexes") && Driver::get()->supportsIndex($tableStatus)) {
			$this->printIndexes(indexes($table), $tableStatus);
		}

		if (!$isView) {
			if (fk_support($tableStatus)) {
				$this->printForeignKeys(foreign_keys($table));
			}
			if (support("check")) {
				$this->printChecks(Driver::get()->checkConstraints($table));
			}
		}

		if ($_POST["triggers"] && support($isView ? "view_trigger" : "trigger")) {
			$this->printTriggers($table, triggers($table));
		}

		return true;
	}

	public function dumpData(string $table, string $style, string $query): ?bool
	{
		if ($_POST["format"] != "md") {
			return null;
		}

		if (!$style) {
			return true;
		}

		$structure = ($this->table == $table);
		$this->printTableHeading($table, false);
		if ($structure) {
			echo "#### " . lang('Data') . "\n\n";
		}

		$result = Connection::get()->query($query, 1); // 1 - MYSQLI_USE_RESULT
		if ($result) {
			$fields = ($table != "" ? fields($table) : []);

			$header = false;
			while ($row = $result->fetchAssoc()) {
				if (!$header) {
					$numbers = [];
					foreach (array_keys($row) as $key) {
						$numbers[] = $this->isNumericColumn($key, $fields);
					}

					$this->printTableHeader(array_keys($row), $numbers);
					$header = true;
				}

				$values = [];
				foreach ($row as $value) {
					$values[] = $this->formatValue($value);
				}

				echo "| " . implode(" | ", $values) . " |\n";
			}

			if ($header) {
				echo "\n";
			}
		}

		return true;
	}

	/**
	 * Prints table heading together with the heading of its group if not printed yet.
	 */
	private function printTableHeading(string $table, bool $isView): void
	{
		if ($this->table == $table) {
			return;
		}

		if ($isView && !$this->viewsHeading) {
			echo "## " . lang('Views') . "\n\n";
			$this->viewsHeading = true;
		} elseif (!$isView && !$this->tablesHeading) {
			echo "## " . lang('Tables') . "\n\n";
			$this->tablesHeading = true;
		}

		echo "### " . ($isView ? lang('View') : lang('Table')) . " `$table`\n\n";
		$this->table = $table;
	}

	/**
	 * @param array[] $fields Result of fields().
	 */
	private function printFields(array $fields): void
	{
		$comments = support("comment");

		$header = [lang('Column'), lang('Type') . " [" . lang('default value') . "]", lang('Collation')];
		if ($comments) {
			$header[] = lang('Comment');
		}
		$this->printTableHeader($header);

		foreach ($fields as $field) {
			$type = $this->escape($field["full_type"]);
			if ($field["null"]) {
				$type .= " *NULL*";
			}
			if ($field["auto_increment"]) {
				$type .= " *" . lang('Auto Increment') . "*";
			}
			if (isset($field["default"])) {
				$default = ($field["generated"] ? $this->code($field["default"]) : $this->bold($field["default"]));
				$type .= " [$default]";
			}

			$cells = [$this->escape($field["field"]), $type, $this->escape($field["collation"])];
			if ($comments) {
				$cells[] = $this->escape($field["comment"]);
			}

			echo "| " . implode(" | ", $cells) . " |\n";
		}

		echo "\n";
	}

	/**
	 * @param array[] $indexes Result of indexes().
	 * @param array $tableStatus Result of table_status1().
	 */
	private function printIndexes(array $indexes, array $tableStatus): void
	{
		if (!$indexes) {
			return;
		}

		$defaultAlgorithm = first(Driver::get()->getIndexAlgorithms($tableStatus));

		$partial = false;
		foreach ($indexes as $index) {
			if ($index["partial"] ?? false) {
				$partial = true;
				break;
			}
		}

		echo "#### " . lang('Indexes') . "\n\n";

		$header = [lang('Name'), lang('Type'), lang('Columns')];
		if ($partial) {
			$header[] = lang('Condition');
		}
		$this->printTableHeader($header);

		foreach ($indexes as $name => $index) {
			ksort($index["columns"]); // enforce correct columns order

			$columns = [];
			foreach ($index["columns"] as $key => $column) {
				$columns[] = $this->escape($column) .
					($index["lengths"][$key] ? "(" . $index["lengths"][$key] . ")" : "") .
					($index["descs"][$key] ? " DESC" : "");
			}

			$type = $index["type"];
			if (isset($index["algorithm"]) && $index["algorithm"] != $defaultAlgorithm) {
				$type .= " ($index[algorithm])";
			}

			$cells = [$this->escape($name), $this->escape($type), implode(", ", $columns)];
			if ($partial) {
				$cells[] = ($index["partial"] ? $this->code("WHERE $index[partial]") : "");
			}

			echo "| " . implode(" | ", $cells) . " |\n";
		}

		echo "\n";
	}

	/**
	 * @param array[] $foreignKeys Result of foreign_keys().
	 */
	private function printForeignKeys(array $foreignKeys): void
	{
		if (!$foreignKeys) {
			return;
		}

		echo "#### " . lang('Foreign keys') . "\n\n";
		$this->printTableHeader([lang('Name'), lang('Source'), lang('Target'), lang('ON DELETE'), lang('ON UPDATE')]);

		foreach ($foreignKeys as $name => $foreignKey) {
			$db = $foreignKey["db"];
			$ns = $foreignKey["ns"];

			$target = ($db != "" && $db != $this->database ? "$db." : "") .
				($ns != "" && $ns != $_GET["ns"] ? "$ns." : "") .
				$foreignKey["table"] .
				" (" . implode(", ", $foreignKey["target"]) . ")";

			echo "| " . $this->escape($name) .
				" | " . $this->escape(implode(", ", $foreignKey["source"])) .
				" | " . $this->escape($target) .
				" | " . $this->escape($foreignKey["on_delete"]) .
				" | " . $this->escape($foreignKey["on_update"]) .
				" |\n";
		}

		echo "\n";
	}

	/**
	 * @param string[] $checks Result of Driver::checkConstraints().
	 */
	private function printChecks(array $checks): void
	{
		if (!$checks) {
			return;
		}

		echo "#### " . lang('Checks') . "\n\n";
		$this->printTableHeader([lang('Name'), lang('Condition')]);

		foreach ($checks as $name => $clause) {
			// SQLite does not return names, the clause is used as the key.
			echo "| " . $this->escape($name != $clause ? $name : "") .
				" | " . $this->code(preg_replace('~\s+~', ' ', trim($clause))) .
				" |\n";
		}

		echo "\n";
	}

	/**
	 * @param array[] $triggers Result of triggers().
	 */
	private function printTriggers(string $table, array $triggers): void
	{
		if (!$triggers) {
			return;
		}

		echo "#### " . lang('Triggers') . "\n\n";

		foreach (array_keys($triggers) as $name) {
			$trigger = trigger($name, $table);

			$definition = "$trigger[Timing] $trigger[Event]";
			if ($trigger["Of"] != "") {
				$definition .= " $trigger[Of]";
			}
			if ($trigger["Type"] != "") {
				$definition .= " $trigger[Type]";
			}

			echo $this->bold($name) . ": $definition\n\n";
			$this->printCode($trigger["Statement"]);
		}
	}

	/**
	 * Checks whether the column holds numbers to be aligned to the right, the same way as in the data selection.
	 *
	 * @param string $column Column name. An aggregated column is named by its expression, e.g. COUNT(*), or by the
	 *     function name only, depending on the driver.
	 * @param array[] $fields Fields returned from fields().
	 */
	private function isNumericColumn(string $column, array $fields): bool
	{
		if (isset($fields[$column])) {
			return $this->isNumericField($fields[$column]);
		}

		// These functions return a number for an argument of any type.
		if (preg_match('~^(CHAR_LENGTH|ROUND|FLOOR|CEIL|UNIX_TIMESTAMP|TIME_TO_SEC|COUNT|SUM)(\(|$)~i', $column)) {
			return true;
		}

		// These functions return the same type as their argument.
		if (preg_match('~^(?:AVG|MIN|MAX)\((.+)\)~i', $column, $match)) {
			$name = idf_unescape($match[1]);

			return $this->isNumericField($fields[$name] ?? null);
		}

		return false;
	}

	/**
	 * Checks whether the field holds numbers.
	 *
	 * @param ?array $field Single field returned from fields().
	 */
	private function isNumericField(?array $field): bool
	{
		// An array of numbers is printed as a text.
		return $field && preg_match(number_type(), $field["type"]) && !preg_match('~\[~', $field["full_type"]);
	}

	/**
	 * Prints the header row of a table.
	 *
	 * @param string[] $cells Raw cell texts.
	 * @param bool[] $rightAligned Columns to be aligned to the right, indexed the same way as the cells.
	 */
	private function printTableHeader(array $cells, array $rightAligned = []): void
	{
		echo "| " . implode(" | ", array_map([$this, 'escape'], $cells)) . " |\n";

		echo "|";
		foreach (array_keys($cells) as $key) {
			echo ($rightAligned[$key] ?? false) ? " ---: |" : " --- |";
		}
		echo "\n";
	}

	private function printCode(string $code): void
	{
		echo "```sql\n$code\n```\n\n";
	}

	/**
	 * Formats data value for a table cell.
	 */
	private function formatValue($value): string
	{
		if ($value === null) {
			return "*NULL*";
		}

		$value = (string)$value;
		if (!is_utf8($value)) {
			return "*" . lang('%d byte(s)', strlen($value)) . "*";
		}

		return $this->escape($value);
	}

	/**
	 * Escapes text to be used in a table cell. Inline formatting, HTML tags and entities are escaped to not be
	 * interpreted by the Markdown renderer.
	 */
	private function escape(?string $text): string
	{
		$text = preg_replace('#[\\\\`*~\[\]<|]#', '\\\\$0', (string)$text);
		// Underscore between two alphanumeric characters cannot start or end an emphasis.
		$text = preg_replace('~(?<![^\W_])_|_(?![^\W_])~', '\\\\_', $text);
		$text = preg_replace('~&(?=#?\w+;)~', '\\\\&', $text);

		return preg_replace('~\r\n|\r|\n~', "<br>", $text);
	}

	/**
	 * Escapes text to be used as a paragraph. Block formatting is escaped at the beginning of the text, the newlines
	 * are converted to line breaks, so they cannot start a block.
	 */
	private function paragraph(string $text): string
	{
		$text = $this->escape(trim($text));

		return preg_replace(['~^[#>+-]~', '~^(\d+)([.)])~'], ['\\\\$0', '$1\\\\$2'], $text);
	}

	/**
	 * Formats text as bold usable in a table cell.
	 */
	private function bold(string $text): string
	{
		$text = $this->escape($text);

		return ($text != "" ? "**$text**" : "");
	}

	/**
	 * Formats text as an inline code usable in a table cell.
	 */
	private function code(string $text): string
	{
		// Delimiter must be longer than any sequence of backticks inside the code.
		preg_match_all('~`+~', $text, $matches);
		$length = ($matches[0] ? max(array_map('strlen', $matches[0])) + 1 : 1);

		$delimiter = str_repeat("`", $length);
		$padding = ($length > 1 ? " " : "");

		// Backslash escapes are not interpreted inside the code, but an escaped pipe is.
		$text = str_replace("|", "\\|", preg_replace('~\s*\R\s*~', " ", $text));

		return "$delimiter$padding$text$padding$delimiter";
	}
}
