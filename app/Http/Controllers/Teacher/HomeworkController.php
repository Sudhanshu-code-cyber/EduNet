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

public function index()
{
    $teacher = auth()->user()->teacher;

    $homeworks = Homework::where('teacher_id', $teacher->id)
        ->with(['class', 'section', 'subject', 'teacher'])
        ->get();

    $assignedSubjects = \App\Models\AssignedTeacher::with(['class', 'section', 'subject'])
        ->where('teacher_id', $teacher->id)
        ->get();

    return view('page.teacher.classwork.homework', compact('homeworks', 'assignedSubjects'));
}

public function search(Request $request)
{
    $teacher = auth()->user()->teacher;

    $query = Homework::query()
        ->where('teacher_id', $teacher->id);

    if ($request->filled('search')) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('class_id')) {
        $query->where('class_id', $request->class_id);
    }

    if ($request->filled('section_id')) {
        $query->where('section_id', $request->section_id);
    }

    if ($request->filled('subject_id')) {
        $query->where('subject_id', $request->subject_id);
    }

    if ($request->filled('date')) {
        $query->whereDate('homework_date', $request->date);
    }

    $homeworks = $query->with(['class', 'section', 'subject', 'teacher'])->get();

    $assignedSubjects = AssignedTeacher::with(['class', 'section', 'subject'])
        ->where('teacher_id', $teacher->id)
        ->get();

    return view('page.teacher.classwork.homework', compact('homeworks', 'assignedSubjects'));
}

public function update(Request $request, $id)
{
    $homework = Homework::findOrFail($id);

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

    if ($request->hasFile('document')) {
        if ($homework->document && Storage::disk('public')->exists($homework->document)) {
            Storage::disk('public')->delete($homework->document);
        }
        $homework->document = $request->file('document')->store('homeworks', 'public');
    }

    $homework->update([
        'class_id' => $request->class_id,
        'section_id' => $request->section_id,
        'subject_id' => $request->subject_id,
        'title' => $request->title,
        'content' => $request->content,
        'homework_date' => $request->homework_date,
        'submission_date' => $request->submission_date,
    ]);

    return redirect()->route('teacher.homework.index')->with('success', 'Homework updated successfully.');
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

public function destroy($id)
{
    $homework = \App\Models\Homework::findOrFail($id);

    if ($homework->document && \Storage::disk('public')->exists($homework->document)) {
        \Storage::disk('public')->delete($homework->document);
    }

    $homework->delete();

    return redirect()->route('teacher.homework.index')->with('success', 'Homework deleted successfully.');
}


public function submissions()
{
    $teacher = Teacher::where('user_id', Auth::id())->firstOrFail();

    $homeworks = Homework::with(['submissions.student', 'subject', 'class', 'section'])
        ->where('teacher_id', $teacher->id)
        ->orderByDesc('created_at')
        ->get();

    // Fetch assigned classes
    $assignedClasses = AssignedTeacher::where('teacher_id', $teacher->id)
        ->with('class')
        ->get()
        ->pluck('class')
        ->unique('id')
        ->values();

    return view('page.teacher.classwork.submission', compact('homeworks', 'assignedClasses'));
}


public function report(Request $request)
{
    $teacher = Teacher::where('user_id', Auth::id())->first();

    // Get assigned class IDs
    $assignedClasses = AssignedTeacher::where('teacher_id', $teacher->id)
        ->with('class')
        ->get()
        ->pluck('class')
        ->unique('id')
        ->values();

    $query = Homework::with(['subject', 'submissions.student']);

    if ($request->filled('class_id')) {
        $query->where('class_id', $request->class_id);
    }

    if ($request->filled('section_id')) {
        $query->where('section_id', $request->section_id);
    }

    if ($request->filled('subject')) {
        $query->whereHas('subject', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->subject . '%');
        });
    }

    if ($request->filled('submission_date')) {
        $query->whereDate('submission_date', $request->submission_date);
    }

    $homeworks = $query->latest()->get();

    $selectedSection = null;

if ($request->filled('section_id')) {
    $selectedSection = \App\Models\Section::find($request->section_id);
}

    return view('page.teacher.classwork.submission', compact('homeworks', 'assignedClasses' ,'selectedSection'));
}

public function getSectionsByClass(Request $request)
{
    $teacher = Teacher::where('user_id', Auth::id())->first();
    $classId = $request->input('class_id');

    $sections = AssignedTeacher::where('teacher_id', $teacher->id)
        ->where('class_id', $classId)
        ->with('section')
        ->get()
        ->pluck('section')
        ->unique('id')
        ->values()
        ->map(function ($section) {
            return [
                'id' => $section->id,
                'name' => $section->name
            ];
        });

    return response()->json($sections);
}

}
