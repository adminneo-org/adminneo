<?php
namespace AdminNeo;

$settings = Admin::get()->getSettings();

if ($_POST["export"]) {
	$settings->updateParameters([
		"exportFormat" => $_POST["format"],
		"exportOutput" => $_POST["output"],
	]);

	dump_headers("sql");
	Admin::get()->dumpTable("", "");
	Admin::get()->dumpData("", "table", $_POST["query"]);
	exit;
}

restart_session();
$history_all = &get_session("queries");
$history = &$history_all[DB];
if ($_POST["clear"]) {
	$history = [];
	redirect(remove_from_uri("history"));
}
stop_session();

$title = isset($_GET["import"]) ? lang('Import') : lang('SQL command');
page_header($title, [$title]);
$line_comment = "--" . (DIALECT == "sql" ? " " : "");

if ($_POST) {
	$fp = false;
	if (!isset($_GET["import"])) {
		$query = $_POST["query"];
	} elseif ($_POST["webfile"]) {
		$import_file_path = Admin::get()->getImportFilePath();
		if ($import_file_path) {
			if (file_exists($import_file_path)) {
				$fp = fopen($import_file_path, "rb");
			} elseif (file_exists("$import_file_path.gz")) {
				$fp = fopen("compress.zlib://$import_file_path.gz", "rb");
			}
		}

		$query = $fp ? fread($fp, 1e6) : false;
	} else {
		$query = get_file("sql_file", true, ";");
	}

	if (is_string($query)) { // get_file() returns error as number, fread() as false
		if (function_exists('memory_get_usage') && ($memory_limit = ini_bytes("memory_limit")) != "-1") {
			@ini_set("memory_limit", max($memory_limit, strval(2 * strlen($query) + memory_get_usage() + 8e6))); // @ - may be disabled, 2 - substr and trim, 8e6 - other variables
		}

		if ($query != "" && strlen($query) < 1e6) { // don't add big queries
			$q = $query . (preg_match("~;[ \t\r\n]*\$~", $query) ? "" : ";"); //! doesn't work with DELIMITER |
			if (!$history || first(end($history)) != $q) { // no repeated queries
				restart_session();
				$history[] = [$q, time()]; //! add elapsed time
				set_session("queries", $history_all); // required because reference is unlinked by stop_session()
				stop_session();
			}
		}

		$space = "(?:\\s|/\\*[\s\S]*?\\*/|(?:#|$line_comment)[^\n]*\n?|--\r?\n)";
		$delimiter = ";";
		$delimiter_length = 1;
		$offset = 0;
		$empty = true;

		// connection for exploring indexes and EXPLAIN (to not replace FOUND_ROWS()) //! PDO - silent error
		$connection2 = connect();
		if ($connection2 && DB != "") {
			$connection2->selectDatabase(DB);
			if ($_GET["ns"] != "") {
				set_schema($_GET["ns"], $connection2);
			}
		}

		$commands = 0;
		$errors = [];
		$parse = '[\'"' . (DIALECT == "sql" ? '`#' : (DIALECT == "sqlite" ? '`[' : (DIALECT == "mssql" ? '[' : ''))) . ']|/\*|' . $line_comment . '|$' . (DIALECT == "pgsql" ? '|\$([a-zA-Z]\w*)?\$' : '');
		$total_start = microtime(true);
		$dump_format = Admin::get()->getDumpFormats();
		unset($dump_format["sql"]);

		while ($query != "") {
			if (!$offset && preg_match("~^$space*+DELIMITER\\s+(\\S+)~i", $query, $match)) {
				$delimiter = preg_quote($match[1]);
				$delimiter_length = strlen($match[1]);

				$formatted_query = Admin::get()->formatSqlCommandQuery(trim($match[0]));
				if ($formatted_query != "") {
					echo "<pre><code class='jush-" . DIALECT . "'>$formatted_query</code></pre>\n";
				}

				$query = substr($query, strlen($match[0]));
			} elseif (!$offset && DIALECT == "pgsql" && preg_match("~^($space*+COPY\\s+)[^;]+\\s+FROM\\s+stdin;~i", $query, $match)) {
				$delimiter = "\n\\\\\\.\r?\n";
				$delimiter_length = 3;
				$offset = strlen($match[0]);
			} else {
				preg_match("($delimiter\\s*|$parse)", $query, $match, PREG_OFFSET_CAPTURE, $offset); // always matches
				/** @var int $pos */
				list($found, $pos) = $match[0];
				if (!$found && $fp && !feof($fp)) {
					$query .= fread($fp, 1e5);
				} else {
					if (!$found && rtrim($query) == "") {
						break;
					}
					$offset = $pos + strlen($found);

					if ($found && !preg_match("(^$delimiter)", $found)) { // find matching quote or comment end
						$c_style_escapes = Driver::get()->hasCStyleEscapes() || (DIALECT == "pgsql" && ($pos > 0 && strtolower($query[$pos - 1]) == "e"));

						$pattern = '(';
						if ($found == '/*') {
							$pattern .= '\*/';
						} elseif ($found == '[') {
							$pattern .= ']';
						} elseif (preg_match("~^$line_comment|^#~", $found)) {
							$pattern .= "\n";
						} else {
							$pattern .= preg_quote($found) . ($c_style_escapes ? "|\\\\." : "");
						}
						$pattern .= '|$)s';

						while (preg_match($pattern, $query, $match, PREG_OFFSET_CAPTURE, $offset)) {
							$s = $match[0][0];
							if (!$s && $fp && !feof($fp)) {
								$query .= fread($fp, 1e5);
							} else {
								$offset = $match[0][1] + strlen($s);
								if (!isset($s[0]) || $s[0] != "\\") {
									break;
								}
							}
						}

					} else { // end of a query
						$empty = false;
						$q = substr($query, 0, $pos + $delimiter_length);
						$commands++;
						$print = "<pre id='sql-$commands'><code class='jush-" . DIALECT . "'>" . Admin::get()->formatSqlCommandQuery(trim($q)) . "</code></pre>\n";
						if (DIALECT == "sqlite" && preg_match("~^$space*+ATTACH\\b~i", $q, $match) !== 0) {
							// PHP doesn't support setting SQLITE_LIMIT_ATTACHED
							echo $print;
							echo "<p class='error'>" . lang('ATTACH queries are not supported.') . "\n";
							$errors[] = " <a href='#sql-$commands'>$commands</a>";
							if ($_POST["error_stops"]) {
								break;
							}
						} else {
							if (!$_POST["only_errors"]) {
								echo $print;
								ob_flush();
								flush(); // can take a long time - show the running query
							}
							$start = microtime(true);
							//! don't allow changing of character_set_results, convert encoding of displayed query
							if (Connection::get()->multiQuery($q) && is_object($connection2) && preg_match("~^$space*+USE\\b~i", $q)) {
								$connection2->query($q);
							}

							do {
								$result = Connection::get()->storeResult();

								if (Connection::get()->getError()) {
									echo ($_POST["only_errors"] ? $print : "");
									echo "<p class='error'>", lang('Error in query'), (!empty(Connection::get()->getErrno()) ? " (" . Connection::get()->getErrno() . ")" : ""), ": ", error() . "</p>\n";

									$errors[] = " <a href='#sql-$commands'>$commands</a>";
									if ($_POST["error_stops"]) {
										break 2;
									}
								} else {
									$time = " <span class='time'>(" . format_time($start) . ")</span>";
									$edit_link = (strlen($q) < 1000 ? " <a href='" . h(ME) . "sql=" . urlencode(trim($q)) . "'>" . icon("edit") . lang('Edit') . "</a>" : ""); // 1000 - maximum length of encoded URL in IE is 2083 characters
									$query_info = Connection::get()->getQueryInfo();
									$affected = Connection::get()->getAffectedRows(); // getting warnings overwrites this

									$warnings = ($_POST["only_errors"] ? null : Driver::get()->warnings());
									$warnings_id = "warnings-$commands";
									$warnings_link = $warnings ? "<a href='#$warnings_id' class='toggle'>" . lang('Warnings') . icon_chevron_down() . "</a>" : null;

									$explain = $orgtables = null;
									$explain_id = "explain-$commands";
									$export = false;
									$export_id = "export-$commands";

									if (is_object($result)) {
										if (!$_POST["only_errors"]) {
											echo "<div class='table-result'>\n";
										}

										$limit = (int)$_POST["limit"];
										$orgtables = print_select_result($result, $connection2, [], $limit);

										if (!$_POST["only_errors"]) {
											echo "<p class='links'>";

											$num_rows = $result->getRowsCount();
											echo ($num_rows ? ($limit && $num_rows > $limit ? lang('%d / ', $limit) : "") . lang('%d row(s)', $num_rows) : "");

											echo $time, $edit_link, $warnings_link;

											if ($connection2 && preg_match("~^($space|\\()*+SELECT\\b~i", $q) && ($explain = explain($connection2, $q))) {
												echo "<a href='#$explain_id' class='toggle'>Explain" . icon_chevron_down() . "</a>";
											}

											$export = true;
											echo "<a href='#$export_id' class='toggle'>" . lang('Export') . icon_chevron_down() . "</a>";
											echo "</p>\n";
										}

									} else {
										if (preg_match("~^$space*+(CREATE|DROP|ALTER)$space++(DATABASE|SCHEMA)\\b~i", $q)) {
											restart_session();
											set_session("dbs", null); // clear cache
											stop_session();
										}

										if (!$_POST["only_errors"]) {
											echo "<p class='message' title='" . h($query_info) . "'>", lang('Query executed OK, %d row(s) affected.', $affected);
											echo "$time $edit_link";
											if ($warnings_link) {
												echo ", $warnings_link";
											}
											echo "</p>\n";
										}
									}

									if (!$_POST["only_errors"]) {
										echo script("initToggles(qsl('p'));");
									}

									if ($warnings) {
										echo "<div id='$warnings_id' class='hidden'>\n$warnings</div>\n";
									}

									if ($explain) {
										echo "<div id='$explain_id' class='hidden explain'>\n";
										print_select_result($explain, $connection2, $orgtables);
										echo "</div>\n";
									}

									if ($export) {
										echo "<form id='$export_id' action='' method='post' class='hidden'><p>\n";
										echo html_select("format", $dump_format, $settings->getParameter("exportFormat"));
										echo html_select("output", Admin::get()->getDumpOutputs(), $settings->getParameter("exportOutput")) . " ";
										echo input_hidden("query", $q);
										echo input_token();
										echo " <input type='submit' class='button' name='export' value='" . lang('Export') . "'>";
										echo "</p></form>\n";
									}

									if (is_object($result) && !$_POST["only_errors"]) {
										echo "</div>\n";
									}
								}

								$start = microtime(true);
							} while (Connection::get()->nextResult());
						}

						$query = substr($query, $offset);
						$offset = 0;
					}

				}
			}
		}

		if ($empty) {
			echo "<p class='message'>" . lang('No commands to execute.') . "\n";
		} elseif ($_POST["only_errors"]) {
			$ok_count = $commands - count($errors);
			echo "<p class='" . ($ok_count ? "message" : "error") . "'>" . lang('%d query(s) executed OK.', $commands - count($errors));
			echo " <span class='time'>(" . format_time($total_start) . ")</span>\n";
		} elseif ($errors && $commands > 1) {
			echo "<p class='error'>" . lang('Error in query') . ": " . implode("", $errors) . "\n";
		}
		//! MS SQL - SET SHOWPLAN_ALL OFF

	} else {
		echo "<p class='error'>" . upload_error($query) . "\n";
	}
}

