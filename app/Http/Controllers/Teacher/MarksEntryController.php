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
        $classes = ClassModel::all(); // Or filter assigned classes to teacher
        return view('page.teacher.examinations.marks-entry', compact('exams', 'classes'))->with('sections', []);
    }

    public function search(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'exam_master_id' => 'required|exists:exam_masters,id',
        ]);

        $students = Student::where('class_id', $request->class_id)
            ->where('section_id', $request->section_id)
            ->orderBy('roll_no')
            ->get();

        $subjects = ClassSubject::with('subject')
            ->where('class_id', $request->class_id)
            ->get();

        $sections = Section::where('class_id', $request->class_id)->get();

        return view('page.teacher.examinations.marks-entry', [
            'students' => $students,
            'student' => $students->first(),
            'subjects' => $subjects,
            'classes' => ClassModel::all(),
            'sections' => $sections,
            'exams' => ExamMaster::all(),
            'exam_master_id' => $request->exam_master_id,
            'class_id' => $request->class_id,
            'section_id' => $request->section_id,
        ]);
    }

    public function save(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'exam_master_id' => 'required|exists:exam_masters,id',
            'subject_marks' => 'required|array',
        ]);

        $teacherId = Auth::user()->teacher->id ?? Auth::id();

        foreach ($request->subject_marks as $subject_id => $marks) {
            MarksEntry::updateOrCreate(
                [
                    'student_id' => $request->student_id,
                    'subject_id' => $subject_id,
                    'exam_master_id' => $request->exam_master_id,
                ],
                [
                    'marks_obtained' => $marks,
                    'teacher_id' => $teacherId,
                ]
            );
        }

        return response()->json(['success' => true]);
    }

    public function nextStudent(Request $request)
    {
        $nextStudent = Student::where('class_id', $request->class_id)
            ->where('section_id', $request->section_id)
            ->where('id', '>', $request->current_student_id)
            ->orderBy('id')
            ->first();

        if (!$nextStudent) {
            return response()->json(['done' => true]);
        }

        $subjects = ClassSubject::with('subject')
            ->where('class_id', $request->class_id)
            ->get();

        return response()->json([
            'done' => false,
            'view' => view('page.teacher.examinations.marks-form', [
                'student' => $nextStudent,
                'subjects' => $subjects,
                'exam_master_id' => $request->exam_master_id,
                'class_id' => $request->class_id,
                'section_id' => $request->section_id,
            ])->render()
        ]);
    }

    public function getSections($class_id)
    {
        return response()->json(
            Section::where('class_id', $class_id)->get()
        );
    }

    public function marksList(Request $request)
    {
        $exams = ExamMaster::all();
        $classes = ClassModel::all();
        $sections = [];

        $students = collect();
        $subjects = collect();
        $marks = collect();

        if (!$request->isMethod('post') && session()->has('filters')) {
            $request->merge(session('filters'));  // simulate POST
        }

        if ($request->filled(['class_id', 'section_id', 'exam_master_id'])) {
            $students = Student::where('class_id', $request->class_id)
                ->where('section_id', $request->section_id)
                ->get();

            $marks = MarksEntry::with(['student', 'subject', 'exam'])
                ->whereIn('student_id', $students->pluck('id'))
                ->where('exam_master_id', $request->exam_master_id)
                ->get();

            $subjects = ClassSubject::with('subject')
                ->where('class_id', $request->class_id)
                ->get();

            $sections = Section::where('class_id', $request->class_id)->get();
        }

        return view('page.teacher.examinations.marks-list', [
            'exams' => $exams,
            'classes' => $classes,
            'sections' => $sections,
            'marks' => $marks,
            'students' => $students,
            'subjects' => $subjects,
            'selected_exam' => $request->exam_master_id ?? null,
            'selected_class' => $request->class_id ?? null,
            'selected_section' => $request->section_id ?? null,
        ]);
    }

    public function editMarksEntry($student_id, $exam_id)
    {
        $student = Student::findOrFail($student_id);
        $subjects = ClassSubject::with('subject')
            ->where('class_id', $student->class_id)
            ->get();

        $marks = MarksEntry::where('student_id', $student_id)
            ->where('exam_master_id', $exam_id)
            ->pluck('marks_obtained', 'subject_id');

        return view('page.teacher.examinations.edit-marks-form', compact('student', 'subjects', 'marks', 'exam_id'));
    }

    public function updateMarksEntry(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'exam_master_id' => 'required|exists:exam_masters,id',
            'subject_marks' => 'required|array',
        ]);

        $teacherId = Auth::user()->teacher->id ?? Auth::id();

        foreach ($request->subject_marks as $subject_id => $marks) {
            MarksEntry::updateOrCreate(
                [
                    'student_id' => $request->student_id,
                    'subject_id' => $subject_id,
                    'exam_master_id' => $request->exam_master_id,
                ],
                [
                    'marks_obtained' => $marks,
                    'teacher_id' => $teacherId,
                ]
            );
        }

        $student = Student::find($request->student_id);

        session()->flash('filters', [
            'exam_master_id' => $request->exam_master_id,
            'class_id' => $student->class_id,
            'section_id' => $student->section_id,
        ]);

        return redirect()->route('marks.list');
    }

    public function deleteMarksEntry(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'exam_master_id' => 'required|exists:exam_masters,id',
        ]);

        MarksEntry::where('student_id', $request->student_id)
            ->where('exam_master_id', $request->exam_master_id)
            ->delete();

        $student = Student::find($request->student_id);

        session()->flash('filters', [
            'exam_master_id' => $request->exam_master_id,
            'class_id' => $student->class_id,
            'section_id' => $student->section_id,
        ]);

        return redirect()->route('marks.list')->with('success', 'Marks deleted successfully.');
    }

   public function viewResult(Request $request)
{
    $student = auth()->user()->student;
    $exams = ExamMaster::all();

    $exam = null;
    $subjects = collect();
    $marks = collect();

    if ($request->filled('exam_master_id')) {
        $exam = ExamMaster::find($request->exam_master_id);

        // Fetch subjects assigned to the student's class
        $subjects = ClassSubject::where('class_id', $student->class_id)
            ->with('subject')
            ->get();

        // Fetch marks entries for this student and exam
        $marks = \App\Models\MarksEntry::where('student_id', $student->id)
            ->where('exam_master_id', $exam->id)
            ->get()
            ->keyBy('subject_id'); // Easier to access in Blade
    }

    return view('page.student.myresult', compact('exams', 'exam', 'subjects', 'marks'));
}

