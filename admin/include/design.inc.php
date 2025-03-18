<?php

namespace AdminNeo;

if (!ob_get_level()) {
	ob_start(null, 4096);
}

/**
 * Prints page header.
 *
 * @param string $title Used in title and h2, should be HTML escaped.
 * @param string $error
 * @param mixed $breadcrumb ["key" => "link", "key2" => ["link", "desc"], 0 => "desc"], null for nothing, false for driver only, true for driver and server
 * @param ?string $missing "auth", "db", "ns"
 */
function page_header(string $title, string $error = "", $breadcrumb = [], ?string $missing = null): void
{
	global $LANG, $admin, $jush, $token;

	page_headers();
	if (is_ajax() && $error) {
		page_messages($error);
		exit;
	}

	$title = strip_tags($title);
	$server_part = $breadcrumb !== false && $breadcrumb !== null && SERVER != "" ? " - " . h($admin->getServerName(SERVER)) : "";
	$service_title = strip_tags($admin->name());

	$title_page = $title . $server_part . " - " . ($service_title != "" ? $service_title : "AdminNeo");

	// Load AdminNeo version from file if cookie is missing.
	if ($admin->getConfig()->isVersionVerificationEnabled()) {
		$filename = get_temp_dir() . "/adminneo.version";
		if (!isset($_COOKIE["neo_version"]) && file_exists($filename) && ($lifetime = filemtime($filename) + 86400 - time()) > 0) { // 86400 - 1 day in seconds
			$data = unserialize(file_get_contents($filename));

			$_COOKIE["neo_version"] = $data["version"];
			cookie("neo_version", $data["version"], $lifetime); // Sync expiration with the file.
		}
	}
	?>
<!DOCTYPE html>
<html lang="<?= $LANG; ?>" dir="<?= lang('ltr'); ?>">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="robots" content="noindex, nofollow">
	<meta name="viewport" content="width=device-width, initial-scale=1"/>

	<title><?= $title_page; ?></title>
<?php
	$theme = $admin->getConfig()->getTheme();
	$color_variant = $admin->getConfig()->getColorVariant();

	echo "<link rel='stylesheet' href='", link_files("default-$color_variant.css", [
		"../admin/themes/default/variables.css",
		"../admin/themes/default-$color_variant/variables.css",
		"../admin/themes/default/common.css",
		"../admin/themes/default/forms.css",
		"../admin/themes/default/code.css",
		"../admin/themes/default/messages.css",
		"../admin/themes/default/links.css",
		"../admin/themes/default/fieldSets.css",
		"../admin/themes/default/tables.css",
		"../admin/themes/default/dragging.css",
		"../admin/themes/default/header.css",
		"../admin/themes/default/navigationPanel.css",
		"../admin/themes/default/print.css",
	]), "'>\n";

	if (!$admin->isLightModeForced()) {
		echo "<link rel='stylesheet' " . (!$admin->isDarkModeForced() ? "media='(prefers-color-scheme: dark)' " : "") . "href='";
		echo link_files("default-$color_variant-dark.css", [
			"../admin/themes/default/variables-dark.css",
			"../admin/themes/default-$color_variant/variables-dark.css",
		]);
		echo "'>\n";
	}

	if ($theme != "default") {
		echo "<link rel='stylesheet' href='", link_files("$theme-$color_variant.css", [
			"../admin/themes/$theme/main.css",
			"../admin/themes/$theme-$color_variant/main.css",
		]), "'>\n";

		if (!$admin->isLightModeForced()) {
			echo "<link rel='stylesheet' " . (!$admin->isDarkModeForced() ? "media='(prefers-color-scheme: dark)' " : "") . "href='";
			echo link_files("$theme-$color_variant-dark.css", [
				"../admin/themes/$theme/main-dark.css",
				"../admin/themes/$theme-$color_variant/main-dark.css",
			]);
			echo "'>\n";
		}
	}

	echo script_src(link_files("main.js", ["../admin/scripts/functions.js", "scripts/editing.js"]));

	if ($admin->head()) {
		// https://evilmartians.com/chronicles/how-to-favicon-in-2021-six-files-that-fit-most-needs
		// Converting PNG to ICO: https://redketchup.io/icon-converter
		echo "<link rel='icon' type='image/x-icon' href='", link_files("favicon-$color_variant.ico", ["../admin/images/variants/favicon-$color_variant.ico"]), "' sizes='32x32'>\n";
		echo "<link rel='icon' type='image/svg+xml' href='", link_files("favicon-$color_variant.svg", ["../admin/images/variants/favicon-$color_variant.svg"]), "'>\n";
		echo "<link rel='apple-touch-icon' href='", link_files("apple-touch-icon-$color_variant.png", ["../admin/images/variants/apple-touch-icon-$color_variant.png"]), "'>\n";

		foreach ($admin->getCssUrls() as $url) {
			if (strpos($url, "adminneo-dark.css") === 0 && !$admin->isDarkModeForced()) {
				echo "<link rel='stylesheet' media='(prefers-color-scheme: dark)' href='", h($url), "'>\n";
			} else {
				echo "<link rel='stylesheet' href='", h($url), "'>\n";
			}
		}

		foreach ($admin->getJsUrls() as $url) {
			echo script_src($url);
		}
	}
?>
</head>
<body class="<?php echo lang('ltr'); ?> nojs">
<script<?php echo nonce(); ?>>
	const body = document.body;

	body.onkeydown = bodyKeydown;
	body.onclick = bodyClick;
	body.classList.remove("nojs");
	body.classList.add("js");

	var offlineMessage = '<?php echo js_escape(lang('You are offline.')); ?>';
	var thousandsSeparator = '<?php echo js_escape(lang(',')); ?>';
</script>


<?php
	echo "<div id='help' class='jush-$jush jsonly hidden'></div>";
    echo script("initHelpPopup();");

	echo "<button id='navigation-button' class='button light navigation-button'>", icon_solo("menu"), icon_solo("close"), "</button>";
    echo "<div id='navigation-panel' class='navigation-panel'>\n";
	$admin->navigation($missing);

	echo "<div class='footer'>\n";
	language_select();

	if ($missing != "auth") {
		?>

        <div class="logout">
            <form action="" method="post">
				<?php echo h($_GET["username"]); ?>
                <input type="submit" class="button" name="logout" value="<?php echo lang('Logout'); ?>" id="logout">
                <input type="hidden" name="token" value="<?php echo $token; ?>">
            </form>
        </div>

		<?php
	}
	echo "</div>\n"; // footer
	echo "</div>\n"; // navigation-panel
	echo script("initNavigation();");

    echo "<div id='content'>\n";
	echo "<div class='header'>\n";

	if ($breadcrumb !== null) {
		echo '<nav class="breadcrumbs"><ul>';

		echo '<li><a href="' . h(HOME_URL) . '" title="', lang('Home'), '">', icon_solo("home"), '</a></li>';

		$server_name = $admin->getServerName(SERVER);
		$server_name = $server_name != "" ? h($server_name) : lang('Server');

		if ($breadcrumb === false) {
			echo "<li>$server_name</li>";
		} else {
			$link = substr(preg_replace('~\b(db|ns)=[^&]*&~', '', ME), 0, -1);
			echo "<li><a href='" . h($link) . "' accesskey='1' title='Alt+Shift+1'>$server_name</a></li>";

			if ($_GET["ns"] != "" || (DB != "" && is_array($breadcrumb))) {
				echo '<li><a href="' . h($link . "&db=" . urlencode(DB) . (support("scheme") ? "&ns=" : "")) . '">' . h(DB) . '</a></li>';
			}

			if ($breadcrumb === true) {
				if ($_GET["ns"] != "") {
					echo '<li>' . h($_GET["ns"]) . '</li>';
				} else {
					echo "<li>", h(DB), "</li>";
				}
			} else {
				if ($_GET["ns"] != "") {
					echo '<li><a href="' . h(substr(ME, 0, -1)) . '">' . h($_GET["ns"]) . '</a></li>';
				}

				foreach ($breadcrumb as $key => $val) {
					if (is_string($key)) {
						$desc = (is_array($val) ? $val[1] : h($val));
						if ($desc != "") {
							echo "<li><a href='" . h(ME . "$key=") . urlencode(is_array($val) ? $val[0] : $val) . "'>$desc</a></li>";
						}
					} else {
						echo "<li>$val</li>\n";
					}

				}
			}
		}

		echo "</ul></nav>";
	}

	echo "</div>\n"; // header

	echo "<h1>$title</h1>\n";
	echo "<div id='ajaxstatus' class='jsonly hidden'></div>\n";

	restart_session();
	page_messages($error);
	$databases = &get_session("dbs");
	if (DB != "" && $databases && !in_array(DB, $databases, true)) {
		$databases = null;
	}
	stop_session();
	define("AdminNeo\PAGE_HEADER", 1);
}

