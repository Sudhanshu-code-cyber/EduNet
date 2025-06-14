<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;

class TeacherController extends Controller
{
    public function create(){
        return view('page.admin.teacher-section.add-teacher');
    }

    public function store(Request $req){
        $data = $req->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'gender' => 'required',
            'dob' => 'nullable|date',
            'id_no' => 'nullable|string|max:50',
            'blood_group' => 'nullable|string',
            'religion' => 'nullable|string',
            'email' => 'email|unique:teachers,email',
            'class' => 'nullable|string',
            'section' => 'nullable|string',
            'phone' => 'required|string|max:15',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'address' => 'required|string',
            'short_bio' => 'required|string',
        ]);

        if ($req->hasFile('photo')) {
            $photoPath = $req->file('photo')->store('teachers/photos', 'public');
            $data['photo'] = $photoPath;
        }

        Teacher::create($data);

        return redirect()->back()->with('success', 'Teacher added successfully.');
    }
    

    public function index()
{
    $teachers = Teacher::all();
    return view('page.admin.teacher-section.teachers-list',compact('teachers'));
}

public function show($id)
{
    $teacher = Teacher::findOrFail($id);
    return view('page.admin.teacher-section.view-teacher',compact('teacher'));
}

public function edit($id)
{
$teacher = Teacher::findOrFail($id);
return view('page.admin.teacher-section.edit-teacher',compact('teacher'));    
}

public function update(Request $request, $id)
{
$data = $request->validate([
    'first_name' => 'required|string|max:100',
    'last_name' => 'required|string|max:100',
    'email' => 'required|email|unique:teachers,email,' . $id,
    'phone' => 'required|string|max:15',
    'class' => 'nullable|string',
    'section' => 'nullable|string',
    'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    'address' => 'required|string',
    'short_bio' => 'required|string',
]);  
$teacher = Teacher::findOrFail($id);

if ($request->hasFile('photo')) {
    $photoPath = $request->file('photo')->store('teachers/photos', 'public');
    $data['photo'] = $photoPath;
}

$teacher->update($data);
return redirect()->route('admin.teachers-list')->with('success','Teacher updated successfully!');
}

public function destroy($id)
{
$teacher = Teacher::findOrFail($id);
$teacher->delete();
return redirect()->route('admin.teachers-list')->with('error','Teacher deleted successfully!');
}

}
