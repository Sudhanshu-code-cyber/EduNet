<!DOCTYPE html>
<html>
<head>
    <title>Print Marksheet</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        .header { text-align: center; }
        .student-info, .marks-table { margin-top: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background-color: #f5f5f5; }
        .footer { margin-top: 40px; text-align: center; }
        .pass { color: green; font-weight: bold; }
        .fail { color: red; font-weight: bold; }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h2>School Name</h2>
        <h4>Student Marksheet</h4>
        <p><strong>Exam:</strong> {{ $exam->exam_name ?? $exam->name }}</p>
    </div>

    <div class="student-info">
        <p><strong>Name:</strong> {{ $student->full_name }}</p>
        <p><strong>Roll No:</strong> {{ $student->roll_no }}</p>
        <p><strong>Class:</strong> {{ $student->class->name ?? 'N/A' }}</p>
        <p><strong>Section:</strong> {{ $student->section->name ?? 'N/A' }}</p>
    </div>

    <div class="marks-table">
        <table>
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Max Marks</th>
                    <th>Pass Marks</th>
                    <th>Obtained Marks</th>
                    <th>Result</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                    $obtained = 0;
                    $fail = false;
                @endphp

           @foreach ($subjects as $subject)
    @php
        $subjectId = $subject->subject->id ?? null;
        $entry = $marks[$subjectId] ?? null;
        $obtainedMarks = $entry->marks_obtained ?? 0;
        $maxMarks = $subject->max_marks ?? 0;
        $passMarks = $subject->pass_marks ?? 0;
        $result = $obtainedMarks >= $passMarks ? 'Pass' : 'Fail';
        $total += $maxMarks;
        $obtained += $obtainedMarks;
        if ($obtainedMarks < $passMarks) $fail = true;
    @endphp
    <tr>
        <td>{{ $subject->subject->name ?? 'N/A' }}</td>
        <td>{{ $maxMarks }}</td>
        <td>{{ $passMarks }}</td>
        <td>{{ $obtainedMarks }}</td>
        <td class="{{ $result == 'Pass' ? 'pass' : 'fail' }}">{{ $result }}</td>
    </tr>
@endforeach


                <tr>
                    <th colspan="3">Total</th>
                    <th>{{ $obtained }}</th>
                    <th>{{ $total }}</th>
                </tr>
                <tr>
                    <th colspan="4">Percentage</th>
                    <th>{{ $total ? round(($obtained / $total) * 100, 2) : 0 }}%</th>
                </tr>
                <tr>
                    <th colspan="4">Final Result</th>
                    <th class="{{ $fail ? 'fail' : 'pass' }}">{{ $fail ? 'Fail' : 'Pass' }}</th>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Generated on: {{ now()->format('d-m-Y') }}</p>
    </div>
</body>
</html>
