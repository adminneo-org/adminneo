<?php

namespace AdminNeo;

class Settings
{
	public const ColorModeLight = "light";
	public const ColorModeDark = "dark";

	/** @var Config */
	private $config;

	/** @var array */
	private $params;

	public function __construct(Config $config)
	{
		$this->config = $config;

		parse_str($_COOKIE["neo_settings"] ?? "", $this->params);
	}

	/**
	 * @return string[]
	 */
	public function getParameters(): array
	{
		return $this->params;
	}

	public function getParameter(string $key): ?string
	{
		return $this->params[$key] ?? null;
	}

	/**
	 * @param string[] $params
	 */
	public function updateParameters(array $params): void
	{
		$this->params = array_filter(array_merge($this->params, $params), function (?string $value) {
			return $value !== null;
		});

		cookie("neo_settings", http_build_query($this->params));
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
}
