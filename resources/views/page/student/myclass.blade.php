@extends('page.student.parent')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-semibold mb-4">📅 Weekly Class Timetable</h2>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="table-auto w-full text-sm text-left">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-4 py-2">Day</th>
                    <th class="px-4 py-2">Subject</th>
                    <th class="px-4 py-2">Teacher</th>
                    <th class="px-4 py-2">Start Time</th>
                    <th class="px-4 py-2">End Time</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($timetable as $class)
                    <tr class="border-b hover:bg-blue-50">
                        <td class="px-4 py-2 font-medium text-gray-800">{{ $class['day'] }}</td>
                        <td class="px-4 py-2">{{ $class['subject'] }}</td>
                        <td class="px-4 py-2">{{ $class['teacher'] }}</td>
                        <td class="px-4 py-2">{{ $class['start_time'] }}</td>
                        <td class="px-4 py-2">{{ $class['end_time'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center px-4 py-4 text-gray-500">No timetable available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
