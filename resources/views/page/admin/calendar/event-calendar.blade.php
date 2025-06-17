@extends('page.admin.parent')
 <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
            min-height: 100vh;
        }
        
        .calendar-header {
            background: linear-gradient(90deg, #4361ee 0%, #3a0ca3 100%);
            color: white;
            border-radius: 16px 16px 0 0;
        }
        
        .fc .fc-button {
            background-color: #4361ee;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .fc .fc-button:hover {
            background-color: #3a0ca3;
            transform: translateY(-2px);
        }
        
        .fc .fc-button-primary:not(:disabled).fc-button-active {
            background-color: #7209b7;
        }
        
        .fc-daygrid-event {
            border-radius: 8px;
            padding: 4px 8px;
            border-left: 4px solid #4361ee;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            transition: all 0.2s ease;
        }
        
        .fc-daygrid-event:hover {
            transform: translateX(3px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .fc .fc-daygrid-day.fc-day-today {
            background-color: rgba(67, 97, 238, 0.1);
        }
        
        .fc .fc-col-header-cell.fc-day-today {
            background-color: rgba(67, 97, 238, 0.1);
        }
        
        .modal-content {
            animation: modalFadeIn 0.3s ease-out;
        }
        
        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .form-input {
            border: 1px solid #d1d5db;
            border-radius: 10px;
            padding: 12px 16px;
            transition: all 0.3s ease;
        }
        
        .form-input:focus {
            border-color: #4361ee;
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
            outline: none;
        }
        
        .btn-primary {
            background: linear-gradient(90deg, #4361ee 0%, #3a0ca3 100%);
            color: white;
            border-radius: 10px;
            padding: 10px 24px;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.4);
        }
        
        .btn-secondary {
            background: #f1f5f9;
            color: #64748b;
            border-radius: 10px;
            padding: 10px 24px;
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover {
            background: #e2e8f0;
            transform: translateY(-3px);
        }
        
        .btn-danger {
            background: linear-gradient(90deg, #ef476f 0%, #d90429 100%);
            color: white;
            border-radius: 10px;
            padding: 10px 24px;
            transition: all 0.3s ease;
        }
        
        .btn-danger:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(239, 71, 111, 0.4);
        }
        
        .stats-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        
        .event-indicator {
            height: 10px;
            width: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }
        
        .feature-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 16px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
</style>
  
@section('content')
 <head>
    <meta charset="UTF-8">
    <title>Event Calendar Manager</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
            min-height: 100vh;
        }
        
        .calendar-header {
            background: linear-gradient(90deg, #4361ee 0%, #3a0ca3 100%);
            color: white;
            border-radius: 16px 16px 0 0;
        }
        
        .fc .fc-button {
            background-color: #4361ee;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .fc .fc-button:hover {
            background-color: #3a0ca3;
            transform: translateY(-2px);
        }
        
        .fc .fc-button-primary:not(:disabled).fc-button-active {
            background-color: #7209b7;
        }
        
        .fc-daygrid-event {
            border-radius: 8px;
            padding: 4px 8px;
            border-left: 4px solid #4361ee;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            transition: all 0.2s ease;
        }
        
        .fc-daygrid-event:hover {
            transform: translateX(3px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .fc .fc-daygrid-day.fc-day-today {
            background-color: rgba(67, 97, 238, 0.1);
        }
        
        .fc .fc-col-header-cell.fc-day-today {
            background-color: rgba(67, 97, 238, 0.1);
        }
        
        .modal-content {
            animation: modalFadeIn 0.3s ease-out;
        }
        
        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .form-input {
            border: 1px solid #d1d5db;
            border-radius: 10px;
            padding: 12px 16px;
            transition: all 0.3s ease;
        }
        
        .form-input:focus {
            border-color: #4361ee;
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
            outline: none;
        }
        
        .btn-primary {
            background: linear-gradient(90deg, #4361ee 0%, #3a0ca3 100%);
            color: white;
            border-radius: 10px;
            padding: 10px 24px;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.4);
        }
        
        .btn-secondary {
            background: #f1f5f9;
            color: #64748b;
            border-radius: 10px;
            padding: 10px 24px;
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover {
            background: #e2e8f0;
            transform: translateY(-3px);
        }
        
        .btn-danger {
            background: linear-gradient(90deg, #ef476f 0%, #d90429 100%);
            color: white;
            border-radius: 10px;
            padding: 10px 24px;
            transition: all 0.3s ease;
        }
        
        .btn-danger:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(239, 71, 111, 0.4);
        }
        
        .stats-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        
        .event-indicator {
            height: 10px;
            width: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }
        
        .feature-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 16px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="min-h-screen">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <header class="text-center mb-12">
           <div class="text-center mb-8">
    <h1 class="text-4xl font-extrabold text-gray-800 mb-3">📅 Event Calendar Manager</h1>

</div>

        </header>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <div class="stats-card p-6 flex items-center">
                <div class="mr-4 p-4 bg-blue-100 rounded-full">
                    <i class="fas fa-calendar-plus text-blue-600 text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-800" id="events-count">0</h3>
                    <p class="text-gray-600">Total Events</p>
                </div>
            </div>
            
            <div class="stats-card p-6 flex items-center">
                <div class="mr-4 p-4 bg-purple-100 rounded-full">
                    <i class="fas fa-tasks text-purple-600 text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-800" id="upcoming-count">0</h3>
                    <p class="text-gray-600">Upcoming Events</p>
                </div>
            </div>
            
            <div class="stats-card p-6 flex items-center">
                <div class="mr-4 p-4 bg-green-100 rounded-full">
                    <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-800" id="completed-count">0</h3>
                    <p class="text-gray-600">Completed Events</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-10">
            <div class="calendar-header px-6 py-4 flex flex-wrap justify-between items-center">
                <h2 class="text-xl font-bold">Event Calendar</h2>
                <div class="flex items-center space-x-2">
                    <div class="flex items-center">
                        <span class="event-indicator bg-blue-500"></span>
                        <span class="text-sm">Today's Events</span>
                    </div>
                    <div class="flex items-center ml-4">
                        <span class="event-indicator bg-purple-500"></span>
                        <span class="text-sm">Upcoming</span>
                    </div>
                </div>
            </div>
            <div id="calendar" class="p-4 md:p-6"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="feature-card p-6">
                <div class="text-blue-500 text-3xl mb-4">
                    <i class="fas fa-mouse-pointer"></i>
                </div>
                <h3 class="font-bold text-lg mb-2">Easy to Use</h3>
                <p class="text-gray-600">Simply click on any date to add a new event or click existing events to edit them.</p>
            </div>
            
            <div class="feature-card p-6">
                <div class="text-purple-500 text-3xl mb-4">
                    <i class="fas fa-arrows-alt"></i>
                </div>
                <h3 class="font-bold text-lg mb-2">Drag & Drop</h3>
                <p class="text-gray-600">Reschedule events by dragging them to new dates. Changes are saved automatically.</p>
            </div>
            
            <div class="feature-card p-6">
                <div class="text-green-500 text-3xl mb-4">
                    <i class="fas fa-sync-alt"></i>
                </div>
                <h3 class="font-bold text-lg mb-2">Real-time Updates</h3>
                <p class="text-gray-600">All changes are reflected immediately across your calendar. No page reload needed.</p>
            </div>
        </div>
    </div>

    <!-- Event Modal -->
    <div id="event-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg modal-content">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 id="modal-title" class="text-xl font-bold text-gray-800">Add Event</h2>
                    <button id="close-modal" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <form id="event-form">
                    <input type="hidden" id="event-id">
                    
                    <div class="mb-5">
                        <label class="block mb-2 font-medium text-gray-700">Event Title</label>
                        <input type="text" id="title" class="form-input w-full" placeholder="Meeting with team">
                    </div>
                    
                    <div class="mb-5">
                        <label class="block mb-2 font-medium text-gray-700">Description</label>
                        <textarea id="description" rows="3" class="form-input w-full" placeholder="Add event details..."></textarea>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                        <div>
                            <label class="block mb-2 font-medium text-gray-700">Start Time</label>
                            <input type="datetime-local" id="start" class="form-input w-full">
                        </div>
                        <div>
                            <label class="block mb-2 font-medium text-gray-700">End Time</label>
                            <input type="datetime-local" id="end" class="form-input w-full">
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap justify-end gap-2 pt-2">
                        <button type="button" id="delete-button" class="btn-danger hidden">
                            <i class="fas fa-trash mr-2"></i>Delete
                        </button>
                        <button type="button" id="close-btn" class="btn-secondary">
                            Cancel
                        </button>
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save mr-2"></i>Save Event
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let allEvents = [];

        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');
            const modal = document.getElementById('event-modal');
            const form = document.getElementById('event-form');
            const deleteBtn = document.getElementById('delete-button');
            const closeBtn = document.getElementById('close-btn');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                selectable: true,
                editable: true,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: 'Today',
                    month: 'Month',
                    week: 'Week',
                    day: 'Day'
                },
                themeSystem: 'standard',
                height: 'auto',
                nowIndicator: true,
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: true
                },
                events: {
                    url: '/calendar/events',
                    method: 'GET',
                    success: function(response) {
                        allEvents = response;
                        updateEventStats();
                    }
                },
                
                eventDidMount: function(info) {
                    // Color events based on date
                    const now = new Date();
                    const eventStart = info.event.start;
                    const eventEnd = info.event.end || eventStart;
                    
                    if (eventStart <= now && eventEnd >= now) {
                        // Current event
                        info.el.style.backgroundColor = '#4361ee';
                        info.el.style.borderLeftColor = '#3a0ca3';
                        info.el.style.color = 'white';
                    } else if (eventStart > now) {
                        // Upcoming event
                        info.el.style.backgroundColor = '#f0abfc';
                        info.el.style.borderLeftColor = '#c026d3';
                    } else {
                        // Past event
                        info.el.style.backgroundColor = '#bbf7d0';
                        info.el.style.borderLeftColor = '#16a34a';
                    }
                    
                    // Add hover effect
                    info.el.addEventListener('mouseenter', function() {
                        info.el.style.transform = 'translateY(-2px)';
                        info.el.style.boxShadow = '0 4px 8px rgba(0,0,0,0.1)';
                    });
                    
                    info.el.addEventListener('mouseleave', function() {
                        info.el.style.transform = '';
                        info.el.style.boxShadow = '';
                    });
                },

                select(info) {
                    openModal('', '', info.startStr, info.endStr, '');
                },

                eventClick(info) {
                    const event = info.event;
                    openModal(
                        event.title,
                        event.extendedProps.description || '',
                        event.startStr,
                        event.end ? event.endStr : event.startStr,
                        event.id
                    );
                },

                eventDrop(info) {
                    axios.put(`/calendar/events/${info.event.id}`, {
                        title: info.event.title,
                        description: info.event.extendedProps.description || '',
                        start: info.event.start.toISOString(),
                        end: info.event.end ? info.event.end.toISOString() : null
                    }, {
                        headers: { 'X-CSRF-TOKEN': csrfToken }
                    }).then(() => {
                        calendar.refetchEvents();
                        updateEventStats();
                    });
                }
            });

            calendar.render();

            form.addEventListener('submit', function (e) {
                e.preventDefault();
                const id = document.getElementById('event-id').value;
                const data = {
                    title: document.getElementById('title').value,
                    description: document.getElementById('description').value,
                    start: document.getElementById('start').value,
                    end: document.getElementById('end').value
                };

                const url = id ? `/calendar/events/${id}` : '/calendar/events';
                const method = id ? 'put' : 'post';

                axios[method](url, data, {
                    headers: { 'X-CSRF-TOKEN': csrfToken }
                }).then(() => {
                    closeModal();
                    calendar.refetchEvents();
                    updateEventStats();
                });
            });

            deleteBtn.addEventListener('click', function() {
                const id = document.getElementById('event-id').value;
                if (id && confirm('Are you sure you want to delete this event?')) {
                    axios.delete(`/calendar/events/${id}`, {
                        headers: { 'X-CSRF-TOKEN': csrfToken }
                    }).then(() => {
                        closeModal();
                        calendar.refetchEvents();
                        updateEventStats();
                    });
                }
            });

            document.getElementById('close-modal').addEventListener('click', closeModal);
            closeBtn.addEventListener('click', closeModal);

            function openModal(title, desc, start, end, id) {
                modal.classList.remove('hidden');
                document.getElementById('modal-title').innerText = id ? 'Edit Event' : 'Add New Event';
                document.getElementById('title').value = title;
                document.getElementById('description').value = desc;
                document.getElementById('start').value = start.substring(0, 16);
                document.getElementById('end').value = end ? end.substring(0, 16) : '';
                document.getElementById('event-id').value = id;

                if (id) {
                    deleteBtn.classList.remove('hidden');
                } else {
                    deleteBtn.classList.add('hidden');
                }
            }

            function closeModal() {
                modal.classList.add('hidden');
                form.reset();
                deleteBtn.classList.add('hidden');
            }
            
            function updateEventStats() {
                const now = new Date();
                const eventsCount = allEvents.length;
                let upcomingCount = 0;
                let completedCount = 0;
                
                allEvents.forEach(event => {
                    const eventStart = new Date(event.start);
                    if (eventStart > now) {
                        upcomingCount++;
                    } else if (eventStart < now) {
                        completedCount++;
                    }
                });
                
                document.getElementById('events-count').textContent = eventsCount;
                document.getElementById('upcoming-count').textContent = upcomingCount;
                document.getElementById('completed-count').textContent = completedCount;
            }
            
            // Close modal when clicking outside
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal();
                }
            });
        });
    </script>
</body>
   


@endsection