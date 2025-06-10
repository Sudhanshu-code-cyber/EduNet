<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;

Route::get('/student/dashboard', function () {
    return view('page/student/dashboard');
});

Route::get('/teacher/dashboard', function () {
    return view('page.teacher.dashboard');
});

Route::get('teacher/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
