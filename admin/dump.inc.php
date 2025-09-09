<?php

namespace AdminNeo;

$TABLE = $_GET["dump"];

$settings = Admin::get()->getSettings();
if ($_POST) {
	$settings->updateParameters([
		"dumpFormat" => $_POST["format"],
		"dumpDbStyle" => $_POST["db_style"],
		"dumpTypes" => $_POST["types"] ?? null,
		"dumpRoutines" => $_POST["routines"] ?? null,
		"dumpEvents" => $_POST["events"] ?? null,
		"dumpTableStyle" => $_POST["table_style"],
		"dumpAutoIncrement" => $_POST["auto_increment"] ?? null,
		"dumpTriggers" => $_POST["triggers"] ?? null,
		"dumpDataStyle" => $_POST["data_style"],
		"dumpOutput" => $_POST["output"],
	]);

	$subjects = array_flip($_POST["databases"] ?? []) + array_flip($_POST["tables"] ?? []) + array_flip($_POST["data"] ?? []);
	if (count($subjects) == 1) {
		$identifier = key($subjects);
	} elseif (DB !== null) {
		$identifier = DB;
	} else {
		$identifier = SERVER != "" ? Admin::get()->getServerName(SERVER) : "localhost";
	}

	$ext = dump_headers($identifier, DB == null || count($subjects) > 1);

	$is_sql = preg_match('~sql~', $_POST["format"]);
	if ($is_sql) {
		echo "-- AdminNeo " . VERSION . " " . Drivers::get(DRIVER) . " " . Connection::get()->getVersion() . " dump\n\n";
		if (DIALECT == "sql") {
			echo "SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
" . ($_POST["data_style"] ? "SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';
" : "") . "
";
			Connection::get()->query("SET time_zone = '+00:00'");
			Connection::get()->query("SET sql_mode = ''");
		}
	}

	$style = $_POST["db_style"];
	$databases = [DB];
	if (DB == "") {
		$databases = $_POST["databases"];
		if (is_string($databases)) {
			$databases = explode("\n", rtrim(str_replace("\r", "", $databases), "\n"));
		}
	}

	foreach ((array) $databases as $db) {
		Admin::get()->dumpDatabase($db);
		if (Connection::get()->selectDatabase($db)) {
			if ($is_sql && preg_match('~CREATE~', $style) && ($create = Connection::get()->getValue("SHOW CREATE DATABASE " . idf_escape($db), 1))) {
				set_utf8mb4($create);
				if ($style == "DROP+CREATE") {
					echo "DROP DATABASE IF EXISTS " . idf_escape($db) . ";\n";
				}
				echo "$create;\n";
			}
			if ($is_sql) {
				if ($style) {
					echo use_sql($db) . ";\n\n";
				}
				$out = "";

				if ($_POST["types"]) {
					foreach (types() as $id => $type) {
						$enums = type_values($id);
						if ($enums) {
							$out .= ($style != 'DROP+CREATE' ? "DROP TYPE IF EXISTS " . idf_escape($type) . ";;\n" : "") . "CREATE TYPE " . idf_escape($type) . " AS ENUM ($enums);\n\n";
						} else {
							//! https://github.com/postgres/postgres/blob/REL_17_4/src/bin/pg_dump/pg_dump.c#L10846
							$out .= "-- Could not export type $type\n\n";
						}
					}
				}

				if ($_POST["routines"]) {
					foreach (routines() as $row) {
						$name = $row["ROUTINE_NAME"];
						$routine = $row["ROUTINE_TYPE"];
						$create = create_routine($routine, ["name" => $name] + routine($row["SPECIFIC_NAME"], $routine));
						set_utf8mb4($create);
						$out .= ($style != 'DROP+CREATE' ? "DROP $routine IF EXISTS " . idf_escape($name) . ";;\n" : "") . "$create;\n\n";
					}
				}

				if ($_POST["events"]) {
					foreach (get_rows("SHOW EVENTS", null, "-- ") as $row) {
						$create = remove_definer(Connection::get()->getValue("SHOW CREATE EVENT " . idf_escape($row["Name"]), 3));
						set_utf8mb4($create);
						$out .= ($style != 'DROP+CREATE' ? "DROP EVENT IF EXISTS " . idf_escape($row["Name"]) . ";;\n" : "") . "$create;;\n\n";
					}
				}

				echo ($out && DIALECT == 'sql' ? "DELIMITER ;;\n\n$out" . "DELIMITER ;\n\n" : $out);
			}

			if ($_POST["table_style"] || $_POST["data_style"]) {
				$views = [];
				foreach (table_status('', true) as $name => $table_status) {
					$table = (DB == "" || in_array($name, (array) $_POST["tables"]));
					$data = (DB == "" || in_array($name, (array) $_POST["data"]));
					if ($table || $data) {
						if ($ext == "tar") {
							$tmp_file = new TmpFile;
							ob_start([$tmp_file, 'write'], 1e5);
						}

						Admin::get()->dumpTable($name, ($table ? $_POST["table_style"] : ""), (is_view($table_status) ? 2 : 0));
						if (is_view($table_status)) {
							$views[] = $name;
						} elseif ($data) {
							$fields = fields($name);
							Admin::get()->dumpData($name, $_POST["data_style"], "SELECT *" . convert_fields($fields, $fields) . " FROM " . table($name));
						}
						if ($is_sql && $_POST["triggers"] && $table && ($triggers = trigger_sql($name))) {
							echo "\nDELIMITER ;;\n$triggers\nDELIMITER ;\n";
						}

						if ($ext == "tar") {
							ob_end_flush();
							tar_file((DB != "" ? "" : "$db/") . "$name.csv", $tmp_file);
						} elseif ($is_sql) {
							echo "\n";
						}
					}
				}

				// add FKs after creating tables (except in MySQL which uses SET FOREIGN_KEY_CHECKS=0)
				if (function_exists('AdminNeo\foreign_keys_sql')) {
					foreach (table_status('', true) as $name => $table_status) {
						$table = (DB == "" || in_array($name, (array) $_POST["tables"]));
						if ($table && !is_view($table_status)) {
							echo foreign_keys_sql($name);
						}
					}
				}

				foreach ($views as $view) {
					Admin::get()->dumpTable($view, $_POST["table_style"], 1);
				}

				if ($ext == "tar") {
					echo pack("x512");
				}
			}
		}
	}

	if ($is_sql) {
		echo "-- " . gmdate("Y-m-d H:i:s e") . "\n";
	}
	exit;
}

