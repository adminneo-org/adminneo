<?php

namespace AdminNeo;

/**
 * Allows using AdminNeo or EditorNeo inside a frame by modifying `X-Frame-Options` and `Content-Security-Policy`
 * HTTP headers.
 *
 * @link https://www.adminer.org/plugins/#use
 *
 * @author Peter Knut
 *
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class FrameSupportPlugin
{
	/** @var string[] */
	private $frameAncestors;

	/**
	 * List of ancestors can contain sources that are allowed to embed AdminNeo as defined in
	 * [frame-ancestors directive specification](https://developer.mozilla.org/en-US/docs/Web/HTTP/Reference/Headers/Content-Security-Policy/frame-ancestors).
	 * Value `self` can be used to allow all ancestor frames from the same origin.
	 *
	 * For example: `["self", "https://adminneo.example.org"]`
	 *
	 * @param string[] $frameAncestors List of allowed ancestors.
	 */
	public function __construct(array $frameAncestors = ["self"])
	{
		$this->frameAncestors = array_map(function ($source) {
			return preg_replace('~^(self|none)$~', "'$1'", $source);
		}, $frameAncestors);

		if (in_array("'none'", $this->frameAncestors)) {
			$this->frameAncestors = [];
		}
	}

	public function headers(): void
	{
		// Note: Do not unset X-Frame-Options if ancestors list contains only URL pages without 'self' source.
		// It would lower the security on old browsers without Content-Security-Policy support.
		if (in_array("'self'", $this->frameAncestors)) {
			header("X-Frame-Options: SAMEORIGIN");
		}
	}

	public function getCspHeader(): ?array
	{
		if (!$this->frameAncestors) {
			return null;
		}

		$csp = admin()->callParent(__FUNCTION__);
		$csp["frame-ancestors"] = implode(" ", $this->frameAncestors);

		return $csp;
	}

	public function head(): ?bool
	{
		$nonce = nonce();

		echo "
		<script $nonce>
			parent.postMessage({
				event: 'adminneo-loading',
				url: window.location.href,
				title: document.title
			}, '*');
		</script>
		";

		return null;
	}
}
