<?php

namespace App\Http\Controllers;

use App\Models\AssignedTeacher;
use App\Models\ExamSchedule;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherExamScheduleController extends Controller
{

    public function examschedule()
    {
        $teacherId = Teacher::where("user_id", Auth::id())->value('id');

        $assigned = AssignedTeacher::with(['class', 'section', 'subject'])
            ->where('teacher_id', $teacherId)
            ->get();
        $exams = ExamSchedule::with(['class', 'section', 'subject'])->get();
        return view('page.teacher.examinations.exam-schedule', compact('assigned', 'exams'));
    }

    public function getClassData($class_id)
{
    $teacherId = Teacher::where('user_id', auth()->id())->value('id');

    $assigned = AssignedTeacher::with(['section:id,name', 'subject:id,name'])
        ->where('teacher_id', $teacherId)
        ->where('class_id', $class_id)
        ->get();

    $sections = $assigned->pluck('section')->unique('id')->values();
    $subjects = $assigned->pluck('subject')->unique('id')->values();

    return response()->json([
        'sections' => $sections,
        'subjects' => $subjects,
    ]);
}


   public function storeschedule(Request $request)
{
    $request->validate([
        'exam_name' => 'required',
        'class_id' => 'required',
        'section_id' => 'required',
        'subject_id' => 'required',
        'exam_date' => 'required|date',
        'start_time' => 'required',
        'end_time' => 'required',
        'duration' => 'required|integer',
        'room_no' => 'required',
        'max_marks' => 'required|integer',
        'min_marks' => 'required|integer',
    ]);

    $teacherId = Teacher::where('user_id', auth()->id())->value('id');

    if (!$teacherId) {
        return redirect()->back()->with('error', 'Teacher not found for this user.');
    }

    ExamSchedule::create([
        'exam_name' => $request->exam_name,
        'class_id' => $request->class_id,
        'section_id' => $request->section_id,
        'subject_id' => $request->subject_id,
        'exam_date' => $request->exam_date,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
        'duration' => $request->duration,
        'room_no' => $request->room_no,
        'max_marks' => $request->max_marks,
        'min_marks' => $request->min_marks,
        'teacher_id' => $teacherId, // ✅ FIXED
    ]);

    return redirect()->back()->with('success', 'Exam schedule added.');
}


    public function deleteExam($id)
    {
        $exam = ExamSchedule::findOrFail($id);
        $exam->delete();

        return redirect()->back()->with('success', 'Exam deleted successfully.');
    }


    public function update(Request $request, $id)
    {
        // ✅ Validate incoming data
        $request->validate([
            'exam_name' => 'required|string|max:255',
            'class_id' => 'required|integer|exists:classes,id',
            'section_id' => 'required|integer|exists:sections,id',
            'subject_id' => 'required|integer|exists:subjects,id',
            'exam_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'duration' => 'required|integer|min:1',
            'room_no' => 'required|string|max:255',
            'max_marks' => 'required|integer|min:1',
            'min_marks' => 'required|integer|min:0|lt:max_marks',
        ]);

        // ✅ Find and update the exam
        $exam = ExamSchedule::findOrFail($id);

        $exam->update([
            'exam_name' => $request->exam_name,
            'class_id' => $request->class_id,
            'section_id' => $request->section_id,
            'subject_id' => $request->subject_id,
            'exam_date' => $request->exam_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'duration' => $request->duration,
            'room_no' => $request->room_no,
            'max_marks' => $request->max_marks,
            'min_marks' => $request->min_marks,
        ]);

        return redirect()->back()->with('success', 'Exam updated successfully.');
    }




}