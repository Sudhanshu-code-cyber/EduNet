@extends('page.teacher.parent')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-8 bg-white rounded-xl shadow-lg">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 border-b pb-3 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
        </svg>
        <span>Mark Student Attendance</span>
    </h2>

    <form action="{{ route('teacher.attendance.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Class -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Class
                </label>
                <select name="class_id" id="class_id" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition">
                    <option value="">Select Class</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Section -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Section
                </label>
                <select name="section_id" id="section_id" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition">
                    <option value="">Select Section</option>
                </select>
            </div>

            <!-- Date -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Date
                </label>
                <input type="date" name="date" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 transition"
                    value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
            </div>
        </div>

        <!-- Hidden subject field -->
        <input type="hidden" name="subject_id" value="1">

        <!-- Students Table Container -->
        <div id="students_container" class="hidden mt-8">
            <div class="bg-blue-50 p-4 rounded-lg mb-4">
                <div class="flex items-center text-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium">Attendance for <span id="class_section_display"></span> on <span id="date_display"></span></span>
                </div>
            </div>

            <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
                <table class="min-w-full bg-white text-sm text-gray-800">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold border-b">#</th>
                            <th class="px-6 py-3 text-left font-semibold border-b">Student Details</th>
                            <th class="px-6 py-3 text-left font-semibold border-b">Status</th>
                            <th class="px-6 py-3 text-left font-semibold border-b">Remarks</th>
                        </tr>
                    </thead>
                    <tbody id="student_rows" class="divide-y divide-gray-200">
                        <!-- Dynamic content will be inserted here -->
                    </tbody>
                </table>
            </div>

            <!-- Summary Section -->
            <div class="mt-4 grid grid-cols-1 md:grid-cols-4 gap-4" id="attendance_summary">
                <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                    <div class="text-green-800 font-medium flex items-center justify-between">
                        <span>Present</span>
                        <span id="present_count" class="text-xl">0</span>
                    </div>
                </div>
                <div class="bg-red-50 p-4 rounded-lg border border-red-100">
                    <div class="text-red-800 font-medium flex items-center justify-between">
                        <span>Absent</span>
                        <span id="absent_count" class="text-xl">0</span>
                    </div>
                </div>
                <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-100">
                    <div class="text-yellow-800 font-medium flex items-center justify-between">
                        <span>Leave</span>
                        <span id="leave_count" class="text-xl">0</span>
                    </div>
                </div>
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                    <div class="text-blue-800 font-medium flex items-center justify-between">
                        <span>Total</span>
                        <span id="total_count" class="text-xl">0</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="text-right pt-4">
            <button type="submit" id="submit_btn" class="hidden bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Submit Attendance
            </button>
        </div>
    </form>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Format date for display
    function formatDisplayDate(dateString) {
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        return new Date(dateString).toLocaleDateString('en-US', options);
    }
    
    // Update counters
    function updateCounters() {
        const present = $('select[name^="attendance_status"] option[value="present"]:selected').length;
        const absent = $('select[name^="attendance_status"] option[value="absent"]:selected').length;
        const leave = $('select[name^="attendance_status"] option[value="leave"]:selected').length;
        
        $('#present_count').text(present);
        $('#absent_count').text(absent);
        $('#leave_count').text(leave);
        $('#total_count').text(present + absent + leave);
    }
    
    // Load sections when class changes
    $('#class_id').on('change', function() {
        const classId = $(this).val();
        $('#section_id').html('<option value="">Select Section</option>');
        $('#students_container').addClass('hidden');
        $('#submit_btn').addClass('hidden');
        
        if (classId) {
            $.get(`/teacher/attendance/get-sections/${classId}`, function(data) {
                let options = '<option value="">Select Section</option>';
                data.sections.forEach(section => {
                    options += `<option value="${section.id}">${section.name}</option>`;
                });
                $('#section_id').html(options);
            });
        }
    });
    
    // Load students when section changes
    $('#section_id').on('change', function() {
        const classId = $('#class_id').val();
        const sectionId = $(this).val();
        const date = $('input[name="date"]').val();
        
        if (classId && sectionId) {
            $.post('/teacher/attendance/get-students', {
                class_id: classId,
                section_id: sectionId,
                _token: '{{ csrf_token() }}'
            }, function(data) {
                $('#student_rows').empty();
                
                if (data.students.length > 0) {
                    data.students.forEach((student, index) => {
                        const profilePic = student.profile_pic ? 
                            `<img src="/storage/${student.profile_pic}" alt="${student.full_name}" class="h-full w-full object-cover">` : 
                            `<div class="h-full w-full flex items-center justify-center text-gray-500 font-medium">${student.full_name.charAt(0)}</div>`;
                        
                        $('#student_rows').append(`
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">${index + 1}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 overflow-hidden">
                                            ${profilePic}
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">${student.full_name}</div>
                                            <div class="text-sm text-gray-500">Roll No: ${student.roll_number || 'N/A'}</div>
                                            <div class="text-xs text-gray-400">ID: ${student.id}</div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="student_ids[]" value="${student.id}">
                                </td>
                                <td class="px-6 py-4">
                                    <select name="attendance_status[${student.id}]" required
                                        class="attendance-select px-3 py-1 rounded-lg border border-gray-300 focus:outline-none focus:ring focus:border-blue-400 transition">
                                        <option value="present" selected>✅ Present</option>
                                        <option value="absent">❌ Absent</option>
                                        <option value="leave">📘 Leave</option>
                                    </select>
                                </td>
                                <td class="px-6 py-4">
                                    <input type="text" name="remarks[${student.id}]" placeholder="Optional remarks"
                                        class="w-full px-3 py-1 rounded-lg border border-gray-300 focus:outline-none focus:ring focus:border-blue-400 transition">
                                </td>
                            </tr>
                        `);
                    });
                    
                    // Update display info
                    const classText = $('#class_id option:selected').text();
                    const sectionText = $('#section_id option:selected').text();
                    $('#class_section_display').text(`${classText} - ${sectionText}`);
                    $('#date_display').text(formatDisplayDate(date));
                    
                    // Show container and submit button
                    $('#students_container').removeClass('hidden');
                    $('#submit_btn').removeClass('hidden');
                    updateCounters();
                } else {
                    $('#students_container').addClass('hidden');
                    $('#submit_btn').addClass('hidden');
                }
            });
        } else {
            $('#students_container').addClass('hidden');
            $('#submit_btn').addClass('hidden');
        }
    });
    
    // Update date display when date changes
    $('input[name="date"]').on('change', function() {
        if ($('#date_display').text()) {
            $('#date_display').text(formatDisplayDate($(this).val()));
        }
    });
    
    // Update counters when attendance status changes
    $(document).on('change', '.attendance-select', function() {
        updateCounters();
    });
});
</script>
@endsection