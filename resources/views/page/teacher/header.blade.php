<header class="bg-white shadow-md sticky top-0 z-40">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo and Title -->
            <div class="flex items-center">
                <a href="#" class="flex items-center">
                    <div class="bg-blue-600 w-10 h-10 rounded-lg flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-white text-xl"></i>
                    </div>
                    <span class="ml-3 text-xl font-bold text-gray-800">EduNet - Teacher</span>
                </a>
            </div>

            <!-- Right Side Section -->
            <div class="flex items-center space-x-4">
                <!-- Notification Icon -->
                <a href="#" class="relative p-2 text-gray-600 hover:text-blue-600">
                    <i class="fas fa-bell text-lg"></i>
                    <span class="absolute top-0 right-0 inline-block w-4 h-4 bg-red-500 text-white text-xs text-center rounded-full">3</span>
                </a>

              <!-- User Dropdown (click-based) -->
<div class="dropdown relative">
    <div class="flex items-center text-sm font-medium text-gray-900 rounded-full focus:outline-none">
    <img src="https://i.pravatar.cc/300" alt="Profile Picture" class="w-9 h-9 rounded-full object-cover" />
    <span class="ml-2 hidden md:inline font-medium text-gray-800">Ms. Briganza</span>
    <button  onclick="toggleDropdown('teacherDropdown')">
        <svg class="w-4 h-4 ml-1 hidden md:inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>
<div>

    <!-- Dropdown Menu -->
    <div id="teacherDropdown" class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg z-50 hidden">
        <!-- User Info -->
        <div class="px-4 py-3 border-b bg-gradient-to-r from-blue-50 to-indigo-50">
            <div class="flex items-center">
                <img src="https://i.pravatar.cc/300" alt="Profile" class="w-12 h-12 rounded-full object-cover">
                <div class="ml-3">
                    <p class="font-semibold text-gray-800">Ms. Briganza</p>
                    <p class="text-sm text-gray-600">Teacher</p>
                    <span class="inline-block mt-1 bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Active</span>
                </div>
            </div>
        </div>

        <!-- Links -->
        <ul class="py-2">
            <li>
                <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-user mr-3 text-gray-500 w-5"></i> My Profile
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-cog mr-3 text-gray-500 w-5"></i> Settings
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-book mr-3 text-gray-500 w-5"></i> My Subjects
                </a>
            </li>
            <li class="border-t border-gray-100 pt-2 bg-gray-50">
    <a href="#" class="flex items-center px-4 py-3 text-gray-700 hover:bg-gray-100">
        <i class="fas fa-sign-out-alt mr-3 text-gray-500 w-5"></i> Sign Out
    </a>
            </li>
        </ul>
    </div>
</div>

<script>
    function toggleDropdown(dropdownId) {
        const dropdown = document.getElementById(dropdownId);
        dropdown.classList.toggle('hidden');
    }
</script>


                        
                    </div>
                </div>
                <!-- End Dropdown -->
            </div>
        </div>
    </div>
</header>
