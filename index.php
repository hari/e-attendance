<?php namespace Attendance;
// start the session
session_start();

use Attendance\Core\Route;
use Attendance\Core\Request;
require_once 'autoload.php';
require_once 'helpers.php';
$routes = require_once 'routes.php';

$uri = get_current_uri();
$current_route = get_current_route();
$called = false;

foreach ($routes as $route) {
  if ($current_route->is_callable($route)) {
    //this is the route we need
    //call the route's method
    echo $route->call(Request::getInstance());
    $called = true;
    break;
  }
}

if (!$called) {
  throw new \Exception("Error Processing Request", 1); 
}