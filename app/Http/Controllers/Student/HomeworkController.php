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
        // Get the logged-in student's class and section
        $student = Student::where('user_id', Auth::id())->firstOrFail();

        // Fetch homeworks assigned to that class and section
        $homeworks = Homework::with(['subject', 'teacher.user'])
            ->where('class_id', $student->class_id)
            ->where('section_id', $student->section_id)
            ->orderBy('homework_date', 'desc')
            ->get();

        return view('page.student.student-homework', compact('homeworks'));
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
