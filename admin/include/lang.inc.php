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

function language_select()
{
	$available_languages = get_available_languages();
	if (count($available_languages) == 1) {
		return;
	}

	$options = [];
	foreach (Locale::Languages as $language => $title) {
		if (isset($available_languages[$language])) {
			$options[$language] = $title;
		}
	}

	echo "<div class='language'><form action='' method='post'>\n";
	echo html_select("lang", $options, Locale::get()->getLanguage(), "this.form.submit();");
	echo "<input type='submit' value='" . lang('Use'), "' class='button hidden'>\n";
	echo "<input type='hidden' name='token' value='", get_token(), "'>\n"; // $token may be empty in auth.inc.php
	echo "</form></div>\n";
}

if (isset($_POST["lang"]) && verify_token()) { // $error not yet available
	cookie("neo_lang", $_POST["lang"]);

	$_SESSION["lang"] = $_POST["lang"]; // cookies may be disabled
	$_SESSION["translations"] = []; // used in compiled version

	redirect(remove_from_uri());
}

$available_languages = get_available_languages();
$LANG = array_keys($available_languages)[0];

if (isset($_COOKIE["neo_lang"]) && isset($available_languages[$_COOKIE["neo_lang"]])) {
	cookie("neo_lang", $_COOKIE["neo_lang"]);
	$LANG = $_COOKIE["neo_lang"];
} elseif (isset($available_languages[$_SESSION["lang"]])) {
	$LANG = $_SESSION["lang"];
} elseif (isset($_SERVER["HTTP_ACCEPT_LANGUAGE"])) {
	$accept_language = [];
	preg_match_all('~([-a-z]+)(;q=([0-9.]+))?~', str_replace("_", "-", strtolower($_SERVER["HTTP_ACCEPT_LANGUAGE"])), $matches, PREG_SET_ORDER);
	foreach ($matches as $match) {
		$accept_language[$match[1]] = ($match[3] ?? 1);
	}

	arsort($accept_language);
	foreach ($accept_language as $key => $q) {
		if (isset($available_languages[$key])) {
			$LANG = $key;
			break;
		}

		$key = preg_replace('~-.*~', '', $key);
		if (!isset($accept_language[$key]) && isset($available_languages[$key])) {
			$LANG = $key;
			break;
		}
	}
}

Locale::create($LANG);
