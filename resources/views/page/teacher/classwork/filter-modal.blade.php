<!-- Filter Modal -->
<div id="filter-modal" tabindex="-1" aria-hidden="true"
    class="hidden fixed top-0 left-0 right-0 z-50 justify-center items-center w-full inset-0 max-h-full overflow-x-hidden overflow-y-auto">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow">
            <!-- Modal Header -->
            <div class="flex justify-between items-center p-4 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900">
                    Filter Homework
                </h3>
                <button type="button" class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg w-8 h-8 flex items-center justify-center" data-modal-toggle="filter-modal">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <form action="{{ route('teacher.homework.search') }}" method="GET" class="p-4 space-y-4">
                <!-- Subject -->
                <div>
                    <label class="block mb-1 font-medium text-gray-800">Subject</label>
                    <select name="subject_id" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                        <option value="">Select Subject</option>
                        @foreach($assignedSubjects->unique('subject_id') as $assignment)
                            <option value="{{ $assignment->subject->id }}">{{ $assignment->subject->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Class -->
                <div>
                    <label class="block mb-1 font-medium text-gray-800">Class</label>
                    <select name="class_id" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                        <option value="">Select Class</option>
                        @foreach($assignedSubjects->unique('class_id') as $assignment)
                            <option value="{{ $assignment->class->id }}">{{ $assignment->class->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Section -->
                <div>
                    <label class="block mb-1 font-medium text-gray-800">Section</label>
                    <select name="section_id" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                        <option value="">Select Section</option>
                        @foreach($assignedSubjects->unique('section_id') as $assignment)
                            <option value="{{ $assignment->section->id }}">{{ $assignment->section->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Date -->
                <div>
                    <label class="block mb-1 font-medium text-gray-800">Homework Date</label>
                    <input type="date" name="date" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                </div>

                <!-- Buttons -->
                <div class="flex justify-between items-center pt-2">
                    <a href="{{ route('teacher.homework.index') }}"
                        class="bg-gray-200 text-gray-800 px-4 py-2 text-sm rounded hover:bg-gray-300">
                        Clear
                    </a>
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 text-sm rounded hover:bg-blue-700">
                        Apply
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
