@extends('page.teacher.parent')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">

       <!-- Header -->
<div class="flex justify-between items-center mb-10">
    <div>
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800">Exam Management</h1>
        <p class="text-gray-500 mt-2">View and manage all your exams in one place</p>
    </div>
    <button onclick="openModal()"
        class="flex items-center bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg transition-all duration-300 shadow-md hover:shadow-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
        </svg>
        Add New Exam
    </button>
</div>

<!-- Exam Table -->
<div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gradient-to-r from-blue-600 to-blue-500 text-white">
            <tr>
                <th scope="col" class="px-8 py-4 text-left font-semibold uppercase tracking-wider">
                    Exam Name
                </th>
                <th scope="col" class="px-6 py-4 text-center font-semibold uppercase tracking-wider">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($exams as $exam)
            <tr class="hover:bg-gray-50 transition-colors duration-150">
                <td class="px-8 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-lg font-medium text-gray-900">{{ $exam->exam_name }}</div>
                            <div class="text-sm text-gray-500">Created on {{ $exam->created_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
                    <div class="flex justify-center space-x-3">
                        
                        <form method="POST" action="{{ route('teacher.exams.destroy', $exam->id) }}"
                            onsubmit="return confirm('Are you sure you want to delete this exam?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="text-red-500 hover:text-red-700 transition-colors duration-200 p-2 rounded-full bg-red-50"
                                    title="Delete">
                                 Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="2" class="px-8 py-12 text-center">
                    <div class="flex flex-col items-center justify-center text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-lg font-medium mb-1">No exams found</h3>
                        <p class="max-w-xs">You haven't created any exams yet. Click the button above to add one.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Total -->
<div class="mt-6 flex justify-between items-center">
    <div class="text-sm text-gray-500 bg-gray-100 px-4 py-2 rounded-full">
        Showing <span class="font-medium text-gray-700">{{ $exams->count() }}</span> exam{{ $exams->count() !== 1 ? 's' : '' }} in total
    </div>
    @if($exams->count() > 5)
    <nav class="flex items-center space-x-2">
        <a href="#" class="px-3 py-1 rounded-md bg-blue-50 text-blue-600 font-medium">1</a>
        <a href="#" class="px-3 py-1 rounded-md hover:bg-gray-100 text-gray-600">2</a>
        <a href="#" class="px-3 py-1 rounded-md hover:bg-gray-100 text-gray-600">3</a>
        <span class="px-2 text-gray-400">...</span>
        <a href="#" class="px-3 py-1 rounded-md hover:bg-gray-100 text-gray-600">8</a>
    </nav>
    @endif
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
