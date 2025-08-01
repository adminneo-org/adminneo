<?php

/**
 * EditorNeo - Easy-to-use data editor in a single PHP file
 * !compile: version
 *
 * !compile: parameters
 *
 * @link https://www.adminneo.org/editor
 *
 * @author Peter Knut
 * @author Jakub Vrana (https://www.vrana.cz/)
 *
 * @copyright 2007-2025 Jakub Vrána
 * @copyright 2024-2025 Peter Knut
 *
 * @license Apache License, Version 2.0 (https://www.apache.org/licenses/LICENSE-2.0)
 * @license GNU General Public License, version 2 (https://www.gnu.org/licenses/gpl-2.0.html)
 */

namespace AdminNeo;

include "../admin/core/Plugin.php";
include "../admin/core/Origin.php";
include "../admin/core/Pluginer.php";
include "core/Admin.php";

include "../admin/include/bootstrap.inc.php";
include "include/connect.inc.php";

if (isset($_GET["select"]) && ($_POST["edit"] || $_POST["clone"]) && !$_POST["save"]) {
	$_GET["edit"] = $_GET["select"];
}

if (isset($_GET["settings"])) {
	include "../admin/settings.inc.php";
} elseif (isset($_GET["download"])) {
	include "../admin/download.inc.php";
} elseif (isset($_GET["edit"])) {
	include "../admin/edit.inc.php";
} elseif (isset($_GET["select"])) {
	include "../admin/select.inc.php";
} elseif (isset($_GET["script"])) {
	include "script.inc.php";
} else {
	include "db.inc.php";
}

// each page calls its own page_header(), if the footer should not be called then the page exits
page_footer();
