@extends('page.admin.parent')

@section('content')
<div class="max-w-7xl mx-auto p-6 bg-gray-50 min-h-screen">

    <!-- Title & Add Button -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-blue-700 relative after:block after:w-24 after:h-1 after:bg-blue-500 after:mt-2">
            Teacher List
        </h1>
        
    </div>

    <!-- Search & Filter -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <!-- Search Form -->
      <form action="{{ route('teacher.search') }}" method="GET" class="flex flex-wrap gap-3">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or id or email"
           class="border border-gray-300 rounded-lg px-4 py-2 text-sm w-60 focus:outline-none focus:ring-2 focus:ring-blue-400" />
    <button type="submit"
        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:shadow-md text-sm">
        <i class="fa-solid fa-magnifying-glass"></i> Search
    </button>

    @if(request()->has('search') && request('search') != '')
        <a href="{{ route('teacher.index') }}"
           class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg text-sm shadow hover:shadow-md">
           Reset
        </a>
    @endif
</form>

<a href="{{ route('teacher.create') }}"
           class="bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg text-sm px-6 py-3 shadow-md hover:shadow-lg transition duration-300 flex items-center gap-2">
            <i class="fa-solid fa-plus"></i>Add Teacher
        </a>
    </div>

    <!-- Teacher Table -->
    <div class="overflow-x-auto bg-white shadow-xl rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-blue-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">Name</th>
                    <th class="px-4 py-3 text-left">Photo</th>
                    <th class="px-4 py-3 text-left">Gender</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Phone</th>
                    <th class="px-4 py-3 text-left">Qualification</th>
                    <th class="px-4 py-3 text-left">Address</th>
                    <th class="px-4 py-3 text-left">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($teachers as $teacher)
                    <tr class="hover:bg-gray-100 transition-all duration-300">
                        <td class="px-4 py-3">{{ $teacher->id_no }}</td>
                        <td class="px-4 py-3 font-medium">{{ $teacher->first_name }} {{ $teacher->last_name }}</td>
                        <td class="px-4 py-3">
                            @if($teacher->photo)
                                <img src="{{ asset('storage/' . $teacher->photo) }}" alt="Photo" class="h-10 w-10 rounded-full object-cover">
                            @else
                                <span class="text-gray-400">N/A</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">{{ $teacher->gender }}</td>
                        <td class="px-4 py-3">{{ $teacher->email }}</td>
                        <td class="px-4 py-3">{{ $teacher->phone }}</td>
                        <td class="px-4 py-3">{{ $teacher->qualification ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $teacher->address }}</td>
                        <td class="px-4 py-3">
                            <div class="flex gap-3 text-gray-600">
                                <a href="{{ route('teacher.show',$teacher->id) }}" title="View">
                                    <i class="fa-regular fa-eye hover:text-blue-600"></i>
                                </a>
                                <button type="button"
                                    data-modal-target="edit-teacher-modal-{{ $teacher->id }}"
                                    data-modal-toggle="edit-teacher-modal-{{ $teacher->id }}"
                                    title="Edit">
                                    <i class="fa-regular fa-pen-to-square hover:text-yellow-500"></i>
                                </button>
                                <form action="{{ route('teacher.destroy',$teacher->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Delete" >
                                        <i class="fa-regular fa-trash-can hover:text-red-600"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @include('page.admin.teacher-section.edit-teacher-modal')
                @empty
                    <tr>
                        <td colspan="9" class="px-4 py-4 text-center text-gray-500">No teachers found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-6">
            {{ $teachers->links('pagination::tailwind') }}
        </div>
    </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const openBtn = document.getElementById("openFilterModal");
    const modal = document.getElementById("filter-teacher-modal");

    if (!modal) return;

    const closeBtns = modal.querySelectorAll("[data-modal-hide]");

    openBtn?.addEventListener("click", () => {
        modal.classList.remove("hidden");
    });

    closeBtns.forEach(btn => {
        btn.addEventListener("click", () => {
            modal.classList.add("hidden");
        });
    });
});

</script>

@include('page.admin.teacher-section.filter-teacher-modal')

@endsection
