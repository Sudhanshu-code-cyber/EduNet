<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function dashboard(){
        return view('page.student.dashboard');
    }

     public function myclass(){
        return view('page.student.myclass');
    }

    public function showTimetable()
{
    $timetable = [
        ['day' => 'Monday', 'subject' => 'Math', 'teacher' => 'Mr. Sharma', 'start_time' => '09:00 AM', 'end_time' => '10:00 AM'],
        ['day' => 'Tuesday', 'subject' => 'Hindi', 'teacher' => 'Ms. Verma', 'start_time' => '10:15 AM', 'end_time' => '11:15 AM'],
        ['day' => 'Wednesday', 'subject' => 'mathmatics', 'teacher' => 'Ms. Verma', 'start_time' => '10:15 AM', 'end_time' => '11:15 AM'],
        ['day' => 'thursday', 'subject' => '', 'teacher' => 'Ms. Verma', 'start_time' => '10:15 AM', 'end_time' => '11:15 AM'],
        ['day' => 'Friday', 'subject' => 'Science', 'teacher' => 'Mr. Rakesh', 'start_time' => '09:00 AM', 'end_time' => '10:00 AM'],
        ['day' => 'saturday', 'subject' => 'Science', 'teacher' => 'Mr. Rakesh', 'start_time' => '09:00 AM', 'end_time' => '10:00 AM'],
        ['day' => 'sunday', 'subject' => '', 'teacher' => 'Mr. Rakesh', 'start_time' => '09:00 AM', 'end_time' => '10:00 AM'],
        // Add more entries...
    ];

    return view('page.student.myclass', compact('timetable'));
}


 public function attendance(){
        return view('page.student.attendance');
    }


     public function assignment(){
        return view('page.student.assignment');
    }


}
