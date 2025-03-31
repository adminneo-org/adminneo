<?php

namespace AdminNeo;

use Exception;

/**
 * Replaces fields ending with "_path" by `<input type="file">` in edit form and displays links to the uploaded files in
 * table select.
 *
 * @link https://www.adminer.org/plugins/#use
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 * @author Peter Knut
 *
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class FileUploadPlugin
{
	/** @var string */
	private $uploadPath;

	/** @var string */
	private $linkPath;

	/** @var string */
	private $extensions;

	/**
	 * @param string $uploadPath Path to a writable directory where uploading data will be stored.
	 *
	 * @param ?string $linkPath Prefix for displaying data, null stands for $uploadPath.
	 * @param string $extensions Regular expression with allowed file extensions.
	 */
	public function __construct(string $uploadPath = "../static/data/", string $linkPath = null, string $extensions = "[a-zA-Z0-9]+")
	{
		$this->uploadPath = $uploadPath;
		$this->linkPath = $linkPath ?? $uploadPath;
		$this->extensions = $extensions;
	}

	public function selectLink($val, $field)
	{
		if ($val == "" || !($shortFieldName = $this->matchField($field))) {
			return null;
		}

		return $this->linkPath . "/" . $this->encodeUrl($_GET["db"]) . "/" .
			$this->encodeUrl($_GET["select"]) . "/" .
			$this->encodeUrl("$shortFieldName-$val");
	}

	public function editInput($table, $field, $attrs, $value)
	{
		if (!$this->matchField($field)) {
			return null;
		}

		return "<input type='file'$attrs>";
	}

	public function processInput(?array $field, $value, $function = "")
	{
		if (!$field || !($shortFieldName = $this->matchField($field))) {
			return null;
		}

		$dbName = $_GET["db"];
		$tableName = ($_GET["edit"] != "" ? $_GET["edit"] : $_GET["select"]);
		$fieldName = $field["field"];
		$files = $_FILES["fields"];

		// Check upload error and file extension.
		if ($files["error"][$fieldName] || !preg_match('~\.(' . $this->extensions . ')$~', $files["name"][$fieldName], $matches)) {
			return false;
		}

		// Create a directory for the current table.
		$targetDir = $this->uploadPath . "/" . $this->encodeFs($dbName) . "/" . $this->encodeFs($tableName);
		if (!file_exists($targetDir) && !mkdir($targetDir, 0777, true)) {
			return false;
		}

		// Generate random unique file name.
		do {
			$filename = $this->generateName() . $matches[0];

			$targetPath = "$targetDir/" . $this->encodeFs($shortFieldName) . "-$filename";
		} while (file_exists($targetPath));

		// Move file to final destination.
		if (!move_uploaded_file($files["tmp_name"][$fieldName], $targetPath)) {
			return false;
		}

		return q($filename);
	}

	private function matchField(array $field): ?string
	{
		return preg_match('~(.*)_path$~', $field["field"], $matches) ? $matches[1] : null;
	}

	private function generateName(): string
	{
		try {
			return function_exists('random_bytes') ? bin2hex(random_bytes(8)) : uniqid("", true);
		} catch (Exception $e) {
			return uniqid("", true);
		}
	}

	private function encodeUrl(string $value): string
	{
		return rawurlencode(str_replace("/", "%2F", $value));
	}

	private function encodeFs(string $value): string
	{
		// Encode special filesystem characters.
		return strtr($value, [
			'.' => '%2E',
			'/' => '%2F',
			'\\' => '%5C',
		]);
	}
}
