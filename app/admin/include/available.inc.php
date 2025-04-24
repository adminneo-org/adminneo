<?php

namespace AdminNeo;

/**
 * Finds available themes and color variants in sources.
 *
 * @return bool[][]
 */
function find_available_themes(): array
{
	static $themes = [];

	if (!$themes) {
		$paths = array_filter(glob(__DIR__ . "/../themes/*"));

		foreach ($paths as $path) {
			if (preg_match('~/([^/]+)-(blue|green|red)$~', $path, $matches)) {
				$themes[$matches[1]][$matches[2]] = true;
			}
		}
	}

	return $themes;
}

/**
 * Finds available languages in sources.
 *
 * @return bool[]
 */
function find_available_languages(): array
{
	static $languages = [];

	if (!$languages) {
		$paths = array_filter(glob(__DIR__ . "/../translations/*"));

		foreach ($paths as $path) {
			if (preg_match('~/([^/]+)\.inc\.php$~', $path, $matches)) {
				$languages[$matches[1]] = true;
			}
		}
	}

	return $languages;
}
