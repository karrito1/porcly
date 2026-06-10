@extends('layouts.guest')

@section('title', 'Restablecer contraseña — Porcly')

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
        <h1 class="auth-heading">Restablece tu contraseña</h1>
        <p class="auth-subheading">Ingresa tus nuevos datos de acceso para continuar</p>

        {{-- Formulario --}}
        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            {{-- Email --}}
            <div class="field">
                <label for="email" class="field-label">Correo electrónico</label>
                <div class="field-input-wrap">
                    <svg class="field-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                        <rect x="1" y="3" width="14" height="10" rx="2" />
                        <path d="M1 5.5l7 4.5 7-4.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="field-input @error('email') is-invalid @enderror"
                        placeholder="tu@correo.com"
                        value="{{ old('email', $request->email) }}"
                        required
                        autofocus
                        autocomplete="username" />
                </div>
                @error('email')
                <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Password --}}
            <div class="field">
                <label for="password" class="field-label">Nueva contraseña</label>
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
                        autocomplete="new-password" />
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

            {{-- Confirm Password --}}
            <div class="field">
                <label for="password_confirmation" class="field-label">Confirmar contraseña</label>
                <div class="field-input-wrap">
                    <svg class="field-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5">
                        <rect x="3" y="7" width="10" height="7" rx="1.5" />
                        <path d="M5 7V5a3 3 0 016 0v2" stroke-linecap="round" />
                    </svg>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="field-input"
                        placeholder="••••••••"
                        required
                        autocomplete="new-password" />
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="margin-top: 1.5rem;">
                Restablecer contraseña
            </button>
        </form>

        <p class="auth-copyright">© {{ date('Y') }} Porcly. Todos los derechos reservados.</p>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/auth/togglePassword.js') }}"></script>
@endpush

@endsection
