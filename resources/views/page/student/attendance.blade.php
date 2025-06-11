@extends('page.student.parent')

@section('content')

  <div class="container mx-auto mt-8 px-4 max-w-6xl">

    <!-- Attendance Report Header Card -->
    <div class="bg-white shadow-md rounded-lg p-6 border-l-4 border-blue-600 space-y-4">
        <div>
            <h2 class="text-2xl font-bold text-blue-700">📊 My Attendance Report</h2>
            <p class="text-sm text-gray-500">Filter and view your attendance summary</p>
        </div>

        <!-- Search Form -->
        <form class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-600">Class</label>
                <select class="w-full border rounded px-3 py-2">
                    <option value="">Select Class</option>
                    <option>1</option>
                    <option>2</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600">Attendance Type</label>
                <select class="w-full border rounded px-3 py-2">
                    <option value="">All</option>
                    <option>Present</option>
                    <option>Absent</option>
                    <option>Leave</option>
                    <option>Late</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600">Report Type</label>
                <select class="w-full border rounded px-3 py-2">
                    <option value="">Select</option>
                    <option>Weekly</option>
                    <option>Monthly</option>
                    <option>Yearly</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600">Start Date</label>
                <input type="date" class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600">End Date</label>
                <input type="date" class="w-full border rounded px-3 py-2">
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">
                    🔍 Search
                </button>
            </div>
        </form>
    </div>

    <!-- Search Result Table -->
    <div class="bg-white shadow-md rounded-lg mt-8 overflow-x-auto">
        <table class="min-w-full table-auto text-sm text-left">
            <thead class="bg-gray-100 text-gray-700 font-semibold">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Student Name</th>
                    <th class="px-4 py-3">Class</th>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Remarks</th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                <!-- Static Rows -->
                <tr class="border-b">
                    <td class="px-4 py-3">1</td>
                    <td class="px-4 py-3">Ravi Kumar</td>
                    <td class="px-4 py-3">1</td>
                    <td class="px-4 py-3">2025-06-10</td>
                    <td class="px-4 py-3 text-green-600 font-medium">Present</td>
                    <td class="px-4 py-3">On Time</td>
                </tr>
               
            </tbody>
        </table>
    </div>
</div>


    


@endsection