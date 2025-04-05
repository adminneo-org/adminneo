<?php

namespace AdminNeo;

class Admin extends AdminBase
{
	/** @var ?array operators used in select, null for all operators */
	private $operators = null;
	/** @var ?string operator for LIKE condition */
	private $likeOperator = null;
	/** @var ?string operator for regular expression condition */
	private $regexpOperator = null;

	public function setOperators(?array $operators, ?string $likeOperator, ?string $regexpOperator): void
	{
		$this->operators = $operators;
		$this->likeOperator = $likeOperator;
		$this->regexpOperator = $regexpOperator;
	}

    public function getOperators(): ?array
	{
		return $this->operators;
	}

	public function getLikeOperator(): ?string
	{
		return $this->likeOperator;
	}

	public function getRegexpOperator(): ?string
	{
		return $this->regexpOperator;
	}

	/** Name in title and navigation
	* @return string HTML code
	*/
	function name() {
		return "<a href='" . h(HOME_URL) . "'><svg role='img' class='logo' width='133' height='28'><desc>AdminNeo</desc><use href='" . link_files("logo.svg", ["images/logo.svg"]) . "#logo'/></svg></a>";
	}

	/**
	 * Returns the name of selected database.
	 *
	 * @return string
	 */
	public function getDatabase(): ?string
	{
		return DB;
	}

	/**
	 * Specifies the limit for waiting on some slow queries like DB list.
	 *
	 * @return int Number of seconds.
	 */
	public function getQueryTimeout(): int
	{
		return 2;
	}

	/**
	 * Prints additional HTML code at the end of the <head>.
	 */
	public function printToHead(): void
	{
		echo "<link rel='stylesheet' href='", link_files("jush.css", ["../vendor/vrana/jush/jush.css"]), "'>";

		if (!$this->isLightModeForced()) {
			echo "<link rel='stylesheet' " . (!$this->isDarkModeForced() ? "media='(prefers-color-scheme: dark)' " : "") . "href='";
			echo link_files("jush-dark.css", ["../vendor/vrana/jush/jush-dark.css"]);
			echo "'>\n";
		}

		echo script_src(link_files("jush.js", [
			"../vendor/vrana/jush/modules/jush.js",
			"../vendor/vrana/jush/modules/jush-textarea.js",
			"../vendor/vrana/jush/modules/jush-sql.js",
			"../vendor/vrana/jush/modules/jush-pgsql.js",
			"../vendor/vrana/jush/modules/jush-mssql.js",
			"../vendor/vrana/jush/modules/jush-oracle.js",
			"../vendor/vrana/jush/modules/jush-simpledb.js",
			"../vendor/vrana/jush/modules/jush-js.js",
		]));
	}

	/**
	 * Prints login form.
	 */
	public function printLoginForm(): void
	{
		global $drivers;

		$serverPairs = $this->config->getServerPairs($drivers);

		echo "<table class='box'>\n";
		if ($serverPairs) {
			echo $this->getLoginFormRow('server', lang('Server'), "<select name='auth[server]'>" . optionlist($serverPairs, SERVER, true) . "</select>");
		} else {
			$driver = DRIVER ?: $this->getConfig()->getDefaultDriver($drivers);

			if (count($drivers) > 1) {
				echo $this->getLoginFormRow('driver', lang('System'), html_select("auth[driver]", $drivers, $driver) . script("initLoginDriver(qsl('select'));", ""));
			} else {
				echo $this->getLoginFormRow('driver', '', '<input type="hidden" name="auth[driver]" value="' . h($driver) . '">');
			}

			echo $this->getLoginFormRow('server', lang('Server'), '<input class="input" name="auth[server]" value="' . h(SERVER) . '" title="hostname[:port]" placeholder="localhost" autocapitalize="off">');
		}

		echo $this->getLoginFormRow('username', lang('Username'), '<input class="input" name="auth[username]" id="username" value="' . h($_GET["username"]) . '" autocomplete="username" autocapitalize="off">');
		echo $this->getLoginFormRow('password', lang('Password'), '<input type="password" class="input" name="auth[password]" autocomplete="current-password">');

		if (!$serverPairs) {
			echo $this->getLoginFormRow('db', lang('Database'), '<input class="input" name="auth[db]" value="' . h($_GET["db"]) . '" autocapitalize="off">');
		}
		echo "</table>\n";

		echo "<p>";
		echo "<input type='submit' class='button default' value='" . lang('Login') . "'>";
		echo checkbox("auth[permanent]", 1, $_COOKIE["neo_permanent"], lang('Permanent login'));
		echo "</p>\n";
	}

	/**
	 * Returns field name used in select and edit.
	 *
	 * @param array $field Single field returned from fields().
	 * @param int $order Order of column in select.
	 *
	 * @return string HTML code, "" to ignore field.
	 */
	public function getFieldName(array $field, int $order = 0): string
	{
		return '<span title="' . h($field["full_type"]) . '">' . h($field["field"]) . '</span>';
	}

	/**
	 * Prints top menu for table selection and structure page.
	 *
	 * @param array $tableStatus The result of SHOW TABLE STATUS.
	 * @param string $set New item options, NULL for no new item.
	 */
	public function printTableMenu(array $tableStatus, string $set = ""): void
	{
		global $jush, $driver;

		echo '<p class="links top-tabs">';

		$links = [];

		$selectionFirst = ($this->config->isSelectionPreferred() && !$this->config->isNavigationReversed()) ||
			(!$this->config->isSelectionPreferred() && $this->config->isNavigationReversed());

		if ($selectionFirst) {
			$links["select"] = [lang('Select data'), "data"];
		}

		if (support("table") || support("indexes")) {
			$links["table"] = [lang('Show structure'), "structure"];
		}

		if (!$selectionFirst) {
			$links["select"] = [lang('Select data'), "data"];
		}

		$is_view = false;
		if (support("table")) {
			$is_view = is_view($tableStatus);
			if ($is_view) {
				$links["view"] = [lang('Alter view'), "edit"];
			} else {
				$links["create"] = [lang('Alter table'), "edit"];
			}
		}

		if ($set !== null) {
			$links["edit"] = [lang('New item'), "item-add"];
		}

		$table = $tableStatus["Name"];
		foreach ($links as $key => $val) {
			echo " <a href='", h(ME), "$key=", urlencode($table), ($key == "edit" ? $set : ""), "'", bold(isset($_GET[$key])), ">", icon($val[1]), "$val[0]</a>";
		}

		echo doc_link([$jush => $driver->tableHelp($table, $is_view)], "?");
		echo "\n";
	}

