<?php

namespace AdminNeo;

require __DIR__ . "/../../admin/include/functions.inc.php";

$errors = 0;

$tests = [
	'' => ['', ''],
	'localhost' => ['localhost', ''],
	'localhost:3307' => ['localhost', '3307'],
	'127.0.0.1' => ['127.0.0.1', ''],
	'::1' => ['::1', ''],
	'2001:0db8::1428:57ab' => ['2001:0db8::1428:57ab', ''],
	'fe80::1' => ['fe80::1', ''],
	'[2001:0db8::1428:57ab]' => ['2001:0db8::1428:57ab', ''],
	'[2001:0db8::1428:57ab]:3307' => ['2001:0db8::1428:57ab', '3307'],
	':/tmp/mysql.sock' => ['', '/tmp/mysql.sock'], // MySQL socket, https://github.com/vrana/adminer/pull/1199
	'/tmp' => ['/tmp', ''], // PostgreSQL socket
	'/tmp:5433' => ['/tmp', '5433'], // PostgreSQL socket /tmp/.s.PGSQL.5433
	'https://elastic' => ['https://elastic', ''],
	'https://elastic:8000' => ['https://elastic', '8000'],
	'http://127.0.0.1:22' => ['http://127.0.0.1', '22'], // https://github.com/vrana/adminer/security/advisories/GHSA-37gx-66gx-rxgh
	'ssl://redis' => ['ssl://redis', ''],
	':/cloudsql/project:region:instance' => ['', '/cloudsql/project:region:instance'], // https://github.com/vrana/adminer/pull/1305
	'stack_service' => ['stack_service', ''], // https://github.com/vrana/adminer/commit/3faf095#r193072212
	':3307' => ['', '3307'],
	// invalid
	'other-host:/tmp/mysql.sock' => ['other-host:/tmp/mysql.sock', ''], // host with socket isn't supported
	'localhost:2200e-2' => ['localhost:2200e-2', ''],
	':' => [':', ''],
	'[a]b:80' => ['[a]b', '80'],
	// rejected by build_http_url() in HTTP based drivers
	'https://[::1]:80' => ['https://[::1]:80', ''],
	'http://localhost:9200/elastic/' => ['http://localhost:9200/elastic/', ''], // legitimate (behind a reverse proxy) but not supported
	'http://localhost:22/elastic/:9200' => ['http://localhost:22/elastic/:9200', ''],
	'localhost:22/elastic/:9200' => ['localhost:22/elastic/:9200', ''],
	'[localhost:22]' => ['localhost:22', ''],
];

foreach ($tests as $server => $expected) {
	$actual = host_port($server);
	if ($actual !== $expected) {
		echo "⚠️ $server results in " . implode(" : ", $actual) . "\n";
		$errors++;
	}
}

exit($errors ? 1 : 0);
