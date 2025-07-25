<?php

namespace AdminNeo;

$TABLE = $_GET["select"];
$table_status = table_status1($TABLE);
$indexes = indexes($TABLE);
$fields = fields($TABLE);
$foreign_keys = column_foreign_keys($TABLE);
$oid = $table_status["Oid"];
$export_settings = get_settings("neo_export");

$rights = []; // privilege => 0
$columns = []; // selectable columns
$search_columns = []; // searchable columns
$order_columns = []; // searchable columns
$text_length = null;
foreach ($fields as $key => $field) {
	$name = Admin::get()->getFieldName($field);
	$name_plain = html_entity_decode(strip_tags($name), ENT_QUOTES);
	if (isset($field["privileges"]["select"]) && $name != "") {
		$columns[$key] = $name_plain;
		if (is_shortable($field)) {
			$text_length = Admin::get()->processSelectionLength();
		}
	}
	if (isset($field["privileges"]["where"]) && $name != "") {
		$search_columns[$key] = $name_plain;
	}
	if (isset($field["privileges"]["order"]) && $name != "") {
		$order_columns[$key] = $name_plain;
	}
	$rights += $field["privileges"];
}

list($select, $group) = Admin::get()->processSelectionColumns($columns, $indexes);
$select = array_unique($select);
$group = array_unique($group);
$is_group = count($group) < count($select);
$where = Admin::get()->processSelectionSearch($fields, $indexes);
$order = Admin::get()->processSelectionOrder($fields, $indexes);
$limit = Admin::get()->processSelectionLimit();

if ($_GET["modify"] && !Admin::get()->isDataEditAllowed()) {
	redirect(ME . "select=" . urlencode($TABLE));
}

if ($_GET["val"] && is_ajax()) {
	header("Content-Type: text/plain; charset=utf-8");
	foreach ($_GET["val"] as $unique_idf => $row) {
		$as = convert_field($fields[key($row)]);
		$select = [$as ?: idf_escape(key($row))];
		$where[] = where_check($unique_idf, $fields);
		$return = Driver::get()->select($TABLE, $select, $where, $select);
		if ($return) {
			echo reset($return->fetchRow());
		}
	}
	exit;
}

$primary = $unselected = null;
foreach ($indexes as $index) {
	if ($index["type"] == "PRIMARY") {
		$primary = array_flip($index["columns"]);
		$unselected = ($select ? $primary : []);
		foreach ($unselected as $key => $val) {
			if (in_array(idf_escape($key), $select)) {
				unset($unselected[$key]);
			}
		}
		break;
	}
}
if ($oid && !$primary) {
	$primary = $unselected = [$oid => 0];
	$indexes[] = ["type" => "PRIMARY", "columns" => [$oid]];
}

