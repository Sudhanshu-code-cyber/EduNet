@extends('page.teacher.parent')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">

    <!-- Search Filter Card -->
    <div class="bg-white border shadow rounded-lg p-6 mb-10">
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
            @include('page.teacher.examinations.marks-form')
        </div>
    @endif
</div>

{{-- JS --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    attachClassChangeHandler();
    attachSaveAndNextHandler();
    attachMarksCalculationHandler();
});

// Load Sections when class is selected
function attachClassChangeHandler() {
    const classDropdown = document.getElementById('class_id');
    const sectionDropdown = document.getElementById('section_id');

    classDropdown?.addEventListener('change', function () {
        const classId = this.value;
        sectionDropdown.innerHTML = '<option value="">Loading...</option>';

        fetch(`{{ route('marks.getSections', ['class_id' => '__CLASS_ID__']) }}`.replace('__CLASS_ID__', classId))
            .then(res => res.json())
            .then(sections => {
                sectionDropdown.innerHTML = '<option value="">Select Section</option>';
                sections.forEach(section => {
                    sectionDropdown.innerHTML += `<option value="${section.id}">${section.name}</option>`;
                });
            })
            .catch(() => {
                sectionDropdown.innerHTML = '<option value="">Error loading sections</option>';
            });
    });
}

// Save marks + load next student
function attachSaveAndNextHandler() {
    const btn = document.getElementById('saveNext');
    if (!btn) return;

    btn.addEventListener('click', function () {
        const form = document.getElementById('marksForm');
        const formData = new FormData(form);

        // === Validation ===
        let isValid = true;
        const errorMessages = [];

        form.querySelectorAll('input[name^="subject_marks"]').forEach(input => {
            const val = parseFloat(input.value);
            const max = parseFloat(input.getAttribute('data-max'));

            if (val > max) {
                isValid = false;
                input.classList.add('border-red-500');
                errorMessages.push(`${input.name} cannot exceed ${max}`);
            } else {
                input.classList.remove('border-red-500');
            }
        });

        if (!isValid) {
            alert('Some marks exceed maximum allowed. Please correct them.');
            return;
        }

        // Save marks
        fetch(`{{ route('marks.entry.save') }}`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': formData.get('_token') },
            body: formData
        })
        .then(res => res.json())
        .then(response => {
            if (response.success) {
                // Get next student
                fetch(`{{ route('marks.entry.next') }}`, {
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
                        document.getElementById('marksWrapper').innerHTML = `<div class="bg-white border shadow rounded-lg p-6">${data.view}</div>`;
                        attachSaveAndNextHandler();
                        attachMarksCalculationHandler();
                    }
                });
            } else {
                alert('Failed to save marks. Please try again.');
            }
        });
    });
}

// Auto-calculate totals & result
function calculateMarks() {
    let obtained = 0, total = 0;

    document.querySelectorAll('input[name^="subject_marks"]').forEach(input => {
        let val = parseFloat(input.value);
        let max = parseFloat(input.getAttribute('data-max'));

        if (!isNaN(val)) obtained += val;
        if (!isNaN(max)) total += max;
    });

    document.getElementById('totalMarks').value = total;
    document.getElementById('obtainedMarks').value = obtained;
    document.getElementById('resultStatus').value = (obtained >= total * 0.33) ? 'Pass' : 'Fail';
}

// Attach calculation to inputs
function attachMarksCalculationHandler() {
    const inputs = document.querySelectorAll('input[name^="subject_marks"]');
    inputs.forEach(input => {
        input.removeEventListener('input', calculateMarks); // Clean existing
        input.addEventListener('input', calculateMarks);    // Attach new
    });
    calculateMarks();
}
</script>
@endsection
