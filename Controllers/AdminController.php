<?php namespace Attendance\Controllers;

use Attendance\Models\User;
use Attendance\Models\Subject;
use Attendance\Core\View;
use Attendance\Database\AttendanceTable;
use Attendance\Database\UserTable;
use Attendance\Database\SubjectTable;
use Attendance\Utils\Session;

class AdminController extends BaseController {

  public function isAuthorized() {
    return User::isLoggedIn() && ((int)User::logged()->getAttribute('role')) == User::ADMIN;
  }

  public function manageTeacher($request) {
    if (!$this->isAuthorized()) return redirect(route('home'));
    $edit = [];
    if ($request->get('do') == "delete") {
      return (new TeacherController())->delete($request);
    }
    if ($request->get('do') == 'edit') {
      $edit = User::select(['*'], sprintf("WHERE reg_no = '%s'", $request->get('id')))[0];
    }
    $teachers = User::select(['*'], 'where role = ' . User::TEACHER);
    return View::make('admin.teacher', compact('teachers', 'edit'));
  }

  public function manageStudent($request) {
    if (!$this->isAuthorized()) return redirect(route('home'));
    $edit = [];
    if ($request->get('do') == "delete") {
      return (new StudentController())->delete($request);
    }
    if ($request->get('do') == 'edit') {
      $edits = User::select(['*'], "where reg_no = '" . $request->get('id') . "'");
      if (count($edits) > 0) {
        $edit = $edits[0];
      }
    }
    $sem = 1;
    if ($request->get('sem') != null) {
      $sem = (int)$request->get('sem');
    }
    $students = User::select(['*'], 'where role = ' . User::STUDENT . ' AND semester = ' . $sem);
    $teachers = User::select(['*'], 'where role = ' . User::TEACHER);
    return View::make('admin.student', compact('students', 'teachers', 'edit'));
  }

  public function manageSubject($request) {
    if (!$this->isAuthorized()) return redirect(route('home'));
    $edit = [];
    if($request->get('do') == "delete"){
      return (new SubjectController())->delete($request);
    }
    if ($request->get('do') == 'edit') {
      $edit = Subject::select(['*'], 'where id = ' . $request->get('id'))[0];
    }
    $sem = ($request->get('sem') != null) ? $request->get('sem') : '1';
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