<?php

namespace AdminNeo;

/**
 * Displays JSON preview as a table.
 *
 * JSON previews can be displayed in data table and/or in edit form. Previews will be displayed for columns with
 * native JSON data type and for values that are automatically detected as JSON objects or arrays if
 * `jsonValuesDetection` configuration option is enabled.
 *
 * @author Peter Knut
 *
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class JsonPreviewPlugin extends Plugin
{
	/** @var bool */
	protected $inTable;

	/** @var bool */
	protected $inEdit;

	/** @var int */
	protected $maxLevel;

	/** @var int */
	protected $maxTextLength;

	/** @var string */
	protected $linkIdBase;

	/** @var int */
	protected $counter = 1;

	/**
	 * @param bool $inTable Whether apply JSON preview in data table.
	 * @param bool $inEdit Whether apply JSON preview in edit form.
	 * @param int $maxLevel Max. level in recursion.
	 * @param int $maxTextLength Maximal length of string values. Longer texts will be truncated with ellipsis sign '…'.
	 */
	public function __construct(bool $inTable = true, bool $inEdit = true, int $maxLevel = 5, int $maxTextLength = 100)
	{
		$this->inTable = $inTable;
		$this->inEdit = $inEdit;
		$this->maxLevel = $maxLevel;
		$this->maxTextLength = $maxTextLength;

		$this->linkIdBase = (string)microtime(true);
	}

	public function inject($admin, Config $config, Settings $settings, Locale $locale): void
	{
		parent::inject($admin, $config, $settings, $locale);

		$param = $settings->getParameter("jsonPreview");
		if ($param) {
			$this->inTable = in_array("table", $param);
			$this->inEdit = in_array("edit", $param);
		}
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

			.json + textarea {
				margin-top: 3px;
			}
		</style>

		<?php
		return null;
	}

	public function formatSelectionValue(?string $val, ?string $link, ?array $field, ?string $original): ?string
	{
		if (!$field || !$this->inTable) {
			return null;
		}

		$json = $this->decodeJson($field, $original);
		if ($json === null) {
			return null;
		}

		return "<a class='toggle jsonly' href='#json-code-$this->linkIdBase-$this->counter' title='JSON' data-value='" . h($val) . "'>" . icon_chevron_right() . "</a>" .
			" <code class='jush-js'>$val</code>" .
			$this->buildTable($json, 1, $this->counter++);

	}

	public function getFieldInput(?string $table, array $field, string $attrs, $value, ?string $function): ?string
	{
		if (!$this->inEdit) {
			return null;
		}

		$json = $this->decodeJson($field, $value);
		if ($json === null) {
			return null;
		}

		return "<div class='jsonly'><a class='toggle' href='#json-code-$this->linkIdBase-$this->counter'>JSON" . icon_chevron_down() . "</a></div>" .
			$this->buildTable($json, 1, $this->counter++) .
			"<textarea $attrs cols='50' rows='12' class='jush-js'>" . h($value) . "</textarea>";

	}

	private function decodeJson(array $field, $value): ?array
	{
		if (
			preg_match('~json~', $field["type"]) ||
			(
				$this->config->isJsonValuesDetection() &&
				preg_match('~varchar|text|character varying|String|keyword~', $field["type"]) &&
				is_string($value) &&
				in_array(substr($value, 0, 1), ['{', '['])
			)
		) {
			$json = json_decode($value, true);

			return is_array($json) ? $json : null;
		}

		return null;

	}

	private function buildTable(array $json, int $level = 1, int $counter = 0): string
	{
		$value = "<table class='json hidden'" . ($counter && $level == 1 ? " id='json-code-$this->linkIdBase-$counter'" : "") . ">";

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

	public function getSettingsRows(int $groupId): array
	{
		if ($groupId != 2) {
			return [];
		}

		$useDefault = !$this->settings->getParameter("jsonPreview");

		$settings["jsonPreview"] = "<tr><th>" . lang('JSON previews') . "</th>" .
			"<td><span class='labels'>" .
			checkbox("jsonPreview[]", "", $useDefault, lang('Default')) .
			checkbox("jsonPreview[]", "table",  $this->inTable, lang('Data table'), "", $useDefault ? "disabled" : "") .
			checkbox("jsonPreview[]", "edit", $this->inEdit, lang('Edit form'), "", $useDefault ? "disabled" : "") .
			"<input type='hidden' name='jsonPreview[]' value='x'>" .
			"</span></td></tr>\n";

		return $settings;
	}
}
