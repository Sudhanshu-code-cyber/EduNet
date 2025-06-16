<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
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
        $subjects = Subject::with('class')->get();
        return view('page.admin.subjects.index', compact('subjects', 'classes'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'name' => 'required|string',
            'code' => 'nullable|string'
        ]);
        Subject::create($request->all());
        return back()->with('success', 'Subject added!');
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

}
