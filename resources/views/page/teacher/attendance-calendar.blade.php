@extends('page.student.parent')

@section('content')
<div class="max-w-4xl mx-auto py-6">
    <h2 class="text-2xl font-bold mb-4">📊 My Attendance</h2>

    <div class="bg-white shadow rounded p-4">
        <div class="mb-4 text-sm text-gray-600">
            <p><strong>Name:</strong> {{ $student->name }}</p>
            <p><strong>Student ID:</strong> {{ $student->student_id }}</p>
            <p><strong>Class:</strong> {{ $student->class->name ?? 'N/A' }}</p>
            <p><strong>Section:</strong> {{ $student->section->name ?? 'N/A' }}</p>
        </div>

        <table class="w-full text-sm border">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-2 border">Date</th>
                    <th class="p-2 border">Subject</th>
                    <th class="p-2 border">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($attendance as $att)
                    <tr>
                        <td class="p-2 border">{{ \Carbon\Carbon::parse($att->date)->format('d M Y') }}</td>
                        <td class="p-2 border">{{ $att->subject->name ?? 'N/A' }}</td>
                        <td class="p-2 border">
                            <span class="px-2 py-1 rounded text-white
                                {{ $att->status === 'present' ? 'bg-green-500' : ($att->status === 'absent' ? 'bg-red-500' : 'bg-yellow-500') }}">
                                {{ ucfirst($att->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-4 text-center text-gray-500">No attendance records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
