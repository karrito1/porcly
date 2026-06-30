<x-modal name="parto-create-modal" maxWidth="2xl" focusable>
    <form action="{{ route('partos.store') }}" method="POST" class="max-h-[85vh] overflow-y-auto p-6 space-y-5">
        @csrf

        <div class="flex items-start justify-between gap-4 border-b border-gray-100 pb-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Registrar Parto</h3>
                <p class="mt-1 text-sm text-gray-500">Crear sin salir de la lista.</p>
            </div>
            <button type="button" class="rounded-lg border border-gray-200 px-3 py-2 text-xs font-semibold text-gray-600 hover:bg-gray-50" x-on:click="$dispatch('close')">Cerrar</button>
        </div>

        <div>
            <label for="modal-cerda_id" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Seleccionar Madre (Cerda Gestante)</label>
            <select name="cerda_id" id="modal-cerda_id" required class="w-full text-sm rounded-lg border-gray-300 focus:border-brand-500 focus:ring focus:ring-brand-200 focus:ring-opacity-50">
                <option value="">-- Seleccionar Cerda --</option>
                @foreach($cerdasGestantes as $cerda)
                    <option value="{{ $cerda->id }}">
                        {{ $cerda->codigo }} - {{ $cerda->nombre ?? 'Sin Nombre' }}
                    </option>
                @endforeach
            </select>
            @error('cerda_id')
                <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
            @enderror
            @if($cerdasGestantes->isEmpty())
                <p class="text-xs text-amber-600 mt-2 font-medium bg-amber-50 border border-amber-200 rounded-lg p-3">
                    No hay cerdas actualmente en estado "Gestante".
                    <a href="{{ route('inseminaciones.index', ['modal' => 'create']) }}" class="underline font-bold">Registrar e inseminar una cerda</a> primero.
                </p>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="modal-fecha_parto" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Fecha del Parto</label>
                <input type="date" name="fecha_parto" id="modal-fecha_parto" value="{{ date('Y-m-d') }}" required class="w-full text-sm rounded-lg border-gray-300 focus:border-brand-500 focus:ring focus:ring-brand-200 focus:ring-opacity-50">
            </div>
            <div>
                <label for="modal-peso_camada" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Peso Total Camada (kg)</label>
                <input type="number" name="peso_camada" id="modal-peso_camada" step="0.01" min="0" placeholder="Opcional (ej. 15.5)" class="w-full text-sm rounded-lg border-gray-300 focus:border-brand-500 focus:ring focus:ring-brand-200 focus:ring-opacity-50">
            </div>
        </div>

        <div class="bg-gray-50/50 p-4 border border-gray-200 rounded-xl">
            <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-4">Recuento de Camada</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="modal-lechones_vivos" class="block text-xs font-bold text-emerald-700 mb-2">Nacidos Vivos</label>
                    <input type="number" name="lechones_vivos" id="modal-lechones_vivos" min="0" value="0" required class="w-full text-sm rounded-lg border-gray-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-50">
                </div>
                <div>
                    <label for="modal-lechones_muertos" class="block text-xs font-bold text-rose-700 mb-2">Nacidos Muertos</label>
                    <input type="number" name="lechones_muertos" id="modal-lechones_muertos" min="0" value="0" required class="w-full text-sm rounded-lg border-gray-300 focus:border-rose-500 focus:ring focus:ring-rose-200 focus:ring-opacity-50">
                </div>
                <div>
                    <label for="modal-lechones_momificados" class="block text-xs font-bold text-amber-800 mb-2">Momificados</label>
                    <input type="number" name="lechones_momificados" id="modal-lechones_momificados" min="0" value="0" required class="w-full text-sm rounded-lg border-gray-300 focus:border-amber-500 focus:ring focus:ring-amber-200 focus:ring-opacity-50">
                </div>
            </div>
        </div>

        <div>
            <label for="modal-observaciones" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Observaciones / Detalles</label>
            <textarea name="observaciones" id="modal-observaciones" rows="3" placeholder="Detalles adicionales (opcional)..." class="w-full text-sm rounded-lg border-gray-300 focus:border-brand-500 focus:ring focus:ring-brand-200 focus:ring-opacity-50"></textarea>
        </div>

        <div class="flex justify-end gap-3 border-t border-gray-100 pt-4">
            <x-secondary-button type="button" x-on:click="$dispatch('close')">Cancelar</x-secondary-button>
            <x-primary-button>Registrar Parto</x-primary-button>
        </div>
    </form>
</x-modal>
