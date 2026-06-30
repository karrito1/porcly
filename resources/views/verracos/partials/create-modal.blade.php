<x-modal name="verraco-create-modal" maxWidth="2xl" focusable>
    <form action="{{ route('verracos.store') }}" method="POST" class="max-h-[85vh] overflow-y-auto p-6 space-y-5">
        @csrf

        <div class="flex items-start justify-between gap-4 border-b border-gray-100 pb-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Registrar Nuevo Verraco</h3>
                <p class="mt-1 text-sm text-gray-500">Crear sin salir de la lista.</p>
            </div>
            <button type="button" class="rounded-lg border border-gray-200 px-3 py-2 text-xs font-semibold text-gray-600 hover:bg-gray-50" x-on:click="$dispatch('close')">Cerrar</button>
        </div>

        @include('verracos.partials.form-fields')

        <div class="flex justify-end gap-3 border-t border-gray-100 pt-4">
            <x-secondary-button type="button" x-on:click="$dispatch('close')">Cancelar</x-secondary-button>
            <x-primary-button>Guardar Verraco</x-primary-button>
        </div>
    </form>
</x-modal>