	/**
	 * Returns backward keys for given table.
	 *
	 * @return array $return[$target_table]["keys"][$key_name][$target_column] = $source_column; $return[$target_table]["name"] = $this->getTableName($target_table);
	 */
	public function getBackwardKeys(string $table, string $tableName): array
	{
		return [];
	}

	/**
	 * Prints backward keys for given row.
	 *
	 * @param array $backwardKeys The result of getBackwardKeys().
	 */
	public function printBackwardKeys(array $backwardKeys, array $row): void
	{
		//
	}

	/**
     * Returns formatted query that will be printed in "Select data" page before its execution.
     * Query printed in select before execution.
     *
	 * @param string $query Query to be executed.
	 * @param float $start Start time.
	 * @param bool $failed Whether the execution failed.
	 *
 	 * @return string HTML to be printed.
	 */
	public function formatSelectQuery(string $query, float $start, bool $failed = false): string
	{
		global $jush, $driver;

		$supportSql = support("sql");
		$warnings = !$failed ? $driver->warnings() : null;

		$return = "<pre><code class='jush-$jush'>" . h(str_replace("\n", " ", $query)) . "</code></pre>\n";

        $return .= "<p class='links'>";
        if ($supportSql) {
			$return .= "<a href='" . h(ME) . "sql=" . urlencode($query) . "'>" . icon("edit") . lang('Edit') . "</a>";
		}
        if ($warnings) {
			$return .= "<a href='#warnings' class='toggle'>" . lang('Warnings') . icon_chevron_down() . "</a>";
        }
        $return .= " <span class='time'>(" . format_time($start) . ")</span>";
		$return .= "</p>\n";

		if ($warnings) {
			$return .= script("initToggles(qsl('p'));");
			$return .= "<div id='warnings' class='warnings hidden'>\n$warnings\n</div>\n";
		}

		return $return;
	}

	/**
	 * Returns formatted query that will be printed in message after its execution.
	 *
	 * @param string $query Query to be executed.
	 * @param string $time Formatted elapsed time.
	 * @param bool $failed Whether the execution failed.
	 *
	 * @return string HTML to be printed.
	 */
	public function formatMessageQuery(string $query, string $time, bool $failed = false): string
	{
		global $jush, $driver;

		restart_session();

		$history = &get_session("queries");
		if (!isset($history[$_GET["db"]])) {
			$history[$_GET["db"]] = [];
		}

		if (strlen($query) > 1e6) {
			$query = preg_replace('~[\x80-\xFF]+$~', '', substr($query, 0, 1e6)) . "\n…"; // [\x80-\xFF] - valid UTF-8, \n - can end by one-line comment
		}

		$history[$_GET["db"]][] = [$query, time(), $time]; // not DB - $_GET["db"] is changed in database.inc.php //! respect $_GET["ns"]

		$supportSql = support("sql");
		$warnings = !$failed ? $driver->warnings() : null;

		$sqlId = "sql-" . count($history[$_GET["db"]]);
		$warningsId = "warnings-" . count($history[$_GET["db"]]);

		$return = " ";
		if ($warnings) {
			$return .= "<a href='#$warningsId' class='toggle'>" . lang('Warnings') . icon_chevron_down() . "</a>, ";
		}
		$return .= "<a href='#$sqlId' class='toggle'>" . lang('SQL command') . icon_chevron_down() . "</a>";
		$return .= " <span class='time'>" . @date("H:i:s") . "</span>\n"; // @ - time zone may be not set

		if ($warnings) {
			$return .= "<div id='$warningsId' class='warnings hidden'>\n$warnings</div>\n";
		}

		$return .= "<div id='$sqlId' class='hidden'>\n";
		$return .= "<pre><code class='jush-$jush'>" . truncate_utf8($query, 1000) . "</code></pre>\n";

		$return .= "<p class='links'>";
		if ($supportSql) {
			$return .= "<a href='" . h(str_replace("db=" . urlencode(DB), "db=" . urlencode($_GET["db"]), ME) . 'sql=&history=' . (count($history[$_GET["db"]]) - 1)) . "'>" . icon("edit") . lang('Edit') . "</a>";
		}
		if ($time) {
			$return .= " <span class='time'>($time)</span>";
		}
		$return .= "</p>\n";
		$return .= "</div>\n";

		return $return;
	}

	/**
	 * Returns formatted query that will be printed in "SQL command" page before its execution.
	 *
	 * @param string $query Query to be executed.
	 *
	 * @return string HTML to be printed.
	 */
	public function formatSqlCommandQuery(string $query): string
	{
		if (preg_match('~^DELIMITER\s~i', $query)) {
			return "";
		}

		return truncate_utf8($query, 1000);
	}

	/**
	 * Returns field name that will be used for getting a foreign key description.
	 *
	 * @return string SQL expression, empty string for no description.
	 */
	public function getTableDescriptionFieldName(string $table): string
	{
		return "";
	}

	/**
	 * Fill descriptions of the foreign keys for the whole selection data.
	 *
	 * @param array $rows All selection data to print.
	 *
	 * @return array Updated selection data.
	 */
	public function fillForeignDescriptions(array $rows, array $foreignKeys): array
	{
		return $rows;
	}

