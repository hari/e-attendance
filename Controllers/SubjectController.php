<?php namespace Attendance\Controllers;

use Attendance\Models\User;
use Attendance\Models\Subject;
use Attendance\Models\Attendance;
use Attendance\Utils\MessageBox;
use Attendance\Core\View;
use Attendance\Utils\Session;
use Attendance\Database\Connection;

class SubjectController extends AdminController
{

    public function create($request)
    {
        if (!$this->isAuthorized()) {
            header('HTTP/1.1 403 Forbidden');
            return redirect(route('login.do'));
        }
        if (Subject::create(['name' => $request->get('name'), 'code' => $request->get('code'), 'teacher' => $request->get('teacher'), 'sem' => $request->get('sem')])) {
            MessageBox::set(['done'=>sprintf('Successfully added new subject [%s].', $request->get('name'))]);
        } else {
            MessageBox::set(['done' => sprintf('Adding new subject failed [%s].', $request->get('name'))]);
        }
        return redirect(route('page.subject'));
    }

    public function update($request)
    {
        if (!$this->isAuthorized()) {
            header('HTTP/1.1 403 Forbidden');
            return redirect(route('login.do'));
        }
        $sql = "UPDATE subjects set name='%s',code='%s',sem=%d,teacher='%s' WHERE id=%d";
        if (Subject::update(sprintf($sql, $request->get('name'), $request->get('code'), $request->get('sem'), $request->get('teacher'), $request->get('id'))) == null) {
            MessageBox::set(['done' =>sprintf('Successfully updated subject [%s].', $request->get('name'))]);
        } else {
            MessageBox::set(['failed' => sprintf('Updating subject failed [%s].', $request->get('name'))]);
        }
        return redirect(route('page.subject'));
    }

    public function delete($request)
    {
        if (!$this->isAuthorized()) {
            header('HTTP/1.1 403 Forbidden');
            return redirect(route('login.do'));
        }
        if ($request->get('do') == "delete") {
            if (Subject::delete(['id' => '= ' . $request->get('id')])) {
                MessageBox::set(['done'=>sprintf('Successfully deleted subject [%s].', $request->get('id'))]);
            } else {
                MessageBox::set(['failed' => sprintf('Deleting subject failed [%s].', $request->get('id'))]);
            }
        }
        return redirect(route('page.subject'));
    }
  /**
   * Returns the subject. Filters the subject if there is request.
   */
    public static function getSubject($request, $subjects)
    {
        $subject = $subjects[0];
        if ($request->get('sub') != null) {
            $subject = array_filter($subjects, function ($item)
 use ($request) {
                return strtolower($item['code']) == strtolower($request->get('sub'));
            });
            $subject = $subject[array_keys($subject)[0]];
        }
        return $subject;
    }
}
