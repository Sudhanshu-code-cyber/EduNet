@extends('page.teacher.parent')

@section('content')
<div class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-7xl mx-auto">

        <h1 class="text-4xl font-bold text-blue-800 mb-6">📥 Homework Submission Report</h1>

        <!-- Search Homework Report Form -->
        <form method="GET" action="" class="bg-white p-4 rounded-lg shadow mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Class Dropdown -->
                <select name="class" class="border border-gray-300 rounded-md p-2 w-full">
                    <option value="">Select Class</option>
                    <option value="Class 6">Class 6</option>
                    <option value="Class 7">Class 7</option>
                    <option value="Class 8">Class 8</option>
                </select>

                <!-- Section Dropdown -->
                <select name="section" class="border border-gray-300 rounded-md p-2 w-full">
                    <option value="">Select Section</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                </select>

                <!-- Subject Input -->
                <input type="text" name="subject" placeholder="Subject"
                    class="border border-gray-300 rounded-md p-2 w-full">

                <!-- Submission Date -->
                <input type="date" name="submission_date"
                    class="border border-gray-300 rounded-md p-2 w-full">
            </div>

            <div class="mt-4 flex justify-end">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                    🔍 Search
                </button>
            </div>
        </form>

        <!-- Dynamic Homework Submissions Table -->
        @forelse($homeworks as $homework)
            <div class="bg-white rounded-lg shadow p-4 mb-8">
                <h2 class="text-xl font-bold text-indigo-700 mb-4">
                    {{ $homework->title }} ({{ $homework->subject->name ?? 'N/A' }})
                </h2>

                <table class="min-w-full table-auto">
                    <thead class="bg-gray-100 text-gray-700 text-sm">
                        <tr>
                            <th class="p-4">Student Name</th>
                            <th class="p-4">Submitted File</th>
                            <th class="p-4">Submitted Date</th>
                            <th class="p-4">Marks</th>
                            <th class="p-4">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-600">
                        @forelse($homework->submissions as $submission)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-4">{{ $submission->student->full_name }}</td>
                                <td class="p-4">
                                    <a href="{{ asset($submission->submitted_file) }}" download
                                        class="inline-block px-3 py-1 text-sm bg-blue-500 text-white rounded hover:bg-blue-600">
                                        Download
                                    </a>
                                </td>
                                <td class="p-4">{{ \Carbon\Carbon::parse($submission->submitted_date)->format('Y-m-d') }}</td>
                                <td class="p-4">
                                    {{ $submission->marks_obtained ?? 'Not Graded' }}
                                </td>
                                <td class="p-4">
                                    <a href="#" class="text-blue-600 hover:underline">View</a>
                                    <a href="#" class="text-yellow-600 hover:underline">Grade</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center p-4 text-gray-400 italic">No submissions yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow p-6 text-center text-gray-500">
                No homework assigned yet.
            </div>
        @endforelse

    </div>
</div>
@endsection
