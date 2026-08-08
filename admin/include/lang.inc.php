<?php

namespace AdminNeo;

/**
 * Returns the list of available languages.
 *
 * @return bool[]
 */
function get_available_languages(): array
{
	return find_available_languages(); // !compile: available languages
}

/**
 * @deprecated
 */
function get_lang(): string
{
	return Locale::get()->getLanguage();
}

/**
 * Returns translated text.
 *
 * @param string|int $key Numeric key is used in compiled version.
 * @param int|string|null $number
 */
function lang($key, $number = null): string
{
	return call_user_func_array([Locale::get(), "translate"], func_get_args());
}

function get_language_options(): array
{
	$available_languages = get_available_languages();
	if (count($available_languages) == 1) {
		return [];
	}

	$options = [];
	foreach (Locale::Languages as $language => $title) {
		if (isset($available_languages[$language])) {
			$options[$language] = $title;
		}
	}

	return $options;
}

function language_select(): void
{
	$options = get_language_options();
	if (!$options) {
		return;
	}

	echo "<form action='' method='post'>\n";
	echo html_select("lang", $options, Locale::get()->getLanguage(), "this.form.submit();");
	echo "<input type='submit' value='" . lang('Use'), "' class='button hidden'>\n";
	echo input_token();
	echo "</form>\n";
}

$available_languages = get_available_languages();
$language = array_keys($available_languages)[0];

// The language is stored by Settings, which is not created yet, so the selected one is saved in the bootstrap.
$posted_language = null;

if (isset($_POST["lang"]) && isset($available_languages[$_POST["lang"]]) && verify_token()) { // $error not yet available
	$posted_language = $_SESSION["lang"] = $_POST["lang"]; // cookies may be disabled
	$_SESSION["translations"] = []; // used in compiled version
}

// The old cookie is read until Settings migrates it to the settings cookie.
$saved_language = Settings::readParameter("lang") ?? ($_COOKIE["neo_lang"] ?? null);

if ($saved_language !== null && isset($available_languages[$saved_language])) {
	$language = $saved_language;
} elseif (isset($_SESSION["lang"]) && isset($available_languages[$_SESSION["lang"]])) {
	$language = $_SESSION["lang"];
} elseif (isset($_SERVER["HTTP_ACCEPT_LANGUAGE"])) {
	$accept_language = [];
	preg_match_all('~([-a-z]+)(;q=([0-9.]+))?~', str_replace("_", "-", strtolower($_SERVER["HTTP_ACCEPT_LANGUAGE"])), $matches, PREG_SET_ORDER);
	foreach ($matches as $match) {
		$accept_language[$match[1]] = ($match[3] ?? 1);
	}

	arsort($accept_language);
	foreach ($accept_language as $key => $q) {
		if (isset($available_languages[$key])) {
			$language = $key;
			break;
		}

		$key = preg_replace('~-.*~', '', $key);
		if (!isset($accept_language[$key]) && isset($available_languages[$key])) {
			$language = $key;
			break;
		}
	}
}

Locale::create($language);
