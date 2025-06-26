@extends('page.teacher.parent')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Marks Entry</h1>

    {{-- Search Filter --}}
    <form method="POST" action="{{ route('marks.entry.search') }}" class="grid grid-cols-4 gap-4 mb-6">
        @csrf
        <div>
            <label class="block font-semibold">Exam Type</label>
            <select name="exam_master_id" class="w-full border p-2 rounded">
                <option value="">Select Exam</option>
                @foreach ($exams as $exam)
                    <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-semibold">Class</label>
            <select name="class_id" id="class_id" class="w-full border p-2 rounded">
                <option value="">Select Class</option>
                @foreach ($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-semibold">Section</label>
            <select name="section_id" id="section_id" class="w-full border p-2 rounded">
                <option value="">Select Section</option>
                @foreach ($sections as $section)
                    <option value="{{ $section->id }}">{{ $section->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex items-end">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Search</button>
        </div>
    </form>

    @isset($students)
        <div class="overflow-auto">
            <form id="marksForm">
                @csrf
                <input type="hidden" name="exam_master_id" value="{{ $exam_master_id }}">
                <input type="hidden" name="class_id" value="{{ $class_id }}">
                <input type="hidden" name="section_id" value="{{ $section_id }}">
                <input type="hidden" name="student_id" id="student_id" value="{{ $student->id }}">

                <table class="table-auto w-full border mb-4">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-4 py-2">Roll No</th>
                            <th class="border px-4 py-2">Student Name</th>
                            @foreach ($subjects as $subject)
                                <th class="border px-4 py-2">
                                    {{ $subject->subject->name }}<br>
                                    ({{ $subject->pass_marks }}/{{ $subject->max_marks }})
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border px-4 py-2">{{ $student->roll_no }}</td>
                            <td class="border px-4 py-2">{{ $student->name }}</td>
                            @foreach ($subjects as $subject)
                                <td class="border px-4 py-2">
                                    <input type="number" name="subject_marks[{{ $subject->subject->id }}]" class="border p-1 w-20 rounded">
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>

                <div class="flex justify-between">
                    <button type="button" id="saveMarks" class="bg-green-500 text-white px-4 py-2 rounded">Save</button>
                    <button type="button" id="saveNext" class="bg-blue-600 text-white px-4 py-2 rounded">Save & Next</button>
                </div>
            </form>
        </div>
    @endisset
</div>

<script>
    document.getElementById('class_id').addEventListener('change', function () {
        const classId = this.value;
        fetch(`/teacher/get-sections/${classId}`)
            .then(res => res.json())
            .then(data => {
                let sectionSelect = document.getElementById('section_id');
                sectionSelect.innerHTML = '<option value="">Select Section</option>';
                data.sections.forEach(section => {
                    sectionSelect.innerHTML += `<option value="${section.id}">${section.name}</option>`;
                });
            });
    });

    document.getElementById('saveMarks')?.addEventListener('click', function () {
        let formData = new FormData(document.getElementById('marksForm'));
        fetch('{{ route('marks.entry.save') }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) alert('Marks saved successfully');
        });
    });

    document.getElementById('saveNext')?.addEventListener('click', function () {
        let form = document.getElementById('marksForm');
        let formData = new FormData(form);
        fetch('{{ route('marks.entry.save') }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                fetch('{{ route('marks.entry.next') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': formData.get('_token') },
                    body: JSON.stringify({
                        current_student_id: document.getElementById('student_id').value,
                        exam_master_id: formData.get('exam_master_id'),
                        class_id: formData.get('class_id'),
                        section_id: formData.get('section_id')
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.done) {
                        alert('All students completed!');
                    } else {
                        document.querySelector('tbody').innerHTML = data.html;
                        document.getElementById('student_id').value = document.querySelector('[name=student_id]').value;
                    }
                });
            }
        });
    });
</script>
@endsection
