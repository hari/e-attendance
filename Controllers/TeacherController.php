<?php namespace Attendance\Controllers;

use Attendance\Models\User;
use Attendance\Models\Subject;
use Attendance\Models\Attendance;
use Attendance\Utils\MessageBox;
use Attendance\Core\View;
use Attendance\Utils\Session;
use Attendance\Database\Connection;

class TeacherController extends AdminController {

  public function create($request) {
    if (!$this->isAuthorized()) {
      header('HTTP/1.1 403 Forbidden');
      return redirect(route('login.do'));
    }
    if (User::create(['full_name' => $request->get('name'),
      'reg_no' => $request->get('user'),
      'password' => md5($request->get('pass')),
      'created_by' => User::logged()->getAttribute('reg_no'),
      'role' => User::TEACHER])) {
      MessageBox::set(['done'=>sprintf('"%s" has been added as new teacher.', $request->get('name'))]);
    } else {
      MessageBox::set(['failed' => 'Adding new teacher failed.']);
    }
    return redirect(route('page.teacher'));
  }

  public function update($request) {
    if (!$this->isAuthorized()) {
      header('HTTP/1.1 403 Forbidden');
      return redirect(route('login.do'));
    }
    $sql = "Update users set full_name='%s', reg_no='%s' WHERE reg_no='%s'";
    if (User::update(sprintf($sql, $request->get('name'), $request->get('user'), $request->get('id'))) == null) {
      MessageBox::set(['done' => 'Successfully updated teacher.']);
    } else {
      MessageBox::set(['failed' => 'Updating teacher failed.']);
    }
    return redirect(route('page.teacher'));
  }

  public function delete($request) {
    if (!$this->isAuthorized()) {
      header('HTTP/1.1 403 Forbidden');
      return redirect(route('login.do'));
    }
    if($request->get('id') != Session::get('user')){
      if (User::delete(['reg_no' => '= ' . $request->get('id') ] )) {
        MessageBox::set(['done' => sprintf('Successfully deleted teacher [%s].',$request->get('id'))]);
      } else {
        MessageBox::set(['failed' => sprintf('Deleting teacher failed [%s].', $request->get('id'))]);
      }
    }
    return redirect(route('page.teacher'));
  }

}