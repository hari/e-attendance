<?php namespace Attendance;

use Attendance\Core\Route;

// collection of application routes as Route object
// all the routes will be defined here
return [
 //index page
 new Route('get', 'PageController', 'index', ''),
 new Route('post', 'PageController', 'login', 'user/login')
];