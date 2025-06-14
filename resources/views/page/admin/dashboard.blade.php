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
                            <p class="text-2xl font-bold text-dark">{{$countstudent}}</p>
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
                            <p class="text-2xl font-bold text-dark">42</p>
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
                            <p class="text-2xl font-bold text-dark">28</p>
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
            <div class="grid grid-cols-1  gap-6">

                <!-- Upcoming Events -->
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-dark">Upcoming Events</h3>
                        <button class="text-primary flex items-center hover:text-secondary">
                            <span>View Calendar</span>
                            <i class="fas fa-chevron-right ml-2 text-sm"></i>
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div class="p-4 border-l-4 border-primary bg-blue-50 rounded-lg hover:bg-blue-100 cursor-pointer">
                            <div class="flex justify-between">
                                <h4 class="font-medium">Science Fair</h4>
                                <span class="text-xs text-gray-500">10:00 AM</span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">Main Auditorium</p>
                            <div class="flex items-center mt-2 text-xs">
                                <span class="bg-primary text-white px-2 py-1 rounded">All Students</span>
                                <span class="ml-2 text-gray-500">Today</span>
                            </div>
                        </div>

                        <div class="p-4 border-l-4 border-success bg-green-50 rounded-lg hover:bg-green-100 cursor-pointer">
                            <div class="flex justify-between">
                                <h4 class="font-medium">Faculty Meeting</h4>
                                <span class="text-xs text-gray-500">2:30 PM</span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">Conference Room A</p>
                            <div class="flex items-center mt-2 text-xs">
                                <span class="bg-success text-white px-2 py-1 rounded">Teachers</span>
                                <span class="ml-2 text-gray-500">Tomorrow</span>
                            </div>
                        </div>

                        <div
                            class="p-4 border-l-4 border-warning bg-yellow-50 rounded-lg hover:bg-yellow-100 cursor-pointer">
                            <div class="flex justify-between">
                                <h4 class="font-medium">Parent-Teacher Conference</h4>
                                <span class="text-xs text-gray-500">9:00 AM</span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">Classroom Building</p>
                            <div class="flex items-center mt-2 text-xs">
                                <span class="bg-warning text-white px-2 py-1 rounded">Important</span>
                                <span class="ml-2 text-gray-500">June 18</span>
                            </div>
                        </div>

                        <div class="p-4 border-l-4 border-info bg-cyan-50 rounded-lg hover:bg-cyan-100 cursor-pointer">
                            <div class="flex justify-between">
                                <h4 class="font-medium">Final Exams Begin</h4>
                                <span class="text-xs text-gray-500">All Day</span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">All Campuses</p>
                            <div class="flex items-center mt-2 text-xs">
                                <span class="bg-info text-white px-2 py-1 rounded">Academic</span>
                                <span class="ml-2 text-gray-500">June 25</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-semibold text-dark mb-4">Quick Actions</h3>
                        <div class="grid grid-cols-2 gap-3">
                            <a href="{{ route('admin.addstudent') }}"
                                class="py-3 bg-primary text-white rounded-lg flex flex-col items-center justify-center hover:bg-secondary transition">
                                <i class="fas fa-plus text-xl mb-2"></i>
                                <span>Add Student</span>
                            </a>
                            <button
                                class="py-3 bg-success text-white rounded-lg flex flex-col items-center justify-center hover:bg-green-600 transition">
                                <i class="fas fa-file-export text-xl mb-2"></i>
                                <span>Generate Report</span>
                            </button>
                            <button
                                class="py-3 bg-warning text-white rounded-lg flex flex-col items-center justify-center hover:bg-pink-600 transition">
                                <i class="fas fa-bell text-xl mb-2"></i>
                                <span>Send Notice</span>
                            </button>
                            <button
                                class="py-3 bg-info text-white rounded-lg flex flex-col items-center justify-center hover:bg-blue-600 transition">
                                <i class="fas fa-calendar-alt text-xl mb-2"></i>
                                <span>Create Event</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