	/**
	 * Formats field value for select table.
	 *
	 * @param ?string $val HTML-escaped value to print.
	 * @param ?string $link Link to foreign key.
	 * @param ?array $field Single field returned from fields().
	 * @param ?string $original Original value before applying formatFieldValue() and escaping.
	 */
	public function formatSelectionValue(?string $val, ?string $link, ?array $field, ?string $original): string
	{
		if ($val === null) {
			$text = "<i>NULL</i>";
		} elseif (!$field) {
			$text = $val;
		} elseif (preg_match("~char|binary|boolean~", $field["type"]) && !preg_match("~var~", $field["type"])) {
			$text = "<code>$val</code>";
		} elseif (preg_match('~blob|bytea|raw|file~', $field["type"]) && !is_utf8($val)) {
			$text = "<i>" . lang('%d byte(s)', strlen($original)) . "</i>";
		} elseif ($this->detectJson($field["type"], $original)) {
			$text = "<code class='jush-js'>$val</code>";
		} else {
			$text = $val;
		}

		if ($link) {
			$text = "<a href='" . h($link) . "'" . (is_web_url($link) ? target_blank() : "") . ">$text</a>";
		}

		return $text;
	}

	/**
	 * Formats field value for select table and edit form.
	 *
	 * @param string|bool|null $value Field value.
	 * @param array $field Single field returned from fields().
	 *
	 * @return ?string
	 */
	public function formatFieldValue($value, array $field): ?string
	{
		// Format Elasticsearch boolean value, but do not touch PostgreSQL boolean that use string value 't' or 'f'.
		if ($field && $field["type"] == "boolean" && is_bool($value)) {
			return $value ? "true" : "false";
		}

		return $value;
	}

	/**
	 * Prints table structure in tabular format.
	 *
	 * @param array $fields Data about individual fields.
	 */
	public function printTableStructure(array $fields): void
	{
		global $structured_types, $jush;

		echo "<div class='scrollable'>\n";
		echo "<table class='nowrap'>\n";

		echo "<thead><tr><th>", lang('Column'), "</th><td>", lang('Type'), "</td><td>", lang('Collation'), "</td>",
			(support("comment") ? "<td>" . lang('Comment') . "</td>" : ""), "</thead>\n";

		foreach ($fields as $field) {
			echo "<tr>";
			echo "<th>", h($field["field"]), "</th>";
			echo "<td>";

			$type = h($field["full_type"]);
			if (in_array($type, (array) $structured_types[lang('User types')])) {
				echo "<a href='" . h(ME . 'type=' . urlencode($type)) . "'>$type</a>";
			} else {
				echo $type;
			}

			if ($field["null"]) {
				echo " <i>NULL</i>";
			}
			if ($field["auto_increment"]) {
				echo " <i>" . lang('Auto Increment') . "</i>";
			}

			$default = h($field["default"]);
			if (isset($field["default"])) {
				echo " <span title='" . lang('Default value') . "'>[<b>";
				echo $field["generated"] ? "<code class='jush-$jush'>$default</code>" : $default;
				echo "</b>]</span>";
			}

			echo "</td>";

			echo "<td>", h($field["collation"]), "</td>";

			if (support("comment")) {
				echo "<td>", $this->formatComment($field["comment"]), "</td>";
			}

			echo "\n";
		}

		echo "</table>\n";
		echo "</div>\n";
	}

	function tablePartitionsPrint($partition_info) {
		$showList = $partition_info["partition_by"] == "RANGE" || $partition_info["partition_by"] == "LIST";

		echo "<p>";
		echo "<code>{$partition_info["partition_by"]} ({$partition_info["partition"]})</code>";
		if (!$showList) {
			echo " " . lang('Partitions') . ": " . h($partition_info["partitions"]);
		}
		echo "</p>";

		if ($showList) {
			echo "<table>\n";
			echo "<thead><tr><th>" . lang('Partition') . "</th><td>" . lang('Values') . "</td></tr></thead>\n";

			foreach ($partition_info["partition_names"] as $key => $name) {
				echo "<tr><th>" . h($name) . "</th><td>" . h($partition_info["partition_values"][$key]) . "\n";
			}

			echo "</table>\n";
		}
	}

	/** Print list of indexes on table in tabular format
	* @param array data about all indexes on a table
	* @return null
	*/
	function tableIndexesPrint($indexes) {
		echo "<table>\n";
		echo "<thead><tr><th>" . lang('Type') . "</th><td>" . lang('Column') . " (" . lang('length') . ")</td></tr></thead>\n";

		foreach ($indexes as $name => $index) {
			ksort($index["columns"]); // enforce correct columns order
			$print = [];

			foreach ($index["columns"] as $key => $val) {
				$print[] = "<i>" . h($val) . "</i>"
					. ($index["lengths"][$key] ? "(" . $index["lengths"][$key] . ")" : "")
					. ($index["descs"][$key] ? " DESC" : "")
				;
			}
			echo "<tr title='" . h($name) . "'><th>$index[type]<td>" . implode(", ", $print) . "\n";
		}

		echo "</table>\n";
	}

	/**
	 * Prints columns box in select filter.
	 *
	 * @param array $select result of selectColumnsProcess()[0]
	 * @param array $columns selectable columns
	 */
	function selectColumnsPrint(array $select, array $columns) {
		global $functions, $grouping;

		print_fieldset_start("select", lang('Select'), "columns", (bool)$select, true);

		$_GET["columns"][""] = [];
		$i = 0;

		foreach ($_GET["columns"] as $key => $val) {
			if ($key != "" && ($val["col"] ?? null) == "") continue;

			$column = select_input(
				"name='columns[$i][col]'",
				$columns,
				$val["col"] ?? null,
				$key !== "" ? "selectFieldChange" : "selectAddRow"
			);

			echo "<div ", ($key != "" ? "" : "class='no-sort'"), ">",
				icon("handle", "handle jsonly");

			if ($functions || $grouping) {
				echo "<select name='columns[$i][fun]'>",
					optionlist([-1 => ""] + array_filter([lang('Functions') => $functions, lang('Aggregation') => $grouping]), $val["fun"]),
					"</select>",
					help_script_command("value && value.replace(/ |\$/, '(') + ')'", true),
					script("qsl('select').onchange = (event) => { " . ($key !== "" ? "" : " qsl('select, input:not(.remove)', event.target.parentNode).onchange();") . " };", ""),
					"($column)";
			} else {
				echo $column;
			}

			echo " <button class='button light remove jsonly' title='" . h(lang('Remove')) . "'>", icon_solo("remove"), "</button>",
				script("qsl('#fieldset-select .remove').onclick = selectRemoveRow;", ""),
				"</div>\n";

			$i++;
		}

		print_fieldset_end("select", true);
	}

