<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Panel de control</h2>
                <p class="text-sm text-gray-500 mt-1">Granja Porcly · {{ now()->translatedFormat('l, d F Y') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="#" class="relative inline-flex items-center px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm text-gray-600 hover:bg-gray-50">
                    🔔 Alertas
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">5</span>
                </a>
            </div>

        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- MÉTRICAS --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Total cerdas</p>
                    <p class="text-3xl font-semibold text-gray-800">48</p>
                    <p class="text-xs text-green-600 mt-2">+3 este mes</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">En gestación</p>
                    <p class="text-3xl font-semibold text-blue-600">21</p>
                    <p class="text-xs text-gray-400 mt-2">43% del total</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Alertas activas</p>
                    <p class="text-3xl font-semibold text-red-500">5</p>
                    <p class="text-xs text-red-400 mt-2">3 partos próximos</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Lechones este mes</p>
                    <p class="text-3xl font-semibold text-gray-800">134</p>
                    <p class="text-xs text-amber-500 mt-2">Mortalidad 4%</p>
                </div>
            </div>

            {{-- GRÁFICA + ESTADO DEL HATO --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-gray-700">Producción mensual</h3>
                        <a href="#" class="text-xs text-green-600 hover:underline">Ver reporte →</a>
                    </div>
                    <div id="chart-produccion"></div>
                </div>
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                    <h3 class="text-sm font-semibold text-gray-700 mb-4">Estado del hato</h3>
                    <div id="chart-hato"></div>
                    <div class="mt-3 space-y-2">
                        <div class="flex items-center justify-between text-xs text-gray-600">
                            <span class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span>Gestante</span>
                            <span class="font-medium">21</span>
                        </div>
                        <div class="flex items-center justify-between text-xs text-gray-600">
                            <span class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-blue-400 inline-block"></span>Lactante</span>
                            <span class="font-medium">12</span>
                        </div>
                        <div class="flex items-center justify-between text-xs text-gray-600">
                            <span class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-amber-400 inline-block"></span>En celo</span>
                            <span class="font-medium">6</span>
                        </div>
                        <div class="flex items-center justify-between text-xs text-gray-600">
                            <span class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-gray-300 inline-block"></span>Vacía</span>
                            <span class="font-medium">9</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ALERTAS + CERDAS RECIENTES --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                {{-- Alertas --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-gray-700">Alertas activas</h3>
                        <a href="#" class="text-xs text-green-600 hover:underline">Ver todas →</a>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3 pb-3 border-b border-gray-50">
                            <span class="bg-red-100 text-red-600 rounded-lg p-2 text-sm">🍼</span>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-800">Parto próximo — Cerda #14</p>
                                <p class="text-xs text-gray-400">Estimado para mañana · 114 días</p>
                            </div>
                            <button class="text-xs px-3 py-1 rounded-full border border-gray-200 text-gray-500 hover:bg-gray-50">Atender</button>
                        </div>
                        <div class="flex items-start gap-3 pb-3 border-b border-gray-50">
                            <span class="bg-red-100 text-red-600 rounded-lg p-2 text-sm">🍼</span>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-800">Parto próximo — Cerda #27</p>
                                <p class="text-xs text-gray-400">Estimado en 3 días · 111 días</p>
                            </div>
                            <button class="text-xs px-3 py-1 rounded-full border border-gray-200 text-gray-500 hover:bg-gray-50">Atender</button>
                        </div>
                        <div class="flex items-start gap-3 pb-3 border-b border-gray-50">
                            <span class="bg-amber-100 text-amber-600 rounded-lg p-2 text-sm">🌀</span>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-800">Celo esperado — Cerda #33</p>
                                <p class="text-xs text-gray-400">21 días desde último celo</p>
                            </div>
                            <button class="text-xs px-3 py-1 rounded-full border border-gray-200 text-gray-500 hover:bg-gray-50">Atender</button>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="bg-green-100 text-green-600 rounded-lg p-2 text-sm">✅</span>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-800">Parto atendido — Cerda #09</p>
                                <p class="text-xs text-gray-400">12 lechones · 1 mortinato</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Cerdas recientes --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-gray-700">Cerdas recientes</h3>
                        <a href="#" class="text-xs text-green-600 hover:underline">Ver todas →</a>
                    </div>
                    <div class="space-y-3">
                        @foreach([
                        ['id'=>'14','estado'=>'Gestante','sub'=>'Parto est. 27/05','color'=>'bg-blue-100 text-blue-700'],
                        ['id'=>'27','estado'=>'Gestante','sub'=>'Parto est. 29/05','color'=>'bg-blue-100 text-blue-700'],
                        ['id'=>'09','estado'=>'Lactante','sub'=>'Parto hace 1 día · 12 lechones','color'=>'bg-green-100 text-green-700'],
                        ['id'=>'33','estado'=>'En celo','sub'=>'Celo esperado hoy','color'=>'bg-amber-100 text-amber-700'],
                        ['id'=>'41','estado'=>'Vacía','sub'=>'Sin eventos recientes','color'=>'bg-gray-100 text-gray-600'],
                        ] as $cerda)
                        <div class="flex items-center gap-3 pb-3 border-b border-gray-50 last:border-0 last:pb-0">
                            <div class="w-9 h-9 rounded-lg bg-green-50 border border-green-100 flex items-center justify-center text-xs font-semibold text-green-700">#{{ $cerda['id'] }}</div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-800">Cerda {{ $cerda['id'] }}</p>
                                <p class="text-xs text-gray-400">{{ $cerda['sub'] }}</p>
                            </div>
                            <span class="text-xs px-2 py-1 rounded-full font-medium {{ $cerda['color'] }}">{{ $cerda['estado'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ApexCharts --}}
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    @vite('resources/js/dashboard.js')

    @endpush
</x-app-layout>