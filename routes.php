<?php namespace Attendance;

use Attendance\Core\Route;

// collection of application routes as Route object
// all the routes will be defined here
return [
 //index page
 new Route('get', '', 'index', 'PageController'),
 new Route('post', 'user/login', 'login', 'PageController')
];