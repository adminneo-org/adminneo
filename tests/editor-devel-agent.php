<?php

use AdminNeo\Admin;
use AdminNeo\FrameSupportPlugin;
use AdminNeo\JsonPreviewPlugin;
use AdminNeo\SlugifyEditPlugin;
use AdminNeo\TranslationPlugin;
use const AdminNeo\SERVER;

function adminneo_instance()
{
	class PluginsEditor extends Admin
	{
		public function getServiceTitle(): string
		{
			return 'Agent Devel';
		}

		public function getDatabase(): ?string
		{
			return 'adminneo_test';
		}

		public function getCredentials(): array
		{
			return [SERVER, "test", "test"];
		}
	}

	$config = [
		"colorVariant" => "green",
		"jsonValuesDetection" => true,
		"jsonValuesAutoFormat" => true,
		"relationLinks" => true,
		"defaultPasswordHash" => "",
		"sslTrustServerCertificate" => true,
	];

	$plugins = [
		new JsonPreviewPlugin(),
		new TranslationPlugin(),
		new SlugifyEditPlugin(),
		new FrameSupportPlugin(),
	];

	return PluginsEditor::create($config, $plugins);
}

chdir("../editor/");

require "index.php";
