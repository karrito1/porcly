<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <h2 class="text-xl font-bold leading-tight text-gray-800">Calendario de eventos</h2>
                <p class="mt-1 text-sm text-gray-500">Vista compacta de partos, celos y vacunaciones, todo en un solo lugar.</p>
            </div>

            <div class="hidden gap-2 lg:flex">
                <button type="button" onclick="openCalendarPartoModal()" class="inline-flex items-center rounded-lg bg-brand-500 px-4 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-brand-600">
                    Registrar parto
                </button>
                <button type="button" onclick="openCalendarInseminacionModal()" class="inline-flex items-center rounded-lg border border-gray-200 bg-white px-4 py-2 text-xs font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50">
                    Registrar inseminación
                </button>
                <button type="button" onclick="openCalendarVacunacionModal()" class="inline-flex items-center rounded-lg border border-gray-200 bg-white px-4 py-2 text-xs font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50">
                    Registrar vacunación
                </button>
            </div>
        </div>
    </x-slot>

    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">
        <style>
            .calendar-shell {
                height: calc(100vh - 11.5rem);
            }

            #calendar {
                height: 100%;
            }

            .fc .fc-toolbar.fc-header-toolbar {
                margin-bottom: .75rem;
            }

            .fc .fc-toolbar-title {
                font-size: 1rem !important;
                font-weight: 700 !important;
                color: #111827;
            }

            .fc .fc-button-primary {
                background-color: #f4b08a !important;
                border-color: #f4b08a !important;
                color: #fff !important;
                box-shadow: none !important;
            }

            .fc .fc-button-primary:hover,
            .fc .fc-button-primary:focus,
            .fc .fc-button-primary:not(:disabled).fc-button-active,
            .fc .fc-button-primary:not(:disabled):active {
                background-color: #e39a72 !important;
                border-color: #e39a72 !important;
            }

            .fc .fc-day-today {
                background: #fff8f3 !important;
            }

            .fc .fc-daygrid-day-frame {
                padding: .2rem;
            }

            .fc .fc-daygrid-event {
                border-radius: .4rem;
                font-size: .72rem;
                font-weight: 600;
                padding: .08rem .25rem;
            }

            .fc .fc-event-title,
            .fc .fc-event-time {
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .fc .fc-event-time {
                display: none;
            }

            .calendar-list-item {
                display: grid;
                grid-template-columns: auto minmax(0, 1fr) auto;
                gap: .75rem;
                align-items: center;
            }

            @media (max-width: 1024px) {
                .calendar-shell {
                    height: auto;
                }
            }
        </style>
    @endpush

    <div class="py-5 lg:py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-4 sm:grid-cols-3">
                <div class="rounded-2xl border border-emerald-100 bg-emerald-50/70 p-4 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-widest text-emerald-700">Partos próximos</p>
                    <p class="mt-2 text-3xl font-extrabold text-emerald-900">{{ $resumenPartos }}</p>
                </div>
                <div class="rounded-2xl border border-amber-100 bg-amber-50/70 p-4 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-widest text-amber-700">Celos próximos</p>
                    <p class="mt-2 text-3xl font-extrabold text-amber-900">{{ $resumenCelos }}</p>
                </div>
                <div class="rounded-2xl border border-blue-100 bg-blue-50/70 p-4 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-widest text-blue-700">Vacunas próximas</p>
                    <p class="mt-2 text-3xl font-extrabold text-blue-900">{{ $resumenVacunas }}</p>
                </div>
            </div>

            <div class="mt-4 grid gap-5 xl:grid-cols-[minmax(0,1fr)_20rem] calendar-shell">
                <section class="flex min-h-0 flex-col rounded-3xl border border-gray-200/80 bg-white p-4 shadow-sm">
                    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-100 pb-4">
                        <div class="flex flex-wrap gap-2 text-[11px] font-semibold">
                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-3 py-1 text-emerald-700"><span class="h-2 w-2 rounded-full bg-emerald-500"></span>Partos realizados</span>
                            <span class="inline-flex items-center gap-1 rounded-full bg-brand-50 px-3 py-1 text-brand-700"><span class="h-2 w-2 rounded-full bg-[#f4b08a]"></span>Partos próximos</span>
                            <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-3 py-1 text-amber-700"><span class="h-2 w-2 rounded-full bg-amber-500"></span>Celos</span>
                            <span class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-3 py-1 text-blue-700"><span class="h-2 w-2 rounded-full bg-blue-500"></span>Vacunas</span>
                        </div>

                        <div class="flex gap-2 lg:hidden">
                            <button type="button" onclick="openCalendarPartoModal()" class="rounded-lg bg-brand-500 px-3 py-2 text-xs font-semibold text-white shadow-sm">Parto</button>
                            <button type="button" onclick="openCalendarInseminacionModal()" class="rounded-lg border border-gray-200 px-3 py-2 text-xs font-semibold text-gray-700">Inseminación</button>
                            <button type="button" onclick="openCalendarVacunacionModal()" class="rounded-lg border border-gray-200 px-3 py-2 text-xs font-semibold text-gray-700">Vacuna</button>
                        </div>
                    </div>

                    <div class="min-h-[34rem] flex-1 pt-4">
                        <div id="calendar"></div>
                    </div>
                </section>

                <aside class="flex min-h-0 flex-col gap-4">
                    <div class="rounded-3xl border border-gray-200/80 bg-white p-4 shadow-sm">
                        <div class="mb-3 flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-bold text-gray-900">Acciones rápidas</h3>
                                <p class="text-xs text-gray-500">Crear sin salir del calendario.</p>
                            </div>
                        </div>

                        <div class="grid gap-2">
                            <button type="button" onclick="openCalendarPartoModal()" class="rounded-2xl border border-emerald-100 bg-emerald-50 px-3 py-3 text-left transition hover:bg-emerald-100/80">
                                <p class="text-xs font-bold text-emerald-700">Nuevo parto</p>
                                <p class="mt-1 text-[11px] text-emerald-900/80">Registrar un parto desde esta vista.</p>
                            </button>
                            <button type="button" onclick="openCalendarInseminacionModal()" class="rounded-2xl border border-amber-100 bg-amber-50 px-3 py-3 text-left transition hover:bg-amber-100/80">
                                <p class="text-xs font-bold text-amber-700">Nueva inseminación</p>
                                <p class="mt-1 text-[11px] text-amber-900/80">Abrir el registro sin cambiar de página.</p>
                            </button>
                            <button type="button" onclick="openCalendarVacunacionModal()" class="rounded-2xl border border-blue-100 bg-blue-50 px-3 py-3 text-left transition hover:bg-blue-100/80">
                                <p class="text-xs font-bold text-blue-700">Nueva vacunación</p>
                                <p class="mt-1 text-[11px] text-blue-900/80">Agregar una vacuna al momento.</p>
                            </button>
                        </div>
                    </div>

                    <div class="rounded-3xl border border-gray-200/80 bg-white p-4 shadow-sm">
                        <h3 class="text-sm font-bold text-gray-900">Próximos partos</h3>
                        <div class="mt-3 space-y-2">
                            @forelse ($partosProximos as $evento)
                                <div class="calendar-list-item rounded-2xl bg-emerald-50/60 px-3 py-2">
                                    <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                                    <div>
                                        <p class="text-xs font-semibold text-gray-900">{{ $evento['cerda_codigo'] }} {{ $evento['cerda_nombre'] ? '• ' . $evento['cerda_nombre'] : '' }}</p>
                                        <p class="text-[11px] text-gray-500">{{ $evento['fecha_formateada'] }}</p>
                                    </div>
                                    <span class="rounded-full bg-white px-2 py-1 text-[10px] font-bold text-emerald-700">Parto</span>
                                </div>
                            @empty
                                <p class="text-xs text-gray-500">No hay partos próximos.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="rounded-3xl border border-gray-200/80 bg-white p-4 shadow-sm">
                        <h3 class="text-sm font-bold text-gray-900">Próximos celos</h3>
                        <div class="mt-3 space-y-2">
                            @forelse ($celosProximos as $evento)
                                <div class="calendar-list-item rounded-2xl bg-amber-50/60 px-3 py-2">
                                    <span class="h-2.5 w-2.5 rounded-full bg-amber-500"></span>
                                    <div>
                                        <p class="text-xs font-semibold text-gray-900">{{ $evento['cerda_codigo'] }} {{ $evento['cerda_nombre'] ? '• ' . $evento['cerda_nombre'] : '' }}</p>
                                        <p class="text-[11px] text-gray-500">{{ $evento['fecha_formateada'] }}</p>
                                    </div>
                                    <span class="rounded-full bg-white px-2 py-1 text-[10px] font-bold text-amber-700">Celo</span>
                                </div>
                            @empty
                                <p class="text-xs text-gray-500">No hay celos próximos.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="rounded-3xl border border-gray-200/80 bg-white p-4 shadow-sm">
                        <h3 class="text-sm font-bold text-gray-900">Próximas vacunas</h3>
                        <div class="mt-3 space-y-2">
                            @forelse ($vacunasProximas as $evento)
                                <div class="calendar-list-item rounded-2xl bg-blue-50/60 px-3 py-2">
                                    <span class="h-2.5 w-2.5 rounded-full bg-blue-500"></span>
                                    <div>
                                        <p class="text-xs font-semibold text-gray-900">{{ $evento['cerda_codigo'] }} {{ $evento['cerda_nombre'] ? '• ' . $evento['cerda_nombre'] : '' }}</p>
                                        <p class="text-[11px] text-gray-500">{{ $evento['detalle'] }}</p>
                                    </div>
                                    <span class="rounded-full bg-white px-2 py-1 text-[10px] font-bold text-blue-700">{{ $evento['fecha_formateada'] }}</span>
                                </div>
                            @empty
                                <p class="text-xs text-gray-500">No hay vacunas próximas.</p>
                            @endforelse
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>

    @include('calendario.partials.event-modal')
    @include('calendario.partials.parto-modal')
    @include('calendario.partials.inseminacion-modal')
    @include('calendario.partials.vacunacion-modal')

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/locales-all.global.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const calendarEl = document.getElementById('calendar');
                if (!calendarEl) return;

                function openModal(name) {
                    window.dispatchEvent(new CustomEvent('open-modal', { detail: name }));
                }

                function closeModal(name) {
                    window.dispatchEvent(new CustomEvent('close-modal', { detail: name }));
                }

                function setValue(id, value) {
                    const el = document.getElementById(id);
                    if (el) el.value = value ?? '';
                }

                function setText(id, value) {
                    const el = document.getElementById(id);
                    if (el) el.textContent = value ?? '';
                }

                function openPartoModal(data = {}) {
                    closeModal('calendar-event-modal');
                    setValue('calendar-parto-cerda', data.cerda_id || '');
                    setValue('calendar-parto-fecha', data.start || new Date().toISOString().slice(0, 10));
                    openModal('calendar-parto-modal');
                }

                function openInseminacionModal(data = {}) {
                    closeModal('calendar-event-modal');
                    setValue('calendar-inseminacion-cerda', data.cerda_id || '');
                    setValue('calendar-inseminacion-fecha', data.start || new Date().toISOString().slice(0, 10));
                    openModal('calendar-inseminacion-modal');
                }

                function openVacunacionModal(data = {}) {
                    closeModal('calendar-event-modal');
                    setValue('calendar-vacunacion-cerda', data.cerda_id || '');
                    setValue('calendar-vacunacion-fecha', data.start || new Date().toISOString().slice(0, 10));
                    openModal('calendar-vacunacion-modal');
                }

                window.openCalendarPartoModal = openPartoModal;
                window.openCalendarInseminacionModal = openInseminacionModal;
                window.openCalendarVacunacionModal = openVacunacionModal;

                window.showCalendarEventModal = function(eventData) {
                    const labels = {
                        parto: 'Parto próximo',
                        celo: 'Celo próximo',
                        vacuna: 'Vacunación próxima',
                        'parto-realizado': 'Parto registrado'
                    };

                    setText('calendar-event-chip', labels[eventData.tipo] || 'Evento');
                    setText('calendar-event-title', eventData.title || 'Evento');
                    setText('calendar-event-date', eventData.fecha_formateada ? `Fecha: ${eventData.fecha_formateada}` : '');
                    setText('calendar-event-cerda', `${eventData.cerda_codigo || ''}${eventData.cerda_nombre ? ' • ' + eventData.cerda_nombre : ''}`.trim());
                    setText('calendar-event-detail', eventData.detalle || '');

                    const actionBtn = document.getElementById('calendar-event-action-primary');
                    if (actionBtn) {
                        actionBtn.onclick = null;

                        if (eventData.accion === 'parto') {
                            actionBtn.style.display = 'inline-flex';
                            actionBtn.textContent = 'Registrar parto';
                            actionBtn.onclick = function() { openPartoModal(eventData); };
                        } else if (eventData.accion === 'inseminacion') {
                            actionBtn.style.display = 'inline-flex';
                            actionBtn.textContent = 'Registrar inseminación';
                            actionBtn.onclick = function() { openInseminacionModal(eventData); };
                        } else if (eventData.accion === 'vacuna') {
                            actionBtn.style.display = 'inline-flex';
                            actionBtn.textContent = 'Registrar vacunación';
                            actionBtn.onclick = function() { openVacunacionModal(eventData); };
                        } else {
                            actionBtn.style.display = 'none';
                        }
                    }

                    openModal('calendar-event-modal');
                };

                const calendar = new FullCalendar.Calendar(calendarEl, {
                    locale: 'es',
                    initialView: 'dayGridMonth',
                    height: '100%',
                    expandRows: true,
                    fixedWeekCount: false,
                    dayMaxEventRows: 2,
                    stickyHeaderDates: true,
                    nowIndicator: true,
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
                        failure: function() {
                            console.error('Error al cargar eventos del calendario.');
                        }
                    },
                    eventClick: function(info) {
                        info.jsEvent.preventDefault();

                        const data = Object.assign({}, info.event.extendedProps, {
                            title: info.event.title,
                            start: info.event.startStr
                        });

                        showCalendarEventModal(data);
                    }
                });

                calendar.render();
            });
        </script>
    @endpush
</x-app-layout>
