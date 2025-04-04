<?php

namespace AdminNeo;

/**
 * Displays JSON preview as a table.
 *
 * JSON previews can be displayed in selection table and/or in edit form. Preview will be displayed for columns with
 * native JSON data type and for values that are automatically detected as JSON objects or arrays if
 * `jsonValuesDetection` configuration option is enabled.
 *
 * @author Peter Knut
 *
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class JsonPreviewPlugin
{
	/** @var bool */
	private $inSelection;

	/** @var bool */
	private $inEdit;

	/** @var int */
	private $maxLevel;

	/** @var int */
	private $maxTextLength;

	/** @var int */
	private $counter = 1;

	/**
	 * @param bool $inSelection Whether apply JSON preview in selection table.
	 * @param bool $inEdit Whether apply JSON preview in edit form.
	 * @param int $maxLevel Max. level in recursion.
	 * @param int $maxTextLength Maximal length of string values. Longer texts will be truncated with ellipsis sign '…'.
	 */
	public function __construct(bool $inSelection = true, bool $inEdit = true, int $maxLevel = 5, int $maxTextLength = 100)
	{
		$this->inSelection = $inSelection;
		$this->inEdit = $inEdit;
		$this->maxLevel = $maxLevel;
		$this->maxTextLength = $maxTextLength;
	}

	/**
	 * Prints HTML code inside <head>.
	 */
	public function printToHead(): ?bool
	{
		?>

		<style>
			/* Table */
			.json {
				/*display: none;*/
				width: auto;
				margin: 4px 0;
				border-color: var(--code-border);
				border-left: 7px solid var(--code-border);
				background-color: var(--code-bg);
			}

			.json th {
				padding: 0;
				width: 1px;
				background-color: transparent;
				border-color: var(--code-border);
			}

			.json td {
				padding: 0;
				border-color: var(--code-border);
			}

			.json code {
				display: block;
				background: transparent;
				padding: 3px 7px;
				white-space: normal;
			}

			.json .json {
				display: table;
				width: 100%;
				border: none;
				margin: 0;
			}

			.json:not(.hidden) + textarea {
				margin-top: 3px;
			}
		</style>

		<?php
		return null;
	}

	public function selectVal(&$val, $link, ?array $field, $original)
	{
		if (!$field || !$this->inSelection) {
			return null;
		}

		$json = $this->decodeJson($field, $original);
		if ($json === null) {
			return null;
		}

		return "<a class='toggle jsonly' href='#json-code-$this->counter' title='JSON' data-value='" . h($val) . "'>" . icon_chevron_right() . "</a>" .
			" <code class='jush-js'>$val</code>" .
			$this->buildTable($json, 1, $this->counter++);

	}

	public function getFieldInput(string $table, array $field, string $attrs, $value, ?string $function): ?string
	{
		if (!$this->inEdit) {
			return null;
		}

		$json = $this->decodeJson($field, $value);
		if ($json === null) {
			return null;
		}

		return "<div class='jsonly'><a class='toggle' href='#json-code-$this->counter'>JSON" . icon_chevron_down() . "</a></div>" .
			$this->buildTable($json, 1, $this->counter++) .
			"<textarea $attrs cols='50' rows='12' class='jush-js'>" . h($value) . "</textarea>";

	}

	private function decodeJson(array $field, $value): ?array
	{
		if (
			preg_match('~json~', $field["type"]) ||
			(
				admin()->getConfig()->isJsonValuesDetection() &&
				preg_match('~varchar|text|character varying|String~', $field["type"]) &&
				is_string($value) &&
				in_array(substr($value, 0, 1), ['{', '['])
			)
		) {
			$json = json_decode($value, true);

			return is_array($json) ? $json : null;
		}

		return null;

	}

	private function buildTable(array $json, int $level = 1, int $id = 0): string
	{
		$value = "<table class='json hidden'" . ($id && $level == 1 ? " id='json-code-$id'" : "") . ">";

		foreach ($json as $key => $val) {
			$value .= "<tr><th><code>" . h($key) . "</code>";
			$value .= "<td>";

			if (is_array($val) && $level < $this->maxLevel) {
				$value .= $this->buildTable($val, $level + 1);
			} else {
				if (is_array($val)) {
					$val = preg_replace('~([,:])(\S)~', '$1 $2', json_encode($val));
					$val = truncate_utf8($val, $this->maxTextLength);
				} elseif (is_string($val)) {
					$val = truncate_utf8($val, $this->maxTextLength);
					$val = '"' . $val . '"';
				} elseif (is_bool($val)) {
					$val = h($val ? "true" : "false");
				} elseif (is_null($val)) {
					$val = "null";
				}

				$value .= "<code class='jush-js'>$val</code>";
			}
		}

		if (!$json) {
			$value .= "<tr><td>   </td></tr>";
		}

		$value .= "</table>";

		return $value;
	}
}
