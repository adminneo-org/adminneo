<?php

namespace AdminNeo;

$tables_views = array_merge((array) $_POST["tables"], (array) $_POST["views"]);

if ($tables_views && !$_POST["search"]) {
	$result = true;
	$message = "";
	if (DIALECT == "sql" && $_POST["tables"] && count($_POST["tables"]) > 1 && ($_POST["drop"] || $_POST["truncate"] || $_POST["copy"])) {
		queries("SET foreign_key_checks = 0"); // allows to truncate or drop several tables at once
	}

	if ($_POST["truncate"] || $_POST["truncate_cascade"]) {
		if ($_POST["tables"]) {
			$result = truncate_tables($_POST["tables"], (bool)$_POST["truncate_cascade"]);
		}
		$message = lang('Tables have been truncated.');
	} elseif ($_POST["move"]) {
		$result = move_tables((array) $_POST["tables"], (array) $_POST["views"], $_POST["target"]);
		$message = lang('Tables have been moved.');
	} elseif ($_POST["copy"]) {
		$result = copy_tables((array) $_POST["tables"], (array) $_POST["views"], $_POST["target"]);
		$message = lang('Tables have been copied.');
	} elseif ($_POST["drop"]) {
		if ($_POST["views"]) {
			$result = drop_views($_POST["views"]);
		}
		if ($result && $_POST["tables"]) {
			$result = drop_tables($_POST["tables"]);
		}
		$message = lang('Tables have been dropped.');
	} elseif (DIALECT == "sqlite" && $_POST["check"]) {
		foreach ((array) $_POST["tables"] as $table) {
			foreach (get_rows("PRAGMA integrity_check(" . q($table) . ")") as $row) {
				$message .= "<b>" . h($table) . "</b>: " . h($row["integrity_check"]) . "<br>";
			}
		}
	} elseif (DIALECT != "sql") {
		$result = (DIALECT == "sqlite"
			? queries("VACUUM")
			: apply_queries("VACUUM" . ($_POST["optimize"] ? " ANALYZE" : ""), $_POST["tables"])
		);
		$message = lang('Tables have been optimized.');
	} elseif (!$_POST["tables"]) {
		$message = lang('No tables.');
	} elseif ($result = queries(($_POST["optimize"] ? "OPTIMIZE" : ($_POST["check"] ? "CHECK" : ($_POST["repair"] ? "REPAIR" : "ANALYZE"))) . " TABLE " . implode(", ", array_map('AdminNeo\idf_escape', $_POST["tables"])))) {
		while ($row = $result->fetchAssoc()) {
			$message .= "<b>" . h($row["Table"]) . "</b>: " . h($row["Msg_text"]) . "<br>";
		}
	}

	queries_redirect($_SERVER["REQUEST_URI"], $message, (bool)$result);
}

if ($_GET["ns"] == "") {
	page_header(lang('Database') . ": " . h(DB), true);
} else {
	page_header(lang('Schema') . ": " . h($_GET["ns"]), true);
}

Admin::get()->printDatabaseMenu();

