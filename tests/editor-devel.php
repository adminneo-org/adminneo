<?php

/*
 * This file is used by automated Katalon tests of compiled version.
 */

use AdminNeo\Admin;

function adminneo_instance()
{
	$config = [
		"defaultPasswordHash" => "",
		"sslTrustServerCertificate" => true,
	];

	return Admin::create($config);
}

chdir("../editor/");

require "index.php";
