<?php

use Attendance\Core\Route;

define('APP'     , 'Attendance');
define('DIR_MODL', 'MODELS');
define('DIR_VIEW', 'Views');
define('DIR_CTRL', 'Controllers');
define('DB_USER' , 'root');
define('DB_PASS' , '');
define('DB_HOST' , 'locahost');
define('DB_NAME' , 'e_attendance');

function asset($path) {
  return "assets/$path";
}

function get_current_uri() {
  return str_replace('/attendance/', '' , explode('?', $_SERVER['REQUEST_URI'])[0]);
}

function get_current_route() {
  return new Route(strtolower($_SERVER['REQUEST_METHOD']), '', '', get_current_uri());
}