<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-bold text-xl text-gray-800 leading-tight">Gestión del Hato — Cerdas</h2>
                <p class="mt-1 text-sm text-gray-500">Todo el flujo principal en la misma pantalla.</p>
            </div>

            <button type="button" onclick="openCerdaCreateModal()" class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-4 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-brand-600">
                Registrar Nueva Cerda
            </button>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mb-6 rounded-2xl border border-gray-200/80 bg-white p-6 shadow-sm">
                <form action="{{ route('cerdas.index') }}" method="GET" class="grid grid-cols-1 gap-4 md:grid-cols-4 md:items-end">
                    <div class="md:col-span-2">
                        <label for="buscar" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-500">Buscar cerda</label>
                        <input type="text" name="buscar" id="buscar" value="{{ request('buscar') }}" placeholder="Código (C-001) o nombre..." class="w-full rounded-lg border-gray-300 text-sm focus:border-brand-500 focus:ring focus:ring-brand-200 focus:ring-opacity-50">
                    </div>

                    <div>
                        <label for="estado" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-500">Estado</label>
                        <select name="estado" id="estado" class="w-full rounded-lg border-gray-300 text-sm focus:border-brand-500 focus:ring focus:ring-brand-200 focus:ring-opacity-50">
                            <option value="">Todos los estados</option>
                            <option value="activa" {{ request('estado') === 'activa' ? 'selected' : '' }}>Activa</option>
                            <option value="gestante" {{ request('estado') === 'gestante' ? 'selected' : '' }}>Gestante</option>
                            <option value="lactante" {{ request('estado') === 'lactante' ? 'selected' : '' }}>Lactante</option>
                            <option value="en_celo" {{ request('estado') === 'en_celo' ? 'selected' : '' }}>En celo</option>
                            <option value="descarte" {{ request('estado') === 'descarte' ? 'selected' : '' }}>Descarte</option>
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg bg-gray-800 px-4 py-2.5 text-xs font-bold text-white shadow-sm transition hover:bg-gray-900">
                            Filtrar
                        </button>
                        @if(request()->anyFilled(['buscar', 'estado', 'raza']))
                            <a href="{{ route('cerdas.index') }}" class="inline-flex w-full items-center justify-center rounded-lg border border-gray-200 bg-gray-100 px-4 py-2.5 text-xs font-bold text-gray-700 shadow-sm transition hover:bg-gray-200">
                                Limpiar
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="overflow-hidden rounded-2xl border border-gray-200/80 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse text-left">
                        <thead>
                            <tr class="border-b border-gray-100 bg-gray-50/50">
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">Código</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">Nombre</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">Raza</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">Edad</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">Peso</th>
                                <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-500">Partos</th>
                                <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-500">Estado</th>
                                <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-gray-500">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($cerdas as $cerda)
                                @php
                                    $cerdaData = [
                                        'id' => $cerda->id,
                                        'codigo' => $cerda->codigo,
                                        'nombre' => $cerda->nombre,
                                        'raza' => $cerda->raza,
                                        'estado' => $cerda->estado,
                                        'fecha_nacimiento' => $cerda->fecha_nacimiento?->format('Y-m-d'),
                                        'fecha_nacimiento_texto' => $cerda->fecha_nacimiento?->format('d/m/Y'),
                                        'peso_actual' => $cerda->peso_actual,
                                        'numero_partos' => $cerda->numero_partos,
                                        'notas' => $cerda->notas,
                                        'edad_meses' => $cerda->fecha_nacimiento ? (int) now()->diffInMonths($cerda->fecha_nacimiento) : null,
                                    ];
                                @endphp
                                <tr class="transition-colors hover:bg-gray-50/40">
                                    <td class="px-6 py-4 font-bold text-gray-900">{{ $cerda->codigo }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $cerda->nombre ?? 'Sin nombre' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $cerda->raza ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        @if($cerda->fecha_nacimiento)
                                            {{ (int) now()->diffInMonths($cerda->fecha_nacimiento) }} m
                                            <span class="text-xs text-gray-400">({{ $cerda->fecha_nacimiento->format('d/m/Y') }})</span>
                                        @else
                                            No registrada
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-700">{{ $cerda->peso_actual ? number_format($cerda->peso_actual, 1) . ' kg' : 'N/A' }}</td>
                                    <td class="px-6 py-4 text-center text-sm font-bold text-gray-900">{{ $cerda->numero_partos }}</td>
                                    <td class="px-6 py-4 text-center">
                                        @if($cerda->estado === 'activa')
                                            <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-700">Activa</span>
                                        @elseif($cerda->estado === 'gestante')
                                            <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-1 text-xs font-bold text-amber-700">Gestante</span>
                                        @elseif($cerda->estado === 'lactante')
                                            <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-1 text-xs font-bold text-blue-700">Lactante</span>
                                        @elseif($cerda->estado === 'en_celo')
                                            <span class="inline-flex items-center rounded-full bg-purple-50 px-2.5 py-1 text-xs font-bold text-purple-700">En celo</span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-1 text-xs font-bold text-gray-700">Descarte</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm">
                                        <div class="flex flex-wrap justify-end gap-2">
                                            <button type="button" data-cerda='@json($cerdaData)' onclick="openCerdaShowModal(JSON.parse(this.dataset.cerda))" class="inline-flex items-center rounded-lg border border-gray-200 bg-gray-50 px-3 py-1 text-xs font-semibold text-gray-700 shadow-sm transition hover:bg-gray-100">Ver</button>
                                            <button type="button" data-cerda='@json($cerdaData)' onclick="openCerdaEditModal(JSON.parse(this.dataset.cerda))" class="inline-flex items-center rounded-lg border border-gray-200 bg-white px-3 py-1 text-xs font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50">Editar</button>
                                            <button type="button" data-cerda='@json($cerdaData)' onclick="openCerdaDeleteModal(JSON.parse(this.dataset.cerda))" class="inline-flex items-center rounded-lg border border-rose-200 bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-700 shadow-sm transition hover:bg-rose-100">Eliminar</button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center text-sm text-gray-500">No se encontraron cerdas que coincidan con los filtros.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($cerdas->hasPages())
                    <div class="border-t border-gray-200 px-6 py-4">{{ $cerdas->links() }}</div>
                @endif
            </div>
        </div>
    </div>

    @include('cerdas.partials.show-modal')
    @include('cerdas.partials.create-modal')
    @include('cerdas.partials.edit-modal')
    @include('cerdas.partials.delete-modal')

    @push('scripts')
        <script>
            function cerdaStatusLabel(estado) {
                return {
                    activa: 'Activa',
                    gestante: 'Gestante',
                    lactante: 'Lactante',
                    en_celo: 'En celo',
                    descarte: 'Descarte',
                }[estado] || 'Sin estado';
            }

            function openModalByName(name) {
                window.dispatchEvent(new CustomEvent('open-modal', { detail: name }));
            }

            // Auto-abrir modal por query string (?modal=create|edit|show|delete&cerda=ID)
            @if($modal && $modal === 'create')
                document.addEventListener('DOMContentLoaded', function() { openModalByName('cerda-create-modal'); });
            @elseif($modal && $modalCerdaData && in_array($modal, ['edit', 'show', 'delete']))
                document.addEventListener('DOMContentLoaded', function() {
                    window['openCerda' + $modal.charAt(0).toUpperCase() + $modal.slice(1) + 'Modal'](@json($modalCerdaData));
                });
            @endif

            window.openCerdaCreateModal = function() {
                openModalByName('cerda-create-modal');
            };

            window.openCerdaEditModal = function(data) {
                const form = document.getElementById('cerda-edit-form');
                if (form) {
                    form.action = '{{ url('cerdas') }}/' + data.id;
                }

                const setValue = (id, value) => {
                    const el = document.getElementById(id);
                    if (el) el.value = value ?? '';
                };

                setValue('cerda-edit-id', data.id);
                setValue('cerda-edit-codigo', data.codigo);
                setValue('cerda-edit-nombre', data.nombre);
                setValue('cerda-edit-raza', data.raza);
                setValue('cerda-edit-estado', data.estado);
                setValue('cerda-edit-fecha_nacimiento', data.fecha_nacimiento);
                setValue('cerda-edit-peso_actual', data.peso_actual);
                setValue('cerda-edit-notas', data.notas);

                openModalByName('cerda-edit-modal');
            };

            window.openCerdaShowModal = function(data) {
                const setText = (id, value) => {
                    const el = document.getElementById(id);
                    if (el) el.textContent = value ?? '';
                };

                setText('cerda-show-code', data.codigo);
                setText('cerda-show-name', data.nombre || 'Sin nombre');
                setText('cerda-show-status', cerdaStatusLabel(data.estado));
                setText('cerda-show-breed', data.raza || 'N/A');
                setText('cerda-show-age', data.edad_meses != null ? data.edad_meses + ' meses' : 'No registrada');
                setText('cerda-show-weight', data.peso_actual ? data.peso_actual + ' kg' : 'N/A');
                setText('cerda-show-parts', data.numero_partos != null ? String(data.numero_partos) : '0');
                setText('cerda-show-notes', data.notas || 'Sin notas');

                const editBtn = document.getElementById('cerda-show-edit-btn');
                if (editBtn) {
                    editBtn.onclick = function() {
                        window.dispatchEvent(new CustomEvent('close-modal', { detail: 'cerda-show-modal' }));
                        window.openCerdaEditModal(data);
                    };
                }

                openModalByName('cerda-show-modal');
            };

            window.openCerdaDeleteModal = function(data) {
                const form = document.getElementById('cerda-delete-form');
                if (form) {
                    form.action = '{{ url('cerdas') }}/' + data.id;
                }

                const text = document.getElementById('cerda-delete-text');
                if (text) {
                    text.textContent = `¿Seguro que deseas eliminar la cerda ${data.codigo}? Esta acción no se puede deshacer.`;
                }

                openModalByName('cerda-delete-modal');
            };
        </script>
    @endpush
</x-app-layout>
