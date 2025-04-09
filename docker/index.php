<?php

use AdminNeo\JsonPreviewPlugin;
use AdminNeo\Pluginer;

function create_adminneo(): Pluginer
{
	foreach (glob("plugins/*.php") as $filename) {
		require $filename;
	}

	$plugins = [
		new JsonPreviewPlugin(),
	];

	$variables = [
		"theme" => "ADMINNEO_THEME",
		"colorVariant" => "ADMINNEO_COLOR_VARIANT",
		"navigationMode" => "ADMINNEO_NAVIGATION_MODE",
		"preferSelection" => "ADMINNEO_PREFER_SELECTION",
		"jsonValuesDetection" => "ADMINNEO_JSON_VALUES_DETECTION",
		"jsonValuesAutoFormat" => "ADMINNEO_JSON_VALUES_AUTO_FORMAT",
		"enumAsSelectThreshold" => "ADMINNEO_ENUM_AS_SELECT_THRESHOLD",
		"recordsPerPage" => "ADMINNEO_RECORDS_PER_PAGE",
		"versionVerification" => "ADMINNEO_VERSION_VERIFICATION",
//		"hiddenDatabases" => "ADMINNEO_HIDDEN_DATABASES",
//		"hiddenSchemas" => "ADMINNEO_HIDDEN_SCHEMAS",
//		"visibleCollations" => "ADMINNEO_VISIBLE_COLLATIONS",
		"defaultDriver" => "ADMINNEO_DEFAULT_DRIVER",
		"defaultPasswordHash" => "ADMINNEO_DEFAULT_PASSWORD_HASH",
		"sslKey" => "ADMINNEO_SSL_KEY",
		"sslCertificate" => "ADMINNEO_SSL_CERTIFICATE",
		"sslCaCertificate" => "ADMINNEO_SSL_CA_CERTIFICATE",
		"sslMode" => "ADMINNEO_SSL_MODE",
		"sslEncrypt" => "ADMINNEO_SSL_ENCRYPT",
		"sslTrustServerCertificate" => "ADMINNEO_SSL_TRUST_SERVER_CERTIFICATE",
//		"servers" => "ADMINNEO_SERVERS",
	];

	$config = [];
	foreach ($variables as $option => $variable) {
		$value = getenv($variable);

		if ($value === false) {
			continue;
		} elseif ($value == "null") {
			$value = null;
		} elseif ($value == "true") {
			$value = true;
		} elseif ($value == "false") {
			$value = false;
		} elseif (is_numeric($value)) {
			$value = (int)$value;
		}

		$config[$option] = $value;
	}

	return new Pluginer($plugins, $config);
}

require "adminneo.php";
