@extends('layouts.guest')

@section('title', 'Confirmar contraseña — Porcly')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endpush

@section('content')

<div class="auth-page">
    <div class="auth-card">

        {{-- Logo --}}
        <div class="auth-logo">
            <img src="{{ asset('img/logo_porcly.png') }}" alt="Porcly">
        </div>

        {{-- Encabezado --}}
        <h1 class="auth-heading">Confirma tu contraseña</h1>
        <p class="auth-subheading" style="margin-bottom: 1.25rem;">
            Esta es un área segura de la aplicación. Por favor, confirma tu contraseña antes de continuar.
        </p>

        {{-- Formulario --}}
        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            {{-- Password --}}
            <div class="field">
                <label for="password" class="field-label">Contraseña</label>
                <div class="field-input-wrap">
                    <svg class="field-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                        <rect x="3" y="7" width="10" height="7" rx="1.5" />
                        <path d="M5 7V5a3 3 0 016 0v2" stroke-linecap="round" />
                    </svg>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="field-input @error('password') is-invalid @enderror"
                        placeholder="••••••••"
                        required
                        autocomplete="current-password" />
                    <button type="button" class="pwd-toggle" onclick="togglePassword(this)" aria-label="Mostrar contraseña">
                        <svg id="eye-icon" width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M1 8s2.5-5 7-5 7 5 7 5-2.5 5-7 5-7-5-7-5z" />
                            <circle cx="8" cy="8" r="2" />
                        </svg>
                    </button>
                </div>
                @error('password')
                <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary" style="margin-top: 1.5rem;">
                Confirmar contraseña
            </button>
        </form>

        <p class="auth-copyright">© {{ date('Y') }} Porcly. Todos los derechos reservados.</p>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/auth/togglePassword.js') }}"></script>
@endpush

@endsection
