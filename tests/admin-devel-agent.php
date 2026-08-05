<?php

use AdminNeo\Admin;

function adminneo_instance()
{
	class AgentAdmin extends Admin
	{
		public function getServiceTitle(): string
		{
			return 'Agent Devel';
		}
	}

	$servers = [
		"mysql9" => ["driver" => "mysql", "server" => "127.0.0.1:3307", "username" => "test", "password" => "test", "name" => "MySQL 9"],
		"mariadb12" => ["driver" => "mysql", "server" => "127.0.0.1", "username" => "test", "password" => "test", "name" => "MariaDB 12"],
		"pgsql18" => ["driver" => "pgsql", "server" => "127.0.0.1:5432", "username" => "test", "password" => "test", "name" => "PostgreSQL 18"],
		"mssql18" => ["driver" => "mssql", "server" => "127.0.0.1:1433", "username" => "test", "password" => '340$Uuxwp7Mcxo7Khy', "name" => "MS SQL 18"],
		"elastic7" => ["driver" => "elastic", "server" => "127.0.0.1:9200", "name" => "Elasticsearch 7"],
		"mongo2" => ["driver" => "mongo", "server" => "127.0.0.1:27017", "username" => "test", "password" => "test", "name" => "Mongo DB 2"],
		"clickhouse26" => ["driver" => "clickhouse", "server" => "127.0.0.1:8123", "username" => "default", "password" => "default", "name" => "Clickhouse 26"],
		"sqlite" => ["driver" => "sqlite", "name" => "SQLite"],
	];

	$config = [
		"colorVariant" => "green",
//		"navigationMode" => "dual",
		"preferSelection" => true,
		"jsonValuesDetection" => true,
		"jsonValuesAutoFormat" => true,
		"relationLinks" => true,
		"recordsPerPage" => 30,
		"hiddenDatabases" => ["__system"],
		"hiddenSchemas" => ["__system"],
		"defaultPasswordHash" => "",
		"sslTrustServerCertificate" => true,
		"visibleCollations" => ["utf8mb4*czech*ci", "ascii_general_ci"],
		"servers" => $servers,
	];

	$plugins = [
//		new OtpLoginPlugin(base64_decode('RXiwXQLdoq7jVQ==')),
		new \AdminNeo\Bz2OutputPlugin(),
		new \AdminNeo\ZipOutputPlugin(),
		new \AdminNeo\JsonDumpPlugin(),
		new \AdminNeo\XmlDumpPlugin(),
//		new \AdminNeo\SqlLogPlugin(),
//		new \AdminNeo\TinyMcePlugin("../externals/tinymce/tinymce.min.js"),
		new \AdminNeo\FileUploadPlugin("../compiled/upload"),
		new \AdminNeo\JsonPreviewPlugin(true, false),
		new \AdminNeo\SystemForeignKeysPlugin(),
		new \AdminNeo\ForeignEditPlugin(),
		new \AdminNeo\SlugifyEditPlugin(),
		new \AdminNeo\FrameSupportPlugin(),
//		new \AdminNeo\GeminiSqlPlugin(),
	];

	return AgentAdmin::create($config, $plugins);
}

chdir("../admin/");

require "index.php";
