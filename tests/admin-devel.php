<?php

/*
 * This file is used by automated Katalon tests of devel version.
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

chdir("../admin/");

require "index.php";
