<?php

namespace AdminNeo;

/**
 * Logs all queries to SQL file.
 *
 * @link https://www.adminneo.org/plugins/#usage
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 * @author Peter Knut
 *
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class SqlLogPlugin extends Plugin
{
	private $filename;

	/**
	 * @param ?string $filename If not set, logs will be written to "$database-log.sql" file.
	 */
	public function __construct(?string $filename = null)
	{
		$this->filename = $filename;
	}

	public function formatMessageQuery(string $query, string $time, bool $failed = false): ?string
	{
		$this->log($query);

		return null;
	}

	public function formatSqlCommandQuery(string $query): ?string
	{
		$this->log($query);

		return null;
	}

	private function log(string $query): void
	{
		if ($this->filename == "") {
			$dbName = $this->admin->getDatabase();
			$this->filename = $dbName . ($dbName ? "-" : "") . "log.sql";
		}

		$folder = dirname($this->filename);

		if (!is_dir($folder)) {
			mkdir($folder, 0777, true); // create folder struct recursively if it doesnt exist
		}

		$fp = fopen($this->filename, "a");

		flock($fp, LOCK_EX);
		fwrite($fp, $query);
		fwrite($fp, "\n\n");
		flock($fp, LOCK_UN);

		fclose($fp);
	}

}
