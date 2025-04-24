<?php

namespace AdminNeo;

/**
 * Restricts login to given IP address.
 *
 * If the remote address is a proxy server, it is possible to set additional restriction to the next client in the line
 * (the last IP address found in X-Forwarded-For HTTP header).
 *
 * @link https://www.adminer.org/plugins/#use
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 * @author Peter Knut
 *
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class IpLoginPlugin
{
	private $ips;
	private $forwardedFor;

	/**
	 * @param array $ips Allowed IP address prefixes.
	 * @param array $forwardedFor Allowed X-Forwarded-For prefixes, empty array means no restriction.
	 */
	function __construct(array $ips, array $forwardedFor = [])
	{
		$this->ips = $ips;
		$this->forwardedFor = $forwardedFor;
	}

	public function authenticate(string $username, string $password): ?string
	{
		foreach ($this->ips as $ip) {
			if (strncasecmp($_SERVER["REMOTE_ADDR"], $ip, strlen($ip)) != 0) {
				continue;
			}

			if (!$this->forwardedFor) {
				return null;
			}

			$header = $_SERVER["HTTP_X_FORWARDED_FOR"] ?? null;
			if (!$header) {
				continue;
			}
			$header = preg_replace('~.*, *~', "", $header);

			foreach ($this->forwardedFor as $forwardedFor) {
				if (strncasecmp($header, $forwardedFor, strlen($forwardedFor)) == 0) {
					return null;
				}
			}
		}

		return lang('Access denied.');
	}
}
