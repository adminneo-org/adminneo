<!DOCTYPE html>
<html lang="cs">
<head>
	<meta charset="utf-8">
	<title>AdminNeo Coverage</title>

	<style>
		body {
			margin: 20px;
			font-family: Helvetica, Arial, sans-serif;
			font-size: 14px;
		}

		h1 {
			font-size: 26px;
			font-weight: normal;
		}

		table {
			border-collapse: collapse;
			margin: 20px 0;
		}

		th, td {
			padding: 5px 7px;
		}

		th {
			text-align: end;
		}

		th.low, .untested {
			background: hsl(0, 100%, 95%);
		}

		th.medium {
			background: hsl(57, 100%, 75%);
		}

		th.heigh, .tested {
			background: hsl(120, 70%, 95%);
		}

		.dead {
			background: #ddd;
		}

		a {
			color: hsl(220, 60%, 45%);
			text-decoration: none;
		}

		a:hover {
			color: hsl(7, 61%, 45%);
		}

		.code-holder {
			position: relative;
		}

		.code {
			position: absolute;
			top: 0;
		}

		pre {
			margin: 0;
		}

		code {
			font-family: JetBrains Mono, Menlo, Consolas, Liberation Mono, monospace;
			font-size: 13px;
			font-variant-ligatures: none;
			line-height: 18px;
		}
	</style>
</head>
<body>
<?php

$coverage_param = $_GET["coverage"] ?? "";
$coverage_filename = sys_get_temp_dir() . "/adminneo.coverage";

if (!extension_loaded("xdebug")) {
	echo "<h1>Coverage</h1>\n";
	echo "<p class='error'>⚠️ Xdebug has to be enabled.</p>\n";
} elseif ($coverage_param == "1") {
	file_put_contents($coverage_filename, serialize([]));
	header("Location: coverage.php");
} elseif ($coverage_param == "0") {
	unlink($coverage_filename);
	header("Location: coverage.php");
} elseif (isset($_GET["file"])) {
	$filename = get_files()[$_GET["file"]] ?? null;
	if (!$filename) {
		header("Location: coverage.php");
		exit;
	}

	echo "<h1>" . trim($filename, "./") . "</h1>\n";

	$coverage = (file_exists($coverage_filename) ? unserialize(file_get_contents($coverage_filename)) : []);

	print_file_code($filename, $coverage);
} elseif (file_exists($coverage_filename)) {
	echo "<h1>Coverage</h1>\n";

	$coverage = unserialize(file_get_contents($coverage_filename));

	print_file_list($coverage);

	echo "<p><a href='coverage.php?coverage=1'>🔄 Restart coverage</a></p>\n";
	echo "<p><a href='coverage.php?coverage=0'>⏹️ Stop coverage</a></p>\n";
} else {
	echo "<h1>Coverage</h1>\n";
	echo "<p><a href='coverage.php?coverage=1'>▶️ Start coverage</a></p>\n";
}

function get_files(): array
{
	return glob("../{admin,admin/core,admin/include,admin/drivers,editor,editor/core,editor/include}/*.php", GLOB_BRACE);
}

function print_file_list(array $coverage): void
{
	echo "<table>\n";
	echo "<tr><th>%</th><td>File</td></tr>\n";

	foreach (get_files() as $key => $filename) {
		$cov = $coverage[realpath($filename)] ?? null;
		$ratio = 0;

		if (is_array($cov)) {
			$values = array_count_values($cov);
			$ratio = round(100 * ($values[1] ?? 0) / (count($cov) - ($values[-2] ?? 0)));
		}

		echo "<tr>";
		echo "<th class='" . ($ratio < 50 ? "low" : ($ratio < 75 ? "medium" : "heigh")) . "'>$ratio</th>";
		echo "<td><a href='coverage.php?file=$key'>" . trim($filename, "./") . "</a></td>";
		echo "</tr>\n";
	}

	echo "</table>\n";
}

function print_file_code(string $filename, array $coverage): void
{
	$code = highlight_file($filename, true);

	// Convert code to the format exported by PHP 8.4.
	if (!preg_match("~^<pre>~", $code)) {
		$code = str_replace("\n", "", $code);
		$code = str_replace("<br />", "\n", $code);
		$code = "<pre>$code</pre>";
	}

	// Lines highlighting.
	$lines_count = count(explode("\n", $code));

	echo "<div class='code-holder'>\n";
	echo "<code>";

	for ($line = 1; $line <= $lines_count; $line++) {
		switch ($coverage[realpath($filename)][$line] ?? null) {
			case -1:
				// untested
				$class = "untested";
				break;
			case -2:
				// dead code
				$class = "dead";
				break;
			case null:
				// not executable
				$class = "";
				break;
			default:
				// tested
				$class = "tested";
				break;
		}
		echo "<div " . ($class ? "class='$class'" : "") . "> </div>\n";
	}

	echo "</code>\n";

	// Source code.
	echo "<div class='code'>\n$code\n</div>\n";
	echo "</div>\n";
}
?>

</body>
</html>
