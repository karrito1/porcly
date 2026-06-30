<x-modal name="calendar-parto-modal" maxWidth="2xl" :show="old('calendar_modal') === 'parto'" focusable>
    <form action="{{ route('partos.store') }}" method="POST" class="max-h-[85vh] overflow-y-auto p-6 space-y-5">
        @csrf
        <input type="hidden" name="calendar_modal" value="parto">

        <div class="flex items-start justify-between gap-4 border-b border-gray-100 pb-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Registrar Parto</h3>
                <p class="mt-1 text-sm text-gray-500">Se crea sin salir del calendario.</p>
            </div>
            <button type="button" class="rounded-lg border border-gray-200 px-3 py-2 text-xs font-semibold text-gray-600 hover:bg-gray-50" x-on:click="$dispatch('close')">Cerrar</button>
        </div>

        <div>
            <x-input-label for="calendar-parto-cerda" value="Cerda gestante" />
            <select id="calendar-parto-cerda" name="cerda_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500" required>
                <option value="">Selecciona una cerda</option>
                @foreach ($cerdasGestantes as $cerda)
                    <option value="{{ $cerda->id }}" @selected(old('cerda_id') == $cerda->id)>
                        {{ $cerda->codigo }} - {{ $cerda->nombre ?? 'Sin nombre' }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="isset($errors) ? $errors->get('cerda_id') : []" />
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <x-input-label for="calendar-parto-fecha" value="Fecha del parto" />
                <x-text-input id="calendar-parto-fecha" name="fecha_parto" type="date" class="mt-1 block w-full" :value="old('fecha_parto', now()->toDateString())" required />
                <x-input-error class="mt-2" :messages="isset($errors) ? $errors->get('fecha_parto') : []" />
            </div>
            <div>
                <x-input-label for="calendar-parto-peso" value="Peso de la camada (kg)" />
                <x-text-input id="calendar-parto-peso" name="peso_camada" type="number" step="0.01" min="0" class="mt-1 block w-full" :value="old('peso_camada')" />
                <x-input-error class="mt-2" :messages="isset($errors) ? $errors->get('peso_camada') : []" />
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-3">
            <div>
                <x-input-label for="calendar-parto-vivos" value="Lechones vivos" />
                <x-text-input id="calendar-parto-vivos" name="lechones_vivos" type="number" min="0" class="mt-1 block w-full" :value="old('lechones_vivos', 0)" required />
                <x-input-error class="mt-2" :messages="isset($errors) ? $errors->get('lechones_vivos') : []" />
            </div>
            <div>
                <x-input-label for="calendar-parto-muertos" value="Lechones muertos" />
                <x-text-input id="calendar-parto-muertos" name="lechones_muertos" type="number" min="0" class="mt-1 block w-full" :value="old('lechones_muertos', 0)" required />
                <x-input-error class="mt-2" :messages="isset($errors) ? $errors->get('lechones_muertos') : []" />
            </div>
            <div>
                <x-input-label for="calendar-parto-momificados" value="Momificados" />
                <x-text-input id="calendar-parto-momificados" name="lechones_momificados" type="number" min="0" class="mt-1 block w-full" :value="old('lechones_momificados', 0)" required />
                <x-input-error class="mt-2" :messages="isset($errors) ? $errors->get('lechones_momificados') : []" />
            </div>
        </div>

        <div>
            <x-input-label for="calendar-parto-observaciones" value="Observaciones" />
            <textarea id="calendar-parto-observaciones" name="observaciones" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500">{{ old('observaciones') }}</textarea>
            <x-input-error class="mt-2" :messages="isset($errors) ? $errors->get('observaciones') : []" />
        </div>

        <div class="flex justify-end gap-3 border-t border-gray-100 pt-4">
            <x-secondary-button type="button" x-on:click="$dispatch('close')">Cancelar</x-secondary-button>
            <x-primary-button>Guardar</x-primary-button>
        </div>
    </form>
</x-modal>
