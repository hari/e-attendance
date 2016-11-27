<?php namespace Attendance\Controllers;

use Attendance\Models\User;
use Attendance\Models\MessageBox;
use Attendance\Core\View;
use Attendance\Database\AttendanceTable;
use Attendance\Database\UserTable;
use Attendance\Database\SubjectTable;

class AdminController {

  public function handleTeacher($r) {
    if (User::create(['full_name' => $r->get('name'), 'reg_no' => $r->get('user'), 'password' => md5($r->get('pass')), 'role' => User::TEACHER])) {
      MessageBox::setMessage(['done' => 'Add new teacher.']);
    }
    return redirect()->route('index');
  }

  public function handleStudent($r) {
    dd($r->all());
  }

  public function handleSubject($r) {
    dd($r->all());
  }

  public function manageTeacher() {
    $teachers = User::select(['*'], 'where role = ' . User::TEACHER);
    return View::make('admin.teacher', compact('teachers'));
  }
  public function manageStudent() {
    return View::make('admin.student');
  }
  public function manageSubject() {
    return View::make('admin.subject');
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