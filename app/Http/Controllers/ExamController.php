<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\ExamMaster;

use Illuminate\Http\Request;

class ExamController extends Controller
{
    
    public function exam()
    {
        $exams = ExamMaster::all();  // fetch all exams
        return view('page.teacher.examinations.exam', compact('exams'));
    }

    public function marksentry(Request $request)
    {
        $exams = ExamMaster::all();
        $classes = ClassModel::all();
    
        // Fix: always define $sections to avoid undefined variable error
        $sections = [];
    
        return view('page.teacher.marks-list', compact('exams', 'classes', 'sections'));
    }
    

    public function examschedule(){
        return view('page.teacher.examinations.exam-schedule');
    }
}
