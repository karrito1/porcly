<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div>
        <x-input-label for="codigo" value="Código *" />
        <x-text-input id="codigo" name="codigo" type="text" class="mt-1 block w-full" required placeholder="Ej: V-001" />
        <x-input-error class="mt-2" :messages="$errors->get('codigo')" />
    </div>
    <div>
        <x-input-label for="nombre" value="Nombre" />
        <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" placeholder="Opcional" />
        <x-input-error class="mt-2" :messages="$errors->get('nombre')" />
    </div>
    <div>
        <x-input-label for="raza" value="Raza" />
        <x-text-input id="raza" name="raza" type="text" class="mt-1 block w-full" placeholder="Ej: Duroc" />
        <x-input-error class="mt-2" :messages="$errors->get('raza')" />
    </div>
    <div>
        <x-input-label for="fecha_nacimiento" value="Fecha de Nacimiento" />
        <x-text-input id="fecha_nacimiento" name="fecha_nacimiento" type="date" class="mt-1 block w-full" />
        <x-input-error class="mt-2" :messages="$errors->get('fecha_nacimiento')" />
    </div>
    <div>
        <x-input-label for="peso" value="Peso (kg)" />
        <x-text-input id="peso" name="peso" type="number" step="0.01" class="mt-1 block w-full" />
        <x-input-error class="mt-2" :messages="$errors->get('peso')" />
    </div>
    <div>
        <x-input-label for="procedencia" value="Procedencia" />
        <x-text-input id="procedencia" name="procedencia" type="text" class="mt-1 block w-full" placeholder="Ej: Granja XYZ" />
        <x-input-error class="mt-2" :messages="$errors->get('procedencia')" />
    </div>
</div>

<div>
    <x-input-label for="notas" value="Notas" />
    <textarea id="notas" name="notas" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500"></textarea>
    <x-input-error class="mt-2" :messages="$errors->get('notas')" />
</div>
