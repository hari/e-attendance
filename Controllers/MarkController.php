<?php namespace Attendance\Controllers;

use Attendance\Models\User;
use Attendance\Models\Subject;
use Attendance\Models\Attendance;
use Attendance\Models\MarksModel;
use Attendance\Utils\MessageBox;
use Attendance\Core\View;
use Attendance\Utils\Session;
use Attendance\Database\Connection;

class MarkController extends BaseController {

  public function index($request) {
    if (!$this->isAuthorized()) {
      header('HTTP/1.1 403 Forbidden');
      return redirect(route('login.do'));
    }
    $user = User::logged();
    $where = sprintf("WHERE teacher = '%s'", $user->getAttribute('reg_no'));
    $subjects = Subject::select(['*'], $where);
    $sub = $subjects[0];
    if ($request->get('sub') != null) {
      $sub =  SubjectController::getSubject($request, $subjects);
    }
    $where = sprintf("WHERE semester = %d", $sub['sem']);
    $students = User::select(['reg_no', 'full_name'], $where);
    $where = sprintf("WHERE subject = '%s'", $sub['code']);
    $fields = MarksModel::select(['*'], $where);
    return View::make('teacher.mark', compact('subjects', 'students', 'fields'));
  }

  public function create($request) {
    if (!$this->isAuthorized()) {
      header('HTTP/1.1 403 Forbidden');
      return redirect(route('login.do'));
    }
    if (Subject::create(['name' => $request->get('name'), 'code' => $request->get('code'), 'teacher' => $request->get('teacher'), 'sem' => $request->get('sem')])) {
      MessageBox::set(['done'=>sprintf('Successfully added new subject [%s].',$request->get('name'))]);
    } else {
      MessageBox::set(['done' => sprintf('Adding new subject failed [%s].', $request->get('name'))]);
    }
    return redirect(route('page.subject'));
  }

  public function update($request) {
    if (!$this->isAuthorized()) {
      header('HTTP/1.1 403 Forbidden');
      return redirect(route('login.do'));
    }
    $sql = "UPDATE subjects set name='%s',code='%s',sem=%d,teacher='%s' WHERE id=%d";
    if (Subject::update(sprintf($sql, $request->get('name'), $request->get('code'), $request->get('sem'),$request->get('teacher'), $request->get('id'))) == null) {
      MessageBox::set(['done' =>sprintf('Successfully updated subject [%s].', $request->get('name'))]);
    } else {
      MessageBox::set(['failed' => sprintf('Updating subject failed [%s].', $request->get('name'))]);
    }
    return redirect(route('page.subject'));
  }

  public function delete($request) {
    if (!$this->isAuthorized()) {
      header('HTTP/1.1 403 Forbidden');
      return redirect(route('login.do'));
    }
    if($request->get('do') == "delete"){
      if (Subject::delete(['id' => '= ' . $request->get('id')])) {
        MessageBox::set(['done'=>sprintf('Successfully deleted subject [%s].',$request->get('id'))]);
      } else {
        MessageBox::set(['failed' => sprintf('Deleting subject failed [%s].', $request->get('id'))]);
      }
    }
    return redirect(route('page.subject'));
  }

  public function isAuthorized() {
    return User::isLoggedIn() && ((int)User::logged()->getAttribute('role')) == User::TEACHER;
  }
}