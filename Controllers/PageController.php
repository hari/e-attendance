<?php namespace Attendance\Controllers;

use Attendance\Models\User;
use Attendance\Core\View;

class PageController {

  public function index() {
    if (!User::isLoggedIn()) 
      return View::make('admin.index');
    $user = User::logged();
    $view = ($user->getAttribute('role') == User::STUDENT) ? 'student.index' : 
    ($user->getAttribute('role') == User::TEACHER) ? 'teacher.index' : 'admin.index';
    return View::make($view, compact('user'));
  }

  public function login($in) {
    User::login($in->get('username'), $in->get('password'));
    return redirect(route('home'));
  }

  public function take() {
    if (!User::isLoggedIn()) {
      header('HTTP/1.1 403 Forbidden');
      return redirect(route('login'));
    }
    $user = User::logged();
    if ($user->role != User::TEACHER)
      header('HTTP/1.1 403 Forbidden');
    return redirect(route('home'));
    //TODO: validate and create attendance
    return Attendance::create([]);
  }

}