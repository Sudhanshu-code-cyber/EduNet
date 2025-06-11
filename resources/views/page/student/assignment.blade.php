@extends('page.student.parent')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl space-y-8">

    <!-- Assignment Header -->
    <div class="bg-white shadow-md rounded-lg p-6 border-l-4 border-indigo-600">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-indigo-700">📚 My Assignments</h2>
                <p class="text-sm text-gray-500">View, download, and submit your pending assignments.</p>
            </div>
            <button class="text-sm text-indigo-600 hover:underline font-medium">🔍 View All</button>
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
                    <th class="px-4 py-3">Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                <!-- Static Row Example -->
                <tr class="border-b">
                    <td class="px-4 py-3">1</td>
                    <td class="px-4 py-3">Mathematics</td>
                    <td class="px-4 py-3 max-w-xs truncate" title="Algebra Worksheet Lorem ipsum dolor sit amet consectetur, adipisicing elit. Labore saepe officia, eum quae culpa sit expedita tempora quo veritatis dolore illum.">
                        Algebra Worksheet Lorem ipsum dolor sit amet consectetur, adipisicing elit. Labore saepe...
                    </td>
                    <td class="px-4 py-3">2025-06-05</td>
                    <td class="px-4 py-3 text-red-500 font-medium">2025-06-12</td>
                    <td class="px-4 py-3 space-x-2">
                        <a href="path-to-file.pdf" download class="text-blue-600 hover:underline">📥 Download</a>
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