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

            <form id="examForm">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Class -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Class</label>
                        <select name="class" class="w-full border border-gray-300 rounded px-3 py-2">
                            <option value="" selected disabled>Select Class</option>
                            <option>Class 6</option>
                            <option>Class 7</option>
                            <option>Class 8</option>
                        </select>
                    </div>

                    <!-- Section -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Section</label>
                        <select name="section" class="w-full border border-gray-300 rounded px-3 py-2">
                            <option value="" selected disabled>Select Section</option>
                            <option>A</option>
                            <option>B</option>
                            <option>C</option>
                        </select>
                    </div>

                    <!-- Exam Name -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Exam Name</label>
                        <select name="exam_id" id="exam_id" required
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Choose Exam --</option>
                        <option value="1">Mid Term</option>
                        <option value="2">Final Term</option>
                        <!-- Add more exams dynamically -->
                    </select>
                    </div>

                    <!-- Subject -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Subject</label>
                        <input type="text" name="subject" placeholder="Mathematics"
                            class="w-full border border-gray-300 rounded px-3 py-2">
                    </div>

                    <!-- Exam Date -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Exam Date</label>
                        <input type="date" name="exam_date"
                            class="w-full border border-gray-300 rounded px-3 py-2">
                    </div>

                    <!-- Start Time -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Start Time</label>
                        <input type="time" name="start_time"
                            class="w-full border border-gray-300 rounded px-3 py-2">
                    </div>

                    <!-- End Time -->
                    <div>
                        <label class="block text-sm font-medium mb-1">End Time</label>
                        <input type="time" name="end_time"
                            class="w-full border border-gray-300 rounded px-3 py-2">
                    </div>

                    <!-- Duration -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Duration (min)</label>
                        <input type="number" name="duration" placeholder="180"
                            class="w-full border border-gray-300 rounded px-3 py-2">
                    </div>

                    <!-- Room No -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Room No</label>
                        <input type="text" name="room_no" placeholder="101"
                            class="w-full border border-gray-300 rounded px-3 py-2">
                    </div>

                    <!-- Max Marks -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Max Marks</label>
                        <input type="number" name="max_marks" placeholder="100"
                            class="w-full border border-gray-300 rounded px-3 py-2">
                    </div>

                    <!-- Min Marks -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Min Marks</label>
                        <input type="number" name="min_marks" placeholder="33"
                            class="w-full border border-gray-300 rounded px-3 py-2">
                    </div>
                </div>

               <!-- Buttons -->
<div class="mt-6 flex flex-row-reverse justify-start gap-4">
    <!-- Submit Button (Rightmost) -->
    <button type="submit"
        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        Add Exam Schedule
    </button>

    <!-- Reset Button -->
    <button type="reset"
        class="bg-gray-300 text-gray-800 font-semibold px-5 py-2 rounded-md hover:bg-gray-400 focus:ring-2 focus:ring-gray-400">
        Reset
    </button>

    <!-- Cancel Button -->
    <button type="button" @click="open = false"
        class="text-red-600 hover:underline font-semibold ">
        Cancel
    </button>
</div>

            </form>
        </div>
    </div>
</div>
