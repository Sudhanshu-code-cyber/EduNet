<!-- Sidebar Wrapper -->
<div class="sm:flex">
   <!-- Toggle Button (Mobile Only) -->
   <button data-drawer-target="student-sidebar" data-drawer-toggle="student-sidebar"
      aria-controls="student-sidebar" type="button"
      class="inline-flex items-center p-2 mt-3 ms-3 text-sm text-gray-600 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-200">
      <span class="sr-only">Toggle sidebar</span>
      <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
         <path fill-rule="evenodd" clip-rule="evenodd"
            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
         </path>
      </svg>
   </button>

   <!-- Sidebar Content -->
   <aside id="student-sidebar"
      class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 bg-gradient-to-b from-white to-gray-50 border-r border-gray-100 shadow-lg">
      <div class="flex flex-col h-full p-5 text-gray-700 space-y-6">

         <!-- Profile -->
         <div class="flex items-center gap-4 p-3 bg-white rounded-xl shadow-xs border border-gray-100">
            <div class="relative">
               <div
                  class="w-12 h-12 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-lg font-bold rounded-full flex items-center justify-center uppercase shadow-sm">
                  {{ substr(Auth::user()->name, 0, 1) }}
               </div>
               <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full shadow-sm"></span>
            </div>
            <div>
               <p class="font-medium text-sm text-gray-800">{{ Auth::user()->name }}</p>
               <p class="text-xs text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full inline-block">Student</p>
            </div>
         </div>

         <!-- Navigation -->
         <nav class="flex-1 space-y-8 text-sm overflow-y-auto">

            <!-- Overview -->
            <div>
               <p class="text-xs font-semibold text-gray-500 uppercase mb-2 tracking-wider px-3">Overview</p>
               <ul class="space-y-1">
                  <li>
                     <a href="{{ route('/student') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-100 transition-all duration-200 group">
                        <span class="w-6 h-6 flex items-center justify-center bg-blue-100 text-blue-600 rounded-lg group-hover:bg-blue-600 group-hover:text-white transition-colors">📋</span>
                        <span class="font-medium">Dashboard</span>
                     </a>
                  </li>
               </ul>
            </div>

            <!-- Learning -->
            <div>
               <p class="text-xs font-semibold text-gray-500 uppercase mb-2 tracking-wider px-3">Learning</p>
               <ul class="space-y-1">
                  <li>
                     <a href="{{ route('student.myclass') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-100 transition-all duration-200 group">
                        <span class="w-6 h-6 flex items-center justify-center bg-green-100 text-green-600 rounded-lg group-hover:bg-green-600 group-hover:text-white transition-colors">📘</span>
                        <span class="font-medium">My Class</span>
                     </a>
                  </li>
                  <li class="relative group">
                     <a href="{{ route('student.attendance') }}"
                        class="flex items-center justify-between gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-100 transition-all duration-200">
                        <div class="flex items-center gap-3">
                           <span class="w-6 h-6 flex items-center justify-center bg-amber-100 text-amber-600 rounded-lg group-hover:bg-amber-600 group-hover:text-white transition-colors">🧭</span>
                           <span class="font-medium">Attendance</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                     </a>
                     <ul class="absolute left-0 mt-1 w-full bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-10 overflow-hidden border border-gray-100">
                        <li>
                           <a href="#" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                              <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                              Daily Report
                           </a>
                        </li>
                        <li>
                           <a href="#" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                              <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                              Monthly Summary
                           </a>
                        </li>
                        <li>
                           <a href="#" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                              <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                              Yearly Overview
                           </a>
                        </li>
                     </ul>
                  </li>
               </ul>
            </div>

            <!-- Assessment -->
            <div>
               <p class="text-xs font-semibold text-gray-500 uppercase mb-2 tracking-wider px-3">Assessment</p>
               <ul class="space-y-1">
                  <li>
                     <a href="{{route('student.homework.index')}}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-purple-50 text-purple-700 group transition-all duration-200">
                        <span class="w-6 h-6 flex items-center justify-center bg-purple-100 text-purple-600 rounded-lg group-hover:bg-purple-600 group-hover:text-white transition-colors">📝</span>
                        <span class="font-medium">Homework</span>
                        <span class="ml-auto bg-purple-600 text-white text-xs px-2 py-0.5 rounded-full">3 New</span>
                     </a>
                  </li>
                  <li class="relative group">
                     <a href="{{route('student.myresult')}}"
                        class="flex items-center justify-between gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-100 transition-all duration-200">
                        <div class="flex items-center gap-3">
                           <span class="w-6 h-6 flex items-center justify-center bg-red-100 text-red-600 rounded-lg group-hover:bg-red-600 group-hover:text-white transition-colors">🧪</span>
                           <span class="font-medium">Exams & Result</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                     </a>
                     <ul class="absolute left-0 mt-1 w-full bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-10 overflow-hidden border border-gray-100">
                        <li>
                           <a href="#" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                              <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                              View Results
                           </a>
                        </li>
                        <li>
                           <a href="{{route('student.examschedule')}}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                              <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                              Exam Schedule
                           </a>
                        </li>
                        <li>
                           <a href="#" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                              <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                              Grade Reports
                           </a>
                        </li>
                     </ul>
                  </li>
                  <li>
                     <a href="{{route('student.myfee')}}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-100 transition-all duration-200 group">
                        <span class="w-6 h-6 flex items-center justify-center bg-emerald-100 text-emerald-600 rounded-lg group-hover:bg-emerald-600 group-hover:text-white transition-colors">💰</span>
                        <span class="font-medium">Fee Status</span>
                     </a>
                  </li>
                  <li>
                     <a href="{{ route('student.notice') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-100 transition-all duration-200 group">
                        <span class="w-6 h-6 flex items-center justify-center bg-blue-100 text-blue-600 rounded-lg group-hover:bg-blue-600 group-hover:text-white transition-colors">📢</span>
                        <span class="font-medium">Notices</span>
                        <span class="ml-auto bg-blue-600 text-white text-xs px-2 py-0.5 rounded-full">5 New</span>
                     </a>
                  </li>
                  <li>
                     <a href="#"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-100 transition-all duration-200 group">
                        <span class="w-6 h-6 flex items-center justify-center bg-cyan-100 text-cyan-600 rounded-lg group-hover:bg-cyan-600 group-hover:text-white transition-colors">🚌</span>
                        <span class="font-medium">Transport</span>
                     </a>
                  </li>
               </ul>
            </div>

            <!-- Account -->
            <div>
               <p class="text-xs font-semibold text-gray-500 uppercase mb-2 tracking-wider px-3">Account</p>
               <ul class="space-y-1">
                  <li class="relative group">
                     <a href="{{route('student.profile.edit')}}"
                        class="flex items-center justify-between gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-100 transition-all duration-200">
                        <div class="flex items-center gap-3">
                           <span class="w-6 h-6 flex items-center justify-center bg-indigo-100 text-indigo-600 rounded-lg group-hover:bg-indigo-600 group-hover:text-white transition-colors">👤</span>
                           <span class="font-medium">My Profile</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                     </a>
                     <ul class="absolute left-0 mt-1 w-full bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-10 overflow-hidden border border-gray-100">
                        <li>
                           <a href="#" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                              <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full"></span>
                              Personal Info
                           </a>
                        </li>
                        <li>
                           <a href="#" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                              <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full"></span>
                              Change Password
                           </a>
                        </li>
                        <li>
                           <a href="#" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                              <span class="w-1.5 h-1.5 bg-indigo-500 rounded-full"></span>
                              Privacy Settings
                           </a>
                        </li>
                     </ul>
                  </li>
               </ul>
            </div>
         </nav>

         <!-- Logout -->
         <div class="mt-auto">
            <a href="{{route('user.logout')}}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-red-600 hover:bg-red-50 transition-all duration-200 group">
               <span class="w-6 h-6 flex items-center justify-center bg-red-100 rounded-lg group-hover:bg-red-600 group-hover:text-white transition-colors">⏻</span>
               <span class="font-medium">Logout</span>
            </a>
         </div>

      </div>
   </aside>
</div>