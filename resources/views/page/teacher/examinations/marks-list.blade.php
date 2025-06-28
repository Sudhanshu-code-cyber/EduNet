@extends('page.teacher.parent')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-blue-800">Marks Entry</h1>

        <!-- Filter Form -->

@php
    $selected_exam = $selected_exam ?? null;
    $selected_class = $selected_class ?? null;
    $selected_section = $selected_section ?? null;
@endphp


      <form method="POST" action="{{ route('marks.list') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    @csrf

    <div>
        <label class="block font-semibold text-sm mb-1">Exam Type</label>
        <select name="exam_master_id" class="w-full border border-gray-300 p-2 rounded" required>
            <option value="">Select Exam</option>
            @foreach ($exams as $exam)
                <option value="{{ $exam->id }}" {{ $selected_exam == $exam->id ? 'selected' : '' }}>
                    {{ $exam->exam_name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block font-semibold text-sm mb-1">Class</label>
        <select name="class_id" id="list_class_id" class="w-full border border-gray-300 p-2 rounded" required>
            <option value="">Select Class</option>
            @foreach ($classes as $class)
                <option value="{{ $class->id }}" {{ $selected_class == $class->id ? 'selected' : '' }}>
                    {{ $class->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block font-semibold text-sm mb-1">Section</label>
        <select name="section_id" id="list_section_id" class="w-full border border-gray-300 p-2 rounded" required>
            <option value="">Select Section</option>
            @foreach ($sections as $section)
                <option value="{{ $section->id }}" {{ $selected_section == $section->id ? 'selected' : '' }}>
                    {{ $section->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="flex items-end">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full">
            Search
        </button>
    </div>
</form>


        <!-- Static Table (Demo Purpose Only) -->
    @if($selected_exam && $selected_class && $selected_section && $students->count())
<div class="bg-white shadow rounded-lg overflow-x-auto">
    <table class="min-w-full text-sm text-left">
        <thead class="bg-gray-100 text-gray-700">
            <tr>
                <th class="p-4">Student Name</th>
                @foreach($subjects as $subject)
                    <th class="p-4">
                        {{ $subject->subject->name }}<br>
                        <span class="text-xs">({{ $subject->pass_marks }}/{{ $subject->max_marks }})</span>
                    </th>
                @endforeach
                <th class="p-4">Total</th>
                <th class="p-4">Obtained</th>
                <th class="p-4">Result</th>
                <th class="p-4">%</th>
                <th class="p-4">Action</th>
            </tr>
        </thead>
        <tbody class="text-gray-800">
            @foreach($students as $student)
                @php
                    $total = $subjects->sum('max_marks');
                    $obtained = 0;
                    $fail = false;
                    $marks = [];

                    foreach ($subjects as $subj) {
                        $entry = \App\Models\MarksEntry::where('student_id', $student->id)
                            ->where('exam_master_id', request('exam_master_id'))
                            ->where('subject_id', $subj->subject_id)
                            ->first();

                       $mark = $entry->marks_obtained ?? null;
                        $obtained += $mark;
                        $fail = $fail || $mark < $subj->pass_marks;
                        $marks[$subj->subject_id] = $mark;
                    }

                    $percentage = $total ? round(($obtained / $total) * 100, 2) : 0;
                @endphp

                <tr class="border-b hover:bg-gray-50">
                    <td class="p-4 font-medium">{{ $student->full_name }}</td>

               @foreach($subjects as $subject)
    <td class="p-4">
        {{ $marks[$subject->subject_id] ?? '-' }}
    </td>
@endforeach


                    <td class="p-4">{{ $total }}</td>
                    <td class="p-4">{{ $obtained }}</td>
                    <td class="p-4 {{ $fail ? 'text-red-600' : 'text-green-600' }}">
                        {{ $fail ? 'Fail' : 'Pass' }}
                    </td>
                    <td class="p-4">{{ $percentage }}%</td>
                   <td class="p-4 space-x-2">
    {{-- Edit Button (opens modal) --}}
    <button onclick="openEditModal('{{ $student->id }}')" class="bg-blue-500 text-white px-2 py-1 rounded text-xs">Edit</button>

    {{-- Delete Form --}}
    <form method="POST" action="{{ route('marks.entry.delete') }}" class="inline">
        @csrf
        @method('DELETE')
        <input type="hidden" name="student_id" value="{{ $student->id }}">
        <input type="hidden" name="exam_master_id" value="{{ request('exam_master_id') }}">
        <button type="submit" onclick="return confirm('Are you sure you want to delete this student\'s marks?')" class="bg-red-500 text-white px-2 py-1 rounded text-xs">
            Delete
        </button>
    </form>
</td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="text-gray-500 text-sm italic">No data to display. Please search using the filters above.</div>
@endif

    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const classDropdown = document.getElementById('list_class_id');
    const sectionDropdown = document.getElementById('list_section_id');

    classDropdown.addEventListener('change', function () {
        const classId = this.value;

        // Clear existing options
        sectionDropdown.innerHTML = '<option value="">Loading...</option>';

        fetch(`/teacher/marks-list/sections/${classId}`)
            .then(response => response.json())
            .then(sections => {
                sectionDropdown.innerHTML = '<option value="">Select Section</option>';
                sections.forEach(section => {
                    sectionDropdown.innerHTML += `<option value="${section.id}">${section.name}</option>`;
                });
            })
            .catch(error => {
                console.error("Error fetching sections:", error);
                sectionDropdown.innerHTML = '<option value="">Error loading sections</option>';
            });
    });
});
</script>

@endsection

<!-- Edit Marks Modal -->
<div id="editMarksModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 relative">
        <button onclick="closeEditModal()" class="absolute top-2 right-2 text-gray-500 hover:text-red-600 text-xl">&times;</button>
        <h2 class="text-xl font-bold mb-4">Edit Marks</h2>
        <div id="editMarksContent">
            <div class="text-gray-500">Loading...</div>
        </div>
    </div>
</div>
<script>
function openEditModal(studentId) {
    const examId = document.querySelector('select[name="exam_master_id"]').value;

   const url = `{{ url('/teacher/marks-entry') }}/edit/${studentId}/${examId}`;
    document.getElementById('editMarksModal').classList.remove('hidden');
    document.getElementById('editMarksContent').innerHTML = '<div class="text-gray-500">Loading...</div>';

    fetch(url)
        .then(res => res.text())
        .then(html => {
            document.getElementById('editMarksContent').innerHTML = html;
        })
        .catch(err => {
            document.getElementById('editMarksContent').innerHTML = '<div class="text-red-500">Error loading marks form.</div>';
        });
}

function closeEditModal() {
    document.getElementById('editMarksModal').classList.add('hidden');
}
</script>
