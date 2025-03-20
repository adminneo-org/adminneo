<?php

namespace AdminNeo;

/**
 * Exports table data to JSON format.
 *
 * @link https://www.adminer.org/plugins/#use
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 *
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class JsonDumpPlugin
{
	private $database = false;

	public function getDumpFormats(): array
	{
		return ['json' => 'JSON'];
	}

	public function sendDumpHeaders(string $identifier, bool $multiTable = false): ?string
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

		$connection = connection();

		$result = $connection->query($query, 1);
		if ($result) {
			echo '"' . addcslashes($table, "\r\n\"\\") . "\": [\n";

			$first = true;
			while ($row = $result->fetch_assoc()) {
				echo($first ? "" : ", ");

				foreach ($row as $key => $val) {
					json_row($key, $val);
				}
				json_row("");

				$first = false;
			}

			echo "]";
		}

		return true;
	}
}
