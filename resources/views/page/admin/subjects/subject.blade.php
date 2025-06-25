@extends('page.admin.parent')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center mb-8 text-blue-700">📚 Manage Classes</h1>



        <!-- Add Class Form -->
        <div
            class="bg-white shadow-md rounded-xl p-6 mb-10 border border-gray-200 transition-transform duration-300 hover:shadow-lg">
            <form action="{{ route('subjects.store') }}" method="POST" class="flex flex-col md:flex-row items-center gap-4">
                @csrf
                <input type="text" name="name" placeholder="Enter Subject Name" required
                    class="flex-1 px-4 py-2  border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 transition">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Subject Code</label>
                    <input type="text" name="code" placeholder="e.g. MATH101"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 hover:scale-105 transition">
                    ➕ Add Subject
                </button>
            </form>
        </div>

        <!-- Class List Table -->
        <div class="overflow-x-auto bg-white shadow-md rounded-xl border border-gray-200 animate-fade-in">
            <table class="min-w-full table-auto text-sm text-left text-gray-700">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4">#</th>
                        <th class="px-6 py-4">Subject Name</th>
                        <th class="px-6 py-4">Subject code</th>

                        <th class="px-6 py-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subjects as $index => $subject)
                        <tr class="border-t hover:bg-blue-50 transition duration-200">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">{{ $subject->name }}</td>
                            <td class="px-6 py-4">{{ $subject->code }}</td>

                            <td class="px-6 py-4 text-center">
                                <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this class?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-800 font-semibold transition hover:scale-105">
                                        🗑 Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center px-6 py-4 text-gray-500">No subjects found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Fade animation -->
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
    </style>
@endsection
