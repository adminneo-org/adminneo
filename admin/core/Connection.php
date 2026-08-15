<?php

namespace AdminNeo;

abstract class Connection
{
	/** @var ?string */
	protected $flavor = null;

	/** @var string */
	protected $version;

	/** @var int */
	protected $affectedRows = 0;

	/** @var int */
	protected $errno = 0;

	/** @var string */
	protected $error = "";

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

	public static function exists(): bool
	{
		return self::$instance !== null;
	}

	protected function __construct()
	{
		//
	}

	public function getDefaultServerName(): string
	{
		return "";
	}

	/**
	 * Tries to open a connection without a password at first.
	 * If the database does not require a password, the configured default password is verified instead.
	 *
	 * @param string $server Host name or an IP address.
	 * @param string $username Database username.
	 * @param string $password User's password.
	 * @param bool $strict Prevents using any password if the default password is not defined or empty.
	 *
	 * @return bool true if successful, false if skipped or an error occurred.
	 */
	public function openPasswordless(string $server, string $username, string $password, bool $strict = true): bool
	{
		$hasDefault = Admin::get()->getConfig()->getDefaultPasswordHash() != "";

		if ($password != "" && ($strict || $hasDefault) && $this->open($server, $username, "")) {
			$result = Admin::get()->verifyDefaultPassword($password);
			if ($result !== true) {
				$this->error = $result;
				return false;
			}

			return true;
		}

		return $this->open($server, $username, $password);
	}

	public abstract function open(string $server, string $username, string $password): bool;

	public function getFlavor(): ?string
	{
		return $this->flavor;
	}

	public function isMariaDB(): bool
	{
		return $this->flavor == "mariadb";
	}

	public function isCockroachDB(): bool
	{
		return $this->flavor == "cockroach";
	}

	public function getVersion(): string
	{
		return $this->version;
	}

	public function isMinVersion(string $version): bool
	{
		return version_compare($this->version, $version) >= 0;
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
	 * Returns information about the most recently executed query.
	 *
	 * @see https://www.php.net/mysqli_info
	 */
	public function getQueryInfo(): ?string
	{
		return null;
	}

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