	/**
	 * Prints search box in select.
	 *
	 * @param array $where result of selectSearchProcess()
	 * @param array $columns selectable columns
	 */
	function selectSearchPrint(array $where, array $columns, array $indexes) {
		print_fieldset_start("search", lang('Search'), "search", (bool)$where);

		foreach ($indexes as $i => $index) {
			if ($index["type"] == "FULLTEXT") {
				echo "<div>(<i>" . implode("</i>, <i>", array_map('AdminNeo\h', $index["columns"])) . "</i>) AGAINST";
				echo "<input type='search' class='input' name='fulltext[$i]' value='" . h($_GET["fulltext"][$i] ?? null) . "'>";
				echo script("qsl('input').oninput = selectFieldChange;", "");
				echo checkbox("boolean[$i]", 1, isset($_GET["boolean"][$i]), "BOOL");
				echo "</div>\n";
			}
		}

		$change_next = "this.parentNode.firstChild.onchange();";
		foreach (array_merge((array) $_GET["where"], [[]]) as $i => $val) {
			if (!$val || ("$val[col]$val[val]" != "" && in_array($val["op"], $this->operators))) {
				echo "<div>",
					select_input(
						" name='where[$i][col]'",
						$columns,
						$val["col"],
						($val ? "selectFieldChange" : "selectAddRow"),
						"(" . lang('anywhere') . ")"
					),
					html_select("where[$i][op]", $this->operators, $val["op"], $change_next),
					"<input type='search' class='input' name='where[$i][val]' value='" . h($val["val"]) . "'>",
					script("mixin(qsl('input'), {oninput: function () { $change_next }, onkeydown: selectSearchKeydown, onsearch: selectSearchSearch});", ""),
					" <button class='button light remove jsonly' title='" . h(lang('Remove')) . "'>", icon_solo("remove"), "</button>",
					script('qsl("#fieldset-search .remove").onclick = selectRemoveRow;', ""),
					"</div>\n";
			}
		}

		print_fieldset_end("search");
	}

	/**
	 * Prints order box in select filter.
	 *
	 * @param array $order result of selectOrderProcess()
	 * @param array $columns selectable columns
	 */
	function selectOrderPrint(array $order, array $columns, array $indexes) {
		print_fieldset_start("sort", lang('Sort'), "sort", (bool)$order, true);

		$_GET["order"][""] = "";
		$i = 0;

		foreach ((array) $_GET["order"] as $key => $val) {
			if ($key != "" && $val == "") continue;

			echo "<div ", ($key != "" ? "" : "class='no-sort'"), ">",
				icon("handle", "handle jsonly"),
				select_input("name='order[$i]'", $columns, $val, $key !== "" ? "selectFieldChange" : "selectAddRow"),
				" ", checkbox("desc[$i]", 1, isset($_GET["desc"][$key]), lang('descending')),
				" <button class='button light remove jsonly' title='" . h(lang('Remove')), "'>", icon_solo("remove"), "</button>",
				script('qsl("#fieldset-sort .remove").onclick = selectRemoveRow;', ""),
				"</div>\n";

			$i++;
		}

		print_fieldset_end("sort", true);
	}

	/**
	 * Prints limit box in select.
	 * @param ?int $limit result of selectLimitProcess()
	 */
	public function selectLimitPrint(?int $limit): void
	{
		echo "<fieldset><legend>" . lang('Limit') . "</legend><div class='fieldset-content'>", // <div> for easy styling
			"<input type='number' name='limit' class='input size' value='" . h($limit) . "'>",
			script("qsl('input').oninput = selectFieldChange;", ""),
			"</div></fieldset>\n";
	}

	/** Print text length box in select
	* @param string result of selectLengthProcess()
	* @return null
	*/
	function selectLengthPrint($text_length) {
		if ($text_length !== null) {
			echo "<fieldset><legend>" . lang('Text length') . "</legend><div class='fieldset-content'>";
			echo "<input type='number' name='text_length' class='input size' value='" . h($text_length) . "'>";
			echo "</div></fieldset>\n";
		}
	}

	/** Print action box in select
	* @param array
	* @return null
	*/
	function selectActionPrint($indexes) {
		echo "<fieldset><legend>" . lang('Action') . "</legend><div class='fieldset-content'>";
		echo "<input type='submit' class='button' value='" . lang('Select') . "'>";
		echo " <span id='noindex' title='" . lang('Full table scan') . "'></span>";
		echo "<script" . nonce() . ">\n";
		echo "var indexColumns = ";
		$columns = [];
		foreach ($indexes as $index) {
			$current_key = reset($index["columns"]);
			if ($index["type"] != "FULLTEXT" && $current_key) {
				$columns[$current_key] = 1;
			}
		}
		$columns[""] = 1;
		foreach ($columns as $key => $val) {
			json_row($key);
		}
		echo ";\n";
		echo "selectFieldChange.call(gid('form')['select']);\n";
		echo "</script>\n";
		echo "</div></fieldset>\n";
	}

	/** Print command box in select
	* @return bool whether to print default commands
	*/
	function selectCommandPrint() {
		return !information_schema(DB);
	}

	/** Print import box in select
	* @return bool whether to print default import
	*/
	function selectImportPrint() {
		return !information_schema(DB);
	}

