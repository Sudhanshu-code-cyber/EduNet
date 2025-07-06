@extends('page.teacher.parent')

@section('content')
<div class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-7xl mx-auto">

        <h1 class="text-4xl font-bold text-blue-800 mb-6">📥 Homework Submission Report</h1>

        <!-- Search Homework Report Form -->
     <form method="GET" action="{{ route('teacher.homework.report') }}" class="p-6 bg-white shadow-md rounded-lg mb-8">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Class Dropdown -->
        <select name="class" id="class-dropdown" class="border border-gray-300 rounded-md p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Select Class</option>
            @foreach($assignedClasses as $class)
                <option value="{{ $class->id }}" {{ (string) request('class') === (string) $class->id ? 'selected' : '' }}>
                    {{ $class->name }}
                </option>
            @endforeach
        </select>

        <!-- Section Dropdown -->
        <select name="section" id="section-dropdown" class="border border-gray-300 rounded-md p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Select Section</option>
            @if(request('class') && request('section') && $selectedSection)
                <option value="{{ $selectedSection->id }}" selected>{{ $selectedSection->name }}</option>
            @endif
        </select>

        <!-- Subject Input -->
        <input type="text" name="subject" placeholder="Subject"
            class="border border-gray-300 rounded-md p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">

        <!-- Submission Date -->
        <input type="date" name="submission_date"
            class="border border-gray-300 rounded-md p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

<div class="mt-6 flex justify-end gap-3">
    @if(request()->has('class') || request()->has('section') || request()->has('subject') || request()->has('submission_date'))
        <!-- Show Reset button only when any filter is active -->
        <a href="{{ route('teacher.homework.report') }}"
           class="inline-flex items-center px-6 py-2 bg-gray-300 text-gray-800 font-semibold rounded-md hover:bg-gray-400">
             Reset
        </a>
    @endif

    <!-- Always show Search button -->
    <button type="submit"
        class="inline-flex items-center px-6 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
         Search
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    const classDropdown = document.getElementById('class-dropdown');
    const sectionDropdown = document.getElementById('section-dropdown');

    classDropdown.addEventListener('change', function () {
        const selectedClass = this.value;

        sectionDropdown.innerHTML = '<option value="">Loading...</option>';

        fetch(`/teacher/homework/get-sections-by-class?class_id=${selectedClass}`)
            .then(response => response.json())
            .then(data => {
                let options = '<option value="">Select Section</option>';
                data.forEach(section => {
                    options += `<option value="${section.id}">${section.name}</option>`;
                });
                sectionDropdown.innerHTML = options;
            })
            .catch(error => {
                console.error('Error fetching sections:', error);
                sectionDropdown.innerHTML = '<option value="">Error loading</option>';
            });
    });
});
</script>

@endsection
