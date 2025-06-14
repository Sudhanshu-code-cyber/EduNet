<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $countstudent = Student::count();
        return view('page.admin.dashboard',compact('countstudent'));
    }

    public function allstudent()
{
    // Fetch students with pagination (10 per page)
    $allstudent = Student::orderBy('created_at', 'desc')->paginate(10);

    // Return to the Blade view with data
    return view('page.admin.student.allstudent', compact('allstudent'));
}



     public function addstudent(){
        return view('page.admin.student.addstudent');
    }


    public function editstudentform(Student $allstudent){
    return view('page.admin.student.allstudent',compact("allstudent"));
}


public function studentUpdateForm(Request $req, $stud)
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



public function SearchRollName(Request $request)
{
    $search = $request->input('search');

    $allstudent = Student::where('full_name', 'like', "%{$search}%")
        ->orWhere('roll_no', 'like', "%{$search}%")
        ->paginate(10); // use pagination

    return view('page.admin.student.allstudent', compact('allstudent'));
}






}
