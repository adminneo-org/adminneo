<?php

use AdminNeo\Bz2OutputPlugin;
use AdminNeo\EditForeignPlugin;
use AdminNeo\EnumOptionPlugin;
use AdminNeo\FileUploadPlugin;
use AdminNeo\JsonDumpPlugin;
use AdminNeo\JsonPreviewPlugin;
use AdminNeo\Pluginer;
use AdminNeo\SlugifyPlugin;
use AdminNeo\SystemForeignKeysPlugin;
use AdminNeo\TranslationPlugin;
use AdminNeo\XmlDumpPlugin;
use AdminNeo\ZipOutputPlugin;

function create_adminneo(): Pluginer
{
	foreach (glob("../plugins/*.php") as $filename) {
		include $filename;
	}

	$plugins = [
		//new OtpLoginPlugin(base64_decode('RXiwXQLdoq7jVQ==')),
		new Bz2OutputPlugin(),
		new ZipOutputPlugin(),
		new JsonDumpPlugin(),
		new XmlDumpPlugin(),
		// new SqlLogPlugin("past-" . rtrim(`git describe --tags --abbrev=0`) . ".sql"),
		// new EditCalendarPlugin(script_src("../externals/jquery-ui/jquery-1.4.4.js") . script_src("../externals/jquery-ui/ui/jquery.ui.core.js") . script_src("../externals/jquery-ui/ui/jquery.ui.widget.js") . script_src("../externals/jquery-ui/ui/jquery.ui.datepicker.js") . script_src("../externals/jquery-ui/ui/jquery.ui.mouse.js") . script_src("../externals/jquery-ui/ui/jquery.ui.slider.js") . script_src("../externals/jquery-timepicker/jquery-ui-timepicker-addon.js") . "<link rel='stylesheet' href='../externals/jquery-ui/themes/base/jquery.ui.all.css'>\n<style>\n.ui-timepicker-div .ui-widget-header { margin-bottom: 8px; }\n.ui-timepicker-div dl { text-align: left; }\n.ui-timepicker-div dl dt { height: 25px; }\n.ui-timepicker-div dl dd { margin: -25px 0 10px 65px; }\n.ui-timepicker-div td { font-size: 90%; }\n</style>\n", "../externals/jquery-ui/ui/i18n/jquery.ui.datepicker-%s.js"),
		// new TinyMcePlugin("../externals/tinymce/jscripts/tiny_mce/tiny_mce_dev.js"),
		// new WymEditorPlugin(["../externals/wymeditor/src/jquery/jquery.js", "../externals/wymeditor/src/wymeditor/jquery.wymeditor.js", "../externals/wymeditor/src/wymeditor/jquery.wymeditor.explorer.js", "../externals/wymeditor/src/wymeditor/jquery.wymeditor.mozilla.js", "../externals/wymeditor/src/wymeditor/jquery.wymeditor.opera.js", "../externals/wymeditor/src/wymeditor/jquery.wymeditor.safari.js"]),
		new FileUploadPlugin(""),
		new JsonPreviewPlugin(),
		new SlugifyPlugin(),
		new TranslationPlugin(),
		new SystemForeignKeysPlugin(),
		new EnumOptionPlugin(),
		new EditForeignPlugin(),
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