$name = DB !== null ? h(DB) : (SERVER != "" ? h(Admin::get()->getServerName(SERVER)) : lang('Server'));
page_header(lang('Export') . ": $name", ($_GET["export"] != "" ? ["table" => $_GET["export"]] : [lang('Export')]));

echo "<form action='' method='post'>\n";
echo "<table class='box'>\n";

$db_style = ['', 'USE', 'DROP+CREATE', 'CREATE'];
$table_style = ['', 'DROP+CREATE', 'CREATE'];
$data_style = ['', 'TRUNCATE+INSERT', 'INSERT'];
if (DIALECT == "sql") { //! use insertUpdate() in all drivers
	$data_style[] = 'INSERT+UPDATE';
}

echo "<tr><th>", lang('Format'), "</th><td>", html_radios("format", Admin::get()->getDumpFormats(), $settings->getParameter("dumpFormat", "sql")), "</td></tr>\n";

if (DIALECT != "sqlite") {
	echo "<tr><th>", lang('Database'), "</th>";
	echo "<td>", html_select('db_style', $db_style, $settings->getParameter("dumpDbStyle", DB == "" ? "CREATE" : ""));

	echo "<span class='labels'>";
	if (support("type")) {
		echo checkbox("types", 1, $settings->getParameter("dumpTypes"), lang('User types'));
	}
	if (support("routine")) {
		echo checkbox("routines", 1, $settings->getParameter("dumpRoutines", $_GET["dump"] == "" ? "1" : ""), lang('Routines'));
	}
	if (support("event")) {
		echo checkbox("events", 1, $settings->getParameter("dumpEvents", $_GET["dump"] == "" ? "1" : ""), lang('Events'));
	}
	echo "</span></td></tr>";
}

