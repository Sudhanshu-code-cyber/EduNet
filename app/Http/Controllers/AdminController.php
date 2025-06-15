<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $countstudent = Student::count();
        return view('page.admin.dashboard', compact('countstudent'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'roll_no' => 'required|string|max:20|unique:students,roll_no',
            'class' => 'required|string|max:20',
            'section' => 'nullable|string|max:10',
            'gender' => 'required|string',
            'dob' => 'required|date',
            'email' => 'required|email|unique:students,email',
            'father_name' => 'required|string|max:255',
            'contact' => 'required|string|max:15',
            'present_address' => 'nullable|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/students'), $filename);
            $data['photo'] = $filename;
        }

        Student::create($data);

        return redirect()->route('admin.allstudent')->with('success', 'Student added successfully!');
    }

    public function allstudent()
    {
        // Fetch students with pagination (10 per page)
        $allstudent = Student::orderBy('created_at', 'desc')->paginate(10);

        // Return to the Blade view with data
        return view('page.admin.student.allstudent', compact('allstudent'));
    }

    public function addstudent()
    {
        return view('page.admin.student.addstudent');
    }

    public function editStudent(Student $student)
    {
        return view('page.admin.student.edit-student', compact('student'));
    }

    public function showStudent($id)
    {
        $student = Student::findOrFail($id);
        return view('page.admin.student.view-student', compact('student'));
    }

    public function deleteStudent($stud)
    {
        $student = Student::findOrFail($stud);
        $student->delete();
        return redirect()->route('admin.allstudent')->with('error', 'Student deleted successfully!');
    }

    public function studentUpdate(Request $req, $stud)
    {
        $student = Student::findOrFail($stud);

        $data = $req->validate([
            'full_name' => 'required|string|max:255',
            'roll_no' => 'required|string|max:20',
            'class' => 'required|string|max:20',
            'section' => 'nullable|string|max:10',
            'gender' => 'required|string',
            'dob' => 'required|date',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'father_name' => 'required|string|max:255',
            'contact' => 'required|string|max:15',
            'present_address' => 'nullable|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($req->hasFile('photo')) {
            $file = $req->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/students'), $filename);
            $data['photo'] = $filename;
        }

        $student->update($data);

        return redirect()->route('admin.allstudent')->with('success', 'Student updated successfully!');
    }

    public function searchRollName(Request $request)
    {
        $search = $request->input('search');

        $allstudent = Student::where('full_name', 'like', "%{$search}%")
            ->orWhere('roll_no', 'like', "%{$search}%")
            ->paginate(10); // use pagination

        return view('page.admin.student.allstudent', compact('allstudent'));
    }
}
