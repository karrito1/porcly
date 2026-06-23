<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Nuevo Verraco</h2>
            <p class="mt-1 text-sm text-gray-500">Registra un reproductor macho en el hato.</p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm sm:p-8">
                <form method="POST" action="{{ route('verracos.store') }}" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="codigo" value="Código *" />
                            <x-text-input id="codigo" name="codigo" type="text" class="mt-1 block w-full" :value="old('codigo')" required placeholder="Ej: V-001" />
                            <x-input-error class="mt-2" :messages="$errors->get('codigo')" />
                        </div>
                        <div>
                            <x-input-label for="nombre" value="Nombre" />
                            <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre')" placeholder="Opcional" />
                            <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
                        </div>
                        <div>
                            <x-input-label for="raza" value="Raza" />
                            <x-text-input id="raza" name="raza" type="text" class="mt-1 block w-full" :value="old('raza')" placeholder="Ej: Duroc" />
                            <x-input-error class="mt-2" :messages="$errors->get('raza')" />
                        </div>
                        <div>
                            <x-input-label for="fecha_nacimiento" value="Fecha de Nacimiento" />
                            <x-text-input id="fecha_nacimiento" name="fecha_nacimiento" type="date" class="mt-1 block w-full" :value="old('fecha_nacimiento')" />
                            <x-input-error class="mt-2" :messages="$errors->get('fecha_nacimiento')" />
                        </div>
                        <div>
                            <x-input-label for="peso" value="Peso (kg)" />
                            <x-text-input id="peso" name="peso" type="number" step="0.01" class="mt-1 block w-full" :value="old('peso')" />
                            <x-input-error class="mt-2" :messages="$errors->get('peso')" />
                        </div>
                        <div>
                            <x-input-label for="procedencia" value="Procedencia" />
                            <x-text-input id="procedencia" name="procedencia" type="text" class="mt-1 block w-full" :value="old('procedencia')" placeholder="Ej: Granja XYZ" />
                            <x-input-error class="mt-2" :messages="$errors->get('procedencia')" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="notas" value="Notas" />
                        <textarea id="notas" name="notas" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500">{{ old('notas') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('notas')" />
                    </div>

                    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end">
                        <a href="{{ route('verracos.index') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition hover:bg-gray-50">Cancelar</a>
                        <x-primary-button>Guardar Verraco</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
