<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function dashboard(){
        $notice=Notice::all();
        return view('page.student.dashboard',compact('notice'));
    }

     public function myclass(){
        return view('page.student.myclass');
    }

    public function showTimetable()
{
    $timetable = [
        ['day' => 'Monday', 'subject' => 'Math', 'teacher' => 'Mr. Sharma', 'start_time' => '09:00 AM', 'end_time' => '10:00 AM'],
        ['day' => 'Tuesday', 'subject' => 'Hindi', 'teacher' => 'Ms. Verma', 'start_time' => '10:15 AM', 'end_time' => '11:15 AM'],
        ['day' => 'Wednesday', 'subject' => 'mathmatics', 'teacher' => 'Ms. Verma', 'start_time' => '10:15 AM', 'end_time' => '11:15 AM'],
        ['day' => 'thursday', 'subject' => '', 'teacher' => 'Ms. Verma', 'start_time' => '10:15 AM', 'end_time' => '11:15 AM'],
        ['day' => 'Friday', 'subject' => 'Science', 'teacher' => 'Mr. Rakesh', 'start_time' => '09:00 AM', 'end_time' => '10:00 AM'],
        ['day' => 'saturday', 'subject' => 'Science', 'teacher' => 'Mr. Rakesh', 'start_time' => '09:00 AM', 'end_time' => '10:00 AM'],
        ['day' => 'sunday', 'subject' => '', 'teacher' => 'Mr. Rakesh', 'start_time' => '09:00 AM', 'end_time' => '10:00 AM'],
        // Add more entries...
    ];

    return view('page.student.myclass', compact('timetable'));
}


 public function attendance(){
        return view('page.student.attendance');
    }


     public function assignment(){
        return view('page.student.assignment');
    }
public function myresult(){
        return view('page.student.myresult');
    }


    public function marksheet(){
        return view('page.student.marksheet');
    }


     public function myfee(){
        return view('page.student.myfee');
    }

    public function notice(){
        return view('page.student.notice');
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
        'email' => 'required|email|unique:students',
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

    // Upload student photo
    if ($request->hasFile('photo')) {
        $validated['photo'] = $request->file('photo')->store('students', 'public');
    }

    // Upload parents photo
    if ($request->hasFile('parents_photo')) {
        $validated['parents_photo'] = $request->file('parents_photo')->store('parents', 'public');
    }

    // Save student
    Student::create($validated);

    return redirect()->back()->with('success', 'Student added successfully!');
}

}
