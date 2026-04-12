<x-app-layout>
    <x-slot name="header">
        <h2>✏️ Editar Usuario: {{ $user->name }}</h2>
    </x-slot>

    <div style="padding: 24px;">
        <div style="max-width: 600px; margin: 0 auto;">

            <div style="margin-bottom: 16px;">
                <a href="{{ route('admin.users.index') }}" style="color: #2563eb; font-weight: 600; text-decoration: none;">← Volver a Usuarios</a>
            </div>

            <div style="background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 24px;">
                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 6px;">Nombre</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            style="width: 100%; border: 2px solid #e5e7eb; border-radius: 10px; padding: 10px 14px; font-size: 1rem;">
                        @error('name') <p style="color: #dc2626; font-size: 0.85rem; margin-top: 4px;">{{ $message }}</p> @enderror
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 6px;">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            style="width: 100%; border: 2px solid #e5e7eb; border-radius: 10px; padding: 10px 14px; font-size: 1rem;">
                        @error('email') <p style="color: #dc2626; font-size: 0.85rem; margin-top: 4px;">{{ $message }}</p> @enderror
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 6px;">Nueva Contraseña <span style="color: #9ca3af; font-weight: 400;">(dejá vacío para no cambiar)</span></label>
                        <input type="password" name="password"
                            style="width: 100%; border: 2px solid #e5e7eb; border-radius: 10px; padding: 10px 14px; font-size: 1rem;">
                        @error('password') <p style="color: #dc2626; font-size: 0.85rem; margin-top: 4px;">{{ $message }}</p> @enderror
                    </div>

                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 6px;">Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation"
                            style="width: 100%; border: 2px solid #e5e7eb; border-radius: 10px; padding: 10px 14px; font-size: 1rem;">
                    </div>

                    <div style="display: flex; gap: 12px;">
                        <button type="submit" style="background: linear-gradient(135deg, #2563eb, #0ea5e9); color: white; padding: 12px 28px; border-radius: 10px; font-weight: 700; border: none; cursor: pointer; font-size: 1rem;">
                            💾 Guardar Cambios
                        </button>
                        <a href="{{ route('admin.users.index') }}" style="background: #e5e7eb; color: #374151; padding: 12px 28px; border-radius: 10px; font-weight: 700; text-decoration: none; font-size: 1rem;">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>