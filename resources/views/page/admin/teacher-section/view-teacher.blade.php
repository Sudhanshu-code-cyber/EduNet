@extends('page.admin.parent')

@section('content')
<div class="max-w-5xl mx-auto py-10 px-6 bg-gray-50 min-h-screen">
    <h1 class="text-4xl font-bold text-blue-700 mb-8 text-center">Teacher Details</h1>

    <div class="bg-white shadow-lg rounded-lg p-6 grid md:grid-cols-2 gap-6 border border-gray-300">
        <!-- Profile Picture -->
        <div class="flex justify-center md:justify-start">
            @if($teacher->photo)
                <img src="{{ asset('storage/' . $teacher->photo) }}" alt="Profile Photo"
                    class="w-48 h-48 rounded-full object-cover border-4 border-blue-300 shadow-md">
            @else
                <div class="w-48 h-48 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 shadow-md border-4 border-gray-300">
                    No Photo
                </div>
            @endif
        </div>

        <!-- Basic Details -->
        <div class="border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="mb-4">
                <h2 class="text-xl font-semibold text-gray-700 border-b border-gray-300 pb-1">Name</h2>
                <p class="text-gray-600 mt-1">{{ $teacher->first_name }} {{ $teacher->last_name }}</p>
            </div>
            <div class="mb-4">
                <h2 class="text-xl font-semibold text-gray-700 border-b border-gray-300 pb-1">Email</h2>
                <p class="text-gray-600 mt-1">{{ $teacher->email }}</p>
            </div>
            <div class="mb-4">
                <h2 class="text-xl font-semibold text-gray-700 border-b border-gray-300 pb-1">Phone</h2>
                <p class="text-gray-600 mt-1">{{ $teacher->phone }}</p>
            </div>
            <div>
                <h2 class="text-xl font-semibold text-gray-700 border-b border-gray-300 pb-1">Gender</h2>
                <p class="text-gray-600 mt-1">{{ $teacher->gender }}</p>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="mb-4">
                <h2 class="text-xl font-semibold text-gray-700 border-b border-gray-300 pb-1">Class & Section</h2>
                <p class="text-gray-600 mt-1">{{ $teacher->class ?? '-' }} - {{ $teacher->section ?? '-' }}</p>
            </div>
            <div class="mb-4">
                <h2 class="text-xl font-semibold text-gray-700 border-b border-gray-300 pb-1">ID Number</h2>
                <p class="text-gray-600 mt-1">{{ $teacher->id_no ?? '-' }}</p>
            </div>
            <div class="mb-4">
                <h2 class="text-xl font-semibold text-gray-700 border-b border-gray-300 pb-1">Blood Group</h2>
                <p class="text-gray-600 mt-1">{{ $teacher->blood_group ?? '-' }}</p>
            </div>
            <div class="mb-4">
                <h2 class="text-xl font-semibold text-gray-700 border-b border-gray-300 pb-1">Religion</h2>
                <p class="text-gray-600 mt-1">{{ $teacher->religion ?? '-' }}</p>
            </div>
            <div>
                <h2 class="text-xl font-semibold text-gray-700 border-b border-gray-300 pb-1">Date of Birth</h2>
                <p class="text-gray-600 mt-1">{{ $teacher->dob ?? '-' }}</p>
            </div>
        </div>

        <!-- Address and Bio -->
        <div class="md:col-span-2 border border-gray-200 rounded-lg p-4 shadow-sm">
            <div class="mb-4">
                <h2 class="text-xl font-semibold text-gray-700 border-b border-gray-300 pb-1">Address</h2>
                <p class="text-gray-600 mt-1">{{ $teacher->address }}</p>
            </div>
            <div>
                <h2 class="text-xl font-semibold text-gray-700 border-b border-gray-300 pb-1">Short Bio</h2>
                <p class="text-gray-600 mt-1">{{ $teacher->short_bio }}</p>
            </div>
        </div>
    </div>

    <div class="mt-8 text-center">
        <a href="{{ route('teacher.index') }}"
            class="inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition shadow-md">
            Back to List
        </a>
    </div>
</div>
@endsection

