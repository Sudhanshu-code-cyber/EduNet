@extends('page.teacher.parent')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold mb-6">📅 Attendance Calendar</h2>

    <div class="flex gap-4 mb-6">
        <div>
            <label class="block mb-1 text-sm font-medium">Class</label>
            <select id="class_id" class="border rounded px-3 py-2 w-full">
                <option value="">All</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block mb-1 text-sm font-medium">Section</label>
            <select id="section_id" name="section_id" class="...">
    <option value="">-- Choose Class First --</option>
</select>

        </div>
    </div>

    <div id="calendar" class="bg-white p-4 rounded shadow"></div>
</div>

<!-- FullCalendar + jQuery -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Calendar Logic -->
<script>
$(document).ready(function () {
    let calendarEl = document.getElementById('calendar');

    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: "auto",
        events: fetchEvents
    });

    calendar.render();

    $('#class_id').on('change', function () {
        loadSections($(this).val());
        calendar.refetchEvents();
    });

    $('#section_id').on('change', function () {
        calendar.refetchEvents();
    });

    function fetchEvents(info, successCallback, failureCallback) {
        $.ajax({
            url: "{{ route('attendance.events') }}",
            data: {
                start: info.startStr,
                end: info.endStr,
                class_id: $('#class_id').val(),
                section_id: $('#section_id').val()
            },
            success: function (response) {
                successCallback(response);
            },
            error: function () {
                failureCallback();
            }
        });
    }

    function loadSections(classId) {
        $('#section_id').html('<option value="">Loading...</option>');
        if (classId) {
            $.get(`/get-sections/${classId}`, function (data) {
                let options = '<option value="">All</option>';
                data.forEach(section => {
                    options += `<option value="${section.id}">${section.name}</option>`;
                });
                $('#section_id').html(options);
            });
        } else {
            $('#section_id').html('<option value="">All</option>');
        }
    }
});
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Load sections based on class selection
    $(document).ready(function () {
        $('#class_id').change(function () {
            const classId = $(this).val();
            $('#section_id').html('<option value="">Loading...</option>');

            $.ajax({
                url: '/get-sections-by-class/' + classId,
                type: 'GET',
                success: function (data) {
                    $('#section_id').html('<option value="">-- Choose Section --</option>');
                    $.each(data, function (index, section) {
                        $('#section_id').append('<option value="' + section.id + '">' + section.name + '</option>');
                    });
                }
            });
        });
    });
</script>
@endsection
