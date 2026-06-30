<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Verracos</h2>
                <p class="mt-1 text-sm text-gray-500">Registro de reproductores machos.</p>
            </div>
            <button type="button" onclick="openVerracoCreateModal()" class="inline-flex items-center justify-center rounded-md bg-brand-500 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2">
                + Nuevo Verraco
            </button>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-brand-50/70">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">Código</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">Nombre</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">Raza</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">Nacimiento</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">Peso</th>
                                <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-gray-600">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse ($verracos as $verraco)
                                @php
                                    $verracoData = [
                                        'id' => $verraco->id,
                                        'codigo' => $verraco->codigo,
                                        'nombre' => $verraco->nombre,
                                        'raza' => $verraco->raza,
                                        'fecha_nacimiento' => $verraco->fecha_nacimiento?->format('Y-m-d'),
                                        'fecha_nacimiento_texto' => $verraco->fecha_nacimiento?->format('d/m/Y'),
                                        'peso' => $verraco->peso,
                                        'procedencia' => $verraco->procedencia,
                                        'notas' => $verraco->notas,
                                    ];
                                @endphp
                                <tr>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-bold text-gray-900">{{ $verraco->codigo }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-700">{{ $verraco->nombre ?? '—' }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">{{ $verraco->raza ?? '—' }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $verraco->fecha_nacimiento?->format('d/m/Y') ?? '—' }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">{{ $verraco->peso ? $verraco->peso . ' kg' : '—' }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
                                        <div class="flex items-center justify-end gap-2">
                                            <button type="button" data-verraco='@json($verracoData)' onclick="openVerracoEditModal(JSON.parse(this.dataset.verraco))" class="rounded-lg border border-gray-200 px-3 py-1.5 text-xs font-semibold text-gray-700 transition hover:bg-gray-50">Editar</button>
                                            <button type="button" data-verraco='@json($verracoData)' onclick="openVerracoDeleteModal(JSON.parse(this.dataset.verraco))" class="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-semibold text-red-600 transition hover:bg-red-50">Eliminar</button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center text-sm text-gray-500">No hay verracos registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-4">{{ $verracos->links() }}</div>
        </div>
    </div>

    @include('verracos.partials.create-modal')
    @include('verracos.partials.edit-modal')
    @include('verracos.partials.delete-modal')

    @push('scripts')
        <script>
            function openModalByName(name) {
                window.dispatchEvent(new CustomEvent('open-modal', { detail: name }));
            }

            window.openVerracoCreateModal = function() {
                openModalByName('verraco-create-modal');
            };

            window.openVerracoEditModal = function(data) {
                const form = document.getElementById('verraco-edit-form');
                if (form) {
                    form.action = '{{ url('verracos') }}/' + data.id;
                }

                const setValue = (id, value) => {
                    const el = document.getElementById(id);
                    if (el) el.value = value ?? '';
                };

                setValue('codigo', data.codigo);
                setValue('nombre', data.nombre);
                setValue('raza', data.raza);
                setValue('fecha_nacimiento', data.fecha_nacimiento);
                setValue('peso', data.peso);
                setValue('procedencia', data.procedencia);
                setValue('notas', data.notas);

                openModalByName('verraco-edit-modal');
            };

            window.openVerracoDeleteModal = function(data) {
                const form = document.getElementById('verraco-delete-form');
                if (form) {
                    form.action = '{{ url('verracos') }}/' + data.id;
                }

                const text = document.getElementById('verraco-delete-text');
                if (text) {
                    text.textContent = '¿Seguro que deseas eliminar el verraco ' + data.codigo + '? Esta acción no se puede deshacer.';
                }

                openModalByName('verraco-delete-modal');
            };

            @if(isset($modal) && $modal === 'create')
                document.addEventListener('DOMContentLoaded', function() { openModalByName('verraco-create-modal'); });
            @elseif(isset($modal) && isset($modalVerracoData) && in_array($modal, ['edit', 'delete']))
                document.addEventListener('DOMContentLoaded', function() {
                    window['openVerraco' + $modal.charAt(0).toUpperCase() + $modal.slice(1) + 'Modal'](@json($modalVerracoData));
                });
            @endif
        </script>
    @endpush
</x-app-layout>
