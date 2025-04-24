<?php

namespace AdminNeo;

use ZipArchive;

/**
 * Adds ZIP compression of data export.
 *
 * @link https://www.adminer.org/plugins/#use
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 *
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class ZipOutputPlugin
{
	/** @var string */
	private $filename;

	/** @var string */
	private $data;

	public function getDumpOutputs(): array
	{
		return class_exists('ZipArchive') ? ['zip' => 'ZIP'] : [];
	}

	public function sendDumpHeaders(string $identifier, bool $multiTable = false): ?string
	{
		if ($_POST["output"] == "zip") {
			$this->filename = "$identifier." . ($multiTable && preg_match("~[ct]sv~", $_POST["format"]) ? "tar" : $_POST["format"]);

			header("Content-Type: application/zip");

			ob_start([$this, 'compress']);
		}

		return null;
	}

	private function compress(string $string, int $state): string
	{
		// ZIP can be created without temporary file by gzcompress - see PEAR File_Archive.
		$this->data .= $string;

		if ($state & PHP_OUTPUT_HANDLER_END) {
			$zipFilename = tempnam("", "zip");

			$zip = new ZipArchive();
			$zip->open($zipFilename, ZipArchive::OVERWRITE); // php://output is not supported
			$zip->addFromString($this->filename, $this->data);
			$zip->close();

			$result = file_get_contents($zipFilename);
			unlink($zipFilename);

			return $result;
		}

		return "";
	}
}
