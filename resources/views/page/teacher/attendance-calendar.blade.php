@extends('page.teacher.parent')

@section('content')
<div class="max-w-6xl mx-auto py-6">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-6">📅 Attendance Calendar - {{ $teacher->name }}</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Class</label>
                <select id="classSelect" class="w-full border rounded-md p-2">
                    <option value="">Select Class</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Section</label>
                <select id="sectionSelect" class="w-full border rounded-md p-2" disabled>
                    <option value="">Select Section</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                <select id="subjectSelect" class="w-full border rounded-md p-2" disabled>
                    <option value="">Select Subject</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Student (Roll No)</label>
                <select id="studentSelect" class="w-full border rounded-md p-2" disabled>
                    <option value="">All Students</option>
                </select>
            </div>
            
            <div class="flex items-end">
                <button id="loadCalendarBtn" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed" disabled>
                    Load Calendar
                </button>
            </div>
        </div>
        
        <div id="calendar" class="mt-4"></div>

        <!-- Attendance Report Table -->
        <div id="reportSection" class="mt-8 hidden">
            <h3 class="text-xl font-bold mb-4">📄 Student Attendance Report</h3>
            <table class="min-w-full border text-sm">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-2 py-1">Date</th>
                        <th class="border px-2 py-1">Subject</th>
                        <th class="border px-2 py-1">Status</th>
                    </tr>
                </thead>
                <tbody id="reportTableBody"></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Event Modal -->
<div id="eventModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h3 class="text-xl font-bold mb-2" id="modalTitle"></h3>
        <p class="text-gray-600 mb-1"><span class="font-medium">Status:</span> <span id="modalStatus"></span></p>
        <p class="text-gray-600 mb-1"><span class="font-medium">Subject:</span> <span id="modalSubject"></span></p>
        <p class="text-gray-600 mb-4"><span class="font-medium">Date:</span> <span id="modalDate"></span></p>
        <button onclick="document.getElementById('eventModal').classList.add('hidden')" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
            Close
        </button>
    </div>
</div>
@endsection

@section('scripts')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let calendar;
    let initialized = false;

    const classSelect = document.getElementById('classSelect');
    const sectionSelect = document.getElementById('sectionSelect');
    const subjectSelect = document.getElementById('subjectSelect');
    const studentSelect = document.getElementById('studentSelect');
    const loadCalendarBtn = document.getElementById('loadCalendarBtn');

    classSelect.addEventListener('change', function() {
        const classId = this.value;
        sectionSelect.disabled = !classId;
        subjectSelect.disabled = !classId;
        studentSelect.disabled = true;
        loadCalendarBtn.disabled = true;

        sectionSelect.innerHTML = '<option value="">Select Section</option>';
        subjectSelect.innerHTML = '<option value="">Select Subject</option>';
        studentSelect.innerHTML = '<option value="">All Students</option>';

        if (!classId) return;

        fetch(`/teacher/get-sections/${classId}`)
            .then(response => response.json())
            .then(data => {
                data.sections.forEach(section => {
                    sectionSelect.innerHTML += `<option value="${section.id}">${section.name}</option>`;
                });
            });

        fetch(`/teacher/get-subjects/${classId}`)
            .then(response => response.json())
            .then(data => {
                data.subjects.forEach(subject => {
                    subjectSelect.innerHTML += `<option value="${subject.id}">${subject.name}</option>`;
                });
            });
    });

    sectionSelect.addEventListener('change', function() {
        const classId = classSelect.value;
        const sectionId = this.value;
        studentSelect.disabled = !sectionId;

        studentSelect.innerHTML = '<option value="">All Students</option>';

        if (!sectionId) return;

        fetch(`/teacher/get-students/${classId}/${sectionId}`)
            .then(response => response.json())
            .then(data => {
                data.students.forEach(student => {
                    studentSelect.innerHTML += `<option value="${student.id}">${student.roll_no} - ${student.full_name}</option>`;
                });
            });

        updateLoadButton();
    });

    subjectSelect.addEventListener('change', updateLoadButton);
    studentSelect.addEventListener('change', function() {
        updateLoadButton();
        loadReport();
    });

    function updateLoadButton() {
        loadCalendarBtn.disabled = !(classSelect.value && sectionSelect.value && subjectSelect.value);
    }

    function initCalendar() {
        if (calendar) {
            calendar.destroy();
        }

        const calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: function(fetchInfo, successCallback, failureCallback) {
                const classId = classSelect.value;
                const sectionId = sectionSelect.value;
                const subjectId = subjectSelect.value;
                const studentId = studentSelect.value;

                if (!classId || !sectionId || !subjectId) {
                    return failureCallback('Select all filters');
                }

                let url = `/teacher/attendance-events?class_id=${classId}&section_id=${sectionId}&subject_id=${subjectId}&start=${fetchInfo.startStr}&end=${fetchInfo.endStr}`;
                if (studentId) {
                    url += `&student_id=${studentId}`;
                }

                fetch(url)
                    .then(response => response.json())
                    .then(data => successCallback(data))
                    .catch(error => failureCallback(error));
            },
            eventClick: function(info) {
                document.getElementById('modalTitle').textContent = info.event.extendedProps.student;
                document.getElementById('modalStatus').textContent = info.event.extendedProps.status;
                document.getElementById('modalSubject').textContent = info.event.extendedProps.subject;
                document.getElementById('modalDate').textContent = info.event.start.toLocaleDateString();
                document.getElementById('eventModal').classList.remove('hidden');
            }
        });

        calendar.render();
    }

    loadCalendarBtn.addEventListener('click', function() {
        if (!initialized) {
            initCalendar();
            initialized = true;
        } else {
            calendar.refetchEvents();
        }
        loadReport();
    });

    function loadReport() {
        const studentId = studentSelect.value;
        if (!studentId) {
            document.getElementById('reportSection').classList.add('hidden');
            return;
        }

        fetch(`/teacher/get-student-report?class_id=${classSelect.value}&section_id=${sectionSelect.value}&student_id=${studentId}`)
            .then(res => res.json())
            .then(data => {
                const tbody = document.getElementById('reportTableBody');
                tbody.innerHTML = '';

                if (data.report.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="3" class="text-center px-2 py-1">No attendance records found.</td></tr>';
                } else {
                    data.report.forEach(item => {
                        tbody.innerHTML += `
                            <tr>
                                <td class="border px-2 py-1">${item.date}</td>
                                <td class="border px-2 py-1">${item.subject ? item.subject.name : '-'}</td>
                                <td class="border px-2 py-1">${item.status.charAt(0).toUpperCase() + item.status.slice(1)}</td>
                            </tr>
                        `;
                    });
                }

                document.getElementById('reportSection').classList.remove('hidden');
            });
    }
});
</script>
@endsection