	/** Process columns box in select
	* @param array selectable columns
	* @param array
	* @return array [[select_expressions], [group_expressions]]
	*/
	function selectColumnsProcess($columns, $indexes) {
		global $functions, $grouping;
		$select = []; // select expressions, empty for *
		$group = []; // expressions without aggregation - will be used for GROUP BY if an aggregation function is used
		foreach ((array) $_GET["columns"] as $key => $val) {
			if ($val["fun"] == "count" || ($val["col"] != "" && (!$val["fun"] || in_array($val["fun"], $functions) || in_array($val["fun"], $grouping)))) {
				$select[$key] = apply_sql_function($val["fun"], ($val["col"] != "" ? idf_escape($val["col"]) : "*"));
				if (!in_array($val["fun"], $grouping)) {
					$group[] = $select[$key];
				}
			}
		}
		return [$select, $group];
	}

	/** Process search box in select
	* @param array
	* @param array
	* @return array expressions to join by AND
	*/
	function selectSearchProcess($fields, $indexes) {
		global $driver;

		$return = [];

		foreach ($indexes as $i => $index) {
			if ($index["type"] == "FULLTEXT" && isset($_GET["fulltext"]) && $_GET["fulltext"][$i] != "") {
				$return[] = "MATCH (" . implode(", ", array_map('AdminNeo\idf_escape', $index["columns"])) . ") AGAINST (" . q($_GET["fulltext"][$i]) . (isset($_GET["boolean"][$i]) ? " IN BOOLEAN MODE" : "") . ")";
			}
		}

		foreach ((array) $_GET["where"] as $where) {
			$col = $where["col"];
			$op = $where["op"];
			$val = $where["val"];

			if ("$col$val" != "" && in_array($op, $this->operators)) {
				$prefix = "";
				$cond = " $op";

				if (preg_match('~IN$~', $op)) {
					$in = process_length($val);
					$cond .= " " . ($in != "" ? $in : "(NULL)");
				} elseif ($op == "SQL") {
					$cond = " $val"; // SQL injection
				} elseif ($op == "LIKE %%") {
					$cond = " LIKE " . $this->processFieldInput($fields[$col] ?? null, "%$val%");
				} elseif ($op == "ILIKE %%") {
					$cond = " ILIKE " . $this->processFieldInput($fields[$col] ?? null, "%$val%");
				} elseif ($op == "FIND_IN_SET") {
					$prefix = "$op(" . q($val) . ", ";
					$cond = ")";
				} elseif (!preg_match('~NULL$~', $op)) {
					$cond .= " " . $this->processFieldInput($fields[$col] ?? null, $val);
				}

				if ($col != "") {
					$search = isset($fields[$col]) ? $driver->convertSearch(idf_escape($col), $where, $fields[$col]) : idf_escape($col);
					$return[] = $prefix . $search . $cond;
				} else {
					// find anywhere
					$cols = [];
					foreach ($fields as $name => $field) {
						if (isset($field["privileges"]["where"])
                            && (preg_match('~^[-\d.' . (preg_match('~IN$~', $op) ? ',' : '') . ']+$~', $val) || !preg_match('~' . number_type() . '|bit~', $field["type"]))
							&& (!preg_match("~[\x80-\xFF]~", $val) || preg_match('~char|text|enum|set~', $field["type"]))
							&& (!preg_match('~date|timestamp~', $field["type"]) || preg_match('~^\d+-\d+-\d+~', $val))
							&& (!preg_match('~^elastic~', DRIVER) || $field["type"] != "boolean" || preg_match('~true|false~', $val)) // Elasticsearch needs boolean value properly formatted.
							&& (!preg_match('~^elastic~', DRIVER) || strpos($op, "regexp") === false || preg_match('~text|keyword~', $field["type"])) // Elasticsearch can use regexp only on text and keyword fields.
						) {
							$cols[] = $prefix . $driver->convertSearch(idf_escape($name), $where, $field) . $cond;
						}
					}
					$return[] = ($cols ? "(" . implode(" OR ", $cols) . ")" : "1 = 0");
				}
			}
		}

		return $return;
	}

	/** Process order box in select
	* @param array
	* @param array
	* @return array expressions to join by comma
	*/
	function selectOrderProcess($fields, $indexes) {
		$return = [];
		foreach ((array) $_GET["order"] as $key => $val) {
			if ($val != "") {
				$return[] = (preg_match('~^((COUNT\(DISTINCT |[A-Z0-9_]+\()(`(?:[^`]|``)+`|"(?:[^"]|"")+")\)|COUNT\(\*\))$~', $val) ? $val : idf_escape($val)) //! MS SQL uses []
					. (isset($_GET["desc"][$key]) ? " DESC" : "")
				;
			}
		}
		return $return;
	}

	/** Process length box in select
	* @return string number of characters to shorten texts, will be escaped
	*/
	function selectLengthProcess() {
		return (isset($_GET["text_length"]) ? $_GET["text_length"] : "100");
	}

	/** Print before edit form
	* @param string
	* @param array
	* @param mixed
	* @param bool
	* @return null
	*/
	function editRowPrint($table, $fields, $row, $update) {
	}

	/** Functions displayed in edit form
	* @param array single field from fields()
	* @return array
	*/
	function editFunctions($field) {
		global $edit_functions;
		$return = ($field["null"] ? "NULL/" : "");
		$update = isset($_GET["select"]) || where($_GET);
		foreach ($edit_functions as $key => $functions) {
			if (!$key || (!isset($_GET["call"]) && $update)) { // relative functions
				foreach ($functions as $pattern => $val) {
					if (!$pattern || preg_match("~$pattern~", $field["type"])) {
						$return .= "/$val";
					}
				}
			}
			if ($key && !preg_match('~enum|set|blob|bytea|raw|file|bool~', $field["type"])) {
				$return .= "/SQL";
			}
		}
		if ($field["auto_increment"] && !$update) {
			$return = lang('Auto Increment');
		}
		return explode("/", $return);
	}

