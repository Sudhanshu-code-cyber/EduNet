@extends('page.teacher.parent')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-8 bg-white rounded-xl shadow-lg">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 border-b pb-3 flex items-center gap-2">
        📋 <span>Mark Student Attendance</span>
    </h2>

    <form action="{{ route('teacher.attendance.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Hidden Fields --}}
        <input type="hidden" name="class_id" value="{{ $class_id }}">
        <input type="hidden" name="section_id" value="{{ $section_id }}">
        <input type="hidden" name="subject_id" value="{{ $subject_id }}">

        {{-- Date Picker --}}
        <div>
            <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Select Date</label>
            <input type="date" name="date" required
                class="w-full max-w-xs px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        {{-- Attendance Table --}}
        <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
            <table class="min-w-full bg-white text-sm text-gray-800">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold border-b">#</th>
                        <th class="px-6 py-3 text-left font-semibold border-b">Student Name</th>
                        <th class="px-6 py-3 text-left font-semibold border-b">Attendance Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $index => $student)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 border-b">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 border-b">
                                {{ $student->full_name }}
                                <input type="hidden" name="student_ids[]" value="{{ $student->id }}">
                            </td>
                            <td class="px-6 py-4 border-b">
                                <select name="attendance_status[{{ $student->id }}]" required
                                    class="px-3 py-1 rounded-lg border border-gray-300 focus:outline-none focus:ring focus:border-blue-400">
                                    <option value="present">✅ Present</option>
                                    <option value="absent">❌ Absent</option>
                                    <option value="leave">📘 Leave</option>
                                </select>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Submit Button --}}
        <div class="text-right pt-4">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition-all duration-200">
                ✅ Submit Attendance
            </button>
        </div>
    </form>
</div>
@endsection
