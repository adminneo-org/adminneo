<?php

namespace AdminNeo;

require __DIR__ . "/../../admin/include/functions.inc.php";

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
	':/tmp/mysql.sock' => ['', '/tmp/mysql.sock'], // MySQL socket
	'/tmp' => ['/tmp', ''], // PostgreSQL socket
	'/tmp:5433' => ['/tmp', '5433'], // PostgreSQL socket /tmp/.s.PGSQL.5433
	'https://elastic' => ['https://elastic', ''],
	'https://elastic:8000' => ['https://elastic', '8000'],
	'ssl://redis' => ['ssl://redis', ''],
	':/cloudsql/project:region:instance' => ['', '/cloudsql/project:region:instance'], // https://github.com/vrana/adminer/pull/1305
	'stack_service' => ['stack_service', ''], // https://github.com/vrana/adminer/commit/3faf095#r193072212
	':3307' => ['', '3307'],
	// invalid
	'other-host:/tmp/mysql.sock' => ['other-host:/tmp/mysql.sock', ''], // host with socket isn't supported
	':' => [':', ''],
	// rejected by auth.inc.php
	'[a]b:80' => ['[a]b', '80'],
	'https://[::1]:80' => ['https://[::1]:80', ''],
];

foreach ($tests as $server => $expected) {
	$actual = host_port($server);
	if ($actual !== $expected) {
		echo "⚠️ $server results in " . implode(" : ", $actual) . "\n";
	}
}
