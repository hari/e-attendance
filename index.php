<?php
require_once 'autoload.php';

define('DIR_MODL', 'MODELS');
define('DIR_VIEW', 'Views');
define('DIR_CTRL', 'Controllers');
define('DB_USER' , 'root');
define('DB_PASS' , '');
define('DB_HOST' , 'locahost');
define('DB_NAME' , 'e_attendance');

use Attendance\Core\Route;

$routes = require_once 'routes.php';

$uri = get_current_uri();
$current_route = get_current_route();

$called = false;
foreach ($routes as $route) {
  if ($current_route->is_callable($route)) {
    $call = true;
    echo $route->call();
    break;
  }
}

if (!$called) {

}

function get_current_uri() {
  return str_replace('/attendance/', '' , $_SERVER['REQUEST_URI']);
}

function get_current_route() {
  return new Route(strtolower($_SERVER['REQUEST_METHOD']), '', '', get_current_uri());
}