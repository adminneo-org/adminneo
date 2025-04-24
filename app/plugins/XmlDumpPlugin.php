<?php

namespace AdminNeo;

/**
 * Exports table data to XML format in structure <database name=""><table name=""><column name="">value
 *
 * @link https://www.adminer.org/plugins/#use
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 *
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class XmlDumpPlugin
{
	private $database = false;

	public function getDumpFormats(): array
	{
		return ['xml' => 'XML'];
	}

	public function sendDumpHeaders(string $identifier, bool $multiTable = false): ?string
	{
		if ($_POST["format"] != "xml") {
			return null;
		}

		header("Content-Type: text/xml; charset=utf-8");

		return "xml";
	}

	public function dumpTable(string $table, string $style, int $viewType = 0): ?bool
	{
		if ($_POST["format"] != "xml") {
			return null;
		}

		return true;
	}

	public function dumpData(string $table, string $style, string $query): ?bool
	{
		if ($_POST["format"] != "xml") {
			return null;
		}

		if (!$this->database) {
			$this->database = true;
			echo "<database name='" . h(DB) . "'>\n";

			register_shutdown_function(function () {
				echo "</database>\n";
			});
		}

		$connection = connection();

		$result = $connection->query($query, 1);
		if ($result) {
			while ($row = $result->fetch_assoc()) {
				echo "\t<table name='" . h($table) . "'>\n";
				foreach ($row as $key => $val) {
					echo "\t\t<column name='" . h($key) . "'" . (isset($val) ? "" : " null='null'") . ">" . h($val) . "</column>\n";
				}
				echo "\t</table>\n";
			}
		}

		return true;
	}
}
