<?php namespace Attendance\Models;

use Attendance\Database\UserTable;
use Attendance\Utils\Session;
use Attendance\Utils\MessageBox;
use Attendance\Database\Connection;

class User extends Model {

  const ADMIN   = 0x0;
  const TEACHER = 0x1;
  const STUDENT = 0x2;
  
  public $role;

  public static function isLoggedIn() {
    return Session::has('user');
  }

  public static function update($sql) {
    return Connection::execute($sql);
  }

  public static function logged() {
    $user = new User();
    if (Session::get('user') != null) {
      $prop = self::select(['*'], "where reg_no = '" . Session::get('user') . "'");
      $user->instance = $prop[0];
    };
    return $user;
  }

  public static function create($pv = []) {
    return parent::_create(UserTable::getInstance(), $pv);
  }

  public static function select($cols = [], $where) {
    return parent::_select(UserTable::getInstance(), $cols, $where);
  }

  public static function login($username, $password) {
    $where = sprintf("where reg_no = '%s' and password = '%s'", $username, md5($password));
    $user = self::select(['reg_no'], $where);
    if ($user == null || empty($user)) {
      MessageBox::set(['type' => 'failed', 'message' => 'Invalid username or password!']);
      return false;
    }
    Session::put("user", $user[0]['reg_no']);
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