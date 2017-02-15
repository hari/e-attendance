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
      return $this->teacherIndex($request);
    }
    if ($role == User::STUDENT) {
      return $this->studentIndex($request);
    }

    $subjects = Subject::select(['code', 'sem'], "WHERE id > 0");
    $sem = 4;

    if ($request->get('sem') != null) {
      $sem = (int)$request->get('sem');
    }
    return View::make('admin.index', compact('user', 'subjects', 'sem'));
  }

  private function studentIndex($request) {
    if (!User::isLoggedIn()) 
      return View::make('index');
    $student = User::select(['*'], sprintf("WHERE reg_no = '%s'", Session::get('user')));
    $subjects = Subject::select(['*'], sprintf("WHERE sem = %d", $student[0]['semester']));
    $absent = 0;
    $real_classes = 0;
    if (count($subjects) > 0) {
      $subject = $subjects[0]['code'];
      if ($request->get('sub') != null) {
        $subject = $r->get('sub');
      }
      $where = sprintf("WHERE subject = '%s' AND reg_no = '%s'", $subject, Session::get('user'));
      $absent = count(Attendance::select(['*'], $where));
      $real_classes = count(Attendance::select(['id'], sprintf("WHERE subject = '%s'", $subject)));
    }
    return View::make('student.index', compact('subjects','absent', 'real_classes'));
  }

  private function teacherIndex($request) {
    if (!User::isLoggedIn()) 
      return View::make('index');
    $user = User::logged();

    $where = sprintf("WHERE teacher = '%s'", $user->getAttribute('reg_no'));
    $subjects = Subject::select(['*'], $where);
    if (count($subjects) == 0) {
      return View::make('teacher.index', compact('user', 'subjects', 'students'));
    }

    $subject = $this->getSubject($request, $subjects);
    if (count($subject) == 0) {
      return View::make('teacher.index', compact('user', 'subjects', 'students'));
    }

    $where = sprintf("WHERE subject = '%s' AND taken_on = '%s' AND taken_by = '%s'", $subject['code'], date('Y-m-d'), Session::get('user'));
    $done = Attendance::select(['*'], $where);

    if (count($done) == 0) {
      $where = sprintf('where role = %d AND semester = %s', User::STUDENT, $subject['sem']);
      $students = User::select(['*'], $where);
    }

    return View::make('teacher.index', compact('user', 'subjects', 'students'));
  }

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

  public function login($in) {
    User::login($in->get('username'), $in->get('password'));
    return redirect(route('home'));
  }

}