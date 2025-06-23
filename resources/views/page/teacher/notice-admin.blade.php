@extends('page.teacher.parent')

@section('content')
<div class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-5xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Admin Notices</h1>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($notices->count() > 0)
            <div class="space-y-4">
                @foreach ($notices as $notice)
                    <div class="bg-white p-4 shadow rounded-lg">
                        <div class="flex justify-between items-center mb-2">
                            <h2 class="text-xl font-semibold text-gray-800">{{ $notice->title }}</h2>
                            <span class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($notice->date)->format('d M Y') }}</span>
                        </div>
                        <p class="text-gray-700">{{ $notice->details }}</p>
                        <div class="mt-2 text-sm text-gray-500 italic">
                            Posted by: {{ ucfirst($notice->creator_role) }}
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $notices->links() }}
            </div>
        @else
            <div class="text-center text-gray-500">
                No notices from admin yet.
            </div>
        @endif
    </div>
</div>
@endsection
