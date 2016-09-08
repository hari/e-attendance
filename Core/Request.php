<?php namespace Attendance\Core;

class Request {

  public static function get($key) {
    if (isset($_REQUEST) && isset($_REQUEST[$key])) {
      return $_REQUEST[$key];
    }
    return null;
  }

  public static function pull($key) {
    $value = self::get($key);
    if ($value != nul) {
      unset($_REQUEST[$key]);
    }
    return $value;
  }

}