<?php namespace Attendance\Utils;
use Attendance\Models\User;

class Session {
  private static $store = [];

  public static function put($key, $value) {
    if (isset($_SESSION))
      $_SESSION[$key] = $value;
    else
      self::$store[$key] = $value;
  }

  public static function get($key) {
    if (isset($_SESSION) && isset($_SESSION[$key]))
      return $_SESSION[$key];
    return null;
  }

  public static function has($key) {
    return self::get($key) != null;
  }

}