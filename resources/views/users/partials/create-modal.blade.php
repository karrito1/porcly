<x-modal name="user-create-modal" maxWidth="2xl" focusable>
    <form action="{{ route('users.store') }}" method="POST" class="max-h-[85vh] overflow-y-auto p-6 space-y-5">
        @csrf

        <div class="flex items-start justify-between gap-4 border-b border-gray-100 pb-4">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Crear Usuario</h3>
                <p class="mt-1 text-sm text-gray-500">Nueva cuenta de acceso al sistema.</p>
            </div>
            <button type="button" class="rounded-lg border border-gray-200 px-3 py-2 text-xs font-semibold text-gray-600 hover:bg-gray-50" x-on:click="$dispatch('close')">Cerrar</button>
        </div>

        <div>
            <x-input-label for="create-name" value="Nombre completo" />
            <x-text-input id="create-name" name="name" type="text" class="mt-1 block w-full" required autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="create-email" value="Correo electrónico" />
            <x-text-input id="create-email" name="email" type="email" class="mt-1 block w-full" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <x-input-label for="create-password" value="Contraseña" />
                <x-text-input id="create-password" name="password" type="password" class="mt-1 block w-full" required autocomplete="new-password" />
                <x-input-error class="mt-2" :messages="$errors->get('password')" />
            </div>
            <div>
                <x-input-label for="create-password_confirmation" value="Confirmar contraseña" />
                <x-text-input id="create-password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required autocomplete="new-password" />
            </div>
        </div>

        <div>
            <x-input-label for="create-role" value="Rol" />
            <select id="create-role" name="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500">
                <option value="">Sin rol</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('role')" />
        </div>

        <div class="flex justify-end gap-3 border-t border-gray-100 pt-4">
            <x-secondary-button type="button" x-on:click="$dispatch('close')">Cancelar</x-secondary-button>
            <x-primary-button>Crear usuario</x-primary-button>
        </div>
    </form>
</x-modal>
