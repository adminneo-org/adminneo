<?php

namespace AdminNeo;

/**
 * Authenticates a user from the users table. This plugin can be used for password-less SQL databases to manage users
 * access.
 *
 * Requires the table:
 * <pre>
 * CREATE TABLE _users (
 *   id int NOT NULL AUTO_INCREMENT, -- optional
 *   username varchar(30) NOT NULL, -- any length
 *   password varchar(255) NOT NULL, -- the result of password_hash($password, PASSWORD_DEFAULT)
 *   PRIMARY KEY (id),
 *   UNIQUE (login)
 * );
 * </pre>
 *
 * @link https://www.adminer.org/plugins/#use
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 * @author Peter Knut
 *
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class TableLoginPlugin
{
	private $database;

	/**
	 * @param string $database Database name with 'login' table.
	 */
	function __construct(string $database)
	{
		$this->database = $database;
	}

	public function getCredentials(): ?array
	{
		return ["", ""];
	}

	public function authenticate(string $username, string $password): ?bool
	{
		if (DRIVER == "sqlite") {
			connection()->select_db($this->database);
			$dbPrefix = "";
		} else {
			$dbPrefix = idf_escape($this->database) . ".";
		}

		$hash = connection()->result(
			"SELECT password FROM {$dbPrefix}_users WHERE username = " . q($username)
		);

		return $hash && password_verify($password, $hash);
	}
}
