@extends('page.teacher.parent')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">
    <!-- Search Filter Card -->
    <div class="bg-white border shadow rounded-lg p-6 mb-10 ">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Search Students for Marks Entry</h2>
        <form method="POST" action="{{ route('marks.entry.search') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            @csrf
            <div>
                <label class="block font-semibold text-sm mb-1">Exam Type</label>
                <select name="exam_master_id" class="w-full border border-gray-300 p-2 rounded" required>
                    <option value="">Select Exam</option>
                    @foreach ($exams as $exam)
                        <option value="{{ $exam->id }}">{{ $exam->exam_name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-semibold text-sm mb-1">Class</label>
                <select name="class_id" id="class_id" class="w-full border border-gray-300 p-2 rounded" required>
                    <option value="">Select Class</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-semibold text-sm mb-1">Section</label>
                <select name="section_id" id="section_id" class="w-full border border-gray-300 p-2 rounded" required>
                    <option value="">Select Section</option>
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full">
                    Search
                </button>
            </div>
        </form>
    </div>

    <!-- Marks Entry Card -->
    @if(isset($student))
    <div class="bg-white border shadow rounded-lg p-6" id="marksWrapper">
       

        {{-- Include the student marks form --}}
        @include('page.teacher.examinations.marks-form')
    </div>
    @endif
</div>

<script>
function attachClassChangeHandler() {
    const classDropdown = document.getElementById('class_id');
    if (classDropdown) {
        classDropdown.addEventListener('change', function () {
            const classId = this.value;
        fetch("{{ route('marks.getSections', ['class_id' => '__CLASS_ID__']) }}".replace('__CLASS_ID__', classId))
                .then(res => res.json())
                .then(sections => {
                    let sectionSelect = document.getElementById('section_id');
                    sectionSelect.innerHTML = '<option value="">Select Section</option>';
                    sections.forEach(section => {
                        sectionSelect.innerHTML += `<option value="${section.id}">${section.name}</option>`;
                    });
                });
        });
    }
}


function attachSaveAndNextHandler() {
    const btn = document.getElementById('saveNext');
    if (!btn) return;

    btn.addEventListener('click', function () {
        const form = document.getElementById('marksForm');
        const formData = new FormData(form);

        fetch("{{ route('marks.entry.save') }}", {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': formData.get('_token') },
            body: formData
        })
        .then(res => res.json())
        .then(response => {
            if (response.success) {
                fetch("{{ route('marks.entry.next') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': formData.get('_token')
                    },
                    body: JSON.stringify({
                        current_student_id: formData.get('student_id'),
                        exam_master_id: formData.get('exam_master_id'),
                        class_id: formData.get('class_id'),
                        section_id: formData.get('section_id')
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.done) {
                        alert('All students completed!');
                        window.location.reload();
                    } else {
                       document.querySelector('#marksWrapper').innerHTML = `<div class="bg-white border shadow rounded-lg p-6">${data.view}</div>`;
                        attachMarksCalculationHandler();
                        attachSaveAndNextHandler();
                    }
                });
            }
        });
    });
}

function calculateMarks() {
    let obtained = 0, total = 0;
    document.querySelectorAll('input[name^="subject_marks"]').forEach(input => {
        let val = parseInt(input.value) || 0;
        obtained += val;
        total += parseInt(input.getAttribute('data-max')) || 0;
    });

    document.getElementById('totalMarks').value = total;
    document.getElementById('obtainedMarks').value = obtained;
    document.getElementById('resultStatus').value = (obtained >= total * 0.33) ? 'Pass' : 'Fail';
}

function attachMarksCalculationHandler() {
    document.querySelectorAll('input[name^="subject_marks"]').forEach(input => {
        input.addEventListener('input', calculateMarks);
    });
    calculateMarks();
}

// Attach all on page load
document.addEventListener('DOMContentLoaded', () => {
    attachClassChangeHandler();
    attachSaveAndNextHandler();
    attachMarksCalculationHandler();
});
</script>
@endsection
