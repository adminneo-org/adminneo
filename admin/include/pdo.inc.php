<?php

namespace AdminNeo;

// PDO can be used in several database drivers
use Exception;
use PDO;
use PDOStatement;

if (extension_loaded('pdo')) {
	abstract class PdoConnection extends Connection
	{
		/** @var PDO */
		protected $pdo;

		/** @var PdoResult|false */
		protected $multiResult;

		protected function dsn(string $dsn, string $username, string $password, array $options = []): bool
		{
			$options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_SILENT;

			try {
				$this->pdo = new PDO($dsn, $username, $password, $options);
			} catch (Exception $exception) {
				$this->error = $exception->getMessage();
				return false;
			}

			$this->version = preg_replace('~^\D*([\d.]+).*~', "$1", (string)@$this->pdo->getAttribute(PDO::ATTR_SERVER_VERSION));

			return true;
		}

		function quote(string $string): string
		{
			return $this->pdo->quote($string);
		}

		function query(string $query, bool $unbuffered = false)
		{
			$statement = $this->pdo->query($query);

			$this->error = "";
			if (!$statement) {
				return $this->storeError(false);
			}

			$result = new PdoResult($statement);
			$this->storeResult($result);

			return $result;
		}

		public function storeResult($result = null)
		{
			if (!$result) {
				$result = $this->multiResult;
				if (!$result) {
					return false;
				}
			}

			if ($result->getColumnsCount()) {
				return $result;
			}

			$this->affectedRows = $result->getAffectedRowsCount();

			return true;
		}

		function nextResult(): bool
		{
			// Forget the error of a query run between the result sets, e.g. SHOW WARNINGS fails while the next ones are pending.
			$this->error = "";

			if (!$this->multiResult) {
				return false;
			}
			if ($this->multiResult->nextRowset()) {
				return true;
			}

			// The error of the next query is stored in the statement. Drivers not supporting rowsets report IM001 without a message.
			$errorInfo = $this->multiResult->getErrorInfo();
			$this->multiResult = false;

			if (!isset($errorInfo[2])) {
				return false;
			}

			list(, $this->errno, $this->error) = $errorInfo;

			return true;
		}

		public function inTransaction(): bool
		{
			// PDO_PgSQL, PDO_MySQL and PDO_SQLite (since PHP 8.4) ask the connection, other drivers report only transactions started by PDO.
			return $this->pdo->inTransaction();
		}

		public function begin(): bool
		{
			// The API works also where a separate BEGIN doesn't, e.g. MS SQL rolls it back at the end of the batch and Oracle commits each command.
			return $this->storeError($this->pdo->beginTransaction());
		}

		public function commit(): bool
		{
			// PDO throws without a transaction, PDO_MySQL reports none after a DDL command committed it implicitly.
			return !$this->pdo->inTransaction() || $this->storeError($this->pdo->commit());
		}

		public function rollback(): bool
		{
			return !$this->pdo->inTransaction() || $this->storeError($this->pdo->rollBack());
		}

		/**
		 * Stores the last error of the connection if the operation failed.
		 */
		private function storeError(bool $return): bool
		{
			if (!$return) {
				list(, $this->errno, $this->error) = $this->pdo->errorInfo();
				if (!$this->error) {
					$this->error = lang('Unknown error.');
				}
			}

			return $return;
		}
	}

	class PdoResult extends Result
	{
		/** @var PDOStatement */
		private $statement;

		/** @var int */
		private $offset = 0;

		public function __construct(PDOStatement $statement)
		{
			// It is not guaranteed to work with all drivers.
			// MSSQL PDO driver returns -1 for SELECT queries.
			parent::__construct(max($statement->columnCount() ? $statement->rowCount() : 0, 0));

			$this->statement = $statement;
		}

		public function getColumnsCount(): int
		{
			return $this->statement->columnCount();
		}

		public function getAffectedRowsCount(): int
		{
			return $this->statement->rowCount();
		}

		public function fetchAssoc()
		{
			return $this->fetchArray(PDO::FETCH_ASSOC);
		}

		public function fetchRow()
		{
			return $this->fetchArray(PDO::FETCH_NUM);
		}

		private function fetchArray(int $mode)
		{
			$result = $this->statement->fetch($mode);

			return $result ? array_map([$this, 'unresource'], $result) : $result;
		}

		private function unresource($value) {
			return is_resource($value) ? stream_get_contents($value) : $value;
		}

		public function fetchField()
		{
			$row = $this->statement->getColumnMeta($this->offset++);
			if ($row === false) {
				return false;
			}

			$type = $row["pdo_type"];
			$row["type"] = ($type == PDO::PARAM_INT ? 0 : 15);
			$row["charsetnr"] = ($type == \PDO::PARAM_LOB || (isset($row["flags"]) && in_array("blob", (array) $row["flags"])) ? 63 : 0);

			return (object) $row;
		}

		public function seek(int $offset): bool
		{
			for ($i = 0; $i < $offset; $i++) {
				if ($this->statement->fetch() === false) {
					return false;
				};
			}

			return true;
		}

		public function nextRowset(): bool
		{
			$this->offset = 0;

			// @ - PDO_PgSQL doesn't support it
			return @$this->statement->nextRowset();
		}

		public function getErrorInfo(): array
		{
			return $this->statement->errorInfo();
		}
	}
}
