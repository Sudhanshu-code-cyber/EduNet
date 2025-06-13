@extends('page.teacher.parent')

@section('content')
<div class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-7xl mx-auto">

        <h1 class="text-4xl font-bold text-blue-800 mb-6">Homework Submission Report</h1>

        <!-- Search Homework Report Form -->
        <form method="GET" action="" class="bg-white p-4 rounded-lg shadow mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Class Dropdown -->
                <select name="class" class="border border-gray-300 rounded-md p-2 w-full">
                    <option value="">Select Class</option>
                    <option value="Class 6">Class 6</option>
                    <option value="Class 7">Class 7</option>
                    <option value="Class 8">Class 8</option>
                </select>

                <!-- Section Dropdown -->
                <select name="section" class="border border-gray-300 rounded-md p-2 w-full">
                    <option value="">Select Section</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                </select>

                <!-- Subject Input -->
                <input type="text" name="subject" placeholder="Subject"
                    class="border border-gray-300 rounded-md p-2 w-full">

                <!-- Submission Date -->
                <input type="date" name="submission_date"
                    class="border border-gray-300 rounded-md p-2 w-full">
            </div>

            <div class="mt-4 flex justify-end">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                    Search
                </button>
            </div>
        </form>


        <!-- Homework Table -->
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100 text-gray-700">
                    <tr class="text-left text-sm">
                        <th class="p-4">Student Name</th>
                        <th class="p-4">Class</th>
                        <th class="p-4">Section</th>
                        <th class="p-4">Subject</th>
                        <th class="p-4">Document</th> <!-- Teacher's Homework -->
                        <th class="p-4">Submission Date</th>
                        <th class="p-4">Submitted Date</th>
                        <th class="p-4">Submitted Document</th>
                        <th class="p-4">Total Marks</th>
                        <th class="p-4">Marks Obtained</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Action</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-600">

                    <!-- Row 1 -->
                    <tr class="border-b hover:bg-gray-50">
                    
                        <td class="p-4">Riya Sharma</td>
                        <td class="p-4">Class 7</td>
                        <td class="p-4">A</td>
                        <td class="p-4">Mathematics</td>
                        <td class="p-4">
                            <a href="/documents/teacher-math-homework.pdf" download
                                class="px-3 py-1 text-sm bg-green-500 text-white rounded hover:bg-green-600">
                                Download
                            </a>
                        </td>
                        <td class="p-4">2025-06-10</td>
                        <td class="p-4">2025-06-11</td>
                        <td class="p-4">
                            <a href="/documents/homework1.pdf" download
                                class="inline-block px-3 py-1 text-sm bg-blue-500 text-white rounded hover:bg-blue-600">
                                Download
                            </a>
                        </td>
                        <td class="p-4">20</td>
                        <td class="p-4">18</td>
                        <td class="p-4">
                            <span class="px-2 py-1 text-green-700 bg-green-100 rounded">Submitted</span>
                        </td>
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
                    
                        <td class="p-4">Aman Verma</td>
                        <td class="p-4">Class 7</td>
                        <td class="p-4">B</td>
                        <td class="p-4">Science</td>
                        <td class="p-4">
                            <a href="/documents/teacher-science-homework.pdf" download
                                class="px-3 py-1 text-sm bg-green-500 text-white rounded hover:bg-green-600">
                                Download
                            </a>
                        </td>
                        <td class="p-4">2025-06-10</td>
                        <td class="p-4">2025-06-12</td>
                        <td class="p-4">
                            <a href="/documents/homework2.pdf" download
                                class="inline-block px-3 py-1 text-sm bg-blue-500 text-white rounded hover:bg-blue-600">
                                Download
                            </a>
                        </td>
                        <td class="p-4">25</td>
                        <td class="p-4">20</td>
                        <td class="p-4">
                            <span class="px-2 py-1 text-green-700 bg-green-100 rounded">Submitted</span>
                        </td>
                        <td class="p-4">
                            <div class="flex gap-2">
                                <a href="#" class="text-blue-600 hover:underline">View</a>
                                <a href="#" class="text-yellow-600 hover:underline">Edit</a>
                                <button class="text-red-600 hover:underline">Delete</button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 3 - Missing -->
                    <tr class="border-b hover:bg-gray-50">
                      
                        <td class="p-4">Kavya Singh</td>
                        <td class="p-4">Class 7</td>
                        <td class="p-4">A</td>
                        <td class="p-4">English</td>
                        <td class="p-4">
                            <a href="/documents/teacher-english-homework.pdf" download
                                class="px-3 py-1 text-sm bg-green-500 text-white rounded hover:bg-green-600">
                                Download
                            </a>
                        </td>
                        <td class="p-4">2025-06-10</td>
                        <td class="p-4">-</td>
                        <td class="p-4 text-gray-400 italic">Not Available</td>
                        <td class="p-4">15</td>
                        <td class="p-4">0</td>
                        <td class="p-4">
                            <span class="px-2 py-1 text-red-700 bg-red-100 rounded">Pending</span>
                        </td>
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