if ($_POST) {
	$where_check = $where;
	if (!$_POST["all"] && is_array($_POST["check"])) {
		$checks = [];
		foreach ($_POST["check"] as $check) {
			$checks[] = where_check($check, $fields);
		}
		$where_check[] = "((" . implode(") OR (", $checks) . "))";
	}
	$where_check = ($where_check ? "\nWHERE " . implode(" AND ", $where_check) : "");
	if ($_POST["export"]) {
		$export_settings = ["output" => $_POST["output"], "format" => $_POST["format"]];
		save_settings($export_settings, "neo_export");

		dump_headers($TABLE);
		Admin::get()->dumpTable($TABLE, "");
		$from = ($select ? implode(", ", $select) : "*")
			. convert_fields($columns, $fields, $select)
			. "\nFROM " . table($TABLE);
		$group_by = ($group && $is_group ? "\nGROUP BY " . implode(", ", $group) : "") . ($order ? "\nORDER BY " . implode(", ", $order) : "");
		if (!is_array($_POST["check"]) || $primary) {
			$query = "SELECT $from$where_check$group_by";
		} else {
			$union = [];
			foreach ($_POST["check"] as $val) {
				// where is not unique so OR can't be used
				$union[] = "(SELECT" . limit($from, "\nWHERE " . ($where ? implode(" AND ", $where) . " AND " : "") . where_check($val, $fields) . $group_by, 1) . ")";
			}
			$query = implode(" UNION ALL ", $union);
		}
		Admin::get()->dumpData($TABLE, "table", $query);
		exit;
	}

	if ($_POST["save"] || $_POST["delete"]) { // edit
		$result = true;
		$affected = 0;
		$set = [];
		if (!$_POST["delete"]) {
			$sent_fields = array_keys($_POST["fields"] + $_POST["function"]);
			foreach ($sent_fields as $name) {
				$val = process_input($fields[$name]);
				if ($val !== null && ($_POST["clone"] || $val !== false)) {
					$set[idf_escape($name)] = ($val !== false ? $val : idf_escape($name));
				}
			}
		}
		if ($_POST["delete"] || $set) {
			if ($_POST["clone"]) {
				$query = "INTO " . table($TABLE) . " (" . implode(", ", array_keys($set)) . ")\nSELECT " . implode(", ", $set) . "\nFROM " . table($TABLE);
			}
			if ($_POST["all"] || ($primary && is_array($_POST["check"])) || $is_group) {
				$result = ($_POST["delete"]
					? Driver::get()->delete($TABLE, $where_check)
					: ($_POST["clone"]
						? queries("INSERT $query$where_check")
						: Driver::get()->update($TABLE, $set, $where_check)
					)
				);
				$affected = Connection::get()->getAffectedRows();
			} else {
				foreach ((array) $_POST["check"] as $val) {
					// where is not unique so OR can't be used
					$where2 = "\nWHERE " . ($where ? implode(" AND ", $where) . " AND " : "") . where_check($val, $fields);
					$result = ($_POST["delete"]
						? Driver::get()->delete($TABLE, $where2, 1)
						: ($_POST["clone"]
							? queries("INSERT" . limit1($TABLE, $query, $where2))
							: Driver::get()->update($TABLE, $set, $where2, 1)
						)
					);
					if (!$result) {
						break;
					}
					$affected += Connection::get()->getAffectedRows();
				}
			}
		}
		$message = lang('%d item(s) have been affected.', $affected);
		if ($_POST["clone"] && $result && $affected == 1) {
			$last_id = last_id();
			if ($last_id) {
				$message = lang('Item%s has been inserted.', " $last_id");
			}
		}
		queries_redirect(remove_from_uri($_POST["all"] && $_POST["delete"] ? "page" : ""), $message, $result);
		if (!$_POST["delete"]) {
			$post_fields = (array) $_POST["fields"];
			edit_form($TABLE, array_intersect_key($fields, $post_fields), $post_fields, !$_POST["clone"]);
			page_footer();
			exit;
		}

	} elseif (!$_POST["import"]) { // modify
		if (!$_POST["val"]) {
			Admin::get()->addError(lang('Ctrl+click on a value to modify it.'));
		} else {
			$result = true;
			$affected = 0;
			foreach ($_POST["val"] as $unique_idf => $row) {
				$set = [];
				foreach ($row as $key => $val) {
					$key = bracket_escape($key, 1); // 1 - back
					$set[idf_escape($key)] = (preg_match('~char|text~', $fields[$key]["type"]) || $val != "" ? Admin::get()->processFieldInput($fields[$key], $val) : "NULL");
				}
				$result = Driver::get()->update(
					$TABLE,
					$set,
					" WHERE " . ($where ? implode(" AND ", $where) . " AND " : "") . where_check($unique_idf, $fields),
					!$is_group && !$primary,
					" "
				);
				if (!$result) {
					break;
				}
				$affected += Connection::get()->getAffectedRows();
			}
			queries_redirect(remove_from_uri(), lang('%d item(s) have been affected.', $affected), $result);
		}

	} elseif (!is_string($file = get_file("csv_file", true))) {
		Admin::get()->addError(upload_error($file));
	} elseif (!preg_match('~~u', $file)) {
		Admin::get()->addError(lang('File must be in UTF-8 encoding.'));
	} else {
		save_settings(["format" => $_POST["import_format"]], "neo_export");

		$cols = array_keys($fields);
		preg_match_all('~(?>"[^"]*"|[^"\r\n]+)+~', $file, $matches);
		$affected = count($matches[0]);
		Driver::get()->begin();
		$separator = ($_POST["import_format"] == "csv;" ? ";" : ($_POST["import_format"] == "tsv" ? "\t" : ","));
		$rows = [];
		foreach ($matches[0] as $key => $val) {
			preg_match_all("~((?>\"[^\"]*\")+|[^$separator]*)$separator~", $val . $separator, $matches2);
			if (!$key && !array_diff($matches2[1], $cols)) { //! doesn't work with column names containing ",\n
				// first row corresponds to column names - use it for table structure
				$cols = $matches2[1];
				$affected--;
			} else {
				$set = [];
				foreach ($matches2[1] as $i => $col) {
					$set[idf_escape($cols[$i])] = ($col == "" && $fields[$cols[$i]]["null"] ? "NULL" : q(preg_match('~^".*"$~s', $col) ? str_replace('""', '"', substr($col, 1, -1)) : $col));
				}
				$rows[] = $set;
			}
		}
		$result = (!$rows || Driver::get()->insertUpdate($TABLE, $rows, $primary));
		if ($result) {
			Driver::get()->commit();
		}
		queries_redirect(remove_from_uri("page"), lang('%d row(s) have been imported.', $affected), $result);
		Driver::get()->rollback(); // after queries_redirect() to not overwrite error
	}
}

