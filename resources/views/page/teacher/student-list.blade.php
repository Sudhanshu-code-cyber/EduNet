@extends('page.teacher.parent')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Student Management</h1>
                <p class="text-gray-600">View and manage your class students</p>
            </div>
            <div class="mt-4 md:mt-0">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>
                    {{ $students->total() }} Students
                </span>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8 transition-all duration-300 hover:shadow-lg">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                </svg>
                Filter Students
            </h2>
            <form method="GET" action="{{ route('teacher.student-list.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Class Select -->
                <div>
                    <label for="class_id" class="block text-sm font-medium text-gray-700 mb-1">Class</label>
                    <div class="relative">
                        <select id="class_id" name="class_id" class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md shadow-sm">
                            <option value="">All Classes</option>
                            @foreach($assignedClasses as $class)
                                <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Section Select -->
                <div>
                    <label for="section_id" class="block text-sm font-medium text-gray-700 mb-1">Section</label>
                    <div class="relative">
                        <select id="section_id" name="section_id" class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md shadow-sm">
                            <option value="">All Sections</option>
                            @foreach($assignedSections as $section)
                                <option value="{{ $section->id }}" {{ request('section_id') == $section->id ? 'selected' : '' }}>
                                    {{ $section->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-end space-x-3">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        Apply Filters
                    </button>
                    <a href="{{ route('teacher.student-list.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Student Table Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
            @if($students->count())
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class Info</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($students as $index => $student)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ ($students->currentPage() - 1) * $students->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center overflow-hidden">
                                            @if($student->profile_pic)
                                                <img class="h-full w-full object-cover" src="{{ asset('storage/'.$student->profile_pic) }}" alt="{{ $student->full_name }}">
                                            @else
                                                <span class="text-blue-800 font-medium">{{ substr($student->full_name, 0, 1) }}</span>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $student->full_name }}</div>
                                            <div class="text-sm text-gray-500">ID: {{ $student->id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">Roll No: {{ $student->roll_no }}</div>
                                    <div class="text-sm text-gray-500 capitalize">{{ $student->gender }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $student->class->name }}</div>
                                    <div class="text-sm text-gray-500">Section {{ $student->section->name }}</div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No students found</h3>
                    <p class="mt-1 text-sm text-gray-500">Try adjusting your filters to find what you're looking for.</p>
                    <div class="mt-6">
                        <a href="{{ route('teacher.student-list.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            Reset Filters
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($students->hasPages())
        <div class="mt-6 bg-white px-4 py-3 rounded-b-lg shadow-sm">
            {{ $students->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Dynamic section loading
        $('#class_id').change(function () {
            const classId = $(this).val();
            const $sectionSelect = $('#section_id');
            
            $sectionSelect.html('<option value="">Loading...</option>');

            if (classId) {
                $.get(`/teacher/get-sections-by-class/${classId}`, function (sections) {
                    $sectionSelect.html('<option value="">All Sections</option>');
                    sections.forEach(function (section) {
                        $sectionSelect.append(`<option value="${section.id}">${section.name}</option>`);
                    });
                }).fail(function() {
                    $sectionSelect.html('<option value="">Error loading sections</option>');
                });
            } else {
                $sectionSelect.html('<option value="">All Sections</option>');
            }
        });

        // Add animation to table rows
        $('tbody tr').each(function(i) {
            $(this).delay(i * 50).fadeIn(300);
        });
    });
</script>
@endsection