<?php

use Attendance\Core\Route;

define('APP'     , 'Attendance');
define('APP_URI' , 'http://192.168.10.12/attendance');
define('DIR_MODL', 'Models');
define('DIR_VIEW', 'Views');
define('DIR_CTRL', 'Controllers');
define('DIR_ASST', 'assets');
define('DB_USER' , 'root');
define('DB_PASS' , '');
define('DB_HOST' , 'localhost');
define('DB_NAME' , 'e_attendance');

function asset($path) {
  return APP_URI . "/" . DIR_ASST . "/$path";
}

function get_current_uri() {
  return str_replace(['index.php', '/attendance/', '/Attendance/'], '' , explode('?', $_SERVER['REQUEST_URI'])[0]);
}

function get_current_route() {
  return new Route(strtolower($_SERVER['REQUEST_METHOD']), get_current_uri(), '', '');
}

function dd($s) {
  die(var_dump($s));
}

function redirect($page) {
  header("Location: $page");
  exit;
}

function route($name) {
  global $routes;
  $final = array_filter($routes, function($route) use ($name) {
    return $route->getName() == $name;
  });
  if (count($final) == 0) {
    throw new \Exception("No route with name {$name}", 1);
  }
  //check if its the index page
  return APP_URI . "/" . ($final[array_keys($final)[0]]->getUri() != "" ? $final[array_keys($final)[0]]->getUri() : 'index.php');
}