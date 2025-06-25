@extends('page.teacher.parent')

@section('content')
    <div class="max-w-7xl mx-auto py-6">
        <h2 class="text-2xl font-bold mb-6">📅 Attendance Calendar</h2>

        <div class="flex flex-col md:flex-row gap-6 mb-6">
            <!-- Class -->
            <div class="w-full">
                <label class="block mb-1 text-sm font-medium text-gray-700">Class</label>
                <select id="class_id" class="border px-3 py-2 rounded w-full">
                    <option value="">-- Select Class --</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Section -->
            <div class="w-full">
                <label class="block mb-1 text-sm font-medium text-gray-700">Section</label>
                <select id="section_id" class="border px-3 py-2 rounded w-full">
                    <option value="">-- Select Section --</option>
                </select>
            </div>

            <!-- Subject -->
            <div class="w-full">
                <label class="block mb-1 text-sm font-medium text-gray-700">Subject</label>
                <select id="subject_id" class="border px-3 py-2 rounded w-full">
                    <option value="">-- Select Subject --</option>
                </select>
            </div>
        </div>
    </div>

    <div id="calendar" class="bg-white p-4 rounded shadow"></div>
    </div>

    <!-- FullCalendar + jQuery -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            let calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                initialView: 'dayGridMonth',
                height: "auto",
                events: fetchEvents
            });

            calendar.render();

            $('#class_id').on('change', function() {
                const classId = $(this).val();

                $('#subject_id').html('<option value="">-- Select Subject --</option>');
                $('#section_id').html('<option value="">-- Select Section --</option>');

                if (classId) {
                    // Get Sections
                    $.get(`/teacher/get-sections/${classId}`, function(res) {
                        let options = '<option value="">-- Select Section --</option>';
                        res.sections.forEach(section => {
                            options +=
                                `<option value="${section.id}">${section.name}</option>`;
                        });
                        $('#section_id').html(options);
                    });

                    // Get Subjects
                    $.get(`/teacher/get-subjects/${classId}`, function(res) {
                        let options = '<option value="">-- Select Subject --</option>';
                        res.subjects.forEach(subject => {
                            options +=
                                `<option value="${subject.id}">${subject.name}</option>`;
                        });
                        $('#subject_id').html(options);
                    });
                }

                // Refetch events
                calendar.refetchEvents();
            });


            function fetchEvents(info, successCallback, failureCallback) {
                // Only fetch if all selections are made
                const classId = $('#class_id').val();
                const sectionId = $('#section_id').val();
                const subjectId = $('#subject_id').val();

                if (!classId || !sectionId || !subjectId) {
                    return successCallback([]);
                }

                $.ajax({
                    url: "/teacher/attendance-events",
                    data: {
                        start: info.startStr,
                        end: info.endStr,
                        class_id: classId,
                        section_id: sectionId,
                        subject_id: subjectId
                    },
                    success: function(response) {
                        successCallback(response);
                    },
                    error: function() {
                        failureCallback();
                    }
                });
            }

        });
    </script>
    <script>
        $(document).ready(function() {
            $('#class_id').on('change', function() {
                const classId = $(this).val();

                $('#subject_id').html('<option value="">-- Select Subject --</option>');
                $('#section_id').html('<option value="">-- Select Section --</option>');

                if (classId) {
                    $.get(`/subjects/by-class/${classId}`, function(data) {
                        $.each(data, function(i, subject) {
                            $('#subject_id').append(
                                `<option value="${subject.id}">${subject.name} (${subject.code})</option>`
                            );
                        });
                    });

                    $.get(`/sections/by-class/${classId}`, function(data) {
                        $.each(data, function(i, section) {
                            $('#section_id').append(
                                `<option value="${section.id}">${section.name}</option>`
                            );
                        });
                    });
                }
            });
        });
    </script>
@endsection
