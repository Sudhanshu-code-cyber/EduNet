<?php

namespace App\Http\Controllers;
use App\Models\AssignedTeacher;
use App\Models\Student;
use App\Models\ClassModel;
use App\Models\Section;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentListController extends Controller
{

public function index()
{
    $assignedClasses = ClassModel::whereIn('id', function($query) {
        $query->select('class_id')
              ->from('assigned_teachers')
              ->where('teacher_id', auth()->user()->teacher->id);
    })->get();

    $assignedSections = Section::whereIn('id', function($query) {
        $query->select('section_id')
              ->from('assigned_teachers')
              ->where('teacher_id', auth()->user()->teacher->id);
    })->get();

    $students = Student::whereIn('class_id', $assignedClasses->pluck('id'))
        ->whereIn('section_id', $assignedSections->pluck('id'))
        ->when(request('class_id'), function($query, $classId) {
            return $query->where('class_id', $classId);
        })
        ->when(request('section_id'), function($query, $sectionId) {
            return $query->where('section_id', $sectionId);
        })
        ->with(['class', 'section'])
        ->paginate(15); 

    return view('page.teacher.student-list', compact('assignedClasses', 'assignedSections', 'students'));
}
    
    public function getSectionsByClass($classId)
    {
        $teacher = Teacher::where('user_id', Auth::id())->first();
    
        if (!$teacher) {
            return response()->json([], 403);
        }
    
        // Only sections assigned to this teacher for selected class
        $sections = AssignedTeacher::where('teacher_id', $teacher->id)
            ->where('class_id', $classId)
            ->with('section')
            ->get()
            ->pluck('section')
            ->unique('id')
            ->values();
    
        return response()->json($sections);
    }
    
}
