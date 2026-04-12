<x-app-layout>
    <x-slot name="header">
        <h2>🛠️ Panel Administrador</h2>
    </x-slot>

    <div style="padding: 24px;">
        <div style="max-width: 1200px; margin: 0 auto;">

            <!-- Stats -->
            <div style="display: flex; gap: 16px; margin-bottom: 24px;">
                <div style="background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 24px; flex: 1; display: flex; align-items: center; gap: 16px;">
                    <span style="font-size: 2.5rem;">👥</span>
                    <div>
                        <p style="color: #6b7280; font-size: 0.85rem;">Total Usuarios</p>
                        <p style="color: #2563eb; font-size: 1.8rem; font-weight: 800;">{{ \App\Models\User::count() }}</p>
                    </div>
                </div>
                <div style="background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 24px; flex: 1; display: flex; align-items: center; gap: 16px;">
                    <span style="font-size: 2.5rem;">⏳</span>
                    <div>
                        <p style="color: #6b7280; font-size: 0.85rem;">Pendientes de Aprobación</p>
                        <p style="color: #d97706; font-size: 1.8rem; font-weight: 800;">{{ \App\Models\User::where('estado', 'pendiente')->count() }}</p>
                    </div>
                </div>
                <div style="background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 24px; flex: 1; display: flex; align-items: center; gap: 16px;">
                    <span style="font-size: 2.5rem;">📚</span>
                    <div>
                        <p style="color: #6b7280; font-size: 0.85rem;">Total Cursos</p>
                        <p style="color: #16a34a; font-size: 1.8rem; font-weight: 800;">{{ \App\Models\Course::count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Accesos rápidos -->
            <div style="background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 24px;">
                <h3 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 16px;">⚡ Accesos rápidos</h3>
                <div style="display: flex; gap: 16px;">
                    <a href="{{ route('admin.users.index') }}" style="background: linear-gradient(135deg, #2563eb, #0ea5e9); color: white; padding: 16px 24px; border-radius: 12px; text-decoration: none; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                        👥 Gestionar Usuarios
                    </a>
                    <a href="{{ route('admin.courses.assign') }}" style="background: linear-gradient(135deg, #16a34a, #22c55e); color: white; padding: 16px 24px; border-radius: 12px; text-decoration: none; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                        📚 Asignar Cursos
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>