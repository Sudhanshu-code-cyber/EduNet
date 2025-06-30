@extends('page.admin.parent')

@section('content')
<div class="max-w-2xl mx-auto bg-white shadow p-6 rounded">
    <h2 class="text-xl font-semibold mb-4">Edit Period</h2>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-2 rounded mb-4">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('periods.update', $period->id) }}">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block mb-1">Period Number</label>
            <input type="number" name="period_number" value="{{ $period->period_number }}" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Start Time</label>
            <input type="time" name="start_time" value="{{ $period->start_time }}" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1">End Time</label>
            <input type="time" name="end_time" value="{{ $period->end_time }}" class="w-full border p-2 rounded" required>
        </div>

        <button class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
    </form>
</div>
@endsection
