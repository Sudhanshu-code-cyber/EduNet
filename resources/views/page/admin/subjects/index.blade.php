@extends('page.admin.parent')

@section('content')
    <div class="max-w-5xl mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Manage Subjects</h2>

        <!-- Add Subject Form -->
        <div class="bg-white shadow-md border border-gray-200 rounded-xl p-6 mb-10">
            <form action="{{ route('class-sub.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-6 bg-white p-6 rounded-lg shadow">
    @csrf

    <!-- Class Dropdown -->
    <div class="col-span-1 md:col-span-2">
        <label class="block text-sm font-semibold text-gray-700 mb-1">Select Class</label>
        <select name="class_id" required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option disabled selected value="">-- Select Class --</option>
            @foreach ($classes as $class)
                <option value="{{ $class->id }}">{{ $class->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Existing Subject Dropdown -->
    <div class="col-span-1">
        <label class="block text-sm font-semibold text-gray-700 mb-1">Select Subject</label>
        <select name="subject_id" required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option disabled selected value="">-- Select Subject --</option>
            @foreach ($subjects as $subject)
                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Max Marks -->
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Max Marks</label>
        <input type="number" name="max_marks" placeholder="e.g. 100" min="0" required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <!-- Pass Marks -->
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Pass Marks</label>
        <input type="number" name="pass_marks" placeholder="e.g. 40" min="0" required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <!-- Submit Button -->
    <div class="md:col-span-4 text-right">
        <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition duration-300">
            Add Subject
        </button>
    </div>
</form>

        </div>

        <div class="max-w-6xl mx-auto px-6 py-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Manage Subjects</h2>
                <select id="classFilter"
                    class="border border-gray-300 px-4 py-2 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400">
                    <option value="">-- Select Class --</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Subjects Table -->
            <div id="subjectTable">
                @include('page.admin.subjects.table', ['subjects' => $subjects])
            </div>
        </div>

        <!-- AJAX Script -->
        <script>
            document.getElementById('classFilter').addEventListener('change', function() {
                const classId = this.value;
                const url = classId ? `/admin/subjects/filter/${classId}` : `/admin/subjects/filter`;

                fetch(url)
                    .then(res => res.text())
                    .then(data => {
                        document.getElementById('subjectTable').innerHTML = data;
                    })
                    .catch(err => {
                        console.error('Error loading subjects:', err);
                    });
            });
        </script>

        <!-- Subjects Table -->
        

    </div>
@endsection
