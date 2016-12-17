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
    if ($role == User::STUDENT) {
      return $this->student();
    }
    $view = 'admin.index';
    $subjects = [];
    if ($role == User::STUDENT) $view = 'student.index';
    $students = [];
    if ($role == User::TEACHER) {
      $subjects = Subject::select(['id', 'name', 'code', 'sem'], "where teacher = '" . User::logged()->getAttribute('reg_no') . "'");
      if (count($subjects) > 0) {
        $subject = $subjects[0];
        if ($request->get('sub') != null) {
          $subject = array_filter($subjects, function($item)
            use ($request) {
              return strtolower($item['code']) == strtolower($request->get('sub'));
            });
          $subject = $subject[array_keys($subject)[0]];
        }
        if (count($subject) > 0) {
          $year = date('Y');
          $batch = ($year - (int)($subject['sem'] / 2));
          $done = Attendance::select(['*'], "where subject = '".$subject['code']. "' AND 
            taken_on = '" . date('Y-m-d') . "' AND taken_by = '" . Session::get('user') . "'");
          if (count($done)  == 0)
            $students = User::select(['*'], 'where role = '.User::STUDENT.' AND batch = '.$batch);
        }
      }
      $view = 'teacher.index';
    }
    return View::make($view, compact('user', 'subjects', 'students'));
  }

  public function login($in) {
    User::login($in->get('username'), $in->get('password'));
    return redirect(route('home'));
  }

  public function take($r) {
    if (!User::isLoggedIn()) {
      header('HTTP/1.1 403 Forbidden');
      return redirect(route('login'));
    }
    $user = User::logged();
    if ($user->getAttribute('role') != User::TEACHER) {
      header('HTTP/1.1 403 Forbidden');
      return redirect(route('home'));
    }
    $list = json_decode($r->get('list', false));
    $id = $user->getAttribute('reg_no');
    $subject = $r->get('subject');
    $d = date('Y-m-d');
    $count = 0;
    foreach ($list as $student) {
      Attendance::create(['taken_by' => $id,
        'taken_on' => $d,
        'subject' => $subject,
        'reg_no' => $student->reg]);
      $count++;
    }
    if ($count > 0) {
      MessageBox::set(['type' => 'done', 'message' => 'Attendance taken of subject ' . $subject]);
    }
    return redirect(route('home'));
  }

  public function attendance() {
    return View::make('teacher.index');
  }

  public function student() {
    $student = User::select(['*'],"where reg_no ='".Session::get('user')."'");
    $year = date('Y');
    $sem = 2*($year - (int) $student[0]['batch']);
    $subjects = Subject::select(['id','name','code'],"where sem=".$sem);
    $attendance = Attendance::select(['*'], "where subject = '".$subjects[0]['code']."'");
    $absent = count($attendance);
    return View::make('student.index', compact('subjects','absent'));
  }

}