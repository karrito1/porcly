<x-modal name="calendar-event-modal" maxWidth="2xl" :show="false" focusable>
    <div class="p-6">
        <div class="flex items-start justify-between gap-4 border-b border-gray-100 pb-4">
            <div>
                <div id="calendar-event-chip" class="inline-flex items-center rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold text-brand-700"></div>
                <h3 id="calendar-event-title" class="mt-2 text-lg font-semibold text-gray-900"></h3>
                <p id="calendar-event-date" class="mt-1 text-sm text-gray-500"></p>
            </div>
            <button type="button" class="rounded-lg border border-gray-200 px-3 py-2 text-xs font-semibold text-gray-600 hover:bg-gray-50" x-on:click="$dispatch('close')">
                Cerrar
            </button>
        </div>

        <div class="mt-4 grid gap-3 sm:grid-cols-2">
            <div class="rounded-2xl bg-gray-50 p-4">
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Cerda</p>
                <p id="calendar-event-cerda" class="mt-1 text-sm font-semibold text-gray-900"></p>
            </div>
            <div class="rounded-2xl bg-gray-50 p-4">
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Detalle</p>
                <p id="calendar-event-detail" class="mt-1 text-sm text-gray-700"></p>
            </div>
        </div>

        <div class="mt-5 flex flex-wrap gap-3">
            <x-primary-button type="button" id="calendar-event-action-primary">Acción</x-primary-button>
            <x-secondary-button type="button" x-on:click="$dispatch('close')">Cerrar</x-secondary-button>
        </div>
    </div>
</x-modal>
