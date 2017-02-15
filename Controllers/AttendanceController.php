<?php namespace Attendance\Controllers;

use Attendance\Models\User;
use Attendance\Models\Subject;
use Attendance\Models\Attendance;
use Attendance\Utils\MessageBox;
use Attendance\Core\View;
use Attendance\Utils\Session;
use Attendance\Database\Connection;

class AttendanceController extends BaseController {


  public function take($request) {
    if (!$this->isAuthorized()) {
      header('HTTP/1.1 403 Forbidden');
      return redirect(route('login.do'));
    }
    
    $user = User::logged();
    $list = json_decode($request->get('list', false));
    $id = $user->getAttribute('reg_no');
    $subject = $request->get('subject');
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

  public function isAuthorized() {
    return User::isLoggedIn() && ((int)User::logged()->getAttribute('role')) == User::TEACHER;
  }

}