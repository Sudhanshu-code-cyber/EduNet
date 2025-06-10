@extends('page.teacher.parent')

@section('content')
<div class="py-10 px-4 space-y-6">

    <!-- Welcome -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h1 class="text-2xl font-semibold text-gray-800">Welcome back, <span class="text-indigo-600">Ms. Briganza</span>! </h1>
        <p class="text-sm text-gray-500 mt-1">Hope you're ready for a productive teaching day.</p>
    </div>

    <!-- Feature Tiles -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- Today's Schedule -->
        <div class="bg-white border-l-4 border-indigo-500 p-4 rounded shadow">
            <h2 class="text-md font-semibold text-indigo-600 mb-1">📅 Today's Schedule</h2>
            <ul class="text-sm text-gray-700 space-y-1">
                <li>10:00 AM - Class 5B - Science</li>
                <li>12:00 PM - Class 6A - Biology</li>
                <li>2:00 PM - Meeting with Principal</li>
            </ul>
        </div>

        <!-- Upload Class Material -->
        <div class="bg-white border-l-4 border-yellow-500 p-4 rounded shadow">
            <h2 class="text-md font-semibold text-yellow-600 mb-1">📚 Upload Class Material</h2>
            <p class="text-sm text-gray-700">Upload PDF, PPT or Video files for students.</p>
        </div>

        <!-- View Student Performance -->
        <div class="bg-white border-l-4 border-green-500 p-4 rounded shadow">
            <h2 class="text-md font-semibold text-green-600 mb-1">📊 View Student Performance</h2>
            <p class="text-sm text-gray-700">Track class performance & subject-wise reports.</p>
        </div>

        <!-- Attendance -->
        <div class="bg-white border-l-4 border-blue-500 p-4 rounded shadow">
            <h2 class="text-md font-semibold text-blue-600 mb-1">✅ Mark Attendance</h2>
            <p class="text-sm text-gray-700">Easily mark student attendance in real-time.</p>
        </div>

        <!-- Send Notice -->
        <div class="bg-white border-l-4 border-rose-500 p-4 rounded shadow">
            <h2 class="text-md font-semibold text-rose-600 mb-1">📢 Send Notices</h2>
            <p class="text-sm text-gray-700">Send updates or reminders to classes instantly.</p>
        </div>

        <!-- Student List -->
        <div class="bg-white border-l-4 border-gray-500 p-4 rounded shadow">
            <h2 class="text-md font-semibold text-gray-700 mb-1">👥 Student List</h2>
            <p class="text-sm text-gray-600">View and manage all students in your class.</p>
        </div>
    </div>

    <!-- Notice Board + My Class Table Side by Side -->
    <div class="flex flex-col lg:flex-row gap-6 h-64">

        <!-- Notice Board -->
        <div class="bg-white p-4 rounded shadow w-full lg:w-1/2 ">
            <h2 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-3">📋 Notice Board</h2>
            <ul class="list-disc pl-5 text-sm text-gray-700 space-y-1">
                <li>Parent-Teacher Meeting on Friday at 3 PM</li>
                <li>Science Project Submission due next Monday</li>
                <li>School Annual Day preparations start next week</li>
            </ul>
        </div>

        <!-- My Class Table -->
        <div class="bg-white p-4 rounded shadow overflow-x-auto w-full lg:w-1/2">
            <h2 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">🏫 My Classes</h2>
            <table class="table-auto w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-2 border">Class</th>
                        <th class="px-4 py-2 border">Subject</th>
                        <th class="px-4 py-2 border">Section</th>
                        <th class="px-4 py-2 border">Schedule</th>
                        <th class="px-4 py-2 border">Time</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border">5</td>
                        <td class="px-4 py-2 border">Science</td>
                        <td class="px-4 py-2 border">B</td>
                        <td class="px-4 py-2 border">Mon, Wed</td>
                        <td class="px-4 py-2 border">10:00 - 10:45 AM</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border">6</td>
                        <td class="px-4 py-2 border">Biology</td>
                        <td class="px-4 py-2 border">A</td>
                        <td class="px-4 py-2 border">Tue, Thu</td>
                        <td class="px-4 py-2 border">12:00 - 12:45 PM</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

</div>
@endsection
