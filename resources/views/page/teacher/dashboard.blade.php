@extends('page.teacher.parent')

@section('content')
    {{-- Tailwind and FontAwesome --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    {{-- Tailwind Config --}}
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4f46e5',
                        secondary: '#818cf8',
                        accent: '#f9a826',
                        light: '#f8fafc',
                        dark: '#1e293b',
                    },
                },
            },
        };
    </script>

    <div class="py-5 px-4 md:px-8 max-w-7xl mx-auto min-h-screen space-y-8 mt-[-20px]">
        <!-- Welcome Section -->
        <div class="bg-white p-6 rounded-2xl shadow-md flex justify-between items-center ">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Welcome back, <span class="text-primary">{{auth()->user()->name}}</span>!
                </h1>
                <p class="text-sm text-gray-500 mt-2">
                    You’re making a difference. Keep inspiring minds every day!
                </p>
            </div>
            <div class="text-right hidden md:block">
                <span class="inline-block bg-indigo-100 text-indigo-600 text-sm px-3 py-1 rounded-full font-medium">
                    Today is {{ now()->format('l, M j') }}
                </span>
            </div>
        </div>

       <!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @foreach ($stats as $stat)
        <div class="bg-white p-6 rounded-2xl shadow-md border-l-4 border-{{ $stat['color'] }}">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 font-medium">{{ $stat['label'] }}</p>
                    <h2 class="text-3xl font-bold mt-2">
                        {{ str_pad($stat['value'], 2, '0', STR_PAD_LEFT) }}
                    </h2>
                </div>
                <div class="p-4 rounded-full bg-{{ $stat['bg'] }}">
                    <i class="fas fa-{{ $stat['icon'] }} text-{{ $stat['color'] }} text-2xl"></i>
                </div>
            </div>
        </div>
    @endforeach
</div>


        <!-- Schedule & Notice Board -->
        <div class="flex flex-col lg:flex-row gap-6 h-52">
            <!-- Schedule -->
      <div class="bg-white p-6 rounded-xl shadow-md w-full lg:w-1/2 border-l-4 border-primary">
    <h2 class="text-lg font-semibold text-primary mb-4">📅 Today's Schedule</h2>
  <ul class="text-sm text-gray-700 space-y-2">
    @forelse ($todaysSchedule as $schedule)
        <li>
            ✅ {{ $schedule->period->start_time }} - 
            {{ $schedule->class->name }} {{ $schedule->section->name }} - 
            {{ $schedule->subject->name }}
        </li>
    @empty
        <li>No schedule for today.</li>
    @endforelse
</ul>
</div>


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
    </div>

        <!-- Quick Actions -->
        <div>
            <h2 class="text-xl font-bold text-gray-800 mb-4">🚀 Quick Actions</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    @php
        $actions = [
            [
                'label' => 'Student List', 
                'icon' => 'users', 
                'color' => 'indigo-600', 
                'bg' => 'indigo-100',
                'url' => '/teacher/student-list' // Replace with your actual route
            ],
            [
                'label' => 'Send Homework', 
                'icon' => 'book-open', 
                'color' => 'purple-600', 
                'bg' => 'purple-100',
                'url' => '/teacher/homework'// Replace with your actual route
            ],
            [
                'label' => 'Exam Schedule', 
                'icon' => 'calendar-alt', 
                'color' => 'orange-600', 
                'bg' => 'orange-100',
                'url' => '/teacher/exam-schedule/create' // Replace with your actual route
            ],
            [
                'label' => 'Send Notice', 
                'icon' => 'bullhorn', 
                'color' => 'green-600', 
                'bg' => 'green-100',
                'url' => '/teacher/notice' // Replace with your actual route
            ],
        ];
    @endphp

    @foreach ($actions as $action)
        <a href="{{ $action['url'] }}" 
           class="block bg-white p-5 rounded-xl shadow-md border border-gray-100 hover:shadow-lg group hover:border-{{ $action['color'] }} transition transform hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-{{ $action['color'] }} focus:ring-opacity-50">
            <div class="flex flex-col items-center">
                <div class="w-14 h-14 rounded-full flex items-center justify-center bg-{{ $action['bg'] }} group-hover:bg-{{ $action['color'] }} transition-colors duration-300">
                    <i class="fas fa-{{ $action['icon'] }} text-{{ $action['color'] }} text-xl group-hover:text-white transition-colors duration-300"></i>
                </div>
                <span class="mt-3 font-medium text-gray-700 group-hover:text-{{ $action['color'] }} transition-colors duration-300">
                    {{ $action['label'] }}
                </span>
            </div>
        </a>
    @endforeach
</div>
        </div>
    </div>

    <!-- Side by Side Cards -->

    

    </div>

</div>
@endsection
