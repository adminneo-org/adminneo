<?php

use AdminNeo\AdminerDumpAlter;
use AdminNeo\AdminerDumpBz2;
use AdminNeo\AdminerDumpJson;
use AdminNeo\AdminerDumpXml;
use AdminNeo\AdminerDumpZip;
use AdminNeo\AdminerEditForeign;
use AdminNeo\AdminerEnumOption;
use AdminNeo\AdminerFileUpload;
use AdminNeo\AdminerForeignSystem;
use AdminNeo\AdminerJsonPreview;
use AdminNeo\AdminerSlugify;
use AdminNeo\AdminerTranslation;
use AdminNeo\Pluginer;

function create_adminer(): Pluginer
{
	foreach (glob("../plugins/*.php") as $filename) {
		include $filename;
	}

	$plugins = [
		new AdminerDumpJson,
		new AdminerDumpBz2,
		new AdminerDumpZip,
		new AdminerDumpXml,
		new AdminerDumpAlter,
		// new AdminerSqlLog("past-" . rtrim(`git describe --tags --abbrev=0`) . ".sql"),
		// new AdminerEditCalendar(script_src("../externals/jquery-ui/jquery-1.4.4.js") . script_src("../externals/jquery-ui/ui/jquery.ui.core.js") . script_src("../externals/jquery-ui/ui/jquery.ui.widget.js") . script_src("../externals/jquery-ui/ui/jquery.ui.datepicker.js") . script_src("../externals/jquery-ui/ui/jquery.ui.mouse.js") . script_src("../externals/jquery-ui/ui/jquery.ui.slider.js") . script_src("../externals/jquery-timepicker/jquery-ui-timepicker-addon.js") . "<link rel='stylesheet' href='../externals/jquery-ui/themes/base/jquery.ui.all.css'>\n<style>\n.ui-timepicker-div .ui-widget-header { margin-bottom: 8px; }\n.ui-timepicker-div dl { text-align: left; }\n.ui-timepicker-div dl dt { height: 25px; }\n.ui-timepicker-div dl dd { margin: -25px 0 10px 65px; }\n.ui-timepicker-div td { font-size: 90%; }\n</style>\n", "../externals/jquery-ui/ui/i18n/jquery.ui.datepicker-%s.js"),
		// new AdminerTinymce("../externals/tinymce/jscripts/tiny_mce/tiny_mce_dev.js"),
		// new AdminerWymeditor(["../externals/wymeditor/src/jquery/jquery.js", "../externals/wymeditor/src/wymeditor/jquery.wymeditor.js", "../externals/wymeditor/src/wymeditor/jquery.wymeditor.explorer.js", "../externals/wymeditor/src/wymeditor/jquery.wymeditor.mozilla.js", "../externals/wymeditor/src/wymeditor/jquery.wymeditor.opera.js", "../externals/wymeditor/src/wymeditor/jquery.wymeditor.safari.js"]),
		new AdminerFileUpload(""),
		new AdminerJsonPreview,
		new AdminerSlugify,
		new AdminerTranslation,
		new AdminerForeignSystem,
		new AdminerEnumOption,
		new AdminerEditForeign,
	];

	$servers = [
		["driver" => "mysql", "name" => "Devel DB"],
		["driver" => "pgsql", "server" => "localhost:5432", "database" => "postgres", "config" => ["colorVariant" => null]],
		["driver" => "sqlite", "database" => "/projects/my-service/test.db", "config" => ["defaultPasswordHash" => ""]],
	];

	$config = [
		"colorVariant" => "green",
		"navigationMode" => "dual",
		"preferSelection" => true,
		"recordsPerPage" => 30,
		"hiddenDatabases" => ["__system"],
		"hiddenSchemas" => ["__system"],
		"sslTrustServerCertificate" => true,
		"visibleCollations" => ["utf8mb4*czech*ci", "ascii_general_ci"],
//		"servers" => $servers,
	];

	return new Pluginer($plugins, $config);
}

include "index.php";
