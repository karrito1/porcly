<x-modal name="inseminacion-create-modal" maxWidth="2xl" focusable>
    <form action="{{ route('inseminaciones.store') }}" method="POST" class="max-h-[85vh] overflow-y-auto p-6 space-y-5">
        @csrf

        <div class="flex items-start justify-between gap-4 border-b border-gray-100 pb-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Registrar Inseminación</h3>
                <p class="mt-1 text-sm text-gray-500">Crear sin salir de la lista.</p>
            </div>
            <button type="button" class="rounded-lg border border-gray-200 px-3 py-2 text-xs font-semibold text-gray-600 hover:bg-gray-50" x-on:click="$dispatch('close')">Cerrar</button>
        </div>

        <div>
            <label for="modal-cerda_id" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Seleccionar Cerda</label>
            <select name="cerda_id" id="modal-cerda_id" required class="w-full text-sm rounded-lg border-gray-300 focus:border-brand-500 focus:ring focus:ring-brand-200 focus:ring-opacity-50">
                <option value="">-- Seleccionar Cerda por Código --</option>
                @foreach($cerdasDisponibles as $cerda)
                    <option value="{{ $cerda->id }}">
                        {{ $cerda->codigo }} - {{ $cerda->nombre ?? 'Sin Nombre' }} (Raza: {{ $cerda->raza ?? 'N/D' }})
                    </option>
                @endforeach
            </select>
            @error('cerda_id')
                <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
            @enderror
            @if($cerdasDisponibles->isEmpty())
                <p class="text-xs text-amber-600 mt-2 font-medium bg-amber-50 border border-amber-200 rounded-lg p-3">
                    No hay cerdas disponibles para inseminación (deben estar activas y no estar gestantes ni lactantes).
                    <button type="button" onclick="
                        window.dispatchEvent(new CustomEvent('close-modal', { detail: 'inseminacion-create-modal' }));
                        setTimeout(function(){ window.dispatchEvent(new CustomEvent('open-modal', { detail: 'cerda-create-modal' })); }, 200);
                    " class="underline font-bold">Registrar nueva cerda</button>.
                </p>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="modal-fecha_inseminacion" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Fecha de Inseminación</label>
                <input type="date" name="fecha_inseminacion" id="modal-fecha_inseminacion" value="{{ date('Y-m-d') }}" required class="w-full text-sm rounded-lg border-gray-300 focus:border-brand-500 focus:ring focus:ring-brand-200 focus:ring-opacity-50">
            </div>
            <div>
                <label for="modal-tipo" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tipo de Inseminación</label>
                <select name="tipo" id="modal-tipo" required class="w-full text-sm rounded-lg border-gray-300 focus:border-brand-500 focus:ring focus:ring-brand-200 focus:ring-opacity-50">
                    <option value="natural">Natural (Monta)</option>
                    <option value="artificial">Artificial (IA)</option>
                </select>
            </div>
            <div>
                <label for="modal-verraco_id" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Verraco</label>
                <select name="verraco_id" id="modal-verraco_id" class="w-full text-sm rounded-lg border-gray-300 focus:border-brand-500 focus:ring focus:ring-brand-200 focus:ring-opacity-50">
                    <option value="">-- Seleccionar Verraco (opcional) --</option>
                    @foreach($verracos as $verraco)
                        <option value="{{ $verraco->id }}">
                            {{ $verraco->codigo }} - {{ $verraco->nombre ?? 'Sin Nombre' }} ({{ $verraco->raza ?? 'N/D' }})
                        </option>
                    @endforeach
                </select>
                @error('verraco_id')
                    <p class="text-xs text-rose-600 mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="modal-verraco" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Otro Verraco / Lote (si no está en la lista)</label>
                <input type="text" name="verraco" id="modal-verraco" placeholder="Código del verraco o lote de dosis manual" class="w-full text-sm rounded-lg border-gray-300 focus:border-brand-500 focus:ring focus:ring-brand-200 focus:ring-opacity-50">
            </div>
        </div>

        <div>
            <label for="modal-notas" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Notas</label>
            <textarea name="notas" id="modal-notas" rows="3" placeholder="Detalles adicionales (opcional)..." class="w-full text-sm rounded-lg border-gray-300 focus:border-brand-500 focus:ring focus:ring-brand-200 focus:ring-opacity-50"></textarea>
        </div>

        <div class="flex justify-end gap-3 border-t border-gray-100 pt-4">
            <x-secondary-button type="button" x-on:click="$dispatch('close')">Cancelar</x-secondary-button>
            <x-primary-button>Guardar Inseminación</x-primary-button>
        </div>
    </form>
</x-modal>
