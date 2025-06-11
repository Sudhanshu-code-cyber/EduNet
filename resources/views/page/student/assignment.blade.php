@extends('page.student.parent')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl space-y-8">

    <!-- Assignment Header -->
    <div class="bg-white shadow-md rounded-lg p-6 border-l-4 border-indigo-600">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-indigo-700">📚 My Assignments</h2>
                <p class="text-sm text-gray-500">View, Total Assignment, and submit your pending assignments.</p>
            </div>
            <button class="text-sm text-indigo-600 hover:underline font-medium">🔍 View All</button>
        </div>

        <!-- Progress Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-6">
                <div class="bg-indigo-50 p-4 rounded-xl">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-gray-500 text-sm font-medium">Total Assignments</h3>
                            <p class="text-2xl font-bold mt-1">12</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center">
                            <i class="fas fa-clipboard-list text-indigo-500 text-xl"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-green-50 p-4 rounded-xl">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-gray-500 text-sm font-medium">Completed</h3>
                            <p class="text-2xl font-bold mt-1">7</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-500 text-xl"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-orange-50 p-4 rounded-xl">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-gray-500 text-sm font-medium">Pending</h3>
                            <p class="text-2xl font-bold mt-1">5</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center">
                            <i class="fas fa-exclamation-circle text-orange-500 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <!-- Assignment List Table -->
    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100 text-gray-700 font-semibold">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Subject</th>
                    <th class="px-4 py-3">Title</th>
                    <th class="px-4 py-3">Assigned Date</th>
                    <th class="px-4 py-3">Due Date</th>
                    <th class="px-4 py-3">status</th>
                    <th class="px-4 py-3">Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                <!-- Static Row Example -->
                <tr class="border-b">
                    <td class="px-4 py-3">1</td>
                    <td class="px-4 py-3">Mathematics</td>
                    <td class="px-4 py-3 max-w-xs truncate" title="">
                        Algebra Worksheet Lorem ipsum dolor sit amet consectetur, adipisicing elit. Labore saepe...
                    </td>
                    <td class="px-4 py-3">2025-06-05</td>
                    <td class="px-4 py-3 text-red-500 font-medium">2025-06-12</td>
                    <td class="px-4 py-3  font-medium"> <span id="modalStatus" class="status-badge p-1 rounded-full bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-exclamation-circle mr-1"></i> Pending
                                </span></td>
                    <td class="px-4 py-3 space-x-2">
                        <button class="text-green-600 hover:underline">👁 View</button>
                    </td>
                </tr>
                <!-- More rows... -->
            </tbody>
        </table>
    </div>

    <!-- Submit Assignment Form -->
    <div id="submitForm" class="bg-white shadow rounded-lg p-6 space-y-4">
        <h3 class="text-xl font-semibold text-gray-800 border-b pb-2">📤 Submit Assignment</h3>

        <form class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Subject</label>
                <select class="w-full border rounded px-3 py-2">
                    <option>Select Subject</option>
                    <option>Mathematics</option>
                    <option>English</option>
                    <option>Science</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Assignment Title</label>
                <input type="text" placeholder="Enter Assignment Title" class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Upload Your File</label>
                <input type="file" class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Remarks (optional)</label>
                <textarea rows="3" placeholder="Any notes..." class="w-full border rounded px-3 py-2"></textarea>
            </div>

            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded">
                ✅ Submit Assignment
            </button>
        </form>
    </div>

</div>




@endsection