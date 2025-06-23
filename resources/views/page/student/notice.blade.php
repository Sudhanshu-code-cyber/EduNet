@extends('page.student.parent')

@section('content')
<div class="min-h-screen bg-gray-100 py-8 px-4">
    <div class="max-w-4xl mx-auto">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Teacher Notices</h2>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @forelse($notices as $notice)
            <div class="bg-white shadow-md rounded-lg p-6 mb-4">
                <h3 class="text-xl font-bold text-blue-800">{{ $notice->title }}</h3>
                <p class="text-sm text-gray-500 mb-2">Posted by: {{ $notice->posted_by }} on {{ \Carbon\Carbon::parse($notice->date)->format('d M, Y') }}</p>
                <p class="text-gray-700">{{ $notice->details }}</p>
            </div>
        @empty
            <div class="text-gray-600">No active notices from teachers.</div>
        @endforelse

        <div class="mt-4">
            {{ $notices->links() }}
        </div>
    </div>
</div>
@endsection
