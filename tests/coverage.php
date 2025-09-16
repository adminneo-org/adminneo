<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
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
        width: 100%;
    }

    th,
    td {
        padding: 5px 7px;
        text-align: left;
    }

    th.low,
    .untested {
        background: hsl(0, 100%, 95%);
    }

    th.medium {
        background: hsl(57, 100%, 75%);
    }

    th.high,
    .tested {
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
        left: 0;
        right: 0;
    }

    pre {
        margin: 0;
        overflow-x: auto;
    }

    code {
        font-family: JetBrains Mono, Menlo, Consolas, monospace;
        font-size: 13px;
        line-height: 18px;
        display: block;
    }

    button {
        padding: 5px 10px;
        margin: 5px;
        cursor: pointer;
    }

    .filters a {
        margin-right: 10px;
    }

    .legend span {
        margin-right: 10px;
        padding: 2px 5px;
    }
    </style>
</head>

<body>
    <?php

$coverage_param = $_GET["coverage"] ?? "";
$filter_folder = $_GET["folder"] ?? "";
$coverage_filename = sys_get_temp_dir() . "/adminneo.coverage";

if (!extension_loaded("xdebug")) {
    echo "<h1>Coverage</h1><p class='error'>⚠️ Xdebug has to be enabled.</p>";
    exit;
}

// Start or stop coverage
if ($coverage_param === "1") {
    file_put_contents($coverage_filename, serialize([]));
    header("Location: coverage.php");
    exit;
} elseif ($coverage_param === "0") {
    @unlink($coverage_filename);
    header("Location: coverage.php");
    exit;
}

$coverage = file_exists($coverage_filename) ? unserialize(file_get_contents($coverage_filename)) : [];

// Get list of files
function get_files(): array {
    global $filter_folder;
    $all_files = array_merge(
        glob("../admin/*.php"),
        glob("../admin/core/*.php"),
        glob("../admin/include/*.php"),
        glob("../admin/drivers/*.php"),
        glob("../editor/*.php"),
        glob("../editor/core/*.php"),
        glob("../editor/include/*.php")
    );

    if ($filter_folder) {
        $all_files = array_filter($all_files, fn($f) => strpos($f, "../$filter_folder/") === 0);
    }

    return array_values($all_files);
}

// Overall coverage
$total_lines = 0;
$tested_lines = 0;
foreach($coverage as $file_cov) {
    if(!is_array($file_cov)) continue;
    $counts = array_count_values($file_cov);
    $tested_lines += $counts[1] ?? 0;
    $total_lines += count($file_cov) - ($counts[-2] ?? 0);
}
$overall_ratio = $total_lines ? round(100 * $tested_lines / $total_lines) : 0;

// If viewing a file
if (isset($_GET["file"])) {
    $files = get_files();
    $filename = $files[$_GET["file"]] ?? null;
    if (!$filename) { header("Location: coverage.php"); exit; }

    echo "<h1>Coverage: " . trim($filename, "./") . "</h1>";
    $file_cov = $coverage[realpath($filename)] ?? [];
    echo "<div class='legend'>";
    echo "<span style='background: hsl(120,70%,95%)'>Tested</span>";
    echo "<span style='background: hsl(0,100%,95%)'>Untested</span>";
    echo "<span style='background: #ddd'>Dead code</span>";
    echo "</div>";

    $lines = file($filename);
    echo "<div class='code-holder'><code>";
    foreach($lines as $i => $line) {
        $status = $file_cov[$i+1] ?? null;
        $class = $status === 1 ? "tested" : ($status === -1 ? "untested" : ($status === -2 ? "dead" : ""));
        echo "<div class='$class'>" . htmlspecialchars($line) . "</div>";
    }
    echo "</code></div>";
    echo "<p><a href='coverage.php'>⬅ Back</a></p>";
    exit;
}

// Default: list all files
echo "<h1>AdminNeo Coverage</h1>";
echo "<p><strong>Overall Coverage:</strong> $overall_ratio%</p>";

// Filters
echo "<div class='filters'><strong>Filter:</strong>
    <a href='coverage.php?folder=admin'>Admin</a> |
    <a href='coverage.php?folder=editor'>Editor</a> |
    <a href='coverage.php'>All</a></div>";

// Legend
echo "<div class='legend'>";
echo "<span style='background: hsl(120,70%,95%)'>Tested</span>";
echo "<span style='background: hsl(57,100%,75%)'>Medium</span>";
echo "<span style='background: hsl(0,100%,95%)'>Low / Untested</span>";
echo "<span style='background: #ddd'>Dead code</span>";
echo "</div>";

// Table
echo "<table border='1'><tr><th>%</th><th>File</th></tr>";
foreach(get_files() as $key => $file) {
    $cov = $coverage[realpath($file)] ?? [];
    $values = array_count_values($cov);
    $ratio = count($cov) ? round(100 * ($values[1] ?? 0) / (count($cov) - ($values[-2] ?? 0))) : 0;
    $class = $ratio < 50 ? "low" : ($ratio < 75 ? "medium" : "high");
    echo "<tr><th class='$class'>$ratio</th><td><a href='coverage.php?file=$key'>" . trim($file, "./") . "</a></td></tr>";
}
echo "</table>";

// Buttons
$toggle_label = file_exists($coverage_filename) ? "⏹️ Stop coverage" : "▶️ Start coverage";
$toggle_param = file_exists($coverage_filename) ? "0" : "1";
echo "<p><a href='coverage.php?coverage=$toggle_param'>$toggle_label</a></p>";
echo "<p><a href='coverage.php?export=csv'>📄 Export CSV</a></p>";

// Export CSV
if(isset($_GET['export']) && $_GET['export'] == 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename="coverage.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['File', 'Coverage %']);
    foreach(get_files() as $key=>$file){
        $cov = $coverage[realpath($file)] ?? [];
        $values = array_count_values($cov);
        $ratio = count($cov) ? round(100*($values[1]??0)/(count($cov)-($values[-2]??0))) : 0;
        fputcsv($output, [trim($file, './'), $ratio]);
    }
    fclose($output);
    exit;
}
?>
</body>

</html>