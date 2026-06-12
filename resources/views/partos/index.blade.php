<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Control de Partos') }}
            </h2>
            <a href="{{ route('partos.create') }}" class="inline-flex items-center px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white text-xs font-semibold rounded-lg shadow-sm transition-colors duration-200">
                Registrar Parto
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Buscador -->
            <div class="bg-white border border-gray-200/80 rounded-2xl shadow-sm p-6 mb-6">
                <form action="{{ route('partos.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <!-- Búsqueda -->
                    <div class="md:col-span-3">
                        <label for="buscar" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Buscar por código de cerda</label>
                        <input type="text" name="buscar" id="buscar" value="{{ request('buscar') }}" placeholder="Código de la cerda madre (ej. C-001)..." class="w-full text-sm rounded-lg border-gray-300 focus:border-brand-500 focus:ring focus:ring-brand-200 focus:ring-opacity-50">
                    </div>

                    <!-- Botón de Acción -->
                    <div>
                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2.5 bg-gray-800 hover:bg-gray-900 text-white text-xs font-bold rounded-lg shadow-sm transition-colors duration-150">
                            Filtrar
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tabla de Partos -->
            <div class="bg-white border border-gray-200/80 rounded-2xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 bg-gray-50/50">
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Madre</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Fecha Parto</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Vivos</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Muertos</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Momias</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Total Camada</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Peso Camada</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Observaciones</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($partos as $parto)
                                <tr class="hover:bg-gray-50/40 transition-colors">
                                    <td class="py-4 px-6">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-gray-900">{{ $parto->cerda->codigo }}</span>
                                            <span class="text-xs text-gray-400">{{ $parto->cerda->nombre ?? 'Sin nombre' }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-sm text-gray-700 font-medium">
                                        {{ $parto->fecha_parto->format('d/m/Y') }}
                                    </td>
                                    <td class="py-4 px-6 text-sm text-center font-bold text-emerald-600 bg-emerald-50/20">
                                        {{ $parto->lechones_vivos }}
                                    </td>
                                    <td class="py-4 px-6 text-sm text-center font-semibold text-rose-600 bg-rose-50/10">
                                        {{ $parto->lechones_muertos }}
                                    </td>
                                    <td class="py-4 px-6 text-sm text-center text-amber-700 font-semibold bg-amber-50/10">
                                        {{ $parto->lechones_momificados }}
                                    </td>
                                    <td class="py-4 px-6 text-sm text-center font-bold text-gray-800">
                                        {{ $parto->totalLechones() }}
                                    </td>
                                    <td class="py-4 px-6 text-sm text-center font-semibold text-gray-700">
                                        @if($parto->peso_camada)
                                            {{ number_format($parto->peso_camada, 1) }} kg
                                            <div class="text-[10px] text-gray-400 font-normal">
                                                Prom: {{ number_format($parto->peso_camada / max($parto->lechones_vivos, 1), 2) }} kg
                                            </div>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-xs text-gray-500 max-w-xs truncate">
                                        {{ $parto->observaciones ?? 'N/A' }}
                                    </td>
                                    <td class="py-4 px-6 text-right text-sm">
                                        <a href="{{ route('cerdas.show', $parto->cerda_id) }}" class="inline-flex items-center px-3 py-1 bg-white hover:bg-gray-50 text-gray-700 text-xs font-semibold border border-gray-200 rounded-lg transition-colors shadow-sm">
                                            Ver Ficha Cerda
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="py-12 text-center text-sm text-gray-500">
                                        No se encontraron registros de partos.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($partos->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $partos->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
