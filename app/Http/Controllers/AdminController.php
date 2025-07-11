<?php

namespace App\Http\Controllers;

use App\Models\Transport;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\ClassSection;
use App\Models\Event;
use App\Models\Student;
use App\Models\ClassModel;
use App\Models\Section;
use App\Models\Teacher;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $countstudent = Student::count();
        $countClass = ClassModel::count();
        $countTeacher = Teacher::count();
        $events = Event::all();
        return view('page.admin.dashboard', compact('countstudent', 'events', 'countClass', 'countTeacher'));
    }


    public function create()
    {
        $classes = ClassModel::all();
        $sections = Section::all();
        $transports=Transport::all();
        
        return view('page.admin.student.addstudent', compact('classes', 'sections','transports'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'transport_id' => 'nullable|string|max:255',
            'roll_no' => 'required|string|max:20|unique:students,roll_no',
            'admission_no' => 'required|string|max:50|unique:students,admission_no',
            'class_id' => 'required|string|max:20',
            'section_id' => 'nullable|string|max:10',
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

        $data['uses_transport'] = $request->has('uses_transport');

        $user = User::create([
            'name' => $data['full_name'],
            'email' => $data['email'],
            'contact' => $data['contact'], // make sure contact is in your users table
            'password' => Hash::make('password'), // default password
            'role' => 'student',
        ]);
        
        $data['user_id'] = $user->id;
        
        Student::create($data);

        return redirect()->route('admin.allstudent')->with('success', 'Student added successfully!');
    }


    public function allstudent()
    {
        $classes = ClassModel::all();
        $sections = Section::all();
        $allstudent = Student::orderBy('created_at', 'desc')->paginate(10);
        return view('page.admin.student.allstudent', compact('allstudent', 'classes', 'sections'));
    }

    public function addstudent()
    {
        $classes = ClassModel::all();
        return view('page.admin.student.addstudent', compact('classes'));
    }

    public function editStudent(Student $student)
    {
        return view('page.admin.student.edit-student', compact('student'));
    }

   public function studentupdate(Request $request, $id)
{
    $request->validate([
        'full_name' => 'required|string|max:255',
        'roll_no' => 'nullable|string|max:20|unique:students,roll_no,' . $id,
        'admission_no' => 'nullable|string|max:50|unique:students,admission_no,' . $id,
        'class_id' => 'required|string|max:20',
        'section_id' => 'nullable|string|max:10',
        'gender' => 'nullable|string',
        'dob' => 'nullable|date',
        'age' => 'nullable|string|max:10',
        'blood_group' => 'nullable|string|max:10',
        'religion' => 'nullable|string|max:50',
        'email' => 'nullable|email|max:255|unique:students,email,' . $id,
        'father_name' => 'nullable|string|max:255',
        'mother_name' => 'nullable|string|max:255',
        'father_occupation' => 'nullable|string|max:255',
        'contact' => 'nullable|string|max:15',
        'nationality' => 'nullable|string|max:100',
        'present_address' => 'nullable|string|max:500',
        'permanent_address' => 'nullable|string|max:500',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'parents_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $student = Student::findOrFail($id);

    $data = $request->all();

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

    $data['uses_transport'] = $request->has('uses_transport');

    $student->update($data);

    // Optional: update related user as well
    if ($student->user) {
        $student->user->name = $student->full_name;
        $student->user->email = $student->email;
        $student->user->contact = $student->contact;
        $student->user->save();
    }

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
        $class_section = ClassModel::all();
        return view('page.admin.class.class-section', compact('class_section'));
    }

    public function showStudent($id)
    {
        $student = Student::findOrFail($id);
        return view('page.admin.student.view-student', compact('student'));
    }

    public function storeSection(Request $request)
    {
        $request->validate([
            'class_name' => 'required',
            'section_name' => 'required',
            'class_code' => 'required|unique:class_sections',
        ]);

        ClassModel::create($request->all());
        return redirect()->back()->with('success', 'Class Section Added!');
    }

    public function destroy($id)
    {
        ClassModel::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Class Section Deleted!');
    } 


public function getSectionsByClasses($classId)
{
    $sections = Section::where('class_id', $classId)->get();
    return response()->json($sections);
}

}

















