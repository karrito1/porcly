<x-modal name="cerda-delete-modal" maxWidth="lg" :show="false" focusable>
    <form id="cerda-delete-form" action="{{ url('cerdas/0') }}" method="POST" class="p-6 space-y-5">
        @csrf
        @method('DELETE')

        <div class="flex items-start justify-between gap-4 border-b border-gray-100 pb-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Eliminar Cerda</h3>
                <p id="cerda-delete-text" class="mt-1 text-sm text-gray-500"></p>
            </div>
            <button type="button" class="rounded-lg border border-gray-200 px-3 py-2 text-xs font-semibold text-gray-600 hover:bg-gray-50" x-on:click="$dispatch('close')">Cerrar</button>
        </div>

        <p class="rounded-2xl bg-rose-50 px-4 py-3 text-sm text-rose-700">Esta acción elimina la cerda y su historial asociado.</p>

        <div class="flex justify-end gap-3 border-t border-gray-100 pt-4">
            <x-secondary-button type="button" x-on:click="$dispatch('close')">Cancelar</x-secondary-button>
            <x-danger-button>Eliminar</x-danger-button>
        </div>
    </form>
</x-modal>
