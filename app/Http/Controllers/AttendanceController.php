<?php

namespace App\Http\Controllers;

use App\Models\AssignedTeacher;
use App\Models\Attendance;
use App\Models\ClassModel;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        $teacher = auth()->user();
        $assignment = AssignedTeacher::where('teacher_id', $teacher->id)
            ->with(['class', 'section', 'subject'])
            ->first();
        // if (!$assignment) {
        //     return redirect()->back()->with('error', 'No assigned class/section/subject found.');
        // }

        // Fetch students of that class and section
        $students = Student::where('class_id', $assignment->class_id)
            ->where('section_id', $assignment->section_id)
            ->get();

        return view('page.teacher.attendance', [
            'class_id' => $assignment->class_id,
            'section_id' => $assignment->section_id,
            'subject_id' => $assignment->subject_id,
            'students' => $students
        ]);
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

    public function showCalendar()
    {
        $teacherId = auth()->id();
        $assigned = AssignedTeacher::where('teacher_id', $teacherId)->with(['class'])->get();
        $classes = $assigned->pluck('class')->unique('id');
        return view('page.teacher.attendance-calendar', compact('classes'));
    }

    public function getAttendanceAjax(Request $request)
    {
        $teacherId = auth()->id();

        $isAssigned = AssignedTeacher::where('teacher_id', $teacherId)
            ->where('class_id', $request->class_id)
            ->where('section_id', $request->section_id)
            ->where('subject_id', $request->subject_id)
            ->exists();

        if (!$isAssigned)
            return response()->json([]);

        $attendances = Attendance::with('student')
            ->whereBetween('date', [$request->start, $request->end])
            ->whereHas('student', function ($q) use ($request) {
                $q->where('class_id', $request->class_id)
                    ->where('section_id', $request->section_id)
                    ->where('subject_id', $request->subject_id);
            })
            ->get();

        $events = [];

        foreach ($attendances as $attendance) {
            $color = match ($attendance->status) {
                'present' => 'green',
                'absent' => 'red',
                'leave' => 'orange',
                default => 'gray',
            };

            $events[] = [
                'title' => $attendance->student->name . ' - ' . ucfirst($attendance->status),
                'start' => $attendance->date,
                'color' => $color,
            ];
        }

        return response()->json($events);
    }
}