echo "<form action='' method='post' enctype='multipart/form-data' id='form'>\n";

if (!isset($_GET["import"])) {
	$q = $_GET["sql"]; // overwrite $q from if ($_POST) to save memory
	if ($_POST) {
		$q = $_POST["query"];
	} elseif ($_GET["history"] == "all") {
		$q = $history;
	} elseif ($_GET["history"] != "") {
		$q = $history[$_GET["history"]][0];
	}
	echo "<p>";
	textarea("query", $q, 20);
	echo script(($_POST ? "" : "qs('textarea').focus();\n") . "gid('form').onsubmit = partial(sqlSubmit, gid('form'), '" . js_escape(remove_from_uri("sql|limit|error_stops|only_errors|history")) . "');");
	echo "</p>";

	echo "<p><input type='submit' class='button default' value='" . lang('Execute') . "' title='Ctrl+Enter'>";
	echo lang('Limit rows') . ": <input type='number' name='limit' class='input size' value='" . h($_POST ? $_POST["limit"] : $_GET["limit"]) . "'>\n";
} else {
	echo "<div class='field-sets'>\n";
	echo "<fieldset><legend>" . lang('File upload') . "</legend><div class='fieldset-content'>";
	$gz = (extension_loaded("zlib") ? "[.gz]" : "");

	if (ini_bool("file_uploads")) {
		// Ignore post_max_size because it is for all form fields together and bytes computing would be necessary.
		echo "SQL$gz (&lt; " . ini_get("upload_max_filesize") . "B): <input type='file' name='sql_file[]' multiple>";
		echo "<input type='submit' class='button default' value='" . lang('Execute') . "'>";
		echo file_upload_form_script("form", "sql_file[]");
	} else {
		echo lang('File uploads are disabled.');
	}
	echo "</div></fieldset>\n";

	$import_file_path = Admin::get()->getImportFilePath();
	if ($import_file_path) {
		echo "<fieldset><legend>" . lang('From server') . "</legend><div class='fieldset-content'>";
		echo lang('Webserver file %s', "<code>" . h($import_file_path) . "$gz</code>");
		echo ' <input type="submit" class="button default" name="webfile" value="' . lang('Run file') . '">';
		echo "</div></fieldset>\n";
	}
	echo "</div>\n";
	echo "<p>";
}

