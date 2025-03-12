<?php

use AdminNeo\Admin;
use function AdminNeo\h;

function create_adminneo(): Admin
{
	class CdsEditor extends Admin
	{
		function name()
		{
			// custom name in title and heading
			return 'CDs';
		}

		public function getCredentials(): array
		{
			// ODBC user with password ODBC on localhost
			return ['localhost', 'ODBC', 'ODBC'];
		}

		public function authenticate(string $username, string $password)
		{
			// username: 'admin', password: anything
			return ($username == 'admin');
		}

		function database()
		{
			// will be escaped by Adminer
			return 'adminneo_test';
		}

		function tableName($tableStatus)
		{
			// tables without comments would return empty string and will be ignored by Adminer
			return h($tableStatus["Comment"]);
		}

		function fieldName($field, $order = 0)
		{
			if ($order && preg_match('~_(md5|sha1)$~', $field["field"])) {
				return ""; // hide hashes in select
			}

			// display only column with comments, first five of them plus searched columns
			if ($order < 5) {
				return h($field["comment"]);
			}

			foreach ((array)$_GET["where"] as $key => $where) {
				if ($where["col"] == $field["field"] && ($key >= 0 || $where["val"] != "")) {
					return h($field["comment"]);
				}
			}

			return "";
		}

	}

	return new CdsEditor([
		"colorVariant" => "green",
	]);
}

include "index.php";
