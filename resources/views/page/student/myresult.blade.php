@extends('page.student.parent')

@section('content')
<div class="min-h-screen bg-gray-50 py-10 px-4">
    <div class="max-w-5xl mx-auto bg-white shadow-md rounded-xl p-6 space-y-6">

        <!-- 🔷 Heading -->
        <div class="flex items-center justify-between border-b pb-4">
            <h1 class="text-3xl font-bold text-blue-800 flex items-center gap-2">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 12h6m-6 4h6m-6-8h6m2 10H7a2 2 0 01-2-2V6a2 2 0 012-2h6l4 4v10a2 2 0 01-2 2z" />
                </svg>
                Student Exam Result
            </h1>
          <a href="{{ route('student.result.print', ['exam_master_id' => request('exam_master_id')]) }}"
   target="_blank"
   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
    Print
</a>

        </div>

        <!-- 📷 Student Info -->
        <div class="flex items-center gap-6 bg-gray-50 rounded-lg p-4 shadow-sm">
            <img src="{{ asset('uploads/students/' . auth()->user()->student->photo) }}"
                 alt="Student Photo"
                 class="w-16 h-16 rounded-full object-cover border border-gray-300" />
            <div>
                <h2 class="text-xl font-semibold text-gray-800">{{ auth()->user()->student->full_name }}</h2>
                <p class="text-sm text-gray-600">
                    Roll No: <strong>{{ auth()->user()->student->roll_no }}</strong> &nbsp; | &nbsp;
                    Class: <strong>{{ auth()->user()->student->class->name ?? '-' }}</strong> &nbsp;
                    Section: <strong>{{ auth()->user()->student->section->name ?? '-' }}</strong>
                </p>
            </div>
        </div>

        <!-- 📘 Exam Selection -->
        <form method="GET" action="{{ route('student.result') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Select Exam</label>
                <select name="exam_master_id" class="w-full rounded-lg border border-gray-300 p-2 focus:ring focus:ring-blue-100" required>
                    <option value="">Choose Exam</option>
                    @foreach ($exams as $exam)
                        <option value="{{ $exam->id }}" {{ request('exam_master_id') == $exam->id ? 'selected' : '' }}>
                            {{ $exam->exam_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg">
                    View Result
                </button>
            </div>
        </form>

        <!-- 🧾 Result Table -->
     <!-- 🧾 Result Table -->
@if($exam && $subjects->count())
    <div class="overflow-x-auto mt-6">
        <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-4 text-left font-semibold">Subject</th>
                    <th class="p-4 text-left font-semibold">Max Marks</th>
                    <th class="p-4 text-left font-semibold">Pass Marks</th>
                    <th class="p-4 text-left font-semibold">Obtained</th>
                    <th class="p-4 text-left font-semibold">Status</th>
                </tr>
            </thead>
           <tbody class="bg-white text-gray-800 divide-y divide-gray-100">
    @foreach($subjects as $subject)
        @php
            $entry = $marks[$subject->subject_id] ?? null;
            $obtained = $entry->marks_obtained ?? null;
            $isFail = !is_null($obtained) && $obtained < $subject->pass_marks;
        @endphp
        <tr class="hover:bg-gray-50">
            <td class="p-4">{{ $subject->subject->name }}</td>
            <td class="p-4">{{ $subject->max_marks }}</td>
            <td class="p-4">{{ $subject->pass_marks }}</td>
            <td class="p-4">{{ !is_null($obtained) ? $obtained : 'N/A' }}</td>
            <td class="p-4 font-semibold {{ is_null($obtained) ? 'text-gray-500' : ($isFail ? 'text-red-600' : 'text-green-600') }}">
                {{ is_null($obtained) ? 'N/A' : ($isFail ? 'Fail' : 'Pass') }}
            </td>
        </tr>
    @endforeach

    <!-- Total -->
    <tr class="bg-gray-100 font-semibold">
        <td class="p-4">Total</td>
        <td class="p-4">{{ $totalMax }}</td>
        <td class="p-4">—</td>
        <td class="p-4">{{ $hasAllMarks ? $totalObtained : 'N/A' }}</td>
        <td class="p-4 {{ $finalResult === 'Fail' ? 'text-red-600' : ($finalResult === 'Pass' ? 'text-green-600' : 'text-gray-600') }}">
            {{ $finalResult }}
        </td>
    </tr>

    <!-- Percentage -->
    <tr class="bg-blue-50 font-semibold">
        <td colspan="4" class="p-4 text-right">Percentage</td>
        <td class="p-4 text-xl text-blue-700 font-bold">
            {{ $hasAllMarks ? $percentage . '%' : 'N/A' }}
        </td>
    </tr>
</tbody>
        </table>
    </div>
@elseif(request('exam_master_id'))
    <div class="mt-6 text-red-500 text-sm">No marks found for this exam.</div>
@endif
    </div>
</div>
@endsection
