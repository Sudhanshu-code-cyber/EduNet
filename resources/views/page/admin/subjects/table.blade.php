<div class="overflow-x-auto bg-white shadow-md rounded-xl border border-gray-200">
    <table class="min-w-full table-auto text-sm text-left text-gray-700">
        <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
            <tr>
                <th class="px-6 py-4">#</th>
                <th class="px-6 py-4">Subject Name</th>
                <th class="px-6 py-4">Code</th>
                <th class="px-6 py-4">Class</th>
                <th class="px-6 py-4 text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($subjects as $index => $subject)
                <tr class="border-t hover:bg-gray-50 transition">
                    <td class="px-6 py-4">{{ $index + 1 }}</td>
                    <td class="px-6 py-4">{{ $subject->name }}</td>
                    <td class="px-6 py-4">{{ $subject->code ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $subject->class->name }}</td>
                    <td class="px-6 py-4 text-center">
                        <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this subject?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center px-6 py-4 text-gray-500">No subjects found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
