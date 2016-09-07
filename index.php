<?php namespace Attendance;

session_start();

use Attendance\Core\Route;

require_once 'autoload.php';
require_once 'helpers.php';
$routes = require_once 'routes.php';

$uri = get_current_uri();
$current_route = get_current_route();
$called = false;

foreach ($routes as $route) {
  if ($current_route->is_callable($route)) {
    $called = true;
    echo $route->call();
    break;
  }
}

if (!$called) {
  throw new \Exception("Error Processing Request", 1); 
}