	/**
	 * Customize input field.
	 *
	 * @param string $table Table name.
	 * @param array $field Single field from fields().
	 * @param string $attrs Attributes to use inside the tag.
	 * @param string|bool|null $value Field value.
	 * @param ?string $function Value modification function.
	 *
	 * @return string Custom input field or empty string for default.
	 */
	public function getFieldInput(string $table, array $field, string $attrs, $value, ?string $function): string
	{
		return "";
	}

	/**
	 * Processes sent input.
	 *
	 * @param ?array $field Single field from fields().
	 *
	 * @return string Expression to use in a query.
	 */
	public function processFieldInput(?array $field, string $value, string $function = ""): string
	{
		if ($function == "SQL") {
			return $value; //! SQL injection
		}
		if (!$field) {
			return q($value);
		}

		$this->detectJson($field["type"], $value, false);

		$name = $field["field"];
		$return = q($value);
		if (preg_match('~^(now|getdate|uuid)$~', $function)) {
			$return = "$function()";
		} elseif (preg_match('~^current_(date|timestamp)$~', $function)) {
			$return = $function;
		} elseif (preg_match('~^([+-]|\|\|)$~', $function)) {
			$return = idf_escape($name) . " $function $return";
		} elseif (preg_match('~^[+-] interval$~', $function)) {
			$return = idf_escape($name) . " $function " . (preg_match("~^(\\d+|'[0-9.: -]') [A-Z_]+\$~i", $value) ? $value : $return);
		} elseif (preg_match('~^(addtime|subtime|concat)$~', $function)) {
			$return = "$function(" . idf_escape($name) . ", $return)";
		} elseif (preg_match('~^(md5|sha1|password|encrypt)$~', $function)) {
			$return = "$function($return)";
		}

		return unconvert_field($field, $return);
	}

	/**
	 * Returns export output options.
	 *
	 * @return string[]
	 */
	public function getDumpOutputs(): array
	{
		$outputs = [
			'file' => lang('save'),
			'text' => lang('open'),
		];

		if (function_exists('gzencode')) {
			$outputs['gz'] = 'gzip';
		}

		return $outputs;
	}

	/**
	 * Returns export format options.
	 *
	 * @return string[] Empty to disable export.
	 */
	public function getDumpFormats(): array
	{
		return (support("dump") ? ['sql' => 'SQL'] : []) + ['csv' => 'CSV,', 'csv;' => 'CSV;', 'tsv' => 'TSV'];
	}

	/**
	 * Sends headers for export.
	 *
	 * @return string File extension.
	 */
	public function sendDumpHeaders(string $identifier, bool $multiTable = false): string
	{
		$output = $_POST["output"];

		// Multiple CSVs are packed to TAR.
		$extension = (str_contains($_POST["format"], "sql") ? "sql" : ($multiTable ? "tar" : "csv"));

		if ($output == "gz") {
			header("Content-Type: application/x-gzip");

			ob_start(function (string $string): string {
				// ob_start() callback receives an optional parameter $phase but gzencode() accepts optional parameter $level
				return gzencode($string);
			}, 1e6);
		} elseif ($extension == "tar") {
			header("Content-Type: application/x-tar");
		} elseif ($extension == "sql") {
			header("Content-Type: text/plain; charset=utf-8");
		} else {
			header("Content-Type: text/csv; charset=utf-8");
		}

		return $extension;
	}

	/**
	 * Exports table structure.
	 *
	 * @param int $viewType 0 table, 1 view, 2 temporary view table.
	 */
	public function dumpTable(string $table, string $style, int $viewType = 0): void
	{
		if ($_POST["format"] != "sql") {
			echo "\xef\xbb\xbf"; // UTF-8 byte order mark
			if ($style) {
				dump_csv(array_keys(fields($table)));
			}
		} else {
			if ($viewType == 2) {
				$fields = [];
				foreach (fields($table) as $name => $field) {
					$fields[] = idf_escape($name) . " $field[full_type]";
				}
				$create = "CREATE TABLE " . table($table) . " (" . implode(", ", $fields) . ")";
			} else {
				$create = create_sql($table, $_POST["auto_increment"], $style);
			}

			set_utf8mb4($create);

			if ($style && $create) {
				if ($style == "DROP+CREATE" || $viewType == 1) {
					echo "DROP " . ($viewType == 2 ? "VIEW" : "TABLE") . " IF EXISTS " . table($table) . ";\n";
				}
				if ($viewType == 1) {
					$create = remove_definer($create);
				}

				echo "$create;\n\n";
			}
		}
	}

