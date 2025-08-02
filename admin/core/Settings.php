<?php

namespace AdminNeo;

class Settings
{
	public const ColorModeLight = "light";
	public const ColorModeDark = "dark";

	/** @var Config */
	private $config;

	/** @var array */
	private $params = [];

	public function __construct(Config $config)
	{
		$this->config = $config;

		if (isset($_COOKIE["neo_settings"])) {
			parse_str($_COOKIE["neo_settings"], $this->params);

			// Prolong settings cookie.
			$this->save();
		}
	}

	/**
	 * @return string[]
	 */
	public function getParameters(): array
	{
		return $this->params;
	}

	/**
	 * @return string|array|null
	 */
	public function getParameter(string $key)
	{
		return $this->params[$key] ?? null;
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
		cookie("neo_settings", http_build_query($this->params), 7776000);
	}

	public function updateParameter(string $key, string $value): void
	{
		$this->updateParameters([$key => $value]);
	}

	public function getColorMode(): ?string
	{
		return $this->getParameter("colorMode");
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

	public function isNavigationReversed(): bool
	{
		return $this->getNavigationMode() == Config::NavigationReversed;
	}

	public function isSelectionPreferred(): bool
	{
		return $this->getParameter("preferSelection") ?? $this->config->isSelectionPreferred();
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
