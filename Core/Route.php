<?php namespace Attendance\Core;

class Route {

  private $_req, $_controller, $_method, $_uri;

  public function __construct($req, $controller, $method, $uri) {
    $this->_req = $req;
    $this->_controller = $controller;
    $this->_method = $method;
    $this->_uri = $uri;
  }

  public function call() {
    $file = 'Controllers/'. $this->_controller . ".php";
    if (!file_exists($file)) {
      throw new \Exception("No File Exists { $file }", 2);
    }
    require_once $file;
    $class = 'Attendance\Controllers\\' . $this->_controller;
    if (!class_exists($class)) {
      throw new \Exception("Class not found { $class }", 2);
    }
    $object = new $class;
    if (!method_exists($object, $this->_method)) {
      throw new \Exception("No Method declared { $method } in class { $class }", 1);
    }
    return call_user_func_array([$object, $this->_method], []);
  }

  public function  __is_equal($__value__) {
    return $other_route->_req == $this->_req &&
           $other_route->_method == $this->_method &&
           $other_route->_uri == $this->_uri;
  }

}