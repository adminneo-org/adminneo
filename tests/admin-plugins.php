<?php

use AdminNeo\Admin;
use AdminNeo\Bz2OutputPlugin;
use AdminNeo\FileUploadPlugin;
use AdminNeo\ForeignEditPlugin;
use AdminNeo\FrameSupportPlugin;
use AdminNeo\JsonDumpPlugin;
use AdminNeo\JsonPreviewPlugin;
use AdminNeo\SlugifyEditPlugin;
use AdminNeo\SystemForeignKeysPlugin;
use AdminNeo\TranslationPlugin;
use AdminNeo\XmlDumpPlugin;
use AdminNeo\ZipOutputPlugin;

function adminneo_instance()
{
	class PluginsAdmin extends Admin
	{
		public function getServiceTitle(): string
		{
			return 'Plugins Test';
		}
	}

	$servers = [
		"server1" => ["driver" => "mysql", "name" => "Devel"],
		"server2" => ["driver" => "mysql", "name" => "Test", "database" => "adminneo_test"],
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

	$plugins = [
		//new OtpLoginPlugin(base64_decode('RXiwXQLdoq7jVQ==')),
		new Bz2OutputPlugin(),
		new ZipOutputPlugin(),
		new JsonDumpPlugin(),
		new XmlDumpPlugin(),
		// new SqlLogPlugin(),
		// new TinyMcePlugin("../externals/tinymce/tinymce.min.js"),
		new FileUploadPlugin("../export/upload"),
		new JsonPreviewPlugin(true, false),
		new TranslationPlugin(),
		new SystemForeignKeysPlugin(),
		new ForeignEditPlugin(),
		new SlugifyEditPlugin(),
		new FrameSupportPlugin(),
	];

	return PluginsAdmin::create($config, $plugins);
}

chdir("../admin/");

require "../admin/index.php";
