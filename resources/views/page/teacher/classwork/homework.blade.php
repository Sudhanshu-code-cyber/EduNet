@extends('page.teacher.parent')

@section('content')
<div class="max-w-7xl mx-auto p-6 bg-gray-50 min-h-screen">

    <!-- Title & Add Button -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-blue-700 relative   after:h-1 after:bg-blue-500 after:mt-2">
            Class Work
        </h1>
        <button data-modal-target="homework-modal" data-modal-toggle="homework-modal"
            class="bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg text-sm px-6 py-3 shadow-md hover:shadow-lg transition duration-300 flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Add Homework
        </button>
    </div>

    <!-- Filter and Search -->
    <div class="flex justify-between items-center mb-6 flex-wrap gap-4">
        <!-- Search Bar -->
        <div class="flex gap-2">
            <input type="text" placeholder="Search homework..." 
                class="border border-gray-300 rounded-lg px-4 py-2 text-sm w-64 focus:outline-none focus:ring-2 focus:ring-blue-400">
            <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:shadow-md text-sm">
                <i class="fa-solid fa-magnifying-glass"></i> Search
            </button>
        </div>

        <!-- Filter Button -->
        <button data-modal-target="filter-modal" data-modal-toggle="filter-modal"
            class="bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-6 py-2 shadow-md hover:shadow-lg text-sm flex items-center gap-2">
            <i class="fa-solid fa-filter"></i> Filter
        </button>
    </div>

    <!-- Homework Table -->
    <div class="overflow-x-auto bg-white shadow-xl rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-blue-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">Class</th>
                    <th class="px-4 py-3 text-left">Section</th>
                    <th class="px-4 py-3 text-left">Subject</th>
                    <th class="px-4 py-3 text-left">Homework Date</th>
                    <th class="px-4 py-3 text-left">Submission Date</th>
                    <th class="px-4 py-3 text-left">Created By</th>
                    <th class="px-4 py-3 text-left">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <!-- Sample Row -->
                <tr class="hover:bg-gray-100 transition-all duration-300">
                    <td class="px-4 py-3 font-medium text-gray-700">HW1783929</td>
                    <td class="px-4 py-3">I</td>
                    <td class="px-4 py-3">A</td>
                    <td class="px-4 py-3">English</td>
                    <td class="px-4 py-3">10 May 2024</td>
                    <td class="px-4 py-3">12 May 2024</td>
                    <td class="px-4 py-3 flex items-center gap-2">
                        <img src="https://i.pravatar.cc/300" class="w-8 h-8 rounded-full border" alt="Janet">
                        <span>Janet</span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex gap-3 text-gray-600">
                            <a href="#" title="View">
                                <i class="fa-regular fa-eye hover:text-blue-600"></i>
                            </a>
                            <a href="#" title="Edit">
                                <i class="fa-regular fa-pen-to-square hover:text-yellow-500"></i>
                            </a>
                            <a href="#" title="Delete" onclick="return confirm('Are you sure?')">
                                <i class="fa-regular fa-trash-can hover:text-red-600"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Homework Modal -->
    @include('page.teacher.classwork.homework-modal')

</div>

<!-- Filter Modal -->
@include('page.teacher.classwork.filter-modal')
@endsection

@push('scripts')
<!-- Flowbite JS -->
<script src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.js"></script>
@endpush
