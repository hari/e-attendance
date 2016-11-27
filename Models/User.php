<?php namespace Attendance\Models;

use Attendance\Database\UserTable;
use Attendance\Utils\Session;

/**
 * 
 */
class User extends Model {

  const ADMIN   = 0x0;
  const TEACHER = 0x1;
  const STUDENT = 0x2;
  
  public $role;

  public static function isLoggedIn() {
    return Session::has('user');
  }

  public static function logged() {
    return Session::get('user');
  }

  public static function create($pv = []) {
    return parent::_create(UserTable::getInstance(), $pv);
  }

  public static function select($cols = [], $where) {
    return parent::_select(UserTable::getInstance(), $cols, $where);
  }

  public static function login($username, $password) {
    if (!preg_match("/^se\d{6}/", $username)) {
      return false;
    }
    $where = sprintf("where reg_no = '%s' and password = '%s'", $username, md5($password));
    $user = self::select(['role', 'full_name'], $where);
    if ($user == null || empty($user)) {
      return false;
    }
    $u = new User();
    $u->instance = $user;
    Session::put("user", $u);
    return true;
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