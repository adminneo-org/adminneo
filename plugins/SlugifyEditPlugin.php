<?php

namespace AdminNeo;

/**
 * Prefills field starting with  "slug_" or ending with "_slug" with slugified value of a previous field.
 *
 * Target slug field has to be empty.
 *
 * @link https://www.adminer.org/plugins/#use
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 * @author Peter Knut
 *
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class SlugifyEditPlugin
{
	/** @var string[] */
	private $slugifyFields;

	public function head(): ?bool
	{
		$nonce = nonce();

		echo "
		<script $nonce>
			function initSlugField(input, slugField, maxLenght) {
				input.oninput = function () {
					const target = this.form[`fields[\${slugField}]`];

					if (target.value === '' || target.dataset.slugEnabled) {
						target.value = webalize(this.value).substring(0, maxLenght);
						target.dataset.slugEnabled = 'true';
					}
				}
			}

			function webalize(string) {
				return string.normalize('NFKD') // decompose
					.replace(/[\u0300-\u036f]/g, '') // remove diacritics
					.toLowerCase()
					.replace(/&/g, '-and-') // ampersand to and
					.replace(/[^\w]+/g, '-') // non-words to dash
					.replace(/^-|-$/g, ''); // trim
			}
		</script>
		";

		return null;
	}

	public function getFieldInput(string $table, array $field, string $attrs, $value, ?string $function): ?string
	{
		// Do not slugify in multi-edit mode.
		if (($_GET["select"] ?? null)) {
			return null;
		}

		// Find fields to slugify.
		if ($this->slugifyFields === null) {
			$this->slugifyFields = [];
			$prev = null;

			foreach (fields($table) as $name => $val) {
				if ($prev && preg_match('~(^|_)slug(_|$)~', $name)) {
					$this->slugifyFields[$prev] = $name;
				}

				$prev = $name;
			}
		}

		$slug = $this->slugifyFields[$field["field"]] ?? null;
		if ($slug === null) {
			return null;
		}

		return "<input class='input' value='" . h($value) . "' data-maxlength='$field[length]' size='40' $attrs>"
			. script("initSlugField(qsl('input'), '$slug', $field[length]);");
	}
}
