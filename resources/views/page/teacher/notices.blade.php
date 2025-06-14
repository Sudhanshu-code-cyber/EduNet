@extends('page.teacher.parent')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">

        <div class="flex items-center justify-between mb-8">
            <h1 class="text-4xl font-bold text-blue-800">Notice Board</h1>
            <!-- Add New Notice Button -->
            <button onclick="openModal()"
                class="bg-blue-600 text-white font-semibold px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                Add New Notice
            </button>
        </div>

        <!-- Search Notice Board -->
        <section class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h2 class="text-2xl font-semibold mb-6 text-blue-700">Search Notices</h2>

            <form method="GET" action="" class="flex flex-col sm:flex-row gap-4 items-center">
                <div class="flex-1">
                    <label for="search_title" class="block text-gray-700 font-medium mb-1">Title</label>
                    <input type="text" name="search_title" id="search_title"
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Search by title" value="{{ request('search_title') }}">
                </div>

                <div>
                    <label for="search_date" class="block text-gray-700 font-medium mb-1">Date</label>
                    <input type="date" name="search_date" id="search_date"
                        class="border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="{{ request('search_date') }}">
                </div>

                <div class="mt-6 sm:mt-0">
                    <button type="submit"
                        class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                        Search
                    </button>
                </div>
            </form>
        </section>

        <!-- Notices List -->
        <section class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-semibold mb-6 text-blue-700">Notices</h2>

            <ul class="divide-y divide-gray-200">
                <li class="py-4 hover:bg-gray-100 transition flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold text-blue-600 mb-1">PTM Schedule Released</h3>
                        <p class="text-gray-800 mb-2 whitespace-pre-line">
                            The parent-teacher meeting for classes 6–10 will be held on June 15, 2025.
                        </p>
                        <div class="text-sm text-gray-500 flex flex-wrap gap-4">
                            <span><strong>Posted By:</strong> Principal Office</span>
                            <span><strong>Date:</strong> Jun 10, 2025</span>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button class="bg-blue-600 text-white hover:bg-blue-700 px-3 py-1 rounded-md transition" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="bg-red-600 text-white hover:bg-red-700 px-3 py-1 rounded-md transition" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </li>

                <li class="py-4 hover:bg-gray-100 transition flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold text-blue-600 mb-1">Holiday Notice</h3>
                        <p class="text-gray-800 mb-2 whitespace-pre-line">
                            The school will remain closed on June 13, 2025, for Eid celebrations.
                        </p>
                        <div class="text-sm text-gray-500 flex flex-wrap gap-4">
                            <span><strong>Posted By:</strong> Admin Department</span>
                            <span><strong>Date:</strong> Jun 11, 2025</span>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button class="bg-blue-600 text-white hover:bg-blue-700 px-3 py-1 rounded-md transition" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="bg-red-600 text-white hover:bg-red-700 px-3 py-1 rounded-md transition" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </li>

                <li class="py-4 hover:bg-gray-100 transition flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold text-blue-600 mb-1">New Library Timings</h3>
                        <p class="text-gray-800 mb-2 whitespace-pre-line">
                            The library will now be open from 8 AM to 3 PM on all working days.
                        </p>
                        <div class="text-sm text-gray-500 flex flex-wrap gap-4">
                            <span><strong>Posted By:</strong> Librarian</span>
                            <span><strong>Date:</strong> Jun 9, 2025</span>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button class="bg-blue-600 text-white hover:bg-blue-700 px-3 py-1 rounded-md transition" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="bg-red-600 text-white hover:bg-red-700 px-3 py-1 rounded-md transition" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </li>
            </ul>

            <div class="mt-6">
                <p class="text-sm text-gray-500 mt-4">Total Notices: 3</p>
            </div>
        </section>

        <!-- Modal for Create Notice -->
        <div id="noticeModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
            <!-- Overlay -->
            <div class="fixed inset-0 bg-black bg-opacity-50" onclick="closeModal()"></div>

            <!-- Modal Content -->
            <div class="bg-white rounded-lg shadow-lg p-6 z-10 w-11/12 sm:w-1/2 relative max-h-screen overflow-y-auto">
                <h2 class="text-2xl font-semibold mb-4 text-blue-700">Create Notice</h2>

                <form method="POST" action="" class="space-y-4" novalidate>
                    @csrf

                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="w-full sm:w-1/2">
                            <label for="title" class="block text-gray-700 font-medium mb-1">Title</label>
                            <input type="text" name="title" id="title" required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Notice title" value="{{ old('title') }}">
                        </div>

                        <div class="w-full sm:w-1/2">
                            <label for="posted_by" class="block text-gray-700 font-medium mb-1">Posted By</label>
                            <input type="text" name="posted_by" id="posted_by" required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Your name" value="{{ old('posted_by') }}">
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="w-full sm:w-2/3">
                            <label for="details" class="block text-gray-700 font-medium mb-1">Details</label>
                            <textarea name="details" id="details" rows="3" required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Write notice details here...">{{ old('details') }}</textarea>
                        </div>

                        <div class="w-full sm:w-1/3">
                            <label for="date" class="block text-gray-700 font-medium mb-1">Date</label>
                            <input type="date" name="date" id="date" required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{ old('date', \Carbon\Carbon::now()->format('Y-m-d')) }}">
                        </div>
                    </div>

                    <div class="flex gap-4 mt-4">
                        <button type="submit"
                            class="bg-blue-600 text-white font-semibold px-5 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Save
                        </button>
                        <button type="reset"
                            class="bg-gray-300 text-gray-700 font-semibold px-5 py-2 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400">
                            Reset
                        </button>
                        <button type="button" onclick="closeModal()"
                            class="ml-auto text-red-600 hover:underline font-semibold">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    function openModal() {
        document.getElementById('noticeModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('noticeModal').classList.add('hidden');
    }
</script>

<!-- Include Font Awesome for icons -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

@endsection