	/**
	 * Exports table data.
	 */
	public function dumpData(string $table, string $style, string $query): void
	{
		global $connection, $jush;

		if ($style) {
			$max_packet = ($jush == "sqlite" ? 0 : 1048576); // default, minimum is 1024
			$fields = [];
			$identity_insert = false;

			if ($_POST["format"] == "sql") {
				if ($style == "TRUNCATE+INSERT") {
					echo truncate_sql($table) . ";\n";
				}

				$fields = fields($table);

				if ($jush == "mssql") {
					foreach ($fields as $field) {
						if ($field["auto_increment"]) {
							echo "SET IDENTITY_INSERT " . table($table) . " ON;\n";
							$identity_insert = true;
							break;
						}
					}
				}
			}

			$result = $connection->query($query, 1); // 1 - MYSQLI_USE_RESULT //! enum and set as numbers
			if ($result) {
				$insert = "";
				$buffer = "";
				$keys = [];
				$generatedKeys = [];
				$suffix = "";
				$fetch_function = ($table != '' ? 'fetch_assoc' : 'fetch_row');

				while ($row = $result->$fetch_function()) {
					if (!$keys) {
						$values = [];

						foreach ($row as $val) {
							$field = $result->fetch_field();
							if (!empty($fields[$field->name]['generated'])) {
								$generatedKeys[$field->name] = true;
								continue;
                            }
							$keys[] = $field->name;
							$key = idf_escape($field->name);
							$values[] = "$key = VALUES($key)";
						}

						$suffix = ($style == "INSERT+UPDATE" ? "\nON DUPLICATE KEY UPDATE " . implode(", ", $values) : "") . ";\n";
					}

					if ($_POST["format"] != "sql") {
						if ($style == "table") {
							dump_csv($keys);
							$style = "INSERT";
						}

						dump_csv($row);
					} else {
						if (!$insert) {
							$insert = "INSERT INTO " . table($table) . " (" . implode(", ", array_map('AdminNeo\idf_escape', $keys)) . ") VALUES";
						}

						foreach ($row as $key => $val) {
							if (isset($generatedKeys[$key])) {
								unset($row[$key]);
								continue;
                            }

							$field = $fields[$key];
							$row[$key] = ($val !== null
								? unconvert_field($field, preg_match(number_type(), $field["type"]) && !preg_match('~\[~', $field["full_type"]) && is_numeric($val) ? $val : q(($val === false ? 0 : $val)))
								: "NULL"
							);
						}

						$s = ($max_packet ? "\n" : " ") . "(" . implode(",\t", $row) . ")";

						if (!$buffer) {
							$buffer = $insert . $s;
						} elseif (strlen($buffer) + 4 + strlen($s) + strlen($suffix) < $max_packet) { // 4 - length specification
							$buffer .= ",$s";
						} else {
							echo $buffer . $suffix;
							$buffer = $insert . $s;
						}
					}
				}
				if ($buffer) {
					echo $buffer . $suffix;
				}
			} elseif ($_POST["format"] == "sql") {
				echo "-- " . str_replace("\n", " ", $connection->error) . "\n";
			}

			if ($identity_insert) {
				echo "SET IDENTITY_INSERT " . table($table) . " OFF;\n";
			}
		}
	}

	/**
	 * Gets the path of the file for webserver load.
	 *
	 * @return string Path of the sql import file.
	 */
	function importServerPath() {
		return "adminneo.sql";
	}

	/**
	 * Prints homepage.
	 *
	 * @return bool Whether to print default homepage.
	 */
	function homepage() {
		echo "<p class='links top-links'>\n";

		$ns = $_GET["ns"] ?? null;

		if ($ns == "" && support("database")) {
			echo '<a href="', h(ME), 'database=">', icon("edit"), lang('Alter database'), "</a>\n";
		}
		if ($ns != "" && support("scheme")) {
			echo "<a href='", h(ME), "scheme='>", icon("edit"), lang('Alter schema'), "</a>\n";
		}
		if ($ns !== "") {
			echo '<a href="', h(ME), 'schema=">', icon("schema"), lang('Database schema'), "</a>\n";
		}
		if (support("privileges")) {
			echo "<a href='", h(ME), "privileges='>", icon("users"), lang('Privileges'), "</a>\n";
		}

		echo "</p>\n";

		return true;
	}

	/** Prints navigation
	* @param string can be "auth" if there is no database connection, "db" if there is no database selected, "ns" with invalid schema
	* @return null
	*/
	function navigation($missing) {
		global $VERSION, $jush, $drivers, $connection;

		$last_version = $_COOKIE["neo_version"] ?? null;
?>

<div class="header">
	<?= $this->name(); ?>

	<?php if ($missing != "auth"): ?>
		<span class="version">
			<?= h($VERSION); ?>
			<a id="version" class="version-badge" href="https://github.com/adminneo-org/adminneo/releases"<?= target_blank(); ?> title="<?= h($last_version); ?>">
				<?= ($this->config->isVersionVerificationEnabled() && $last_version && version_compare($VERSION, $last_version) < 0 ? icon_solo("asterisk") : ""); ?>
			</a>
		</span>
		<?php
		if ($this->config->isVersionVerificationEnabled() && !$last_version) {
			echo script("verifyVersion('" . js_escape(ME) . "', '" . get_token() . "');");
		}
		?>
    <?php endif; ?>
</div>

<?php
		if ($missing == "auth") {
			$output = "";
			foreach ((array) $_SESSION["pwds"] as $vendor => $servers) {
				foreach ($servers as $server => $usernames) {
					foreach ($usernames as $username => $password) {
						if ($password !== null) {
							$dbs = $_SESSION["db"][$vendor][$server][$username];
							foreach (($dbs ? array_keys($dbs) : [""]) as $db) {
								$server_name = $this->getServerName($server);
								$title = h($drivers[$vendor])
									. ($username != "" || $server_name != "" ? " - " : "")
									. h($username)
									. ($username != "" && $server_name != "" ? "@" : "")
									. h($server_name)
									. ($db != "" ? h(" - $db") : "");

								$output .= "<li><a href='" . h(auth_url($vendor, $server, $username, $db)) . "' class='primary' title='$title'>$title</a></li>\n";
							}
						}
					}
				}
			}
			if ($output) {
				echo "<nav id='logins'><menu>\n$output</menu></nav>\n";
			}
		} else {
			$this->databasesPrint($missing);

			$actions = [];
			if (DB == null || !$missing) {
				if (support("sql")) {
					$actions[] = "<a href='" . h(ME) . "sql='" . bold(isset($_GET["sql"]) && !isset($_GET["import"])) . ">" . icon("command") . lang('SQL command') . "</a>";
					$actions[] = "<a href='" . h(ME) . "import='" . bold(isset($_GET["import"])) . ">" . icon("import") . lang('Import') . "</a>";
				}
				$actions[] = "<a href='" . h(ME) . "dump=" . urlencode($_GET["table"] ?? $_GET["select"]) . "' id='dump'" . bold(isset($_GET["dump"])) . ">" . icon("export") . lang('Export') . "</a>";
			}
			if (DB == null) {
				$actions[] = '<a href="' . h(ME) . 'database="' . bold($_GET["database"] === "") . ">" . icon("database-add") . lang('Create database') . "</a>\n";
			}
			if (DB != null && $_GET["ns"] === "" && !$missing) {
				$actions[] = '<a href="' . h(ME) . 'scheme="' . bold($_GET["scheme"] === "") . ">" . icon("database-add") . lang('Create schema') . "</a>\n";
			}
			if (DB != null && $_GET["ns"] !== "" && !$missing) {
				$actions[] = '<a href="' . h(ME) . 'create="' . bold($_GET["create"] === "") . ">" . icon("table-add") . lang('Create table') . "</a>\n";
			}
			if ($actions) {
				echo "<p class='links'>" . implode("\n", $actions) . "</p>";
			}

			// Tables.
			$tables = [];
			if ($_GET["ns"] !== "" && !$missing && DB != "") {
				$connection->select_db(DB);
				$tables = table_status('', true);
			}

			if ($_GET["ns"] !== "" && !$missing && DB != "") {
				if ($tables) {
					$this->printTablesFilter();
					$this->tablesPrint($tables);
				} else {
					echo "<p class='message'>" . lang('No tables.') . "</p>\n";
				}
			}

			// Syntax highlighting.
			if (support("sql")) {
				?>
				<script<?php echo nonce(); ?>>
					<?php
					if ($tables) {
						$links = [];
						foreach ($tables as $table => $type) {
							$links[] = preg_quote($table, '/');
						}
						echo "var jushLinks = { $jush: [ '" . js_escape(ME) . (support("table") ? "table=" : "select=") . "\$&', /\\b(" . implode("|", $links) . ")\\b/g ] };\n";
						foreach (["bac", "bra", "sqlite_quo", "mssql_bra"] as $val) {
							echo "jushLinks.$val = jushLinks.$jush;\n";
						}
					}
					$server_info = $connection->server_info;
					?>
					initSyntaxHighlighting('<?php echo (is_object($connection) ? preg_replace('~^(\d\.?\d).*~s', '\1', $server_info) : ""); ?>'<?php echo (preg_match('~MariaDB~', $server_info) ? ", true" : ""); ?>);
				</script>
				<?php
			}
		}
	}

