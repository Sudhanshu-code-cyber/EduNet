@extends('page.teacher.parent')

@section('content')
<div class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-7xl mx-auto ">
    
        <h1 class="text-4xl font-bold text-blue-800 mb-6">Exam Schedule</h1>
         
        <div class="flex justify-end items-center gap-4 mb-3">
            <!-- Filter Button -->
            <button data-modal-target="filter-modal" data-modal-toggle="filter-modal"
                class="bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-6 py-2 shadow-md hover:shadow-lg text-sm flex items-center gap-2">
                <i class="fa-solid fa-filter"></i> Filter
            </button>
        
            @include('page.teacher.examinations.exam-schedule-modal')
        </div>
        
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100 text-gray-700">
                    <tr class="text-left text-sm">
                        <th class="p-4">Subject</th>
                        <th class="p-4">Exam Date</th>
                        <th class="p-4">Start Time</th>
                        <th class="p-4">End Time</th>
                        <th class="p-4">Duration</th>
                        <th class="p-4">Room No</th> 
                        <th class="p-4">Max Marks</th>
                        <th class="p-4">Min Marks</th>
                        <th class="p-4">Action</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700">
                    <!-- Row 1 -->
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-4">Mathematics</td>
                        <td class="p-4">2025-06-20</td>
                        <td class="p-4">09:00 AM</td>
                        <td class="p-4">12:00 PM</td>
                        <td class="p-4">3 hrs</td>
                        <td class="p-4">Room 101</td>
                        <td class="p-4">100</td>
                        <td class="p-4">33</td>
                        <td class="p-4">
                            <div class="flex gap-2">
                                <a href="#" class="text-blue-600 hover:underline">View</a>
                                <a href="#" class="text-yellow-600 hover:underline">Edit</a>
                                <button class="text-red-600 hover:underline">Delete</button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 2 -->
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-4">Science</td>
                        <td class="p-4">2025-06-22</td>
                        <td class="p-4">10:00 AM</td>
                        <td class="p-4">01:00 PM</td>
                        <td class="p-4">3 hrs</td>
                        <td class="p-4">Room 102</td>
                        <td class="p-4">100</td>
                        <td class="p-4">33</td>
                        <td class="p-4">
                            <div class="flex gap-2">
                                <a href="#" class="text-blue-600 hover:underline">View</a>
                                <a href="#" class="text-yellow-600 hover:underline">Edit</a>
                                <button class="text-red-600 hover:underline">Delete</button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 3 -->
                    <tr class="hover:bg-gray-50">
                        <td class="p-4">English</td>
                        <td class="p-4">2025-06-24</td>
                        <td class="p-4">08:30 AM</td>
                        <td class="p-4">11:30 AM</td>
                        <td class="p-4">3 hrs</td>
                        <td class="p-4">Room 103</td>
                        <td class="p-4">100</td>
                        <td class="p-4">33</td>
                        <td class="p-4">
                            <div class="flex gap-2">
                                <a href="#" class="text-blue-600 hover:underline">View</a>
                                <a href="#" class="text-yellow-600 hover:underline">Edit</a>
                                <button class="text-red-600 hover:underline">Delete</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>


    </div>
</div>
@endsection
