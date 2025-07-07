@extends('page.student.parent')

@section('content')
<div class="py-6 space-y-6">
    <!-- Greeting Box with Animated Background -->
    <div class="relative w-full bg-gradient-to-r from-indigo-600 to-blue-700 p-6 rounded-2xl shadow-lg text-white overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/always-grey.png')] opacity-10"></div>
        <div class="relative z-10">
            <h1 class="text-2xl md:text-3xl font-bold flex items-center gap-3">
                <span class="bg-white/20 p-2 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
                Welcome back, {{ auth()->user()->name }}!
            </h1>
            <p class="text-sm opacity-90 mt-2">Here's what's happening with your studies today.</p>
            <div class="absolute right-4 top-4 opacity-20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Summary Boxes with Icons -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white rounded-xl shadow-sm p-5 hover:shadow-md transition-all duration-300 border-l-4 border-indigo-500 group">
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-sm text-gray-500 font-medium mb-1">Notice</h2>
                <p class="text-3xl font-extrabold text-indigo-600">
    {{ str_pad($countNotice, 2, '0', STR_PAD_LEFT) }}
</p>
                </div>
                <div class="p-2 bg-indigo-100 rounded-lg text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
            <div class="mt-3">
                <a href="{{route('student.notice')}}" class="text-xs font-medium text-indigo-600 hover:underline flex items-center gap-1">
                    View All Notice
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-5 hover:shadow-md transition-all duration-300 border-l-4 border-green-500 group">
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-sm text-gray-500 font-medium mb-1">Homework</h2>
             <p class="text-3xl font-extrabold text-green-600">
    {{ str_pad($homeworkCount, 2, '0', STR_PAD_LEFT) }}
</p>
                </div>
                <div class="p-2 bg-green-100 rounded-lg text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <div class="mt-3">
                <a href="{{ route('student.homework.index') }}" class="text-xs font-medium text-green-600 hover:underline flex items-center gap-1">
                    View homework
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>

      <div class="bg-white rounded-xl shadow-sm p-5 hover:shadow-md transition-all duration-300 border-l-4 border-emerald-500 group">
    <div class="flex items-start justify-between">
        <div>
            <h2 class="text-sm text-gray-500 font-medium mb-1">Attendance</h2>
            <p class="text-3xl font-extrabold text-emerald-600">{{ $overallPercentage }}%</p>
        </div>
        <div class="p-2 bg-emerald-100 rounded-lg text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
    </div>
    <div class="mt-3">
        <div class="w-full bg-gray-200 rounded-full h-1.5">
            <div class="bg-emerald-600 h-1.5 rounded-full transition-all duration-500" style="width: {{ $overallPercentage }}%"></div>
        </div>
        <p class="text-xs text-gray-500 mt-1">
            {{ $overallPercentage > 85 ? 'Better than 85% of your class' : 'Try to improve!' }}
        </p>
    </div>
</div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Upcoming Exam Schedule -->
        <div class="bg-white shadow-sm rounded-2xl overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-indigo-600 to-blue-600 px-6 py-4">
                <h2 class="text-lg font-semibold text-white flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Upcoming Exam Schedule
                </h2>
            </div>
            <a href="{{route('student.examschedule')}}">
                <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium">Subject</th>
                            <th class="px-4 py-3 text-left font-medium">Date</th>
                            <th class="px-4 py-3 text-left font-medium">Time</th>
                            <th class="px-4 py-3 text-left font-medium">Room</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($examSchedules as $exam)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 font-medium text-gray-800">{{ $exam->subject->name ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ \Carbon\Carbon::parse($exam->exam_date)->format('M d, Y') }}</td>
                            <td class="px-4 py-3 text-gray-600">
                                <span class="bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full text-xs">
                                    {{ $exam->start_time }} - {{ $exam->end_time }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $exam->room_no }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            </a>
            @if($examSchedules->isEmpty())
            <div class="p-6 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No upcoming exams</h3>
                <p class="mt-1 text-sm text-gray-500">You're all caught up for now!</p>
            </div>
            @endif
        </div>

        <!-- Notice Board -->
       <!-- Add this in your layout once -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style>
    [x-cloak] { display: none; }
</style>

<!-- Notice Board Component -->
<div class="bg-white shadow-sm rounded-2xl overflow-hidden border border-gray-100">
    <!-- Header -->
    <div class="bg-gradient-to-r from-indigo-600 to-blue-600 px-6 py-4">
        <h2 class="text-lg font-semibold text-white flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
            </svg>
            Notice Board
        </h2>
    </div>

    <!-- Body -->
    <div class="p-4 space-y-4">
        @forelse ($latestNotices as $note)
            <div x-data="{ showModal: false }" class="relative">
                <div @click="showModal = true"
                    class="bg-gray-50 rounded-lg p-4 border border-gray-100 hover:shadow transition cursor-pointer">
                    <div class="flex items-start gap-3">
                        <div class="bg-indigo-100 p-2 rounded-lg text-indigo-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-semibold text-gray-900">{{ $note->title }}</h3>
                                <span class="text-xs text-gray-500">{{ $note->date }}</span>
                            </div>
                            <p class="mt-1 text-sm text-gray-600 line-clamp-2">{{ $note->description }}</p>
                            <div class="mt-2 text-xs text-gray-500">
                                Posted by:  {{ $note->creator->name ?? 'Unknown' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div x-show="showModal" x-cloak x-transition
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                    <div @click.outside="showModal = false"
                        class="bg-white rounded-lg max-w-lg w-full p-6 shadow-xl relative z-50">
                        <div class="flex items-start gap-4">
                            <div class="bg-indigo-100 p-2 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $note->title }}</h3>
                                <p class="mt-2 text-sm text-gray-600">
                                    {{ $note->details }}
                                </p>
                                <div class="mt-4 text-xs text-gray-400">
                                    Posted on {{ $note->date }} by {{ $note->posted_by }}
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 text-right">
                            <button @click="showModal = false"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="p-8 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No notices available</h3>
                <p class="mt-1 text-sm text-gray-500">Check back later for updates</p>
            </div>
        @endforelse

       
    </div>
</div>

    </div>
</div>
@endsection