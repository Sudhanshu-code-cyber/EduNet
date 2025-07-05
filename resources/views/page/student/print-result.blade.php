<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Marksheet</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            @page {
                margin: 1cm;
            }
            body {
                background: white;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body class="bg-white text-gray-900 font-sans text-sm leading-relaxed">

<div class="max-w-4xl mx-auto p-8 border border-gray-300 rounded shadow-lg bg-white">
    <!-- Header Section -->
    <div class="flex justify-between items-center border-b border-gray-300 pb-4 mb-4">
          <img src="{{ asset('storage/homeworks/images.jpeg') }}" alt="School Logo" class="w-32 h-24 object-cover rounded">

        <div class="text-center flex-1">
            <h1 class="text-3xl font-bold uppercase tracking-wide">ABC International School</h1>
            <p class="text-sm text-gray-600 mt-1">123 Knowledge Street, Learning City, India</p>
        </div>
        <img src="{{ asset('uploads/students/' . $student->photo) }}" alt="Student Photo" class="w-16 h-16 object-cover rounded-full border border-gray-300">
    </div>

    <!-- Student Details -->
    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-6 text-gray-700">
        <p><span class="font-semibold">Name:</span> {{ $student->full_name }}</p>
        <p><span class="font-semibold">Admission No:</span> {{ $student->roll_no }}</p>
        <p><span class="font-semibold">Gender:</span> {{ ucfirst($student->gender) }}</p>
        <p><span class="font-semibold">Class:</span> {{ $student->class->name ?? '-' }}</p>
        <p><span class="font-semibold">Section:</span> {{ $student->section->name ?? '-' }}</p>
        <p><span class="font-semibold">Term:</span> {{ $exam->exam_name ?? '-' }}</p>
    </div>

    <!-- Marks Table -->
    <div class="overflow-x-auto">
        <table class="w-full border border-collapse text-center">
            <thead class="bg-gray-100 text-sm uppercase tracking-wide">
                <tr>
                    <th class="border p-2">Subject</th>
                    <th class="border p-2">Max Marks</th>
                    <th class="border p-2">Pass Marks</th>
                    <th class="border p-2">Obtained</th>
                    <th class="border p-2">Result</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                    $obtained = 0;
                    $fail = false;
                @endphp

                @foreach($subjects as $subject)
                    @php
                        $subjectId = $subject->subject_id;
                        $maxMarks = $subject->max_marks;
                        $passMarks = $subject->pass_marks;
                        $entry = $marks[$subjectId] ?? null;
                        $mark = $entry->marks_obtained ?? 0;

                        $total += $maxMarks;
                        $obtained += $mark;
                        $isFail = $mark < $passMarks;
                        $fail = $fail || $isFail;
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="border p-2 text-left">{{ $subject->subject->name }}</td>
                        <td class="border p-2">{{ $maxMarks }}</td>
                        <td class="border p-2">{{ $passMarks }}</td>
                        <td class="border p-2">{{ $mark }}</td>
                        <td class="border p-2 font-semibold {{ $isFail ? 'text-red-600' : 'text-green-600' }}">
                            {{ $isFail ? 'Fail' : 'Pass' }}
                        </td>
                    </tr>
                @endforeach

                <!-- Summary Row -->
                <tr class="bg-gray-100 font-semibold">
                    <td class="border p-2">Total</td>
                    <td class="border p-2">{{ $total }}</td>
                    <td class="border p-2">—</td>
                    <td class="border p-2">{{ $obtained }}</td>
                    <td class="border p-2 {{ $fail ? 'text-red-600' : 'text-green-600' }}">
                        {{ $fail ? 'Fail' : 'Pass' }}
                    </td>
                </tr>
                <tr class="bg-blue-50 font-semibold text-blue-800">
                    <td colspan="4" class="text-right border p-2">Percentage</td>
                    <td class="border p-2 text-lg">
                        {{ $total ? round(($obtained / $total) * 100, 2) : 0 }}%
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Remarks -->
    <div class="mt-6 text-gray-700 text-sm border-t pt-4">
        <p><span class="font-semibold">Remarks:</span>
            @if($fail)
                Needs improvement in some subjects.
            @else
                Excellent performance. Keep it up!
            @endif
        </p>
    </div>

    <!-- Footer -->
    <div class="mt-10 flex justify-between items-center text-sm text-gray-600">
        <p>Generated on: {{ now()->format('d-m-Y') }}</p>
        <div class="text-center">
            <p class="border-t border-gray-400 w-48 pt-2">Principal's Signature</p>
        </div>
    </div>
</div>

<script>
    window.onload = function () {
        window.print();
    }
</script>
</body>
</html>
