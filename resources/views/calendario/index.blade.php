<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-xl text-gray-800 leading-tight">Calendario de Eventos</h2>
                <p class="mt-1 text-sm text-gray-500">Visualiza partos, celos y vacunas en un calendario.</p>
            </div>
        </div>
    </x-slot>

    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">
    <style>
        #calendar { max-width: 100%; margin: 0 auto; }
        .fc-event { cursor: pointer; font-size: 11px; padding: 1px 3px; border-radius: 4px; font-weight: 600; }
        .fc-toolbar-title { font-size: 1.1rem !important; font-weight: 700 !important; }
        .fc-button-primary { background-color: #f4b08a !important; border-color: #f4b08a !important; }
        .fc-button-primary:not(:disabled).fc-button-active, .fc-button-primary:not(:disabled):active { background-color: #e39a72 !important; border-color: #e39a72 !important; }
        .fc-button-primary:hover { background-color: #e39a72 !important; border-color: #e39a72 !important; }
        .fc-day-today { background-color: #fff8f3 !important; }
        .fc-daygrid-event-dot { display: none; }
    </style>
    @endpush

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white border border-gray-200/85 rounded-2xl shadow-sm p-6">
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/locales-all.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'es',
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek'
                },
                buttonText: {
                    today: 'Hoy',
                    month: 'Mes',
                    week: 'Semana'
                },
                events: {
                    url: '{{ route("calendario.eventos.json") }}',
                    failure: function() { console.error('Error al cargar eventos del calendario.'); }
                },
                eventClick: function(info) {
                    if (info.event.url) {
                        window.open(info.event.url, '_parent');
                    }
                },
                loading: function(isLoading) {
                    if (!isLoading) {
                        document.querySelector('.fc-button-primary')?.focus();
                    }
                }
            });
            calendar.render();
        });
    </script>
    @endpush
</x-app-layout>
