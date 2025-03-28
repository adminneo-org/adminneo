<?php

use AdminNeo\Bz2OutputPlugin;
use AdminNeo\EditForeignPlugin;
use AdminNeo\EnumOptionPlugin;
use AdminNeo\FileUploadPlugin;
use AdminNeo\FrameSupportPlugin;
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
		// new TinyMcePlugin("../externals/tinymce/tinymce.min.js"),
		new FileUploadPlugin(""),
		new JsonPreviewPlugin(),
		new SlugifyPlugin(),
		new TranslationPlugin(),
		new SystemForeignKeysPlugin(),
		new EnumOptionPlugin(),
		new EditForeignPlugin(),
		new FrameSupportPlugin(),
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
		"jsonValuesDetection" => true,
		"jsonValuesAutoFormat" => true,
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
