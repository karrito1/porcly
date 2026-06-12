<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Registrar Parto') }}
            </h2>
            <a href="{{ route('partos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-750 text-xs font-bold rounded-lg border border-gray-200 shadow-sm transition-colors duration-150">
                Volver a la Lista
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-white border border-gray-200/80 rounded-2xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-base font-bold text-gray-800">
                        Detalles del Parto
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">
                        Ingrese los resultados del parto. Al guardarse, se crearán de manera automática los registros de lechones individuales para su posterior seguimiento, se incrementará el número de partos históricos de la cerda y se actualizará su estado a "Lactante".
                    </p>
                </div>

                <form action="{{ route('partos.store') }}" method="POST" class="p-6 space-y-6">
                    @csrf

                    <!-- Cerda Gestante -->
                    <div>
                        <label for="cerda_id" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Seleccionar Madre (Cerda Gestante)</label>
                        <select name="cerda_id" id="cerda_id" required class="w-full text-sm rounded-lg border-gray-250 focus:border-brand-500 focus:ring focus:ring-brand-200 focus:ring-opacity-50">
                            <option value="">-- Seleccionar Cerda --</option>
                            @foreach($cerdas as $cerda)
                                <option value="{{ $cerda->id }}" {{ (old('cerda_id') == $cerda->id || $selected_cerda_id == $cerda->id) ? 'selected' : '' }}>
                                    {{ $cerda->codigo }} - {{ $cerda->nombre ?? 'Sin Nombre' }}
                                </option>
                            @endforeach
                        </select>
                        @error('cerda_id')
                            <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                        @if($cerdas->isEmpty())
                            <p class="text-xs text-amber-600 mt-2 font-medium bg-amber-50 border border-amber-200 rounded-lg p-3">
                                No hay cerdas actualmente en estado "Gestante". 
                                <a href="{{ route('inseminaciones.create') }}" class="underline font-bold">Registrar e inseminar una cerda</a> primero.
                            </p>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Fecha de Parto -->
                        <div>
                            <label for="fecha_parto" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Fecha del Parto</label>
                            <input type="date" name="fecha_parto" id="fecha_parto" value="{{ old('fecha_parto', date('Y-m-d')) }}" required class="w-full text-sm rounded-lg border-gray-250 focus:border-brand-500 focus:ring focus:ring-brand-200 focus:ring-opacity-50">
                            @error('fecha_parto')
                                <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Peso Total de la Camada -->
                        <div>
                            <label for="peso_camada" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Peso Total Camada (kg)</label>
                            <input type="number" name="peso_camada" id="peso_camada" step="0.01" min="0" value="{{ old('peso_camada') }}" placeholder="Opcional (ej. 15.5)" class="w-full text-sm rounded-lg border-gray-250 focus:border-brand-500 focus:ring focus:ring-brand-200 focus:ring-opacity-50">
                            @error('peso_camada')
                                <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Distribución de Lechones Nacidos -->
                    <div class="bg-gray-50/50 p-4 border border-gray-200 rounded-xl">
                        <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-4">Recuento de Camada</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Lechones Vivos -->
                            <div>
                                <label for="lechones_vivos" class="block text-xs font-bold text-emerald-700 mb-2">Nacidos Vivos</label>
                                <input type="number" name="lechones_vivos" id="lechones_vivos" min="0" value="{{ old('lechones_vivos', 0) }}" required class="w-full text-sm rounded-lg border-gray-250 focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50">
                                @error('lechones_vivos')
                                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Lechones Muertos -->
                            <div>
                                <label for="lechones_muertos" class="block text-xs font-bold text-rose-700 mb-2">Nacidos Muertos</label>
                                <input type="number" name="lechones_muertos" id="lechones_muertos" min="0" value="{{ old('lechones_muertos', 0) }}" required class="w-full text-sm rounded-lg border-gray-250 focus:border-rose-500 focus:ring focus:ring-rose-200 focus:ring-opacity-50">
                                @error('lechones_muertos')
                                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Lechones Momificados -->
                            <div>
                                <label for="lechones_momificados" class="block text-xs font-bold text-amber-800 mb-2">Momificados</label>
                                <input type="number" name="lechones_momificados" id="lechones_momificados" min="0" value="{{ old('lechones_momificados', 0) }}" required class="w-full text-sm rounded-lg border-gray-250 focus:border-amber-500 focus:ring focus:ring-amber-200 focus:ring-opacity-50">
                                @error('lechones_momificados')
                                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Observaciones -->
                    <div>
                        <label for="observaciones" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Observaciones / Detalles</label>
                        <textarea name="observaciones" id="observaciones" rows="4" placeholder="Registrar detalles adicionales (complicaciones del parto, asistencia veterinaria, condiciones de la jaula de maternidad, etc.)..." class="w-full text-sm rounded-lg border-gray-250 focus:border-brand-500 focus:ring focus:ring-brand-200 focus:ring-opacity-50">{{ old('observaciones') }}</textarea>
                        @error('observaciones')
                            <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Botón Enviar -->
                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('partos.index') }}" class="px-4 py-2 text-sm font-semibold text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                            Cancelar
                        </a>
                        <button type="submit" class="px-5 py-2 text-sm font-bold text-white rounded-lg hover:bg-brand-650 shadow-sm transition-colors" style="background-color: #f4b08a;">
                            Registrar Parto
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</x-app-layout>
