<?php

namespace App\Http\Controllers;

use App\Models\TeacherTimetable;
use Illuminate\Http\Request;
use App\Models\Notice;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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

        $totalClasses = \App\Models\ClassModel::count(); // replace with your actual Class model
    $totalSubjects = \App\Models\Subject::count();
    $totalNotices = Notice::where('creator_role', 'admin')->where('target', 'teacher')->count();

    $stats = [
        ['label' => 'Total Classes', 'value' => $totalClasses, 'icon' => 'chalkboard-teacher', 'color' => 'blue-500', 'bg' => 'blue-100'],
        ['label' => 'Total Subjects', 'value' => $totalSubjects, 'icon' => 'book-open', 'color' => 'green-500', 'bg' => 'green-100'],
        ['label' => 'Total Notices', 'value' => $totalNotices, 'icon' => 'clipboard-list', 'color' => 'orange-500', 'bg' => 'orange-100'],
    ];

      $user = auth()->user();
    $teacher = \App\Models\Teacher::where('user_id', $user->id)->first();

    if (!$teacher) {
        abort(403, 'No teacher profile linked to this user.');
    }

    $today = Carbon::now()->format('l');

    $todaysSchedule = TeacherTimetable::with(['class', 'section', 'subject', 'period'])
        ->where('teacher_id', $teacher->id)
        ->where('day_of_week', $today)
        ->orderBy('period_id')
        ->get();

    return view('page.teacher.dashboard', compact('latestNotices','stats','todaysSchedule'));
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
    $user = Auth::user();
    $teacher = \App\Models\Teacher::where('user_id', $user->id)->first();

    if (!$teacher) {
        abort(403, 'No teacher profile linked to this user.');
    }

    $timetables = TeacherTimetable::where('teacher_id', $teacher->id)
                    ->with(['class', 'section', 'subject', 'period'])
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
