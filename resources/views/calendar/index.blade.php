@extends('layouts.app')

@section('title', 'Kalender Proyek')

@section('content')
<div class="container mt-4">
    <h3 class="text-black mb-4">📅 Kalender Proyek</h3>

    <div class="card shadow-sm border border-secondary rounded">
        <div class="card-body p-4">
            <div id="calendar-container">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>

<!-- FullCalendar & jQuery -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/main.min.css">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.5/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>

<style>
    #calendar-container {
        max-width: 800px;
        margin: 0 auto;
    }

    #calendar {
        width: 100%;
    }

    .card {
        border: 2px solid #dee2e6 !important;
    }

    .fc-daygrid-day-number, .fc-col-header-cell-cushion {
        color: #000 !important;
    }

    .fc-button {
        background: none !important;
        border: none !important;
        box-shadow: none !important;
        padding: 5px 10px !important;
        font-weight: bold !important;
        color: #000 !important;
    }

    .fc-button:hover {
        opacity: 0.7;
    }

    .fc-prev-button, .fc-next-button {
        background: none !important;
        border: none !important;
        box-shadow: none !important;
        width: auto !important;
        height: auto !important;
        padding: 0 !important;
    }

    .fc-prev-button .fc-icon, .fc-next-button .fc-icon {
        color: #000 !important;
    }

    .fc-prev-button:hover .fc-icon, .fc-next-button:hover .fc-icon {
        opacity: 0.7;
    }

    @media (max-width: 768px) {
        #calendar {
            font-size: 12px;
        }
    }

    .fc-event {
        font-size: 14px;
        padding: 4px;
        border-radius: 5px;
        transition: 0.3s;
        text-align: center;
        font-weight: normal !important;
    }

    .fc-event:hover {
        opacity: 0.8;
        transform: scale(1.02);
    }

    .event-sekolah {
        background-color: #1E90FF !important;
        border: 2px solid #104E8B !important;
        color: #fff !important;
    }

    .event-pribadi {
        background-color: #32CD32 !important;
        border: 2px solid #228B22 !important;
        color: #fff !important;
    }

    .event-pekerjaan {
        background-color: #0a82b5 !important;
        border: 2px solid #0066ec !important;
        color: #fff !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: window.innerWidth < 768 ? 'listWeek' : 'dayGridMonth',
            height: "auto",
            contentHeight: "auto",
            aspectRatio: 1.5,
            events: @json($events),

            eventClick: function(info) {
                window.location.href = info.event.url;
            },

            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: window.innerWidth < 768 ? 'listWeek' : 'dayGridMonth,timeGridWeek,timeGridDay'
            },

            eventDidMount: function(info) {
                let eventText = info.el.querySelector('.fc-event-title');

                if (!eventText) return;

                let eventType = info.event.title.split(' ')[0]; // Ambil ikon sebagai identifier

                if (eventType === '🎓') {
                    info.el.classList.add('event-sekolah');
                } else if (eventType === '🌱') {
                    info.el.classList.add('event-pribadi');
                } else if (eventType === '💼') {
                    info.el.classList.add('event-pekerjaan');
                }
            }
        });

        calendar.render();
    });
</script>

<script type="application/json" id="calendar-event-data">
    {!! json_encode($events) !!}
</script>
@endsection
