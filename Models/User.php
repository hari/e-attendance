<?php namespace Attendance\Models;

use Attendance\Database\UserTable;

/**
 * 
 */
class User extends Model {

  const ADMIN   = 0x0;
  const TEACHER = 0x1;
  const STUDENT = 0x2;
  
  public $role;

  public static function isLoggedIn() {
    return isset($_SESSION) && isset($_SESSION['user']);
  }

  public static function create($pv = []) {
    return parent::_create(UserTable::getInstance(), $pv);
  }

  /**
   * Deletes a matching row from the table
   *
   *  delete(['age' => '=> 12', 'name' =>  '= ram']);
   *
   * @param $wheres array A collection of condition to meet for deleting the record
   *
   * @return boolean true if successfully deleted
   */
  public static function delete($wheres = []) {
    return parent::_delete(UserTable::getInstance(), $wheres);
  }
  
}