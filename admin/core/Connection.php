<?php

namespace AdminNeo;

abstract class Connection
{
	/** @var string */
	protected $server_info;

	/** @var int */
	protected $affected_rows = 0;

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
		return $this->server_info;
	}

	public function getAffectedRows(): int
	{
		return $this->affected_rows;
	}

	public function setAffectedRows(int $affected_rows): void
	{
		$this->affected_rows = $affected_rows;
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
	 * @return Result|bool
	 */
	public abstract function query(string $query, bool $unbuffered = false);

	/**
	 * @return mixed
	 */
	public function getResult(string $query, int $field = 0)
	{
		$result = $this->query($query);
		if (!is_object($result)) {
			return false;
		}

		$row = $result->fetch_row();

		return $row ? $row[$field] : false;
	}

	/**
	 * @return Result|false
	 */
	public function multiQuery(string $query)
	{
		return $this->multiResult = $this->query($query);
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
