<?php namespace Attendance\Controllers;

use Attendance\Models\User;
use Attendance\Core\View;

class PageController {

  public function index() {
    if (!User::isLoggedIn()) 
      return View::make('index');
    $user = User::logged();
    $view = ($user->role == User::STUDENT) ? 'student.index' : 
            ($user->role == User::TEACHER) ? 'teacher.index' : 'admin.index';
    return View::make($view, compact('user'));
  }

  public function login() {
    return "Got request";
  }

}