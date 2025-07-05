  <header class="bg-white shadow-md rounded-full  ">
                <div class=" mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <!-- Logo and Navigation -->
                        <div class="flex items-center">
                            <!-- Logo -->
                            <a href="#" class="flex items-center">
                                <div class="bg-primary w-10 h-10 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-graduation-cap text-white text-xl"></i>
                                </div>
                                <span class="ml-3 text-xl font-bold text-gray-800">EduNet</span>
                            </a>

                            <!-- Navigation Links -->

                        </div>

                        <!-- Right Section -->
                        <div class="flex items-center space-x-4">


                            <!-- Icons -->
                            <div class="flex space-x-4">
                                <a href="#" class="relative p-2 text-gray-600 hover:text-primary">
                                    <i class="fas fa-bell text-lg"></i>
                                    <span class="notification-badge bg-red-500 text-white text-xs rounded-full">3</span>
                                </a>

                            </div>

                            <!-- User Dropdown -->
                            <div class="dropdown relative">
                                <button
                                    class="flex items-center text-sm font-medium text-gray-900 rounded-full focus:outline-none">
                                    <div class="relative">
                                        <div
                                            class="profile-img w-9 h-9 rounded-full flex items-center justify-center text-white font-bold">
                                            
                                        </div>
                                    </div>
                                    <span class="ml-2 hidden md:inline">{{ Auth::user()->name }}</span>
                                    <svg class="w-4 h-4 ml-1 hidden md:inline" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                <!-- Dropdown Content -->
                                <div class="dropdown-content bg-white rounded-lg w-64 z-50">
                                    <!-- User Info -->
                                    <div
                                        class="px-4 py-3 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                                        <div class="flex items-center">
                                            
                                            <div class="ml-3">
                                                <p class="font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                                                <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
                                                <div class="mt-1">
                                                    <span
                                                        class="inline-block bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full">Pro
                                                        Student</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Dropdown Links -->
                                    <ul class="py-2">
                                        <li>
                                            <a href="#"
                                                class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50">
                                                <i class="fas fa-user mr-3 text-gray-500 w-5"></i>
                                                <span>My Profile</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#"
                                                class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50">
                                                <i class="fas fa-cog mr-3 text-gray-500 w-5"></i>
                                                <span>Account Settings</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#"
                                                class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50">
                                                <i class="fas fa-book mr-3 text-gray-500 w-5"></i>
                                                <span>My Courses</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#"
                                                class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50">
                                                <i class="fas fa-wallet mr-3 text-gray-500 w-5"></i>
                                                <span>Payments</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#"
                                                class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50">
                                                <i class="fas fa-graduation-cap mr-3 text-gray-500 w-5"></i>
                                                <span>Academic Progress</span>
                                            </a>
                                        </li>
                                    </ul>

                                    <!-- Sign Out -->
                                    <div class="border-t border-gray-100 pt-2 bg-gray-50">
                                        <form method="POST" action="{{ route('user.logout') }}">
    @csrf
    <button type="submit" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100 w-full text-left">
        <i class="fas fa-sign-out-alt mr-3 text-gray-500 w-5"></i>
        <span>Sign Out</span>
    </button>
</form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>