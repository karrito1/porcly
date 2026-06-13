<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Porcly | Iniciar sesión</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#fcfbf9] text-gray-900 antialiased">
        <div class="absolute inset-x-0 top-0 -z-10 h-80 bg-gradient-to-b from-brand-50 to-transparent"></div>

        <header class="mx-auto flex w-full max-w-7xl items-center justify-between px-5 py-5 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('img/logo_porcly.png') }}" alt="Porcly" class="h-12 w-auto">
                <span class="text-lg font-extrabold tracking-tight text-gray-900">Porcly</span>
            </a>

            <nav class="flex items-center gap-3 text-sm font-semibold">
                @auth
                    <a href="{{ route('dashboard') }}" class="rounded-full bg-gray-900 px-4 py-2 text-white transition hover:bg-gray-700">
                        Ir al dashboard
                    </a>
                @else
                    <a href="#login" class="rounded-full px-4 py-2 text-gray-700 transition hover:bg-white hover:text-gray-950">
                        Iniciar sesión
                    </a>
                @endauth
            </nav>
        </header>

        <main>
            <section class="mx-auto grid w-full max-w-7xl items-center gap-10 px-5 pb-16 pt-8 sm:px-6 lg:grid-cols-[1.05fr_0.95fr] lg:px-8 lg:pb-24 lg:pt-16">
                <div id="login" class="rounded-[2rem] border border-brand-100 bg-white/95 p-6 shadow-xl shadow-brand-100/50 sm:p-8 lg:p-10">
                    <p class="mb-5 inline-flex rounded-full border border-brand-200 bg-brand-50 px-4 py-2 text-sm font-semibold text-brand-700">
                        Acceso autorizado a Porcly
                    </p>

                    <h1 class="text-3xl font-extrabold tracking-tight text-gray-950 sm:text-4xl lg:text-5xl">
                        Inicia sesión para gestionar tu granja porcina.
                    </h1>

                    <p class="mt-4 text-sm leading-6 text-gray-600 sm:text-base">
                        Las cuentas nuevas son creadas únicamente por administradores desde el panel interno.
                    </p>

                    @if (session('status'))
                        <div class="mt-6 rounded-xl border border-brand-200 bg-brand-50 px-4 py-3 text-sm font-medium text-brand-800">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="mt-7 space-y-5">
                        @csrf

                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-800">Correo electrónico</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="tu@correo.com"
                                class="mt-2 block w-full rounded-xl border-gray-200 bg-white px-4 py-3 text-sm shadow-sm transition focus:border-brand-500 focus:ring-brand-500 @error('email') border-red-500 @enderror"
                            >
                            @error('email')
                                <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-bold text-gray-800">Contraseña</label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="••••••••"
                                class="mt-2 block w-full rounded-xl border-gray-200 bg-white px-4 py-3 text-sm shadow-sm transition focus:border-brand-500 focus:ring-brand-500 @error('password') border-red-500 @enderror"
                            >
                            @error('password')
                                <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex flex-col gap-3 text-sm sm:flex-row sm:items-center sm:justify-between">
                            <label class="inline-flex items-center gap-2 font-medium text-gray-600">
                                <input type="checkbox" name="remember" class="rounded border-gray-300 text-brand-500 focus:ring-brand-500">
                                Recordar sesión
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="font-semibold text-brand-600 transition hover:text-brand-700">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            @endif
                        </div>

                        <button type="submit" class="inline-flex w-full items-center justify-center rounded-full bg-brand-500 px-6 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2">
                            Iniciar sesión
                        </button>
                    </form>
                </div>

                <div class="relative">
                    <div class="absolute -inset-4 rounded-[2rem] bg-brand-100/70 blur-2xl"></div>
                    <div class="relative overflow-hidden rounded-[2rem] border border-brand-100 bg-white p-6 shadow-xl shadow-brand-100/60">
                        <div class="rounded-3xl bg-[#fff8f3] p-5">
                            <div class="flex items-center justify-between border-b border-brand-100 pb-4">
                                <div>
                                    <p class="text-sm font-bold text-gray-950">Resumen productivo</p>
                                    <p class="text-xs text-gray-500">Datos listos para actuar</p>
                                </div>
                                <span class="rounded-full bg-brand-500 px-3 py-1 text-xs font-bold text-white">Activo</span>
                            </div>

                            <div class="mt-5 grid grid-cols-2 gap-3">
                                <div class="rounded-2xl bg-white p-4 shadow-sm">
                                    <p class="text-xs font-semibold text-gray-500">Cerdas</p>
                                    <p class="mt-2 text-3xl font-extrabold text-gray-950">128</p>
                                </div>
                                <div class="rounded-2xl bg-white p-4 shadow-sm">
                                    <p class="text-xs font-semibold text-gray-500">Alertas</p>
                                    <p class="mt-2 text-3xl font-extrabold text-brand-600">14</p>
                                </div>
                            </div>

                            <div class="mt-4 space-y-3">
                                <div class="rounded-2xl bg-white p-4 shadow-sm">
                                    <p class="text-sm font-bold text-gray-900">Partos próximos</p>
                                    <p class="mt-1 text-xs text-gray-500">Seguimiento de fechas estimadas y estado de cada cerda.</p>
                                </div>
                                <div class="rounded-2xl bg-white p-4 shadow-sm">
                                    <p class="text-sm font-bold text-gray-900">Registros rápidos</p>
                                    <p class="mt-1 text-xs text-gray-500">Alimentación, vacunas, tratamientos y destetes en un solo flujo.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="border-t border-gray-100 bg-white/70 px-5 py-10 sm:px-6 lg:px-8">
                <div class="mx-auto grid max-w-7xl gap-4 sm:grid-cols-3">
                    <div class="rounded-3xl border border-gray-100 bg-white p-5">
                        <p class="font-bold text-gray-950">Acceso controlado</p>
                        <p class="mt-2 text-sm leading-6 text-gray-600">Los visitantes solo pueden iniciar sesión con cuentas previamente autorizadas.</p>
                    </div>
                    <div class="rounded-3xl border border-gray-100 bg-white p-5">
                        <p class="font-bold text-gray-950">Gestión interna</p>
                        <p class="mt-2 text-sm leading-6 text-gray-600">La creación de usuarios queda disponible dentro del sistema para perfiles con permiso.</p>
                    </div>
                    <div class="rounded-3xl border border-gray-100 bg-white p-5">
                        <p class="font-bold text-gray-950">Alertas visuales</p>
                        <p class="mt-2 text-sm leading-6 text-gray-600">Confirmaciones consistentes en la esquina inferior derecha.</p>
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>
