<?php namespace Attendance\Controllers;

use Attendance\Models\User;
use Attendance\Models\Subject;
use Attendance\Models\Attendance;
use Attendance\Utils\MessageBox;
use Attendance\Core\View;
use Attendance\Utils\Session;
use Attendance\Database\Connection;

class PageController {

  public function index($request) {
    if (!User::isLoggedIn()) 
      return View::make('index');

    $user = User::logged();
    $role = (int)$user->getAttribute('role') ;

    if ($role == User::TEACHER) {
      return (new TeacherController())->index($request);
    }
    if ($role == User::STUDENT) {
      return (new StudentController())->index($request);
    }

    $subjects = Subject::select(['code', 'sem'], "WHERE id > 0");
    $sem = 4;

    if ($request->get('sem') != null) {
      $sem = $request->get('sem');
    }
    return View::make('admin.index', compact('user', 'subjects', 'sem'));
  }

  public function login($in) {
    User::login($in->get('username'), $in->get('password'));
    return redirect(route('home'));
  }

}