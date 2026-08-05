<?php

/*
 * This file is used by automated Katalon tests of compiled version.
 */

use AdminNeo\Admin;

if (!file_exists("../compiled/adminneo.php")) {
	exec("php ../bin/compile.php");
}

function adminneo_instance()
{
	$config = [
		"defaultPasswordHash" => "",
		"sslTrustServerCertificate" => true,
	];

	return Admin::create($config);
}

chdir("../compiled/");

require "adminneo.php";
