<?php namespace Attendance;

use Attendance\Core\Route;

// collection of application routes as Route object
// all the routes will be defined here
return [
 //index page
 Route::get('', 'index', 'PageController', 'home'),
 Route::get('user/login', function() {
  //redirect login page to home page
  return redirect(route('home'));
 }),
 Route::post('user/login', 'login', 'PageController', 'login.do'),
 Route::get('take', 'take', 'PageController', 'take')
];