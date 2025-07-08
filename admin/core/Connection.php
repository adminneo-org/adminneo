<?php

namespace AdminNeo;

abstract class Connection
{
	/** @var string */
	protected $serverInfo;

	/** @var int */
	protected $affectedRows = 0;

	/** @var int */
	protected $errno = 0;

	/** @var string */
	protected $error = '';

	/** @var Result|false */
	protected $multiResult;

	/** @var ?Connection */
	private static $instance = null;

	public static function create(): Connection
	{
		if (self::$instance) {
			die(__CLASS__ . " instance already exists.\n");
		}

		return self::$instance = new static();
	}

	public static function createSecondary(): Connection
	{
		return new static();
	}

	public static function get(): Connection
	{
		if (!self::$instance) {
			exit(__CLASS__ . " instance not found.\n");
		}

		return self::$instance;
	}

	protected function __construct()
	{
		//
	}

	public abstract function open(string $server, string $username, string $password): bool;

	public function getServerInfo(): string
	{
		return $this->serverInfo;
	}

	public function getVersion(): string
	{
		return $this->getServerInfo();
	}

	public function isMinVersion(string $version): bool
	{
		return version_compare($this->getVersion(), $version) >= 0;
	}

	public function isMariaDB(): bool
	{
		return str_contains($this->getServerInfo(), "MariaDB");
	}

	public function isCockroachDB(): bool
	{
		return str_contains($this->getServerInfo(), "CockroachDB");
	}

	public function getAffectedRows(): int
	{
		return $this->affectedRows;
	}

	public function setAffectedRows(int $affectedRows): void
	{
		$this->affectedRows = $affectedRows;
	}

	public function getErrno(): int
	{
		return $this->errno;
	}

	public function getError(): string
	{
		return $this->error;
	}

	public function setError(string $error): void
	{
		$this->error = $error;
	}

	public abstract function selectDatabase(string $name): bool;

	public abstract function quote(string $string): string;

	/**
	 * Converts the value returned by database to the actual value.
	 *
	 * @param ?string $value Original value.
	 * @param array $field Single field returned from fields().
	 */
	public function formatValue(?string $value, array $field): ?string
	{
		return $value;
	}

	/**
	 * @return Result|bool
	 */
	public abstract function query(string $query, bool $unbuffered = false);

	/**
	 * @deprecated
	 */
	public function getResult(string $query, int $field = 0)
	{
		return $this->getValue($query, $field);
	}

	/**
	 * @return mixed|false Returns false on error.
	 */
	public function getValue(string $query, int $fieldIndex = 0)
	{
		$result = $this->query($query);
		if (!is_object($result)) {
			return false;
		}

		$row = $result->fetchRow();

		return $row ? $row[$fieldIndex] : false;
	}

	public function multiQuery(string $query): bool
	{
		$this->multiResult = $this->query($query);

		return (bool)($this->multiResult);
	}

	/**
	 * @param ?Result|bool $result
	 *
	 * @return Result|bool
	 */
	public function storeResult($result = null)
	{
		return $this->multiResult;
	}

	public function nextResult(): bool
	{
		return false;
	}
}
