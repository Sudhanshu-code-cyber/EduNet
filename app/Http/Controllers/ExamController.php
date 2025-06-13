<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function exam(){
        return view('page.teacher.examinations.exam');
    }

    public function marksentry(){
        return view('page.teacher.marks-entry');
    }

    public function examschedule(){
        return view('page.teacher.examinations.exam-schedule');
    }
}
