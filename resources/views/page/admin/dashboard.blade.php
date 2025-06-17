@extends('page.admin.parent')
@section('content')
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4361ee',
                        secondary: '#3f37c9',
                        accent: '#4895ef',
                        success: '#4cc9f0',
                        dark: '#1d3557',
                        light: '#f1faee',
                        warning: '#f72585',
                        info: '#560bad'
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fb;
        }

        .sidebar {
            transition: all 0.3s ease;
            background: linear-gradient(180deg, #1d3557 0%, #0f1c2f 100%);
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .chart-container {
            background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
            border-radius: 16px;
        }

        .notification-dot {
            position: absolute;
            top: 3px;
            right: 3px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #f72585;
        }




        .active-tab {
            background: linear-gradient(90deg, #4361ee 0%, #3f37c9 100%);
            color: white !important;
        }
    </style>
    <div>
        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto p-8">
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="card-hover bg-white p-6 rounded-xl shadow-sm border-l-4 border-primary">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-blue-100 mr-4">
                            <i class="fas fa-users text-primary text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-gray-500 text-sm font-medium">Total Students</h3>
                            <p class="text-2xl font-bold text-dark">{{ $countstudent }}</p>
                        </div>
                    </div>

                </div>

                <div class="card-hover bg-white p-6 rounded-xl shadow-sm border-l-4 border-warning">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-pink-100 mr-4">
                            <i class="fas fa-chalkboard-teacher text-warning text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-gray-500 text-sm font-medium">Total Teachers</h3>
                            <p class="text-2xl font-bold text-dark">{{ $countTeacher }}</p>
                        </div>
                    </div>

                </div>

                <div class="card-hover bg-white p-6 rounded-xl shadow-sm border-l-4 border-success">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-cyan-100 mr-4">
                            <i class="fas fa-book text-success text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-gray-500 text-sm font-medium">Classes</h3>
                            <p class="text-2xl font-bold text-dark">{{ $countClass }}</p>
                        </div>
                    </div>
                </div>

                <div class="card-hover bg-white p-6 rounded-xl shadow-sm border-l-4 border-info">
                    <div class="flex items-center">
                        <!-- Icon Container -->
                        <div class="p-3 rounded-lg bg-green-100 mr-4">
                            <i class="fas fa-dollar-sign text-green-600 text-xl"></i>
                        </div>

                        <!-- Text Content -->
                        <div>
                            <h3 class="text-gray-500 text-sm font-medium">Total Earnings</h3>
                            <p class="text-2xl font-bold text-dark">₹1,24,000</p>
                        </div>
                    </div>


                </div>
            </div>

            <!-- Charts and Analytics -->


            <!-- Recent Activity and Upcoming Events -->
            <div class="grid grid-cols-1 gap-6">

                <!-- Upcoming Events -->
                <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100">
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-gray-800">📅 Upcoming Events</h3>
                        <a href="{{ route('admin.calendar') }}"
                            class="text-blue-600 hover:text-blue-800 text-sm flex items-center font-medium">
                            View Calendar
                            <i class="fas fa-chevron-right ml-2 text-xs"></i>
                        </a>
                    </div>

                    <!-- Events List -->
                    <div class="space-y-4 max-h-72 overflow-y-auto pr-2">
                        @forelse ($events as $event)
                            <div
                                class="p-5 bg-blue-50 border-l-4 border-blue-600 rounded-2xl shadow-sm hover:shadow-md hover:bg-blue-100 transition-all duration-300 cursor-pointer group">
                                <!-- Title and Date -->
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-semibold text-lg text-blue-800 group-hover:text-blue-900">
                                        {{ $event->title }}</h4>
                                    <div class="text-right text-xs text-gray-500 leading-5">
                                        <div class="flex items-center gap-1">
                                            <i class="fas fa-clock text-blue-500"></i>
                                            <span>{{ \Carbon\Carbon::parse($event->start)->format('M d, Y h:i A') }}</span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <i class="fas fa-hourglass-end text-blue-400"></i>
                                            <span>{{ \Carbon\Carbon::parse($event->end)->format('M d, Y h:i A') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Description -->
                                <p class="text-sm text-gray-700 mt-1 leading-relaxed">
                                    {{ $event->description }}
                                </p>

                               
                            </div>

                        @empty
                            <div class="text-center py-6 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                                <p class="text-sm text-gray-600 italic flex items-center justify-center gap-2">
                                    <i class="fas fa-calendar-times text-red-500 text-base"></i>
                                    No upcoming events scheduled
                                </p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Quick Actions -->
                    <div class="mt-10">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">⚡ Quick Actions</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            <a href="{{ route('admin.addstudent') }}"
                                class="bg-blue-600 text-white p-4 rounded-xl flex flex-col items-center justify-center hover:bg-blue-700 transition">
                                <i class="fas fa-user-plus text-2xl mb-1"></i>
                                <span class="text-sm font-medium">Add Student</span>
                            </a>
                            <a href="{{ route('teacher.create') }}"
                                class="group bg-green-600 text-white px-5 py-4 rounded-2xl shadow-sm flex flex-col items-center justify-center hover:bg-green-700 transition duration-300">

                                <!-- Icon -->
                                <div
                                    class="bg-white text-green-600 rounded-full p-3 mb-2 group-hover:bg-green-100 transition">
                                    <i class="fas fa-user-plus text-xl"></i>
                                </div>

                                <!-- Label -->
                                <span class="text-sm font-semibold tracking-wide">Add Teacher</span>
                            </a>

                            <a href="{{ route('notice.index') }}"
                                class="bg-yellow-500 text-white p-4 rounded-xl flex flex-col items-center justify-center hover:bg-yellow-600 transition">
                                <i class="fas fa-bell text-2xl mb-1"></i>
                                <span class="text-sm font-medium">Send Notice</span>
                            </a>
                            <a href="{{ route('admin.calendar') }}"
                                class="bg-indigo-500 text-white p-4 rounded-xl flex flex-col items-center justify-center hover:bg-indigo-600 transition">
                                <i class="fas fa-calendar-plus text-2xl mb-1"></i>
                                <span class="text-sm font-medium">Create Event</span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

        </main>
    </div>
@endsection
