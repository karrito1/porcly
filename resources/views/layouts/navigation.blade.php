<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-16 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Panel de control
                    </x-nav-link>
                    <x-nav-link :href="route('cerdas.index')" :active="request()->routeIs('cerdas.*')">
                        {{ __('Cerdas') }}
                    </x-nav-link>
                    <x-nav-link :href="route('inseminaciones.index')" :active="request()->routeIs('inseminaciones.*')">
                        {{ __('Inseminaciones') }}
                    </x-nav-link>
                    <x-nav-link :href="route('partos.index')" :active="request()->routeIs('partos.*')">
                        {{ __('Partos') }}
                    </x-nav-link>
                    @can('users.create')
                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                            {{ __('Usuarios') }}
                        </x-nav-link>
                    @endcan
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
Perfil
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
Cerrar sesión
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button id="mobile-menu-button" @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path id="hamburger-icon-lines" :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path id="hamburger-icon-close" :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div id="mobile-menu"
         x-show="open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="sm:hidden relative overflow-hidden bg-brand-50/90 backdrop-blur-md shadow-lg rounded-b-3xl border-b border-brand-200"
         style="display: none;">
         
        <!-- SVG Wave Background -->
        <div class="absolute bottom-0 left-0 w-full pointer-events-none" style="z-index: 0;">
            <svg viewBox="0 0 1440 320" class="w-full h-auto text-brand-400 fill-current opacity-20" xmlns="http://www.w3.org/2000/svg">
                <path fill-opacity="0.5" d="M0,160L48,170.7C96,181,192,203,288,192C384,181,480,139,576,144C672,149,768,203,864,224C960,245,1056,235,1152,202.7C1248,171,1344,117,1392,90.7L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
                <path d="M0,224L48,213.3C96,203,192,181,288,186.7C384,192,480,224,576,213.3C672,203,768,149,864,138.7C960,128,1056,160,1152,181.3C1248,203,1344,213,1392,218.7L1440,224L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div>

        <div class="relative z-10 pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Panel de control
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('cerdas.index')" :active="request()->routeIs('cerdas.*')">
                {{ __('Cerdas') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('inseminaciones.index')" :active="request()->routeIs('inseminaciones.*')">
                {{ __('Inseminaciones') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('partos.index')" :active="request()->routeIs('partos.*')">
                {{ __('Partos') }}
            </x-responsive-nav-link>
            @can('users.create')
                <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                    {{ __('Usuarios') }}
                </x-responsive-nav-link>
            @endcan
        </div>

        <!-- Responsive Settings Options -->
        <div class="relative z-10 pt-4 pb-4 border-t border-brand-200/50 bg-white/40">
            <div class="px-4">
                <div class="font-medium text-base text-brand-900">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-brand-700">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    Perfil
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        Cerrar sesión
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>

    <!-- Vanilla JS Fallback to ensure the menu works even if Alpine.js fails or is blocked -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const button = document.getElementById('mobile-menu-button');
            const menu = document.getElementById('mobile-menu');
            const lines = document.getElementById('hamburger-icon-lines');
            const closeIcon = document.getElementById('hamburger-icon-close');
            
            if (button && menu) {
                button.addEventListener('click', function (e) {
                    // Prevent default behavior
                    e.preventDefault();
                    
                    // Toggle visibility
                    const isHidden = menu.style.display === 'none' || menu.classList.contains('hidden');
                    
                    if (isHidden) {
                        menu.style.setProperty('display', 'block', 'important');
                        menu.classList.remove('hidden');
                        if (lines) {
                            lines.classList.add('hidden');
                            lines.classList.remove('inline-flex');
                        }
                        if (closeIcon) {
                            closeIcon.classList.remove('hidden');
                            closeIcon.classList.add('inline-flex');
                        }
                    } else {
                        menu.style.setProperty('display', 'none', 'important');
                        menu.classList.add('hidden');
                        if (lines) {
                            lines.classList.remove('hidden');
                            lines.classList.add('inline-flex');
                        }
                        if (closeIcon) {
                            closeIcon.classList.add('hidden');
                            closeIcon.classList.remove('inline-flex');
                        }
                    }
                });
            }
        });
    </script>
</nav>
