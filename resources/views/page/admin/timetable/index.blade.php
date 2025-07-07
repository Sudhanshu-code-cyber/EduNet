@extends('page.admin.parent')

@section('content')
<div class="max-w-6xl mx-auto bg-white shadow p-6 rounded mt-6">
      <div class="flex justify-between items-center mb-4">
    <h2 class="text-xl font-semibold mb-4">Teacher Timetable List</h2>
    <a href="{{ route('timetable.create') }}" class="bg-green-500 text-white px-4 py-2 rounded mb-4 inline-block"> + Assign New</a>
      </div>


    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif


    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border p-2 text-left">Teacher</th>
                    <th class="border p-2 text-left">Class</th>
                    <th class="border p-2 text-left">Section</th>
                    <th class="border p-2 text-left">Subject</th>
                    <th class="border p-2 text-left">Day</th>
                    <th class="border p-2 text-left">Period</th>
                    <th class="border p-2 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($timetables as $timetable)
                    <tr class="hover:bg-gray-50">
                        <td class="border p-2">{{ $timetable->teacher->first_name }} {{ $timetable->teacher->last_name ?? '' }}</td>
                        <td class="border p-2">{{ $timetable->class->name }}</td>
                        <td class="border p-2">{{ $timetable->section->name ?? 'N/A' }}</td>
                        <td class="border p-2">{{ $timetable->subject->name }}</td>
                        <td class="border p-2">{{ $timetable->day_of_week }}</td>
                        <td class="border p-2">
                            Period {{ $timetable->period->period_number }}<br>
                            <span class="text-xs text-gray-600">{{ $timetable->period->start_time }} - {{ $timetable->period->end_time }}</span>
                        </td>
                        <td class="border p-2 text-center">
                            <form method="POST" action="{{ route('timetable.destroy', $timetable->id) }}" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 text-white px-3 py-1 rounded">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

                @if($timetables->isEmpty())
                    <tr>
                        <td colspan="7" class="border p-2 text-center text-gray-500">No timetable records found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
