<?php

namespace AdminNeo;

class Locale
{
	public const Languages = [
		'en' => 'English', // Jakub Vrána - https://www.vrana.cz
		'ar' => 'العربية', // Y.M Amine - Algeria - nbr7@live.fr
		'bg' => 'Български', // Deyan Delchev
		'bn' => 'বাংলা', // Dipak Kumar - dipak.ndc@gmail.com | Hossain Ahmed Saiman - hossain.ahmed@altscope.com
		'bs' => 'Bosanski', // Emir Kurtovic
		'ca' => 'Català', // Joan Llosas
		'cs' => 'Čeština', // Jakub Vrána - https://www.vrana.cz
		'da' => 'Dansk', // Jarne W. Beutnagel - jarne@beutnagel.dk
		'de' => 'Deutsch', // Klemens Häckel - http://clickdimension.wordpress.com
		'el' => 'Ελληνικά', // Dimitrios T. Tanis - jtanis@tanisfood.gr
		'es' => 'Español', // Klemens Häckel - http://clickdimension.wordpress.com
		'et' => 'Eesti', // Priit Kallas
		'fa' => 'فارسی', // mojtaba barghbani - Iran - mbarghbani@gmail.com, Nima Amini - http://nimlog.com
		'fi' => 'Suomi', // Finnish - Kari Eveli - http://www.lexitec.fi/
		'fr' => 'Français', // Francis Gagné, Aurélien Royer
		'gl' => 'Galego', // Eduardo Penabad Ramos
		'he' => 'עברית', // Binyamin Yawitz - https://stuff-group.com/
		'hi' => 'हिन्दी', // Joshi yogesh
		'hu' => 'Magyar', // Borsos Szilárd (Borsosfi) - http://www.borsosfi.hu, info@borsosfi.hu
		'id' => 'Bahasa Indonesia', // Ivan Lanin - http://ivan.lanin.org
		'it' => 'Italiano', // Alessandro Fiorotto, Paolo Asperti
		'ja' => '日本語', // Hitoshi Ozawa - http://sourceforge.jp/projects/oss-ja-jpn/releases/
		'ka' => 'ქართული', // Saba Khmaladze skhmaladze@uglt.org
		'ko' => '한국어', // dalli - skcha67@gmail.com
		'lv' => 'Latviešu', // Kristaps Lediņš - https://krysits.com
		'lt' => 'Lietuvių', // Paulius Leščinskas - http://www.lescinskas.lt
		'ms' => 'Bahasa Melayu', // Pisyek
		'nl' => 'Nederlands', // Maarten Balliauw - http://blog.maartenballiauw.be
		'no' => 'Norsk', // Iver Odin Kvello, mupublishing.com
		'pl' => 'Polski', // Radosław Kowalewski - http://srsbiz.pl/
		'pt' => 'Português', // André Dias
		'pt-BR' => 'Português (Brazil)', // Gian Live - gian@live.com, Davi Alexandre davi@davialexandre.com.br, RobertoPC - http://www.robertopc.com.br
		'ro' => 'Limba Română', // .nick .messing - dot.nick.dot.messing@gmail.com
		'ru' => 'Русский', // Maksim Izmaylov; Andre Polykanine - https://github.com/Oire/
		'sk' => 'Slovenčina', // Ivan Suchy - http://www.ivansuchy.com, Juraj Krivda - http://www.jstudio.cz
		'sl' => 'Slovenski', // Matej Ferlan - www.itdinamik.com, matej.ferlan@itdinamik.com
		'sr' => 'Српски', // Nikola Radovanović - cobisimo@gmail.com
		'sv' => 'Svenska', // rasmusolle - https://github.com/rasmusolle
		'ta' => 'த‌மிழ்', // G. Sampath Kumar, Chennai, India, sampathkumar11@gmail.com
		'th' => 'ภาษาไทย', // Panya Saraphi, elect.tu@gmail.com - http://www.opencart2u.com/
		'tr' => 'Türkçe', // Bilgehan Korkmaz - turktron.com
		'uk' => 'Українська', // Valerii Kryzhov
		'vi' => 'Tiếng Việt', // Giang Manh @ manhgd google mail
		'zh' => '简体中文', // Mr. Lodar, vea - urn2.net - vea.urn2@gmail.com
		'zh-TW' => '繁體中文', // http://tzangms.com
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
		$translation = $this->translations[$key] ?: $key;
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
				: ($language == 'bs' || $language == 'ru' || $language == 'sr' || $language == 'uk' ? ($number % 10 == 1 && $number % 100 != 11 ? 0 : ($number % 10 > 1 && $number % 10 < 5 && $number / 10 % 10 != 1 ? 1 : 2)) // different forms for 1 except 11, 2-4 except 12-14, other
				: 1 // different forms for 1, other
			))))))));
			$translation = $translation[$pos];
		}

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
