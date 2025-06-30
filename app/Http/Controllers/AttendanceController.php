<?php

namespace App\Http\Controllers;

use App\Models\AssignedTeacher;
use App\Models\Attendance;
use App\Models\ClassModel;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceController extends Controller
{
  public function index()
{
    $teacher = Teacher::where("user_id", Auth::id())->firstOrFail();

    // All class-section-subjects assigned to the teacher
    $assigned = AssignedTeacher::where('teacher_id', $teacher->id)
        ->with(['class', 'section', 'subject'])
        ->get();

    $classes = $assigned->pluck('class')->unique('id');
    $sections = $assigned->pluck('section')->unique('id');

    return view('page.teacher.attendance', compact('classes', 'sections'));
}


public function getSectionsByClass($class_id)
{
    $teacher = Teacher::where("user_id", Auth::id())->firstOrFail();

    $sections = AssignedTeacher::where('teacher_id', $teacher->id)
        ->where('class_id', $class_id)
        ->with('section')
        ->get()
        ->pluck('section')
        ->unique('id')
        ->values();

    return response()->json(['sections' => $sections]);
}

public function getStudentsForAttendance(Request $request)
{
    $teacher = Teacher::where("user_id", Auth::id())->firstOrFail();

    $students = Student::where('class_id', $request->class_id)
        ->where('section_id', $request->section_id)
        ->get();

    return response()->json(['students' => $students]);
}
    



    public function showForm($class_id, $section_id, $subject_id)
    {
        $students = Student::where('class_id', $class_id)
            ->where('section_id', $section_id)
            ->get();

        return view('page.teacher.attendance', compact('students', 'class_id', 'section_id', 'subject_id'));
    }

    public function store(Request $request)
    {
        foreach ($request->student_ids as $student_id) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $student_id,
                    'class_id' => $request->class_id,
                    'section_id' => $request->section_id,
                    'subject_id' => $request->subject_id,
                    'date' => $request->date,
                ],
                [
                    'status' => $request->attendance_status[$student_id],
                    'teacher_id' => auth()->id(),
                ]
            );
        }

        return redirect()->back()->with('success', 'Attendance recorded successfully!');
    }

    //calendar work
   public function showCalendar()
    {
        $teacher = Teacher::where("user_id", Auth::id())->first();

        if (!$teacher) {
            abort(403, "Teacher not found for this user.");
        }

        $assigned = AssignedTeacher::where('teacher_id', $teacher->id)->with('class')->get();
        $classes = $assigned->pluck('class')->unique('id');

        return view('page.teacher.attendance-calendar', compact('classes', 'teacher'));
    }

    public function getAttendanceAjax(Request $request)
    {
        $teacher = Teacher::where("user_id", Auth::id())->first();

        if (!$teacher) {
            return response()->json([]);
        }

        if (!$request->class_id || !$request->section_id) {
            return response()->json([]);
        }

        $query = Attendance::where('class_id', $request->class_id)
            ->where('section_id', $request->section_id)
            ->whereBetween('date', [$request->start, $request->end])
            ->with(['student', 'subject']);

        if ($request->subject_id) {
            $query->where('subject_id', $request->subject_id);
        }

        if ($request->student_id) {
            $query->where('student_id', $request->student_id);
        }

        $attendances = $query->get();

        $events = [];

        foreach ($attendances as $attendance) {
            $color = match ($attendance->status) {
                'present' => 'green',
                'absent' => 'red',
                'leave' => 'orange',
                default => 'gray',
            };

            $events[] = [
                'title' => $attendance->student->full_name . ' - ' . ucfirst($attendance->status),
                'start' => $attendance->date,
                'color' => $color,
                'extendedProps' => [
                    'student' => $attendance->student->full_name,
                    'status' => ucfirst($attendance->status),
                    'subject' => $attendance->subject->name ?? '',
                ]
            ];
        }

        return response()->json($events);
    }

    public function getStudents($class_id, $section_id)
    {
        $students = Student::where('class_id', $class_id)
            ->where('section_id', $section_id)
            ->orderBy('roll_no')
            ->get(['id', 'full_name', 'roll_no']);

        return response()->json(['students' => $students]);
    }

    public function getStudentReport(Request $request)
    {
        $query = Attendance::where('class_id', $request->class_id)
            ->where('section_id', $request->section_id);

        if ($request->student_id) {
            $query->where('student_id', $request->student_id);
        }

        $report = $query->with(['subject'])->orderBy('date', 'desc')->get();

        return response()->json(['report' => $report]);
    }

}