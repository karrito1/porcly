@props([
    'context',
    'prefix',
])

@php
    $reopen = old('cerda_modal') === $context;
@endphp

<div class="grid grid-cols-1 gap-4 md:grid-cols-2">
    <div>
        <x-input-label for="{{ $prefix }}-codigo" value="Código *" />
        <x-text-input
            id="{{ $prefix }}-codigo"
            name="codigo"
            type="text"
            class="mt-1 block w-full"
            :value="$reopen ? old('codigo') : ''"
            required
        />
        <x-input-error class="mt-2" :messages="isset($errors) ? $errors->get('codigo') : []" />
    </div>

    <div>
        <x-input-label for="{{ $prefix }}-nombre" value="Nombre / Apodo" />
        <x-text-input
            id="{{ $prefix }}-nombre"
            name="nombre"
            type="text"
            class="mt-1 block w-full"
            :value="$reopen ? old('nombre') : ''"
        />
        <x-input-error class="mt-2" :messages="isset($errors) ? $errors->get('nombre') : []" />
    </div>

    <div>
        <x-input-label for="{{ $prefix }}-raza" value="Raza" />
        <x-text-input
            id="{{ $prefix }}-raza"
            name="raza"
            type="text"
            class="mt-1 block w-full"
            :value="$reopen ? old('raza') : ''"
        />
        <x-input-error class="mt-2" :messages="isset($errors) ? $errors->get('raza') : []" />
    </div>

    <div>
        <x-input-label for="{{ $prefix }}-estado" value="Estado Productivo *" />
        <select
            id="{{ $prefix }}-estado"
            name="estado"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500"
            required
        >
            <option value="">Selecciona un estado</option>
            <option value="activa" @selected($reopen ? old('estado') === 'activa' : false)>Activa</option>
            <option value="gestante" @selected($reopen ? old('estado') === 'gestante' : false)>Gestante</option>
            <option value="lactante" @selected($reopen ? old('estado') === 'lactante' : false)>Lactante</option>
            <option value="en_celo" @selected($reopen ? old('estado') === 'en_celo' : false)>En Celo</option>
            <option value="descarte" @selected($reopen ? old('estado') === 'descarte' : false)>Descarte</option>
        </select>
        <x-input-error class="mt-2" :messages="isset($errors) ? $errors->get('estado') : []" />
    </div>

    <div>
        <x-input-label for="{{ $prefix }}-fecha_nacimiento" value="Fecha de Nacimiento" />
        <x-text-input
            id="{{ $prefix }}-fecha_nacimiento"
            name="fecha_nacimiento"
            type="date"
            class="mt-1 block w-full"
            :value="$reopen ? old('fecha_nacimiento') : ''"
        />
        <x-input-error class="mt-2" :messages="isset($errors) ? $errors->get('fecha_nacimiento') : []" />
    </div>

    <div>
        <x-input-label for="{{ $prefix }}-peso_actual" value="Peso Actual (kg)" />
        <x-text-input
            id="{{ $prefix }}-peso_actual"
            name="peso_actual"
            type="number"
            step="0.01"
            class="mt-1 block w-full"
            :value="$reopen ? old('peso_actual') : ''"
        />
        <x-input-error class="mt-2" :messages="isset($errors) ? $errors->get('peso_actual') : []" />
    </div>
</div>

<div>
    <x-input-label for="{{ $prefix }}-notas" value="Notas / Observaciones" />
    <textarea
        id="{{ $prefix }}-notas"
        name="notas"
        rows="4"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500"
    >{{ $reopen ? old('notas') : '' }}</textarea>
    <x-input-error class="mt-2" :messages="isset($errors) ? $errors->get('notas') : []" />
</div>
