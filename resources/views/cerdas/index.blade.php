<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Gestión del Hato — Cerdas') }}
            </h2>
            <a href="{{ route('cerdas.create') }}" class="inline-flex items-center px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white text-xs font-semibold rounded-lg shadow-sm transition-colors duration-200">
                Registrar Nueva Cerda
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Buscador y Filtros -->
            <div class="bg-white border border-gray-200/80 rounded-2xl shadow-sm p-6 mb-6">
                <form action="{{ route('cerdas.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <!-- Búsqueda -->
                    <div class="md:col-span-2">
                        <label for="buscar" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Buscar cerda</label>
                        <input type="text" name="buscar" id="buscar" value="{{ request('buscar') }}" placeholder="Código (C-001) o Nombre..." class="w-full text-sm rounded-lg border-gray-300 focus:border-brand-500 focus:ring focus:ring-brand-200 focus:ring-opacity-50">
                    </div>
                    
                    <!-- Estado -->
                    <div>
                        <label for="estado" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Estado</label>
                        <select name="estado" id="estado" class="w-full text-sm rounded-lg border-gray-300 focus:border-brand-500 focus:ring focus:ring-brand-200 focus:ring-opacity-50">
                            <option value="">Todos los estados</option>
                            <option value="activa" {{ request('estado') === 'activa' ? 'selected' : '' }}>Activa</option>
                            <option value="gestante" {{ request('estado') === 'gestante' ? 'selected' : '' }}>Gestante</option>
                            <option value="lactante" {{ request('estado') === 'lactante' ? 'selected' : '' }}>Lactante</option>
                            <option value="en_celo" {{ request('estado') === 'en_celo' ? 'selected' : '' }}>En Celo</option>
                            <option value="descarte" {{ request('estado') === 'descarte' ? 'selected' : '' }}>Descarte</option>
                        </select>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="flex gap-2">
                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2.5 bg-gray-800 hover:bg-gray-900 text-white text-xs font-bold rounded-lg shadow-sm transition-colors duration-150">
                            Filtrar
                        </button>
                        @if(request()->anyFilled(['buscar', 'estado', 'raza']))
                            <a href="{{ route('cerdas.index') }}" class="w-full inline-flex justify-center items-center px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-lg border border-gray-200 shadow-sm transition-colors duration-150">
                                Limpiar
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Tabla de Cerdas -->
            <div class="bg-white border border-gray-200/80 rounded-2xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 bg-gray-50/50">
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Código</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Nombre</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Raza</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Edad (Meses)</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Peso Actual</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Partos</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Estado</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($cerdas as $cerda)
                                <tr class="hover:bg-gray-50/40 transition-colors">
                                    <td class="py-4 px-6 font-bold text-gray-900">
                                        {{ $cerda->codigo }}
                                    </td>
                                    <td class="py-4 px-6 text-sm text-gray-700">
                                        {{ $cerda->nombre ?? 'N/A' }}
                                    </td>
                                    <td class="py-4 px-6 text-sm text-gray-600">
                                        {{ $cerda->raza ?? 'N/A' }}
                                    </td>
                                    <td class="py-4 px-6 text-sm text-gray-500">
                                        @if($cerda->fecha_nacimiento)
                                            {{ (int) now()->diffInMonths($cerda->fecha_nacimiento) }} m
                                            <span class="text-xs text-gray-400">({{ $cerda->fecha_nacimiento->format('d/m/Y') }})</span>
                                        @else
                                            No registrada
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-sm font-semibold text-gray-700">
                                        {{ $cerda->peso_actual ? number_format($cerda->peso_actual, 1) . ' kg' : 'N/A' }}
                                    </td>
                                    <td class="py-4 px-6 text-sm text-gray-900 text-center font-bold">
                                        {{ $cerda->numero_partos }}
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        @if($cerda->estado === 'activa')
                                            <span class="inline-flex items-center text-xs font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full">
                                                Activa
                                            </span>
                                        @elseif($cerda->estado === 'gestante')
                                            <span class="inline-flex items-center text-xs font-bold text-amber-700 bg-amber-50 px-2.5 py-1 rounded-full" style="color: #d97706; background-color: #fef3c7;">
                                                Gestante
                                            </span>
                                        @elseif($cerda->estado === 'lactante')
                                            <span class="inline-flex items-center text-xs font-bold text-blue-700 bg-blue-50 px-2.5 py-1 rounded-full">
                                                Lactante
                                            </span>
                                        @elseif($cerda->estado === 'en_celo')
                                            <span class="inline-flex items-center text-xs font-bold text-purple-700 bg-purple-50 px-2.5 py-1 rounded-full">
                                                En Celo
                                            </span>
                                        @else
                                            <span class="inline-flex items-center text-xs font-bold text-gray-700 bg-gray-100 px-2.5 py-1 rounded-full">
                                                Descarte
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-right text-sm">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('cerdas.show', $cerda->id) }}" class="inline-flex items-center px-3 py-1 bg-gray-50 hover:bg-gray-100 text-gray-700 text-xs font-semibold border border-gray-200 rounded-lg transition-colors shadow-sm">
                                                Ficha
                                            </a>
                                            <a href="{{ route('cerdas.edit', $cerda->id) }}" class="inline-flex items-center px-3 py-1 bg-white hover:bg-gray-50 text-gray-600 text-xs font-semibold border border-gray-200 rounded-lg transition-colors shadow-sm">
                                                Editar
                                            </a>
                                            <form action="{{ route('cerdas.destroy', $cerda->id) }}" method="POST" onsubmit="return confirm('¿Está seguro de eliminar esta cerda del sistema? Se perderá todo su historial.')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-1 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-semibold border border-rose-200 rounded-lg transition-colors shadow-sm">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="py-12 text-center text-sm text-gray-500">
                                        No se encontraron cerdas que coincidan con los filtros de búsqueda.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($cerdas->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $cerdas->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
