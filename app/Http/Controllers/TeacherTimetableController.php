<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\Period;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherTimetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherTimetableController extends Controller
{
    public function index()
    {
        $timetables = TeacherTimetable::with(['teacher', 'class', 'section', 'subject', 'period'])->get();
        return view('page.admin.timetable.index', compact('timetables'));
    }

    public function create()
    {
        $teachers = Teacher::all();
        $periods = Period::all();
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        return view('page.admin.timetable.create', compact('teachers', 'periods', 'days'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required',
            'class_id' => 'required',
            'section_id' => 'required',
            'subject_id' => 'required',
            'period_id' => 'required',
            'day_of_week' => 'required',
        ]);

        $exists = TeacherTimetable::where('teacher_id', $request->teacher_id)
            ->where('day_of_week', $request->day_of_week)
            ->where('period_id', $request->period_id)
            ->first();

        if ($exists) {
            return back()->withErrors('Teacher already assigned for this period on this day!');
        }

        TeacherTimetable::create($request->all());
        return redirect()->route('timetable.index')->with('success', 'Timetable created successfully.');
    }

    public function destroy($id)
    {
        $timetable = TeacherTimetable::findOrFail($id);
        $timetable->delete();
        return back()->with('success', 'Timetable deleted successfully.');
    }

    // Get all assignments of the selected teacher
    public function getAssignments($teacher_id)
    {
        $assignments = DB::table('assigned_teachers')
            ->where('teacher_id', $teacher_id)
            ->get();

        $classIds = $assignments->pluck('class_id')->unique();
        $classes = ClassModel::whereIn('id', $classIds)->get(['id', 'name']);

        return response()->json([
            'classes' => $classes,
        ]);
    }

    // Get sections and subjects for that teacher filtered by class
    public function getSectionsSubjects($teacher_id, $class_id)
    {
        $assignments = DB::table('assigned_teachers')
            ->where('teacher_id', $teacher_id)
            ->where('class_id', $class_id)
            ->get();

        $sectionIds = $assignments->pluck('section_id')->unique()->filter();
        $subjectIds = $assignments->pluck('subject_id')->unique();

        $sections = Section::whereIn('id', $sectionIds)->get(['id', 'name']);
        $subjects = Subject::whereIn('id', $subjectIds)->get(['id', 'name']);

        return response()->json([
            'sections' => $sections,
            'subjects' => $subjects,
        ]);
    }
}
