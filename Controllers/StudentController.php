<?php namespace Attendance\Controllers;

use Attendance\Models\User;
use Attendance\Models\Subject;
use Attendance\Models\Attendance;
use Attendance\Utils\MessageBox;
use Attendance\Core\View;
use Attendance\Utils\Session;
use Attendance\Database\Connection;

class StudentController extends BaseController {

  public function index($r) {
    if (!User::isLoggedIn()) 
      return View::make('index');
    $student = User::select(['*'],"where reg_no ='".Session::get('user')."'");
    $subjects = Subject::select(['id','name','code'],"where sem=".$student[0]['semester']);
    $absent = 0;
    if (count($subjects) > 0) {
      $subject = $subjects[0]['code'];
      if ($r->get('sub') != null) {
        $subject = $r->get('sub');
      }
      $where = "where subject = '".$subject."' and reg_no = '".Session::get('user')."'";
      $absent = count(Attendance::select(['*'], $where));
    }
    return View::make('student.index', compact('subjects','absent'));
  }

}