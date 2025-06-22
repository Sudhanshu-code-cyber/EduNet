@extends('page.teacher.parent')

@section('content')
    <div class="max-w-7xl mx-auto py-6">
        <h2 class="text-2xl font-bold mb-6">📅 Attendance Calendar</h2>

        <!-- Filters -->
        <div class="flex gap-4 mb-6">
            <div>
                <label class="block mb-1 text-sm font-medium">Class</label>
                <select id="class_id" class="border px-3 py-2 rounded w-full">
                    <option value="">-- Select Class --</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block mb-1 text-sm font-medium">Section</label>
                <select id="section_id" class="border px-3 py-2 rounded w-full">
                    <option value="">-- Select Section --</option>
                </select>
            </div>
            <div>
                <label class="block mb-1 text-sm font-medium">Subject</label>
                <select id="subject_id" class="border px-3 py-2 rounded w-full">
                    <option value="">-- Select Subject --</option>
                </select>
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
                let classId = $(this).val();

                $('#section_id').html('<option>Loading...</option>');
                $('#subject_id').html('<option>Loading...</option>');

                if (classId) {
                    $.get('/teacher/get-sections/' + classId, function(res) {
                        let options = '<option value="">-- Select Section --</option>';
                        res.sections.forEach(s => {
                            options += `<option value="${s.id}">${s.name}</option>`;
                        });
                        $('#section_id').html(options);
                    });

                    $.get('/teacher/get-subjects/' + classId, function(res) {
                        let options = '<option value="">-- Select Subject --</option>';
                        res.subjects.forEach(s => {
                            options += `<option value="${s.id}">${s.name}</option>`;
                        });
                        $('#subject_id').html(options);
                    });
                }

                calendar.refetchEvents();
            });

            $('#section_id, #subject_id').on('change', function() {
                calendar.refetchEvents();
            });

            function fetchEvents(info, successCallback, failureCallback) {
                $.ajax({
                    url: "/teacher/attendance-events", // ✔ No middleware, full URL
                    data: {
                        start: info.startStr,
                        end: info.endStr,
                        class_id: $('#class_id').val(),
                        section_id: $('#section_id').val(),
                        subject_id: $('#subject_id').val()
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
@endsection
