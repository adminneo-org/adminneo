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

		public function getDatabase(): ?string
		{
			// will be escaped by Admin
			return 'adminneo_test';
		}

		public function getTableName(array $tableStatus): string
		{
			// Tables without comments would return empty string and will be ignored by Editor.
			return $tableStatus["Comment"] ? h($tableStatus["Name"]) : "";
		}

		public function getFieldName(array $field, int $order = 0): string
		{
			// Hide hashes in select.
			if ($order && preg_match('~_(md5|sha1)$~', $field["field"])) {
				return "";
			}

			// Display only column with comments, first five of them plus searched columns.
			if ($order < 5) {
				return h($field["field"]);
			}

			foreach ((array)$_GET["where"] as $key => $where) {
				if ($where["col"] == $field["field"] && ($key >= 0 || $where["val"] != "")) {
					return h($field["field"]);
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
