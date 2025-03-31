<?php

namespace AdminNeo;

/**
 * Translates all table and field comments, enum and set values in Editor from the translation table.
 *
 * If translation is not found, new record is inserted automatically.
 *
 * Requires the table:
 * <pre>
 * CREATE TABLE translation (                       -- table name is configurable
 *   id int NOT NULL AUTO_INCREMENT,                -- optional
 *   language varchar(5) NOT NULL,
 *   text varchar(1024) NOT NULL COLLATE utf8_bin,  -- set longer size if needed
 *   translation varchar(1024) NULL,                -- set longer size if needed
 *   UNIQUE (language, text),
 *   PRIMARY KEY (id)
 * );
 * </pre>
 *
 * @link https://www.adminer.org/plugins/#use
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 * @author Peter Knut
 *
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class TranslationPlugin
{
	/** @var string */
	private $table;

	/** @var int */
	private $maxLength;

	/** @var ?string */
	private $language = null;

	/** @var ?string[] */
	private $translations = null;

	public function __construct(string $table = "translation", int $maxLength = 1024)
	{
		$this->table = $table;
		$this->maxLength = $maxLength;
	}

	public function getTableName(array $tableStatus): ?string
	{
		return h($this->translate($tableStatus["Name"]));
	}

	public function getFieldName(array $field, int $order = 0): ?string
	{
		return h($this->translate($field["field"]));
	}

	public function formatComment(?string $comment): ?string
	{
		return $comment != "" ? h($this->translate($comment)) : "";
	}

	public function editVal($val, $field)
	{
		if ($field["type"] == "enum") {
			return $this->translate($val);
		}

		return null;
	}

	private function translate(string $text): string
	{
		if ($this->language === null) {
			$this->language = get_lang();
		}

		if ($text == "") {
			return "";
		}

		if ($this->translations === null) {
			$this->translations = get_key_vals(
				"SELECT text, translation FROM " . idf_escape($this->table) . "
				WHERE language = " . q($this->language)
			);
		}

		if (!array_key_exists($text, $this->translations)) {
			$connection = connection();
			$connection->query(
				"INSERT INTO " . idf_escape($this->table) . " (language, text)
				VALUES (" . q($this->language) . ", " . $this->sanitizeText($text) . ")"
			);

			$this->translations[$text] = null;
		}

		return $this->translations[$text] ?? $text;
	}

	private function sanitizeText(string $text): string
	{
		return q(substr($text, 0, $this->maxLength));
	}
}
