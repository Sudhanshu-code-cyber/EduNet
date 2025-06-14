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

        return redirect()->route('teacher.index')->with('success', 'Teacher added successfully.');
    }
    

    public function index()
{
    $teachers = Teacher::paginate(10);
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
return view('page.admin.teacher-section.edit-teacher-modal',compact('teacher'));    
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
return redirect()->route('teacher.index')->with('success','Teacher updated successfully!');
}

public function destroy($id)
{
$teacher = Teacher::findOrFail($id);
$teacher->delete();
return redirect()->route('teacher.index')->with('error','Teacher deleted successfully!');
}

public function search(Request $request)
{
    $search = $request->input('search');

    $teachers = Teacher::query()
        ->when($search, function ($query, $search) {
            return $query->where(function ($q) use ($search) {
                $q->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"])
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('id_no', 'like', "%{$search}%");
            });
        })
        ->paginate(10)
        ->appends(['search' => $search]);

    return view('page.admin.teacher-section.teachers-list', compact('teachers', 'search'));
}

}
