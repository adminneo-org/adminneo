<?php

namespace AdminNeo;

/**
 * Adds time-based one-time password authentication to the login form.
 *
 * The implementation uses standard SHA1 algorithm, 30s time interval and 6-digits code.
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
		if (isset($_POST["auth"])) {
			$_SESSION["otp"] = (string)$_POST["auth"]["otp"];
		}

		return null;
	}

	public function getLoginFormRow(string $fieldName, string $label, string $field): ?string
	{
		if ($fieldName != "password") return null;

		return "<tr><th>$label</th><td>$field</td></tr>\n" .
			"<tr><th><abbr title='" . lang('One Time Password') . "'>OTP</abbr></th>" .
			"<td><input class='input' name='auth[otp]' value='" . h($_SESSION["otp"]) . "' " .
			"size='6' autocomplete='one-time-code' inputmode='numeric' maxlength='6' pattern='\d{6}'/></td>" .
			"</tr>\n";
	}

	public function authenticate(string $username, string $password): ?string
	{
		if (!isset($_SESSION["otp"])) return null;

		if ($_SESSION["otp"] == "") {
			return lang('Enter OTP code.');
		}

		$timeSlot = floor(time() / 30);

		foreach ([0, -1, 1] as $skew) {
			if ($_SESSION["otp"] == $this->getOtp($timeSlot + $skew)) {
				restart_session();
				unset($_SESSION["otp"]);
				stop_session();

				return null;
			}
		}

		return lang('Invalid OTP code.');
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
