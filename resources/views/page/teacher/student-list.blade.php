@extends('page.teacher.parent')

@section('content')
<div class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-semibold mb-8 text-gray-900">Student List</h1>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('teacher.student-list.index') }}" class="mb-6 flex flex-wrap gap-4">
            <select name="class_id" class="border px-4 py-2 rounded shadow-sm w-48">
                <option value="">-- Select Class --</option>
                @foreach($assignedClasses as $class)
                    <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                        {{ $class->name }}
                    </option>
                @endforeach
            </select>

            <select name="section_id" class="border px-4 py-2 rounded shadow-sm w-48">
                <option value="">-- Select Section --</option>
                @foreach($assignedSections as $section)
                    <option value="{{ $section->id }}" {{ request('section_id') == $section->id ? 'selected' : '' }}>
                        {{ $section->name }}
                    </option>
                @endforeach
            </select>

            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow-sm">Filter</button>
        </form>

        <!-- Student Table -->
        @if(count($students))
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full table-auto border-collapse">
                    <thead class="bg-gray-200 text-gray-800">
                        <tr>
                            <th class="px-6 py-3 text-left">#</th>
                            <th class="px-6 py-3 text-left">Name</th>
                            <th class="px-6 py-3 text-left">Roll No</th>
                            <th class="px-6 py-3 text-left">Gender</th>
                            <th class="px-6 py-3 text-left">Class</th>
                            <th class="px-6 py-3 text-left">Section</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach($students as $index => $student)
                            <tr class="border-t">
                                <td class="px-6 py-4">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">{{ $student->full_name }}</td>
                                <td class="px-6 py-4">{{ $student->roll_no }}</td>
                                <td class="px-6 py-4 capitalize">{{ $student->gender }}</td>
                                <td class="px-6 py-4">{{ $student->class->name }}</td>
                                <td class="px-6 py-4">{{ $student->section->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-600">No students found for the selected class and section.</p>
        @endif
    </div>
</div>
@endsection
