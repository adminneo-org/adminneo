<?php

namespace AdminNeo;

// PDO can be used in several database drivers
use Exception;
use PDO;
use PDOStatement;

if (extension_loaded('pdo')) {
	abstract class PdoDatabase extends Database
	{
		/** @var PDO */
		protected $pdo;

		/** @var PDOStatement|false */
		protected $multiResult;

		protected function dsn(string $dsn, string $username, string $password, array $options = []): void
		{
			$options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_SILENT;
			$options[PDO::ATTR_STATEMENT_CLASS] = [PdoResult::class];

			try {
				$this->pdo = new PDO($dsn, $username, $password, $options);
			} catch (Exception $ex) {
				auth_error(h($ex->getMessage())); // TODO: Just return error text.
			}

			$this->server_info = @$this->pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
		}

		function quote(string $string): string
		{
			return $this->pdo->quote($string);
		}

		/**
		 * @return PDOStatement|false
		 */
		function query(string $query, bool $unbuffered = false)
		{
			$result = $this->pdo->query($query);

			$this->error = "";
			if (!$result) {
				list(, $this->errno, $this->error) = $this->pdo->errorInfo();
				if (!$this->error) {
					$this->error = lang('Unknown error.');
				}

				return false;
			}

			$this->storeResult($result);

			return $result;
		}

		/**
		 * @param ?PDOStatement|bool $result
		 *
		 * @return PDOStatement|bool
		 */
		public function storeResult($result = null)
		{
			if (!$result) {
				$result = $this->multiResult;
				if (!$result) {
					return false;
				}
			}

			if ($result->columnCount()) {
				$result->num_rows = $result->rowCount(); // is not guaranteed to work with all drivers

				return $result;
			}

			$this->affected_rows = $result->rowCount();

			return true;
		}

		function nextResult(): bool
		{
			if (!$this->multiResult) {
				return false;
			}

			$this->multiResult->_offset = 0;

			return @$this->multiResult->nextRowset(); // @ - PDO_PgSQL doesn't support it
		}
	}

	class PdoResult extends PDOStatement
	{
		var $_offset = 0, $num_rows;

		function fetch_assoc()
		{
			return $this->fetch(PDO::FETCH_ASSOC);
		}

		function fetch_row()
		{
			return $this->fetch(PDO::FETCH_NUM);
		}

		function fetch_field()
		{
			$row = (object)$this->getColumnMeta($this->_offset++);
			$row->orgtable = $row->table ?? null;
			$row->orgname = $row->name;
			$row->charsetnr = (in_array("blob", $row->flags ?? []) ? 63 : 0);

			return $row;
		}

		function seek($offset)
		{
			for ($i = 0; $i < $offset; $i++) {
				$this->fetch();
			}
		}
	}
}
