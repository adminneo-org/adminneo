<?php

namespace AdminNeo;

class Locale
{
	public const Languages = [
		// Sorted by the translated name: Latin first, then Greek with Cyrillic, then other scripts.
		'en' => 'English',
		'id' => 'Bahasa Indonesia',
		'ms' => 'Bahasa Melayu',
		'bs' => 'Bosanski',
		'ca' => 'Català',
		'cs' => 'Čeština',
		'da' => 'Dansk',
		'de' => 'Deutsch',
		'et' => 'Eesti',
		'es' => 'Español',
		'fr' => 'Français',
		'gl' => 'Galego',
		'hr' => 'Hrvatski',
		'it' => 'Italiano',
		'lv' => 'Latviešu',
		'lt' => 'Lietuvių',
		'ro' => 'Limba Română',
		'hu' => 'Magyar',
		'nl' => 'Nederlands',
		'no' => 'Norsk',
		'pl' => 'Polski',
		'pt' => 'Português',
		'pt-BR' => 'Português (Brazil)',
		'sk' => 'Slovenčina',
		'sl' => 'Slovenski',
		'fi' => 'Suomi',
		'sv' => 'Svenska',
		'vi' => 'Tiếng Việt',
		'tr' => 'Türkçe',
		'bg' => 'Български',
		'el' => 'Ελληνικά',
		'ru' => 'Русский',
		'sr' => 'Српски',
		'uk' => 'Українська',
		'he' => 'עברית',
		'ar' => 'العربية',
		'fa' => 'فارسی',
		'hi' => 'हिन्दी',
		'bn' => 'বাংলা',
		'ta' => 'த‌மிழ்',
		'th' => 'ภาษาไทย',
		'ka' => 'ქართული',
		'ja' => '日本語',
		'zh' => '简体中文',
		'zh-TW' => '繁體中文',
		'ko' => '한국어',
	];

	/** @var string */
	private $language;

	/** @var string[] */
	private $translations;

	/** @var ?Locale */
	private static $instance = null;

	public static function create(string $language): Locale
	{
		if (self::$instance) {
			die(__CLASS__ . " instance already exists.\n");
		}

		return self::$instance = new static($language);
	}

	public static function get(): Locale
	{
		if (!self::$instance) {
			exit(__CLASS__ . " instance not found.\n");
		}

		return self::$instance;
	}

	protected function __construct(string $language)
	{
		$this->language = $language;
	}

	public function getLanguage(): string
	{
		return $this->language;
	}

	/**
	 * @param string[] $translations
	 */
	public function setTranslations(array $translations): void
	{
		$this->translations = $translations;
	}

	/**
	 * @return string[]
	 */
	public function getTranslations(): array
	{
		return $this->translations;
	}

	/**
	 * Returns translated text.
	 *
	 * @param string|int $key Numeric key is used in compiled version.
	 * @param int|string|null $number
	 */
	public function translate($key, $number = null): string
	{
		$key = $this->convertTranslationKey($key);
		$translation = $this->translations[$key] ?? $key;
		$language = $this->language;

		if (is_array($translation)) {
			// http://www.gnu.org/software/gettext/manual/html_node/Plural-forms.html
			$pos = ($number == 1 ? 0
				: ($language == 'cs' || $language == 'sk' ? ($number && $number < 5 ? 1 : 2) // different forms for 1, 2-4, other
				: ($language == 'fr' ? (!$number ? 0 : 1) // different forms for 0-1, other
				: ($language == 'pl' ? ($number % 10 > 1 && $number % 10 < 5 && $number / 10 % 10 != 1 ? 1 : 2) // different forms for 1, 2-4 except 12-14, other
				: ($language == 'sl' ? ($number % 100 == 1 ? 0 : ($number % 100 == 2 ? 1 : ($number % 100 == 3 || $number % 100 == 4 ? 2 : 3))) // different forms for 1, 2, 3-4, other
				: ($language == 'lt' ? ($number % 10 == 1 && $number % 100 != 11 ? 0 : ($number % 10 > 1 && $number / 10 % 10 != 1 ? 1 : 2)) // different forms for 1, 12-19, other
				: ($language == 'lv' ? ($number % 10 == 1 && $number % 100 != 11 ? 0 : ($number ? 1 : 2)) // different forms for 1 except 11, other, 0
				: ($language == 'ro' ? (!$number || ($number % 100 > 0 && $number % 100 < 20) ? 1 : 2) // different forms for 1, 0 and 2-19, other
				: ($language == 'bs' || $language == 'hr' || $language == 'ru' || $language == 'sr' || $language == 'uk' ? ($number % 10 == 1 && $number % 100 != 11 ? 0 : ($number % 10 > 1 && $number % 10 < 5 && $number / 10 % 10 != 1 ? 1 : 2)) // different forms for 1 except 11, 2-4 except 12-14, other
				: 1 // different forms for 1, other
			)))))))));
			$translation = $translation[$pos];
		}

		// Translations can contain HTML or be used in optionlist (we couldn't escape them here) but they can also be
		// used e.g. in title=''.
		// TODO escape plaintext translations
		$translation = str_replace("'", '’', $translation);

		$args = func_get_args();
		array_shift($args);

		$format = str_replace("%d", "%s", $translation);
		if ($format != $translation) {
			$args[0] = format_number($number);
		}

		return vsprintf($format, $args);
	}

	/**
	 * Converts translation key into the right form.
	 * In compiled version, string keys used in plugins are dynamically translated to numeric keys.
	 *
	 * @param string|int $key
	 *
	 * @return string|int
	 */
	function convertTranslationKey($key)
	{
		return $key; // !compile: convert translation key
	}
}
