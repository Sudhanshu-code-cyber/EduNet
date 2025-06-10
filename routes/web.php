<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;

Route::get('/student',[StudentController::class,'dashboard'])->name('/student');
Route::get('/student/myclass',[StudentController::class,'myclass'])->name('student.myclass');
Route::get('/student/mytimetable',[StudentController::class,'showTimetable'])->name('student.mytimetable');

Route::get('/teacher/dashboard', function () {
    return view('page.teacher.dashboard');
});

Route::get('teacher/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
