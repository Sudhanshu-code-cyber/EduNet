<!-- Add Exam Schedule Modal Trigger -->
<div x-data="{ open: false }">
    <div class="flex justify-end mb-4">
        <button @click="open = true" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 mt-3">
            + Add Exam Schedule
        </button>
    </div>


    <!-- Modal -->
    <div x-show="open" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
        <div @click.away="open = false"
            class="bg-white w-full max-w-2xl rounded-lg shadow-lg p-6 overflow-y-auto max-h-[90vh]">

            <h2 class="text-2xl font-semibold mb-4 text-gray-800">Add Exam Schedule</h2>

            <form id="examForm" action= " {{ route('teacher.exam_schedule.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Class -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Class</label>
                        <select name="class_id" id="class_id" class="w-full border border-gray-300 rounded px-3 py-2">
                            <option value="">Select Class</option>
                            @foreach ($assigned->unique('class_id') as $item)
                                <option value="{{ $item->class_id }}">{{ $item->class->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Section -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Section</label>
                        <select name="section_id" id="section_id"
                            class="w-full border border-gray-300 rounded px-3 py-2">
                            <option value="">Select Section</option>
                        </select>
                    </div>

                    <!-- Subject -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Subject</label>
                        <select name="subject_id" id="subject_id"
                            class="w-full border border-gray-300 rounded px-3 py-2">
                            <option value="">Select Subject</option>
                        </select>
                    </div>

                    <!-- Exam Name -->
                    <div>
                        <label>Exam Name</label>
                        <input type="text" name="exam_name" class="w-full border border-gray-300 rounded px-3 py-2">

                        @error('exam_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>



                    <!-- Exam Date -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Exam Date</label>
                        <input type="date" name="exam_date" class="w-full border border-gray-300 rounded px-3 py-2">
                        @error('exam_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Start Time -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Start Time</label>
                        <input type="time" name="start_time" class="w-full border border-gray-300 rounded px-3 py-2">
                        @error('start_time')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- End Time -->
                    <div>
                        <label class="block text-sm font-medium mb-1">End Time</label>
                        <input type="time" name="end_time" class="w-full border border-gray-300 rounded px-3 py-2">
                        @error('end_time')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Duration -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Duration (min)</label>
                        <input type="number" name="duration" value="{{ old('duration') }}"
                            class="w-full border border-gray-300 rounded px-3 py-2">
                        @error('duration')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Room No -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Room No</label>
                        <input type="text" name="room_no" class="w-full border border-gray-300 rounded px-3 py-2">
                        @error('room_no')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Max Marks -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Max Marks</label>
                        <input type="number" name="max_marks" class="w-full border border-gray-300 rounded px-3 py-2">
                        @error('max_marks')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Min Marks -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Min Marks</label>
                        <input type="number" name="min_marks" class="w-full border border-gray-300 rounded px-3 py-2">
                        @error('min_marks')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Buttons -->
                <div class="mt-6 flex flex-row-reverse justify-start gap-4">
                    <!-- Submit Button (Rightmost) -->
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Add Exam Schedule
                    </button>

                    <!-- Reset Button -->
                    <button type="reset"
                        class="bg-gray-300 text-gray-800 font-semibold px-5 py-2 rounded-md hover:bg-gray-400 focus:ring-2 focus:ring-gray-400">
                        Reset
                    </button>

                    <!-- Cancel Button -->
                    <button type="button" @click="open = false" class="text-red-600 hover:underline font-semibold ">
                        Cancel
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#class_id').on('change', function() {
            const classId = $(this).val();

  console.log("Selected Class ID:", classId);
  
            $('#section_id').html('<option value="">Loading...</option>');
            $('#subject_id').html('<option value="">Loading...</option>');

            if (classId) {
                $.ajax({
                    url: `/teacher/class-data/${classId}`,
                    method: 'GET',
                    success: function(data) {
                        $('#section_id').html('<option value="">Select Section</option>');
                        $('#subject_id').html('<option value="">Select Subject</option>');

                        $.each(data.sections, function(i, section) {
                            $('#section_id').append(
                                `<option value="${section.id}">${section.name}</option>`
                                );
                        });

                        $.each(data.subjects, function(i, subject) {
                            $('#subject_id').append(
                                `<option value="${subject.id}">${subject.name}</option>`
                                );
                        });
                    },
                    error: function() {
                        alert('Failed to fetch sections/subjects.');
                    }
                });
            }
        });
    });
</script>
