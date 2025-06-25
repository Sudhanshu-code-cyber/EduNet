<div class="overflow-x-auto bg-white shadow-md rounded-xl border border-gray-200">
   <table class="min-w-full table-auto text-sm text-left text-gray-700 border rounded-lg overflow-hidden">
    <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
        <tr>
            <th class="px-6 py-4">#</th>
            <th class="px-6 py-4">Subject Name</th>
            <th class="px-6 py-4">Class</th>
            <th class="px-6 py-4">Max Marks</th>
            <th class="px-6 py-4">Pass Marks</th>
            <th class="px-6 py-4 text-center">Actions</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @forelse($classSubjects as $index => $item)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4">{{ $index + 1 }}</td>
                <td class="px-6 py-4">{{ $item->subject->name ?? 'N/A' }}</td>
                <td class="px-6 py-4">{{ $item->class->name ?? 'N/A' }}</td>
                <td class="px-6 py-4">{{ $item->max_marks }}</td>
                <td class="px-6 py-4">{{ $item->pass_marks }}</td>
                <td class="px-6 py-4 text-center">
                    <form action="{{ route('class-sub.destroy', $item->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this assignment?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center px-6 py-4 text-gray-500">No subject-class assignments found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

</div>
