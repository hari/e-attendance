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
Route::post('user/login', 'login', 'PageController', 'login.do'),
Route::post('manage/teacher', 'handleTeacher', 'AdminController', 'do.teacher'),
Route::post('manage/student', 'handleStudent', 'AdminController', 'do.student'),
Route::post('manage/subject', 'handleSubject', 'AdminController', 'do.subject'),
Route::post('take', 'take', 'TeacherController', 'take'),
Route::get('marks', 'mark', 'TeacherController', 'page.mark'),
Route::get('student', 'student', 'PageController', 'student.index'),
Route::get('manage/teacher', 'manageTeacher', 'AdminController', 'page.teacher'),
Route::get('manage/student', 'manageStudent', 'AdminController', 'page.student'),
Route::get('manage/subject', 'manageSubject', 'AdminController', 'page.subject')
];