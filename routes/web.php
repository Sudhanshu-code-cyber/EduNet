<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\Admin\TeacherController as AdminTeacherController;




Route::controller(StudentController::class)->group(function () {

    Route::get('/student', 'dashboard')->name('/student');
    Route::get('/student/myclass', 'showTimetable')->name('student.myclass');
    Route::get('/student/attendance', 'attendance')->name('student.attendance');
    Route::get('/student/assignment', 'assignment')->name('student.assignment');
    Route::get('/student/myresult', 'myresult')->name('student.myresult');
    Route::get('/student/marksheet', 'marksheet')->name('student.marksheet');
    Route::get('/student/myfee', 'myfee')->name('student.myfee');
    Route::get('/student/notice', 'notice')->name('student.notice');
    Route::post('/student/insert', 'store')->name('students.store');

});



Route::get('/parent', function () {
    return view('page.admin.parent');
})->name('/parent');
Route::controller(AdminController::class)->group(function () {
    Route::get('/admin', 'index')->name('/admin');
    Route::get('admin/allstudent', 'allstudent')->name('admin.allstudent');
    Route::get('admin/addstudent', 'addstudent')->name('admin.addstudent');
    Route::get('admin/allstudent/{id}', 'editstudentform')->name('allstudent.edit');
    Route::put('admin/allstudent/{id}', 'studentUpdateForm');
Route::get('/admin/search-student', [AdminController::class, 'SearchRollName'])->name('searchStudent');
    
   
});




Route::controller(TeacherController::class)->prefix('teacher')->name('teacher.')->group(function(){
    Route::get('/','dashboard')->name('dashboard');
    Route::get('/myclass', 'myclass')->name('myclass');
    Route::get('/timetable','timetable')->name('timetable');
    Route::get('/studentlist','studentlist')->name('studentlist');
    Route::get('/notice','noticeBoard')->name('notice');
    Route::get('/homework','homework')->name('homework');
    Route::get('/homework/submission','submission')->name('submission');
});

Route::controller(ExamController::class)->prefix('teacher')->name('teacher.')->group(function(){
    Route::get('/exam','exam')->name('exam');
    Route::get('/examschedule','examschedule')->name('examschedule');
    Route::get('/marksentry','marksentry')->name('marksentry');
});

Route::controller(AdminTeacherController::class)->prefix('admin/teacher')->name('teacher.')->group(function(){
    Route::get('/create','create')->name('create');
    Route::post('/store','store')->name('store');
    Route::get('/','index')->name('index');
    Route::get('/{id}/edit','edit')->name('edit');
    Route::get('/{id}/show','show')->name('show');
    Route::delete('/{id}','destroy')->name('destroy');
    Route::put('/{id}','update')->name('update');

});

Route::get('teacher/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
