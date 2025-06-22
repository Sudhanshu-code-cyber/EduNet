@extends('page.teacher.parent')

@section('content')
    <div class="min-h-screen bg-gray-100 p-6">
        <div class="max-w-7xl mx-auto ">
            <h1 class="text-4xl font-bold text-blue-800 mb-6">Exam Schedule</h1>
            @include('page.teacher.examinations.filter-modal')
            @include('page.teacher.examinations.exam-schedule-modal')
        </div>

        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100 text-gray-700">
                    <tr class="text-left text-sm">
                        <th class="p-4">Subject</th>
                        <th class="p-4">Exam Date</th>
                        <th class="p-4">Start Time</th>
                        <th class="p-4">End Time</th>
                        <th class="p-4">Duration</th>
                        <th class="p-4">Room No</th>
                        <th class="p-4">Max Marks</th>
                        <th class="p-4">Min Marks</th>
                        <th class="p-4">Action</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700">
                    @forelse ($exams as $exam)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4">{{ $exam->subject->name }}</td>
                            <td class="p-4">{{ $exam->exam_date }}</td>
                            <td class="p-4">{{ $exam->start_time }}</td>
                            <td class="p-4">{{ $exam->end_time }}</td>
                            <td class="p-4">{{ $exam->duration }}</td>
                            <td class="p-4">{{ $exam->room_no }}</td>
                            <td class="p-4">{{ $exam->max_marks }}</td>
                            <td class="p-4">{{ $exam->min_marks }}</td>
                            <td class="p-4">
                                <div x-data="{ open: false }">
                                    <div class="flex gap-2">
                                        <button @click="open = true"
                                            class="px-3 py-1 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600">Edit</button>

                                        <form action="{{ route('delete.exam', $exam->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-1 text-sm text-white bg-red-600 rounded hover:bg-red-700">Delete</button>
                                        </form>
                                    </div>

                                    <!-- Modal -->
                                    <div x-show="open" x-cloak
                                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                                        <div class="bg-white rounded-xl w-full max-w-lg p-6 shadow-lg">
                                            <h2 class="text-xl font-bold mb-4">Edit Exam</h2>

                                            <form action="{{ route('exam.update', $exam->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <div class="mb-4">
                                                    <label class="block text-sm font-medium mb-1">Exam Name</label>
                                                    <input type="text" name="exam_name" value="{{ $exam->exam_name }}"
                                                        class="w-full border border-gray-300 rounded p-2" required>
                                                </div>

                                                <div class="mb-4">
                                                    <label class="block text-sm font-medium mb-1">Class</label>
                                                    <select name="class_id" class="w-full border border-gray-300 rounded p-2" required>
                                                        <option value="">Select Class</option>
                                                        @foreach ($assigned as $item)
                                                            <option value="{{ $item->class_id }}" @if ($exam->class_id == $item->class_id) selected @endif>
                                                                {{ $item->class->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-4">
                                                    <label class="block text-sm font-medium mb-1">Section</label>
                                                    <select name="section_id" class="w-full border border-gray-300 rounded p-2" required>
                                                        <option value="">Select Section</option>
                                                        @foreach ($assigned as $item)
                                                            <option value="{{ $item->section_id }}" @if ($exam->section_id == $item->section_id) selected @endif>
                                                                {{ $item->section->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-4">
                                                    <label class="block text-sm font-medium mb-1">Subject</label>
                                                    <select name="subject_id" class="w-full border border-gray-300 rounded p-2" required>
                                                        <option value="">Select Subject</option>
                                                        @foreach ($assigned as $item)
                                                            <option value="{{ $item->subject_id }}" @if ($exam->subject_id == $item->subject_id) selected @endif>
                                                                {{ $item->subject->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="grid grid-cols-2 gap-4 mb-4">
                                                    <div>
                                                        <label class="block text-sm font-medium mb-1">Exam Date</label>
                                                        <input type="date" name="exam_date" value="{{ $exam->exam_date }}"
                                                            class="w-full border border-gray-300 rounded p-2" required>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium mb-1">Room No</label>
                                                        <input type="text" name="room_no" value="{{ $exam->room_no }}"
                                                            class="w-full border border-gray-300 rounded p-2" required>
                                                    </div>
                                                </div>

                                                <div class="grid grid-cols-3 gap-4 mb-4">
                                                    <div>
                                                        <label class="block text-sm font-medium mb-1">Start Time</label>
                                                        <input type="time" name="start_time" value="{{ $exam->start_time }}"
                                                            class="w-full border border-gray-300 rounded p-2" required>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium mb-1">End Time</label>
                                                        <input type="time" name="end_time" value="{{ $exam->end_time }}"
                                                            class="w-full border border-gray-300 rounded p-2" required>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium mb-1">Duration (min)</label>
                                                        <input type="number" name="duration" value="{{ $exam->duration }}"
                                                            class="w-full border border-gray-300 rounded p-2" required>
                                                    </div>
                                                </div>

                                                <div class="grid grid-cols-2 gap-4 mb-4">
                                                    <div>
                                                        <label class="block text-sm font-medium mb-1">Max Marks</label>
                                                        <input type="number" name="max_marks" value="{{ $exam->max_marks }}"
                                                            class="w-full border border-gray-300 rounded p-2" required>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-medium mb-1">Min Marks</label>
                                                        <input type="number" name="min_marks" value="{{ $exam->min_marks }}"
                                                            class="w-full border border-gray-300 rounded p-2" required>
                                                    </div>
                                                </div>

                                                <div class="flex justify-end gap-2">
                                                    <button type="button" @click="open = false"
                                                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                                                    <button type="submit"
                                                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="p-4 text-center text-gray-500">No exam schedules found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection