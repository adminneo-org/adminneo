<?php

namespace AdminNeo;

/**
 * Edits all fields containing "_html" by TinyMCE 7 editor.
 *
 * @link https://www.tiny.cloud/docs/tinymce/latest/php-projects/
 * @link https://www.tiny.cloud/docs/tinymce/latest/basic-setup/
 * @link https://www.tiny.cloud/get-tiny/language-packages/
 *
 * @link https://www.adminer.org/plugins/#use
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 * @author Peter Knut
 *
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class TinyMcePlugin
{
	/** @var string */
	private $path;

	/** @var string */
	private $licenseKey;

	public function __construct(string $path = "tinymce/tinymce.min.js", string $licenseKey = "gpl")
	{
		$this->path = $path;
		$this->licenseKey = $licenseKey;
	}

	public function head()
	{
		$lang = get_lang();
		$lang = ($lang == "zh" ? "zh-CN" : ($lang == "zh-tw" ? "zh-TW" : $lang));
		if (!file_exists(dirname($this->path) . "/langs/$lang.js")) {
			$lang = "en";
		}

		echo script_src($this->path);
		?>
		<script<?php echo nonce(); ?>>
			tinyMCE.init({
				license_key: '<?= js_escape($this->licenseKey); ?>',
				selector: 'textarea[data-editor="tinymce"]',
				width: 800,
				height: 600,
				entity_encoding: 'raw',
				language: '<?= $lang; ?>',
				plugins: 'image link',
				toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | link image'
			});
		</script>
		<?php
	}

	public function getFieldInput(string $table, array $field, string $attrs, $value, ?string $function): ?string
	{
		if (str_contains($field["type"], "text") && str_contains($field["field"], "_html")) {
			return "<textarea $attrs cols='50' rows='12' data-editor='tinymce' style='width: 800px; height: 600px;'>" . h($value) . "</textarea>";
		}

		return null;
	}
}
