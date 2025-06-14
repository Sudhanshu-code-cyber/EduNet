<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TransportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\NoticeController;
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
    Route::get('admin/allstudent/{student}', 'editStudent')->name('student.edit');
    Route::put('/students/{id}', 'studentUpdate')->name('student.update');
    Route::get('admin/student/search', 'searchRollName')->name('student.search');
    Route::get('/admin/class', 'class')->name('admin.class');
Route::post('/admin/class/store',  'storeSection')->name('admin.storeSection');
Route::delete('/class/{id}',  'destroy')->name('class.destroy');
Route::post('/admin/student', 'store')->name('student.store');
Route::get('/admin/student/{id}/show', 'showStudent')->name('student.show');
Route::delete('admin/student/{id}', 'deleteStudent')->name('student.destroy');


});




Route::controller(TeacherController::class)->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/', 'dashboard')->name('dashboard');
    Route::get('/myclass', 'myclass')->name('myclass');
    Route::get('/timetable', 'timetable')->name('timetable');
    Route::get('/studentlist', 'studentlist')->name('studentlist');
    Route::get('/notice', 'noticeBoard')->name('notice');
    Route::get('/homework', 'homework')->name('homework');
    Route::get('/homework/submission', 'submission')->name('submission');
});

Route::controller(ExamController::class)->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/exam', 'exam')->name('exam');
    Route::get('/examschedule', 'examschedule')->name('examschedule');
    Route::get('/marksentry', 'marksentry')->name('marksentry');
});

Route::controller(AdminTeacherController::class)->prefix('admin/teacher')->name('teacher.')->group(function () {
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/', 'index')->name('index');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::get('/{id}/show', 'show')->name('show');
    Route::delete('/{id}', 'destroy')->name('destroy');
    Route::put('/{id}', 'update')->name('update');
    Route::get('/search', 'search')->name('search');
});

Route::get('teacher/attendance', [AttendanceController::class, 'index'])->name('attendance.index');

Route::get('admin/notice/search', [NoticeController::class, 'search'])->name('notice.search');
Route::resource('admin/notice', NoticeController::class);


Route::get('admin/transport', [TransportController::class, 'index'])->name('admin.transport');
Route::post('admin/sport', [TransportController::class, 'store'])->name('admin.store');
Route::delete('admin/transport/{id}', [TransportController::class, 'deletetransport'])->name('transport.delete');
Route::get('admin/transport/search', [TransportController::class, 'search'])->name('transport.search');

