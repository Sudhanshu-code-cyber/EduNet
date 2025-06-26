<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SectionContoller;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherExamScheduleController;
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
use App\Http\Controllers\Teacher\MarksEntryController;
use App\Http\Controllers\ExamMasterController;


// Student Routes
Route::controller(StudentController::class)->prefix('student')->group(function () {
    Route::get('/', 'dashboard')->name('/student');
    Route::get('/attendance', 'attendance')->name('student.attendance');
    Route::get('/homework', 'homework')->name('student.homework');
    Route::get('/myresult', 'myresult')->name('student.myresult');
    Route::get('/marksheet', 'marksheet')->name('student.marksheet');
    Route::get('/myfee', 'myfee')->name('student.myfee');
    Route::get('/notice', 'notice')->name('student.notice');
    // Route::post('/insert', 'store')->name('students.store');
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

// Teacher Notice Route 
Route::controller(TeacherNoticeController::class)
    ->prefix('teacher/notice')->name('teacher.notice.')
    ->group(function () {
        Route::get('/', 'index')->name('index'); 
        Route::get('/search', 'search')->name('search');
        Route::get('/create', 'create')->name('create'); 
        Route::post('/', 'store')->name('store'); 
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::get('/notice','adminNotices')->name('admin');
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
Route::get('/get-subjects-by-class', [AssignTeacherController::class, 'getSubjectsByClass']);

//Student List route
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

// ExamMaster Route
Route::prefix('teacher/exams')->middleware(['auth'])->name('teacher.')->group(function () {
    Route::get('/', [ExamMasterController::class, 'index'])->name('exams.index');
    Route::post('/', [ExamMasterController::class, 'store'])->name('exams.store');
    Route::post('/{id}/edit', [ExamMasterController::class, 'edit'])->name('exams.edit');
    Route::post('/{id}', [ExamMasterController::class, 'update'])->name('exams.update');
    Route::delete('/{id}', [ExamMasterController::class, 'destroy'])->name('exams.destroy');
});

// Marks-Entry Route
Route::prefix('teacher/marks-entry')->middleware(['auth'])->group(function () {
    Route::get('/', [MarksEntryController::class, 'index'])->name('marks.entry.index');
    Route::post('/search', [MarksEntryController::class, 'search'])->name('marks.entry.search');
    Route::post('/save', [MarksEntryController::class, 'save'])->name('marks.entry.save');
    Route::post('/next-student', [MarksEntryController::class, 'getNextStudent'])->name('marks.entry.next');
    Route::get('/class-sections', [MarksEntryController::class, 'getSections'])->name('get.class.sections');
});
Route::get('/get-sections-by-class/{id}', [TeacherExamScheduleController::class, 'getSectionsByClass']);
Route::get('/get-subjects-by-class', [TeacherExamScheduleController::class, 'getSubjectsByClass']);

















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
Route::delete('/admin/destroy/{id}', [ClassController::class, 'destroyClass'])->name('class.destroy');



// Subject Routes
Route::get('/admin/class-sub', [SubjectController::class, 'index'])->name('class-sub.index');
Route::post('/admin/class-sub', [SubjectController::class, 'store'])->name('class-sub.store');
Route::put('/admin/class-sub/{id}', [SubjectController::class, 'update'])->name('class-sub.update');
Route::delete('/admin/class-sub/{id}', [SubjectController::class, 'destroy'])->name('class-sub.destroy');


Route::get('/admin/subjects/', [SubjectController::class, 'sub_index'])->name('subjects.index');
Route::post('/admin/subjects', [SubjectController::class, 'sub_store'])->name('subjects.store');
Route::put('/admin/update/{id}', [SubjectController::class, 'sub_update'])->name('subjects.update');
Route::delete('/admin/destory/{id}', [SubjectController::class, 'sub_destroy'])->name('subjects.destroy');
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

Route::get('/sections/by-class/{id}', [SectionContoller::class, 'getSectionsByClass']);

Route::get('/get-sections/{id}', [SectionContoller::class, 'getSectionByClass']);

Route::get('/teacher/attendance', [AttendanceController::class, 'index'])->name('teacher.attendance.index');
Route::post('/teacher/attendance/store', [AttendanceController::class, 'store'])->name('teacher.attendance.store');

Route::get('/teacher/calendar', [AttendanceController::class, 'showCalendar'])->name('teacher.calendar');
Route::get('/teacher/attendance-events', [AttendanceController::class, 'getAttendanceAjax'])->name('teacher.attendance.ajax');

// AJAX: get sections by class
Route::get('/teacher/get-sections/{class_id}', function ($class_id) {
    $teacherId = auth()->id();
    $sections = \App\Models\AssignedTeacher::where('teacher_id', $teacherId)
        ->where('class_id', $class_id)
        ->with('section')
        ->get()
        ->pluck('section')
        ->unique('id')
        ->values();
    return response()->json(['sections' => $sections]);
});

// AJAX: get subjects by class
Route::get('/teacher/get-subjects/{class_id}', function ($class_id) {
    $teacherId = auth()->id();
    $subjects = \App\Models\AssignedTeacher::where('teacher_id', $teacherId)
        ->where('class_id', $class_id)
        ->with('subject')
        ->get()
        ->pluck('subject')
        ->unique('id')
        ->values();
    return response()->json(['subjects' => $subjects]);
});

Route::get('/teacher/exam-schedule/create', [TeacherExamScheduleController::class, 'examschedule'])->name('teacher.exam_schedule.create');
Route::post('/teacher/exam-schedule/store', [TeacherExamScheduleController::class, 'storeschedule'])->name('teacher.exam_schedule.store');
Route::delete('/teacher/exam-schedule/{id}', [TeacherExamScheduleController::class, 'deleteExam'])->name('delete.exam');
Route::put('/teacher/exam-schedule/update/{id}', [TeacherExamScheduleController::class, 'update'])->name('exam.update');
Route::get('/teacher/class-data/{class_id}', [TeacherExamScheduleController::class, 'getClassData']);


Route::get('/student/profile', [StudentController::class, 'editProfile'])->name('student.profile.edit');
Route::post('/student/profile', [StudentController::class, 'updateProfile'])->name('student.profile.update');

//teacher edit profile
Route::get('/teacher/profile', [TeacherController::class, 'teachereditProfile'])->name('teacher.profile.edit');
Route::post('/teacher/profile', [TeacherController::class, 'updateProfile'])->name('teacher.profile.update');

Route::get('/subjects/by-class/{id}', [AttendanceController::class, 'getByClass']);
Route::get('/sections/by-class/{id}', [AttendanceController::class, 'getBySection']);






