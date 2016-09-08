<?php namespace Attendance\Database;

use Attendance\Database\Connection;

abstract class AbstractTable {

  protected $table_name, $error;

	public abstract function create();

	public function destroy() {
    return $this->execute('DROP TABLE ' . $this->getTableName());
  }

  public function getTableName() {
    if ($this->table_name == null) 
      throw new \Exception('Table Name is null, make sure to set table name in constructor', 1);
    return $this->table_name;
  }

  protected function execute($sql, $params = []) {
    $con = Connection::get();
    $pst = $con->prepare($sql);
    if (!$pst->execute($params)) {
      $this->setError($pst->errorInfo());
      return false;
    }
    return true;
  }

  public function createInsertStatement($pv = []) {
    return sprintf('INSERT INTO %s (%s) VALUES (%s)', $this->getTableName(), 
                  implode(',', array_keys($pv)),
                  str_repeat('?, ', count($pv) - 1) . '?');
  }

  public function insert($pv = []) {
    return $this->execute($this->createInsertStatement($pv), array_values($pv));
  }

  public function getError() {
    return $this->error;
  }

  public function setError($err) {
    $this->error = $err;
  }

}