<nav x-data="{ open: false }" style="background: linear-gradient(135deg, #2563eb 0%, #0ea5e9 100%);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <span style="font-size: 1.6rem;">🎓</span>
                    <span style="color: white; font-weight: 800; font-size: 1.2rem; letter-spacing: -0.5px;">EduPlataforma</span>
                </a>

                <!-- Links según rol -->
                <div class="hidden sm:flex sm:items-center sm:ms-10 space-x-2">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="text-white text-sm font-600 px-3 py-2 rounded-lg hover:bg-white hover:bg-opacity-20 transition">🏠 Inicio</a>
                            <a href="{{ route('admin.users.index') }}" class="text-white text-sm font-600 px-3 py-2 rounded-lg hover:bg-white hover:bg-opacity-20 transition">👥 Usuarios</a>
                            <a href="{{ route('admin.courses.assign') }}" class="text-white text-sm font-600 px-3 py-2 rounded-lg hover:bg-white hover:bg-opacity-20 transition">📚 Asignar Cursos</a>
                        @elseif(auth()->user()->role === 'docente')
                            <a href="{{ route('docente.dashboard') }}" class="text-white text-sm font-600 px-3 py-2 rounded-lg hover:bg-white hover:bg-opacity-20 transition">🏠 Inicio</a>
                            <a href="{{ route('docente.courses.index') }}" class="text-white text-sm font-600 px-3 py-2 rounded-lg hover:bg-white hover:bg-opacity-20 transition">📚 Mis Cursos</a>
                        @elseif(auth()->user()->role === 'alumno')
                            <a href="{{ route('alumno.dashboard') }}" class="text-white text-sm font-600 px-3 py-2 rounded-lg hover:bg-white hover:bg-opacity-20 transition">🏠 Inicio</a>
                            <a href="{{ route('alumno.courses.index') }}" class="text-white text-sm font-600 px-3 py-2 rounded-lg hover:bg-white hover:bg-opacity-20 transition">📚 Mis Cursos</a>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Usuario -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-white hover:bg-opacity-20 transition">
                            <span style="background: white; color: #2563eb; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                            <span class="text-white text-sm font-semibold">{{ Auth::user()->name }}</span>
                            <svg class="fill-current h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            👤 {{ __('Mi Perfil') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                🚪 {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:bg-white hover:bg-opacity-20 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden" style="background: rgba(0,0,0,0.2);">
        <div class="pt-2 pb-3 space-y-1 px-4">
            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="block text-white py-2">🏠 Inicio</a>
                    <a href="{{ route('admin.users.index') }}" class="block text-white py-2">👥 Usuarios</a>
                    <a href="{{ route('admin.courses.assign') }}" class="block text-white py-2">📚 Asignar Cursos</a>
                @elseif(auth()->user()->role === 'docente')
                    <a href="{{ route('docente.dashboard') }}" class="block text-white py-2">🏠 Inicio</a>
                    <a href="{{ route('docente.courses.index') }}" class="block text-white py-2">📚 Mis Cursos</a>
                @elseif(auth()->user()->role === 'alumno')
                    <a href="{{ route('alumno.dashboard') }}" class="block text-white py-2">🏠 Inicio</a>
                    <a href="{{ route('alumno.courses.index') }}" class="block text-white py-2">📚 Mis Cursos</a>
                @endif
            @endauth
        </div>

        <div class="pt-4 pb-3 border-t border-white border-opacity-20 px-4">
            <div class="text-white font-semibold">{{ Auth::user()->name }}</div>
            <div class="text-blue-200 text-sm">{{ Auth::user()->email }}</div>
            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.edit') }}" class="block text-white py-2">👤 Mi Perfil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block text-white py-2">🚪 Cerrar Sesión</button>
                </form>
            </div>
        </div>
    </div>
</nav>