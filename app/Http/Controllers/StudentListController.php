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
    public function index(Request $request)
    {
        // Step 1: Get user_id from logged-in user
        $teacher = Teacher::where("user_id",Auth::id())->first();
        // Step 2: Get teacher_id from teachers table

        if (!$teacher) {
            abort(403, 'No teacher profile found.');
        }

        $teacherId = $teacher->id;

        // Step 3: Get assigned classes and sections for this teacher
        $assignments = AssignedTeacher::where('teacher_id', $teacherId)->get();

        $assignedClassIds = $assignments->pluck('class_id')->unique();
        $assignedSectionIds = $assignments->pluck('section_id')->unique();

        $assignedClasses = ClassModel::whereIn('id', $assignedClassIds)->get();
        $assignedSections = Section::whereIn('id', $assignedSectionIds)->get();

        // Step 4: Filter students based on class and section filters
        $query = Student::query()->with('class', 'section');

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        if ($request->filled('section_id')) {
            $query->where('section_id', $request->section_id);
        }

        // Step 5: Restrict students to only assigned class & section
        $query->whereIn('class_id', $assignedClassIds)
              ->whereIn('section_id', $assignedSectionIds);

        $students = $query->get();

        return view('page.teacher.student-list', compact(
            'students', 'assignedClasses', 'assignedSections'
        ));
    }
    
}
