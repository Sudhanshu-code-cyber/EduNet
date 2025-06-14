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

        .pagination-btn {
            transition: all 0.2s ease;
            min-width: 32px;
        }

        .pagination-btn:hover:not(.active) {
            background-color: #e5e7eb;
        }

        /* Modal styling with pure CSS */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 100;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.25);
            transform: scale(0.9);
            opacity: 0;
            transition: all 0.3s ease;
        }

        #modal-toggle:checked~.modal {
            display: flex;
        }

        #modal-toggle:checked~.modal .modal-content {
            transform: scale(1);
            opacity: 1;
        }

        .modal-header {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            padding: 20px;
            border-radius: 12px 12px 0 0;
        }

        .close-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 28px;
            color: white;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .close-btn:hover {
            transform: scale(1.2);
        }

        /* Responsive table */
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
    <input type="checkbox" id="modal-toggle" class="hidden">

    <div class="max-w-7xl mx-auto text-[14px] leading-relaxed"> <!-- overall font size and line-height -->
        <!-- Header -->
        <div class="card rounded">
            <div class="header-gradient px-6 py-3">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center leading-snug">
                        <i class="fas fa-user-graduate mr-3"></i>
                        Student Records
                    </h2>
                    <div class="mt-4 md:mt-0">
                        <a href="{{ route('admin.addstudent') }}"
                            class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-900 flex items-center text-sm leading-tight">
                            <i class="fas fa-plus mr-2"></i> Add New Student
                        </a>
                    </div>
                </div>
            </div>

            <div class="p-5">
                <!-- Search and Filters -->
                <form action="{{ route('student.search') }}" method="GET">
                    <div class="flex flex-col md:flex-row justify-between gap-4 bg-white p-2 rounded-lg">
                        <!-- Search Input -->
                        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                            <div class="relative w-full md:w-80">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Search by name & Roll No..."
                                    class="w-full px-4 py-2.5 pl-10 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm leading-tight placeholder-gray-500">
                                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Search Button -->
                        <div class="flex gap-2 items-center">
                            <button type="submit"
                                class="flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white px-5 py-2.5 rounded-lg shadow transition-all duration-300 text-sm leading-tight">
                                <i class="fas fa-search"></i>
                                <span>Search</span>
                            </button>
                        </div>
                    </div>
                </form>


                <!-- Table -->
                <div class="overflow-x-auto responsive-table">
                    <table class="min-w-full divide-y divide-gray-200 text-sm leading-relaxed">
                        <thead class="bg-blue-50 text-gray-700 text-sm leading-snug">
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
                        <tbody class="bg-white divide-y divide-gray-200 text-sm leading-snug">
                            @if ($allstudent->count())
                                @foreach ($allstudent as $student)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 font-medium">{{ $student->roll_no }}</td>
                                        <td class="px-4 py-2">
                                            <img class="w-10 h-10 rounded-full mx-auto student-photo"
                                                src="{{ $student->photo ? asset('storage/' . $student->photo) : 'https://i.pravatar.cc/40?img=1' }}"
                                                alt="{{ $student->full_name }}">
                                        </td>
                                        <td class="px-4 py-3 font-medium">{{ $student->full_name }}</td>
                                        <td class="px-4 py-3">{{ $student->gender }}</td>
                                        <td class="px-4 py-3 hide-on-mobile">{{ $student->father_name }}</td>
                                        <td class="px-4 py-3">{{ $student->class }}</td>
                                        <td class="px-4 py-3">{{ $student->section }}</td>
                                        <td class="px-4 py-3 hide-on-mobile">
                                            <div class="w-32 truncate overflow-hidden text-ellipsis whitespace-nowrap">
                                                {{ $student->present_address }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 hide-on-mobile">
                                            {{ \Carbon\Carbon::parse($student->dob)->format('d/m/Y') }}
                                        </td>
                                        <td class="px-4 py-3 hide-on-mobile">{{ $student->contact }}</td>
                                        <td class="px-4 py-3 hide-on-mobile">{{ $student->email }}</td>
                                        <td class="px-4 py-3">
                                            <div class="flex gap-2 justify-center">
                                                <button
                                                    class="text-blue-500 hover:text-blue-700 action-btn view-btn text-sm">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                
                                                <input type="checkbox" id="edit-modal-{{ $student->id }}" class="modal-toggle hidden peer">
                                                <label for="edit-modal-{{ $student->id }}" class="cursor-pointer">
                                                    <i class="fas fa-edit"></i>
                                                </label>
                                                

                                                @include('page.admin.student.edit-student', ['student' => $student])


                                                <button
                                                    class="text-red-500 hover:text-red-700 action-btn delete-btn text-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
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

                    <!-- Pagination -->
                    <div class="flex justify-end mt-6 text-sm leading-tight">
                        <nav class="inline-flex rounded-md shadow-sm" aria-label="Pagination">
                            {{-- Prev --}}
                            @if ($allstudent->onFirstPage())
                                <span
                                    class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 rounded-l-md cursor-not-allowed">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                    </svg>
                                    Prev
                                </span>
                            @else
                                <a href="{{ $allstudent->previousPageUrl() }}"
                                    class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-l-md hover:bg-gray-100">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                    </svg>
                                    Prev
                                </a>
                            @endif

                            {{-- Pages --}}
                            @foreach ($allstudent->getUrlRange(1, $allstudent->lastPage()) as $page => $url)
                                @if ($page == $allstudent->currentPage())
                                    <span
                                        class="px-3 py-2 border-t border-b border-gray-300 text-sm text-white bg-gray-600">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}"
                                        class="px-3 py-2 border-t border-b border-gray-300 text-sm text-gray-700 bg-white hover:bg-gray-100">{{ $page }}</a>
                                @endif
                            @endforeach

                            {{-- Next --}}
                            @if ($allstudent->hasMorePages())
                                <a href="{{ $allstudent->nextPageUrl() }}"
                                    class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-r-md hover:bg-gray-100">
                                    Next
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            @else
                                <span
                                    class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 rounded-r-md cursor-not-allowed">
                                    Next
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                    </svg>
                                </span>
                            @endif
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