public function printResult(Request $request)
{
    $examId = $request->input('exam_master_id') ?? $request->input('exam_id');
    $studentId = $request->input('student_id');

    if (auth()->check() && auth()->user()->role === 'student') {
        // If student is logged in
        $student = auth()->user()->student;
        $isTeacherView = false;
    } elseif ($studentId) {
        // If teacher is printing
        $student = Student::findOrFail($studentId);
        $isTeacherView = true;
    } else {
        abort(404, 'Student not found.');
    }

    $exam = ExamMaster::findOrFail($examId);

    $subjects = ClassSubject::where('class_id', $student->class_id)->with('subject')->get();

    $marks = MarksEntry::where('student_id', $student->id)
        ->where('exam_master_id', $examId)
        ->get()
        ->keyBy('subject_id');

    return view('page.student.print-result', compact('student', 'exam', 'subjects', 'marks', 'isTeacherView'));
}


public function printMarksheet(Request $request, $studentId, $examId)
{
    $student = Student::findOrFail($studentId);
    $exam = ExamMaster::findOrFail($examId);

    $subjects = ClassSubject::where('class_id', $student->class_id)->with('subject')->get();

    $marks = MarksEntry::where('student_id', $student->id)
        ->where('exam_master_id', $examId)
        ->get()
        ->keyBy('subject_id');

    $isTeacherView = true;

    return view('page.teacher.examinations.print-marksheet', compact('student', 'exam', 'subjects', 'marks', 'isTeacherView'));
}

}

