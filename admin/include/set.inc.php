<?php

namespace AdminNeo;

if (isset($_GET["set"])) {
	header("Content-Type: text/javascript; charset=utf-8");

	if (!verify_token()) {
		header("HTTP/1.1 403 Forbidden");
		exit;
	}

	if ($_GET["set"] == "navigation-width") {
		// Number of rem units received from the client, empty value restores the default width.
		$width = $_POST["width"] ?? "";
		if ($width != "") {
			$width = min(max((float)$width, Settings::NavigationWidthMin), Settings::NavigationWidthMax);

			Admin::get()->getSettings()->updateParameter("navigationWidth", sprintf("%.2F", $width));
		} else {
			Admin::get()->getSettings()->updateParameter("navigationWidth", null);
		}
	}

	if ($_GET["set"] == "export-settings") {
		Admin::get()->getSettings()->updateParameters([
			"exportFormat" => $_POST["format"] ?? "",
			"exportOutput" => $_POST["output"] ?? "",
		]);
	}

	exit;
}
