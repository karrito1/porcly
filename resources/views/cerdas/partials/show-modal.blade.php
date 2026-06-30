<x-modal name="cerda-show-modal" maxWidth="2xl" :show="false" focusable>
    <div class="p-6 space-y-5">
        <div class="flex items-start justify-between gap-4 border-b border-gray-100 pb-4">
            <div>
                <p id="cerda-show-code" class="inline-flex rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold text-brand-700"></p>
                <h3 id="cerda-show-name" class="mt-2 text-lg font-semibold text-gray-900"></h3>
                <p id="cerda-show-status" class="mt-1 text-sm text-gray-500"></p>
            </div>
            <button type="button" class="rounded-lg border border-gray-200 px-3 py-2 text-xs font-semibold text-gray-600 hover:bg-gray-50" x-on:click="$dispatch('close')">Cerrar</button>
        </div>

        <div class="grid gap-3 sm:grid-cols-2">
            <div class="rounded-2xl bg-gray-50 p-4">
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Raza</p>
                <p id="cerda-show-breed" class="mt-1 text-sm font-semibold text-gray-900"></p>
            </div>
            <div class="rounded-2xl bg-gray-50 p-4">
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Edad</p>
                <p id="cerda-show-age" class="mt-1 text-sm font-semibold text-gray-900"></p>
            </div>
            <div class="rounded-2xl bg-gray-50 p-4">
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Peso</p>
                <p id="cerda-show-weight" class="mt-1 text-sm font-semibold text-gray-900"></p>
            </div>
            <div class="rounded-2xl bg-gray-50 p-4">
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Partos</p>
                <p id="cerda-show-parts" class="mt-1 text-sm font-semibold text-gray-900"></p>
            </div>
        </div>

        <div class="rounded-2xl bg-gray-50 p-4">
            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Notas</p>
            <p id="cerda-show-notes" class="mt-1 text-sm text-gray-700 whitespace-pre-line"></p>
        </div>

        <div class="flex flex-wrap justify-end gap-3 border-t border-gray-100 pt-4">
            <x-secondary-button type="button" x-on:click="$dispatch('close')">Cerrar</x-secondary-button>
            <x-primary-button type="button" id="cerda-show-edit-btn">Editar cerda</x-primary-button>
        </div>
    </div>
</x-modal>
