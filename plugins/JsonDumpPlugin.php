<?php

namespace AdminNeo;

/**
 * Adds option to export table data to JSON format.
 *
 * Last changed in release: !compile: version
 *
 * @link https://www.adminneo.org/plugins/#usage
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 * @author Peter Knut
 *
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class JsonDumpPlugin extends Plugin
{
	private $database = false;

	public function getDumpFormats(): array
	{
		return ['json' => [
			'name' => 'JSON',
			'data' => true,
		]];
	}

	public function sendDumpFormatHeaders(string $identifier, bool $multiTable = false): ?string
	{
		if ($_POST["format"] != "json") {
			return null;
		}

		header("Content-Type: application/json; charset=utf-8");

		return "json";
	}

	public function dumpTable(string $table, string $style, int $viewType = 0): ?bool
	{
		if ($_POST["format"] != "json") {
			return null;
		}

		return true;
	}

	public function dumpData(string $table, string $style, string $query): ?bool
	{
		if ($_POST["format"] != "json") {
			return null;
		}

		if ($this->database) {
			echo ",\n";
		} else {
			$this->database = true;
			echo "{\n";

			register_shutdown_function(function () {
				echo "}\n";
			});
		}

		$result = Connection::get()->query($query, 1);
		if ($result) {
			echo '"' . addcslashes($table, "\r\n\"\\") . "\": [\n";

			$first = true;
			while ($row = $result->fetchAssoc()) {
				if (!$first) {
					echo ",\n";
				}

				echo preg_replace('~\n\s+~', "\n\t", json_encode($row, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

				$first = false;
			}

			echo "\n]";
		}

		return true;
	}
}
