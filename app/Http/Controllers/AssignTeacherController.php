<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\ClassModel;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\AssignedTeacher;

class AssignTeacherController extends Controller
{
    public function index()
    {
        $classes = ClassModel::all();
        $sections    = Section::all();
        $subjects = Subject::all();
        $teachers = Teacher::all();
        $assignments = AssignedTeacher::with([ 'class','section', 'subject', 'teacher'])->get();
        dd($assignments);

        return view('page.admin.teacher-work.assign-teacher', compact('classes', 'sections','subjects', 'teachers','assignments'));
    }
    
    public function getSectionsByClass($id)
    {
        return Section::where('class_id', $id)->get();
    }
    


    public function store(Request $request)
    {
        foreach ($request->subjects as $subjectId => $teacherId) {
            AssignedTeacher::updateOrCreate([
                'class_id' => $request->class_id,
                'section_id' => $request->section_id,
                'subject_id' => $subjectId
            ], [
                'teacher_id' => $teacherId
            ]);
        }

        return back()->with('success', 'Teachers assigned successfully!');
    }

    public function destroy($id)
    {
        AssignedTeacher::findOrFail($id)->delete();
        return back()->with('success', 'Assignment deleted.');
    }
}
