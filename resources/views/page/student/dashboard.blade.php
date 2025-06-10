@extends('page.student.parent')

@section('content')
    <div class="py-10">
        <div class="w-full bg-white p-6 rounded-lg shadow-sm mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Welcome back, <span class="text-indigo-600">Student</span>! 🎓
            </h1>
            <p class="text-sm text-gray-500 mt-1">Hope you're having a great learning experience today.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 p-4">
            <!-- Upcoming Exam -->
            <div class="border rounded-lg p-4 bg-white shadow-sm text-center">
                <h2 class="text-sm font-semibold text-gray-500 mb-1">Upcoming Exams</h2>
                <p class="text-2xl font-bold text-indigo-600">05</p>
            </div>

            <!-- Events -->
            <div class="border rounded-lg p-4 bg-white shadow-sm text-center">
                <h2 class="text-sm font-semibold text-gray-500 mb-1">Events</h2>
                <p class="text-2xl font-bold text-green-600">05</p>
            </div>



            <!-- Attendance -->
            <div class="border rounded-lg p-4 bg-white shadow-sm text-center">
                <h2 class="text-sm font-semibold text-gray-500 mb-1">Attendance</h2>
                <p class="text-2xl font-bold text-emerald-600">94%</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-2 p-4">
            <div class="bg-white shadow-xl rounded-2xl p-6 overflow-x-auto">
                <h2 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-6">📊 All Exam Results</h2>

                <!-- Search Filters -->
                <div class="flex flex-col sm:flex-row gap-3 mb-6">
                    <input type="text" placeholder="🔍 Search by Exam"
                        class="border border-gray-300 px-4 py-2 rounded-lg w-full sm:w-1/3 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    <input type="date"
                        class="border border-gray-300 px-4 py-2 rounded-lg w-full sm:w-1/3 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    <button
                        class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-2 rounded-lg w-full sm:w-auto transition duration-300 ease-in-out">
                        🔎 Search
                    </button>
                </div>

                <!-- Table -->
                <div class="rounded-lg overflow-hidden border border-gray-200">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3 border-b">Exam Name</th>
                                <th class="px-4 py-3 border-b">Subject</th>
                                <th class="px-4 py-3 border-b">Grade Point</th>
                                <th class="px-4 py-3 border-b">Percent From</th>
                                <th class="px-4 py-3 border-b">Percent Upto</th>
                                <th class="px-4 py-3 border-b">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr class="hover:bg-yellow-50 transition">
                                <td class="px-4 py-3">Class Test</td>
                                <td class="px-4 py-3">Mathematics</td>
                                <td class="px-4 py-3 font-semibold text-green-600">4.00</td>
                                <td class="px-4 py-3">98.00</td>
                                <td class="px-4 py-3">100.00</td>
                                <td class="px-4 py-3">20/06/2017</td>
                            </tr>
                            <tr class="hover:bg-yellow-50 transition">
                                <td class="px-4 py-3">Pre Test</td>
                                <td class="px-4 py-3">English</td>
                                <td class="px-4 py-3 font-semibold text-yellow-600">3.50</td>
                                <td class="px-4 py-3">70.00</td>
                                <td class="px-4 py-3">100.00</td>
                                <td class="px-4 py-3">20/06/2017</td>
                            </tr>
                            <!-- More rows -->
                        </tbody>
                    </table>
                </div>
            </div>


            <!-- All Exam Result -->


            <div class="bg-white shadow-md rounded-lg p-6 space-y-4 w-full max-w-2xl mx-auto">
                <!-- Header -->
                <div class="border-b pb-2">
                    <h2 class="text-xl font-semibold text-gray-800">📌 Notice Board</h2>
                </div>

                <!-- Include Alpine.js -->
                <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

                <!-- Single Notice -->
                <div class="flex flex-col gap-4" x-data="{ showModal: false, selectedNotice: '' }">

                    <!-- Notice Item -->
                    <div>
                        <p class="text-sm text-gray-500">📅 16 May, 2025</p>
                        <h3 class="text-lg font-medium text-blue-700">Sudhanshu Kumar</h3>

                        <!-- Truncated content -->
                        <p class="text-gray-700 line-clamp-2">
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quod, quos reprehenderit! Eum cum
                            dolorem voluptate fugiat voluptatem, molestiae dolor inventore corrupti aliquid ad maiores
                            expedita dolore doloribus hic aut placeat?
                        </p>

                        <!-- Read More Button -->
                        <button
                            @click="showModal = true; selectedNotice = `Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quod, quos reprehenderit! Eum cum dolorem voluptate fugiat voluptatem, molestiae dolor inventore corrupti aliquid ad maiores expedita dolore doloribus hic aut placeat?`"
                            class="text-sm text-blue-600 hover:underline mt-1">
                            Read More
                        </button>
                    </div>

                    <!-- Modal -->
                    <div x-show="showModal" x-cloak
                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white p-6 rounded-lg max-w-lg w-full relative">
                            <button @click="showModal = false"
                                class="absolute top-2 right-2 text-gray-500 hover:text-black">&times;</button>
                            <h3 class="text-lg font-semibold text-blue-700 mb-2">Full Notice</h3>
                            <p class="text-gray-700" x-text="selectedNotice"></p>
                        </div>
                    </div>
                </div>



            </div>


        </div>
        

    </div>
@endsection
