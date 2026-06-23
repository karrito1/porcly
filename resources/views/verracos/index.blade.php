<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Verracos</h2>
                <p class="mt-1 text-sm text-gray-500">Registro de reproductores machos.</p>
            </div>
            <a href="{{ route('verracos.create') }}" class="inline-flex items-center justify-center rounded-md bg-brand-500 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2">
                + Nuevo Verraco
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
                                <tr>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-bold text-gray-900">{{ $verraco->codigo }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-700">{{ $verraco->nombre ?? '—' }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">{{ $verraco->raza ?? '—' }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $verraco->fecha_nacimiento?->format('d/m/Y') ?? '—' }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">{{ $verraco->peso ? $verraco->peso . ' kg' : '—' }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('verracos.edit', $verraco) }}" class="rounded-lg border border-gray-200 px-3 py-1.5 text-xs font-semibold text-gray-700 transition hover:bg-gray-50">Editar</a>
                                            <form method="POST" action="{{ route('verracos.destroy', $verraco) }}" onsubmit="return confirm('¿Eliminar este verraco?')">
                                                @csrf @method('delete')
                                                <button type="submit" class="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-semibold text-red-600 transition hover:bg-red-50">Eliminar</button>
                                            </form>
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
</x-app-layout>
