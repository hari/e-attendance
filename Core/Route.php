<?php namespace Attendance\Core;

class Route {

  private $_req, $_controller, $_method, $_uri, $_name;

  public function __construct($req, $uri, $method, $controller = '', $name = '') {
    $this->_req = $req;
    $this->_controller = $controller;
    $this->_method = $method;
    $this->_uri = $uri;
    $this->_name = $name;
  }

  public function call() {
    if ($this->_method instanceof \Closure) {
      return call_user_func_array($this->_method, func_get_args());
    }
    $file = DIR_CTRL . '/'. $this->_controller . ".php";
    if (!file_exists($file)) {
      throw new \Exception("No File Exists { $file }", 2);
    }
    $class = APP .  '\\' . DIR_CTRL . '\\' . $this->_controller;
    if (!class_exists($class)) {
      throw new \Exception("Class not found { $class }", 2);
    }
    $object = new $class;
    if (!method_exists($object, $this->_method)) {
      throw new \Exception("No Method declared { $this->_method } in class { $class }", 1);
    }
    return call_user_func_array([$object, $this->_method], func_get_args());
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
    $__value__->_controller == $this->_controller &&
    $__value__->_name == $this->_name;
  }

  public function getName() {
    return $this->_name;
  }

  public function getUri($full_path = false) {
    $prefix = "";
    if ($full_path) {
      $prefix = APP_URI . "/";
    }
    return $prefix.$this->_uri;
  }

  public static function post($uri, $method, $controller = '', $name = '') {
    return new Route('post', $uri, $method, $controller, $name);
  }

  public static function get($uri, $method, $controller = '', $name = '') {
    return new Route('get', $uri, $method, $controller, $name);
  }

}