<?php namespace Attendance\Models;

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
  
}