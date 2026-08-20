<?php

namespace AdminNeo;

class Settings
{
	private const CookieName = "neo_settings";

	public const ColorSchemeLight = "light";
	public const ColorSchemeDark = "dark";

	/** Limits of the navigation panel width in rem units. */
	public const NavigationWidthMin = 10;
	public const NavigationWidthMax = 30;

	/** @var Config */
	private $config;

	/** @var array */
	private $params = [];

	public function __construct(Config $config)
	{
		$this->config = $config;

		if (isset($_COOKIE[self::CookieName])) {
			parse_str($_COOKIE[self::CookieName], $this->params);

			// Prolong settings cookie.
			$this->save();
		}

		// Migrate old parameters.
		if (isset($_COOKIE["neo_lang"])) {
			$this->updateParameter("lang", $_COOKIE["neo_lang"]);

			unset($_COOKIE["neo_lang"]);
			cookie("neo_lang", "", -3600);
		}
	}

	/**
	 * Returns the parameter read directly from the cookie. Usable before the instance is created.
	 */
	public static function readParameter(string $key): ?string
	{
		parse_str($_COOKIE[self::CookieName] ?? "", $params);

		return $params[$key] ?? null;
	}

	/**
	 * @return string|array|null
	 */
	public function getParameter(string $key, ?string $default = null)
	{
		return $this->params[$key] ?? $default;
	}

	public function updateParameter(string $key, ?string $value): void
	{
		$this->updateParameters([$key => $value]);
	}

	/**
	 * @param (string|array)[] $params
	 */
	public function updateParameters(array $params): void
	{
		$this->params = array_filter(array_merge($this->params, $params), function ($value) {
			return $value !== null;
		});

		$this->save();
	}

	private function save(): void
	{
		// Expires in 90 days.
		cookie(self::CookieName, http_build_query($this->params), 7776000);
	}

	public function getColorScheme(): ?string
	{
		return $this->getParameter("colorScheme");
	}

	public function getNavigationMode(): string
	{
		return $this->getParameter("navigationMode") ?? $this->config->getNavigationMode();
	}

	public function isNavigationSimple(): bool
	{
		return $this->getNavigationMode() == Config::NavigationSimple;
	}

	public function isNavigationDual(): bool
	{
		return $this->getNavigationMode() == Config::NavigationDual;
	}

	public function isNavigationHover(): bool
	{
		return $this->getNavigationMode() == Config::NavigationHover;
	}

	public function isNavigationReversed(): bool
	{
		return $this->getNavigationMode() == Config::NavigationReversed;
	}

	/**
	 * Returns the width of the navigation panel in rem units set by dragging its edge, adjusted to the limits.
	 */
	public function getNavigationWidth(): ?float
	{
		$width = $this->getParameter("navigationWidth");
		if ($width === null) {
			return null;
		}

		return min(max((float)$width, self::NavigationWidthMin), self::NavigationWidthMax);
	}

	public function isSelectionPreferred(): bool
	{
		return $this->getParameter("preferSelection") ?? $this->config->isSelectionPreferred();
	}

	public function isRelationLinks(): bool
	{
		return $this->params["relationLinks"] ?? $this->config->isRelationLinks();
	}

	public function getRecordsPerPage(): int
	{
		return $this->getParameter("recordsPerPage") ?? $this->config->getRecordsPerPage();
	}

	public function getEnumAsSelectThreshold(): ?int
	{
		$value = $this->getParameter("enumAsSelectThreshold");
		if ($value < 0) {
			return null;
		}

		return $value !== null ? (int)$value : $this->config->getEnumAsSelectThreshold();
	}
}
