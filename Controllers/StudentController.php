<?php namespace Attendance\Controllers;

use Attendance\Models\User;
use Attendance\Models\Subject;
use Attendance\Models\Attendance;
use Attendance\Utils\MessageBox;
use Attendance\Core\View;
use Attendance\Utils\Session;
use Attendance\Database\Connection;

class StudentController extends AdminController
{

    public function create($request)
    {
        if (!$this->isAuthorized()) {
            header('HTTP/1.1 403 Forbidden');
            return redirect(route('login.do'));
        }
        if ($request->get('regno') == "" || strtolower(substr($request->get('regno'), 0, 2)) != 'se') {
            MessageBox::set(['failed' => 'Invalid registration number.']);
            return redirect(route('page.student'));
        }
        if (User::create(['full_name' => $request->get('name'), 'reg_no' => $request->get('regno'), 'password' => md5($request->get('pass')), 'batch' => $request->get('batch'), 'semester' => $request->get('semester'), 'role' => User::STUDENT, 'created_by' => User::logged()->getAttribute('reg_no')])) {
            MessageBox::set(['done' => sprintf('Successfully added new student [%s].', $request->get('name'))]);
        } else {
            MessageBox::set(['failed' => sprintf('Adding new student failed [%s].', $request->get('name'))]);
        }
        return redirect(route('page.student'));
    }

    public function update($request)
    {
        if (!$this->isAuthorized()) {
            header('HTTP/1.1 403 Forbidden');
            return redirect(route('login.do'));
        }
        if ($request->get('regno') == "" || strtolower(substr($request->get('regno'), 0, 2)) != 'se') {
            MessageBox::set(['failed' => 'Invalid registration number.']);
            return redirect(route('page.student'));
        }
        $sql = "UPDATE users set full_name='%s',reg_no='%s',batch='%s',semester='%s' WHERE reg_no='%s'";
        if (User::update(sprintf($sql, $request->get('name'), $request->get('regno'), $request->get('batch'), $request->get('semester'), $request->get('id'))) == null) {
            MessageBox::set(['done' =>sprintf('Successfully updated student [%s].', $request->get('name'))]);
        } else {
            MessageBox::set(['failed' => sprintf('Updating student failed [%s].', $request->get('name'))]);
        }
        return redirect(route('page.student'));
    }

    public function delete($request)
    {
        if (!$this->isAuthorized()) {
            header('HTTP/1.1 403 Forbidden');
            return redirect(route('login.do'));
        }
        if ($request->get('id') != Session::get('user')) {
            if (User::delete(['reg_no' => '= ' . $request->get('id') ] )) {
                MessageBox::set(['done' => sprintf('Successfully deleted student [%s].', $request->get('id'))]);
            } else {
                MessageBox::set(['failed' => sprintf('Deleting student failed [%s].', $request->get('id'))]);
            }
        }
        return redirect(route('page.student'));
    }
}