$table_name = Admin::get()->getTableName($table_status);
if (is_ajax()) {
	page_headers();
	ob_start();
} else {
	page_header(lang('Select') . ": $table_name", [$table_name]);
}

$set = null;
if (isset($rights["insert"]) || !support("table")) {
	$params = [];
	foreach ((array) $_GET["where"] as $val) {
		if (isset($foreign_keys[$val["col"]]) && count($foreign_keys[$val["col"]]) == 1
			&& ($val["op"] == "=" || (!$val["op"] && (is_array($val["val"]) || !preg_match('~[_%]~', $val["val"]))) // LIKE in Editor
		)) {
			$params["set" . "[" . bracket_escape($val["col"]) . "]"] = $val["val"];
		}
	}

	$set = $params ? "&" . http_build_query($params) : "";
}
Admin::get()->printTableMenu($table_status, $set);

if (!$columns && support("table")) {
	echo "<p class='error'>" . lang('Unable to select the table') . ($fields ? "." : ": " . error()) . "\n";
} else {
	echo "<form action='' id='form'>\n";
	echo "<div style='display: none;'>";
	hidden_fields_get();
	echo (DB != "" ? '<input type="hidden" name="db" value="' . h(DB) . '">' . (isset($_GET["ns"]) ? '<input type="hidden" name="ns" value="' . h($_GET["ns"]) . '">' : "") : ""); // not used in Editor
	echo '<input type="hidden" name="select" value="' . h($TABLE) . '">';
	echo '<input type="submit" class="button" value="' . h(lang('Select')) . '">'; # hidden default submit so filter remove buttons aren't "clicked" on submission from enter key
	echo "</div>\n";
	echo "<div class='field-sets'>\n";
	Admin::get()->printSelectionColumns($select, $columns);
	Admin::get()->printSelectionSearch($where, $search_columns, $indexes);
	Admin::get()->printSelectionOrder($order, $order_columns, $indexes);
	Admin::get()->printSelectionLimit($limit);
	Admin::get()->printSelectionLength($text_length);
	Admin::get()->printSelectionAction($indexes);
	echo "</div>\n</form>\n";

	$page = $_GET["page"] ?? null;
	if ($page == "last") {
		$found_rows = Connection::get()->getValue(count_rows($TABLE, $where, $is_group, $group));
		$page = (int)floor(max(0, $found_rows - 1) / $limit);
	} else {
		$found_rows = false;
		$page = (int)$page;
	}

	$select2 = $select;
	$group2 = $group;
	if (!$select2) {
		$select2[] = "*";
		$convert_fields = convert_fields($columns, $fields, $select);
		if ($convert_fields) {
			$select2[] = substr($convert_fields, 2);
		}
	}
	foreach ($select as $key => $val) {
		$field = $fields[idf_unescape($val)];
		if ($field && ($as = convert_field($field))) {
			$select2[$key] = "$as AS $val";
		}
	}
	if (!$is_group && $unselected) {
		foreach ($unselected as $key => $val) {
			$select2[] = idf_escape($key);
			if ($group2) {
				$group2[] = idf_escape($key);
			}
		}
	}
	$result = Driver::get()->select($TABLE, $select2, $where, $group2, $order, $limit, $page, true);

	if (!$result) {
		echo "<p class='error'>" . error() . "\n";
	} else {
		if (DIALECT == "mssql" && $page) {
			$result->seek($limit * $page);
		}
		echo "<form action='' method='post' enctype='multipart/form-data'>\n";
		echo "<div class='table-footer-parent'>\n";
		$rows = [];
		while ($row = $result->fetchAssoc()) {
			if ($page && DIALECT == "oracle") {
				unset($row["RNUM"]);
			}
			$rows[] = $row;
		}

		// use count($rows) without LIMIT, COUNT(*) without grouping, FOUND_ROWS otherwise (slowest)
		if ($_GET["page"] != "last" && $limit !== null && $group && $is_group && DIALECT == "sql") {
			$found_rows = Connection::get()->getValue(" SELECT FOUND_ROWS()"); // space to allow mysql.trace_mode
		}

		if (!$rows) {
			echo "<p class='message'>" . lang('No rows.') . "\n";
		} else {
			$backward_keys = Admin::get()->getBackwardKeys($TABLE, $table_name);

			echo "<div class='scrollable'>\n";
			echo "<table id='table' class='nowrap checkable'>\n";

			echo script("mixin(gid('table'), {onclick: partialArg(tableClick, false, " . (Admin::get()->isDataEditAllowed() ? "true" : "false") . "), ondblclick: partialArg(tableClick, true), onkeydown: onEditingKeydown});");
			echo "<thead><tr>";

			if ($group || !$select) {
				echo "<th class='actions'><input type='checkbox' id='all-page' class='jsonly'>" . script("gid('all-page').onclick = partial(formCheck, /check/);", "");
				if (Admin::get()->isDataEditAllowed()) {
					echo " <a href='", h($_GET["modify"] ? remove_from_uri("modify") : $_SERVER["REQUEST_URI"] . "&modify=1") . "' title='", lang('Modify'), "'>", icon_solo("edit-all"), "</a>";
				}
			}

			$names = [];
			$functions = [];
			reset($select);
			$rank = 1;
			foreach ($rows[0] as $key => $val) {
				if (!isset($unselected[$key])) {
					$select_key = key($select);
					$val = $_GET["columns"][$select_key] ?? null;
					$field = $fields[$select ? ($val ? $val["col"] : current($select)) : $key];
					$name = ($field ? Admin::get()->getFieldName($field, $rank) : (isset($val["fun"]) ? "*" : h($key)));
					if ($name != "") {
						$rank++;
						$names[$key] = $name;
						$column = idf_escape($key);
						$href = remove_from_uri('(order|desc)[^=]*|page') . '&order%5B0%5D=' . urlencode($key);
						$desc = "&desc%5B0%5D=1";
						echo "<th id='th[" . h(bracket_escape($key)) . "]'>" . script("mixin(qsl('th'), {onmouseover: partial(columnMouse), onmouseout: partial(columnMouse, ' hidden')});", "");
						$fun = apply_sql_function($val["fun"] ?? null, $name); //! columns looking like functions
						$sortable = isset($field["privileges"]["order"]) || $fun;
						if ($sortable) {
							echo '<a href="', h($href . ($order[0] == $column || $order[0] == $key || (!$order && $is_group && $group[0] == $column) ? $desc : '')), '">', "$fun</a>"; // $order[0] == $key - COUNT(*)
						} else {
							echo $fun;
						}
						echo "<span class='column hidden'>";
						if ($sortable) {
							echo "<a href='" . h($href . $desc) . "' title='" . lang('descending') . "' class='button light'>", icon_solo("arrow-down"), "</a>";
						}
						if (!isset($val["fun"]) && isset($field["privileges"]["where"])) {
							echo '<a href="#fieldset-search" title="' . lang('Search') . '" class="button light jsonly">', icon_solo("search"), '</a>';
							echo script("qsl('a').onclick = partial(selectSearch, '" . js_escape($key) . "');");
						}
						echo "</span>";
					}
					$functions[$key] = $val["fun"] ?? null;
					next($select);
				}
			}

			$lengths = [];
			if ($_GET["modify"]) {
				foreach ($rows as $row) {
					foreach ($row as $key => $val) {
						$lengths[$key] = max($lengths[$key], min(40, strlen(utf8_decode($val))));
					}
				}
			}

			echo ($backward_keys ? "<th>" . lang('Relations') : "") . "</thead>\n";

			if (is_ajax()) {
				ob_end_clean();
			}

			foreach (Admin::get()->fillForeignDescriptions($rows, $foreign_keys) as $n => $row) {
				$unique_array = unique_array($rows[$n], $indexes);
				if (!$unique_array) {
					$unique_array = [];
					foreach ($rows[$n] as $key => $val) {
						if (!preg_match('~^(COUNT\((\*|(DISTINCT )?`(?:[^`]|``)+`)\)|(AVG|GROUP_CONCAT|MAX|MIN|SUM)\(`(?:[^`]|``)+`\))$~', $key)) { //! columns looking like functions
							$unique_array[$key] = $val;
						}
					}
				}
				$unique_idf = "";
				foreach ($unique_array as $key => $val) {
					$field = $fields[$key] ?? null;

					if ((DIALECT == "sql" || DIALECT == "pgsql") && $field && preg_match('~char|text|enum|set~', $field["type"]) && strlen($val) > 64) {
						$key = (strpos($key, '(') ? $key : idf_escape($key)); //! columns looking like functions
						$key = "MD5(" . (DIALECT != 'sql' || preg_match("~^utf8~", $field["collation"] ?? "") ? $key : "CONVERT($key USING " . charset(Connection::get()) . ")") . ")";
						$val = md5($val);
					}
					$unique_idf .= "&" . ($val !== null ? urlencode("where[" . bracket_escape($key) . "]") . "=" . urlencode($val === false ? "f" : $val) : "null%5B%5D=" . urlencode($key));
				}
				echo "<tr>";
				if ($group || !$select) {
					echo "<td class='actions'>",
						checkbox("check[]", substr($unique_idf, 1), in_array(substr($unique_idf, 1), (array)$_POST["check"]));

					if (!$is_group && Admin::get()->isDataEditAllowed()) {
						echo " <a href='", h(ME . "edit=" . urlencode($TABLE) . $unique_idf), "' class='edit' title='", lang('Edit'), "'>", icon_solo("edit"), "</a>";
					}
				}

				foreach ($row as $key => $val) {
					if (isset($names[$key])) {
						$field = $fields[$key] ?? null;
						$val = $field ? Connection::get()->formatValue($val, $field) : $val;

						$link = "";
						if ($field && preg_match('~blob|bytea|raw|file~', $field["type"]) && $val != "") {
							$link = ME . 'download=' . urlencode($TABLE) . '&field=' . urlencode($key) . $unique_idf;
						}
						if (!$link && $val !== null) { // link related items
							foreach ((array) $foreign_keys[$key] as $foreign_key) {
								if (count($foreign_keys[$key]) == 1 || end($foreign_key["source"]) == $key) {
									$link = "";
									foreach ($foreign_key["source"] as $i => $source) {
										$link .= where_link($i, $foreign_key["target"][$i], $rows[$n][$source]);
									}
									$link = ($foreign_key["db"] != "" ? preg_replace('~([?&]db=)[^&]+~', '\1' . urlencode($foreign_key["db"]), ME) : ME) . 'select=' . urlencode($foreign_key["table"]) . $link; // InnoDB supports non-UNIQUE keys
									if ($foreign_key["ns"]) {
										$link = preg_replace('~([?&]ns=)[^&]+~', '\1' . urlencode($foreign_key["ns"]), $link);
									}
									if (count($foreign_key["source"]) == 1) {
										break;
									}
								}
							}
						}
						if ($key == "COUNT(*)") { //! columns looking like functions
							$link = ME . "select=" . urlencode($TABLE);
							$i = 0;
							foreach ((array) $_GET["where"] as $v) {
								if (!array_key_exists($v["col"], $unique_array)) {
									$link .= where_link($i++, $v["col"], $v["val"], $v["op"]);
								}
							}
							foreach ($unique_array as $k => $v) {
								$link .= where_link($i++, $k, $v);
							}
						}

						$val = select_value($val, $link, $field, $text_length);
						$escaped_key = bracket_escape($key);
						$id = h("val[$unique_idf][$escaped_key]");
						$value = $_POST["val"][$unique_idf][$escaped_key] ?? null;
						$editable = !is_array($row[$key]) && is_utf8($val) && $rows[$n][$key] == $row[$key] && !$functions[$key] && !($field["generated"] ?? false);
						$text = $field && preg_match('~text|json|lob~', $field["type"]);
						$class = preg_match(number_type(), $field["type"]) && is_numeric(strip_tags($val)) ? "class='number'" : "";
						echo "<td id='$id' $class";
						if (($_GET["modify"] && $editable) || $value !== null) {
							$h_value = h($value !== null ? $value : $row[$key]);
							echo ">" . ($text ? "<textarea name='$id' cols='30' rows='" . (substr_count($row[$key], "\n") + 1) . "'>$h_value</textarea>" : "<input class='input' name='$id' value='$h_value' size='$lengths[$key]'>");
						} else {
							$long = strpos($val, "<i>…</i>");
							echo " data-text='" . ($long ? 2 : ($text ? 1 : 0)) . "'"
								. ($editable ? "" : " data-warning='" . h(lang('Use edit link to modify this value.')) . "'")
								. ">$val"
							;
						}
					}
				}

				if ($backward_keys) {
					echo "<td>";
				}
				Admin::get()->printBackwardKeys($backward_keys, $rows[$n]);
				echo "</tr>\n"; // close to allow white-space: pre
			}

			if (is_ajax()) {
				exit;
			}

			echo "</table>\n";
			echo script("initToggles(gid('table'));");
			echo "</div>\n"; // scrollable
		}

		if (!is_ajax()) {
			if ($rows || $page) {
				$exact_count = true;

				if ($_GET["page"] != "last") {
					if ($limit == "" || (count($rows) < $limit && ($rows || !$page))) {
						$found_rows = ($page ? $page * $limit : 0) + count($rows);
					} elseif (DIALECT != "sql" || !$is_group) {
						$found_rows = ($is_group ? false : found_rows($table_status, $where));
						if ($found_rows < max(1e4, 2 * ($page + 1) * $limit)) {
							// slow with big tables
							$result = slow_query(count_rows($TABLE, $where, $is_group, $group));
							$found_rows = reset($result);
						} else {
							$exact_count = false;
						}
					}
				}

				$pagination = ($limit !== null && ($found_rows === false || $found_rows > $limit || $page));
				if ($pagination) {
					if (($found_rows === false ? count($rows) + 1 : $found_rows - $page * $limit) > $limit) {
						echo '<p class="links">',
							'<a href="', h(remove_from_uri("page") . "&page=" . ($page + 1)), '" class="loadmore">', icon("expand"), lang('Load more data'), '</a>',
							script("qsl('a').onclick = partial(loadNextPage, " . (+$limit) . ", '" . lang('Loading') . "…');", "");
					}
					echo "\n";
				}

			    echo "<div class='table-footer'><div class='field-sets'>\n";

				if ($pagination) {
					// display first, previous 4, next 4 and last page
					$max_page = ($found_rows === false
						? $page + (count($rows) >= $limit ? 2 : 1)
						: (int) floor(($found_rows - 1) / $limit)
					);
					$dots = "<li>…</li>";

					echo "<fieldset>";

					if (DIALECT != "simpledb") {
						echo "<legend><a href='" . h(remove_from_uri("page")) . "'>" . lang('Page') . "</a></legend>";
						echo script("qsl('a').onclick = function () { pageClick(this.href, +prompt('" . lang('Page') . "', '" . ($page + 1) . "')); return false; };");
						echo "<div id='fieldset-pagination' class='fieldset-content'><ul class='pagination'>";

						echo pagination(0, $page);
						if ($page > 5) {
							echo $dots;
						}

						for ($i = max(1, $page - 4); $i < min($max_page, $page + 5); $i++) {
							echo pagination($i, $page);
						}

						if ($max_page > 0) {
							if ($page + 5 < $max_page) {
								echo $dots;
							}
							echo ($exact_count && $found_rows !== false
								? pagination($max_page, $page)
								: " <a href='" . h(remove_from_uri("page") . "&page=last") . "' title='~$max_page'>" . lang('last') . "</a>"
							);
						}

						echo "</ul></div>";
					} else {
						echo "<legend>" . lang('Page') . "</legend>";
						echo "<div id='fieldset-pagination'><ul class='pagination'>";

						echo pagination(0, $page);
						if ($page > 1) {
							echo $dots;
						}
						if ($page) {
							echo pagination($page, $page);
						}
						if ($max_page > $page) {
							echo pagination($page + 1, $page);
							if ($max_page > $page + 1) {
								echo $dots;
							}
						}

						echo "</ul></div>";
					}

					echo "</fieldset>\n";
				}

				echo "<fieldset>";
				echo "<legend>" . lang('Whole result') . "</legend><div class='fieldset-content'>";
				$display_rows = ($exact_count ? "" : "~ ") . $found_rows;
				echo checkbox("all", 1, 0, ($found_rows !== false ? ($exact_count ? "" : "~ ") . lang('%d row(s)', $found_rows) : ""), "var checked = formChecked(this, /check/); selectCount('selected', this.checked ? '$display_rows' : checked); selectCount('selected2', this.checked || !checked ? '$display_rows' : checked);") . "\n";
				echo "</div></fieldset>\n";

				if (Admin::get()->isDataEditAllowed()) {
					?>
<fieldset<?php echo ($_GET["modify"] ? '' : ' class="jsonly"'); ?>><legend><?php echo lang('Modify'); ?></legend><div class='fieldset-content'>
<input type="submit" class="button" value="<?php echo lang('Save'); ?>"<?php echo ($_GET["modify"] ? '' : ' title="' . lang('Ctrl+click on a value to modify it.') . '"'); ?>>
</div></fieldset>
<fieldset><legend><?php echo lang('Selected'); ?> <span id="selected"></span></legend><div class='fieldset-content'>
<input type="submit" class="button" name="edit" value="<?php echo lang('Edit'); ?>">
<input type="submit" class="button" name="clone" value="<?php echo lang('Clone'); ?>">
<input type="submit" class="button" name="delete" value="<?php echo lang('Delete'); ?>"><?php echo confirm(); ?>
</div></fieldset>
<?php
				}

				$format = Admin::get()->getDumpFormats();
				foreach ((array) $_GET["columns"] as $column) {
					if ($column["fun"]) {
						unset($format['sql']);
						break;
					}
				}
				if ($format) {
					print_fieldset_start("export", lang('Export') . " <span id='selected2'></span>", "export");
					echo html_select("format", $format, $export_settings["format"] ?? null);
					$output = Admin::get()->getDumpOutputs();
					echo ($output ? " " . html_select("output", $output, $export_settings["output"] ?? null) : "");
					echo " <input type='submit' class='button' name='export' value='" . lang('Export') . "'>\n";
					print_fieldset_end("export");
				}

			    echo "</div></div>\n"; // table-footer
				echo script("initTableFooter()");
			}

			echo "</div>\n"; // table-footer-parent

			if (Admin::get()->isDataEditAllowed()) {
				echo "<p>";
				echo "<a href='#import'>", icon("import"), lang('Import') . "</a>";
				echo script("qsl('a').onclick = partial(toggle, 'import');", "");
				echo "</p>";
				echo "<p id='import'" . ($_POST["import"] ? "" : " class='hidden'") . ">";
				echo "<input type='file' name='csv_file'> ";
				echo html_select("import_format", ["csv" => "CSV,", "csv;" => "CSV;", "tsv" => "TSV"], $export_settings["format"]);
				echo " <input type='submit' class='button default' name='import' value='" . lang('Import') . "'>";
				echo "</p>";
			}

			echo "<input type='hidden' name='token' value='", get_token(), "'>\n";
			echo "</form>\n";
			echo (!$group && $select ? "" : script("tableCheck();"));
		} else {
			echo "</div>\n"; // table-footer-parent
		}
	}
}

if (is_ajax()) {
	ob_end_clean();
	exit;
}
