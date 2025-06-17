@extends('page.admin.parent')

@section('content')

<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md mt-10">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">Add Fee Type</h2>

    {{-- Fee Type Form --}}
    <form method="POST" action="{{ route('fee-types.store') }}" class="space-y-4">
        @csrf
        <div>
            <label for="name" class="block mb-1 font-medium text-gray-700">Fee Type Name</label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                placeholder="Fee Type Name"
                class="w-full rounded-md border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                required
            >
        </div>
        <div>
            <label for="frequency" class="block mb-1 font-medium text-gray-700">Frequency</label>
            <select 
                id="frequency" 
                name="frequency"
                class="w-full rounded-md border border-gray-300 px-4 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                required
            >
                <option value="monthly">Monthly</option>
                <option value="one_time">One-time</option>
            </select>
        </div>
        <button 
            type="submit" 
            class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-md shadow-md transition focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1"
        >
            Add
        </button>
    </form>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="mt-6 p-4 bg-green-100 text-green-800 rounded-md shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Existing Fee Types --}}
    <h3 class="text-xl font-semibold mt-10 mb-4 text-gray-800">Existing Fee Types</h3>
    <ul class="space-y-3">
        @foreach($feeTypes as $fee)
            <li class="flex justify-between items-center p-3 bg-green-50 border border-green-200 rounded-md text-gray-700 shadow-sm hover:bg-green-100 transition">
                <div>
                    <span class="font-medium">{{ $fee->name }}</span>
                    <span class="text-sm italic text-green-700 ml-2">
                        ({{ ucfirst($fee->frequency) }})
                    </span>
                </div>
                <div class="flex  gap-4 items-center justify-between">
                    <button 
                    onclick="openEditModal({{ $fee->id }}, '{{ $fee->name }}', '{{ $fee->frequency }}')" 
                    class="text-blue-600 hover:text-blue-800  text-sm font-semibold transition"
                >
                    Edit
                </button>
                    {{-- Delete --}}
                    <form action="{{ route('fee-types.destroy', $fee->id) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this fee type?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-semibold transition">
                            Delete
                        </button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
</div>



<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
        <h2 class="text-xl font-semibold mb-4">Edit Fee Type</h2>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Fee Type Name</label>
                <input type="text" name="name" id="editName" class="w-full border px-3 py-2 rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Frequency</label>
                <select name="frequency" id="editFrequency" class="w-full border px-3 py-2 rounded" required>
                    <option value="monthly">Monthly</option>
                    <option value="one_time">One-time</option>
                </select>
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeEditModal()" class="bg-gray-400 text-white px-4 py-2 rounded">Cancel</button>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Update</button>
            </div>
        </form>
        <button class="absolute top-2 right-2 text-gray-500 hover:text-black" onclick="closeEditModal()">✕</button>
    </div>
</div>

<script>
    function openEditModal(id, name, frequency) {
        document.getElementById('editName').value = name;
        document.getElementById('editFrequency').value = frequency;
        document.getElementById('editForm').action = `/fee-types/${id}`;
        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editModal').classList.add('flex');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.getElementById('editModal').classList.remove('flex');
    }
</script>

@endsection
