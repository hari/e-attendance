<?php namespace Attendance;
use Attendance\Core\Route;

// collection of application routes as Route object
// all the routes will be defined here
return [
 new Route('get', 'ApiController', 'home', ''),
 new Route('get', 'ApiController', 'test', 'web'),
 new Route('get', 'ApiController', 'do', 'web/api')
];