@extends('layouts.app')

@section('title', 'Project Calendar')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-black fw-bold mb-0">📅 Project Calendar</h2>
    </div>

    <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
        <div class="card-body p-0">
            <div class="calendar-container">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>

<!-- FullCalendar & dependencies -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/main.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>

<style>
    .calendar-container {
        width: 100%;
        margin: 0 auto;
        padding: 1rem;
    }

    /* Card styling */
    .card {
        border: none !important;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border-radius: 16px !important;
    }

    /* Header toolbar */
    .fc-toolbar {
        padding: 1rem 1rem 0;
        flex-wrap: wrap;
    }

    .fc-toolbar-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #2c3e50;
    }

    /* Button styling */
    .fc-button {
        background: #f8f9fa !important;
        border: 1px solid #e9ecef !important;
        color: #495057 !important;
        border-radius: 8px !important;
        padding: 0.4rem 0.8rem !important;
        font-size: 0.875rem;
        font-weight: 500 !important;
        box-shadow: none !important;
        transition: all 0.2s ease;
    }

    .fc-button:hover {
        background: #e9ecef !important;
        color: #212529 !important;
    }

    .fc-button-active {
        background: #0d6efd !important;
        border-color: #0d6efd !important;
        color: white !important;
    }

    /* Today button */
    .fc-today-button {
        background: transparent !important;
        border-color: #0d6efd !important;
        color: #0d6efd !important;
    }

    /* Calendar header */
    .fc-col-header-cell {
        background: #f8f9fa;
        border-color: #e9ecef !important;
    }

    .fc-col-header-cell-cushion {
        color: #495057;
        font-weight: 500;
        padding: 0.5rem;
        text-decoration: none !important;
    }

    /* Day cells */
    .fc-daygrid-day {
        border-color: #e9ecef !important;
    }

    .fc-daygrid-day-number {
        color: #495057;
        font-weight: 500;
        padding: 0.5rem;
        text-decoration: none !important;
    }

    .fc-day-today {
        background-color: rgba(13, 110, 253, 0.1) !important;
    }

    /* Event styling */
    .fc-event {
        border: none !important;
        border-radius: 6px !important;
        padding: 4px 6px !important;
        font-size: 0.8rem !important;
        font-weight: 500 !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .fc-event:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .fc-event-title {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Event type colors */
    .event-school {
        background: linear-gradient(135deg, #1E90FF, #0d6efd) !important;
        color: white !important;
    }

    .event-private {
        background: linear-gradient(135deg, #32CD32, #28a745) !important;
        color: white !important;
    }

    .event-work {
        background: linear-gradient(135deg, #6f42c1, #6610f2) !important;
        color: white !important;
    }

    /* Deadline indicator */
    .deadline-dot {
        display: inline-block;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin-right: 6px;
        vertical-align: middle;
    }

    .dot-red {
        background-color: #dc3545;
        box-shadow: 0 0 0 2px rgba(220, 53, 69, 0.3);
    }

    .dot-yellow {
        background-color: #ffc107;
        box-shadow: 0 0 0 2px rgba(255, 193, 7, 0.3);
    }

    .dot-green {
        background-color: #28a745;
        box-shadow: 0 0 0 2px rgba(40, 167, 69, 0.3);
    }

    .dot-gray {
        background-color: #6c757d;
        box-shadow: 0 0 0 2px rgba(108, 117, 125, 0.3);
    }

    /* Mobile adjustments */
    @media (max-width: 768px) {
        .fc-toolbar {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .fc-toolbar-chunk {
            width: 100%;
            display: flex;
            justify-content: space-between;
        }
        
        .fc-header-toolbar .fc-toolbar-chunk:nth-child(2) {
            order: -1;
            margin-bottom: 0.5rem;
        }
        
        .fc-button {
            padding: 0.3rem 0.6rem !important;
            font-size: 0.8rem !important;
        }
        
        .fc-toolbar-title {
            font-size: 1.1rem;
        }
        
        .fc-event {
            font-size: 0.7rem !important;
            padding: 2px 4px !important;
        }
    }

    /* Popover styling */
    .fc-popover {
        border-radius: 12px !important;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        border: none !important;
    }

    .fc-popover-header {
        background: #f8f9fa !important;
        border-radius: 12px 12px 0 0 !important;
        font-weight: 600;
    }

    /* List view adjustments */
    .fc-list-event:hover td {
        background-color: #f8f9fa !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: window.innerWidth < 768 ? 'listWeek' : 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: window.innerWidth < 768 ? 'listWeek' : 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            firstDay: 1, // Monday as first day
            navLinks: true,
            editable: false,
            selectable: false,
            nowIndicator: true,
            dayMaxEvents: 3,
            height: 'auto',
            events: @json($events),

            eventClick: function(info) {
                window.location.href = info.event.url;
            },

            eventDidMount: function(info) {
                // Add event type class
                let eventType = info.event.title.split(' ')[0];

                if (eventType === '🎓') {
                    info.el.classList.add('event-school');
                } else if (eventType === '🌱') {
                    info.el.classList.add('event-private');
                } else if (eventType === '💼') {
                    info.el.classList.add('event-work');
                }

                // Add deadline indicator
                const now = new Date();
                const end = new Date(info.event.end || info.event.start);
                const diffInDays = Math.floor((end - now) / (1000 * 60 * 60 * 24));

                let dot = document.createElement('span');
                dot.classList.add('deadline-dot');

                if (end < now) {
                    dot.classList.add('dot-gray');
                } else if (diffInDays === 0 || diffInDays === 1) {
                    dot.classList.add('dot-red');
                } else if (diffInDays <= 3) {
                    dot.classList.add('dot-yellow');
                } else {
                    dot.classList.add('dot-green');
                }

                const titleEl = info.el.querySelector('.fc-event-title');
                if (titleEl) {
                    titleEl.prepend(dot);
                }
            }
        });

        calendar.render();

        // Responsive adjustments
        window.addEventListener('resize', function() {
            if (window.innerWidth < 768 && calendar.view.type !== 'listWeek') {
                calendar.changeView('listWeek');
            } else if (window.innerWidth >= 768 && calendar.view.type === 'listWeek') {
                calendar.changeView('dayGridMonth');
            }
        });
    });
</script>
@endsection