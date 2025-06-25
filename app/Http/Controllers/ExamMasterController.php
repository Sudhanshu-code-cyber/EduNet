<?php

namespace App\Http\Controllers;

use App\Models\ExamMaster;
use Illuminate\Http\Request;

class ExamMasterController extends Controller
{
    public function index()
    {
        $exams = ExamMaster::latest()->get();
        return view('page.teacher.examinations.exam', compact('exams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'exam_name' => 'required|string',
            'exam_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        ExamMaster::create($request->all());

        return redirect()->back()->with('success', 'Exam added successfully.');
    }

    public function destroy($id)
    {
        ExamMaster::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Exam deleted successfully.');
    }
}