echo "<tr><th>", lang('Tables'), "</th><td>";
echo html_select('table_style', $table_style, $settings->getParameter("dumpTableStyle", "DROP+CREATE"));

echo " <span class='labels'>";
echo checkbox("auto_increment", 1, $settings->getParameter("dumpAutoIncrement"), lang('Auto Increment'));
if (support("trigger")) {
	echo checkbox("triggers", 1, $settings->getParameter("dumpTriggers", "1"), lang('Triggers'));
}
echo "</span></td></tr>";

echo "<tr><th>", lang('Data'), "</th><td>", html_select("data_style", $data_style, $settings->getParameter("dumpDataStyle", "INSERT")), "</td></tr>";

echo "<tr><th>", lang('Output'), "</th><td>", html_radios("output", Admin::get()->getDumpOutputs(), $settings->getParameter("dumpOutput", "file")), "</td></tr>\n";
echo "</table>\n";

echo "<p>";
echo "<input type='submit' class='button default' value='", lang('Export'), "'>";
echo input_token();
echo "</p>\n";

echo "<table>\n";
echo script("qsl('table').onclick = dumpClick;");

$prefixes = [];
if (DB != "") {
	$checked = ($TABLE != "" ? "" : " checked");
	echo "<thead><tr>";
	echo "<th><label class='block'><input type='checkbox' id='check-tables'$checked>" . lang('Tables') . "</label>" . script("gid('check-tables').onclick = partial(formCheck, /^tables\\[/);", "");
	echo "<th class='right'><label class='block'>" . lang('Data') . "<input type='checkbox' id='check-data'$checked></label>" . script("gid('check-data').onclick = partial(formCheck, /^data\\[/);", "");
	echo "</thead>\n";

	$views = "";
	$tables_list = tables_list();
	foreach ($tables_list as $name => $type) {
		$prefix = preg_replace('~_.*~', '', $name);
		$checked = ($TABLE == "" || $TABLE == (substr($TABLE, -1) == "%" ? "$prefix%" : $name)); //! % may be part of table name
		$print = "<tr><td>" . checkbox("tables[]", $name, $checked, $name, "", "block");
		if ($type !== null && !preg_match('~table~i', $type)) {
			$views .= "$print\n";
		} else {
			echo "$print<td class='right'><label class='block'><span id='Rows-" . h($name) . "'></span>" . checkbox("data[]", $name, $checked) . "</label>\n";
		}
		$prefixes[$prefix]++;
	}
	echo $views;

	if ($tables_list) {
		echo script("ajaxSetHtml('" . js_escape(ME) . "script=db');");
	}

} else {
	echo "<thead><tr><th>";
	echo "<label class='block'><input type='checkbox' id='check-databases'" . ($TABLE == "" ? " checked" : "") . ">" . lang('Database') . "</label>";
	echo script("gid('check-databases').onclick = partial(formCheck, /^databases\\[/);", "");
	echo "</thead>\n";
	$databases = Admin::get()->getDatabases();
	if ($databases) {
		foreach ($databases as $db) {
			if (!information_schema($db)) {
				$prefix = preg_replace('~_.*~', '', $db);
				echo "<tr><td>" . checkbox("databases[]", $db, $TABLE == "" || $TABLE == "$prefix%", $db, "", "block") . "\n";
				$prefixes[$prefix]++;
			}
		}
	} else {
		echo "<tr><td><textarea name='databases' rows='10' cols='20'></textarea>";
	}
}

echo "</table>\n";
echo "</form>\n";

$links = [];
foreach ($prefixes as $key => $val) {
	if ($key != "" && $val > 1) {
		$links[] = "<a href='" . h(ME) . "dump=" . urlencode("$key%") . "'>" . icon("check") . h($key) . "*</a>";
	}
}
if ($links) {
	echo "<p class='links'>";
	echo implode("", $links);
	echo "</p>\n";
}
