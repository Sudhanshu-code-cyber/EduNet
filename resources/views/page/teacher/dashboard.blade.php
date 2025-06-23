@extends('page.teacher.parent')

@section('content')
<div class="py-10 px-4 space-y-6 bg-gray-100 min-h-screen">

    <!-- Welcome -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold text-gray-800">Welcome back, <span class="text-indigo-600">{{auth()->user()->name}}</span>!</h1>
        <p class="text-sm text-gray-500 mt-2">Hope you're ready for a productive teaching day.</p>
    </div>

    <!-- Feature Tiles -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- Tile -->
        <div class="bg-white p-5 rounded-lg shadow border-l-4 border-indigo-500">
            <h2 class="text-lg font-semibold text-indigo-600 mb-2">📅 Today's Schedule</h2>
            <ul class="text-gray-700 text-sm space-y-1">
                <li>10:00 AM - Class 5B - Science</li>
                <li>12:00 PM - Class 6A - Biology</li>
                <li>2:00 PM - Meeting with Principal</li>
            </ul>
        </div>

        <div class="bg-white p-5 rounded-lg shadow border-l-4 border-yellow-500">
            <h2 class="text-lg font-semibold text-yellow-600 mb-2">📚 Upload Class Material</h2>
            <p class="text-sm text-gray-700">Upload PDF, PPT or video files for students.</p>
        </div>

        <div class="bg-white p-5 rounded-lg shadow border-l-4 border-green-500">
            <h2 class="text-lg font-semibold text-green-600 mb-2">📊 View Student Performance</h2>
            <p class="text-sm text-gray-700">Track class performance & subject-wise reports.</p>
        </div>

        <div class="bg-white p-5 rounded-lg shadow border-l-4 border-blue-500">
            <h2 class="text-lg font-semibold text-blue-600 mb-2">✅ Mark Attendance</h2>
            <p class="text-sm text-gray-700">Mark student attendance in real-time.</p>
        </div>

        <div class="bg-white p-5 rounded-lg shadow border-l-4 border-rose-500">
            <h2 class="text-lg font-semibold text-rose-600 mb-2">📢 Send Notices</h2>
            <p class="text-sm text-gray-700">Send updates or reminders to classes instantly.</p>
        </div>

        <div class="bg-white p-5 rounded-lg shadow border-l-4 border-gray-500">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">👥 Student List</h2>
            <p class="text-sm text-gray-600">View and manage all students in your class.</p>
        </div>
    </div>

    <!-- Side by Side Cards -->
    <div class="flex flex-col lg:flex-row gap-6">

        <!-- Notice Board -->
        <div class="bg-white w-full lg:w-1/2 p-5 rounded-lg shadow">
            <h2 class="text-xl font-bold text-gray-800 border-b pb-2 mb-4">📋 Notice Board</h2>
            <ul class="list-disc pl-5 text-sm text-gray-700 space-y-2">
                @forelse ($latestNotices as $notice)
                    <li>
                        <span class="font-medium text-gray-900">{{ $notice->title }}:</span>
                        {{ \Illuminate\Support\Str::limit($notice->details, 80) }}
                        <span class="text-xs text-gray-500 block">Date: {{ \Carbon\Carbon::parse($notice->date)->format('d M Y') }}</span>
                    </li>
                @empty
                    <li class="text-gray-500">No recent notices from admin.</li>
                @endforelse
            </ul>
            
        </div>

        <!-- My Classes Table -->
        <div class="bg-white w-full lg:w-1/2 p-5 rounded-lg shadow overflow-x-auto">
            <h2 class="text-xl font-bold text-gray-800 border-b pb-2 mb-4">🏫 My Classes</h2>
            <table class="table-auto w-full text-sm text-left border border-gray-200">
                <thead class="bg-gray-100">
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
