@extends('page.student.parent')

@section('content')
    <div class="py-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Exam Schedule</h1>
                <p class="text-gray-600">View all your upcoming examinations</p>
            </div>

        </div>

        <!-- Exam Schedule Table -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Exam
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Subject</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date
                                & Time</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Duration</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Marks
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Teacher</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($examSchedules as $exam)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-medium text-gray-900">{{ $exam->exam->exam_name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-medium text-gray-900">{{ $exam->subject->name ?? 'N/A' }}</div>
                                    <div class="text-xs text-gray-500">{{ $exam->subject->code ?? '' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-medium text-gray-900">
                                        {{ \Carbon\Carbon::parse($exam->exam_date)->format('D, M d, Y') }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        <span class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full text-xs">
                                            {{ $exam->start_time }} - {{ $exam->end_time }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                    {{ $exam->duration }} mins
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ $exam->room_no }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <div class="w-16 bg-gray-200 rounded-full h-1.5">
                                            <div class="bg-blue-600 h-1.5 rounded-full"
                                                style="width: {{ ($exam->min_marks / $exam->max_marks) * 100 }}%"></div>
                                        </div>
                                        <span class="text-sm text-gray-700">
                                            {{ $exam->min_marks }}/{{ $exam->max_marks }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">

                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">{{ $exam->teacher->first_name }}
                                                {{ $exam->teacher->last_name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Empty State -->
            @if ($examSchedules->isEmpty())
                <div class="p-12 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No exam schedules found</h3>
                    <p class="mt-1 text-sm text-gray-500">Your upcoming exams will appear here when scheduled.</p>
                </div>
            @endif

            <!-- Pagination -->
            @if ($examSchedules->hasPages())
                <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Showing
                                <span class="font-medium">{{ $examSchedules->firstItem() }}</span>
                                to
                                <span class="font-medium">{{ $examSchedules->lastItem() }}</span>
                                of
                                <span class="font-medium">{{ $examSchedules->total() }}</span>
                                results
                            </p>
                        </div>
                        <div>
                            {{-- Laravel Pagination Links with Tailwind --}}
                            {{ $examSchedules->links('vendor.pagination.tailwind') }}
                        </div>
                    </div>
                </div>
            @endif

        </div>

        <!-- Upcoming Exams Card -->

    </div>
@endsection
