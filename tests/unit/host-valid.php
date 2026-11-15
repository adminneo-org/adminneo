<?php

namespace AdminNeo;

require __DIR__ . "/../../admin/include/functions.inc.php";

$errors = 0;

$tests = [
	'localhost' => true,
	'127.0.0.1' => true,
	'db.example.com' => true,
	'stack_service' => true,
	'stack-service.internal' => true,
	'bücher.example' => true,
	'TNSALIAS' => true,
	'[::1]' => true,
	'[2001:0db8::1428:57ab]' => true,
	'[::ffff:127.0.0.1]' => true,
	// invalid
	'' => false,
	'::1' => false, // IPv6 address has to be in brackets
	'[]' => false,
	'[localhost]' => false,
	'[127.0.0.1]' => false,
	'[127.0.0.1:25]' => false, // FreeTDS reads the port from the host
	'[127.0.0.1 port=25]' => false,
	'[::1]x' => false,
	'127.0.0.1 port=25' => false, // libpq connection parameter
	'127.0.0.1;port=25' => false, // PDO DSN parameter
	'127.0.0.1,25' => false, // port in MS SQL
	'127.0.0.1:25' => false, // port is not a part of the host
	'127.0.0.1:25,127.0.0.1' => false, // more seeds in MongoDB
	'(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=127.0.0.1)(PORT=25)))' => false, // Oracle connect descriptor
	'localhost\SQLEXPRESS' => false, // allowed only by MS SQL driver
	'localhost/XE' => false, // allowed only by Oracle driver
	"localhost\n" => false,
	"local\thost" => false,
	"localhost\0" => false,
	"localhost'" => false,
	'local\ host' => false,
	'user@localhost' => false,
	'localhost?x=y' => false,
	'localhost#x' => false,
	"local\xFFhost" => false, // invalid UTF-8
];

foreach ($tests as $host => $expected) {
	$actual = is_host_valid((string)$host);
	if ($actual !== $expected) {
		echo "⚠️ " . json_encode((string)$host, JSON_INVALID_UTF8_SUBSTITUTE) . " is " . ($actual ? "valid" : "invalid") . "\n";
		$errors++;
	}
}

exit($errors ? 1 : 0);