if ($_GET["ns"] === "") {
	echo "<h2 id='schemas'>" . lang('Schemas') . "</h2>\n";
	$schemas = Admin::get()->getSchemas();
	if (!$schemas) {
		echo "<p class='message'>" . lang('No schemas.') . "\n";
	} else {
		// TODO: Checkboxes for batch dropping of schemas.
		echo "<div class='scrollable'>\n",
			"<table class='nowrap'>\n",
			'<thead><tr class="wrap"><th>', lang('Schema'), "</th></tr></thead>";

		foreach ($schemas as $name) {
			echo "<tr><th><a href='", h(ME), "ns=" . urlencode($name), "' title='", lang('Show schema'), "'>" . h($name) . "</a></th></tr>";
		}

		echo '</table></div>';
	}

	echo '<p class="links"><a href="' . h(ME) . 'scheme=">' . icon("database-add") . lang('Create schema') . "</a>\n";
} else {
	echo "<h2 id='tables-views'>" . lang('Tables and views') . "</h2>\n";

	$table_status_links = [
		'sql' => 'show-table-status.html',
		'mariadb' => 'reference/sql-statements/administrative-sql-statements/show/show-table-status'
	];

	$db_collation = db_collation(DB, collations());

	$columns = [
		"Engine" => [
			"label" => lang('Engine'),
			"doc" => doc_link(['sql' => 'storage-engines.html', 'mariadb' => 'server-usage/storage-engines']),
		],
	];
	if ($db_collation != "") {
		$columns["Collation"] = [
			"label" => lang('Collation'),
			"doc" => doc_link(['sql' => 'charset-charsets.html', 'mariadb' => 'reference/data-types/string-data-types/character-sets/supported-character-sets-and-collations']),
		];
	}
	$columns += [
		"Data_length" => [
			"label" => lang('Data Length'),
			"doc" => doc_link($table_status_links + ['pgsql' => 'functions-admin.html#FUNCTIONS-ADMIN-DBOBJECT', 'oracle' => 'REFRN20286']),
			"link" => "create", "title" => lang('Alter table'),
		],
		"Index_length" => [
			"label" => lang('Index Length'),
			"doc" => doc_link($table_status_links + ['pgsql' => 'functions-admin.html#FUNCTIONS-ADMIN-DBOBJECT']),
			"link" => "indexes", "title" => lang('Alter indexes'),
		],
		"Data_free" => [
			"label" => lang('Data Free'),
			"doc" => doc_link($table_status_links),
			"link" => "edit", "title" => lang('New item'),
		],
		"Auto_increment" => [
			"label" => lang('Auto Increment'),
			"doc" => doc_link(['sql' => 'example-auto-increment.html', 'mariadb' => 'reference/data-types/auto_increment']),
			"link" => "auto_increment=1&create", "title" => lang('Alter table'),
		],
		"Rows" => [
			"label" => lang('Rows'),
			"doc" => doc_link($table_status_links + ['pgsql' => 'catalog-pg-class.html#CATALOG-PG-CLASS', 'oracle' => 'REFRN20286']),
			"link" => "select", "title" => lang('Select data'),
		],
	];
	if (support("comment")) {
		$columns["Comment"] = [
			"label" => lang('Comment'),
			"doc" => doc_link($table_status_links + ['pgsql' => 'functions-info.html#FUNCTIONS-INFO-COMMENT-TABLE']),
		];
	}

	// Tables are sorted by name in ascending order by default, which is the order returned by drivers.
	$order = (is_string($_GET["order"]) ? $_GET["order"] : "");
	$descending = null;
	if (preg_match('~^(.+)-(asc|desc)$~', $order, $match)) {
		$order = $match[1];
		$descending = ($match[2] == "desc");
	}
	if ($order != "__table" && !isset($columns[$order])) {
		$order = "";
	}
	if ($descending === null) {
		// Numeric columns, i.e. those with a link, are sorted in descending order by default.
		$descending = isset($columns[$order]["link"]);
	}

	// Sorting by a status column requires the statuses of all tables, so they are not loaded by AJAX in that case.
	// Neither are they for drivers serving them fast enough to not delay the page.
	$with_status = ($order != "" && $order != "__table") || support("fast_status");

	$tables_list = ($with_status ? table_status() : tables_list());
	if (!$tables_list) {
		echo "<p class='message'>" . lang('No tables.') . "\n";
	} else {
		echo "<form action='' method='post'>\n";
		echo "<div class='table-footer-parent'>\n";

		if (support("table")) {
			echo "<div class='field-sets'>\n";
			echo "<fieldset><legend>" . lang('Search data in tables') . " <span id='selected2'></span></legend><div class='fieldset-content'>";
			echo html_select("op", Admin::get()->getOperators(), $_POST["op"] ?? Driver::get()->getLikeOperator());
			echo "<input type='search' class='input' name='query' value='" . h($_POST["query"]) . "'>";
			echo script("qsl('input').onkeydown = event => bodyKeydown(event, 'search');", "");
			echo " <input type='submit' class='button' name='search' value='" . lang('Search') . "'>\n";
			echo "</div></fieldset>\n";
			echo "</div>\n";

			if ($_POST["search"] && $_POST["query"] != "") {
				$_GET["where"][0]["op"] = $_POST["op"];
				search_tables();
			}
		}

		echo "<div class='scrollable'>\n";
		echo "<table class='nowrap checkable'>\n";

		echo '<thead><tr class="wrap">';
		echo '<td class="actions"><input id="check-all" type="checkbox" class="input jsonly" title="' . lang('All') . '">' . script("gid('check-all').onclick = partial(formCheck, /^(tables|views)\[/);", "");
		// Tables are already sorted by name when no other column is used, so only the descending order needs a parameter.
		$name_order = ($order == "" || $order == "__table");
		$table_link = ($name_order && !$descending ? ME . "order=__table-desc" : substr(ME, 0, -1));
		// SQLite puts the sqlite_ tables last, so its list is not sorted by name.
		$name_sorted = ($name_order && DIALECT != "sqlite");
		echo '<th' . ($name_sorted ? " aria-sort='" . ($descending ? "descending" : "ascending") . "'" : '')
			. '><a href="' . h($table_link) . '">' . lang('Table') . '</a>';
		foreach ($columns as $key => $column) {
			// The sorted column is linked to the opposite direction, so repeated clicks toggle it.
			$direction = ($key === $order ? !$descending : isset($column["link"]));
			echo '<th' . ($key === $order ? " aria-sort='" . ($descending ? "descending" : "ascending") . "'" : '')
				. '><a href="' . h(ME) . "order=$key-" . ($direction ? "desc" : "asc") . '">' . $column["label"] . '</a>' . $column["doc"];
		}
		echo "</thead>\n";
		echo "<tbody>\n";

		if ($order == "__table") {
			if ($descending) {
				$tables_list = array_reverse($tables_list, true); // Drivers return tables sorted by name.
			}
		} elseif ($order) {
			uasort($tables_list, function ($a, $b) use ($order, $descending) {
				$x = $a[$order] ?? null;
				$y = $b[$order] ?? null;
				$result = ($x < $y ? -1 : ($x > $y ? 1 : 0)); // <=> is not downgraded to PHP 5.4.

				return ($descending ? -$result : $result);
			});
		}

		$sums = ["Data_length" => 0, "Index_length" => 0, "Data_free" => 0];

		$tables = 0;
		foreach ($tables_list as $name => $status) {
			$view = ($with_status ? is_view($status) : $status !== null && !preg_match('~table|sequence~i', $status));
			$engine = ($with_status ? ($status["Engine"] ?? "") : $status);
			$id = h("Table-" . $name);

			echo '<tr><td class="actions">' . checkbox(($view ? "views[]" : "tables[]"), $name, in_array("$name", $tables_views, true), "", "", "", $id); // "$name" to check numeric table names

			if (!Admin::get()->getSettings()->isSelectionPreferred() && (support("table") || support("indexes"))) {
				$action = "table";
			} else {
				$action = "select";
			}
			echo "<th><a href='", h(ME), "$action=", urlencode($name), "' id='$id'>", h($name), "</a></th>";

			if ($view && !preg_match('~materialized~i', $engine)) {
				$title = lang('View');
				$colspan = count($columns) - (support("comment") ? 2 : 1); // Rows and Comment columns are printed separately.
				echo '<td colspan="' . $colspan . '">' . (support("view") ? "<a href='" . h(ME) . "view=" . urlencode($name) . "' title='" . lang('Alter view') . "'>$title</a>" : $title);
				echo "<td align='right'><a href='" . h(ME) . "select=" . urlencode($name) . "' title='" . lang('Select data') . "'>?</a>";
			} else {
				foreach ($columns as $key => $column) {
					if ($key == "Comment") {
						continue;
					}

					$id = " id='$key-" . h($name) . "'";
					$link = $column["link"] ?? "";
					if (!$link) {
						$val = "";
						if ($with_status) {
							$val = $status[$key] ?? "";

							// Tables without own collation inherit it from the database.
							if ($key == "Collation" && $val == "") {
								$val = $db_collation;
							}
						}

						echo "<td$id>" . h($val);
						continue;
					}

					$val = "?";
					if ($with_status) {
						$number = $status[$key] ?? "";
						if (is_numeric($number) && $number >= 0) {
							$val = ($key == "Rows" ? format_rows($status) : format_number($number));

							// Ignore innodb_file_per_table because it is not active for tables created before it was enabled.
							if (isset($sums[$key]) && ($engine != "InnoDB" || $key != "Data_free")) {
								$sums[$key] += $number;
							}
						}
					}

					echo "<td align='right'>" . (support("table") || $key == "Rows" || (support("indexes") && $key != "Data_length")
						? "<a href='" . h(ME . "$link=") . urlencode($name) . "'$id title='" . $column["title"] . "'>" . h($val) . "</a>"
						: "<span$id>" . h($val) . "</span>"
					);
				}
				$tables++;
			}
			echo (support("comment") ? "<td id='Comment-" . h($name) . "'>" . ($with_status ? h($status["Comment"] ?? "") : "") : "");
			echo "\n";
		}

		echo "</tbody>\n";
		echo script("mixin(qsl('tbody'), {onclick: tableClick, ondblclick: event => tableClick(event, true)});");

		echo "<tfoot><tr>";
		echo "<td><th>" . lang('%d in total', count($tables_list));
		echo "<td>" . h(DIALECT == "sql" ? Connection::get()->getValue("SELECT @@default_storage_engine") : "");
		echo ($db_collation != "" ? "<td>" . h($db_collation) : "");
		if ($with_status && function_exists('AdminNeo\db_status')) {
			$sums = db_status();
		}
		foreach ($sums as $key => $sum) {
			echo "<td align='right' id='sum-$key'>" . ($with_status ? format_number($sum) : "");
		}
		echo "<td></td><td></td>";
		if (support("comment")) {
			echo "<td></td>";
		}
		echo "</tr></tfoot>\n";

		echo "</table>\n";
		echo "</div>\n"; // scrollable

		echo ($with_status ? "" : script("ajaxSetHtml('" . js_escape(ME) . "script=db');"));

		if (Admin::get()->isDataEditAllowed()) {
			echo "<div class='table-footer'><div class='field-sets'>\n";
			$vacuum = "<input type='submit' class='button' value='" . lang('Vacuum') . "'> " . help_script("VACUUM");
			$optimize = "<input type='submit' class='button' name='optimize' value='" . lang('Optimize') . "'> " . help_script(DIALECT == "sql" ? "OPTIMIZE TABLE" : "VACUUM ANALYZE");
			echo "<fieldset><legend>" . lang('Selected') . " <span id='selected'></span></legend><div class='fieldset-content'>"
			. (DIALECT == "sqlite" ? $vacuum . "<input type='submit' class='button' name='check' value='" . lang('Check') . "'> " . help_script("PRAGMA integrity_check")
			: (DIALECT == "pgsql" ? $vacuum . $optimize
			: (DIALECT == "sql" ? "<input type='submit' class='button' value='" . lang('Analyze') . "'> " . help_script("ANALYZE TABLE")
				. $optimize
				. "<input type='submit' class='button' name='check' value='" . lang('Check') . "'> " . help_script("CHECK TABLE")
				. "<input type='submit' class='button' name='repair' value='" . lang('Repair') . "'> " . help_script("REPAIR TABLE")
			: "")))
			. "<input type='submit' class='button' name='truncate' value='" . lang('Truncate') . "'> " . help_script(DIALECT == "sqlite" ? "DELETE" : ("TRUNCATE" . (DIALECT == "pgsql" ? "" : " TABLE"))) . confirm()
			. (DIALECT == "pgsql" ? "<input type='submit' class='button' name='truncate_cascade' value='" . lang('Truncate Cascade') . "'> " . help_script("TRUNCATE CASCADE") . confirm() : "")
			. "<input type='submit' class='button' name='drop' value='" . lang('Drop') . "'>" . help_script("DROP TABLE") . confirm() . "\n";
			$databases = (support("scheme") ? Admin::get()->getSchemas() : Admin::get()->getDatabases());
			echo "</div></fieldset>\n";
			$script = "";
			if (count($databases) != 1 && DIALECT != "sqlite") {
				echo "<fieldset><legend>" . lang('Move to other database') . " <span id='selected3'></span></legend><div>";
				$db = (isset($_POST["target"]) ? $_POST["target"] : (support("scheme") ? $_GET["ns"] : DB));
				echo ($databases ? html_select("target", $databases, $db, "", "label-move") : '<input class="input" name="target" value="' . h($db) . '" autocapitalize="off">');
				echo " <input type='submit' class='button' name='move' value='" . lang('Move') . "'>";
				echo (support("copy") ? " <input type='submit' class='button' name='copy' value='" . lang('Copy') . "'> " . checkbox("overwrite", 1, $_POST["overwrite"], lang('overwrite')) : "");
				echo "</div></fieldset>\n";
				$script = " selectCount('selected3', formChecked(this, /^(tables|views)\[/));";
			}
			echo input_hidden("all"); // used by trCheck()
			echo script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^(tables|views)\[/));"
				. (support("table") ? " selectCount('selected2', formChecked(this, /^tables\[/) || $tables);" : "")
				. "$script }"
			);
			echo input_token();
			echo "</div></div>\n";

			echo script("initTableFooter()");
		}

		echo "</div>\n"; // table-footer-parent
		echo "</form>\n";
		echo script("tableCheck();");
	}

	echo '<p class="links"><a href="', h(ME), 'create=">', icon("table-add"), lang('Create table'), "</a>\n";
	if (support("view")) {
		echo '<a href="', h(ME), 'view=">', icon("view-add"), lang('Create view'), "</a>\n";
	}

	if (support("routine")) {
		echo "<h2 id='routines'>" . lang('Routines') . "</h2>\n";

		$routines = routines();
		if ($routines) {
			$commentsSupported = $routines[0]["ROUTINE_COMMENT"] !== null;

			echo "<table>\n";
			echo '<thead><tr>',
				'<th>', lang('Name'), '</th><td>', lang('Type'), '</td><td>', lang('Return type'), "</td>";
				if ($commentsSupported) {
					echo "<td>", lang('Comment'), "</td>";
				}
			echo "<td></td>",
				"</tr></thead>\n";

			foreach ($routines as $row) {
				// not computed on the pages to be able to print the header first
				$name = ($row["SPECIFIC_NAME"] == $row["ROUTINE_NAME"] ? "" : "&name=" . urlencode($row["ROUTINE_NAME"]));

				echo '<tr>',
					'<th><a href="', h(ME . ($row["ROUTINE_TYPE"] != "PROCEDURE" ? 'callf=' : 'call=') . urlencode($row["SPECIFIC_NAME"]) . $name), '">', h($row["ROUTINE_NAME"]), '</a></th>',
					'<td>', h($row["ROUTINE_TYPE"]), '</td>',
					'<td>', h($row["DTD_IDENTIFIER"]), '</td>';

				if ($commentsSupported) {
					echo '<td>', truncate_utf8(preg_replace('~\s{2,}~', " ", trim($row["ROUTINE_COMMENT"])), 50), '</td>';
				}

				echo '<td><a href="' . h(ME . ($row["ROUTINE_TYPE"] != "PROCEDURE" ? 'function=' : 'procedure=') . urlencode($row["SPECIFIC_NAME"]) . $name) . '">' . lang('Alter') . "</a></td>";
			}

			echo "</table>\n";
		}

		echo '<p class="links">';
		if (support("procedure")) {
			echo '<a href="', h(ME), 'procedure=">', icon("function-add"), lang('Create procedure'), "</a>";
		}
		echo '<a href="', h(ME), 'function=">', icon("function-add"), lang('Create function'), "</a>\n",
			"</p>\n";
	}

	if (support("sequence")) {
		echo "<h2 id='sequences'>" . lang('Sequences') . "</h2>\n";
		$sequences = get_vals("SELECT sequence_name FROM information_schema.sequences WHERE sequence_schema = current_schema() ORDER BY sequence_name");
		if ($sequences) {
			echo "<table>\n",
				"<thead><tr><th>", lang('Name'), "</th><td></td></tr></thead>\n";

			foreach ($sequences as $val) {
				echo "<tr>",
					"<th>", h($val), "</th>",
					"<td><a href='", h(ME), "sequence=", urlencode($val), "'>", lang('Alter'), "</a></td>\n";
			}

			echo "</table>\n";
		}
		echo "<p class='links'><a href='", h(ME), "sequence='>", icon("add"), lang('Create sequence'), "</a></p>\n";
	}

	if (support("type")) {
		echo "<h2 id='user-types'>" . lang('User types') . "</h2>\n";
		$user_types = types();
		if ($user_types) {
			echo "<table>\n",
				"<thead><tr><th>", lang('Name'), "</th><td></td></tr></thead>\n";

			foreach ($user_types as $val) {
				echo "<tr>",
					"<th>", h($val), "</th>",
					"<td><a href='", h(ME), "type=", urlencode($val), "'>", lang('Alter'), "</a></td>\n";
			}

			echo "</table>\n";
		}
		echo "<p class='links'><a href='", h(ME), "type='>", icon("add"), lang('Create type'), "</a></p>\n";
	}

	if (support("event")) {
		echo "<h2 id='events'>" . lang('Events') . "</h2>\n";
		$rows = get_rows("SHOW EVENTS");
		if ($rows) {
			echo "<table>\n";
			echo "<thead><tr><th>" . lang('Name') . "<td>" . lang('Schedule') . "<td>" . lang('Start') . "<td>" . lang('End') . "<td></thead>\n";
			foreach ($rows as $row) {
				echo "<tr>";
				echo "<th>" . h($row["Name"]);
				echo "<td>" . ($row["Execute at"] ? lang('At given time') . "<td>" . h($row["Execute at"]) : lang('Every') . " " . h($row["Interval value"]) . " " . h($row["Interval field"]) . "<td>" . h($row["Starts"]));
				echo "<td>" . h($row["Ends"]);
				echo '<td><a href="' . h(ME) . 'event=' . urlencode($row["Name"]) . '">' . lang('Alter') . '</a>';
			}
			echo "</table>\n";
			$event_scheduler = Connection::get()->getValue("SELECT @@event_scheduler");
			if ($event_scheduler && $event_scheduler != "ON") {
				echo "<p class='error'><code class='jush-sqlset'>event_scheduler</code>: " . h($event_scheduler) . "\n";
			}
		}
		echo '<p class="links"><a href="', h(ME), 'event=">', icon("event-add"), lang('Create event'), "</a></p>\n";
	}
}
