@extends('page.admin.parent')

@section('content')
<div class="min-h-screen bg-gray-50 py-10 px-6">
    <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-3xl font-bold text-blue-700 mb-6">Student Details</h1>

        {{-- PHOTO SECTION --}}
        <div class="flex justify-center mb-6">
            @if($student->photo)
            <img src="{{ asset('uploads/students/' . $student->photo) }}" alt="Student Photo"
            class="w-32 h-32 object-cover rounded-full shadow-md border border-gray-300">       
            @else
                <div class="w-32 h-32 flex items-center justify-center bg-gray-200 text-gray-500 rounded-full">
                    No Photo
                </div>
            @endif
        </div>

        {{-- DETAILS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <label class="font-semibold text-gray-600">Full Name:</label>
                <div class="text-gray-900">{{ $student->full_name }}</div>
            </div>
            <div>
                <label class="font-semibold text-gray-600">Roll Number:</label>
                <div class="text-gray-900">{{ $student->roll_no }}</div>
            </div>
            <div>
                <label class="font-semibold text-gray-600">Gender:</label>
                <div class="text-gray-900">{{ $student->gender }}</div>
            </div>
            <div>
                <label class="font-semibold text-gray-600">Date of Birth:</label>
                <div class="text-gray-900">{{ \Carbon\Carbon::parse($student->dob)->format('d-m-Y') }}</div>
            </div>
            <div>
                <label class="font-semibold text-gray-600">Parent/Guardian:</label>
                <div class="text-gray-900">{{ $student->father_name }}</div>
            </div>
            <div>
                <label class="font-semibold text-gray-600">Contact Number:</label>
                <div class="text-gray-900">{{ $student->contact }}</div>
            </div>
            <div>
                <label class="font-semibold text-gray-600">Class:</label>
                <div class="text-gray-900">{{ $student->class }}</div>
            </div>
            <div>
                <label class="font-semibold text-gray-600">Section:</label>
                <div class="text-gray-900">{{ $student->section }}</div>
            </div>
            <div class="md:col-span-2">
                <label class="font-semibold text-gray-600">Email:</label>
                <div class="text-gray-900">{{ $student->email }}</div>
            </div>
            <div class="md:col-span-2">
                <label class="font-semibold text-gray-600">Address:</label>
                <div class="text-gray-900">{{ $student->present_address }}</div>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('admin.allstudent') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">Back to List</a>
        </div>
    </div>
</div>
@endsection
