<?php
class Connection {

  private static $connection;

  private function __construct() {

  }

  public static function get() {
    
  }

  public static function close() {
    if (self::$connection != null) {
      $connection->close();
    }
  }

}