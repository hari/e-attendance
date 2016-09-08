<?php namespace Attendance\Database;

use Attendance\Database\Connection;

abstract class TableInterface {

	public static function create();

	public static function destroy() {
  }

  protected static function execute($sql, $params) {
    $con = Connection::get();
    $pst = $con->prepare($sql);
    $pst->bindParam($params);
    return $pst->execute();
  }

}