<?php

namespace App\Http\Controllers;
use App\Models\AssignedTeacher;
use App\Models\Attendance;
use App\Models\ExamSchedule;
use App\Models\Subject;
use Illuminate\Support\Facades\Hash;
use App\Models\Notice;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use Illuminate\Http\Request;

class StudentController extends Controller
{

public function dashboard()
{
    if (!auth()->check()) {
        return redirect()->route('login'); // make sure 'login' route exists
    }

    // Get the logged-in student's data
    $student = Student::where('user_id', Auth::id())->firstOrFail();

    // Latest notices for students
    $latestNotices = Notice::where('target', 'student')
        ->where(function ($query) {
            $query->whereNull('expires_at')->orWhere('expires_at', '>=', now());
        })
        ->orderByDesc('created_at')
        ->take(3)
        ->get();

    // Exam schedules for student's class and section
    $examSchedules = ExamSchedule::with(['subject', 'teacher.user'])
        ->where('class_id', $student->class_id)
        ->where('section_id', $student->section_id)
        ->get();

    // Counts
    $countNotice = Notice::count();
    $countExamShedules = ExamSchedule::count();

    // Attendance calculation
    $attendances = Attendance::where('student_id', $student->id)->get();
    $totalDays = $attendances->count();
    $presentDays = $attendances->where('status', 'present')->count();
    $overallPercentage = $totalDays > 0 ? round(($presentDays / $totalDays) * 100) : 0;

    return view('page.student.dashboard', compact(
        'latestNotices',
        'examSchedules',
        'countExamShedules',
        'countNotice',
        'overallPercentage'
    ));
}


    public function myclass()
    {
        $student = Student::where("user_id", Auth::id())->first();
        $classId = $student->class_id;
        $sectionId = $student->section_id;

        // Hardcoded timetable example
        $timetable = [
            ['day' => 'Monday', 'subject' => 'Math', 'teacher' => 'Mr. Sharma', 'start_time' => '09:00 AM', 'end_time' => '10:00 AM'],
            ['day' => 'Tuesday', 'subject' => 'Hindi', 'teacher' => 'Ms. Verma', 'start_time' => '10:15 AM', 'end_time' => '11:15 AM'],
            ['day' => 'Wednesday', 'subject' => 'Mathematics', 'teacher' => 'Ms. Verma', 'start_time' => '10:15 AM', 'end_time' => '11:15 AM'],
            ['day' => 'Thursday', 'subject' => '', 'teacher' => 'Ms. Verma', 'start_time' => '10:15 AM', 'end_time' => '11:15 AM'],
            ['day' => 'Friday', 'subject' => 'Science', 'teacher' => 'Mr. Rakesh', 'start_time' => '09:00 AM', 'end_time' => '10:00 AM'],
            ['day' => 'Saturday', 'subject' => 'Science', 'teacher' => 'Mr. Rakesh', 'start_time' => '09:00 AM', 'end_time' => '10:00 AM'],
            ['day' => 'Sunday', 'subject' => '', 'teacher' => 'Mr. Rakesh', 'start_time' => '09:00 AM', 'end_time' => '10:00 AM'],
        ];

        return view('page.student.myclass', compact('student', 'classId', 'sectionId', 'timetable'));
    }

