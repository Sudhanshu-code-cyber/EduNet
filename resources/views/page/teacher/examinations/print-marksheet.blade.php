<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Marksheet</title>
    <style>
        body {
            font-family: 'Georgia', serif;
            margin: 40px;
            color: #000;
        }

        .container {
            max-width: 900px;
            margin: auto;
            border: 2px solid #444;
            padding: 30px;
        }

        .top-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo, .photo {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border: 2px solid #999;
            border-radius: 8px;
        }

        .header-text {
            text-align: center;
            flex: 1;
        }

        .header-text h2 {
            margin: 0;
            font-size: 26px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .header-text h4 {
            margin: 5px 0;
            font-size: 18px;
            color: #444;
        }

        .student-info {
            margin-top: 30px;
            line-height: 1.6;
        }

        .student-info p {
            margin: 4px 0;
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            font-size: 15px;
        }

        th, td {
            border: 1px solid #777;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .pass {
            color: green;
            font-weight: bold;
        }

        .fail {
            color: red;
            font-weight: bold;
        }

        .footer {
            margin-top: 60px;
            text-align: center;
            font-size: 14px;
        }

        .signature {
            text-align: right;
            margin-top: 60px;
        }

        .signature-line {
            display: inline-block;
            margin-top: 30px;
            border-top: 1px solid #000;
            width: 200px;
            text-align: center;
            font-weight: bold;
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                margin: 0;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="container">
        <!-- Header -->
        <div class="top-row">
          <img src="{{ asset('storage/homeworks/images.jpeg') }}" alt="School Logo" class="w-20 h-20 object-cover rounded">

            <div class="header-text">
                <h2>{{ config('app.name', 'ABC International School') }}</h2>
                <h4>123 Learning Road, Knowledge City, India</h4>
                <h4>Marksheet - {{ $exam->exam_name ?? $exam->name }}</h4>
            </div>

            <img src="{{ asset('uploads/students/' . $student->photo) }}" class="photo" alt="Student Photo">
        </div>

        <!-- Student Info -->
        <div class="student-info">
            <p><strong>Name:</strong> {{ $student->full_name }}</p>
            <p><strong>Roll No:</strong> {{ $student->roll_no }}</p>
            <p><strong>Class:</strong> {{ $student->class->name ?? 'N/A' }}</p>
            <p><strong>Section:</strong> {{ $student->section->name ?? 'N/A' }}</p>
        </div>

        <!-- Marks Table -->
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
                    $totalMax = 0;
                    $totalObtained = 0;
                    $fail = false;
                @endphp

                @foreach ($subjects as $classSubject)
                    @php
                        $subjectId = $classSubject->subject_id;
                        $subjectName = $classSubject->subject->name ?? 'N/A';

                        $entry = $marks->get($subjectId);
                        $obtainedMarks = $entry->marks_obtained ?? null;

                        $maxMarks = $classSubject->max_marks ?? 0;
                        $passMarks = $classSubject->pass_marks ?? 0;

                        $result = $obtainedMarks !== null && $obtainedMarks >= $passMarks ? 'Pass' : 'Fail';

                        if ($obtainedMarks !== null) {
                            $totalMax += $maxMarks;
                            $totalObtained += $obtainedMarks;
                            if ($obtainedMarks < $passMarks) {
                                $fail = true;
                            }
                        }
                    @endphp
                    <tr>
                        <td>{{ $subjectName }}</td>
                        <td>{{ $maxMarks }}</td>
                        <td>{{ $passMarks }}</td>
                        <td>{{ $obtainedMarks !== null ? $obtainedMarks : 'N/A' }}</td>
                        <td class="{{ $obtainedMarks === null ? '' : ($result === 'Pass' ? 'pass' : 'fail') }}">
                            {{ $obtainedMarks === null ? 'N/A' : $result }}
                        </td>
                    </tr>
                @endforeach

                <tr>
                    <th colspan="3">Total</th>
                    <th>{{ $totalObtained }}</th>
                    <th>{{ $totalMax }}</th>
                </tr>
                <tr>
                    <th colspan="4">Percentage</th>
                    <th>{{ $totalMax ? round(($totalObtained / $totalMax) * 100, 2) : 'N/A' }}%</th>
                </tr>
                <tr>
                    <th colspan="4">Final Result</th>
                    <th class="{{ $fail ? 'fail' : 'pass' }}">{{ $fail ? 'Fail' : 'Pass' }}</th>
                </tr>
            </tbody>
        </table>

        <!-- Footer -->
        <div class="footer">
            <p>Generated on: {{ now()->format('d-m-Y') }}</p>
            <p><em>This is a system-generated marksheet. No signature required.</em></p>
        </div>

        <div class="signature">
            <div class="signature-line">Principal’s Signature</div>
        </div>
    </div>
</body>
</html>
