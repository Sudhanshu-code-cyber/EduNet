@extends('page.teacher.parent')

@section('content')
<div class="min-h-screen bg-gray-50 p-6">
    <div class="max-w-7xl mx-auto">

        <h1 class="text-4xl font-bold mb-8 text-blue-800">Notice Board</h1>

        <!-- Create Notice Form -->
        <section class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h2 class="text-2xl font-semibold mb-4 text-blue-700">Create Notice</h2>

            <form method="POST" action="" class="space-y-4" novalidate>
                @csrf

                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="w-full sm:w-1/2">
                        <label for="title" class="block text-gray-700 font-medium mb-1">Title</label>
                        <input type="text" name="title" id="title" required
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Notice title" value="{{ old('title') }}">
                    </div>

                    <div class="w-full sm:w-1/2">
                        <label for="posted_by" class="block text-gray-700 font-medium mb-1">Posted By</label>
                        <input type="text" name="posted_by" id="posted_by" required
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Your name" value="{{ old('posted_by') }}">
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="w-full sm:w-2/3">
                        <label for="details" class="block text-gray-700 font-medium mb-1">Details</label>
                        <textarea name="details" id="details" rows="3" required
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Write notice details here...">{{ old('details') }}</textarea>
                    </div>

                    <div class="w-full sm:w-1/3">
                        <label for="date" class="block text-gray-700 font-medium mb-1">Date</label>
                        <input type="date" name="date" id="date" required
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('date', \Carbon\Carbon::now()->format('Y-m-d')) }}">
                    </div>
                </div>

                <div class="flex gap-4">
                    <button type="submit"
                        class="bg-blue-600 text-white font-semibold px-5 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Save
                    </button>
                    <button type="reset"
                        class="bg-gray-300 text-gray-700 font-semibold px-5 py-2 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400">
                        Reset
                    </button>
                </div>
            </form>
        </section>

        <!-- Search Notice Board -->
        <section class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h2 class="text-2xl font-semibold mb-6 text-blue-700">Search Notices</h2>

            <form method="GET" action="" class="flex flex-col sm:flex-row gap-4 items-center">
                <div class="flex-1">
                    <label for="search_title" class="block text-gray-700 font-medium mb-1">Title</label>
                    <input type="text" name="search_title" id="search_title"
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Search by title" value="{{ request('search_title') }}">
                </div>

                <div>
                    <label for="search_date" class="block text-gray-700 font-medium mb-1">Date</label>
                    <input type="date" name="search_date" id="search_date"
                        class="border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="{{ request('search_date') }}">
                </div>

                <div class="mt-6 sm:mt-0">
                    <button type="submit"
                        class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                        Search
                    </button>
                </div>
            </form>
        </section>

        <!-- Notices List -->
        <section class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-semibold mb-6 text-blue-700">Notices</h2>

            @if($notices->count())
                <ul class="divide-y divide-gray-200">
                    @foreach($notices as $notice)
                        <li class="py-4 hover:bg-gray-100 transition">
                            <h3 class="text-xl font-bold text-blue-600 mb-1">{{ $notice->title }}</h3>
                            <p class="text-gray-800 mb-2 whitespace-pre-line">{{ $notice->details }}</p>
                            <div class="text-sm text-gray-500 flex flex-wrap gap-4">
                                <span><strong>Posted By:</strong> {{ $notice->posted_by }}</span>
                                <span><strong>Date:</strong> {{ \Carbon\Carbon::parse($notice->date)->format('M d, Y') }}</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="mt-6">
                    <p class="text-sm text-gray-500 mt-4">Total Notices: {{ $notices->count() }}</p>
                </div>
            @else
                <p class="text-gray-500">No notices found.</p>
            @endif
        </section>

    </div>
</div>
@endsection