 public function attendance(Request $request)
    {
        $student = Student::where('user_id', Auth::id())->firstOrFail();

        // Get filters from request
        $subject_id = $request->subject_id;
        $month = $request->month ?? date('m');
        $year = $request->year ?? date('Y');
        $date = $request->date;

        // Get all subjects for dropdown
        $subjects = Subject::all();

        // Base query
        $query = Attendance::with(['subject', 'teacher'])
            ->where('student_id', $student->id)
            ->whereYear('date', $year);

        if ($month) {
            $query->whereMonth('date', $month);
        }

        if ($subject_id) {
            $query->where('subject_id', $subject_id);
        }

        if ($date) {
            $query->whereDate('date', $date);
        }

        $attendances = $query->get();

        // Calculate overall counts
        $totalDays = $attendances->count();
        $presentDays = $attendances->where('status', 'present')->count();
        $absentDays = $attendances->where('status', 'absent')->count();
        $leaveDays = $attendances->where('status', 'leave')->count();

        // Overall percentage
        $overallPercentage = $totalDays > 0 ? round(($presentDays / $totalDays) * 100) : 0;

        // Prepare subject-wise report
        $report = [];
        foreach ($subjects as $subject) {
            $subjectAttendances = $attendances->where('subject_id', $subject->id);
            $subjectTotal = $subjectAttendances->count();
            $subjectPresent = $subjectAttendances->where('status', 'present')->count();
            $subjectPercentage = $subjectTotal > 0 ? round(($subjectPresent / $subjectTotal) * 100) : 0;

            if ($subjectTotal > 0) {
                $report[] = [
                    'subject' => $subject->name,
                    'total_days' => $subjectTotal,
                    'present_days' => $subjectPresent,
                    'percentage' => $subjectPercentage,
                ];
            }
        }

        // Get month name for display
        $monthName = Carbon::createFromDate(null, $month, 1)->format('F');

        return view('page.student.attendance', [
            'subjects' => $subjects,
            'subject_id' => $subject_id,
            'month' => $month,
            'year' => $year,
            'date' => $date,
            'attendances' => $attendances,
            'totalDays' => $totalDays,
            'presentDays' => $presentDays,
            'absentDays' => $absentDays,
            'leaveDays' => $leaveDays,
            'overallPercentage' => $overallPercentage,
            'report' => $report,
            'monthName' => $monthName,
        ]);
    }


    public function homework()
    {
        return view('page.student.student-homework');
    }



 


    public function myfee()
    {
        return view('page.student.myfee');
    }

    public function notice()
    {
        $notices = \App\Models\Notice::where('target', 'student')
            ->where('creator_role', 'teacher')
            ->where(function ($query) {
                $query->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->latest()
            ->paginate(4);

        return view('page.student.notice', compact('notices'));
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'nullable|string',
            'gender' => 'required|string',
            'dob' => 'required|date',
            'roll_no' => 'required|string|unique:students',
            'admission_no' => 'required|string|unique:students',
            'age' => 'required|string',
            'blood_group' => 'nullable|string',
            'religion' => 'nullable|string',
            'email' => 'required|email|unique:students|unique:users,email',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'father_name' => 'required|string',
            'mother_name' => 'required|string',
            'father_occupation' => 'nullable|string',
            'contact' => 'required|string',
            'nationality' => 'required|string',
            'present_address' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'parents_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Step 1: Create user for student
        $user = User::create([
            'name' => $validated['full_name'],
            'email' => $validated['email'],
            'contact' => $validated['contact'],
            'password' => Hash::make('password'), // default password
            'role' => 'student'
        ]);

        $validated['user_id'] = $user->id;

        // Step 2: Handle file uploads
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('students', 'public');
        }

        if ($request->hasFile('parents_photo')) {
            $validated['parents_photo'] = $request->file('parents_photo')->store('parents', 'public');
        }

        // Step 3: Save student
        Student::create($validated);

        return redirect()->route('/student')->with('success', 'Student added successfully!');

    }
    public function editProfile()
    {
        $student = auth()->user();

        return view('page.student.edit-profile', compact('student'));
    }
    public function updateProfile(Request $request)
    {
        $request->validate([
            'contact' => 'required|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $student = auth()->user();
        $student->contact = $request->contact;

        if ($request->password) {
            $student->password = bcrypt($request->password);
        }

        $student->save();

        return back()->with('success', 'Profile updated successfully!');
    }

      public function examSchedule()
    {
          $student = Student::where('user_id', Auth::id())->firstOrFail();

        $examSchedules = ExamSchedule::with(['subject', 'teacher.user', 'class', 'section'])
    ->where('class_id', $student->class_id)
    ->where('section_id', $student->section_id)
    ->paginate(10); // Paginate 10 results per page

return view('page.student.exam-schedule', compact('examSchedules'));

    }

      public function transport()
{
        $student = Student::where('user_id', Auth::id())->firstOrFail();

    // Ensure relation is loaded
    $transport = $student->transport;

    return view('page.student.transport', compact('transport'));
}


}
