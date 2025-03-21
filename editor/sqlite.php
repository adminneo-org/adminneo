<?php

use AdminNeo\Admin;

function create_adminneo(): Admin
{
	include "../plugins/Pluginer.php";

	class CustomAdmin extends Admin
	{
		public function composeLoginFormRow(string $fieldName, string $heading, string $field): string
		{
			return parent::composeLoginFormRow($fieldName, $heading, str_replace('value="mysql"', 'value="sqlite"', $field));
		}

		function database()
		{
			return "PATH_TO_YOUR_SQLITE_HERE";
		}
	}

	$config = [
		"colorVariant" => "green",
		// Warning! Inline the result of password_hash() so that the password is not visible in the source code.
		"defaultPasswordHash" => password_hash("YOUR_PASSWORD_HERE", PASSWORD_DEFAULT),
	];

	return new CustomAdmin($config);
}

include "index.php";
