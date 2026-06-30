<x-modal name="calendar-inseminacion-modal" maxWidth="2xl" :show="old('calendar_modal') === 'inseminacion'" focusable>
    <form action="{{ route('inseminaciones.store') }}" method="POST" class="max-h-[85vh] overflow-y-auto p-6 space-y-5">
        @csrf
        <input type="hidden" name="calendar_modal" value="inseminacion">

        <div class="flex items-start justify-between gap-4 border-b border-gray-100 pb-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Registrar Inseminación</h3>
                <p class="mt-1 text-sm text-gray-500">Se crea sin salir del calendario.</p>
            </div>
            <button type="button" class="rounded-lg border border-gray-200 px-3 py-2 text-xs font-semibold text-gray-600 hover:bg-gray-50" x-on:click="$dispatch('close')">Cerrar</button>
        </div>

        <div>
            <x-input-label for="calendar-inseminacion-cerda" value="Cerda" />
            <select id="calendar-inseminacion-cerda" name="cerda_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500" required>
                <option value="">Selecciona una cerda</option>
                @foreach ($cerdasDisponibles as $cerda)
                    <option value="{{ $cerda->id }}" @selected(old('cerda_id') == $cerda->id)>
                        {{ $cerda->codigo }} - {{ $cerda->nombre ?? 'Sin nombre' }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="isset($errors) ? $errors->get('cerda_id') : []" />
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <x-input-label for="calendar-inseminacion-fecha" value="Fecha de inseminación" />
                <x-text-input id="calendar-inseminacion-fecha" name="fecha_inseminacion" type="date" class="mt-1 block w-full" :value="old('fecha_inseminacion', now()->toDateString())" required />
                <x-input-error class="mt-2" :messages="isset($errors) ? $errors->get('fecha_inseminacion') : []" />
            </div>
            <div>
                <x-input-label for="calendar-inseminacion-tipo" value="Tipo" />
                <select id="calendar-inseminacion-tipo" name="tipo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500" required>
                    <option value="artificial" @selected(old('tipo', 'artificial') === 'artificial')>Artificial</option>
                    <option value="natural" @selected(old('tipo') === 'natural')>Natural</option>
                </select>
                <x-input-error class="mt-2" :messages="isset($errors) ? $errors->get('tipo') : []" />
            </div>
        </div>

        <div>
            <x-input-label for="calendar-inseminacion-verraco" value="Verraco" />
            <x-text-input id="calendar-inseminacion-verraco" name="verraco" type="text" class="mt-1 block w-full" :value="old('verraco')" placeholder="Código o nombre" />
            <x-input-error class="mt-2" :messages="isset($errors) ? $errors->get('verraco') : []" />
        </div>

        <div>
            <x-input-label for="calendar-inseminacion-notas" value="Notas" />
            <textarea id="calendar-inseminacion-notas" name="notas" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500">{{ old('notas') }}</textarea>
            <x-input-error class="mt-2" :messages="isset($errors) ? $errors->get('notas') : []" />
        </div>

        <div class="flex justify-end gap-3 border-t border-gray-100 pt-4">
            <x-secondary-button type="button" x-on:click="$dispatch('close')">Cancelar</x-secondary-button>
            <x-primary-button>Guardar</x-primary-button>
        </div>
    </form>
</x-modal>
