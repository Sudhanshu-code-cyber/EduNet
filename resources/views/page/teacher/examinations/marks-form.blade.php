
<form id="marksForm" class="space-y-6">
    @csrf

<!-- Student Header -->
<div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4">
    <h2 class="text-lg font-bold text-blue-700">
        Entering Marks for: (Class: {{ $student->class->name }} | Section: {{ $student->section->name }})
    </h2>
</div>



    <input type="hidden" name="exam_master_id" value="{{ $exam_master_id }}">
    <input type="hidden" name="class_id" value="{{ $class_id }}">
    <input type="hidden" name="section_id" value="{{ $section_id }}">
    <input type="hidden" name="student_id" id="student_id" value="{{ $student->id }}">

    <!-- Student Info -->
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block font-medium text-gray-700">Student Name</label>
            <input type="text" value="{{ $student->full_name }}" class="w-full border p-2 rounded bg-gray-100" readonly>
        </div>
       <div>
 <div>
            <label class="block font-medium text-gray-700">Roll No.</label>
            <input type="text" value="{{ $student->roll_no }}" class="w-full border p-2 rounded bg-gray-100" readonly>
        </div>
       </div>
    </div>

    <!-- Subject Marks -->
    <div class="grid grid-cols-4 gap-4">
        @foreach ($subjects as $subject)
            <div>
                <label class="block font-medium text-gray-700">
                    {{ $subject->subject->name }} ({{ $subject->pass_marks }}/{{ $subject->max_marks }})
                </label>
                <input type="number"
                       name="subject_marks[{{ $subject->subject->id }}]"
                       class="w-full border p-2 rounded"
                       min="0"
                       max="{{ $subject->max_marks }}"
                       data-max="{{ $subject->max_marks }}">
            </div>
        @endforeach
    </div>

    <!-- Totals -->
    <div class="grid grid-cols-3 gap-4 pt-4">
        <div>
            <label class="block font-medium text-gray-700">Total</label>
            <input type="text" id="totalMarks" class="w-full border p-2 rounded bg-gray-100" readonly>
        </div>
        <div>
            <label class="block font-medium text-gray-700">Obtained</label>
            <input type="text" id="obtainedMarks" class="w-full border p-2 rounded bg-gray-100" readonly>
        </div>
        <div>
            <label class="block font-medium text-gray-700">Result</label>
            <input type="text" id="resultStatus" class="w-full border p-2 rounded bg-gray-100" readonly>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex justify-end space-x-4 pt-4">
        <button type="button" id="saveNext" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save & Next</button>
       <div>
<a href="{{ route('marks.entry.print', ['student_id' => $student->id, 'exam_id' => $exam->id]) }}" 
    target="_blank"   class="text-sm bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
    Print Marksheet
</a>
       </div>
    </div>
</form>