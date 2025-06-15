@extends('page.admin.parent')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            min-height: 100vh;
        }

        .card {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            background: white;
        }

        .card:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .student-photo {
            transition: transform 0.3s ease;
            border: 2px solid #e5e7eb;
        }

        .student-photo:hover {
            transform: scale(1.1);
            border-color: #3b82f6;
        }

        .action-btn {
            transition: all 0.2s ease;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .action-btn:hover {
            transform: scale(1.1);
        }

        .view-btn:hover {
            background-color: rgba(16, 185, 129, 0.1);
        }

        .edit-btn:hover {
            background-color: rgba(245, 158, 11, 0.1);
        }

        .delete-btn:hover {
            background-color: rgba(239, 68, 68, 0.1);
        }

        @media (max-width: 1024px) {
            .responsive-table {
                display: block;
                overflow-x: auto;
            }

            .hide-on-mobile {
                display: none;
            }
        }
    </style>

    <div class="max-w-7xl mx-auto text-[14px] leading-relaxed">
        <div class="card rounded">
            <div class="header-gradient px-6 py-3">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center leading-snug">
                        <i class="fas fa-user-graduate mr-3"></i>
                        Student Records
                    </h2>
                    <div class="mt-4 md:mt-0">
                        <a href="{{ route('admin.addstudent') }}" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-900 flex items-center text-sm">
                            <i class="fas fa-plus mr-2"></i> Add New Student
                        </a>
                    </div>
                </div>
            </div>

            <div class="p-5">
                <form action="{{ route('student.search') }}" method="GET">
                    <div class="flex flex-col md:flex-row justify-between gap-4 bg-white p-2 rounded-lg">
                        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                            <div class="relative w-full md:w-80">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name & Roll No..." class="w-full px-4 py-2.5 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-2 items-center">
                            <button type="submit" class="flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white px-5 py-2.5 rounded-lg shadow text-sm">
                                <i class="fas fa-search"></i>
                                <span>Search</span>
                            </button>
                        </div>
                    </div>
                </form>

                <div class="overflow-x-auto responsive-table">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-blue-50 text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">Roll</th>
                                <th class="px-4 py-3 font-semibold">Photo</th>
                                <th class="px-4 py-3 font-semibold">Name</th>
                                <th class="px-4 py-3 font-semibold">Gender</th>
                                <th class="px-4 py-3 font-semibold hide-on-mobile">Parent</th>
                                <th class="px-4 py-3 font-semibold">Class</th>
                                <th class="px-4 py-3 font-semibold">Section</th>
                                <th class="px-4 py-3 font-semibold hide-on-mobile">Address</th>
                                <th class="px-4 py-3 font-semibold hide-on-mobile">DOB</th>
                                <th class="px-4 py-3 font-semibold hide-on-mobile">Mobile</th>
                                <th class="px-4 py-3 font-semibold hide-on-mobile">Email</th>
                                <th class="px-4 py-3 font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @if ($allstudent->count())
                                @foreach ($allstudent as $student)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-2 px-4 font-medium">{{ $student->roll_no }}</td>
                                        <td class="py-2 px-4">
                                            <img class="w-10 h-10 rounded-full mx-auto student-photo"
                                                 src="{{ $student->photo ? asset('storage/' . $student->photo) : 'https://i.pravatar.cc/40?img=1' }}"
                                                 alt="{{ $student->full_name }}">
                                        </td>
                                        <td class="py-2 px-4 font-medium">{{ $student->full_name }}</td>
                                        <td class="py-2 px-4">{{ $student->gender }}</td>
                                        <td class="py-2 px-4 hide-on-mobile">{{ $student->father_name }}</td>
                                        <td class="py-2 px-4">{{ $student->class }}</td>
                                        <td class="py-2 px-4">{{ $student->section }}</td>
                                        <td class="py-2 px-4 hide-on-mobile">
                                            <div class="w-32 truncate overflow-hidden text-ellipsis whitespace-nowrap">
                                                {{ $student->present_address }}
                                            </div>
                                        </td>
                                        <td class="py-2 px-4 hide-on-mobile">
                                            {{ \Carbon\Carbon::parse($student->dob)->format('d/m/Y') }}
                                        </td>
                                        <td class="py-2 px-4 hide-on-mobile">{{ $student->contact }}</td>
                                        <td class="py-2 px-4 hide-on-mobile">{{ $student->email }}</td>
                                        <td class="py-2 px-4">
                                            <div class="flex gap-2 justify-center">
                                                <a href="{{ route('student.show', $student->id) }}"
                                                   class="text-blue-500 hover:text-blue-700 action-btn view-btn text-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <!-- Trigger Modal -->
                                                <label for="edit-modal-{{ $student->id }}" class="text-blue-600 hover:underline cursor-pointer">
                                                    Edit
                                                </label>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal Trigger -->
                                    <input type="checkbox" id="edit-modal-{{ $student->id }}" class="peer hidden" />

                                    <!-- Modal -->
                                    <div class="fixed inset-0 bg-black bg-opacity-50 hidden peer-checked:flex items-center justify-center z-50">
                                        <div class="bg-white rounded-lg p-6 w-full max-w-2xl relative">
                                            <!-- Close Button -->
                                            <label for="edit-modal-{{ $student->id }}" class="absolute top-3 right-4 text-xl text-gray-500 cursor-pointer">&times;</label>

                                            <h2 class="text-xl font-semibold mb-4">Edit Student Information</h2>

                                            <!-- Form -->
                                            <form action="{{ route('student.update', $student->id) }}" method="POST" class="space-y-4">
                                                @csrf
                                                @method('PUT')

                                                <div class="grid grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block text-sm font-medium">Full Name</label>
                                                        <input type="text" name="full_name" value="{{ $student->full_name }}" class="w-full border rounded p-2" required>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium">Roll Number</label>
                                                        <input type="text" name="roll_no" value="{{ $student->roll_no }}" class="w-full border rounded p-2">
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium">Gender</label>
                                                        <select name="gender" class="w-full border rounded p-2">
                                                            <option {{ $student->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                                            <option {{ $student->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium">Date of Birth</label>
                                                        <input type="date" name="dob" value="{{ $student->dob }}" class="w-full border rounded p-2">
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium">Class</label>
                                                        <input type="text" name="class" value="{{ $student->class }}" class="w-full border rounded p-2">
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium">Section</label>
                                                        <input type="text" name="section" value="{{ $student->section }}" class="w-full border rounded p-2">
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium">Contact Number</label>
                                                        <input type="text" name="contact_number" value="{{ $student->contact_number }}" class="w-full border rounded p-2">
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium">Email</label>
                                                        <input type="email" name="email" value="{{ $student->email }}" class="w-full border rounded p-2">
                                                    </div>
                                                    <div class="col-span-2">
                                                        <label class="block text-sm font-medium">Address</label>
                                                        <textarea name="address" class="w-full border rounded p-2">{{ $student->address }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="flex justify-end gap-3 pt-4">
                                                    <!-- Close Modal -->
                                                    <label for="edit-modal-{{ $student->id }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 cursor-pointer">Cancel</label>
                                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach                       
                            @else
                                <tr>
                                    <td colspan="12" class="text-center px-4 py-6 text-gray-500 text-sm">
                                        No students found.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <div class="flex justify-end mt-6 text-sm">
                        {{ $allstudent->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection