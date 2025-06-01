<?php

namespace AdminNeo;

/**
 * Authenticates a user by a custom method.
 *
 * This plugin allows integrating AdminNeo with environments that use a single sign-on user authentication. It requires
 * the `servers` configuration option to be set together with the database username and password. If only one server is
 * configured, the user will be automatically logged in.
 *
 * @link https://www.adminneo.org/plugins/#usage
 *
 * @author Peter Knut
 *
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class ExternalLoginPlugin extends Plugin
{
	/** @var bool */
	private $authenticated;

	/** @var bool */
	private $hasServers = false;

	/** @var bool */
	private $autologin = false;

	/**
	 * @param bool $authenticated Whether the user is authenticated by the external service.
	 */
	public function __construct(bool $authenticated)
	{
		$this->authenticated = $authenticated;
	}

	public function init(): ?bool
	{
		$servers = $this->config->getServerPairs(Drivers::getList());

		$this->hasServers = count($servers) > 0;
		$this->autologin = count($servers) == 1;

		if ($this->authenticated && $this->autologin) {
			$password = get_password();

			// If the password is not found or expired, store the login information.
			if ($password === null || $password === false) {
				$serverKey = key($servers);
				$server = $this->config->getServer($serverKey);

				session_regenerate_id();
				save_login($server->getDriver(), $serverKey, $server->getUsername(), $server->getPassword(), $server->getDatabase());

				if (!isset($_GET["username"])) {
					redirect(auth_url($server->getDriver(), $serverKey, $server->getUsername(), $server->getDatabase()));
				}
			}
		}

		return null;
	}

	public function getLoginFormRow(string $fieldName, string $label, string $field): ?string
	{
		if (!$this->hasServers) {
			return null;
		}

		// Hide username and password fields.
		return $fieldName == "username" || $fieldName == "password" ? "" : null;
	}

	public function printLogout(): ?bool
	{
		// Hide the logout button if autologin is enabled.
		return $this->autologin ? true : null;
	}

	public function getCredentials(): ?array
	{
		$server = $this->config->getServer(SERVER);
		if (!$server) {
			return null;
		}

		return [$server->getServer(), $server->getUsername(), $server->getPassword()];
	}

	public function authenticate(string $username, string $password): ?bool
	{
		return $this->authenticated;
	}
}
