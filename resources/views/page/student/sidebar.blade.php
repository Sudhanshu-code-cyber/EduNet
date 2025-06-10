<div class="w-full sm:w-3/12">
   <!-- Toggle Button for Mobile -->
   <button data-drawer-target="sidebar-multi-level-sidebar" data-drawer-toggle="sidebar-multi-level-sidebar"
      aria-controls="sidebar-multi-level-sidebar" type="button"
      class="inline-flex items-center p-2 mt-3 ms-3 text-sm text-gray-600 rounded-md sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
      <span class="sr-only">Toggle sidebar</span>
      <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
         <path fill-rule="evenodd" clip-rule="evenodd"
            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
         </path>
      </svg>
   </button>

   <!-- Sidebar -->
   <aside class="w-full sm:w-80 h-screen bg-white border-r border-gray-200 shadow-sm">
      <div class="flex flex-col h-full p-5 text-gray-700 space-y-6">

         <!-- Profile -->
         <div class="flex items-center gap-4">
            <div class="relative">
               <div class="w-12 h-12 bg-indigo-600 text-white text-lg font-bold rounded-full flex items-center justify-center uppercase">B</div>
               <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
            </div>
            <div>
               <p class="font-medium text-sm">Badal Kumar</p>
               <p class="text-xs text-gray-500">Student</p>
            </div>
         </div>

         <!-- Navigation -->
         <nav class="flex-1 space-y-8 text-sm overflow-y-auto">

            <!-- Overview -->
            <div>
               <p class="text-xs font-semibold text-gray-400 uppercase mb-2">Overview</p>
               <ul class="space-y-1">
                  <li>
                     <a href="#" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-100 transition">
                        📋 <span>Dashboard</span>
                     </a>
                  </li>
               </ul>
            </div>

            <!-- Learning -->
            <div>
               <p class="text-xs font-semibold text-gray-400 uppercase mb-2">Learning</p>
               <ul class="space-y-1">
                  <li>
                     <a href="#" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-100 transition">
                        📘 <span>My Class</span>
                     </a>
                  </li>
                  <li>
                     <a href="#" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-100 transition">
                        🧭 <span>Attendance Report</span>
                     </a>
                  </li>
               </ul>
            </div>

            <!-- Assessment -->
            <div>
               <p class="text-xs font-semibold text-gray-400 uppercase mb-2">Assessment</p>
               <ul class="space-y-1">
                  <li>
                     <a href="#" class="flex items-center gap-2 px-3 py-2 rounded bg-purple-100 text-purple-700">
                        📝 <span>Assignment & Homework</span>
                     </a>
                  </li>
                  <li>
                     <a href="#" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-100 transition">
                        🧪 <span>Exams & Result</span>
                     </a>
                  </li>
                  <li>
                     <a href="#" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-100 transition">
                        💰 <span>Fee Status</span>
                     </a>
                  </li>
                  <li>
                     <a href="#" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-100 transition">
                        📢 <span>Notices & Announcements</span>
                     </a>
                  </li>
                  <li>
                     <a href="#" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-100 transition">
                        🚌 <span>Transport Details</span>
                     </a>
                  </li>
               </ul>
            </div>

            <!-- Account -->
            <div>
               <p class="text-xs font-semibold text-gray-400 uppercase mb-2">Account</p>
               <ul class="space-y-1">
                  <li>
                     <a href="#" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-gray-100 transition">
                        👤 <span>My Profile</span>
                     </a>
                  </li>
               </ul>
            </div>
         </nav>

         <!-- Logout -->
         <div>
            <a href="#" class="flex items-center gap-2 px-3 py-2 rounded text-red-600 hover:bg-red-50 transition">
               ⏻ <span>Logout</span>
            </a>
         </div>

      </div>
   </aside>
</div>
