<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Gestión de usuarios</h2>
                <p class="mt-1 text-sm text-gray-500">Crea y revisa las cuentas autorizadas para acceder a Porcly.</p>
            </div>

            <a href="{{ route('users.create') }}" class="inline-flex items-center justify-center rounded-md bg-brand-500 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2">
                Crear usuario
            </a>
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
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-600">Creado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse ($users as $user)
                                <tr>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-semibold text-gray-900">{{ $user->name }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $user->created_at?->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-10 text-center text-sm text-gray-500">No hay usuarios registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
