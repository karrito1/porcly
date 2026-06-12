<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Gestión de Inseminaciones') }}
            </h2>
            <a href="{{ route('inseminaciones.create') }}" class="inline-flex items-center px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white text-xs font-semibold rounded-lg shadow-sm transition-colors duration-200">
                Registrar Inseminación
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Buscador y Filtros -->
            <div class="bg-white border border-gray-200/80 rounded-2xl shadow-sm p-6 mb-6">
                <!-- Toggle: Activas / Historial Completo -->
                <div class="flex items-center gap-3 mb-5 pb-4 border-b border-gray-100">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Mostrar:</span>
                    <a href="{{ route('inseminaciones.index', array_merge(request()->query(), ['scope' => 'activas'])) }}"
                        class="px-4 py-1.5 text-xs font-bold rounded-full transition-colors duration-150
                        {{ $scope === 'activas' ? 'bg-brand-500 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Inseminaciones Activas
                    </a>
                    <a href="{{ route('inseminaciones.index', array_merge(request()->query(), ['scope' => 'todas'])) }}"
                        class="px-4 py-1.5 text-xs font-bold rounded-full transition-colors duration-150
                        {{ $scope === 'todas' ? 'bg-brand-500 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Historial Completo
                    </a>
                </div>
                <form action="{{ route('inseminaciones.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <input type="hidden" name="scope" value="{{ $scope }}">
                    <!-- Búsqueda -->
                    <div class="md:col-span-2">
                        <label for="buscar" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Buscar por código de cerda</label>
                        <input type="text" name="buscar" id="buscar" value="{{ request('buscar') }}" placeholder="Código de la cerda (ej. C-001)..." class="w-full text-sm rounded-lg border-gray-300 focus:border-brand-500 focus:ring focus:ring-brand-200 focus:ring-opacity-50">
                    </div>
                    
                    <!-- Resultado -->
                    <div>
                        <label for="resultado" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Resultado / Diagnóstico</label>
                        <select name="resultado" id="resultado" class="w-full text-sm rounded-lg border-gray-300 focus:border-brand-500 focus:ring focus:ring-brand-200 focus:ring-opacity-50">
                            <option value="">Todos</option>
                            <option value="pendiente" {{ request('resultado') === 'pendiente' ? 'selected' : '' }}>Pendiente de Confirmación</option>
                            <option value="exitosa" {{ request('resultado') === 'exitosa' ? 'selected' : '' }}>Gestación Confirmada</option>
                            <option value="fallida" {{ request('resultado') === 'fallida' ? 'selected' : '' }}>Gestación Fallida</option>
                        </select>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="flex gap-2">
                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2.5 bg-gray-800 hover:bg-gray-900 text-white text-xs font-bold rounded-lg shadow-sm transition-colors duration-150">
                            Filtrar
                        </button>
                        @if(request()->anyFilled(['buscar', 'resultado']))
                            <a href="{{ route('inseminaciones.index') }}" class="w-full inline-flex justify-center items-center px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-lg border border-gray-200 shadow-sm transition-colors duration-150">
                                Limpiar
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Tabla de Inseminaciones -->
            <div class="bg-white border border-gray-200/80 rounded-2xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 bg-gray-50/50">
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Cerda</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Fecha Inseminación</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Tipo</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Verraco</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider">Fecha Parto Estimada</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Estado Gestación</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($inseminaciones as $inseminacion)
                                <tr class="hover:bg-gray-50/40 transition-colors" x-data="{ showConfirmModal: false }">
                                    <td class="py-4 px-6">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-gray-900">{{ $inseminacion->cerda->codigo }}</span>
                                            <span class="text-xs text-gray-400">{{ $inseminacion->cerda->nombre ?? 'Sin nombre' }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-sm text-gray-700">
                                        {{ $inseminacion->fecha_inseminacion->format('d/m/Y') }}
                                    </td>
                                    <td class="py-4 px-6 text-sm text-gray-600 capitalize">
                                        {{ $inseminacion->tipo }}
                                    </td>
                                    <td class="py-4 px-6 text-sm text-gray-700">
                                        {{ $inseminacion->verraco ?? 'N/A' }}
                                    </td>
                                    <td class="py-4 px-6 text-sm text-gray-600">
                                        <div>{{ $inseminacion->fecha_parto_estimada->format('d/m/Y') }}</div>
                                        @if(is_null($inseminacion->exitosa))
                                            <div class="text-xs text-brand-500 font-medium">
                                                Estimado en {{ (int) now()->diffInDays($inseminacion->fecha_parto_estimada, false) }} días
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        @if($inseminacion->exitosa === true)
                                            <span class="inline-flex items-center text-xs font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-200">
                                                Exitosa / Gestante
                                            </span>
                                        @elseif($inseminacion->exitosa === false)
                                            <span class="inline-flex items-center text-xs font-bold text-rose-700 bg-rose-50 px-2.5 py-1 rounded-full border border-rose-200">
                                                Fallida / Repite Celo
                                            </span>
                                        @else
                                            <span class="inline-flex items-center text-xs font-bold text-amber-700 bg-amber-50 px-2.5 py-1 rounded-full border border-amber-200">
                                                Pendiente Diagnóstico
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-right text-sm">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('cerdas.show', $inseminacion->cerda_id) }}" class="inline-flex items-center px-3 py-1 bg-white hover:bg-gray-50 text-gray-700 text-xs font-semibold border border-gray-200 rounded-lg transition-colors shadow-sm">
                                                Ver Ficha Cerda
                                            </a>
                                            @if(is_null($inseminacion->exitosa))
                                                <button @click="showConfirmModal = true" class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-lg transition-colors shadow-sm" style="background-color: #fee2e2; border: 1px solid #fca5a5; color: #b91c1c;">
                                                    Confirmar Gestación
                                                </button>
                                            @endif
                                        </div>

                                        <!-- Modal de Confirmación de Inseminación -->
                                        <div x-show="showConfirmModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-transition>
                                            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                                                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="showConfirmModal = false"></div>
                                                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                                                
                                                <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100">
                                                    <div class="bg-white px-6 pt-6 pb-4 sm:p-6 sm:pb-4">
                                                        <div class="sm:flex sm:items-start">
                                                            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                                                <h3 class="text-lg font-bold leading-6 text-gray-900 border-b border-gray-100 pb-3">
                                                                    Confirmar Diagnóstico de Gestación
                                                                </h3>
                                                                <div class="mt-4">
                                                                    <form action="{{ route('inseminaciones.confirm', $inseminacion->id) }}" method="POST" class="space-y-4 text-left">
                                                                        @csrf
                                                                        <div>
                                                                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Resultado</label>
                                                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                                                <label class="flex items-center justify-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-emerald-50/20 focus-within:ring-2 focus-within:ring-emerald-500">
                                                                                    <input type="radio" name="exitosa" value="1" required class="text-emerald-500 focus:ring-emerald-500 mr-2 border-gray-300">
                                                                                    <span class="text-sm font-semibold text-emerald-700">Exitosa (Gestante)</span>
                                                                                </label>
                                                                                <label class="flex items-center justify-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-rose-50/20 focus-within:ring-2 focus-within:ring-rose-500">
                                                                                    <input type="radio" name="exitosa" value="0" required class="text-rose-500 focus:ring-rose-500 mr-2 border-gray-300">
                                                                                    <span class="text-sm font-semibold text-rose-700">Fallida (En Celo)</span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div>
                                                                            <label for="notas" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Observaciones</label>
                                                                            <textarea name="notas" id="notas" rows="3" placeholder="Detalles sobre el diagnóstico (ej. Ecografía realizada, celo recurrente...)" class="w-full text-sm rounded-lg border-gray-300 focus:border-brand-500 focus:ring focus:ring-brand-200 focus:ring-opacity-50"></textarea>
                                                                        </div>
                                                                        <div class="flex justify-end gap-3 pt-3 border-t border-gray-100">
                                                                            <button type="button" @click="showConfirmModal = false" class="px-4 py-2 text-xs font-semibold text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                                                                Cancelar
                                                                            </button>
                                                                            <button type="submit" class="px-4 py-2 text-xs font-bold text-white rounded-lg transition-colors" style="background-color: #f4b08a;">
                                                                                Guardar Diagnóstico
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-12 text-center text-sm text-gray-500">
                                        No se encontraron registros de inseminaciones.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($inseminaciones->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $inseminaciones->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
