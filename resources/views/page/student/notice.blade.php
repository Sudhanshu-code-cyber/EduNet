@extends('page.student.parent')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 px-4 sm:px-6">
    <div class="max-w-4xl mx-auto">
        <!-- Header with decorative elements -->
        <div class="relative mb-8">
            <div class="absolute -left-8 -top-4 w-16 h-16 bg-blue-100 rounded-full opacity-30"></div>
            <div class="absolute -right-8 -bottom-4 w-20 h-20 bg-indigo-100 rounded-full opacity-30"></div>
            <div class="relative bg-white shadow-sm rounded-xl p-6 border border-gray-100">
                <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                    </svg>
                    Teacher Notices
                </h2>
                <p class="text-gray-600 mt-2">Important announcements from your teachers</p>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Notices List -->
        <div class="space-y-6">
            @forelse($notices as $notice)
            <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-100 transition-all duration-200 hover:shadow-md">
                <div class="p-6">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">{{ $notice->title }}</h3>
                            <div class="flex items-center mt-2 text-sm text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Posted by {{ $notice->posted_by }}
                            </div>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ \Carbon\Carbon::parse($notice->date)->format('d M, Y') }}
                        </span>
                    </div>
                    
                    <div class="mt-4 text-gray-700 prose max-w-none">
                        {!! nl2br(e($notice->details)) !!}
                    </div>
                    
                    @if($notice->attachment)
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <a href="{{ Storage::url($notice->attachment) }}" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            Download Attachment
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="text-center py-12 bg-white rounded-xl shadow-sm border border-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No notices available</h3>
                <p class="mt-1 text-sm text-gray-500">Check back later for updates from your teachers</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($notices->hasPages())
        <div class="mt-8">
            {{ $notices->links('vendor.pagination.tailwind') }}
        </div>
        @endif
    </div>
</div>
@endsection