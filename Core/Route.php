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
    $class = APP .  '\\' . DIR_CTRL . '\\' . $this->_controller;
    if (!class_exists($class)) {
      throw new \Exception("Class not found { $class }", 2);
    }
    $object = new $class;
    if (!method_exists($object, $this->_method)) {
      throw new \Exception("No Method declared { $this->_method } in class { $class }", 1);
    }
    return call_user_func_array([$object, $this->_method], []);
  }

  /**
   * Checks if the given route is callable by making sure the uri and request method are same
   */
  public function is_callable($other) {
    return $this->_uri == $other->_uri && 
           $this->_req == $other->_req;
  }

  public function  __is_equal($__value__) {
    return $__value__->_req == $this->_req &&
           $__value__->_method == $this->_method &&
           $__value__->_uri == $this->_uri &&
           $__value__->_controller == $this->_controller;
  }

}