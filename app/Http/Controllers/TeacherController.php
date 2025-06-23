<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notice;

class TeacherController extends Controller
{
    
   public function dashboard()
{
    $latestNotices = Notice::where('creator_role', 'admin')
        ->where('target', 'teacher')
        ->where(function ($query) {
            $query->whereNull('expires_at')
                  ->orWhere('expires_at', '>=', now());
        })
        ->orderByDesc('date')
        ->take(3)
        ->get();

    return view('page.teacher.dashboard', compact('latestNotices'));
}
    
    

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
        'Wednesday' => [],
        'Thursday' => [],
        'Friday' => [],
        'Saturday' => [],
        'Sunday' => [],
    ];

    return view('page.teacher.timetable', compact('weeklyTimetable'));

}

public function noticeBoard()
{
    $notices = collect([
        (object)[
            'title' => 'Holiday Announcement',
            'details' => 'The school will remain closed on 15th August for Independence Day.',
            'posted_by' => 'Principal',
            'date' => '2025-08-15'
        ],
        (object)[
            'title' => 'Exam Schedule',
            'details' => "Midterm exams will start from 1st September.\nMake sure to collect your admit cards.",
            'posted_by' => 'Exam Department',
            'date' => '2025-08-25'
        ],
        (object)[
            'title' => 'PTM Notice',
            'details' => 'Parents are requested to attend the PTM on 5th September at 9 AM.',
            'posted_by' => 'Class Teacher',
            'date' => '2025-09-05'
        ]
    ]);

    return view('page.teacher.notices', compact('notices'));
}

public function studentlist(){
    return view('page.teacher.student-list');
}

public function homework(){
    return view('page.teacher.classwork.homework');
}

public function submission(){
    return view('page.teacher.classwork.submission');
}

//teacher edit profile work

public function teachereditProfile(){
     $teacher = auth()->user();

    return view('page.teacher.edit-profile',compact('teacher'));

}

public function updateProfile(Request $request)
{
    $request->validate([
        'contact' => 'required|string|max:20',
        'password' => 'nullable|string|min:6|confirmed',
    ]);
    
    $teacher = auth()->user();
    $teacher->contact = $request->contact;

    if ($request->password) {
        $teacher->password = bcrypt($request->password);
    }

    $teacher->save();

    return back()->with('success', 'Profile updated successfully!');
}



}
