@extends('page.admin.parent')


@section('content')
<div class="max-w-4xl mx-auto bg-white shadow p-6 rounded">
    <h2 class="text-xl font-semibold mb-4">Periods List</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif

    <a href="{{ route('periods.create') }}" class="bg-green-500 text-white px-4 py-2 rounded mb-4 inline-block">Add New Period</a>

    <table class="w-full table-auto border-collapse">
        <thead>
            <tr class="bg-gray-200">
                <th class="border p-2">Period Number</th>
                <th class="border p-2">Start Time</th>
                <th class="border p-2">End Time</th>
                <th class="border p-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($periods as $period)
                <tr>
                    <td class="border p-2">{{ $period->period_number }}</td>
                    <td class="border p-2">{{ \Carbon\Carbon::parse($period->start_time)->format('h:i A') }}</td>
                    <td class="border p-2">{{ \Carbon\Carbon::parse($period->end_time)->format('h:i A') }}</td>
                    <td class="border p-2">
                        <a href="{{ route('periods.edit', $period->id) }}" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>
                        <form action="{{ route('periods.destroy', $period->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection