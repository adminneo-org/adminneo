<?php

namespace AdminNeo;

use Exception;

/**
 * Adds time-based one-time password authentication to the login form.
 *
 * The implementation uses standard SHA1 algorithm, 30s time interval and 6-digits code.
 *
 * Permanent login works as a trusted device: it is issued after the code is verified and the code is not required
 * as long as it is valid. Changing the secret invalidates all permanent logins.
 *
 * Last changed in release: !compile: version
 *
 * @link https://www.adminneo.org/plugins/otp-login
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 * @author Peter Knut
 *
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class OtpLoginPlugin extends Plugin
{
	/** @var string */
	protected $secret;

	/**
	 * @param string $secret Decoded secret, e.g. base64_decode("ENCODED_SECRET").
	 */
	public function __construct(string $secret)
	{
		$this->secret = $secret;
	}

	public function init(): ?bool
	{
		// The code of a refused login is not stored, it would replace the verified state of the session.
		if (is_login_verified()) {
			$_SESSION["otp"] = (string)($_POST["auth"]["otp"] ?? "");
		}

		return null;
	}

	public function getLoginFormRow(string $fieldName, string $label, string $field): ?string
	{
		if ($fieldName != "password") return null;

		$otp = $_SESSION["otp"] ?? "";

		return "<tr><th>$label</th><td>$field</td></tr>\n" .
			"<tr><th><abbr title='" . lang('One Time Password') . "'>OTP</abbr></th>" .
			"<td><input class='input' name='auth[otp]' value='" . h(is_string($otp) ? $otp : "") . "' " .
			"size='6' autocomplete='one-time-code' inputmode='numeric' maxlength='6' pattern='\d{6}'/></td>" .
			"</tr>\n";
	}

	public function authenticate(string $username, string $password): ?string
	{
		$otp = $_SESSION["otp"] ?? null;

		// The code was already verified in this session.
		if ($otp === true) return null;

		// Without a submitted code, only the login restored from a valid permanent login is trusted.
		if ($otp === null && get_session("permanent") === true) return null;

		if ((string)$otp == "") {
			return lang('Enter OTP code.');
		}

		$timeSlot = floor(time() / 30);

		foreach ([0, -1, 1] as $skew) {
			if ($otp == $this->getOtp($timeSlot + $skew)) {
				restart_session();
				$_SESSION["otp"] = true;
				stop_session();

				return null;
			}
		}

		return lang('Invalid OTP code.');
	}

	/**
	 * Binds permanent logins to the secret, so they can't be issued by another instance sharing the private key.
	 *
	 * @return string|false
	 *
	 * @throws Exception
	 */
	public function getPrivateKey(bool $create = false)
	{
		$key = get_private_key($create);

		return $key ? bin2hex(Hash::hmacSha1($key, $this->secret)) : false;
	}

	private function getOtp(int $timeSlot): int
	{
		$data = str_pad(pack("N", $timeSlot), 8, "\0", STR_PAD_LEFT);
		$hash = Hash::hmacSha1($data, $this->secret);
		$offset = ord(substr($hash, -1)) & 0xF;
		$unpacked = unpack("N", substr($hash, $offset, 4));

		return ($unpacked[1] & 0x7FFFFFFF) % 1e6;
	}
}
