@extends('page.admin.parent')

@section('content')
    <div class="w-full max-w-md mx-auto bg-white shadow-lg rounded-xl p-6 space-y-4">
        {{-- Flash Messages --}}
        @if (session('error'))
            <div class="bg-red-100 text-red-700 border border-red-300 p-3 rounded-md shadow">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="bg-green-100 text-green-700 border border-green-300 p-3 rounded-md shadow">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('store.section') }}" method="POST">
            @csrf

            <!-- Class Selection -->
            <div>
                <label for="class" class="block text-sm font-medium text-gray-700 mb-1">Select Class</label>
                <select name="class" id="class" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Choose --</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Section Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Select Sections</label>
                <div class="flex flex-wrap gap-4">
                    @foreach (['A', 'B', 'C', 'D', 'E'] as $section)
                        <label class="inline-flex items-center space-x-2">
                            <input type="checkbox" name="sections[]" value="{{ $section }}"
                                class="text-blue-500 focus:ring-blue-500">
                            <span>Section {{ $section }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <button type="submit"
                class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition">
                ➕ Save Sections
            </button>
        </form>
    </div>

    {{-- Class List Table --}}
    <div class="max-w-4xl mx-auto mt-10 bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">📚 Class Sections List</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-green-100 text-left text-sm text-gray-700 uppercase">
                        <th class="px-4 py-3">Class</th>
                        <th class="px-4 py-3">Sections</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800">
                    @foreach ($groupedSections as $classId => $sections)
                        <tr class="border-b hover:bg-green-50 transition">
                            <td class="px-4 py-3 font-medium">Class {{ $classId }}</td>
                            <td class="px-4 py-3 space-x-2">
                                @foreach ($sections as $section)
                                    <span
                                        class="inline-block bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-md">{{ $section->name }}</span>
                                @endforeach
                            </td>
                            <td class="px-4 py-3 space-x-2">
                                <a href=""
                                    class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">✏️ Edit</a>
                                <form action="" method="POST"
                                    class="inline-block"
                                    onsubmit="return confirm('Are you sure you want to delete this class\'s sections?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-800 font-medium text-sm">🗑️ Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

