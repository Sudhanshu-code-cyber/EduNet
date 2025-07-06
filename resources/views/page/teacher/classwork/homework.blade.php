@extends('page.teacher.parent')

@section('content')
<div class="max-w-7xl mx-auto p-6 bg-gray-50 min-h-screen">

    <!-- Title & Add Button -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-blue-700 relative   after:h-1 after:bg-blue-500 after:mt-2">
            Class Work
        </h1>
        <button data-modal-target="homework-modal" data-modal-toggle="homework-modal"
            class="bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg text-sm px-6 py-3 shadow-md hover:shadow-lg transition duration-300 flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Add Homework
        </button>
    </div>

  <!-- Filter and Search -->
<div class="flex flex-wrap items-center justify-between gap-4 mb-6">

    <!-- Search and Filters -->
   <!-- Search Form -->
<form method="GET" action="{{ route('teacher.homework.search') }}" class="flex gap-4 mb-6">
    <input 
        type="text" 
        name="search" 
        value="{{ request('search') }}" 
        placeholder="Search homework by title"
        class="w-full px-4 py-2 border border-gray-300 rounded"
    >
    
    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Search</button>

    @if(request()->has('search') && request('search') != '')
        <a href="{{ route('teacher.homework.index') }}" 
            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg shadow hover:shadow-md">
           Reset
        </a>
    @endif
</form>


    <!-- Filter Button -->
    <button data-modal-target="filter-modal" data-modal-toggle="filter-modal"
        class="bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-6 py-2 shadow-md hover:shadow-lg text-sm flex items-center gap-2">
        <i class="fa-solid fa-filter"></i> Filter
    </button>
</div>


    <!-- Homework Table -->
    <div class="overflow-x-auto bg-white shadow-xl rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Title</th>
                        <th>Subject</th>
                        <th>Homework Date</th>
                        <th>Submission Date</th>
                        <th>Teacher</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($homeworks as $homework)
                    <tr class="hover:bg-gray-100 transition-all duration-300">
                        <td class="px-4 py-3 font-medium text-gray-700">{{ $homework->id }}</td>
                        <td class="px-4 py-3">{{ $homework->class->name ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $homework->section->name ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $homework->title }}</td>
                        <td class="px-4 py-3">{{ $homework->subject->name ?? '-' }}</td>
                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($homework->homework_date)->format('d M Y') }}</td>
                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($homework->submission_date)->format('d M Y') }}</td>
                        <td class="px-4 py-3 flex items-center gap-2">
                            <img src="{{ $homework->teacher->user->photo_url ?? 'https://i.pravatar.cc/300' }}" class="w-8 h-8 rounded-full border" alt="{{ $homework->teacher->user->name ?? 'Unknown' }}">
                            <span>{{ $homework->teacher->user->name ?? 'Unknown' }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex gap-3 text-gray-600">
                              <button type="button" onclick='openEditModal(@json($homework))' title="Edit">
    <i class="fa-regular fa-pen-to-square hover:text-yellow-500"></i>
</button>
<form action="{{ route('teacher.homework.destroy', $homework->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="text-red-600 hover:underline">
         <i class="fa-regular fa-trash-can hover:text-red-600"></i>
    </button>
</form>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-10 text-gray-400 text-lg">
                            <i class="fa-regular fa-face-frown text-2xl mb-2 block"></i>
                            No homework found.
                        </td>
                    </tr>                    
                @endforelse
                </tbody>
        </table>
    </div>

    <!-- Homework Modal -->
    @include('page.teacher.classwork.homework-modal')

</div>

<!-- Filter Modal -->
@include('page.teacher.classwork.filter-modal')
@endsection

@push('scripts')
<!-- Flowbite JS -->
<script src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.js"></script>
@include('page.teacher.classwork.edit-homework-modal')

@push('scripts')
<script src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.js"></script>
@endpush

