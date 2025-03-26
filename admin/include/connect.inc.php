<?php

namespace AdminNeo;

/**
 * @var Admin $admin
 * @var ?Min_DB $connection
 * @var ?Min_Driver $driver
 */

if (isset($_GET["status"])) {
	$_GET["variables"] = $_GET["status"];
}
if (isset($_GET["import"])) {
	$_GET["sql"] = $_GET["import"];
}

if (!(DB != "" ? $connection->select_db(DB) : isset($_GET["sql"]) || isset($_GET["dump"]) || isset($_GET["database"]) || isset($_GET["processlist"]) || isset($_GET["privileges"]) || isset($_GET["user"]) || isset($_GET["variables"]) || $_GET["script"] == "connect" || $_GET["script"] == "kill")) {
	if (DB != "" || $_GET["refresh"]) {
		restart_session();
		set_session("dbs", null);
	}
	if (DB != "") {
		header("HTTP/1.1 404 Not Found");
		page_header(lang('Database') . ": " . h(DB), lang('Invalid database.'), true, "db");
	} else {
		if ($_POST["db"] && !$error) {
			queries_redirect(substr(ME, 0, -1), lang('Databases have been dropped.'), drop_databases($_POST["db"]));
		}

		$server_name = $admin->getServerName(SERVER);
		$title = h($drivers[DRIVER]) . ": " . ($server_name != "" ? h($server_name) : lang('Server'));

		page_header($title, $error, false, "db");

		$links = [
			'privileges' => [lang('Privileges'), "users"],
			'processlist' => [lang('Process list'), "list"],
			'variables' => [lang('Variables'), "variable"],
			'status' => [lang('Status'), "status"],
		];
		$links_html = "";
		foreach ($links as $key => $val) {
			if (support($key)) {
				$links_html .= "<a href='" . h(ME) . "$key='>" . icon($val[1]) . "$val[0]</a>";
			}
		}
		if ($links_html) {
			echo "<p id='top-links' class='links'>$links_html</p>\n";
		}

		echo "<p>" . lang('%s version: %s through PHP extension %s', $drivers[DRIVER], "<b>" . h($connection->server_info) . "</b>", "<b>$connection->extension</b>") . "\n";
		echo "<p>" . lang('Logged as: %s', "<b>" . h(logged_user()) . "</b>") . "\n";
		$databases = $admin->databases();
		if ($databases) {
			$scheme = support("scheme");
			$all_collations = collations();
			echo "<form class='table-footer-parent' action='' method='post'>\n";
			echo "<div class='scrollable'>\n";
			echo "<table class='checkable'>\n";
			echo script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});");

			echo "<thead><tr>"
				. (support("database") ? "<td>" : "")
				. "<th>" . lang('Database') . (get_session("dbs") !== null ? " - <a href='" . h(ME) . "refresh=1'>" . lang('Refresh') . "</a>" : "")
				. "<td>" . lang('Collation')
				. "<td>" . lang('Tables')
				. "<td>" . lang('Size') . " - <a href='" . h(ME) . "dbsize=1'>" . lang('Compute') . "</a>" . script("qsl('a').onclick = partial(ajaxSetHtml, '" . js_escape(ME) . "script=connect');", "")
				. "</thead>\n"
			;

			$databases = ($_GET["dbsize"] ? count_tables($databases) : array_flip($databases));

			foreach ($databases as $db => $tables) {
				$root = h(ME) . "db=" . urlencode($db);
				$id = h("Db-" . $db);
				echo "<tr>" . (support("database") ? "<td class='actions'>" . checkbox("db[]", $db, in_array($db, (array) $_POST["db"]), "", "", "", $id) : "");
				echo "<th><a href='$root' id='$id'>" . h($db) . "</a>";
				$collation = h(db_collation($db, $all_collations));
				echo "<td>" . (support("database") ? "<a href='$root" . ($scheme ? "&amp;ns=" : "") . "&amp;database=' title='" . lang('Alter database') . "'>$collation</a>" : $collation);
				echo "<td align='right'><a href='$root&amp;schema=' id='tables-" . h($db) . "' title='" . lang('Database schema') . "'>" . ($_GET["dbsize"] ? $tables : "?") . "</a>";
				echo "<td align='right' id='size-" . h($db) . "'>" . ($_GET["dbsize"] ? db_size($db) : "?");
				echo "\n";
			}

			echo "</table>\n";
			echo "</div>\n";

			echo (support("database")
				? "<div class='table-footer'><div class='field-sets'>\n"
					. "<fieldset><legend>" . lang('Selected') . " <span id='selected'></span></legend><div class='fieldset-content'>\n"
					. "<input type='hidden' name='all' value=''>" . script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^db/)); };") // used by trCheck()
					. "<input type='submit' class='button' name='drop' value='" . lang('Drop') . "'>" . confirm() . "\n"
					. "</div></fieldset>\n"
					. "</div></div>\n"
				: ""
			);
			echo "<input type='hidden' name='token' value='$token'>\n";
			echo "</form>\n";
			echo script("tableCheck();");
		}
	}

	echo '<p class="links"><a href="' . h(ME) . 'database=">' . icon("database-add") . lang('Create database') . "</a>\n";

	page_footer();
	exit;
}

if (support("scheme")) {
	if (DB != "" && $_GET["ns"] !== "") {
		if (!isset($_GET["ns"])) {
			redirect(preg_replace('~ns=[^&]*&~', '', ME) . "ns=" . get_schema());
		}
		if (!set_schema($_GET["ns"])) {
			header("HTTP/1.1 404 Not Found");
			page_header(lang('Schema') . ": " . h($_GET["ns"]), lang('Invalid schema.'), true, "ns");
			page_footer();
			exit;
		}
	}
}
