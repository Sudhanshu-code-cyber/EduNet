@extends('page.teacher.parent') {{-- If you have a separate parent layout for teacher; else use app or main parent --}}

@section('content')
<div class="max-w-6xl mx-auto bg-white shadow p-6 rounded">
    <h2 class="text-xl font-semibold mb-4">Timetable for {{ $teacher->first_name }} {{ $teacher->last_name }}</h2>

    @if ($timetables->isEmpty())
        <p>No timetable assigned yet.</p>
    @else
        <table class="min-w-full border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2">Day</th>
                    <th class="border p-2">Period</th>
                    <th class="border p-2">Class</th>
                    <th class="border p-2">Section</th>
                    <th class="border p-2">Subject</th>
                    <th class="border p-2">Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($timetables as $timetable)
                    <tr>
                        <td class="border p-2">{{ $timetable->day_of_week }}</td>
                        <td class="border p-2">Period {{ $timetable->period->period_number }}</td>
                        <td class="border p-2">{{ $timetable->class->name ?? '-' }}</td>
                        <td class="border p-2">{{ $timetable->section->name ?? '-' }}</td>
                        <td class="border p-2">{{ $timetable->subject->name ?? '-' }}</td>
                        <td class="border p-2">{{ $timetable->period->start_time }} - {{ $timetable->period->end_time }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
