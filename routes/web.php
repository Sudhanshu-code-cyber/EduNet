<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PeriodController;
use App\Http\Controllers\SectionContoller;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherExamScheduleController;
use App\Http\Controllers\TeacherTimetableController;
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
use App\Http\Controllers\Student\FeeController;

// Student Routes
Route::controller(StudentController::class)->prefix('student')->group(function () {
    Route::get('/', 'dashboard')->name('/student');
    Route::get('/homework', 'homework')->name('student.homework');
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

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::controller(AdminController::class)->group(function () {
        // Dashboard
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
        Route::get('/class', 'class')->name('class');
        Route::post('/class/store', 'storeSection')->name('storeSection');
    });
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
    // Route::get('/marksentry', 'marksentry')->name('marksentry');
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
        Route::post('/', 'store')->name('store'); 
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::get('/admin','adminNotices')->name('admin');
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
Route::match(['get', 'post'], 'admin/student/fee-payment/search', [FeePaymentController::class, 'search'])->name('fee-payment.search');
Route::post('admin/student/fee-payment/', [FeePaymentController::class, 'store'])->name('fee-payment.store');
Route::get('admin/student/fee-payment', [FeePaymentController::class, 'create'])->name('fee-payment.create');


Route::get('/fee-payment/view/{student_id}', [FeePaymentController::class, 'showFeeDetails'])->name('admin.fee-payment.view');
Route::post('/admin/fee-payment/store', [FeePaymentController::class, 'storeFeePayment'])->name('admin.fee-payment.store');
Route::get('/admin/fee-payment/history', [FeePaymentController::class, 'paymentHistory'])->name('admin.fee-payment.history');


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
Route::prefix('teacher')->name('teacher.')->group(function () {
    Route::get('homework', [TeacherHomeworkController::class, 'index'])->name('homework.index');    
    Route::post('homework', [TeacherHomeworkController::class, 'store'])->name('homework.store');
    Route::get('homework/{id}/edit', [TeacherHomeworkController::class, 'edit'])->name('homework.edit');
    Route::put('homework/{id}', [TeacherHomeworkController::class, 'update'])->name('homework.update');
    Route::delete('homework/{id}', [TeacherHomeworkController::class, 'destroy'])->name('homework.destroy');
    Route::get('homework/search', [TeacherHomeworkController::class, 'search'])->name('homework.search');
    Route::get('homework/submissions', [TeacherHomeworkController::class, 'submissions'])->name('homework.submissions');
Route::get('get-sections/{class_id}', [TeacherHomeworkController::class, 'getSections'])->name('homework.get-sections');
Route::get('get-subjects/{class_id}/{section_id}', [TeacherHomeworkController::class, 'getSubjects'])->name('homework.get-subjects');
Route::put('homework/{id}', [TeacherHomeworkController::class, 'update'])->name('homework.update');
Route::get('homework/report', [TeacherHomeworkController::class, 'report'])->name('homework.report');
Route::get('homework/get-sections-by-class', [TeacherHomeworkController::class, 'getSectionsByClass']);

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

// Marks Entry Routes
Route::prefix('teacher/marks-entry')->middleware(['auth'])->group(function () {
    Route::get('/', [MarksEntryController::class, 'index'])->name('marks.entry.index');
    Route::post('/search', [MarksEntryController::class, 'search'])->name('marks.entry.search');
    Route::post('/save', [MarksEntryController::class, 'save'])->name('marks.entry.save');
    Route::post('/next-student', [MarksEntryController::class, 'nextStudent'])->name('marks.entry.next');
    Route::get('/get-sections/{class_id}', [MarksEntryController::class, 'getSections'])->name('marks.getSections');
  Route::get('/edit/{student_id}/{exam_id}', [MarksEntryController::class, 'editMarksEntry'])->name('marks.entry.edit'); 
Route::post('/update', [MarksEntryController::class, 'updateMarksEntry'])->name('marks.entry.update');
Route::delete('/delete', [MarksEntryController::class, 'deleteMarksEntry'])->name('marks.entry.delete');
});

// Marks List Routes 
Route::match(['get', 'post'], 'teacher/marks-list', [MarksEntryController::class, 'marksList'])->name('marks.list');
Route::get('teacher/marks-list/sections/{class_id}', [MarksEntryController::class, 'getSections'])->name('marks.list.sections');
Route::get('/student/result/print',[MarksEntryController::class, 'printResult'])->name('student.result.print');
Route::get('student/result', [MarksEntryController::class, 'viewResult'])->name('student.result');
Route::get('marks-entry/print/{student_id}/{exam_id}', [MarksEntryController::class, 'printMarksheet'])->name('marks.entry.print');


Route::get('/get-sections-by-class/{id}', [TeacherExamScheduleController::class, 'getSectionsByClass']);
Route::get('/get-subjects-by-class', [TeacherExamScheduleController::class, 'getSubjectsByClass']);

Route::get('/admin/fee-payment-summary', [App\Http\Controllers\Admin\FeePaymentSummaryController::class, 'index'])->name('admin.fee.summary');
Route::get('/admin/fee-payment-summary/months', [App\Http\Controllers\Admin\FeePaymentSummaryController::class, 'getFeeMonths'])->name('admin.fee.summary.months');
Route::get('/admin/fee-payment-summary/months', [App\Http\Controllers\Admin\FeePaymentSummaryController::class, 'monthsData']);


// Student Fee Overview
Route::middleware(['web'])->prefix('student')->group(function () {
// Simulate student login
Route::get('/simulate-student-login', function () {
session(['student_id' => 1]); // Set student_id here
return redirect()->route('student.fees.overview');
});

// Student Fee Overview
Route::get('/fees/overview', [FeeController::class, 'overview'])->name('student.fees.overview');

// Student Fee Payment
Route::post('/pay-fee', [FeeController::class, 'pay'])->name('student.fees.pay');
Route::get('/pay-fees/{fee_type_id?}', [FeeController::class, 'payFeesPage'])->name('student.pay-fees');

// Student Fee Payment History
Route::get('/student/payment-history', [FeeController::class, 'paymentHistory'])->name('student.payment-history');

});









Route::get('/student/attendance/data', [StudentController::class, 'fetchStudentAttendance'])->name('student.attendance.data');
















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
Route::delete('/classes/{id}', [ClassController::class, 'destroy'])->name('classes.destroy');



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

Route::get('/sections/by-class/{classId}', [App\Http\Controllers\AdminController::class, 'getSectionsByClasses']);


Route::get('/', function () {
    return view('home');
})->name('login');


Route::get('/register',[AuthController::class,'register'])->name('register');
Route::post('/register',[AuthController::class,'userRegister'])->name('userRegister');
Route::post('/',[AuthController::class,'Userlogin'])->name('Userlogin');
Route::post('/logout', [AuthController::class, 'logout'])->name('user.logout');


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

// Route::get('/teacher/get-sections/{class_id}', function ($class_id) {
//     $teacherId = auth()->id();
//     $sections = \App\Models\AssignedTeacher::where('teacher_id', $teacherId)
//         ->where('class_id', $class_id)
//         ->with('section')
//         ->get()
//         ->pluck('section')
//         ->unique('id')
//         ->values();
//     return response()->json(['sections' => $sections]);
// });

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

Route::get('/teacher/get-students/{class_id}/{section_id}', [AttendanceController::class, 'getStudents']);
Route::get('/teacher/get-student-report', [AttendanceController::class, 'getStudentReport']);
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
Route::get('/student/examshedule', [StudentController::class, 'examSchedule'])->name('student.examschedule');
// routes/web.php

Route::get('/teacher/attendance', [AttendanceController::class, 'index'])->name('teacher.attendance');
Route::post('/teacher/attendance/store', [AttendanceController::class, 'store'])->name('teacher.attendance.store');
Route::post('/teacher/attendance/get-students', [AttendanceController::class, 'getStudentsForAttendance']);
Route::get('/teacher/attendance/get-sections/{class_id}', [AttendanceController::class, 'getSectionsByClass']);
// routes/web.php
Route::get('/student/transport', [StudentController::class,'transport'])->name('student.transport');

//timetable 

// Show all periods
Route::get('/admin/periods', [PeriodController::class, 'index'])->name('periods.index');

// Show create form
Route::get('/admin/periods/create', [PeriodController::class, 'create'])->name('periods.create');

// Store new period
Route::post('/admin/periods', [PeriodController::class, 'store'])->name('periods.store');

// Show edit form
Route::get('/admin/periods/{id}/edit', [PeriodController::class, 'edit'])->name('periods.edit');

// Update period
Route::put('/admin/periods/{id}', [PeriodController::class, 'update'])->name('periods.update');

// Delete period
Route::delete('/admin/periods/{id}', [PeriodController::class, 'destroy'])->name('periods.destroy');
Route::get('/admin/timetables', [TeacherTimetableController::class, 'index'])->name('timetable.index');
Route::get('/admin/timetables/create', [TeacherTimetableController::class, 'create'])->name('timetable.create');


// Store new timetable
Route::post('admin/timetables', [TeacherTimetableController::class, 'store'])->name('timetable.store');

// Delete timetable
Route::delete('admin/timetables/{id}', [TeacherTimetableController::class, 'destroy'])->name('timetable.destroy');
Route::get('/get-assignments-by-teacher/{teacher_id}', [TeacherTimetableController::class, 'getAssignments']);
Route::get('/get-sections-subjects/{teacher_id}/{class_id}', [TeacherTimetableController::class, 'getSectionsSubjects']);
Route::get('/teacher/timetable/{teacher_id}', [TeacherController::class, 'timetable'])->name('teacher.timetable');


  Route::get('/student/attendance', [StudentController::class, 'attendance'])->name('student.attendance');
















