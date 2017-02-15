<?php namespace Attendance;

use Attendance\Core\Route;

// collection of application routes as Route object
// all the routes will be defined here
return [
Route::get('init', 'init', 'AdminController', 'db.init'),
 //index page
Route::get('', 'index', 'PageController', 'home'),
Route::get('user/login', function() {
  //redirect login page to home page
  return redirect(route('home'));
}),
Route::get('logout', function() {
  session_destroy();
  return redirect(route('home'));
}, null, 'logout'),
Route::post('marks', 'create', 'MarkController', 'do.mark'),
Route::post('marks-model', 'create', 'MarkModelController', 'create.model'),
Route::post('user/login', 'login', 'PageController', 'login.do'),
Route::post('manage/teacher', 'create', 'TeacherController', 'do.teacher'),
Route::post('manage/student', 'create', 'StudentController', 'do.student'),
Route::post('manage/subject', 'create', 'SubjectController', 'do.subject'),
Route::post('update/teacher', 'update', 'TeacherController', 'update.teacher'),
Route::post('update/student', 'update', 'StudentController', 'update.student'),
Route::post('update/subject', 'update', 'SubjectController', 'update.subject'),
Route::post('attendance', 'take', 'AttendanceController', 'attendance.take'),
Route::get('marks', 'index', 'MarkController', 'page.mark'),
Route::get('marks-model', 'index', 'MarkModelController', 'page.markmodel'),
Route::get('student', 'student', 'PageController', 'student.index'),
Route::get('manage/teacher', 'manageTeacher', 'AdminController', 'page.teacher'),
Route::get('manage/student', 'manageStudent', 'AdminController', 'page.student'),
Route::get('manage/subject', 'manageSubject', 'AdminController', 'page.subject')
];