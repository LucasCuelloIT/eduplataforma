<x-app-layout>
    <x-slot name="header">
        <h2>👥 Gestión de Usuarios</h2>
    </x-slot>

    <div style="padding: 24px;">
        <div style="max-width: 1200px; margin: 0 auto;">

            @if(session('success'))
                <div style="background: #dcfce7; border: 1px solid #86efac; color: #15803d; padding: 12px 16px; border-radius: 12px; margin-bottom: 16px; font-weight: 600;">
                    ✅ {{ session('success') }}
                </div>
            @endif
<div style="margin-bottom: 16px;">
    <a href="{{ route('admin.dashboard') }}" style="color: #2563eb; font-weight: 600; text-decoration: none;">← Volver al Dashboard</a>
</div>
            <div style="background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 24px;">
                @foreach($users as $user)
                    <div style="display: flex; align-items: center; gap: 16px; border-bottom: 2px solid #f1f5f9; padding: 16px 0;">
                        
                        <!-- Avatar -->
                        <div style="background: linear-gradient(135deg, #2563eb, #0ea5e9); color: white; width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.1rem; flex-shrink: 0;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>

                        <!-- Info -->
                        <div style="flex: 1;">
                            <p style="font-weight: 700; color: #1e293b;">{{ $user->name }}</p>
                            <p style="color: #6b7280; font-size: 0.85rem;">{{ $user->email }}</p>
                        </div>

                        <!-- Estado -->
                        <div>
                            @if($user->estado == 'pendiente')
                                <span style="background: #fef9c3; color: #a16207; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">⏳ Pendiente</span>
                            @else
                                <span style="background: #dcfce7; color: #15803d; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">✅ Aprobado</span>
                            @endif
                        </div>

                        <!-- Rol -->
                        <form action="{{ route('admin.users.cambiarRol', $user) }}" method="POST" style="display: flex; gap: 8px; align-items: center;">
                            @csrf
                            @method('PATCH')
                            <select name="role" style="border: 2px solid #e5e7eb; border-radius: 8px; padding: 6px 12px; font-size: 0.85rem; color: #1e293b;">
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>🛠️ Admin</option>
                                <option value="docente" {{ $user->role == 'docente' ? 'selected' : '' }}>👨‍🏫 Docente</option>
                                <option value="alumno" {{ $user->role == 'alumno' ? 'selected' : '' }}>🎓 Alumno</option>
                            </select>
                            <button type="submit" style="background: linear-gradient(135deg, #2563eb, #0ea5e9); color: white; padding: 6px 14px; border-radius: 8px; font-weight: 600; font-size: 0.85rem; border: none; cursor: pointer;">
                                Guardar
                            </button>
                        </form>

                        <!-- Acciones -->
                        <div style="display: flex; gap: 8px;">
    <a href="{{ route('admin.users.edit', $user) }}" style="background: linear-gradient(135deg, #d97706, #f59e0b); color: white; padding: 6px 14px; border-radius: 8px; font-weight: 600; font-size: 0.85rem; text-decoration: none;">
        ✏️ Editar
    </a>
    @if($user->estado == 'pendiente')
                                <form action="{{ route('admin.users.aprobar', $user) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" style="background: linear-gradient(135deg, #16a34a, #22c55e); color: white; padding: 6px 14px; border-radius: 8px; font-weight: 600; font-size: 0.85rem; border: none; cursor: pointer;">
                                        ✅ Aprobar
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('¿Seguro que querés eliminar este usuario?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: linear-gradient(135deg, #dc2626, #ef4444); color: white; padding: 6px 14px; border-radius: 8px; font-weight: 600; font-size: 0.85rem; border: none; cursor: pointer;">
                                    🗑️
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>