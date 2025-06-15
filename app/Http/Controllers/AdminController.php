<?php

namespace App\Http\Controllers;

use App\Models\ClassSection;
use App\Models\Student;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $countstudent = Student::count();
        return view('page.admin.dashboard', compact('countstudent'));
<<<<<<< HEAD
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
=======
>>>>>>> 6448a3cc8c40d24494440e5fdca9e4fb1dd74b6e
    }

    public function allstudent()
    {
        // Fetch students with pagination (10 per page)
        $allstudent = Student::orderBy('created_at', 'desc')->paginate(10);

        // Return to the Blade view with data
        return view('page.admin.student.allstudent', compact('allstudent'));
    }

<<<<<<< HEAD
=======


>>>>>>> 6448a3cc8c40d24494440e5fdca9e4fb1dd74b6e
    public function addstudent()
    {
        return view('page.admin.student.addstudent');
    }

<<<<<<< HEAD
=======

>>>>>>> 6448a3cc8c40d24494440e5fdca9e4fb1dd74b6e
    public function editStudent(Student $student)
    {
        return view('page.admin.student.edit-student', compact('student'));
    }
<<<<<<< HEAD
=======



    public function studentUpdate(Request $req, $stud)
    {
        $student = Student::findOrFail($stud);

        $data = $req->validate([
            'full_name' => 'required|string|max:255',
            'class' => 'required|string',
            'section' => 'nullable|string',
            'gender' => 'required|string',
            'dob' => 'required|date',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'father_name' => 'required|string',
            'contact' => 'required|string',
        ]);

        $student->update($data); // This returns true/false, but we don't need to store it

        return redirect("/admin/allstudent")->with('success', 'Student updated successfully!');
    }



    public function searchRollName(Request $request)
    {
        $search = $request->input('search');

        $allstudent = Student::where('full_name', 'like', "%{$search}%")
            ->orWhere('roll_no', 'like', "%{$search}%")
            ->paginate(10); // use pagination

        return view('page.admin.student.allstudent', compact('allstudent'));
    }
>>>>>>> 6448a3cc8c40d24494440e5fdca9e4fb1dd74b6e

    public function showStudent($id)
    {
        $student = Student::findOrFail($id);
        return view('page.admin.student.view-student', compact('student'));
    }

<<<<<<< HEAD
    public function deleteStudent($stud)
    {
        $student = Student::findOrFail($stud);
        $student->delete();
        return redirect()->route('admin.allstudent')->with('error', 'Student deleted successfully!');
=======
    public function class()
    {
        $class_section = ClassSection::all();
        return view('page.admin.class.class-section', compact('class_section'));
    }

    public function storeSection(Request $request)
    {
        $request->validate([
            'class_name' => 'required',
            'section_name' => 'required',
            'class_code' => 'required|unique:class_sections',
        ]);

        ClassSection::create($request->all());
        return redirect()->back()->with('success', 'Class Section Added!');
    }

    public function destroy($id)
    {
        ClassSection::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Class Section Deleted!');
>>>>>>> 6448a3cc8c40d24494440e5fdca9e4fb1dd74b6e
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
