@extends('layouts.guest')

@section('title', 'Verificar correo electrónico — Porcly')

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
        <h1 class="auth-heading">Verifica tu correo electrónico</h1>
        <p class="auth-subheading" style="margin-bottom: 1.25rem;">
            ¡Gracias por registrarte! Antes de comenzar, por favor verifica tu correo electrónico haciendo clic en el enlace que te acabamos de enviar. Si no lo recibiste, con gusto te enviaremos otro.
        </p>

        {{-- Status --}}
        @if (session('status') == 'verification-link-sent')
        <div class="alert-success">
            Se ha enviado un nuevo enlace de verificación a la dirección de correo que proporcionaste al registrarte.
        </div>
        @endif

        {{-- Formulario --}}
        <div class="field" style="margin-top: 1.5rem;">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-primary" style="margin-bottom: 1rem;">
                    Reenviar correo de verificación
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" style="text-align: center;">
                @csrf
                <button type="submit" class="link-muted" style="background: none; border: none; cursor: pointer; font-size: 0.8125rem; font-weight: 500;">
                    Cerrar sesión
                </button>
            </form>
        </div>

        <p class="auth-copyright">© {{ date('Y') }} Porcly. Todos los derechos reservados.</p>
    </div>
</div>

@endsection
