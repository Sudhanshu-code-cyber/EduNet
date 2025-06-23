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

    <div class="py-5 px-4 md:px-8 max-w-7xl mx-auto min-h-screen space-y-8">
        <!-- Welcome Section -->
        <div class="bg-white p-6 rounded-2xl shadow-md flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Welcome back, <span class="text-primary">Ms. Briganza</span>!
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
            @php
                $stats = [
                    ['label' => 'Total Classes', 'value' => 5, 'icon' => 'chalkboard-teacher', 'color' => 'primary', 'bg' => 'indigo-100'],
                    ['label' => 'Total Subjects', 'value' => 5, 'icon' => 'book-open', 'color' => 'secondary', 'bg' => 'indigo-100'],
                    ['label' => 'Total Notices', 'value' => 5, 'icon' => 'clipboard-list', 'color' => 'accent', 'bg' => 'orange-100'],
                ];
            @endphp

            @foreach ($stats as $stat)
                <div class="bg-white p-6 rounded-2xl shadow-md border-l-4 border-{{ $stat['color'] }}">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 font-medium">{{ $stat['label'] }}</p>
                            <h2 class="text-3xl font-bold mt-2">{{ str_pad($stat['value'], 2, '0', STR_PAD_LEFT) }}</h2>
                        </div>
                        <div class="p-4 rounded-full bg-{{ $stat['bg'] }}">
                            <i class="fas fa-{{ $stat['icon'] }} text-{{ $stat['color'] }} text-2xl"></i>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Schedule & Notice Board -->
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Schedule -->
            <div class="bg-white p-6 rounded-xl shadow-md w-full lg:w-1/2 border-l-4 border-primary">
                <h2 class="text-lg font-semibold text-primary mb-4">📅 Today's Schedule</h2>
                <ul class="text-sm text-gray-700 space-y-2">
                    <li>✅ 10:00 AM - Class 5B - Science</li>
                    <li>✅ 12:00 PM - Class 6A - Biology</li>
                    <li>📌 2:00 PM - Meeting with Principal</li>
                </ul>
            </div>

            <!-- Notice Board -->
            <div class="bg-white p-6 rounded-xl shadow-md w-full lg:w-1/2 border-l-4 border-yellow-500">
                <h2 class="text-lg font-semibold text-yellow-600 mb-4">📋 Notice Board</h2>
                <ul class="list-disc pl-5 text-sm text-gray-700 space-y-2">
                    <li>👩‍🏫 Parent-Teacher Meeting on Friday at 3 PM</li>
                    <li>📘 Science Project Submission due next Monday</li>
                    <li>🎉 Annual Day prep starts next week</li>
                </ul>
            </div>
        </div>

        <!-- Quick Actions -->
        <div>
            <h2 class="text-xl font-bold text-gray-800 mb-4">🚀 Quick Actions</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @php
                    $actions = [
                        ['label' => 'Student List', 'icon' => 'users', 'color' => 'primary', 'bg' => 'indigo-100'],
                        ['label' => 'Send Homework', 'icon' => 'book-open', 'color' => 'secondary', 'bg' => 'purple-100'],
                        ['label' => 'Exam Schedule', 'icon' => 'calendar-alt', 'color' => 'accent', 'bg' => 'orange-100'],
                        ['label' => 'Send Notice', 'icon' => 'bullhorn', 'color' => 'green-500', 'bg' => 'green-100'],
                    ];
                @endphp

                @foreach ($actions as $action)
                    <button
                        class="bg-white p-5 rounded-xl shadow-md border border-gray-100 hover:shadow-lg group hover:border-{{ $action['color'] }} transition">
                        <div class="flex flex-col items-center">
                            <div
                                class="w-14 h-14 rounded-full flex items-center justify-center bg-{{ $action['bg'] }} group-hover:bg-{{ $action['color'] }} transition-colors">
                                <i class="fas fa-{{ $action['icon'] }} text-{{ $action['color'] }} text-xl group-hover:text-white"></i>
                            </div>
                            <span class="mt-3 font-medium text-gray-700 group-hover:text-{{ $action['color'] }}">
                                {{ $action['label'] }}
                            </span>
                        </div>
                    </button>
                @endforeach
            </div>
        </div>
    </div>
@endsection
