<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TransportController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\Admin\TeacherController as AdminTeacherController;
use App\Http\Controllers\Teacher\TeacherNoticeController;
use App\Http\Controllers\FeeTypeController;
use App\Http\Controllers\FeeStructureController;
use App\Http\Controllers\FeePaymentController;
use App\Http\Controllers\AssignTeacherController;
use App\Http\Controllers\StudentListController;
use App\Http\Controllers\Teacher\HomeworkController as TeacherHomeworkController;
use App\Http\Controllers\Student\HomeworkController as StudentHomeworkController;


// Student Routes
Route::controller(StudentController::class)->prefix('student')->group(function () {
    Route::get('/', 'dashboard')->name('/student');
    Route::get('/attendance', 'attendance')->name('student.attendance');
    Route::get('/homework', 'homework')->name('student.homework');
    Route::get('/myresult', 'myresult')->name('student.myresult');
    Route::get('/marksheet', 'marksheet')->name('student.marksheet');
    Route::get('/myfee', 'myfee')->name('student.myfee');
    Route::get('/notice', 'notice')->name('student.notice');
    Route::post('/insert', 'store')->name('students.store');
Route::get('/myclass','myclass')->name('student.myclass');

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
    Route::get('/allstudent/{student}', 'editStudent')->name('student.edit');
    Route::put('/students/{id}', 'studentUpdate')->name('student.update');
    Route::post('/student/store', 'store')->name('students.store');
    Route::get('/student/{id}/show', 'showStudent')->name('student.show');
    Route::delete('/student/{id}', 'deleteStudent')->name('student.destroy');
    Route::get('/student/search', 'searchRollName')->name('student.search');
    Route::get('/student/create', 'create')->name('student.create');

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
    Route::get('/notice', 'noticeBoard')->name('notice');
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




Route::controller(TeacherNoticeController::class)->prefix('teacher')->name('teacher.notice.')->group(function () {
    Route::get('/notice','index')->name('index');
    Route::get('/notice/search', 'search')->name('search');
    Route::get('/create','create')->name('create');
    Route::post('/','store')->name('store');
    Route::get('/{id}/edit','edit')->name('edit');
    Route::put('/notice/{id}','update')->name('update');
    Route::delete('/{id}', 'destroy')->name('destroy');
});

// Fee Type
Route::get('admin/student/fee-types', [FeeTypeController::class, 'index'])->name('fee-types.index');
Route::post('admin/student/', [FeeTypeController::class, 'store'])->name('fee-types.store');
Route::get('/fee-types/{id}/edit', [FeeTypeController::class, 'edit'])->name('fee-types.edit');
Route::put('/fee-types/{id}', [FeeTypeController::class, 'update'])->name('fee-types.update');
Route::delete('/fee-types/{id}', [FeeTypeController::class, 'destroy'])->name('fee-types.destroy');


// Fee Structure
Route::get('admin/student/fee-structure/create', [FeeStructureController::class, 'create'])->name('fee-structure.create');
Route::get('admin/student/fee-structure/index', [FeeStructureController::class, 'index'])->name('fee-structure.index');
Route::post('admin/student/fee-structure', [FeeStructureController::class, 'store'])->name('fee-structure.store');
Route::delete('/fee-structure/{id}', [FeeStructureController::class, 'destroy'])->name('fee-structure.destroy');

// Fee Payment
Route::post('admin/student/fee-payment/search', [FeePaymentController::class, 'search'])->name('fee-payment.search');
Route::post('admin/student/fee-payment/', [FeePaymentController::class, 'store'])->name('fee-payment.store');
Route::get('admin/student/fee-payment', [FeePaymentController::class, 'create'])->name('fee-payment.create');

//Assign Subject to teachers
Route::get('admin/assign-teacher', [AssignTeacherController::class, 'index'])->name('assign.teacher.index');
Route::post('admin/assign-teacher/submit', [AssignTeacherController::class, 'store'])->name('assign.teacher.store');
Route::delete('/assigned-subjects/{id}', [AssignTeacherController::class, 'destroy'])->name('assign.teacher.delete');
Route::get('/get-sections-by-class/{id}', [AssignTeacherController::class, 'getSectionsByClass']);
Route::get('/get-subjects-by-class/{class_id}', [AssignTeacherController::class, 'getSubjectsByClass']);


Route::middleware(['auth'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/student-list', [StudentListController::class, 'index'])->name('student-list.index');
    Route::get('/get-sections-by-class/{id}', [StudentListController::class, 'getSectionsByClass']);
});

// Teacher Routes for Homework
// Route::middleware(['auth'])->prefix('teacher')->name('teacher.')->group(function () {

Route::prefix('teacher')->name('teacher.')->group(function () {
    Route::get('homework', [TeacherHomeworkController::class, 'index'])->name('homework.index');
    Route::post('homework', [TeacherHomeworkController::class, 'store'])->name('homework.store');
    Route::get('homework/{id}/edit', [TeacherHomeworkController::class, 'edit'])->name('homework.edit');
    Route::put('homework/{id}', [TeacherHomeworkController::class, 'update'])->name('homework.update');
    Route::delete('homework/{id}', [TeacherHomeworkController::class, 'destroy'])->name('homework.destroy');
    // Route::get('homework/{id}', [TeacherHomeworkController::class, 'show'])->name('homework.show');
    Route::get('homework/search', [TeacherHomeworkController::class, 'search'])->name('homework.search');
    Route::get('homework/submissions', [TeacherHomeworkController::class, 'submissions'])->name('homework.submissions');

    // Fetch sections for selected class assigned to the logged-in teacher
Route::get('get-sections/{class_id}', [\App\Http\Controllers\Teacher\HomeworkController::class, 'getSections']);
// Fetch subjects for selected class and section assigned to the logged-in teacher
Route::get('get-subjects/{class_id}/{section_id}', [\App\Http\Controllers\Teacher\HomeworkController::class, 'getSubjects']);
});

// Student Routes for Homework
Route::prefix('student')->name('student.')->group(function () {
    Route::get('homework', [StudentHomeworkController::class, 'index'])->name('homework.index');
    Route::post('homework/submit', [StudentHomeworkController::class, 'submit'])->name('homework.submit');
});


















// Transport Routes
Route::prefix('admin')->group(function () {
    Route::get('/transport', [TransportController::class, 'index'])->name('admin.transport');
    Route::post('/transport/submit', [TransportController::class, 'store'])->name('admin.store');
    Route::delete('/transport/{id}', [TransportController::class, 'deletetransport'])->name('transport.delete');
    Route::get('/transport/search', [TransportController::class, 'search'])->name('transport.search');
    Route::put('/transport/update/{id}', [TransportController::class, 'update'])->name('transport.update');
});



Route::get('/admin/classes/', [ClassController::class, 'index'])->name('classes.index');
Route::post('/admin/classes', [ClassController::class, 'store'])->name('classes.store');
Route::put('/admin/update/{id}', [ClassController::class, 'update'])->name('classes.update');
Route::delete('/admin/destory/{id}', [ClassController::class, 'destroy'])->name('classes.destroy');



// Subject Routes
Route::get('/admin/subjects', [SubjectController::class, 'index'])->name('subjects.index');
Route::post('/admin/subjects', [SubjectController::class, 'store'])->name('subjects.store');
Route::put('/admin/subjects/{id}', [SubjectController::class, 'update'])->name('subjects.update');
Route::delete('/admin/subjects/{id}', [SubjectController::class, 'destroy'])->name('subjects.destroy');
// routes/web.php
Route::get('/admin/subjects/by-class/{id}', [SubjectController::class, 'getByClass']);


Route::get('/admin/subjects/filter/{class_id?}', [SubjectController::class, 'filter'])->name('subjects.filter');



Route::get('/', function () {
    return view('home');
})->name('home.login');


Route::get('/register',[AuthController::class,'register'])->name('register');
Route::post('/register',[AuthController::class,'userRegister'])->name('userRegister');
Route::post('/',[AuthController::class,'Userlogin'])->name('Userlogin');
Route::get('/logout',[AuthController::class,'logout'])->name('user.logout');

use App\Http\Controllers\EventController;

Route::get('/admin/calendar', [EventController::class, 'index'])->name('admin.calendar');
Route::get('/calendar/events', [EventController::class, 'fetch']);
Route::post('/calendar/events', [EventController::class, 'store']);
Route::put('/calendar/events/{id}', [EventController::class, 'update']);
Route::delete('/calendar/events/{id}', [EventController::class, 'destroy']);


Route::get('/admin/create-section',[SectionContoller::class,'index'])->name('create.section');
Route::post('/admin/store',[SectionContoller::class,'storeSections'])->name('store.section');
Route::delete('/admin/delete{id}',[SectionContoller::class,'delete'])->name('delete.section');



    Route::get('/teacher/attendance', [AttendanceController::class, 'index'])->name('teacher.attendance.index');

    Route::get('/teacher/attendance/form/{class_id}/{section_id}/{subject_id}', 
        [AttendanceController::class, 'showForm'])->name('teacher.attendance.form');

    Route::post('/teacher/attendance/store', [AttendanceController::class, 'store'])->name('teacher.attendance.store');



    //attendace calendar
   Route::get('teacher/calendar', [AttendanceController::class, 'calendarView'])->name('attendance.calendar');
Route::get('/attendance-events', [AttendanceController::class, 'getEvents'])->name('attendance.events');
Route::get('/get-sections/{id}', [SectionContoller::class, 'getSectionByClass']);

