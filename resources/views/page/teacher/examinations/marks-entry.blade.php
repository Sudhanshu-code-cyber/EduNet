@extends('page.teacher.parent')

@section('content')
<div class="max-w-5xl mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Marks Entry</h1>

    {{-- Top Search Form --}}
    <form method="POST" action="{{ route('marks.entry.search') }}" class="grid grid-cols-4 gap-4 mb-6">
        @csrf
        <div>
            <label>Exam Type</label>
            <select name="exam_master_id" class="w-full border p-2" required>
                <option value="">Select Exam</option>
                @foreach($exams as $exam)
                    <option value="{{ $exam->id }}" {{ request('exam_master_id') == $exam->id ? 'selected' : '' }}>
                        {{ $exam->exam_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="classDropdown">Class</label>
            <select name="class_id" id="class_id" class="w-full border p-2" required>
                <option value="">Select Class</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                        {{ $class->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="sectionDropdown">Section</label>
            <select name="section_id" id="sectionDropdown" class="w-full border p-2" required>
                <option value="">Select Section</option>
                @if(!empty($sections))
                    @foreach($sections as $section)
                        <option value="{{ $section->id }}" {{ request('section_id') == $section->id ? 'selected' : '' }}>
                            {{ $section->name }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>

        <div class="flex items-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded w-full">Search</button>
        </div>
    </form>

    {{-- Student Marks Form --}}
    <div id="marksFormWrapper">
        @if(isset($student))
            @if($subjects && count($subjects) > 0)
                <form id="marksForm">
                    @csrf
                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                    <input type="hidden" name="exam_master_id" value="{{ $exam_master_id }}">
                    <input type="hidden" id="class_id" value="{{ $class_id }}">
                    <input type="hidden" id="section_id" value="{{ $section_id }}">

                    <h2 class="text-xl mb-4">Student: {{ $student->name }} | Roll No: {{ $student->roll_no }}</h2>

                    <div class="grid grid-cols-3 gap-4">
                        @foreach ($subjects as $item)
                            <div>
                                <label for="subject_{{ $item->subject->id }}">
                                    {{ $item->subject->name }} (Pass: {{ $item->pass_marks }} / Max: {{ $item->max_marks }})
                                </label>
                                <input 
                                    type="number"
                                    id="subject_{{ $item->subject->id }}"
                                    name="subject_marks[{{ $item->subject->id }}]"
                                    class="subject-input border p-2 w-full"
                                    min="0"
                                    max="{{ $item->max_marks }}"
                                    required
                                    oninput="validateAndCalculate(false)"
                                    data-max="{{ $item->max_marks }}"
                                    data-pass="{{ $item->pass_marks }}"
                                >
                                <span class="error-msg text-red-500 text-sm hidden">Invalid Marks</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="grid grid-cols-4 gap-4 mt-4">
                        <input type="text" id="total" class="border p-2" placeholder="Total Marks" readonly>
                        <input type="text" id="obtained" class="border p-2" placeholder="Marks Obtained" readonly>
                        <input type="text" id="percentage" class="border p-2" placeholder="Percentage %" readonly>
                        <input type="text" id="result" class="border p-2" placeholder="Result" readonly>
                    </div>

                    <div class="mt-4 flex gap-2">
                        <button type="submit" id="saveBtn" class="bg-blue-600 text-white px-4 py-2 rounded" disabled>Save & Next</button>
                        <button type="button" onclick="window.print()" class="bg-gray-600 text-white px-4 py-2 rounded">Print</button>
                    </div>
                </form>
            @else
                <p class="text-red-600">No subjects found for this class.</p>
            @endif
        @else
            <p class="text-gray-600 text-center">Please search by Exam Type, Class and Section to begin entering marks.</p>
        @endif
    </div>
</div>
@endsection

@section('scripts')

{{--  validateAndCalculate() and submission JS code --}}
<script>
function validateAndCalculate(showErrors = false) {
    let totalObtained = 0;
    let totalMax = 0;
    let isValid = true;
    const inputs = document.querySelectorAll('.subject-input');

    inputs.forEach(input => {
        const valStr = input.value.trim();
        const val = parseFloat(valStr);
        const max = parseFloat(input.dataset.max);
        const pass = parseFloat(input.dataset.pass);
        const errorMsg = input.nextElementSibling;

        errorMsg.classList.add('hidden');
        input.classList.remove('border-red-500');

        if (valStr === '') {
            if (showErrors) {
                errorMsg.textContent = "Marks required";
                errorMsg.classList.remove('hidden');
                input.classList.add('border-red-500');
            }
            isValid = false;
        } else if (isNaN(val) || val < 0 || val > max) {
            if (showErrors) {
                errorMsg.textContent = `Marks must be between 0 and ${max}`;
                errorMsg.classList.remove('hidden');
                input.classList.add('border-red-500');
            }
            isValid = false;
        } else {
            totalObtained += val;
            totalMax += max;
        }
    });

    const totalField = document.getElementById('total');
    const obtainedField = document.getElementById('obtained');
    const percentageField = document.getElementById('percentage');
    const resultField = document.getElementById('result');
    const saveBtn = document.getElementById('saveBtn');

    if (isValid && totalMax > 0) {
        const percentage = ((totalObtained / totalMax) * 100).toFixed(2);
        totalField.value = totalMax;
        obtainedField.value = totalObtained;
        percentageField.value = percentage;
        resultField.value = checkPassFail(inputs);
        if (saveBtn) saveBtn.disabled = false;
    } else {
        totalField.value = '';
        obtainedField.value = '';
        percentageField.value = '';
        resultField.value = '';
        if (saveBtn) saveBtn.disabled = true;
    }
}


function checkPassFail(inputs) {
    for (const input of inputs) {
        const val = parseFloat(input.value);
        const pass = parseFloat(input.dataset.pass);
        if (val < pass) return 'Fail';
    }
    return 'Pass';
}

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('marksForm');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        validateAndCalculate(true);

        const formData = new FormData(form);

        fetch("{{ route('marks.entry.save') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const nextFormData = new FormData();
                nextFormData.append('current_student_id', formData.get('student_id'));
                nextFormData.append('class_id', document.getElementById('class_id').value);
                nextFormData.append('section_id', document.getElementById('section_id').value);
                nextFormData.append('exam_master_id', formData.get('exam_master_id'));

                fetch("{{ route('marks.entry.next') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: nextFormData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.done) {
                        alert("All students completed!");
                        document.getElementById('marksFormWrapper').innerHTML = `<p class="text-center text-gray-600">All students completed!</p>`;
                    } else {
                        document.getElementById('marksFormWrapper').innerHTML = data.html;
                    }
                });
            }
        });
    });
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const classDropdown = document.getElementById('class_id');
    const sectionDropdown = document.getElementById('sectionDropdown'); 

        classDropdown.addEventListener('change', function () {
            const classId = this.value;

            if (!classId) {
                sectionDropdown.innerHTML = '<option value="">Select Section</option>';
                return;
            }

            fetch(`/teacher/marks-entry/class-sections?class_id=${classId}`)
                .then(response => response.json())
                .then(data => {
                    console.log("Sections loaded from backend:", data);
                    sectionDropdown.innerHTML = '<option value="">Select Section</option>';
                    data.forEach(section => {
                        sectionDropdown.innerHTML += `<option value="${section.id}">${section.name}</option>`;
                    });
                })
                .catch(error => {
                    console.error('Error fetching sections:', error);
                });
        });
    });
</script>


@endsection
