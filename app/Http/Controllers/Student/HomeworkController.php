<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Homework;
use App\Models\HomeworkSubmission;
use Illuminate\Support\Facades\Auth;
class HomeworkController extends Controller
{
    
   public function index()
{
    // Get the logged-in student
    $student = Student::where('user_id', Auth::id())->firstOrFail();

    // Fetch homeworks for the student's class & section, and filter student's own submissions
    $homeworks = Homework::with([
        'subject',
        'teacher.user',
        'submissions' => function ($query) use ($student) {
            $query->where('student_id', $student->id);
        }
    ])
    ->where('class_id', $student->class_id)
    ->where('section_id', $student->section_id)
    ->orderBy('homework_date', 'desc')
    ->get();

    // Assign submission status dynamically
    foreach ($homeworks as $homework) {
        $homework->submission_status = $homework->submissions->isNotEmpty() ? 'submitted' : 'pending';
    }

    // Count completed and pending homework
    $completed = $homeworks->where('submission_status', 'submitted')->count();
    $pending = $homeworks->where('submission_status', 'pending')->count();

    return view('page.student.student-homework', compact('homeworks', 'completed', 'pending'));
}


public function submit(Request $request)
{
    $request->validate([
        'homework_id' => 'required|exists:homework,id',
        'title' => 'required|string|max:255',
        'submitted_file' => 'nullable|file|mimes:pdf,docx,doc,jpg,png,avif|max:2048',
        'remarks' => 'nullable|string',
    ]);

    $student = Student::where('user_id', Auth::id())->firstOrFail();

    $data = $request->only(['homework_id', 'title', 'remarks']);
    $data['student_id'] = $student->id;
    $data['submitted_date'] = now();

    if ($request->hasFile('submitted_file')) {
        $file = $request->file('submitted_file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('homework_submissions'), $filename);
        $data['submitted_file'] = 'homework_submissions/' . $filename;
    }

    HomeworkSubmission::create($data);

    return back()->with('success', 'Homework submitted successfully!');
}
}
