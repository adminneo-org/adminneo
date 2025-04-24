<?php

use AdminNeo\Bz2OutputPlugin;
use AdminNeo\FileUploadPlugin;
use AdminNeo\ForeignEditPlugin;
use AdminNeo\FrameSupportPlugin;
use AdminNeo\JsonDumpPlugin;
use AdminNeo\JsonPreviewPlugin;
use AdminNeo\Pluginer;
use AdminNeo\SlugifyEditPlugin;
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
		// new SqlLogPlugin(),
		// new TinyMcePlugin("../externals/tinymce/tinymce.min.js"),
		new FileUploadPlugin("../export/upload"),
		new JsonPreviewPlugin(),
		new TranslationPlugin(),
		new SystemForeignKeysPlugin(),
		new ForeignEditPlugin(),
		new SlugifyEditPlugin(),
		new FrameSupportPlugin(),
	];

	$servers = [
		["driver" => "mysql", "name" => "Devel DB"],
		["driver" => "pgsql", "server" => "localhost:5432", "database" => "postgres", "config" => ["colorVariant" => null]],
		["driver" => "sqlite", "database" => "/projects/my-service/test.db"],
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
		"defaultPasswordHash" => "",
		"sslTrustServerCertificate" => true,
		"visibleCollations" => ["utf8mb4*czech*ci", "ascii_general_ci"],
//		"servers" => $servers,
	];

	return new Pluginer($plugins, $config);
}

include "index.php";