/**
 * Sends HTTP headers.
 */
function page_headers(): void
{
	global $admin;

	header("Content-Type: text/html; charset=utf-8");
	header("Cache-Control: no-cache");
	header("X-XSS-Protection: 0"); // prevents introducing XSS in IE8 by removing safe parts of the page
	header("X-Content-Type-Options: nosniff");
	header("Referrer-Policy: origin-when-cross-origin");

	// Clickjacking prevention for older browsers that do not support CSP2.
	header("X-Frame-Options: " . (in_array(Config::SelfSource, $admin->getConfig()->getFrameAncestors()) ? "SAMEORIGIN" : "DENY"));

	$directives = [];
	foreach ($admin->getCspHeader() as $directive => $sources) {
		$directives[] = "$directive $sources";
	}
	header("Content-Security-Policy: " . implode("; ", $directives));

	$admin->headers();
}

/**
 * Gets a CSP nonce.
 *
 * @return string Base64 value.
 * @throws \Random\RandomException
 */
function get_nonce()
{
	static $nonce;

	if (!$nonce) {
		$nonce = base64_encode(get_random_string(true));
	}

	return $nonce;
}

/** Print flash and error messages
* @param string
* @return null
*/
function page_messages($error) {
	$uri = preg_replace('~^[^?]*~', '', $_SERVER["REQUEST_URI"]);
	$messages = $_SESSION["messages"][$uri] ?? null;
	if ($messages) {
		echo "<div class='message'>" . implode("</div>\n<div class='message'>", $messages) . "</div>" . script("initToggles();");
		unset($_SESSION["messages"][$uri]);
	}
	if ($error) {
		echo "<div class='error'>$error</div>\n";
	}
}

/**
 * Prints page footer.
 */
function page_footer()
{
	echo "</div>\n"; // content
}
