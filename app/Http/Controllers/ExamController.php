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

    public function examschedule(){
        return view('page.teacher.examinations.exam-schedule');
    }
}
