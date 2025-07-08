<?php

namespace AdminNeo;

class DummyConnection extends Connection
{
	protected function __construct()
	{
		parent::__construct();

		$this->serverInfo = "0.1";
	}

	public function open(string $server, string $username, string $password): bool
	{
		return true;
	}

	public function selectDatabase(string $name): bool
	{
		return true;
	}

	public function quote(string $string): string
	{
		return true;
	}

	/**
	 * @inheritDoc
	 */
	public function query(string $query, bool $unbuffered = false)
	{
		return true;
	}
}
