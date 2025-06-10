<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/student',[StudentController::class,'dashboard'])->name('/student');
Route::get('/student/myclass',[StudentController::class,'myclass'])->name('student.myclass');
Route::get('/student/mytimetable',[StudentController::class,'showTimetable'])->name('student.mytimetable');



