<?php

namespace App\Http\Controllers;
use App\Models\ExamMaster;

use Illuminate\Http\Request;

class ExamController extends Controller
{
    
    public function exam()
    {
        $exams = ExamMaster::all();  // fetch all exams
        return view('page.teacher.examinations.exam', compact('exams'));
    }

    public function marksentry(){
        $student = [
            'name' => 'Riya Sharma',
            'subjects' => [
                ['name' => 'Mathematics', 'marks' => 55],
                ['name' => 'Science', 'marks' => 48],
                ['name' => 'English', 'marks' => 50],
                ['name' => 'Hindi', 'marks' => 52],
                ['name' => 'SST', 'marks' => 49],
                ['name' => 'Sanskrit', 'marks' => 51],
            ],
            'total' => 600,
            'obtained' => 305,
            'result' => 'Pass',
            'percentage' => '50.8%',
        ];
        return view('page.teacher.marks-entry',compact('student'));
    }

    public function examschedule(){
        return view('page.teacher.examinations.exam-schedule');
    }
}
