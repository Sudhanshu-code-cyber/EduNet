<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\ClassSubject;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{

    public function filter($class_id = null)
    {
        $subjects = Subject::with('class');

        if ($class_id) {
            $subjects->where('class_id', $class_id);
        }

        $subjects = $subjects->get();

        return view('page.admin.subjects.table', compact('subjects'));
    }


    public function index()
    {
        $classes = ClassModel::all();
        $subjects = Subject::with('class')->get(); // ✅ this loads the class relation
        $classSubjects = ClassSubject::all();
        return view('page.admin.subjects.index', compact('subjects', 'classes', 'classSubjects'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'max_marks' => 'required|integer|min:0',
            'pass_marks' => 'required|integer|min:0|lte:max_marks',
        ]);



        ClassSubject::create([
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'max_marks' => $request->max_marks,
            'pass_marks' => $request->pass_marks,
        ]);

        return back()->with('success', 'Subject assigned to class successfully!');
    }

    public function update(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);
        $subject->update($request->all());
        return back()->with('success', 'Subject updated!');
    }

    public function destroy($id)
    {
        Subject::findOrFail($id)->delete();
        return back()->with('success', 'Subject deleted!');
    }

    public function getByClass($id)
    {
        $subjects = Subject::where('class_id', $id)->select('id', 'name', 'code')->get();
        return response()->json($subjects);
    }

    public function sub_index()
    {
        $subjects = Subject::all();
        return view('page.admin.subjects.subject', compact('subjects'));
    }

    public function sub_store(Request $request)
    {
        // Validate both 'name' and 'code'
        $request->validate([
            'name' => 'required|string',
            'code' => 'nullable|string',
        ]);

        // Store only 'name' and 'code'
        Subject::create($request->only('name', 'code'));

        return redirect()->back()->with('success', 'Subject added!');
    }


    public function sub_update(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);
        $subject->update($request->only('name'));
        return redirect()->back()->with('success', 'subject added!');
    }

    public function sub_destroy($id)
    {
        Subject::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'subject added!');
    }
}
