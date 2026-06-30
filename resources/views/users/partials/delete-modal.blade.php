<x-modal name="user-delete-modal" maxWidth="sm" focusable>
    <div class="p-6 space-y-5">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center font-bold text-lg border border-rose-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Eliminar Usuario</h3>
                <p id="user-delete-text" class="mt-1 text-sm text-gray-500">¿Seguro que deseas eliminar este usuario? Esta acción no se puede deshacer.</p>
            </div>
        </div>

        <form id="user-delete-form" method="POST" class="flex justify-end gap-3 border-t border-gray-100 pt-4">
            @csrf
            @method('delete')
            <x-secondary-button type="button" x-on:click="$dispatch('close')">Cancelar</x-secondary-button>
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-rose-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2 transition ease-in-out duration-150">Eliminar</button>
        </form>
    </div>
</x-modal>
