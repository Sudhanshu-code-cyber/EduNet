<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ExamController;



Route::controller(StudentController::class)->group(function () {

    Route::get('/student', 'dashboard')->name('/student');
    Route::get('/student/myclass', 'showTimetable')->name('student.myclass');
    Route::get('/student/attendance', 'attendance')->name('student.attendance');
    Route::get('/student/assignment', 'assignment')->name('student.assignment');
    Route::get('/student/myresult', 'myresult')->name('student.myresult');
    Route::get('/student/marksheet', 'marksheet')->name('student.marksheet');
    Route::get('/student/myfee', 'myfee')->name('student.myfee');
    Route::get('/student/notice', 'notice')->name('student.notice');

});


Route::controller(AdminController::class)->group(function () {
    Route::get('/admin', 'index')->name('/admin');

   
    
});


Route::get('/teacher', function () {
    return view('page.teacher.dashboard');
})->name('/teacher');

Route::get('teacher/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
Route::get('/teacher/myclass', [TeacherController::class, 'myclass'])->name('teacher.myclass');
Route::get('/teacher/timetable', [TeacherController::class, 'timetable'])->name('teacher.timetable');
Route::get('/teacher/studentlist', [TeacherController::class, 'studentlist'])->name('teacher.studentlist');
<<<<<<< HEAD
Route::get('/teacher/notice', [TeacherController::class, 'noticeBoard'])->name('teacher.notice');



Route::get('/parent', function () {
    return view('page.admin.parent');
})->name('/parent');
=======
Route::get('/teacher/notice',[TeacherController::class, 'noticeBoard'])->name('teacher.notice');
Route::get('/teacher/homework',[TeacherController::class, 'homework'])->name('teacher.homework');

Route::get('/teacher/exam',[ExamController::class,'exam'])->name('teacher.exam');
Route::get('/teacher/marksentry',[ExamController::class,'marksentry'])->name('teacher.marksentry');
>>>>>>> 2dd966227e8e0024c1d153f1b431afd8b71dbd28
