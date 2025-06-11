<!-- Sidebar -->
<aside id="teacher-sidebar" class="bg-white border-r border-gray-200 w-64 hidden sm:block flex-shrink-0 h-screen sticky top-0 overflow-y-auto">
    <div class="flex flex-col h-full p-3 px-5">
      
      <!-- Profile -->
      <div class="flex items-center gap-4 mb-5 px-2 py-2 rounded-md hover:bg-gray-50 transition duration-200">
        <div class="relative">
          <div class="w-10 h-10 bg-blue-500 text-white text-sm font-bold rounded-full flex items-center justify-center uppercase">TB</div>
          <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 border-2 border-white rounded-full"></span>
        </div>
        <div>
          <p class="font-medium text-sm text-gray-800">Ms. Briganza</p>
          <p class="text-xs text-gray-500">Teacher</p>
        </div>
      </div>
  
      <!-- Navigation -->
      <nav class="flex-1 space-y-1 text-sm">
        
        <!-- Overview -->
        <div>
          <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Overview</p>
          <ul class="space-y-0.5">
            <li>
              <a href="{{ route('/teacher') }}" class="block px-3 py-2 rounded-md hover:bg-gray-200 transition duration-200 text-gray-700 items-center gap-2">
                <i class="fas fa-home w-4 text-center text-gray-500"></i>
                Dashboard
              </a>
            </li>
          </ul>
        </div>
  
        <!-- Classroom -->
        <div>
          <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Classroom</p>
          <ul class="space-y-0.5">
            <li>
              <a href="{{ route('teacher.myclass') }}" class="block px-3 py-2 rounded-md hover:bg-gray-200 transition duration-200 text-gray-700 items-center gap-2">
                <i class="fas fa-chalkboard-teacher w-4 text-center text-gray-500"></i>
                My Classes
              </a>
            </li>
            <li>
              <a href="#" class="block px-3 py-2 rounded-md hover:bg-gray-200 transition duration-200 text-gray-700 items-center gap-2">
                <i class="fas fa-users w-4 text-center text-gray-500"></i>
                Student List
              </a>
            </li>
            <li>
              <a href="{{ route('attendance.index') }}" class="block px-3 py-2 rounded-md hover:bg-gray-200 transition duration-200 text-gray-700 items-center gap-2">
                <i class="fas fa-calendar-check w-4 text-center text-gray-500"></i>
                Attendance
              </a>
            </li>
          </ul>
        </div>
  
        <!-- Academic -->
        <div>
          <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Academic</p>
          <ul class="space-y-0.5">
            <li>
              <a href="#" class="block px-3 py-2 rounded-md hover:bg-gray-200 transition duration-200 text-gray-700 items-center gap-2">
                <i class="fas fa-book-open w-4 text-center text-gray-500"></i>
                Assignments
              </a>
            </li>
            <li>
              <a href="#" class="block px-3 py-2 rounded-md hover:bg-gray-200 transition duration-200 text-gray-700 items-center gap-2">
                <i class="fas fa-file-signature w-4 text-center text-gray-500"></i>
                Exam Management
              </a>
            </li>
            <li>
              <a href="#" class="block px-3 py-2 rounded-md hover:bg-gray-200 transition duration-200 text-gray-700 items-center gap-2">
                <i class="fas fa-chart-line w-4 text-center text-gray-500"></i>
                Marks Entry
              </a>
            </li>
            <li>
              <a href="{{ route('teacher.timetable') }}" class="block px-3 py-2 rounded-md hover:bg-gray-200 transition duration-200 text-gray-700 items-center gap-2">
                <i class="fas fa-clock w-4 text-center text-gray-500"></i>
                Timetable
              </a>
            </li>
            <li>
              <a href="#" class="block px-3 py-2 rounded-md hover:bg-gray-200 transition duration-200 text-gray-700 items-center gap-2">
                <i class="fas fa-bullhorn w-4 text-center text-gray-500"></i>
                Notices
              </a>
            </li>
          </ul>
        </div>
  
        <!-- Account -->
        <div>
          <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Account</p>
          <ul class="space-y-0.5">
            <li>
              <a href="#" class="block px-3 py-2 rounded-md hover:bg-gray-200 transition duration-200 text-gray-700 items-center gap-2">
                <i class="fas fa-user-cog w-4 text-center text-gray-500"></i>
                Profile & Settings
              </a>
            </li>
          </ul>
        </div>
      </nav>
  
      <!-- Logout -->
      <div class="mt-auto">
        <a href="#" class="block px-3 py-2 rounded-md text-sm text-red-600 hover:bg-red-50 transition duration-200 items-center gap-2 justify-center">
          <i class="fas fa-sign-out-alt w-4 text-center text-red-500"></i>
          Logout
        </a>
      </div>
    </div>
  </aside>
  