<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function myclass(){
    $classes = [
        [
            'id' => 1,
            'name' => 'Class 7',
            'section' => 'A',
            'subjects' => ['Mathematics', 'Science', 'English'],
            'student_count' => 32,
        ],
        [
            'id' => 2,
            'name' => 'Class 8',
            'section' => 'B',
            'subjects' => ['History', 'Geography', 'Civics'],
            'student_count' => 28,
        ],
        [
            'id' => 3,
            'name' => 'Class 9',
            'section' => 'C',
            'subjects' => ['Physics', 'Chemistry', 'Biology'],
            'student_count' => 30,
        ],
    ];
    return view('page.teacher.my-classes', compact('classes'));
}

    public function timetable()
{
    $weeklyTimetable = [
        'Monday' => [
            [
                'subject' => 'Math',
                'teacher' => 'Mr. Smith',
                'start_time' => '09:00',
                'end_time' => '10:00',
                'type' => 'class',
            ],
            [
                'subject' => 'Break',
                'teacher' => null,
                'start_time' => '10:00',
                'end_time' => '10:15',
                'type' => 'break',
            ],
            [
                'subject' => 'Physics',
                'teacher' => 'Ms. Johnson',
                'start_time' => '10:15',
                'end_time' => '11:15',
                'type' => 'class',
            ],
        ],
        'Tuesday' => [
            [
                'subject' => 'History',
                'teacher' => 'Mrs. Davis',
                'start_time' => '08:30',
                'end_time' => '09:30',
                'type' => 'class',
            ],
            [
                'subject' => 'Free Period',
                'teacher' => null,
                'start_time' => '09:30',
                'end_time' => '10:30',
                'type' => 'free',
            ],
        ],
        // ... other days of the week
        'Wednesday' => [],
        'Thursday' => [],
        'Friday' => [],
        'Saturday' => [],
        'Sunday' => [],
    ];

    return view('page.teacher.timetable', compact('weeklyTimetable'));

}

}
