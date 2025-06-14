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
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'roll_no' => 'required|string|max:20|unique:students,roll_no',
            'admission_no' => 'required|string|max:50|unique:students,admission_no',
            'class' => 'required|string|max:20',
            'section' => 'nullable|string|max:10',
            'gender' => 'required|string',
            'dob' => 'required|date',
            'age' => 'required|string|max:10',
            'blood_group' => 'nullable|string|max:10',
            'religion' => 'nullable|string|max:50',
            'email' => 'required|email|unique:students,email',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'father_occupation' => 'nullable|string|max:255',
            'contact' => 'required|string|max:15',
            'nationality' => 'required|string|max:100',
            'present_address' => 'nullable|string|max:500',
            'permanent_address' => 'nullable|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'parents_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/students'), $filename);
            $data['photo'] = $filename;
        }
    
        if ($request->hasFile('parents_photo')) {
            $file = $request->file('parents_photo');
            $filename = 'parents_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/students'), $filename);
            $data['parents_photo'] = $filename;
        }
    
        Student::create($data);
    
        return redirect()->route('admin.allstudent')->with('success', 'Student added successfully!');
    }
    

    public function allstudent()
    {
        $allstudent = Student::orderBy('created_at', 'desc')->paginate(10);
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

   public function studentupdate(Request $request, $id)
{
    $request->validate([
        'full_name' => 'required|string|max:255',
        'roll_no' => 'nullable|string|max:50',
        'gender' => 'nullable|in:Male,Female',
        'dob' => 'nullable|date',
        'class' => 'nullable|string|max:100',
        'section' => 'nullable|string|max:100',
        'contact' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255',
        'address' => 'nullable|string|max:500',
    ]);

    $student = Student::findOrFail($id);

    $student->full_name = $request->full_name;
    $student->roll_no = $request->roll_no;
    $student->gender = $request->gender;
    $student->dob = $request->dob;
    $student->class = $request->class;
    $student->section = $request->section;
    $student->contact = $request->contact;
    $student->email = $request->email;
    $student->present_address = $request->address;

    $student->save();

    return redirect()->back()->with('success', 'Student updated successfully.');
}
    public function deleteStudent($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        return redirect()->route('admin.allstudent')->with('error', 'Student deleted successfully!');
    }

    public function searchRollName(Request $request)
    {
        $search = $request->input('search');

        $allstudent = Student::where('full_name', 'like', "%{$search}%")
            ->orWhere('roll_no', 'like', "%{$search}%")
            ->paginate(10);

        return view('page.admin.student.allstudent', compact('allstudent'));
    }

    public function class()
    {
        $class_section = ClassSection::all();
        return view('page.admin.class.class-section', compact('class_section'));
    }

public function showStudent($id){
$student = Student::findOrFail($id);
return view('page.admin.student.view-student',compact('student'));
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
    }
}

















