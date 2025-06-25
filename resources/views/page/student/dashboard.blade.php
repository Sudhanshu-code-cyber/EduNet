@extends('page.student.parent')

@section('content')
    <div class="py-5">
        <div class="w-full bg-white p-6 rounded-lg shadow-sm mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Welcome back, <span
                    class="text-indigo-600">{{ auth()->user()->name }}</span>! 🎓
            </h1>
            <p class="text-sm text-gray-500 mt-1">Hope you're having a great learning experience today.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 p-4">
            <!-- Upcoming Exam -->
            <div class="border rounded-lg p-4 bg-white shadow-sm text-center">
                <h2 class="text-sm font-semibold text-gray-500 mb-1">Upcoming Exams Schedule</h2>
                <p class="text-2xl font-bold text-indigo-600">{{$countExamShedules}}</p>
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
                <h2 class="text-2xl font-bold text-blue-800 border-b-2 pb-4 mb-6 flex items-center gap-2">
                    📝 Upcoming Exam Schedule
                </h2>



                <!-- Exam Table -->
                <div class="rounded-xl overflow-hidden border border-gray-200 shadow-sm">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-blue-100 text-blue-800 uppercase text-xs tracking-wider">
                            <tr>
                                <th class="px-4 py-3">Subject</th>
                                <th class="px-4 py-3">Exam Date</th>
                                <th class="px-4 py-3">Start Time</th>
                                <th class="px-4 py-3">End Time</th>
                                <th class="px-4 py-3">Duration</th>
                                <th class="px-4 py-3">Room No</th>
                                <th class="px-4 py-3">Max Marks</th>
                                <th class="px-4 py-3">Min Marks</th>
                            </tr>
                        </thead>
                        <tbody class=" divide-gray-100 bg-white">
                            @foreach ($examSchedules as $exam)
                                <tr>
                                    <td>{{ $exam->class->name ?? 'N/A' }}</td>
                                    <td>{{ $exam->subject->name ?? 'N/A' }}</td>
                                    <td>{{ $exam->exam_date }}</td>
                                    <td>{{ $exam->teacher->user->name ?? 'N/A' }}</td>
                                </tr>
                            @endforeach

                            <!-- Add more rows as needed -->
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
                @forelse ($latestNotices as  $note)
                    <div class="flex flex-col gap-4" x-data="{ showModal: false, selectedNotice: '' }">

                        <!-- Notice Item -->
                        <div>
                            <p class="text-sm text-gray-500">📅 {{ $note->date }}</p>
                            <h3 class="text-lg font-medium text-blue-700">{{ $note->posted_by }}</h3>

                            <!-- Truncated content -->
                            <p class="text-gray-700 line-clamp-2">
                                {{ $note->title }}
                            </p>

                            <!-- Read More Button -->
                            <button @click="showModal = true; selectedNotice = `{{ $note->title }}`"
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
                @empty
                    <div
                        class="flex flex-col items-center justify-center text-center p-6 bg-gray-50 border border-dashed border-gray-300 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-4" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12A9 9 0 113 12a9 9 0 0118 0z" />
                        </svg>
                        <h2 class="text-lg font-semibold text-gray-700">Not Found</h2>
                        <p class="text-sm text-gray-500 mt-1">We couldn't find what you were looking for.</p>
                    </div>
                @endforelse




            </div>


        </div>


    </div>
@endsection
