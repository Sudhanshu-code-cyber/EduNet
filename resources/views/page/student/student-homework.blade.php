@extends('page.student.parent')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-6xl space-y-8">

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
                            <span class="p-1 rounded-full bg-green-100 text-green-800">✅ Submitted</span>
                        @else
                            <span class="p-1 rounded-full bg-yellow-100 text-yellow-800">⌛ Pending</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        @if($homework->submission_status !== 'submitted')
                            <!-- Trigger collapsible form -->
                            <button class="text-indigo-600 hover:underline" onclick="document.getElementById('submitForm{{ $homework->id }}').classList.toggle('hidden')">📤 Submit</button>
                        @else
                            <span class="text-gray-400 italic">Completed</span>
                        @endif
                    </td>
                </tr>

                <!-- Submit Homework Form (Collapsible) -->
                @if($homework->submission_status !== 'submitted')
                <tr id="submitForm{{ $homework->id }}" class="hidden">
                    <td colspan="7" class="bg-gray-50 p-6">
                        <form action="{{ route('student.homework.submit') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @csrf
                            <input type="hidden" name="homework_id" value="{{ $homework->id }}">

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Title</label>
                                <input type="text" name="title" required class="w-full border rounded px-3 py-2">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Upload File</label>
                                <input type="file" name="submitted_file" required class="w-full border rounded px-3 py-2">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Remarks</label>
                                <textarea name="remarks" rows="3" class="w-full border rounded px-3 py-2"></textarea>
                            </div>

                            <div class="md:col-span-2">
                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded">
                                    ✅ Submit Homework
                                </button>
                            </div>
                        </form>
                    </td>
                </tr>
                @endif

                @empty
                <tr>
                    <td colspan="7" class="text-center py-6 text-gray-500">No Homework Found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
