@extends('layouts.guest')

@section('title', 'Iniciar sesión — Porcly')

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
        <h1 class="auth-heading">Bienvenido de nuevo</h1>
        <p class="auth-subheading">Inicia sesión para continuar en Porcly</p>

        {{-- Status --}}
        @if (session('status'))
        <div class="alert-success">{{ session('status') }}</div>
        @endif

        {{-- Formulario --}}
        <form method="POST" action="{{ route('login') }}">
            @csrf

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
                        value="{{ old('email') }}"
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

            {{-- Remember + Forgot --}}
            <div class="field-row">
                <div class="remember-wrap">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Recordar sesión</label>
                </div>
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="link-muted">
                    ¿Olvidaste tu contraseña?
                </a>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">
                Iniciar sesión
            </button>
        </form>

        <p class="auth-footer">
            Las cuentas nuevas son creadas únicamente por administradores.
        </p>

        <p class="auth-copyright">© {{ date('Y') }} Porcly. Todos los derechos reservados.</p>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/auth/togglePassword.js') }}"></script>
@endpush

@endsection
