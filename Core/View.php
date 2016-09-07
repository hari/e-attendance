<?php namespace Attendance\Core;

class View {
  
  public static function make() {
    $args = func_get_args();
    if (count($args) > 0) {
      $file = str_replace(".", "/", $args[0]);
      ob_start();
      if (count($args) >= 2) {
        extract($args[1]);
      }
      $file (DIR_VIEW . '/' . $file . '.php');
      if (!file_exists($file)) {

      }
      @include_once $file;
      $data = ob_get_contents();
      ob_clean();
      return $data;
    }
  }

}