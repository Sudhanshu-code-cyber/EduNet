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

        return view('page.admin.teacher-work.assign-teacher', compact('classes', 'sections','subjects', 'teachers','assignments'));
    }
    
    public function getSectionsByClass($id)
    {
        return Section::where('class_id', $id)->get();
    }
    
    public function getSubjectsByClass($classId)
    {
        $subjects = Subject::where('class_id', $classId)->get(); // Assuming your Subject model has class_id
        return response()->json($subjects);
    }
    

    public function store(Request $request)
    {
        // Validate inputs
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'subjects_selected' => 'required|array',
            'subjects' => 'required|array'
        ]);
    
        // Debugging: Check the incoming request data
        \Log::info('Request Data:', $request->all());
    
        $selectedSubjects = $request->input('subjects_selected', []);
        $subjectTeacherMap = $request->input('subjects', []);
    
        foreach ($selectedSubjects as $subjectId) {
            $teacherId = $subjectTeacherMap[$subjectId] ?? null;
    
            if ($teacherId) {
                AssignedTeacher::updateOrCreate(
                    [
                        'class_id' => $request->class_id,
                        'section_id' => $request->section_id,
                        'subject_id' => $subjectId
                    ],
                    [
                        'teacher_id' => $teacherId
                    ]
                );
            }
        }
    
        return redirect()->route('assign.teacher.index')->with('success', 'Teachers assigned successfully!');
    }
    
    

    

    public function destroy($id)
    {
        AssignedTeacher::findOrFail($id)->delete();
        return back()->with('error', 'Assignment deleted.');
    }
}
