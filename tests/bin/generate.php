<?php

chdir(__DIR__ . "/../katalon/");
@mkdir("compiled");

foreach (glob("*.krecorder") as $filename) {
	if (preg_match('~-pdo|-dblib~', $filename)) {
		continue;
	}

	$content = file_get_contents($filename);
	generate_pdo($filename, $content);

	$content = str_replace("</title>", "-compiled</title>", $content);
	$content = preg_replace("~(admin|editor)-devel.php~", "$1-compiled.php", $content);

	$filename = preg_replace('~(\.krecorder)$~', "-compiled$1", $filename);
	file_put_contents("compiled/$filename", $content);

	generate_pdo("compiled/$filename", $content);
}

function generate_pdo(string $filename, string $content): void
{
	if (preg_match('~elastic|clickhouse|mongo|simpledb~', $filename)) {
		return;
	}

	$content = str_replace("</title>", "-pdo</title>", $content);

	$content = preg_replace_callback("~(/(admin|editor)-(devel|compiled).php)(\??)~", function ($matches) {
		return "$matches[1]?ext=pdo" . ($matches[4] ? "&" : "");
	}, $content);

	$content = str_replace("extension MySQLi", "extension PDO_MySQL", $content);
	$content = str_replace("extension PgSQL", "extension PDO_PgSQL", $content);
	$content = str_replace("extension sqlsrv", "extension PDO_SQLSRV", $content);
	$content = str_replace("extension SQLite3", "extension PDO_SQLite", $content);

	// MS SQL PDO doesn't support EXPLAIN.
	$content = str_replace("<tr><td>click</td><td>link=Explain</td><td></td></tr>\n<tr><td>verifyTextPresent</td><td>Clustered Index Scan</td><td></td></tr>\n", "", $content);

	$filename = preg_replace('~(\.krecorder)$~', "-pdo$1", $filename);
	file_put_contents($filename, $content);

	if (strpos($filename, "mssql") !== false) {
		$content = str_replace("-pdo</title>", "-dblib</title>", $content);
		$content = str_replace("?ext=pdo", "?ext=dblib", $content);
		$content = str_replace("extension PDO_SQLSRV", "extension PDO_DBLIB", $content);

		$content = str_replace("Table 'interprets' already has a primary key defined on it.", "Could not create constraint or index.", $content);

		$filename = str_replace('-pdo', "-dblib", $filename);
		file_put_contents($filename, $content);
	}
}
