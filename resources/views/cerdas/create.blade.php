<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('cerdas.index') }}" class="text-gray-500 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Registrar Nueva Cerda') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-white border border-gray-200/80 rounded-2xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Datos de Identificación y Registro</h3>
                    <p class="text-xs text-gray-500 mt-1">Completa los campos para añadir una cerda al inventario productivo.</p>
                </div>

                <form action="{{ route('cerdas.store') }}" method="POST" class="p-6 space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Código -->
                        <div>
                            <label for="codigo" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Código de la Cerda <span class="text-rose-500">*</span></label>
                            <input type="text" name="codigo" id="codigo" value="{{ old('codigo') }}" placeholder="Ej. C-012 o M-09" class="w-full text-sm rounded-lg border-gray-250 focus:border-brand-500 focus:ring focus:ring-brand-200 focus:ring-opacity-50 @error('codigo') border-rose-300 focus:border-rose-500 focus:ring-rose-200 @enderror" required>
                            @error('codigo')
                                <p class="text-rose-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nombre -->
                        <div>
                            <label for="nombre" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nombre / Apodo</label>
                            <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" placeholder="Ej. Margarita, La gorda..." class="w-full text-sm rounded-lg border-gray-250 focus:border-brand-500 focus:ring focus:ring-brand-200 focus:ring-opacity-50 @error('nombre') border-rose-300 focus:border-rose-500 focus:ring-rose-200 @enderror">
                            @error('nombre')
                                <p class="text-rose-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Raza -->
                        <div>
                            <label for="raza" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Raza</label>
                            <input type="text" name="raza" id="raza" value="{{ old('raza') }}" placeholder="Ej. Landrace, Duroc, Large White" class="w-full text-sm rounded-lg border-gray-250 focus:border-brand-500 focus:ring focus:ring-brand-200 focus:ring-opacity-50 @error('raza') border-rose-300 focus:border-rose-500 focus:ring-rose-200 @enderror">
                            @error('raza')
                                <p class="text-rose-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Estado Inicial -->
                        <div>
                            <label for="estado" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Estado Productivo Inicial <span class="text-rose-500">*</span></label>
                            <select name="estado" id="estado" class="w-full text-sm rounded-lg border-gray-250 focus:border-brand-500 focus:ring focus:ring-brand-200 focus:ring-opacity-50 @error('estado') border-rose-300 focus:border-rose-500 focus:ring-rose-200 @enderror" required>
                                <option value="activa" {{ old('estado') === 'activa' ? 'selected' : '' }}>Activa (Ciclando / Destetada)</option>
                                <option value="gestante" {{ old('estado') === 'gestante' ? 'selected' : '' }}>Gestante (Preñada)</option>
                                <option value="lactante" {{ old('estado') === 'lactante' ? 'selected' : '' }}>Lactante (Con lechones)</option>
                                <option value="en_celo" {{ old('estado') === 'en_celo' ? 'selected' : '' }}>En Celo</option>
                                <option value="descarte" {{ old('estado') === 'descarte' ? 'selected' : '' }}>Descarte (Inactiva)</option>
                            </select>
                            @error('estado')
                                <p class="text-rose-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fecha de Nacimiento -->
                        <div>
                            <label for="fecha_nacimiento" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Fecha de Nacimiento</label>
                            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" class="w-full text-sm rounded-lg border-gray-250 focus:border-brand-500 focus:ring focus:ring-brand-200 focus:ring-opacity-50 @error('fecha_nacimiento') border-rose-300 focus:border-rose-500 focus:ring-rose-200 @enderror">
                            @error('fecha_nacimiento')
                                <p class="text-rose-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Peso Actual -->
                        <div>
                            <label for="peso_actual" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Peso Inicial (kg)</label>
                            <input type="number" step="0.01" name="peso_actual" id="peso_actual" value="{{ old('peso_actual') }}" placeholder="Ej. 180.5" class="w-full text-sm rounded-lg border-gray-250 focus:border-brand-500 focus:ring focus:ring-brand-200 focus:ring-opacity-50 @error('peso_actual') border-rose-300 focus:border-rose-500 focus:ring-rose-200 @enderror">
                            @error('peso_actual')
                                <p class="text-rose-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Notas -->
                    <div>
                        <label for="notas" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Notas / Observaciones</label>
                        <textarea name="notas" id="notas" rows="4" placeholder="Algún detalle clínico, rasgos particulares, antecedentes, etc." class="w-full text-sm rounded-lg border-gray-250 focus:border-brand-500 focus:ring focus:ring-brand-200 focus:ring-opacity-50 @error('notas') border-rose-300 focus:border-rose-500 focus:ring-rose-200 @enderror">{{ old('notas') }}</textarea>
                        @error('notas')
                            <p class="text-rose-600 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('cerdas.index') }}" class="inline-flex items-center px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 text-xs font-bold border border-gray-250 rounded-lg shadow-sm transition-colors duration-150">
                            Cancelar
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 text-white text-xs font-bold rounded-lg shadow-sm transition-colors duration-150" style="background-color: #f4b08a; hover:background-color: #e39a72;">
                            Guardar Cerda
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
