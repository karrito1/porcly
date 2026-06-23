<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Panel de Control Porcícola') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('cerdas.create') }}" class="inline-flex items-center px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white text-xs font-semibold rounded-lg shadow-sm transition-colors duration-200">
                    Registrar Cerda
                </a>
                <a href="{{ route('inseminaciones.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 hover:bg-gray-950 text-white text-xs font-semibold rounded-lg shadow-sm transition-colors duration-200">
                    Registrar Inseminación
                </a>
                <form action="{{ route('reportes.mensual') }}" method="GET" class="inline-flex items-center gap-1">
                    <select name="mes" class="text-xs border border-gray-200 rounded-lg px-2 py-2 bg-white text-gray-700 shadow-sm focus:ring-brand-500 focus:border-brand-500">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" @selected($m == now()->month)>{{ now()->setMonth($m)->translatedFormat('F') }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="anio" value="{{ now()->year }}">
                    <button type="submit" class="inline-flex items-center px-3 py-2 bg-white hover:bg-gray-50 text-gray-700 text-xs font-semibold rounded-lg shadow-sm border border-gray-200 transition-colors duration-200">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        PDF
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    @push('styles')
    <style>
        .sparkline-container {
            min-height: 50px;
        }
        .main-chart-container {
            min-height: 350px;
        }
        @media (max-width: 768px) {
            .desktop-only { display: none !important; }
            .kpi-grid-mobile { grid-template-columns: repeat(2, 1fr) !important; }
            #calendario-link-mobile { display: inline-flex !important; }
        }
    </style>
    @endpush

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Bienvenida -->
            <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">¡Bienvenido al Sistema, {{ Auth::user()->name }}!</h1>
                    <p class="text-sm text-gray-500 mt-1">Monitoreo del hato porcícola, alertas productivas y estadísticas en tiempo real.</p>
                </div>
                <!-- Indicador de Tiempo Real -->
                <div class="flex items-center gap-2 bg-white px-3.5 py-2 border border-gray-200/80 rounded-xl shadow-sm">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-500 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-500"></span>
                    </span>
                    <span class="text-xs font-semibold text-gray-600">Conectado — Datos Actualizados</span>
                </div>
            </div>

            <!-- Grid de Tarjetas de Métricas (KPIs) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                
                <!-- Tarjeta 1: Cerdas Activas -->
                <div class="bg-white border border-gray-200/80 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm font-semibold text-gray-500">Cerdas Totales</span>
                            <div class="p-2 bg-brand-50 rounded-lg text-brand-500">
                                <svg class="w-5 h-5 text-[#f4b08a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-3xl font-bold text-gray-900 tracking-tight">{{ $totalCerdas }}</span>
                            <span class="text-xs font-semibold text-gray-500">cerdas registradas</span>
                        </div>
                    </div>
                    <div class="sparkline-container mt-4">
                        <div id="sparkline-cerdas"></div>
                    </div>
                </div>

                <!-- Tarjeta 2: Cerdas Gestantes -->
                <div class="bg-white border border-gray-200/80 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm font-semibold text-gray-500">Cerdas Gestantes</span>
                            <div class="p-2 bg-amber-50 rounded-lg text-amber-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-3xl font-bold text-gray-900 tracking-tight">{{ $cerdasGestantes }}</span>
                            <span class="text-xs font-semibold text-gray-500">activas en gestación</span>
                        </div>
                    </div>
                    <div class="sparkline-container mt-4">
                        <div id="sparkline-gestantes"></div>
                    </div>
                </div>

                <!-- Tarjeta 3: Partos del Mes -->
                <div class="bg-white border border-gray-200/80 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm font-semibold text-gray-500">Partos Registrados</span>
                            <div class="p-2 bg-emerald-50 rounded-lg text-emerald-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-3xl font-bold text-gray-900 tracking-tight">{{ $partosEsteMes }}</span>
                            <span class="text-xs font-semibold text-gray-500">partos este mes</span>
                        </div>
                    </div>
                    <div class="sparkline-container mt-4">
                        <div id="sparkline-partos"></div>
                    </div>
                </div>

                <!-- Tarjeta 4: Tasa de Supervivencia -->
                <div class="bg-white border border-gray-200/80 rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm font-semibold text-gray-500">Tasa Supervivencia Lechones</span>
                            <div class="p-2 bg-blue-50 rounded-lg text-blue-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex items-baseline gap-2">
                            <span class="text-3xl font-bold text-gray-900 tracking-tight">{{ $tasaSupervivencia }}%</span>
                            <span class="text-xs font-semibold text-gray-500">promedio anual</span>
                        </div>
                    </div>
                    <div class="sparkline-container mt-4">
                        <div id="sparkline-supervivencia"></div>
                    </div>
                </div>
            </div>

            <!-- Panel de Alertas Prioritarias (Gestión de alertas automáticas) -->
            <div id="alertas-panel" class="bg-white border border-gray-200/85 rounded-2xl shadow-sm p-6 mb-8">
                <h3 class="text-lg font-bold text-gray-950 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#f4b08a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    Alertas Críticas de Producción
                    <span class="ml-auto text-xs text-gray-400 font-normal" id="alertas-timestamp"></span>
                </h3>
                
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <!-- Próximos Partos -->
                    <div class="bg-emerald-50/40 border border-emerald-100 rounded-xl p-5 flex flex-col justify-between">
                        <div>
                            <h4 class="text-sm font-bold text-emerald-900 flex items-center justify-between mb-3">
                                <span>Próximos Partos (5 días)</span>
                                <span id="alertas-partos-count" class="text-xs font-semibold bg-emerald-100/80 px-2 py-0.5 rounded text-emerald-800">{{ $alertasPartos->count() }}</span>
                            </h4>
                            @if($alertasPartos->isEmpty())
                                <p class="text-xs text-gray-500 py-4">No hay partos estimados en los próximos días.</p>
                            @else
                                <ul class="space-y-3">
                                    @foreach($alertasPartos as $alerta)
                                        <li class="bg-white p-3 rounded-lg border border-emerald-100 shadow-sm flex justify-between items-center">
                                            <div>
                                                <div class="text-xs font-bold text-gray-800">Sow {{ $alerta->cerda->codigo }} ({{ $alerta->cerda->nombre ?? 'Sin nombre' }})</div>
                                                <div class="text-[11px] text-gray-500">Estimado: {{ $alerta->fecha_parto_estimada->format('d/m/Y') }}</div>
                                            </div>
                                            <div class="text-right">
                                                <span class="inline-block text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md mb-1.5">
                                                    @php
                                                        $diff = (int) now()->startOfDay()->diffInDays($alerta->fecha_parto_estimada->startOfDay(), false);
                                                    @endphp
                                                    @if($diff == 0)
                                                        Hoy
                                                    @elseif($diff == 1)
                                                        Mañana
                                                    @else
                                                        En {{ $diff }} días
                                                    @endif
                                                </span>
                                                <a href="{{ route('partos.create', ['cerda_id' => $alerta->cerda_id]) }}" class="block text-[11px] font-semibold text-emerald-600 hover:text-emerald-700 hover:underline">
                                                    Registrar Parto →
                                                </a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>

                    <!-- Retornos a Celo Próximos -->
                    <div class="bg-amber-50/40 border border-amber-100 rounded-xl p-5 flex flex-col justify-between" style="background-color: rgba(245, 158, 11, 0.05);">
                        <div>
                            <h4 class="text-sm font-bold text-amber-900 flex items-center justify-between mb-3">
                                <span>Estimación de Celos (3 días)</span>
                                <span id="alertas-celos-count" class="text-xs font-semibold bg-amber-100/80 px-2 py-0.5 rounded text-amber-800">{{ $alertasCelos->count() }}</span>
                            </h4>
                            @if($alertasCelos->isEmpty())
                                <p class="text-xs text-gray-500 py-4">No hay retornos a celo previstos para los siguientes días.</p>
                            @else
                                <ul class="space-y-3">
                                    @foreach($alertasCelos as $alerta)
                                        <li class="bg-white p-3 rounded-lg border border-amber-100 shadow-sm flex justify-between items-center">
                                            <div>
                                                <div class="text-xs font-bold text-gray-800">Sow {{ $alerta->cerda->codigo }} ({{ $alerta->cerda->nombre ?? 'Sin nombre' }})</div>
                                                <div class="text-[11px] text-gray-500">Estimado: {{ $alerta->fecha_proximo_celo->format('d/m/Y') }}</div>
                                            </div>
                                            <div class="text-right">
                                                <span class="inline-block text-[10px] font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-md mb-1.5">
                                                    @php
                                                        $diff = (int) now()->startOfDay()->diffInDays($alerta->fecha_proximo_celo->startOfDay(), false);
                                                    @endphp
                                                    @if($diff == 0)
                                                        Hoy
                                                    @elseif($diff == 1)
                                                        Mañana
                                                    @else
                                                        En {{ $diff }} días
                                                    @endif
                                                </span>
                                                <a href="{{ route('inseminaciones.create', ['cerda_id' => $alerta->cerda_id]) }}" class="block text-[11px] font-semibold text-amber-600 hover:text-amber-700 hover:underline">
                                                    Inseminar →
                                                </a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>

                    <!-- Vacunas Programadas -->
                    <div class="bg-blue-50/40 border border-blue-100 rounded-xl p-5 flex flex-col justify-between">
                        <div>
                            <h4 class="text-sm font-bold text-blue-900 flex items-center justify-between mb-3">
                                <span>Vacunas Programadas (7 días)</span>
                                <span id="alertas-vacunas-count" class="text-xs font-semibold bg-blue-100/80 px-2 py-0.5 rounded text-blue-800">{{ $alertasVacunas->count() }}</span>
                            </h4>
                            @if($alertasVacunas->isEmpty())
                                <p class="text-xs text-gray-500 py-4">No hay vacunas programadas en los próximos días.</p>
                            @else
                                <ul class="space-y-3">
                                    @foreach($alertasVacunas as $alerta)
                                        <li class="bg-white p-3 rounded-lg border border-blue-100 shadow-sm flex justify-between items-center">
                                            <div>
                                                <div class="text-xs font-bold text-gray-800">Sow {{ $alerta->cerda->codigo }}</div>
                                                <div class="text-[11px] text-gray-500 font-semibold">{{ $alerta->vacuna }}</div>
                                            </div>
                                            <div class="text-right">
                                                <span class="inline-block text-[10px] font-bold text-blue-700 bg-blue-50 px-2 py-0.5 rounded-md">
                                                    {{ $alerta->proxima_dosis->format('d/m/Y') }}
                                                </span>
                                                <a href="{{ route('cerdas.show', $alerta->cerda_id) }}#vacunas" class="block text-[11px] font-semibold text-blue-600 hover:text-blue-700 hover:underline mt-1">
                                                    Ver ficha →
                                                </a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

            <!-- Gráficas de Producción y Distribución del Hato -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Gráfica Principal: Lechones nacidos por mes -->
                <div class="bg-white border border-gray-200/80 rounded-2xl shadow-sm p-6 lg:col-span-2">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Producción de Camadas</h3>
                            <p class="text-xs text-gray-500 mt-0.5">Lechones nacidos vivos vs nacidos muertos en los últimos 12 meses.</p>
                        </div>
                    </div>
                    <div class="main-chart-container">
                        <div id="main-production-chart"></div>
                    </div>
                </div>

                <!-- Gráfica Secundaria: Estados del Hato -->
                <div class="bg-white border border-gray-200/80 rounded-2xl shadow-sm p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Composición del Hato</h3>
                            <p class="text-xs text-gray-500 mt-0.5">Distribución de las cerdas registradas según su estado productivo actual.</p>
                        </div>
                    </div>
                    <div class="flex flex-col justify-between h-[350px]">
                        <div id="herd-status-pie-chart" class="flex justify-center"></div>
                        <div class="border-t border-gray-100 pt-4 mt-2">
                            <div class="grid grid-cols-2 gap-2 text-xs font-semibold text-gray-600">
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span> Activas ({{ $estadosHato['activa'] ?? 0 }})
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-[#f4b08a]"></span> Gestantes ({{ $estadosHato['gestante'] ?? 0 }})
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-blue-400"></span> Lactantes ({{ $estadosHato['lactante'] ?? 0 }})
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-purple-400"></span> En celo ({{ $estadosHato['en_celo'] ?? 0 }})
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-gray-400 col-span-2"></span> Descarte ({{ $estadosHato['descarte'] ?? 0 }})
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actividad Reciente -->
            <div class="bg-white border border-gray-200/80 rounded-2xl shadow-sm p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Actividad Reciente</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Últimos eventos productivos y reproductivos registrados en la granja.</p>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 bg-gray-50/50">
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Evento</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Cerda</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Detalle</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Fecha</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($actividadReciente as $actividad)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-3">
                                            @if($actividad['tipo'] === 'parto')
                                                <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-xs">
                                                    P
                                                </div>
                                                <div>
                                                    <span class="text-sm font-bold text-gray-900">Parto Registrado</span>
                                                </div>
                                            @else
                                                <div class="w-8 h-8 rounded-full bg-[#f4b08a]/20 text-[#f4b08a] flex items-center justify-center font-bold text-xs">
                                                    I
                                                </div>
                                                <div>
                                                    <span class="text-sm font-bold text-gray-900">Inseminación</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-sm font-semibold text-gray-700">
                                        <a href="{{ route('cerdas.show', $actividad['cerda']->id) }}" class="hover:underline">
                                            Sow {{ $actividad['cerda']->codigo }}
                                        </a>
                                    </td>
                                    <td class="py-4 px-6 text-sm text-gray-600">
                                        {{ $actividad['detalle'] }}
                                    </td>
                                    <td class="py-4 px-6 text-sm text-gray-500">
                                        {{ $actividad['fecha']->format('d/m/Y') }}
                                    </td>
                                    <td class="py-4 px-6 text-right">
                                        <a href="{{ route('cerdas.show', $actividad['cerda']->id) }}" class="inline-flex items-center px-3 py-1 bg-gray-50 hover:bg-gray-100 text-[11px] font-semibold text-gray-700 border border-gray-200 rounded-lg shadow-sm transition-colors" title="Ver ficha">
                                            Ver Ficha
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-6 text-center text-sm text-gray-500">
                                        No hay actividades registradas aún.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        // Configuración de Colores de Marca
        const brandColor = '#f4b08a';
        const brandColorDark = '#e39a72';
        const brandColorMuted = '#ffe3d3';

        // Sparklines Options
        const sparklineCerdasOptions = {
            chart: { type: 'area', height: 50, sparkline: { enabled: true } },
            stroke: { curve: 'smooth', width: 2 },
            fill: { opacity: 0.3, colors: [brandColor] },
            series: [{ name: 'Cerdas', data: @json($sparklineCerdas) }],
            colors: [brandColor],
            tooltip: { fixed: { enabled: false }, x: { show: false }, y: { title: { formatter: () => 'Cerdas' } }, marker: { show: false } }
        };
        new ApexCharts(document.querySelector("#sparkline-cerdas"), sparklineCerdasOptions).render();

        const sparklineGestantesOptions = {
            chart: { type: 'area', height: 50, sparkline: { enabled: true } },
            stroke: { curve: 'smooth', width: 2 },
            fill: { opacity: 0.3, colors: ['#f59e0b'] },
            series: [{ name: 'Gestantes', data: @json($sparklineGestantes) }],
            colors: ['#f59e0b'],
            tooltip: { fixed: { enabled: false }, x: { show: false }, y: { title: { formatter: () => 'Gestantes' } }, marker: { show: false } }
        };
        new ApexCharts(document.querySelector("#sparkline-gestantes"), sparklineGestantesOptions).render();

        const sparklinePartosOptions = {
            chart: { type: 'area', height: 50, sparkline: { enabled: true } },
            stroke: { curve: 'smooth', width: 2 },
            fill: { opacity: 0.3, colors: ['#10b981'] },
            series: [{ name: 'Partos', data: @json($sparklinePartos) }],
            colors: ['#10b981'],
            tooltip: { fixed: { enabled: false }, x: { show: false }, y: { title: { formatter: () => 'Partos' } }, marker: { show: false } }
        };
        new ApexCharts(document.querySelector("#sparkline-partos"), sparklinePartosOptions).render();

        const sparklineSupervivenciaOptions = {
            chart: { type: 'area', height: 50, sparkline: { enabled: true } },
            stroke: { curve: 'smooth', width: 2 },
            fill: { opacity: 0.3, colors: ['#3b82f6'] },
            series: [{ name: 'Supervivencia %', data: @json($sparklineSupervivencia) }],
            colors: ['#3b82f6'],
            tooltip: { fixed: { enabled: false }, x: { show: false }, y: { title: { formatter: () => 'Tasa %' } }, marker: { show: false } }
        };
        new ApexCharts(document.querySelector("#sparkline-supervivencia"), sparklineSupervivenciaOptions).render();

        // Gráfica de Producción Mensual
        const prodData = @json($mesesProduccion);
        const categories = prodData.map(item => item.mes);
        const vivos = prodData.map(item => item.lechones_vivos);
        const muertos = prodData.map(item => item.lechones_muertos);

        const mainProductionOptions = {
            chart: {
                type: 'bar',
                height: 350,
                stacked: true,
                toolbar: { show: false },
                fontFamily: 'Inter, sans-serif'
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '40%',
                    borderRadius: 4
                },
            },
            stroke: {
                width: 0
            },
            series: [{
                name: 'Nacidos Vivos',
                data: vivos
            }, {
                name: 'Nacidos Muertos',
                data: muertos
            }],
            xaxis: {
                categories: categories,
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: { style: { colors: '#9ca3af', fontSize: '11px' } }
            },
            yaxis: {
                labels: { style: { colors: '#9ca3af', fontSize: '11px' } }
            },
            grid: {
                borderColor: '#f3f4f6',
                strokeDashArray: 4,
                xaxis: { lines: { show: false } },
                yaxis: { lines: { show: true } }
            },
            colors: ['#10b981', '#f87171'],
            dataLabels: { enabled: false },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                fontSize: '12px',
                fontFamily: 'Inter, sans-serif',
                markers: { radius: 12 }
            }
        };
        new ApexCharts(document.querySelector("#main-production-chart"), mainProductionOptions).render();

        // Herd Status Donut Chart
        const herdStatusData = @json($estadosHato);
        const statusLabels = ['Activas', 'Gestantes', 'Lactantes', 'En celo', 'Descarte'];
        const statusValues = [
            herdStatusData['activa'] || 0,
            herdStatusData['gestante'] || 0,
            herdStatusData['lactante'] || 0,
            herdStatusData['en_celo'] || 0,
            herdStatusData['descarte'] || 0
        ];

        const herdStatusOptions = {
            chart: {
                type: 'donut',
                height: 250,
                fontFamily: 'Inter, sans-serif'
            },
            series: statusValues,
            labels: statusLabels,
            colors: ['#34d399', '#f4b08a', '#60a5fa', '#c084fc', '#9ca3af'],
            legend: { show: false },
            dataLabels: { enabled: false },
            plotOptions: {
                pie: {
                    donut: {
                        size: '75%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Hato Total',
                                fontSize: '13px',
                                fontWeight: 600,
                                color: '#4b5563',
                                formatter: function (w) {
                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                }
                            }
                        }
                    }
                }
            }
        };
        new ApexCharts(document.querySelector("#herd-status-pie-chart"), herdStatusOptions).render();
    </script>
    @endpush

    @push('scripts')
    <script>
        (function() {
            function actualizarAlertas() {
                fetch('{{ route("dashboard.alertas.json") }}')
                    .then(function(r) { return r.json(); })
                    .then(function(data) {
                        var ts = document.getElementById('alertas-timestamp');
                        if (ts) ts.textContent = new Date().toLocaleTimeString('es-CO');

                        var pc = document.getElementById('alertas-partos-count');
                        if (pc) pc.textContent = data.total_partos;
                        var cc = document.getElementById('alertas-celos-count');
                        if (cc) cc.textContent = data.total_celos;
                        var vc = document.getElementById('alertas-vacunas-count');
                        if (vc) vc.textContent = data.total_vacunas;

                        function limpiarLista(id) {
                            var el = document.getElementById(id);
                            if (el) el.innerHTML = '';
                            return el;
                        }

                        var pl = limpiarLista('alertas-partos-list');
                        if (pl && data.partos.length > 0) {
                            data.partos.forEach(function(a) {
                                var dias = a.dias_restantes;
                                var texto = dias === 0 ? 'Hoy' : dias === 1 ? 'Mañana' : 'En ' + dias + ' d\u00edas';
                                pl.innerHTML += '<li class="bg-white p-3 rounded-lg border border-emerald-100 shadow-sm flex justify-between items-center">' +
                                    '<div><div class="text-xs font-bold text-gray-800">Sow ' + a.cerda_codigo + ' (' + (a.cerda_nombre || 'Sin nombre') + ')</div>' +
                                    '<div class="text-[11px] text-gray-500">Estimado: ' + a.fecha_estimada + '</div></div>' +
                                    '<div class="text-right"><span class="inline-block text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md mb-1.5">' + texto + '</span>' +
                                    '<a href="/partos/crear?cerda_id=' + a.cerda_id + '" class="block text-[11px] font-semibold text-emerald-600 hover:text-emerald-700 hover:underline">Registrar Parto \u2192</a></div></li>';
                            });
                        } else if (pl) {
                            pl.innerHTML = '<li class="text-xs text-gray-500 py-4 text-center">No hay partos estimados en los pr\u00f3ximos d\u00edas.</li>';
                        }

                        var cl = limpiarLista('alertas-celos-list');
                        if (cl && data.celos.length > 0) {
                            data.celos.forEach(function(a) {
                                var dias = a.dias_restantes;
                                var texto = dias === 0 ? 'Hoy' : dias === 1 ? 'Mañana' : 'En ' + dias + ' d\u00edas';
                                cl.innerHTML += '<li class="bg-white p-3 rounded-lg border border-amber-100 shadow-sm flex justify-between items-center">' +
                                    '<div><div class="text-xs font-bold text-gray-800">Sow ' + a.cerda_codigo + ' (' + (a.cerda_nombre || 'Sin nombre') + ')</div>' +
                                    '<div class="text-[11px] text-gray-500">Estimado: ' + a.fecha_estimada + '</div></div>' +
                                    '<div class="text-right"><span class="inline-block text-[10px] font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-md mb-1.5">' + texto + '</span>' +
                                    '<a href="/inseminaciones/crear?cerda_id=' + a.cerda_id + '" class="block text-[11px] font-semibold text-amber-600 hover:text-amber-700 hover:underline">Inseminar \u2192</a></div></li>';
                            });
                        } else if (cl) {
                            cl.innerHTML = '<li class="text-xs text-gray-500 py-4 text-center">No hay retornos a celo previstos para los siguientes d\u00edas.</li>';
                        }

                        var vl = limpiarLista('alertas-vacunas-list');
                        if (vl && data.vacunas.length > 0) {
                            data.vacunas.forEach(function(a) {
                                vl.innerHTML += '<li class="bg-white p-3 rounded-lg border border-blue-100 shadow-sm flex justify-between items-center">' +
                                    '<div><div class="text-xs font-bold text-gray-800">Sow ' + a.cerda_codigo + '</div>' +
                                    '<div class="text-[11px] text-gray-500 font-semibold">' + a.vacuna + '</div></div>' +
                                    '<div class="text-right"><span class="inline-block text-[10px] font-bold text-blue-700 bg-blue-50 px-2 py-0.5 rounded-md">' + a.proxima_dosis + '</span>' +
                                    '<a href="/cerdas/' + a.cerda_id + '#vacunas" class="block text-[11px] font-semibold text-blue-600 hover:text-blue-700 hover:underline mt-1">Ver ficha \u2192</a></div></li>';
                            });
                        } else if (vl) {
                            vl.innerHTML = '<li class="text-xs text-gray-500 py-4 text-center">No hay vacunas programadas en los pr\u00f3ximos d\u00edas.</li>';
                        }
                    })
                    .catch(function() {});
            }

            actualizarAlertas();
            setInterval(actualizarAlertas, 30000);
        })();
    </script>
    @endpush
</x-app-layout>
