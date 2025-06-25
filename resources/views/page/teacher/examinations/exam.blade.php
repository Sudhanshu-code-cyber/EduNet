@extends('page.teacher.parent')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">

        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-bold text-blue-800">Exam List</h1>
            <button onclick="openModal()"
                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 font-medium">
                + Add New Exam
            </button>
        </div>

        <!-- Exam Table -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="px-6 py-3">Exam Name</th>
                        <th class="px-6 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($exams as $exam)
                    <tr>
                        <td class="px-6 py-4">{{ $exam->exam_name }}</td>
                        <td class="px-6 py-4 text-center flex justify-center gap-4">
                            <a href="{{ route('teacher.exams.edit', $exam->id) }}" title="Edit"
                                class="text-green-600 hover:text-green-800 transition">
                                <i class="fa-regular fa-pen-to-square hover:text-yellow-500"></i>
                            </a>
                            <form method="POST" action="{{ route('teacher.exams.destroy', $exam->id) }}"
                                onsubmit="return confirm('Are you sure?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Delete" class="text-red-600 hover:text-red-800 transition">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No exams found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Total -->
        <p class="text-sm text-gray-500 mt-6">Total Exams: {{ $exams->count() }}</p>
    </div>
</div>

<!-- Modal -->
<div id="examModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="fixed inset-0 bg-black bg-opacity-50" onclick="closeModal()"></div>

    <div class="bg-white rounded-lg shadow-lg w-11/12 sm:w-1/2 p-6 z-10 relative max-h-screen overflow-y-auto">
        <h2 class="text-2xl font-semibold mb-4 text-blue-700">Add New Exam</h2>

        <form method="POST" action="{{ route('teacher.exams.store') }}" class="space-y-4">
            @csrf

            <div>
                <label for="exam_name" class="block text-gray-700 font-medium mb-1">Exam Name</label>
                <input type="text" name="exam_name" id="exam_name" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter exam name">
            </div>
         
            <div class="flex gap-4 mt-4">
                <button type="submit"
                    class="bg-blue-600 text-white font-semibold px-5 py-2 rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">
                    Save
                </button>
                <button type="reset"
                    class="bg-gray-300 text-gray-800 font-semibold px-5 py-2 rounded-md hover:bg-gray-400 focus:ring-2 focus:ring-gray-400">
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

<!-- Modal JS -->
<script>
    function openModal() {
        document.getElementById('examModal').classList.remove('hidden');
        document.getElementById('examModal').classList.add('flex');
    }

    function closeModal() {
        document.getElementById('examModal').classList.add('hidden');
        document.getElementById('examModal').classList.remove('flex');
    }
</script>
@endsection
