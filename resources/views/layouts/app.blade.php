<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-[#fcfbf9]">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow-sm border-b border-gray-100/50">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @php
            $toastType = session('success') ? 'success' : (session('error') ? 'error' : null);
            $toastMessage = session('success') ?? session('error') ?? null;
        @endphp

        @if ($toastType && $toastMessage)
            <div id="toast" data-type="{{ $toastType }}" data-message="{{ $toastMessage }}"
                class="fixed top-4 right-4 z-50 max-w-sm w-full translate-x-full opacity-0 transition-all duration-500 ease-out"
                role="alert"
            >
                <div class="border px-5 py-4 rounded-xl shadow-lg flex items-center gap-3
                    @if($toastType === 'success') bg-emerald-50 border-emerald-200 text-emerald-800
                    @else bg-rose-50 border-rose-200 text-rose-800 @endif
                ">
                    @if($toastType === 'success')
                        <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    @else
                        <svg class="w-5 h-5 text-rose-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    @endif
                    <span class="text-sm font-medium" id="toast-message">{{ $toastMessage }}</span>
                    <button onclick="dismissToast()" class="ml-auto shrink-0 opacity-60 hover:opacity-100 transition-opacity">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <script>
                (function() {
                    var toast = document.getElementById('toast');
                    if (!toast) return;
                    requestAnimationFrame(function() {
                        toast.classList.remove('translate-x-full', 'opacity-0');
                        toast.classList.add('translate-x-0', 'opacity-100');
                    });
                    setTimeout(dismissToast, 5000);
                })();
                function dismissToast() {
                    var toast = document.getElementById('toast');
                    if (!toast) return;
                    toast.classList.remove('translate-x-0', 'opacity-100');
                    toast.classList.add('translate-x-full', 'opacity-0');
                    setTimeout(function() { toast.remove(); }, 500);
                }
            </script>
        @endif

        @stack('scripts')
    </body>
</html>
