<?php namespace Attendance\Controllers;

use Attendance\Models\User;
use Attendance\Models\Subject;
use Attendance\Models\Attendance;
use Attendance\Utils\MessageBox;
use Attendance\Core\View;
use Attendance\Utils\Session;
use Attendance\Database\Connection;

class TeacherController extends BaseController {

  /**
   * Returns the subject. Filters the subject if there is request.
   */
  private function getSubject($request, $subjects) {
    $subject = $subjects[0];
    if ($request->get('sub') != null) {
      $subject = array_filter($subjects, function($item)
        use ($request) {
          return strtolower($item['code']) == strtolower($request->get('sub'));
        });
      $subject = $subject[array_keys($subject)[0]];
    }
    return $subject;
  }

  public function index($request) {
    if (!User::isLoggedIn()) 
      return View::make('index');
    $user = User::logged();
    $subjects = Subject::select(['id', 'name', 'code', 'sem'], "where teacher = '" . User::logged()->getAttribute('reg_no') . "'");
    if (count($subjects) > 0) {
      $subject = $this->getSubject($request, $subjects);
      if (count($subject) > 0) {
        $done = Attendance::select(['*'], "where subject = '".$subject['code']. "' AND 
          taken_on = '" . date('Y-m-d') . "' AND taken_by = '" . Session::get('user') . "'");
        if (count($done) == 0)
          $students = User::select(['*'], 'where role = '.User::STUDENT.' AND semester = '.$subject['sem']);
      }
    }
    return View::make('teacher.index', compact('user', 'subjects', 'students'));
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

  public function mark($request) {
    if (!$this->isAuthorized()) return redirect(route('page.index'));
    $subjects = Subject::select(['id', 'name', 'code', 'sem'], "where teacher = '" . User::logged()->getAttribute('reg_no') . "'");
    return View::make('teacher.mark', compact('subjects'));
  }

  public function isAuthorized() {
    return User::isLoggedIn() && ((int)User::logged()->getAttribute('role')) == User::TEACHER;
  }

}