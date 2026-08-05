<?php
// Updates the linked commands in modules/jush-redis.js
// from a checkout of https://github.com/redis/redis (the latest release branch, e.g. 8.10)

require __DIR__ . '/functions.inc.php';

if (!isset($argv[1])) {
	fwrite(STDERR, "Usage: php update/redis.php path/to/redis\n");
	exit(1);
}
$jush_file = __DIR__ . '/../modules/jush-redis.js';

// Every command has its own file with the name as the only key, subcommands hold the container name
$files = glob("$argv[1]/src/commands/*.json");
if (!$files) {
	fwrite(STDERR, "No commands in $argv[1]/src/commands\n");
	exit(1);
}
$names = [];
foreach ($files as $file) {
	foreach (json_decode(read_file($file), true) as $name => $command) {
		$container = $command['container'] ?? '';
		$names[] = ($container != '' ? "$container $name" : $name);
	}
}
$names = array_unique($names);

$jush = read_file($jush_file);
$jush = set_list($jush, "'\$1': /(", ")/,", explode('|', phrases_regexp($names)), 'commands');
file_put_contents($jush_file, $jush);
