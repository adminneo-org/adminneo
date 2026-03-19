<?php

chdir(__DIR__ . "/../katalon/");
@mkdir("compiled");

foreach (glob("*.krecorder") as $filename) {
	$content = file_get_contents($filename);

	$content = str_replace("</title>", "-compiled</title>", $content);
	$content = preg_replace("~(admin|editor)-devel.php~", "$1-compiled.php", $content);

	$filename = preg_replace('~(\.krecorder)$~', "-compiled$1", $filename);
	file_put_contents("compiled/$filename", $content);
}
