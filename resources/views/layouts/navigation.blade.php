<nav style="background: linear-gradient(135deg, #2563eb 0%, #0ea5e9 100%);">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 24px;">
        <div style="display: flex; justify-content: space-between; align-items: center; height: 64px;">
            
            <!-- Logo + Links -->
            <div style="display: flex; align-items: center; gap: 32px;">
                <a href="{{ route('dashboard') }}" style="display: flex; align-items: center; gap: 8px; text-decoration: none;">
                    <span style="font-size: 1.6rem;">🎓</span>
                    <span style="color: white; font-weight: 800; font-size: 1.2rem;">EduPlataforma</span>
                </a>

                <div style="display: flex; gap: 4px;">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" style="color: white; font-weight: 600; padding: 8px 14px; border-radius: 8px; text-decoration: none; font-size: 0.9rem;">🏠 Inicio</a>
                            <a href="{{ route('admin.users.index') }}" style="color: white; font-weight: 600; padding: 8px 14px; border-radius: 8px; text-decoration: none; font-size: 0.9rem;">👥 Usuarios</a>
                            <a href="{{ route('admin.courses.assign') }}" style="color: white; font-weight: 600; padding: 8px 14px; border-radius: 8px; text-decoration: none; font-size: 0.9rem;">📚 Asignar Cursos</a>
                        @elseif(auth()->user()->role === 'docente')
                            <a href="{{ route('docente.dashboard') }}" style="color: white; font-weight: 600; padding: 8px 14px; border-radius: 8px; text-decoration: none; font-size: 0.9rem;">🏠 Inicio</a>
                            <a href="{{ route('docente.courses.index') }}" style="color: white; font-weight: 600; padding: 8px 14px; border-radius: 8px; text-decoration: none; font-size: 0.9rem;">📚 Mis Cursos</a>
                            <a href="{{ route('docente.reports.index') }}" style="color: white; font-weight: 600; padding: 8px 14px; border-radius: 8px; text-decoration: none; font-size: 0.9rem;">📊 Reportes</a>
                        @elseif(auth()->user()->role === 'alumno')
                            <a href="{{ route('alumno.dashboard') }}" style="color: white; font-weight: 600; padding: 8px 14px; border-radius: 8px; text-decoration: none; font-size: 0.9rem;">🏠 Inicio</a>
                            <a href="{{ route('alumno.courses.index') }}" style="color: white; font-weight: 600; padding: 8px 14px; border-radius: 8px; text-decoration: none; font-size: 0.9rem;">📚 Mis Cursos</a>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Usuario dropdown -->
            <div style="position: relative;">
                <button onclick="toggleMenu()" style="display: flex; align-items: center; gap: 8px; padding: 8px 12px; border-radius: 10px; background: rgba(255,255,255,0.15); border: none; cursor: pointer;">
                    <span style="background: white; color: #2563eb; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.9rem;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </span>
                    <span style="color: white; font-size: 0.9rem; font-weight: 600;">{{ Auth::user()->name }}</span>
                    <svg style="fill: white; width: 16px; height: 16px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>

                <div id="userMenu" style="display: none; position: absolute; top: 52px; right: 0; background: white; border-radius: 12px; box-shadow: 0 8px 30px rgba(0,0,0,0.15); min-width: 180px; z-index: 999; overflow: hidden;">
                    <a href="{{ route('profile.edit') }}" style="display: block; padding: 12px 16px; color: #374151; text-decoration: none; font-weight: 600; font-size: 0.9rem; border-bottom: 1px solid #f1f5f9;">
                        👤 Mi Perfil
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" style="display: block; width: 100%; text-align: left; padding: 12px 16px; color: #dc2626; font-weight: 600; font-size: 0.9rem; background: none; border: none; cursor: pointer;">
                            🚪 Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        function toggleMenu() {
            const menu = document.getElementById('userMenu');
            menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
        }

        document.addEventListener('click', function(e) {
            const menu = document.getElementById('userMenu');
            if (menu && !e.target.closest('button[onclick="toggleMenu()"]')) {
                menu.style.display = 'none';
            }
        });
    </script>
</nav>