@extends('page.admin.parent')
@section('content')
<div class="max-w-4xl mx-auto bg-white shadow p-6 rounded mt-16">
    <h2 class="text-xl font-semibold mb-4">Assign Teacher Timetable</h2>
    
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-2 rounded mb-4">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('timetable.store') }}">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label>Teacher</label>
                <select id="teacher" name="teacher_id" class="w-full border p-2 rounded" required>
                    <option value="">Select Teacher</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->first_name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Class</label>
                <select id="class" name="class_id" class="w-full border p-2 rounded" required>
                    <option value="">Select Class</option>
                </select>
            </div>

            <div>
                <label>Section (optional)</label>
                <select id="section" name="section_id" class="w-full border p-2 rounded">
                    <option value="">Select Section</option>
                </select>
            </div>

            <div>
                <label>Subject</label>
                <select id="subject" name="subject_id" class="w-full border p-2 rounded" required>
                    <option value="">Select Subject</option>
                </select>
            </div>

            <div>
                <label>Period</label>
                <select name="period_id" class="w-full border p-2 rounded" required>
                    @foreach($periods as $period)
                        <option value="{{ $period->id }}">Period {{ $period->period_number }} ({{ $period->start_time }} - {{ $period->end_time }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label>Day</label>
                <select name="day_of_week" class="w-full border p-2 rounded" required>
                    @foreach($days as $day)
                        <option value="{{ $day }}">{{ $day }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mt-4">
            <button class="bg-blue-500 text-white px-4 py-2 rounded">Assign</button>
        </div>
    </form>
</div>

<script>
document.getElementById('teacher').addEventListener('change', function () {
    const teacherId = this.value;
    if (teacherId) {
        fetch(`/get-assignments-by-teacher/${teacherId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('class').innerHTML = '<option value="">Select Class</option>';
                document.getElementById('section').innerHTML = '<option value="">Select Section</option>';
                document.getElementById('subject').innerHTML = '<option value="">Select Subject</option>';

                data.classes.forEach(c => {
                    document.getElementById('class').innerHTML += `<option value="${c.id}">${c.name}</option>`;
                });
            });
    } else {
        document.getElementById('class').innerHTML = '<option value="">Select Class</option>';
        document.getElementById('section').innerHTML = '<option value="">Select Section</option>';
        document.getElementById('subject').innerHTML = '<option value="">Select Subject</option>';
    }
});

document.getElementById('class').addEventListener('change', function () {
    const teacherId = document.getElementById('teacher').value;
    const classId = this.value;

    if (teacherId && classId) {
        fetch(`/get-sections-subjects/${teacherId}/${classId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('section').innerHTML = '<option value="">Select Section</option>';
                document.getElementById('subject').innerHTML = '<option value="">Select Subject</option>';

                data.sections.forEach(s => {
                    document.getElementById('section').innerHTML += `<option value="${s.id}">${s.name}</option>`;
                });
                data.subjects.forEach(sub => {
                    document.getElementById('subject').innerHTML += `<option value="${sub.id}">${sub.name}</option>`;
                });
            });
    }
});
</script>
@endsection
