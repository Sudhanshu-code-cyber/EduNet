<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Homework;
use App\Models\Teacher;
use App\Models\AssignedTeacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class HomeworkController extends Controller
{

public function store(Request $request)
{
    $teacher = Teacher::where('user_id', Auth::id())->first();

    $request->validate([
        'class_id' => 'required',
        'section_id' => 'required',
        'subject_id' => 'required',
        'title' => 'required|string|max:255',
        'content' => 'required',
       'document' => 'nullable|file|mimes:pdf,docx,jpg,jpeg,png,avif|max:2048', 
        'homework_date' => 'required|date',
        'submission_date' => 'required|date|after_or_equal:homework_date',
    ]);

    $documentPath = null;
    if ($request->hasFile('document')) {
        $documentPath = $request->file('document')->store('homeworks', 'public');
    }

    Homework::create([
        'teacher_id' => $teacher->id,
        'class_id' => $request->class_id,
        'section_id' => $request->section_id,
        'subject_id' => $request->subject_id,
        'title' => $request->title,
        'content' => $request->content,
        'document' => $documentPath,
        'homework_date' => $request->homework_date,
        'submission_date' => $request->submission_date,
    ]);

    return redirect()->route('teacher.homework.index')->with('success', 'Homework Assigned Successfully!');
}

public function index(Request $request)
{
    $teacher = Teacher::where('user_id', Auth::id())->first();
    

    $query = Homework::query()->where('teacher_id', $teacher->id);

    if ($request->has('search') && $request->search != '') {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    $homeworks = $query->with(['class', 'section', 'subject', 'teacher'])->get();

    $assignedSubjects = AssignedTeacher::where('teacher_id', $teacher->id)
        ->with(['class', 'section', 'subject'])
        ->get();
        $initialSections = $assignedSubjects->unique('section_id')->pluck('section');
        $initialSubjects = $assignedSubjects->unique('subject_id')->pluck('subject');
    

    return view('page.teacher.classwork.homework', compact('homeworks', 'assignedSubjects','initialSections',
        'initialSubjects'));
}


public function search(Request $request)
{
    $search = $request->input('query');
    $teacher = Teacher::where('user_id', Auth::id())->first();

    $homeworks = Homework::where('teacher_id', $teacher->id)
        ->where('title', 'like', "%$search%")
        ->get();

    return view('page.teacher.classwork.homework', compact('homeworks'));
}

public function getSections($classId)
{
    $teacher = Teacher::where('user_id', Auth::id())->first();

    $sections = AssignedTeacher::where('teacher_id', $teacher->id)
        ->where('class_id', $classId)
        ->with('section')
        ->get()
        ->pluck('section')
        ->unique('id')
        ->values();

    return response()->json(['sections' => $sections->toArray()]);


}


public function getSubjects($classId, $sectionId)
{
    $teacher = Teacher::where('user_id', Auth::id())->first();

    $subjects = AssignedTeacher::where('teacher_id', $teacher->id)
        ->where('class_id', $classId)
        ->where('section_id', $sectionId)
        ->with('subject')
        ->get()
        ->pluck('subject')
        ->unique('id')
        ->values();

    return response()->json($subjects);
}

public function submissions()
{
    $teacher = Teacher::where('user_id', Auth::id())->firstOrFail();

    $homeworks = \App\Models\Homework::with(['submissions.student', 'subject', 'class', 'section'])
        ->where('teacher_id', $teacher->id)
        ->orderByDesc('created_at')
        ->get();

    return view('page.teacher.classwork.submission', compact('homeworks'));
}

}
