<?php

namespace AdminNeo;

if (isset($_GET["set"])) {
	header("Content-Type: text/javascript; charset=utf-8");

	if (!verify_token()) {
		header("HTTP/1.1 403 Forbidden");
		exit;
	}

	if ($_GET["set"] == "navigation-width") {
		save_navigation_width($_POST["width"] ?? "");
	}

	if ($_GET["set"] == "export-settings") {
		Admin::get()->getSettings()->updateParameters([
			"exportFormat" => $_POST["format"] ?? "",
			"exportOutput" => $_POST["output"] ?? "",
		]);
	}

	exit;
}

/**
 * Stores the width of the navigation panel set by dragging its edge, adjusted to the limits.
 *
 * @param numeric-string $width Number of rem units received from the client, empty value restores the default width.
 */
function save_navigation_width(string $width): void
{
	if ($width == "") {
		Admin::get()->getSettings()->updateParameter("navigationWidth", null);
		return;
	}

	$width = min(max((float)$width, Settings::NavigationWidthMin), Settings::NavigationWidthMax);

	Admin::get()->getSettings()->updateParameter("navigationWidth", sprintf("%.2F", $width));
}
