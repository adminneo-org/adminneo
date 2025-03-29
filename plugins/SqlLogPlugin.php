<?php

namespace AdminNeo;

/**
 * Logs all queries to SQL file.
 *
 * @link https://www.adminer.org/plugins/#use
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 * @author Peter Knut
 *
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class SqlLogPlugin
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
			$dbName = admin()->database();
			$this->filename = $dbName . ($dbName ? "-" : "") . "log.sql";
		}

		$fp = fopen($this->filename, "a");

		flock($fp, LOCK_EX);
		fwrite($fp, $query);
		fwrite($fp, "\n\n");
		flock($fp, LOCK_UN);

		fclose($fp);
	}

}
