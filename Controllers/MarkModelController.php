<?php namespace Attendance\Controllers;

use Attendance\Models\User;
use Attendance\Models\MarksModel;
use Attendance\Models\Subject;
use Attendance\Utils\MessageBox;
use Attendance\Core\View;
use Attendance\Utils\Session;
use Attendance\Database\Connection;

class MarkModelController extends BaseController
{

    public function index($request)
    {
        if (!$this->isAuthorized()) {
            header('HTTP/1.1 403 Forbidden');
            return redirect(route('login.do'));
        }
        $user = User::logged();
        $where = sprintf("WHERE teacher = '%s'", $user->getAttribute('reg_no'));
        $subjects = Subject::select(['*'], $where);
        $fields = [];
        if (count($subjects) > 0) {
            $sub = $subjects[0]['code'];
        }
        if ($request->get('sub') != null) {
            $sub = $request->get('sub');
        }
        $fields = MarksModel::select(['*'], "WHERE subject = '".$sub."'");
        return View::make('teacher.markmodel', compact('subjects', 'fields'));
    }

    public function create($request)
    {
        if (!$this->isAuthorized()) {
            header('HTTP/1.1 403 Forbidden');
            return redirect(route('login.do'));
        }
        $user = User::logged();
        $total = MarksModel::getTotalOf($request->get('subject'));
        $mark = (int)$request->get('weight');
        //total internal mark = 50;
        if ($total >= 50) {
            MessageBox::set(['failed' => 'Allocated marks exceeded.']);
            return redirect(route('page.markmodel'));
        }
        if (MarksModel::exists($request->get('field_name'), $request->get('subject'))) {
            MessageBox::set(['failed' => 'Given field has been used already.']);
            return redirect(route('page.markmodel'));
        }
        if (50 - $mark < 0) {
            $mark = $mark - 50;
        }
        if (MarksModel::create(['weight' => $mark, 'subject' => $request->get('subject'), 'created_by' => $user->getAttribute('reg_no'), 'name' => $request->get('field_name')])) {
            MessageBox::set(['done' => 'New field added for marks.']);
        } else {
            MessageBox::set(['failed' => 'Failed to add new field.']);
        }
        return redirect(route('page.markmodel'));
    }

    public function isAuthorized()
    {
        return User::isLoggedIn() && ((int)User::logged()->getAttribute('role')) == User::TEACHER;
    }
}
