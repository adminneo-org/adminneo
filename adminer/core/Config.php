<?php

namespace Adminer;

class Config
{
	public const NavigationSimple = "simple";
	public const NavigationDual = "dual";
	public const NavigationReversed = "reversed";

	/** @var array */
	private $config;

	/** @var Server[] */
	private $servers = [];

	public function __construct(array $config)
	{
		$this->config = $config; // !compile: custom config

		if (isset($this->config["servers"])) {
			foreach ($this->config["servers"] as $server) {
				$serverObj = new Server($server);
				$this->servers[$serverObj->getKey()] = $serverObj;
			}
		}
	}

	public function getTheme(): string
	{
		return $this->config["theme"] ?? "default";
	}

	public function getColorVariant(): ?string
	{
		return $this->config["colorVariant"] ?? null;
	}

	/**
	 * @return string[]
	 */
	public function getCssUrls(): array
	{
		return $this->config["cssUrls"] ?? [];
	}

	/**
	 * @return string[]
	 */
	public function getJsUrls(): array
	{
		return $this->config["jsUrls"] ?? [];
	}

	public function getNavigationMode(): string
	{
		return $this->config["navigationMode"] ?? self::NavigationSimple;
	}

	public function isNavigationSimple(): bool
	{
		return $this->getNavigationMode() == self::NavigationSimple;
	}

	public function isNavigationDual(): bool
	{
		return $this->getNavigationMode() == self::NavigationDual;
	}

	public function isNavigationReversed(): bool
	{
		return $this->getNavigationMode() == self::NavigationReversed;
	}

	public function isSelectionPreferred(): bool
	{
		return $this->config["preferSelection"] ?? false;
	}

	public function getRecordsPerPage(): int
	{
		return (int)($this->config["recordsPerPage"] ?? 50);
	}

	public function isVersionVerificationEnabled(): bool
	{
		return $this->config["versionVerification"] ?? true;
	}

	public function getHiddenDatabases(): array
	{
		return $this->config["hiddenDatabases"] ?? [];
	}

	public function getHiddenSchemas(): array
	{
		return $this->config["hiddenSchemas"] ?? [];
	}

	public function getVisibleCollations(): array
	{
		return $this->config["visibleCollations"] ?? [];
	}

	public function getDefaultPasswordHash(): ?string
	{
		return $this->config["defaultPasswordHash"] ?? null;
	}

	public function getSslKey(): ?string
	{
		return $this->config["sslKey"] ?? null;
	}

	public function getSslCertificate(): ?string
	{
		return $this->config["sslCertificate"] ?? null;
	}

	public function getSslCaCertificate(): ?string
	{
		return $this->config["sslCaCertificate"] ?? null;
	}

	public function getSslMode(): ?string
	{
		return $this->config["sslMode"] ?? null;
	}

	public function getSslEncrypt(): ?bool
	{
		return $this->config["sslEncrypt"] ?? null;
	}

	public function getSslTrustServerCertificate(): ?bool
	{
		return $this->config["sslTrustServerCertificate"] ?? null;
	}

	public function hasServers(): bool
	{
		return isset($this->config["servers"]);
	}

	/**
	 * @return string[]
	 */
	public function getServerPairs(array $drivers): array
	{
		return array_map(function (Server $server) use ($drivers): string {
			$serverName = $server->getName();

			return $drivers[$server->getDriver()] . ($serverName != "" ? " - $serverName" : "");
		}, $this->servers);
	}

	public function getServer(string $serverKey): ?Server
	{
		return $this->servers[$serverKey] ?? null;
	}

	public function applyServer(string $server): void
	{
		$server = $this->getServer($server);
		if (!$server) {
			return;
		}

		$this->config = array_merge($this->config, $server->getConfigParams());
	}
}
