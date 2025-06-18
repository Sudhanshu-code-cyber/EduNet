@extends('page.admin.parent')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fas fa-user-graduate text-blue-600"></i> Student Records
        </h1>
        <a href="{{ route('student.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow text-sm flex items-center gap-2">
            <i class="fas fa-plus"></i> Add Student
        </a>
    </div>

    <!-- Search Bar -->
    <form action="{{ route('student.search') }}" method="GET" class="mb-6">
        <div class="bg-white p-4 rounded-lg shadow-sm flex flex-col md:flex-row items-center gap-4">
            <div class="relative w-full md:w-80">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm"
                    placeholder="Search by Name or Roll No.">
                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                    <i class="fas fa-search"></i>
                </div>
            </div>
            <button type="submit"
                class="bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white px-5 py-2.5 rounded-md text-sm flex items-center gap-2 shadow">
                <i class="fas fa-search"></i> Search
            </button>
        </div>
    </form>

    <!-- Student Table -->
    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-blue-50 text-blue-800 uppercase tracking-wide">
                <tr>
                    <th class="px-4 py-3">Roll</th>
                    <th class="px-4 py-3">Photo</th>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Gender</th>
                    <th class="px-4 py-3 hidden lg:table-cell">Parent</th>
                    <th class="px-4 py-3">Class</th>
                    <th class="px-4 py-3">Section</th>
                    <th class="px-4 py-3 hidden lg:table-cell">Address</th>
                    <th class="px-4 py-3 hidden lg:table-cell">DOB</th>
                    <th class="px-4 py-3 hidden lg:table-cell">Mobile</th>
                    <th class="px-4 py-3 hidden lg:table-cell">Email</th>
                    <th class="px-4 py-3 hidden lg:table-cell">Uses Transport</th>
                    <th class="px-4 py-3">Actions</th>
                    
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
    @forelse ($allstudent as $student)
        <tr class="hover:bg-gray-50" x-data="{ open: false }">
            <td class="px-4 py-2 font-medium">{{ $student->roll_no }}</td>
            <td class="px-4 py-2">
                <img class="w-10 h-10 rounded-full object-cover mx-auto"
                     src="{{ $student->photo ? asset('uploads/students/' . $student->photo) : 'https://i.pravatar.cc/40?img=1' }}"
                     alt="{{ $student->full_name }}">
            </td>
            <td class="px-4 py-2 font-medium">{{ $student->full_name }}</td>
            <td class="px-4 py-2">{{ $student->gender }}</td>
            <td class="px-4 py-2 hidden lg:table-cell">{{ $student->father_name }}</td>
            <td class="px-4 py-2">{{ $student->class }}</td>
            <td class="px-4 py-2">{{ $student->section }}</td>
            <td class="px-4 py-2 hidden lg:table-cell truncate w-32">{{ $student->present_address }}</td>
            <td class="px-4 py-2 hidden lg:table-cell">{{ \Carbon\Carbon::parse($student->dob)->format('d/m/Y') }}</td>
            <td class="px-4 py-2 hidden lg:table-cell">{{ $student->contact }}</td>
            <td class="px-4 py-2 hidden lg:table-cell">{{ $student->email }}</td>
            <td class="px-4 py-2 hidden lg:table-cell">
                @if($student->uses_transport)
                    <span class="text-green-600 font-semibold">Yes</span>
                @else
                    <span class="text-red-500 font-medium">No</span>
                @endif
            </td>
            
            <td class="px-4 py-2 text-center">
                <div class="flex items-center justify-center gap-3">
                    <!-- View -->
                    <a href="{{ route('student.show', $student->id) }}"
                       class="text-blue-500 hover:text-blue-700" title="View">
                        <i class="fas fa-eye"></i>
                    </a>

                    <!-- Edit -->
                    <button @click="open = true" class="text-yellow-600 hover:text-yellow-800" title="Edit">
                        <i class="fas fa-edit"></i>
                    </button>

                    <!-- Delete -->
                    <form action="{{ route('student.destroy', $student->id) }}" method="POST"
                          onsubmit="return confirm('Are you sure to delete this student?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>

               @include('page.admin.student.edit-student')
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="12" class="px-4 py-6 text-center text-gray-500">No students found.</td>
        </tr>
    @endforelse
</tbody>

        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6 flex justify-end">
        {{ $allstudent->links() }}
    </div>
</div>
@endsection
