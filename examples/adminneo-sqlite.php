<?php

use AdminNeo\Admin;

function adminneo_instance()
{
	$config = [
		"colorVariant" => "green",

		// Disable verifying custom default password.
		"defaultPasswordHash" => "",

		// Warning! Inline the result of password_hash() so that the password is not visible in the source code.
//		"defaultPasswordHash" => password_hash("YOUR_PASSWORD_HERE", PASSWORD_DEFAULT),
	];

	return Admin::create($config);
}

include "../compiled/adminneo.php";
