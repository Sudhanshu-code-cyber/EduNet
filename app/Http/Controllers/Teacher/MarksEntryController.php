<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ExamMaster;
use App\Models\Section;
use App\Models\ClassModel;
use App\Models\ClassSubject;
use App\Models\Student;
use App\Models\MarksEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarksEntryController extends Controller
{
    public function index()
    {
        $exams = ExamMaster::all();
        $teacher = Auth::user()->teacher;
        $classes = ClassModel::all(); // your existing logic
        return view('page.teacher.examinations.marks-entry', compact('exams', 'classes'))->with('sections', []);
    }


    public function search(Request $request)
    {
        $students = Student::where('class_id', $request->class_id)
                           ->where('section_id', $request->section_id)
                           ->get();
    
                           $subjects = ClassSubject::with('subject')
    ->where('class_id', $request->class_id)
    ->get();

        $sections = Section::where('class_id', $request->class_id)->get();
        $student = $students->first(); // first student for entry
    
        $exams = ExamMaster::all();
        $teacher = Auth::user()->teacher;
        $classes = $teacher->assignedClasses();
    
        return view('page.teacher.examinations.marks-entry', [
            'students' => $students,
            'student' => $student,
            'subjects' => $subjects,
            'classes' => $classes,
            'sections' => $sections,
            'exams' => $exams,
            'exam_master_id' => $request->exam_master_id,
            'class_id' => $request->class_id,
            'section_id' => $request->section_id,
        ]);
        
    }
    

    public function save(Request $request)
    {
        foreach ($request->subject_marks as $subject_id => $marks) {
            MarksEntry::create([
                'student_id' => $request->student_id,
                'exam_master_id' => $request->exam_master_id,
                'subject_id' => $subject_id,
                'marks_obtained' => $marks,
                'teacher_id' => Auth::id(),
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function getNextStudent(Request $request)
    {
        $students = Student::where('class_id', $request->class_id)
            ->where('section_id', $request->section_id)
            ->orderBy('roll_no')
            ->get();
    
        $index = $students->search(fn($s) => $s->id == $request->current_student_id);
        $nextStudent = $students->get($index + 1);
    
        if (!$nextStudent) {
            return response()->json(['done' => true]);
        }
    
        $subjects = ClassSubject::with('subject')
            ->where('class_id', $request->class_id)->get();
        $html = view('page.teacher.examinations.marks-entry', [
            'student' => $nextStudent,
            'subjects' => $subjects,
            'request' => $request
        ])->render();
    
        return response()->json(['html' => $html]);
    }
    
   
public function getSections(Request $request)
{
    $sections = Section::where('class_id', $request->class_id)->get();
    return response()->json($sections);
}


}
