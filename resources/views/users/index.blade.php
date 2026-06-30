<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Gestión de usuarios</h2>
                <p class="mt-1 text-sm text-gray-500">Crea, edita y administra las cuentas autorizadas para acceder a Porcly.</p>
            </div>

            <button type="button" onclick="openUserCreateModal()" class="inline-flex items-center justify-center rounded-md bg-brand-500 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2">
                Crear usuario
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
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">Nombre</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">Correo</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">Rol</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">Estado</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">Creado</th>
                                <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-gray-600">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse ($users as $user)
                                @php
                                    $userData = [
                                        'id' => $user->id,
                                        'name' => $user->name,
                                        'email' => $user->email,
                                        'role' => $user->roles->first()?->name ?? '',
                                        'is_active' => $user->is_active,
                                        'can_delete' => $user->id !== Auth::id(),
                                    ];
                                @endphp
                                <tr>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-gray-900">{{ $user->name }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm">
                                        @if ($user->roles->isNotEmpty())
                                            <span class="inline-flex items-center rounded-full bg-brand-100 px-2.5 py-0.5 text-xs font-semibold text-brand-800">
                                                {{ ucfirst($user->roles->first()->name) }}
                                            </span>
                                        @else
                                            <span class="text-gray-400">—</span>
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm">
                                        @if ($user->is_active)
                                            <span class="inline-flex items-center gap-1 text-emerald-700">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                Activo
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 text-red-600">
                                                <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                                                Inactivo
                                            </span>
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $user->created_at?->format('d/m/Y') }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
                                        <div class="flex items-center justify-end gap-2">
                                            <button type="button" data-user='@json($userData)' onclick="openUserEditModal(JSON.parse(this.dataset.user))" class="rounded-lg border border-gray-200 px-3 py-1.5 text-xs font-semibold text-gray-700 transition hover:bg-gray-50">
                                                Editar
                                            </button>
                                            @if ($user->id !== Auth::id())
                                                <button type="button" data-user='@json($userData)' onclick="openUserDeleteModal(JSON.parse(this.dataset.user))" class="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-semibold text-red-600 transition hover:bg-red-50">
                                                    Eliminar
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center text-sm text-gray-500">No hay usuarios registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('users.partials.create-modal')
    @include('users.partials.edit-modal')
    @include('users.partials.delete-modal')

    @push('scripts')
        <script>
            function openModalByName(name) {
                window.dispatchEvent(new CustomEvent('open-modal', { detail: name }));
            }

            window.openUserCreateModal = function() {
                openModalByName('user-create-modal');
            };

            window.openUserEditModal = function(data) {
                const form = document.getElementById('user-edit-form');
                if (form) {
                    form.action = '{{ url('usuarios') }}/' + data.id;
                }

                document.getElementById('edit-user-id').value = data.id;
                document.getElementById('edit-name').value = data.name ?? '';
                document.getElementById('edit-email').value = data.email ?? '';
                document.getElementById('edit-password').value = '';
                document.getElementById('edit-password_confirmation').value = '';

                const roleSelect = document.getElementById('edit-role');
                if (roleSelect) {
                    for (let opt of roleSelect.options) {
                        opt.selected = opt.value === data.role;
                    }
                }

                const activeCheckbox = document.getElementById('edit-is_active');
                if (activeCheckbox) {
                    activeCheckbox.checked = data.is_active;
                }

                openModalByName('user-edit-modal');
            };

            window.openUserDeleteModal = function(data) {
                const form = document.getElementById('user-delete-form');
                if (form) {
                    form.action = '{{ url('usuarios') }}/' + data.id;
                }

                const text = document.getElementById('user-delete-text');
                if (text) {
                    text.textContent = '¿Seguro que deseas eliminar a ' + data.name + '? Esta acción no se puede deshacer.';
                }

                openModalByName('user-delete-modal');
            };
        </script>
    @endpush
</x-app-layout>
