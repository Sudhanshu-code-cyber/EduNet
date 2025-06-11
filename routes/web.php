<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\TeacherController;

Route::get('/student',[StudentController::class,'dashboard'])->name('/student');
Route::get('/student/myclass',[StudentController::class,'showTimetable'])->name('student.myclass');
Route::get('/student/attendance',[StudentController::class,'attendance'])->name('student.attendance');
Route::get('/student/assignment',[StudentController::class,'assignment'])->name('student.assignment');

Route::get('/teacher', function () {
    return view('page.teacher.dashboard');
})->name('/teacher');

Route::get('teacher/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
Route::get('/teacher/myclass',[TeacherController::class,'myclass'])->name('teacher.myclass');
Route::get('/teacher/timetable', [TeacherController::class, 'timetable'])->name('teacher.timetable'); 