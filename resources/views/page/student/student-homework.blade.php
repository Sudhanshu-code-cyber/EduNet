@extends('page.student.parent')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl space-y-8">

    <!-- Success Toast Notification (Hidden by default) -->
    @if(session('success'))
    <div id="successToast" class="fixed top-4 right-4 z-50">
        <div class="bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span>{{ session('success') }}</span>
            <button onclick="document.getElementById('successToast').remove()" class="ml-4 text-white hover:text-green-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
    @endif

    <!-- Homework Header -->
    <div class="bg-white shadow-md rounded-lg p-6 border-l-4 border-indigo-600">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-indigo-700">📚 My Homework</h2>
                <p class="text-sm text-gray-500">View and submit your pending assignments.</p>
            </div>
            <button class="text-sm text-indigo-600 hover:underline font-medium">🔍 View All</button>
        </div>

        <!-- Progress Summary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mt-6">
            <div class="bg-indigo-50 p-4 rounded-xl">
                <h3 class="text-gray-500 text-sm font-medium">Total Homework</h3>
                <p class="text-2xl font-bold mt-1">{{ $homeworks->count() }}</p>
            </div>
            <div class="bg-green-50 p-4 rounded-xl">
                <h3 class="text-gray-500 text-sm font-medium">Completed</h3>
                <p class="text-2xl font-bold mt-1">{{ $homeworks->where('submission_status', 'submitted')->count() }}</p>
            </div>
            <div class="bg-orange-50 p-4 rounded-xl">
                <h3 class="text-gray-500 text-sm font-medium">Pending</h3>
                <p class="text-2xl font-bold mt-1">{{ $homeworks->where('submission_status', 'pending')->count() }}</p>
            </div>
        </div>
    </div>

    <!-- Homework Table -->
    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100 text-gray-700 font-semibold">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Subject</th>
                    <th class="px-4 py-3">Title</th>
                    <th class="px-4 py-3">Assigned</th>
                    <th class="px-4 py-3">Due</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @forelse ($homeworks as $index => $homework)
                <tr class="border-b">
                    <td class="px-4 py-3">{{ $index + 1 }}</td>
                    <td class="px-4 py-3">{{ $homework->subject->name ?? '-' }}</td>
                    <td class="px-4 py-3 max-w-xs truncate" title="{{ $homework->title }}">{{ $homework->title }}</td>
                    <td class="px-4 py-3">{{ \Carbon\Carbon::parse($homework->homework_date)->format('Y-m-d') }}</td>
                    <td class="px-4 py-3 text-red-500 font-medium">{{ \Carbon\Carbon::parse($homework->submission_date)->format('Y-m-d') }}</td>
                    <td class="px-4 py-3">
                        @if($homework->submission_status === 'submitted')
                            <span class="px-2 py-1 rounded-full bg-green-100 text-green-800 text-xs font-medium">✅ Submitted</span>
                        @else
                            <span class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-800 text-xs font-medium">⌛ Pending</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        @if($homework->submission_status !== 'submitted')
                            <button class="text-indigo-600 hover:text-indigo-800 font-medium text-sm flex items-center gap-1" 
                                    onclick="toggleSubmitForm('submitForm{{ $homework->id }}')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                Submit
                            </button>
                        @else
                            <span class="text-gray-400 text-sm italic">Completed</span>
                        @endif
                    </td>
                </tr>

                <!-- Submit Homework Form (Collapsible) -->
                @if($homework->submission_status !== 'submitted')
                <tr id="submitForm{{ $homework->id }}" class="hidden bg-gray-50">
                    <td colspan="7" class="p-6">
                        <form action="{{ route('student.homework.submit') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @csrf
                            <input type="hidden" name="homework_id" value="{{ $homework->id }}">

                            <div class="md:col-span-2">
                                <h3 class="text-lg font-medium text-gray-800 mb-2">Submit Homework: {{ $homework->title }}</h3>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
                                <input type="text" name="title" required 
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Upload File *</label>
                                <div class="relative">
                                    <input type="file" name="submitted_file" required 
                                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500">
                                    <span class="absolute right-3 top-2 text-xs text-gray-500">PDF, DOC, JPG</span>
                                </div>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Remarks</label>
                                <textarea name="remarks" rows="3" 
                                          class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500"></textarea>
                            </div>

                            <div class="md:col-span-2 flex justify-end space-x-3">
                                <button type="button" onclick="toggleSubmitForm('submitForm{{ $homework->id }}')" 
                                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    Cancel
                                </button>
                                <button type="submit" 
                                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-sm font-medium flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Submit Homework
                                </button>
                            </div>
                        </form>
                    </td>
                </tr>
                @endif

                @empty
                <tr>
                    <td colspan="7" class="text-center py-6 text-gray-500">No homework assignments found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    // Toggle form visibility
    function toggleSubmitForm(formId) {
        document.getElementById(formId).classList.toggle('hidden');
    }

    // Auto-hide success message after 5 seconds
    @if(session('success'))
    setTimeout(() => {
        const toast = document.getElementById('successToast');
        if (toast) toast.remove();
    }, 5000);
    @endif
</script>
@endsection