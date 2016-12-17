<?php namespace Attendance\Controllers;

use Attendance\Models\User;
use Attendance\Models\Subject;
use Attendance\Models\MessageBox;
use Attendance\Core\View;
use Attendance\Database\AttendanceTable;
use Attendance\Database\UserTable;
use Attendance\Database\SubjectTable;
use Attendance\Utils\Session;

class AdminController {

  public function isAuthorized() {
    return User::isLoggedIn() && ((int)User::logged()->getAttribute('role')) == User::ADMIN;
  }

  public function handleTeacher($r) {
    if (!$this->isAuthorized()) return redirect(route('index'));
    if (User::create(['full_name' => $r->get('name'), 'reg_no' => $r->get('user'), 'password' => md5($r->get('pass')), 'role' => User::TEACHER])) {
      MessageBox::setMessage(['done' => 'Add new teacher.']);
    }
    return redirect(route('page.teacher'));
  }

  public function handleStudent($r) {
    if (!$this->isAuthorized()) return redirect(route('index'));
    if ($r->get('regno') != "" && strtolower(substr($r->get('regno'),0,2)) == 'se') {
      if (User::create(['full_name' => $r->get('name'), 
        'reg_no' => $r->get('regno'), 
        'password' => md5($r->get('pass')), 
        'batch' => $r->get('batch'), 
        'role' => User::STUDENT])) {
        MessageBox::setMessage(['done' => 'Successfully added new student.']);
    } else {
      MessageBox::setMessage(['failed' => 'Adding new student failed.']);
    }
  } else {
    MessageBox::setMessage(['failed' => 'Invalid registration number.']);
  }
  return redirect(route('page.student'));
}

public function handleSubject($r) {
  if (!$this->isAuthorized()) return redirect(route('home'));
  if (Subject::create(['name' => $r->get('name'), 'code' => $r->get('code'), 
    'teacher' => $r->get('teacher'), 'sem' => $r->get('sem')])) {
    MessageBox::setMessage(['done' => 'Add new subject.']);
}
return redirect(route('page.subject'));
}

public function manageTeacher($r) {
  if (!$this->isAuthorized()) return redirect(route('home'));
  if ($r->get('do') != null && $r->get('do') == "delete") {
    if($r->get('id') != Session::get('user')){
      User::delete(['reg_no' => '= ' . $r->get('id') ] );
    }
  }
  $teachers = User::select(['*'], 'where role = ' . User::TEACHER);
  return View::make('admin.teacher', compact('teachers'));
}

public function manageStudent($r) {
  if (!$this->isAuthorized()) return redirect(route('home'));
  if ($r->get('do') != null && $r->get('do') == "delete") {
    if($r->get('id') != Session::get('user')){
      User::delete(['reg_no' => '= ' . $r->get('id') ] );
    }
  }
  $sem = 1;
  if ($r->get('sem') != null) {
    $sem = (int)$r->get('sem');
  }
  $year = date('Y');
  $batch =($year - (int)($sem / 2));
  $students = User::select(['*'], 'where role = ' . User::STUDENT . ' AND batch = ' . $batch);
  $teachers = User::select(['*'], 'where role = ' . User::TEACHER);
  return View::make('admin.student', compact('students', 'teachers'));
}
public function manageSubject($r) {
  if (!$this->isAuthorized()) return redirect(route('home'));
  if($r->get('do') == "delete"){
    Subject::delete(['id' => '= ' . $r->get('id') ] );
  }
  $sem = ($r->get('sem') != null) ? $r->get('sem') : '1';
  $subjects = Subject::select(['*'], 'where sem = ' . $sem);
  $teachers = User::select(['*'], 'where role = ' . User::TEACHER);
  return View::make('admin.subject', compact('subjects', 'teachers'));
}

public function init() {
  $tables = [AttendanceTable::getInstance(), UserTable::getInstance(), SubjectTable::getInstance()];
  foreach ($tables as $table) {
    if ($table->create()) {
      echo "Created '" . $table->getTableName() . "' table.<br />";
    }
  }
}

}