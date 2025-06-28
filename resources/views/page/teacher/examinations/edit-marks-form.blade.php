

<form method="POST"  action="{{ url('/teacher/marks-entry/update') }}">
    @csrf
    <input type="hidden" name="student_id" value="{{ $student->id }}">
    <input type="hidden" name="exam_master_id" value="{{ $exam_id }}">

    <table class="w-full text-sm mb-4">
        <thead class="text-left">
            <tr>
                <th class="p-2">Subject</th>
                <th class="p-2">Max Marks</th>
                <th class="p-2">Pass Marks</th>
                <th class="p-2">Marks Obtained</th>
            </tr>
        </thead>
        <tbody>
           @foreach ($subjects as $subject)
    <tr>
        <td class="p-2">{{ $subject->subject->name }}</td>
        <td class="p-2">{{ $subject->max_marks }}</td>
        <td class="p-2">{{ $subject->pass_marks }}</td>
        <td class="p-2">
            <input type="number" name="subject_marks[{{ $subject->subject->id }}]"
                   value="{{ $marks[$subject->subject->id] ?? '' }}"
                   class="border rounded px-2 py-1 w-20"
                   min="0" max="{{ $subject->max_marks }}">
        </td>
    </tr>
@endforeach

        </tbody>
    </table>

    <div class="text-right">
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Update</button>
        <button type="button" onclick="closeEditModal()" class="ml-2 text-gray-600 hover:text-red-500">Cancel</button>
    </div>
</form>

