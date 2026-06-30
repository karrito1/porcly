<x-modal name="calendar-vacunacion-modal" maxWidth="2xl" :show="old('calendar_modal') === 'vacunacion'" focusable>
    <form action="{{ route('quick-record.vacunacion') }}" method="POST" class="max-h-[85vh] overflow-y-auto p-6 space-y-5">
        @csrf
        <input type="hidden" name="calendar_modal" value="vacunacion">

        <div class="flex items-start justify-between gap-4 border-b border-gray-100 pb-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Registrar Vacunación</h3>
                <p class="mt-1 text-sm text-gray-500">Se crea sin salir del calendario.</p>
            </div>
            <button type="button" class="rounded-lg border border-gray-200 px-3 py-2 text-xs font-semibold text-gray-600 hover:bg-gray-50" x-on:click="$dispatch('close')">Cerrar</button>
        </div>

        <div>
            <x-input-label for="calendar-vacunacion-cerda" value="Cerda" />
            <select id="calendar-vacunacion-cerda" name="cerda_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500" required>
                <option value="">Selecciona una cerda</option>
                @foreach ($cerdasTodas as $cerda)
                    <option value="{{ $cerda->id }}" @selected(old('cerda_id') == $cerda->id)>
                        {{ $cerda->codigo }} - {{ $cerda->nombre ?? 'Sin nombre' }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="isset($errors) ? $errors->get('cerda_id') : []" />
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <x-input-label for="calendar-vacunacion-fecha" value="Fecha" />
                <x-text-input id="calendar-vacunacion-fecha" name="fecha" type="date" class="mt-1 block w-full" :value="old('fecha', now()->toDateString())" required />
                <x-input-error class="mt-2" :messages="isset($errors) ? $errors->get('fecha') : []" />
            </div>
            <div>
                <x-input-label for="calendar-vacunacion-vacuna" value="Vacuna" />
                <x-text-input id="calendar-vacunacion-vacuna" name="vacuna" type="text" class="mt-1 block w-full" :value="old('vacuna')" required />
                <x-input-error class="mt-2" :messages="isset($errors) ? $errors->get('vacuna') : []" />
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-3">
            <div>
                <x-input-label for="calendar-vacunacion-dosis" value="Dosis" />
                <x-text-input id="calendar-vacunacion-dosis" name="dosis" type="text" class="mt-1 block w-full" :value="old('dosis')" />
                <x-input-error class="mt-2" :messages="isset($errors) ? $errors->get('dosis') : []" />
            </div>
            <div>
                <x-input-label for="calendar-vacunacion-proxima" value="Próxima dosis" />
                <x-text-input id="calendar-vacunacion-proxima" name="proxima_dosis" type="date" class="mt-1 block w-full" :value="old('proxima_dosis')" />
                <x-input-error class="mt-2" :messages="isset($errors) ? $errors->get('proxima_dosis') : []" />
            </div>
            <div>
                <x-input-label for="calendar-vacunacion-veterinario" value="Veterinario" />
                <x-text-input id="calendar-vacunacion-veterinario" name="veterinario" type="text" class="mt-1 block w-full" :value="old('veterinario')" />
                <x-input-error class="mt-2" :messages="isset($errors) ? $errors->get('veterinario') : []" />
            </div>
        </div>

        <div>
            <x-input-label for="calendar-vacunacion-notas" value="Notas" />
            <textarea id="calendar-vacunacion-notas" name="notas" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500">{{ old('notas') }}</textarea>
            <x-input-error class="mt-2" :messages="isset($errors) ? $errors->get('notas') : []" />
        </div>

        <div class="flex justify-end gap-3 border-t border-gray-100 pt-4">
            <x-secondary-button type="button" x-on:click="$dispatch('close')">Cancelar</x-secondary-button>
            <x-primary-button>Guardar</x-primary-button>
        </div>
    </form>
</x-modal>
