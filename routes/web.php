<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TransportController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\Admin\TeacherController as AdminTeacherController;

// Student Routes
Route::controller(StudentController::class)->prefix('student')->group(function () {
    Route::get('/', 'dashboard')->name('/student');
    Route::get('/myclass', 'showTimetable')->name('student.myclass');
    Route::get('/attendance', 'attendance')->name('student.attendance');
    Route::get('/assignment', 'assignment')->name('student.assignment');
    Route::get('/myresult', 'myresult')->name('student.myresult');
    Route::get('/marksheet', 'marksheet')->name('student.marksheet');
    Route::get('/myfee', 'myfee')->name('student.myfee');
    Route::get('/notice', 'notice')->name('student.notice');
    Route::post('/insert', 'store')->name('students.store');
});

// Parent Route
Route::get('/parent', function () {
    return view('page.admin.parent');
})->name('/parent');

// Admin Routes
Route::controller(AdminController::class)->prefix('admin')->group(function () {
    Route::get('/', 'index')->name('/admin');

    // Student Management
    Route::get('/allstudent', 'allstudent')->name('admin.allstudent');
    Route::get('/addstudent', 'addstudent')->name('admin.addstudent');
    Route::get('/allstudent/{student}', 'editStudent')->name('student.edit');
    Route::put('/students/{id}', 'studentUpdate')->name('student.update');
    Route::post('/student', 'store')->name('student.store');
    Route::get('/student/{id}/show', 'showStudent')->name('student.show');
    Route::delete('/student/{id}', 'deleteStudent')->name('student.destroy');
    Route::get('/student/search', 'searchRollName')->name('student.search');

    // Class Section
    Route::get('/class', 'class')->name('admin.class');
    Route::post('/class/store', 'storeSection')->name('admin.storeSection');
    Route::delete('/class/{id}', 'destroy')->name('class.destroy');
});

// Teacher Routes (User Side)
Route::controller(TeacherController::class)->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/', 'dashboard')->name('dashboard');
    Route::get('/myclass', 'myclass')->name('myclass');
    Route::get('/timetable', 'timetable')->name('timetable');
    Route::get('/studentlist', 'studentlist')->name('studentlist');
    Route::get('/notice', 'noticeBoard')->name('notice');
    Route::get('/homework', 'homework')->name('homework');
    Route::get('/homework/submission', 'submission')->name('submission');
});

// Exam Routes (Part of Teacher Role)
Route::controller(ExamController::class)->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/exam', 'exam')->name('exam');
    Route::get('/examschedule', 'examschedule')->name('examschedule');
    Route::get('/marksentry', 'marksentry')->name('marksentry');
});

// Admin Teacher Management
Route::controller(AdminTeacherController::class)->prefix('admin/teacher')->name('teacher.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::get('/{id}/show', 'show')->name('show');
    Route::put('/{id}', 'update')->name('update');
    Route::delete('/{id}', 'destroy')->name('destroy');
    Route::get('/search', 'search')->name('search');
});

// Attendance Route
Route::get('teacher/attendance', [AttendanceController::class, 'index'])->name('attendance.index');

// Notice Routes
Route::get('admin/notice/search', [NoticeController::class, 'search'])->name('notice.search');
Route::resource('admin/notice', NoticeController::class);

// Transport Routes
Route::prefix('admin')->group(function () {
    Route::get('/transport', [TransportController::class, 'index'])->name('admin.transport');
    Route::post('/sport', [TransportController::class, 'store'])->name('admin.store');
    Route::delete('/transport/{id}', [TransportController::class, 'deletetransport'])->name('transport.delete');
    Route::get('/transport/search', [TransportController::class, 'search'])->name('transport.search');
});