	/**
	 * Prints databases select in menu.
	 *
	 * @param $missing string
	 * @return null
	 */
	function databasesPrint($missing) {
		global $admin, $connection;

		$databases = $this->getDatabases();
		if (DB && $databases && !in_array(DB, $databases)) {
			array_unshift($databases, DB);
		}

		echo "<div class='db-selector'><form action=''>";
		hidden_fields_get();

		if ($databases) {
			echo "<select id='database-select' name='db'>" . optionlist(["" => lang('Database')] + $databases, DB) . "</select>"
				. script("mixin(gid('database-select'), {onmousedown: dbMouseDown, onchange: dbChange});");
		} else {
			echo "<input id='database-select' class='input' name='db' value='" . h(DB) . "' autocapitalize='off'>\n";
		}
		echo "<input type='submit' value='" . lang('Use') . "' class='button " . ($databases ? "hidden" : "") . "'>\n";

		if (support("scheme") && $missing != "db" && DB != "" && $connection->select_db(DB)) {
			echo "<br><select id='scheme-select' name='ns'>" . optionlist(["" => lang('Schema')] + $admin->getSchemas(), $_GET["ns"]) . "</select>"
				. script("mixin(gid('scheme-select'), {onmousedown: dbMouseDown, onchange: dbChange});");

			if ($_GET["ns"] != "") {
				set_schema($_GET["ns"]);
			}
		}

		foreach (["import", "sql", "schema", "dump", "privileges"] as $val) {
			if (isset($_GET[$val])) {
				echo "<input type='hidden' name='$val' value=''>";
				break;
			}
		}

		echo "</form></div>\n";

		return null;
	}

	/**
	 * Prints table list in menu.
	 *
	 * @param array $tables Result of table_status('', true)
	 * @return null
	 */
	function tablesPrint(array $tables) {
		$menuClass = ($this->config->isNavigationDual() ? "class='dual'" : ($this->config->isNavigationReversed() ? "class='reversed'" : ""));

		echo "<nav id='tables'><menu $menuClass>";

		foreach ($tables as $table => $status) {
			$name = $this->getTableName($status);
			if ($name == "") {
				continue;
			}

			echo "<li>";

			$active = in_array($table, [$_GET["table"], $_GET["select"], $_GET["create"], $_GET["indexes"], $_GET["foreign"], $_GET["trigger"]]);
			$class = "primary" . (is_view($status) ? " view" : "");
			$supportStructure = support("table") || support("indexes");
			$selectUrl = h(ME) . "select=" . urlencode($table);
			$tableUrl = h(ME) . "table=" . urlencode($table);

			if ($this->config->isSelectionPreferred()) {
				if ($this->config->isNavigationReversed() && $supportStructure) {
					echo " <a href='$tableUrl' title='", lang('Show structure'), "' class='secondary'>", icon("structure"), "</a>";
				}

				echo "<a href='$selectUrl'", bold($active, $class), " data-primary='true' title='$name'>$name</a>";

				if ($this->config->isNavigationDual() && $supportStructure) {
					echo " <a href='$tableUrl' title='", lang('Show structure'), "' class='secondary'>", icon_solo("structure"), "</a>";
				}
			} else {
				if ($this->config->isNavigationReversed()) {
					echo " <a href='$selectUrl' title='", lang('Select data'), "' class='secondary'>", icon("data"), "</a>";
				}

				if ($supportStructure) {
					echo "<a href='$tableUrl'", bold($active, $class), " data-primary='true' title='$name'>$name</a>";
				} else {
					echo "<span data-primary='true'", bold($active, $class), ">$name</span>";
				}

				if ($this->config->isNavigationDual()) {
					echo " <a href='$selectUrl' title='", lang('Select data'), "' class='secondary'>", icon_solo("data"), "</a>";
				}
			}

			echo "</li>\n";
		}

		echo "</menu></nav>\n";

		return null;
	}

	public function foreignColumn($foreignKeys, $column): ?array
	{
		return null;
	}
}
