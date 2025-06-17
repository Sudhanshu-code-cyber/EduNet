<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>EduNet - School Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': '#2563eb',
                        'primary-dark': '#1d4ed8',
                        'secondary': '#0ea5e9',
                        'accent': '#8b5cf6'
                    }
                }
            }
        }
    </script>
    <style>
        html {
      scroll-behavior: smooth; /* Enables smooth scrolling */
    }

        .gradient-bg {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        }

        .hero-pattern {
            background: radial-gradient(circle, rgba(37, 99, 235, 0.1) 0%, rgba(255, 255, 255, 0) 70%);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .login-card {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(219, 234, 254, 0.8);
        }

        .nav-link:hover::after {
            content: '';
            display: block;
            width: 100%;
            height: 2px;
            background: #3b82f6;
            position: absolute;
            bottom: -5px;
            left: 0;
            animation: underline 0.3s ease;
        }

        @keyframes underline {
            from {
                width: 0;
            }

            to {
                width: 100%;
            }
        }
    </style>
</head>

<body class="gradient-bg min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <div class="bg-primary p-2 rounded-lg">
                    <i class="fas fa-graduation-cap text-white text-2xl"></i>
                </div>
                <span class="text-2xl font-bold text-gray-800">Edu<span class="text-primary">Net</span></span>
            </div>

            <nav class="hidden md:flex space-x-8">
                <a href="#" class="text-gray-700 hover:text-primary font-medium relative nav-link">Home</a>
                <a href="#" class="text-gray-700 hover:text-primary font-medium relative nav-link">Features</a>
                <a href="#" class="text-gray-700 hover:text-primary font-medium relative nav-link">About</a>
                <a href="#" class="text-gray-700 hover:text-primary font-medium relative nav-link">Contact</a>
            </nav>

            <div class="flex items-center space-x-4">
                <a href="{{ route('register') }}" class="text-primary hover:text-primary-dark font-medium">Register</a>
                 <a href="#login-section" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
      Login
    </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        <!-- Hero Section -->
        <section class="hero-pattern py-16">
            <div class="container mx-auto px-4 flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-10 md:mb-0">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">
                        Transform Your School <br>
                        <span class="text-primary">Management Experience</span>
                    </h1>
                    <p class="text-gray-600 text-lg mb-8 max-w-lg">
                        EduNet provides a comprehensive solution for managing students, teachers, classes, attendance,
                        and more.
                        Streamline your educational institution with our powerful tools.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="#"
                            class="bg-primary hover:bg-primary-dark text-white px-6 py-3 rounded-lg font-medium transition flex items-center">
                            Get Started <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                        <a href="#"
                            class="border border-primary text-primary hover:bg-blue-50 px-6 py-3 rounded-lg font-medium transition flex items-center">
                            <i class="fas fa-play-circle mr-2"></i> Watch Demo
                        </a>
                    </div>
                </div>
                <div class="md:w-1/2 flex justify-center">
                    <div class="relative">
                        <div class="w-80 h-80 bg-primary rounded-full opacity-10 absolute -top-10 -left-10"></div>
                        <div class="w-64 h-64 bg-secondary rounded-full opacity-10 absolute -bottom-10 -right-10"></div>
                        <div class="relative bg-white p-6 rounded-2xl shadow-xl border border-gray-100">
                            <img src="/vidya-school-management-software-flash.png" alt="Dashboard" class="w-full">
                            <div class="bg-primary text-white p-4 rounded-lg mt-6">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-sm opacity-80">Total Students</p>
                                        <p class="text-2xl font-bold">2,458</p>
                                    </div>
                                    <div class="bg-primary-dark p-3 rounded-lg">
                                        <i class="fas fa-users text-xl"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-16 bg-white">
            <div class="container mx-auto px-4">
                <div class="text-center max-w-2xl mx-auto mb-16">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Powerful Features</h2>
                    <p class="text-gray-600">Everything you need to efficiently manage your educational institution in
                        one place.</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div
                        class="feature-card bg-white rounded-xl p-6 shadow-lg border border-gray-100 transition-all duration-300">
                        <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center mb-6">
                            <i class="fas fa-tachometer-alt text-primary text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Smart Dashboard</h3>
                        <p class="text-gray-600 mb-4">Get a comprehensive overview of your institution with real-time
                            analytics and insights.</p>
                        <a href="#" class="text-primary font-medium flex items-center">
                            Learn more <i class="fas fa-arrow-right ml-2 text-sm"></i>
                        </a>
                    </div>

                    <!-- Feature 2 -->
                    <div
                        class="feature-card bg-white rounded-xl p-6 shadow-lg border border-gray-100 transition-all duration-300">
                        <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center mb-6">
                            <i class="fas fa-user-clock text-accent text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Real-Time Attendance</h3>
                        <p class="text-gray-600 mb-4">Track student and teacher attendance with our intuitive and
                            efficient system.</p>
                        <a href="#" class="text-primary font-medium flex items-center">
                            Learn more <i class="fas fa-arrow-right ml-2 text-sm"></i>
                        </a>
                    </div>

                    <!-- Feature 3 -->
                    <div
                        class="feature-card bg-white rounded-xl p-6 shadow-lg border border-gray-100 transition-all duration-300">
                        <div class="w-14 h-14 bg-cyan-100 rounded-xl flex items-center justify-center mb-6">
                            <i class="fas fa-calendar-alt text-secondary text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Event Calendar</h3>
                        <p class="text-gray-600 mb-4">Manage school events, exams, and holidays with our integrated
                            calendar system.</p>
                        <a href="#" class="text-primary font-medium flex items-center">
                            Learn more <i class="fas fa-arrow-right ml-2 text-sm"></i>
                        </a>
                    </div>

                    <!-- Feature 4 -->
                    <div
                        class="feature-card bg-white rounded-xl p-6 shadow-lg border border-gray-100 transition-all duration-300">
                        <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center mb-6">
                            <i class="fas fa-chart-line text-green-500 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Performance Reports</h3>
                        <p class="text-gray-600 mb-4">Generate detailed reports on student performance, attendance, and
                            more.</p>
                        <a href="#" class="text-primary font-medium flex items-center">
                            Learn more <i class="fas fa-arrow-right ml-2 text-sm"></i>
                        </a>
                    </div>

                    <!-- Feature 5 -->
                    <div
                        class="feature-card bg-white rounded-xl p-6 shadow-lg border border-gray-100 transition-all duration-300">
                        <div class="w-14 h-14 bg-yellow-100 rounded-xl flex items-center justify-center mb-6">
                            <i class="fas fa-users-cog text-yellow-500 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Multi-Role Access</h3>
                        <p class="text-gray-600 mb-4">Customized portals for administrators, teachers, students, and
                            parents.</p>
                        <a href="#" class="text-primary font-medium flex items-center">
                            Learn more <i class="fas fa-arrow-right ml-2 text-sm"></i>
                        </a>
                    </div>

                    <!-- Feature 6 -->
                    <div
                        class="feature-card bg-white rounded-xl p-6 shadow-lg border border-gray-100 transition-all duration-300">
                        <div class="w-14 h-14 bg-red-100 rounded-xl flex items-center justify-center mb-6">
                            <i class="fas fa-comments text-red-500 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Communication Hub</h3>
                        <p class="text-gray-600 mb-4">Integrated messaging system for seamless communication between
                            all stakeholders.</p>
                        <a href="#" class="text-primary font-medium flex items-center">
                            Learn more <i class="fas fa-arrow-right ml-2 text-sm"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Login Section - Preserving your original logic -->
        <section id="login-section" class="py-16 bg-gradient-to-br from-blue-50 to-blue-100">
            <div class="container mx-auto px-4">
                <div class="text-center max-w-2xl mx-auto mb-16">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Access Your Account</h2>
                    <p class="text-gray-600">Sign in to manage your educational institution</p>
                </div>

                <div class="max-w-4xl mx-auto bg-white rounded-2xl overflow-hidden shadow-xl">
                    <div class="flex flex-col md:flex-row">
                        <!-- Left: Info Section -->
                        <div class="md:w-2/5 bg-gradient-to-br from-primary to-primary-dark text-white p-10">
                            <h1 class="text-3xl font-bold mb-6 leading-tight">Welcome to EduNet</h1>
                            <p class="mb-6">Manage Students, Teachers, Classes, Attendance, and more.</p>
                            <ul class="space-y-3">
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle mt-1 mr-3"></i>
                                    <span>Smart Dashboard Access</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle mt-1 mr-3"></i>
                                    <span>Real-Time Attendance System</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle mt-1 mr-3"></i>
                                    <span>Event Calendar, Exams, and Reports</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check-circle mt-1 mr-3"></i>
                                    <span>Admin, Teacher & Student Portals</span>
                                </li>
                            </ul>
                            <div class="mt-10 flex justify-center">
                                <img src="/vidya-school-management-software-flash.png" class="w-40 opacity-90"
                                    alt="school icon">
                            </div>
                        </div>

                        <!-- Right: Login Panel -->
                        <div class="md:w-3/5 p-8 md:p-10">
                            <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">Login to EduNet</h2>

                            @if ($errors->any())
                                <div class="mb-4 bg-red-50 p-3 rounded-lg">
                                    @foreach ($errors->all() as $error)
                                        <p class="text-sm text-red-600 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-2"></i> {{ $error }}
                                        </p>
                                    @endforeach
                                </div>
                            @endif

                            <form action="{{ route('Userlogin') }}" method="POST" class="space-y-5">
                                @csrf

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email
                                        Address</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-envelope text-gray-400"></i>
                                        </div>
                                        <input type="email" name="email" id="email"
                                            value="{{ old('email') }}"
                                            class="pl-10 w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-primary focus:border-primary"
                                            placeholder="your.email@example.com" required autofocus>
                                    </div>
                                </div>

                                <div>
                                    <label for="password"
                                        class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class="fas fa-lock text-gray-400"></i>
                                        </div>
                                        <input type="password" name="password" id="password"
                                            class="pl-10 w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:ring-primary focus:border-primary"
                                            placeholder="••••••••" required>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="remember"
                                            class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                                    </label>
                                    <a href="#" class="text-sm text-primary hover:underline">Forgot
                                        Password?</a>
                                </div>

                                <button type="submit"
                                    class="w-full bg-primary hover:bg-primary-dark text-white py-3 px-4 rounded-lg font-medium transition flex items-center justify-center">
                                    Login <i class="fas fa-sign-in-alt ml-2"></i>
                                </button>

                                <p class="text-center text-sm mt-4 text-gray-600">
                                    Don't have an account?
                                    <a href="{{ route('register') }}"
                                        class="text-primary font-medium hover:underline">Register here</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white pt-16 pb-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Column 1 -->
                <div>
                    <div class="flex items-center space-x-2 mb-6">
                        <div class="bg-primary p-2 rounded-lg">
                            <i class="fas fa-graduation-cap text-white text-2xl"></i>
                        </div>
                        <span class="text-2xl font-bold">Edu<span class="text-primary">Net</span></span>
                    </div>
                    <p class="text-gray-400 mb-6">
                        Transforming education management with innovative solutions for schools, colleges, and
                        universities.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>

                <!-- Column 2 -->
                <div>
                    <h3 class="text-lg font-semibold mb-6">Quick Links</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Home</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Features</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">About Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Pricing</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Contact</a></li>
                    </ul>
                </div>

                <!-- Column 3 -->
                <div>
                    <h3 class="text-lg font-semibold mb-6">Features</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Student Management</a>
                        </li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Attendance System</a>
                        </li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Exam Management</a>
                        </li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Timetable
                                Scheduling</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Reporting &
                                Analytics</a></li>
                    </ul>
                </div>

                <!-- Column 4 -->
                <div>
                    <h3 class="text-lg font-semibold mb-6">Contact Us</h3>
                    <ul class="space-y-3 text-gray-400">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-primary"></i>
                            <span>123 Education Street, Learnville, LV 54321</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-phone-alt mt-1 mr-3 text-primary"></i>
                            <span>+1 (555) 123-4567</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-envelope mt-1 mr-3 text-primary"></i>
                            <span>support@edunet.example</span>
                        </li>
                    </ul>
                    <div class="mt-6">
                        <h4 class="font-medium mb-3">Subscribe to Newsletter</h4>
                        <div class="flex">
                            <input type="email" placeholder="Your email"
                                class="px-4 py-2 w-full rounded-l-lg focus:outline-none text-gray-800">
                            <button class="bg-primary hover:bg-primary-dark px-4 py-2 rounded-r-lg">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-12 pt-8 text-center text-gray-400 text-sm">
                <p>&copy; 2023 EduNet School Management System. All rights reserved.</p>
                <div class="mt-2">
                    <a href="#" class="hover:text-white transition mx-2">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition mx-2">Terms of Service</a>
                    <a href="#" class="hover:text-white transition mx-2">Cookies</a>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