echo checkbox("error_stops", 1, ($_POST ? $_POST["error_stops"] : isset($_GET["import"]) || $_GET["error_stops"]), lang('Stop on error'));
echo checkbox("only_errors", 1, ($_POST ? $_POST["only_errors"] : isset($_GET["import"]) || $_GET["only_errors"]), lang('Show only errors'));
echo input_token();
echo "</p>\n";

if (!isset($_GET["import"])) {
	Admin::get()->printAfterSqlCommand();
}

if (!isset($_GET["import"]) && $history) {
	echo "<div class='field-sets'>\n";

	print_fieldset_start("history", lang('History'), "history", $_GET["history"] != "");

	for ($val = end($history); $val; $val = prev($history)) { // not array_reverse() to save memory
		$key = key($history);
		list($q, $time, $elapsed) = $val;

		echo " <pre><code class='jush-" . DIALECT . "'>", truncate_utf8(ltrim(str_replace("\n", " ", str_replace("\r", "", preg_replace("~^(#|$line_comment).*~m", '', $q))))), "</code></pre>";
		echo '<p class="links">';
		echo "<a href='" . h(ME . "sql=&history=$key") . "'>" . icon("edit") . lang('Edit') . "</a>";
		echo " <span class='time' title='" . @date('Y-m-d', $time) . "'>" . @date("H:i:s", $time) . // @ - time zone may be not set
			($elapsed ? " ($elapsed)" : "") . "</span>";
		echo "</p>";
	}

	echo "<p><input type='submit' class='button' name='clear' value='" . lang('Clear') . "'>\n";
	echo "<a href='", h(ME . "sql=&history=all") . "' class='button light'>", icon("edit"), lang('Edit all'), "</a></p>\n";

	print_fieldset_end("history");

	echo "</div>\n";
}

echo "</form>\n";
