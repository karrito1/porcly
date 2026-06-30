<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Registrar Inseminación') }}
            </h2>
            <a href="{{ route('inseminaciones.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-lg border border-gray-200 shadow-sm transition-colors duration-150">
                Volver a la Lista
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-white border border-gray-200/80 rounded-2xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-base font-bold text-gray-800">
                        Información del Evento de Reproducción
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">
                        Complete los datos de la inseminación. Al guardarse, se calculará automáticamente la fecha estimada de parto (+115 días) y el próximo celo (+21 días).
                    </p>
                </div>

                <form action="{{ route('inseminaciones.store') }}" method="POST" class="p-6 space-y-6">
                    @csrf

                    <!-- Cerda -->
                    <div>
                        <label for="cerda_id" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Seleccionar Cerda</label>
                        <select name="cerda_id" id="cerda_id" required class="w-full text-sm rounded-lg border-gray-300 focus:border-brand-500 focus:ring focus:ring-brand-200 focus:ring-opacity-50">
                            <option value="">-- Seleccionar Cerda por Código --</option>
                            @foreach($cerdas as $cerda)
                                <option value="{{ $cerda->id }}" {{ (old('cerda_id') == $cerda->id || $selected_cerda_id == $cerda->id) ? 'selected' : '' }}>
                                    {{ $cerda->codigo }} - {{ $cerda->nombre ?? 'Sin Nombre' }} (Raza: {{ $cerda->raza ?? 'N/D' }})
                                </option>
                            @endforeach
                        </select>
                        @error('cerda_id')
                            <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                        @if($cerdas->isEmpty())
                            <p class="text-xs text-amber-600 mt-2 font-medium bg-amber-50 border border-amber-200 rounded-lg p-3">
                                No hay cerdas disponibles para inseminación (deben estar activas y no estar gestantes ni lactantes). 
                                <a href="{{ route('cerdas.index', ['modal' => 'create']) }}" class="underline font-bold">Registrar nueva cerda</a>.
                            </p>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Fecha Inseminación -->
                        <div>
                            <label for="fecha_inseminacion" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Fecha de Inseminación</label>
                            <input type="date" name="fecha_inseminacion" id="fecha_inseminacion" value="{{ old('fecha_inseminacion', date('Y-m-d')) }}" required class="w-full text-sm rounded-lg border-gray-300 focus:border-brand-500 focus:ring focus:ring-brand-200 focus:ring-opacity-50">
                            @error('fecha_inseminacion')
                                <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tipo -->
                        <div>
                            <label for="tipo" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Método / Tipo</label>
                            <select name="tipo" id="tipo" required class="w-full text-sm rounded-lg border-gray-300 focus:border-brand-500 focus:ring focus:ring-brand-200 focus:ring-opacity-50">
                                <option value="artificial" {{ old('tipo') === 'artificial' ? 'selected' : '' }}>Inseminación Artificial (Recomendado)</option>
                                <option value="natural" {{ old('tipo') === 'natural' ? 'selected' : '' }}>Monta Natural</option>
                            </select>
                            @error('tipo')
                                <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Verraco -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="verraco_id" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Verraco Registrado</label>
                            <select name="verraco_id" id="verraco_id" class="w-full text-sm rounded-lg border-gray-300 focus:border-brand-500 focus:ring focus:ring-brand-200 focus:ring-opacity-50">
                                <option value="">-- Seleccionar Verraco (opcional) --</option>
                                @foreach($verracos as $verraco)
                                    <option value="{{ $verraco->id }}" {{ old('verraco_id') == $verraco->id ? 'selected' : '' }}>
                                        {{ $verraco->codigo }} - {{ $verraco->nombre ?? 'Sin Nombre' }} ({{ $verraco->raza ?? 'N/D' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('verraco_id')
                                <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="verraco" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Otro Verraco / Lote (manual)</label>
                            <input type="text" name="verraco" id="verraco" value="{{ old('verraco') }}" placeholder="Código del verraco o lote de dosis manual" class="w-full text-sm rounded-lg border-gray-300 focus:border-brand-500 focus:ring focus:ring-brand-200 focus:ring-opacity-50">
                            @error('verraco')
                                <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Notas -->
                    <div>
                        <label for="notas" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Notas / Observaciones</label>
                        <textarea name="notas" id="notas" rows="4" placeholder="Registrar detalles adicionales (casa genética del semen, condiciones del celo, etc.)..." class="w-full text-sm rounded-lg border-gray-300 focus:border-brand-500 focus:ring focus:ring-brand-200 focus:ring-opacity-50">{{ old('notas') }}</textarea>
                        @error('notas')
                            <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Botón Enviar -->
                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('inseminaciones.index') }}" class="px-4 py-2 text-sm font-semibold text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                            Cancelar
                        </a>
                        <button type="submit" class="px-5 py-2 text-sm font-bold text-white rounded-lg hover:bg-brand-600 shadow-sm transition-colors" style="background-color: #f4b08a;">
                            Registrar Inseminación
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</x-app-layout>
