<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        return view('page.teacher.attendance');
    }
    /**
     * Process the attendance filter form submission and return the filtered attendance data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'class' => 'required|integer',
            'section' => 'required|string',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer',
        ]);
        // Extract the validated data
        $class = $validatedData['class'];
        $section = $validatedData['section'];
                // Extract the validated data
                $class = $validatedData['class'];
                $section = $validatedData['section'];
                $month = $validatedData['month'];
                $year = $validatedData['year'];
                // Get the list of students for the selected class and section
                $students = DB::table('students') // Assuming you have a 'students' table
                    ->where('class_id', $class)
                    ->where('section', $section)
                    ->get();
                // Get the attendance records for the selected class, section, month, and year
                $attendanceRecords = DB::table('attendance') // Assuming you have an 'attendance' table
                    ->where('class_id', $class)
                    ->where('section_id', $section)
                    ->whereMonth('date', $month)
                    ->whereYear('date', $year)
                    ->get();
                // Prepare the attendance data for the view
                $attendanceData = [];
                foreach ($students as $student) {
                    $attendanceData[$student->id] = [];
                    for ($day = 1; $day <= Carbon::create($year, $month)->daysInMonth; $day++) {
                        $date = Carbon::create($year, $month, $day)->toDateString();
                        $record = $attendanceRecords->where('student_id', $student->id)->where('date', $date)->first();
                        $attendanceData[$student->id][$date] = $record ? $record->present : false; // Default to absent if no record
                    }
                }
                // Pass the data to the view
                return view('attendance', [
                    'class' => $class,
                    'section' => $section,
                    'month' => $month,
                    'year' => $year,
                    'students' => $students,
                    'attendanceData' => $attendanceData,
                ]);
            }
            /**
             * Save the attendance data.
             *
             * @param  \Illuminate\Http\Request  $request
             * @return \Illuminate\Http\RedirectResponse
             */
            public function save(Request $request)
            {
                // Validate the request data
                $validatedData = $request->validate([
                    'class' => 'required|integer',
                    'section' => 'required|string',
                    'month' => 'required|integer|min:1|max:12',
                    'year' => 'required|integer',
                    'attendance' => 'required|array',
                    'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer',
            'attendance' => 'required|array',
            'attendance.*.student_id' => 'required|integer',
            'attendance.*.date' => 'required|date',
            'attendance.*.present' => 'required|boolean',
        ]);
        // Extract the validated data
        $class = $validatedData['class'];
        $section = $validatedData['section'];
        $month = $validatedData['month'];
        $year = $validatedData['year'];
        $attendanceData = $validatedData['attendance'];
        // Loop through the attendance data and save it to the database
        foreach ($attendanceData as $data) {
            // Check if an attendance record already exists for the student and date
            $existingRecord = DB::table('attendance')
                ->where('student_id', $data['student_id'])
                ->where('date', $data['date'])
                ->first();
            if ($existingRecord) {
                // Update the existing record
                DB::table('attendance')
                    ->where('id', $existingRecord->id)
                    ->update(['present' => $data['present']]);
            } else {
                // Create a new record
                DB::table('attendance')->insert([
                    'student_id' => $data['student_id'],
                    'class_id' => $class,
                    'section_id' => $section,
                    'date' => $data['date'],
                    'present' => $data['present'],
                ]);
            }
        }
        // Redirect back to the attendance page with a success message
        return redirect()->route('attendance.index')->with('success', 'Attendance saved successfully!');
    }
}
