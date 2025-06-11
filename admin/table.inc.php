<?php

namespace AdminNeo;

$TABLE = $_GET["table"];
$fields = fields($TABLE);
if (!$fields) {
	Admin::get()->addError(error() ?: lang('No tables.'));
}
$table_status = table_status1($TABLE, true);
$name = Admin::get()->getTableName($table_status);

$rights = [];
foreach ($fields as $key => $field) {
	$rights += $field["privileges"];
}

$title = $fields && is_view($table_status) ? $table_status['Engine'] == 'materialized view' ? lang('Materialized view') : lang('View') : lang('Table');
$table_name = $name != "" ? $name : h($TABLE);
page_header("$title: $table_name", [$table_name]);

$set = null;
if (isset($rights["insert"]) || !support("table")) {
	$set = "";
}
Admin::get()->printTableMenu($table_status, $set);

$info = [];
if (!preg_match("~sqlite|mssql|pgsql~", DIALECT) && isset($table_status["Engine"])) {
	$info[] = lang('Engine') . ": " . h($table_status["Engine"]);
}
if (isset($table_status["Collation"])) {
	$info[] = lang('Collation') . ": " . h($table_status["Collation"]);
}
if ($info) {
	echo "<p>", implode(", ", $info), "</p>";
}

if ($fields) {
	Admin::get()->printTableStructure($fields);
}

$comment = $table_status["Comment"];
if ($comment != "") {
	echo "<p class='keep-lines'>", lang('Comment'), ": ", Admin::get()->formatComment($comment), "</p>\n";
}

if (!is_view($table_status)) {
	$editLink = '<p class="links"><a href="' . h(ME) . 'create=' . urlencode($TABLE) . '">' . icon("edit") . lang('Alter table') . "</a>\n";
} elseif (support("view")) {
	$editLink = '<p class="links"><a href="' . h(ME) . 'view=' . urlencode($TABLE) . '">' . icon("edit") . lang('Alter view') . "</a>\n";
} else {
	$editLink = "";
}

if ($info || $fields || $comment != "") {
	echo $editLink;
}

$parent_tables = Driver::get()->getParentTables($TABLE);
if ($parent_tables) {
	echo "<h2>" . lang('Inherited from') . "</h2>\n";
	echo "<ul class='links'>\n";
	foreach ($parent_tables as $table) {
		echo "<li><a href='", h(ME . "table=" . urlencode($table)), "'>", icon("structure"), h($table), "</a>";
	}
	echo "</ul>\n";
}

if (Driver::get()->getPartitionBy() && str_contains($table_status["Create_options"] ?? "", "partitioned")) {
	$partitions_info = Driver::get()->getPartitionsInfo($TABLE);

	if ($partitions_info) {
		echo "<h2 id='partitions'>" . lang('Partitions') . "</h2>\n";
		Admin::get()->printTablePartitions($partitions_info);

		if (DIALECT != "pgsql") {
			echo $editLink;
		}
	}
}

$inherited_tables = Driver::get()->getInheritedTables($TABLE);
if ($inherited_tables) {
	echo "<h2 id='inherited-by'>" . lang('Inherited tables') . "</h2>\n";
	Admin::get()->printInheritedTables($inherited_tables);
}

if (support("indexes") && Driver::get()->supportsIndex($table_status)) {
	echo "<h2 id='indexes'>" . lang('Indexes') . "</h2>\n";
	$indexes = indexes($TABLE);
	if ($indexes) {
		Admin::get()->printTableIndexes($indexes, $table_status);
	}
	echo '<p class="links"><a href="' . h(ME) . 'indexes=' . urlencode($TABLE) . '">' . icon("edit") . lang('Alter indexes') . "</a>\n";
}

if (!is_view($table_status)) {
	if (fk_support($table_status)) {
		echo "<h2 id='foreign-keys'>" . lang('Foreign keys') . "</h2>\n";
		$foreign_keys = foreign_keys($TABLE);
		if ($foreign_keys) {
			echo "<table>\n";
			echo "<thead><tr><th>" . lang('Source') . "<td>" . lang('Target') . "<td>" . lang('ON DELETE') . "<td>" . lang('ON UPDATE') . "<td></thead>\n";
			foreach ($foreign_keys as $name => $foreign_key) {
				echo "<tr title='" . h($name) . "'>";
				echo "<th><i>" . implode("</i>, <i>", array_map('AdminNeo\h', $foreign_key["source"])) . "</i>";
				echo "<td><a href='" . h($foreign_key["db"] != "" ? preg_replace('~db=[^&]*~', "db=" . urlencode($foreign_key["db"]), ME) : ($foreign_key["ns"] != "" ? preg_replace('~ns=[^&]*~', "ns=" . urlencode($foreign_key["ns"]), ME) : ME)) . "table=" . urlencode($foreign_key["table"]) . "'>"
					. ($foreign_key["db"] != "" && $foreign_key["db"] != DB ? "<b>" . h($foreign_key["db"]) . "</b>." : "")
					. ($foreign_key["ns"] != "" && $foreign_key["ns"] != $_GET["ns"] ? "<b>" . h($foreign_key["ns"]) . "</b>." : "")
					. h($foreign_key["table"])
					. "</a>"
				;
				echo "(<i>" . implode("</i>, <i>", array_map('AdminNeo\h', $foreign_key["target"])) . "</i>)";
				echo "<td>" . h($foreign_key["on_delete"]);
				echo "<td>" . h($foreign_key["on_update"]);
				echo '<td><a href="' . h(ME . 'foreign=' . urlencode($TABLE) . '&name=' . urlencode($name)) . '">' . lang('Alter') . '</a>';
				echo "\n";
			}
			echo "</table>\n";
		}
		echo '<p class="links"><a href="' . h(ME) . 'foreign=' . urlencode($TABLE) . '">' . icon("add") . lang('Add foreign key') . "</a>\n";
	}

	if (support("check")) {
		echo "<h2 id='checks'>" . lang('Checks') . "</h2>\n";
		$check_constraints = Driver::get()->checkConstraints($TABLE);
		if ($check_constraints) {
			echo "<table cellspacing='0'>\n";
			foreach ($check_constraints as $key => $val) {
				echo "<tr title='" . h($key) . "'>";
				echo "<td><code class='jush-" . DIALECT . "'>" . h($val);
				echo "<td><a href='" . h(ME . 'check=' . urlencode($TABLE) . '&name=' . urlencode($key)) . "'>" . lang('Alter') . "</a>";
				echo "\n";
			}
			echo "</table>\n";
		}
		echo '<p class="links"><a href="' . h(ME) . 'check=' . urlencode($TABLE) . '">' . icon("add") . lang('Create check') . "</a>\n";
	}
}

if (support(is_view($table_status) ? "view_trigger" : "trigger")) {
	echo "<h2 id='triggers'>" . lang('Triggers') . "</h2>\n";
	$triggers = triggers($TABLE);
	if ($triggers) {
		echo "<table>\n";
		foreach ($triggers as $key => $val) {
			echo "<tr><td>" . h($val[0]) . "<td>" . h($val[1]) . "<th>" . h($key) . "<td><a href='" . h(ME . 'trigger=' . urlencode($TABLE) . '&name=' . urlencode($key)) . "'>" . lang('Alter') . "</a>\n";
		}
		echo "</table>\n";
	}
	echo '<p class="links"><a href="' . h(ME) . 'trigger=' . urlencode($TABLE) . '">' . icon("add") . lang('Add trigger') . "</a>\n";
}
