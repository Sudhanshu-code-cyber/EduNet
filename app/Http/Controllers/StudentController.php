<?php

namespace App\Http\Controllers;
use App\Models\ExamSchedule;
use Illuminate\Support\Facades\Hash;
use App\Models\Notice;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function dashboard()
    {
        $latestNotices = Notice::where('target', 'student')
            ->where(function ($query) {
                $query->whereNull('expires_at')->orWhere('expires_at', '>=', now());
            })
            ->orderByDesc('created_at')
            ->take(3)
            ->get();

        // Get the logged-in student's class and section
        $student = Student::where('user_id', Auth::id())->firstOrFail();

         $examSchedules = ExamSchedule::with(['subject', 'teacher.user'])
            ->where('class_id', $student->class_id)
            ->where('section_id', $student->section_id)
            ->get();

        $countExamShedules=ExamSchedule::count();

        return view('page.student.dashboard', compact('latestNotices', 'examSchedules','countExamShedules'));
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


    public function attendance()
    {
        return view('page.student.attendance');
    }


    public function homework()
    {
        return view('page.student.student-homework');
    }
    public function myresult()
    {
        return view('page.student.myresult');
    }


    public function marksheet()
    {
        return view('page.student.marksheet');
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

}
