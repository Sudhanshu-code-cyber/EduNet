<?php

namespace App\Http\Controllers;

use App\Models\TeacherTimetable;
use Illuminate\Http\Request;
use App\Models\Notice;

class TeacherController extends Controller
{
    
  public function dashboard()
{
    if (!auth()->check()) {
        return redirect()->route('login'); // make sure 'login' route exists
    }

    $latestNotices = Notice::where('creator_role', 'admin')
        ->where('target', 'teacher')
        ->where(function ($query) {
            $query->whereNull('expires_at')
                  ->orWhere('expires_at', '>=', now());
        })
        ->orderByDesc('created_at')
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

    public function timetable($teacher_id)
{
     $teacher = \App\Models\Teacher::findOrFail($teacher_id);

    // Fetch all timetables assigned to this teacher
    $timetables = TeacherTimetable::with(['class', 'section', 'subject', 'period'])
        ->where('teacher_id', $teacher_id)
        ->orderBy('day_of_week')
        ->orderBy('period_id')
        ->get();

    return view('page.teacher.timetable', compact('teacher', 'timetables'));


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


public function submission(){
    return view('page.teacher.classwork.submission');
}

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
