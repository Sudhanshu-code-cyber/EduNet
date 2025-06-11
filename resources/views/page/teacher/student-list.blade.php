@extends('page.teacher.parent')

@section('content')
<div class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-semibold mb-8 text-gray-900">Student List</h1>

        <div class="flex flex-col md:flex-row gap-8">
            <!-- Filters and Student List -->
            <div class="md:w-1/3 bg-white rounded-lg shadow p-6 flex flex-col">
                <form method="GET" action="">
                    <div class="mb-4">
                        <label for="class" class="block text-gray-700 font-medium mb-2">Class</label>
                        <select id="class" class="w-full border border-gray-300 rounded-md px-3 py-2">
                            <option>Select Class</option>
                            <option>Class 7</option>
                            <option>Class 8</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="section" class="block text-gray-700 font-medium mb-2">Section</label>
                        <select id="section" class="w-full border border-gray-300 rounded-md px-3 py-2">
                            <option>Select Section</option>
                            <option>A</option>
                            <option>B</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-medium mb-2">Student Name</label>
                        <input type="text" id="name" placeholder="Enter student name" class="w-full border border-gray-300 rounded-md px-3 py-2">
                    </div>

                    <div class="mb-6">
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md">
                            Search
                        </button>
                    </div>
                </form>

                <h2 class="text-xl font-semibold mb-4 text-gray-800 border-b border-gray-200 pb-2">Students</h2>

                <div class="overflow-y-auto max-h-[600px]">
                    <ul class="divide-y divide-gray-200">
                        <li class="flex justify-between items-center p-3 hover:bg-indigo-50 rounded-md">
                            <div>
                                <p class="font-medium text-gray-900">Aarav Sharma</p>
                                <p class="text-sm text-gray-500">ID: STU001</p>
                            </div>
                            <a href="#" class="text-indigo-600 hover:underline font-semibold">View</a>
                        </li>
                        <li class="flex justify-between items-center p-3 hover:bg-indigo-50 rounded-md">
                            <div>
                                <p class="font-medium text-gray-900">Riya Verma</p>
                                <p class="text-sm text-gray-500">ID: STU002</p>
                            </div>
                            <a href="#" class="text-indigo-600 hover:underline font-semibold">View</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Student Profile & Logs -->
            <div class="md:w-2/3 bg-white rounded-lg shadow p-6 overflow-y-auto max-h-[600px]">
                <h2 class="text-2xl font-semibold mb-6 text-gray-900">Aarav Sharma's Profile</h2>

                <section class="mb-8">
                    <h3 class="text-xl font-semibold mb-4 border-b border-gray-300 pb-2 text-gray-800">Basic Details</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-gray-700">
                        <div><span class="font-semibold">Student ID:</span> STU001</div>
                        <div><span class="font-semibold">Date of Birth:</span> Jan 15, 2010</div>
                        <div><span class="font-semibold">Gender:</span> Male</div>
                        <div><span class="font-semibold">Class & Section:</span> Class 7 - A</div>
                    </div>
                </section>

                <section class="mb-8">
                    <h3 class="text-xl font-semibold mb-4 border-b border-gray-300 pb-2 text-gray-800">Contact Information</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-gray-700">
                        <div><span class="font-semibold">Email:</span> aarav@example.com</div>
                        <div><span class="font-semibold">Phone:</span> 9876543210</div>
                        <div><span class="font-semibold">Address:</span> New Delhi, India</div>
                    </div>
                </section>

                <section class="mb-8">
                    <h3 class="text-xl font-semibold mb-4 border-b border-gray-300 pb-2 text-gray-800">Leave Logs</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left border border-gray-200">
                            <thead class="bg-indigo-50 text-indigo-700">
                                <tr>
                                    <th class="px-4 py-2 border-r">Date</th>
                                    <th class="px-4 py-2 border-r">Reason</th>
                                    <th class="px-4 py-2">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-t hover:bg-indigo-100">
                                    <td class="px-4 py-2 border-r">May 10, 2025</td>
                                    <td class="px-4 py-2 border-r">Fever</td>
                                    <td class="px-4 py-2">
                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">Approved</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <section>
                    <h3 class="text-xl font-semibold mb-4 border-b border-gray-300 pb-2 text-gray-800">Absent Logs</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left border border-gray-200">
                            <thead class="bg-red-50 text-red-700">
                                <tr>
                                    <th class="px-4 py-2 border-r">Date</th>
                                    <th class="px-4 py-2">Reason</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-t hover:bg-red-100">
                                    <td class="px-4 py-2 border-r">April 21, 2025</td>
                                    <td class="px-4 py-2">Personal Work</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
