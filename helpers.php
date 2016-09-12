<?php

use Attendance\Core\Route;

define('APP'     , 'Attendance');
define('DIR_MODL', 'Models');
define('DIR_VIEW', 'Views');
define('DIR_CTRL', 'Controllers');
define('DIR_ASST', 'assets');
define('DB_USER' , 'root');
define('DB_PASS' , '');
define('DB_HOST' , 'localhost');
define('DB_NAME' , 'e_attendance');

function asset($path) {
  return DIR_ASST . "/$path";
}

function get_current_uri() {
  return str_replace(['index.php', '/attendance/'], '' , explode('?', $_SERVER['REQUEST_URI'])[0]);
}

function get_current_route() {
  return new Route(strtolower($_SERVER['REQUEST_METHOD']), get_current_uri(), '', '');
}

function dd($s) {
  die(var_dump($s));
}