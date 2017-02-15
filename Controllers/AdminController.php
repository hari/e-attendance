<?php namespace Attendance\Controllers;

use Attendance\Models\User;
use Attendance\Models\Subject;
use Attendance\Models\MessageBox;
use Attendance\Core\View;
use Attendance\Database\AttendanceTable;
use Attendance\Database\UserTable;
use Attendance\Database\SubjectTable;
use Attendance\Utils\Session;

class AdminController extends BaseController {

  public function isAuthorized() {
    return User::isLoggedIn() && ((int)User::logged()->getAttribute('role')) == User::ADMIN;
  }

  public function handleTeacher($r) {
    if (!$this->isAuthorized()) return redirect(route('index'));
    if ($r->get('update') == 1) {
      $sql = "Update users set full_name='%s', reg_no='%s' WHERE reg_no='%s'";
      if (User::update(sprintf($sql, $r->get('name'), $r->get('user'), $r->get('id'))) == null) {
        MessageBox::setMessage(['done' => 'Successfully updated teacher.']);
      } else {
        MessageBox::setMessage(['failed' => 'Updating teacher failed.']);
      }
    } else {
      if (User::create(['full_name' => $r->get('name'), 'reg_no' => $r->get('user'), 'password' => md5($r->get('pass')), 'role' => User::TEACHER])) {
        MessageBox::setMessage(['done' => 'Add new teacher.']);
      }
    }
    return redirect(route('page.teacher'));
  }

  public function handleStudent($r) {
    if (!$this->isAuthorized()) return redirect(route('index'));
    if ($r->get('regno') == "" || strtolower(substr($r->get('regno'),0,2)) != 'se') {
      MessageBox::setMessage(['failed' => 'Invalid registration number.']);
      return redirect(route('page.student'));
    }
    if ((int)$r->get('update') == 1) {
      $sql = "Update users set full_name='%s', reg_no='%s', batch = '%s', semester = '%s' WHERE reg_no='%s'";
      if (User::update(sprintf($sql, $r->get('name'), $r->get('regno'), $r->get('batch'),$r->get('semester'), $r->get('id'))) == null) {
        MessageBox::setMessage(['done' => 'Successfully updated student.']);
      } else {
        MessageBox::setMessage(['failed' => 'Updating student failed.']);
      }
      return redirect(route('page.student'));
    }
    if (User::create(['full_name' => $r->get('name'), 
      'reg_no' => $r->get('regno'), 
      'password' => md5($r->get('pass')), 
      'batch' => $r->get('batch'), 
      'semester' => $r->get('semester'), 
      'role' => User::STUDENT])) {
      MessageBox::setMessage(['done' => 'Successfully added new student.']);
  } else {
    MessageBox::setMessage(['failed' => 'Adding new student failed.']);
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
  $edit = [];
  if ($r->get('do') != null && $r->get('do') == "delete") {
    if($r->get('id') != Session::get('user')){
      User::delete(['reg_no' => '= ' . $r->get('id') ] );
    }
  } elseif ($r->get('do') == 'edit') {
    $edit = User::select(['*'], "where reg_no = '" . $r->get('id') . "'")[0];
  }
  $teachers = User::select(['*'], 'where role = ' . User::TEACHER);
  return View::make('admin.teacher', compact('teachers', 'edit'));
}

public function manageStudent($r) {
  if (!$this->isAuthorized()) return redirect(route('home'));
  $edit = [];
  if ($r->get('do') == "delete") {
    if($r->get('id') != Session::get('user')){
      User::delete(['reg_no' => '= ' . $r->get('id') ] );
    }
  } elseif ($r->get('do') == 'edit') {
    $edit = User::select(['*'], "where reg_no = '" . $r->get('id') . "'")[0];
  }
  $sem = 1;
  if ($r->get('sem') != null) {
    $sem = (int)$r->get('sem');
  }
  $students = User::select(['*'], 'where role = ' . User::STUDENT . ' AND semester = ' . $sem);
  $teachers = User::select(['*'], 'where role = ' . User::TEACHER);
  return View::make('admin.student', compact('students', 'teachers', 'edit'));
}
public function manageSubject($r) {
  if (!$this->isAuthorized()) return redirect(route('home'));
  $edit = [];
  if($r->get('do') == "delete"){
    Subject::delete(['id' => '= ' . $r->get('id') ] );
  } elseif ($r->get('do') == 'edit') {
    $edit = Subject::select(['*'], 'where id = ' . $r->get('id'))[0];
  }
  $sem = ($r->get('sem') != null) ? $r->get('sem') : '1';
  $subjects = Subject::select(['*'], 'where sem = ' . $sem);
  $teachers = User::select(['*'], 'where role = ' . User::TEACHER);
  return View::make('admin.subject', compact('subjects', 'teachers', 'edit'));
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