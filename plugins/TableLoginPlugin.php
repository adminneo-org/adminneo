<?php

namespace AdminNeo;

/**
 * Authenticates a user from the users table.
 *
 * This plugin can be used to manage users access in EditorNeo and/or if connecting to a password-less SQL database.
 *
 * Stored database credentials are sent only to a server from the `servers` configuration, or if no servers are
 * configured, to `defaultServer` with `defaultDriver`. Never to a server chosen by the user in the login form.
 *
 * Requires the table:
 * <pre>
 * CREATE TABLE users (               -- table name is configurable
 *   id int NOT NULL AUTO_INCREMENT,  -- optional, not used internally
 *   username varchar(30) NOT NULL,   -- any length
 *   password varchar(255) NOT NULL,  -- the result of password_hash($password, PASSWORD_DEFAULT)
 *   PRIMARY KEY (id),
 *   UNIQUE (username)
 * );
 * </pre>
 *
 * The minimum required PHP version is 5.5.
 *
 * Last changed in release: !compile: version
 *
 * @link https://www.adminneo.org/plugins/#usage
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 * @author Peter Knut
 *
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class TableLoginPlugin extends Plugin
{
	/** @var string */
	protected $database;

	/** @var string */
	protected $table;

	/** @var string[] */
	protected $credentials;

	/**
	 * @param string $database Database name.
	 * @param string $table Table name.
	 * @param string[] $credentials Database credentials in form [user, password].
	 */
	public function __construct(string $database, string $table = "users", array $credentials = ["", ""])
	{
		$this->database = $database;
		$this->table = $table;
		$this->credentials = $credentials;
	}

	public function getCredentials(): ?array
	{
		$server = $this->getAllowedServer();
		if ($server === null) {
			return null;
		}

		return array_merge([$server], $this->credentials);
	}

	public function authenticate(string $username, string $password): ?bool
	{
		if ($this->getAllowedServer() === null) {
			return false;
		}

		if (DRIVER == "sqlite") {
			Connection::get()->selectDatabase($this->database);
			$dbPrefix = "";
		} else {
			$dbPrefix = idf_escape($this->database) . ".";
		}

		$hash = Connection::get()->getValue(
			"SELECT password FROM $dbPrefix" . idf_escape($this->table) . " WHERE username = " . q($username)
		);

		return $hash && password_verify($password, $hash);
	}

	/**
	 * Returns the server address the stored credentials can be sent to, null for a server chosen by the user.
	 */
	private function getAllowedServer(): ?string
	{
		$server = $this->config->getServer(SERVER);
		if ($server) {
			return $server->getServer();
		}

		// Without stored credentials, the user connects with their own ones.
		if (implode("", $this->credentials) === "") {
			return SERVER;
		}

		if ($this->config->hasServers() ||
			DRIVER != $this->config->getDefaultDriver(Drivers::getList()) ||
			SERVER !== (string)$this->config->getDefaultServer()
		) {
			return null;
		}

		return SERVER;
	}
}
