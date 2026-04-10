<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestión de Usuarios
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b">
                                <th class="py-2">Nombre</th>
                                <th class="py-2">Email</th>
                                <th class="py-2">Rol</th>
                                <th class="py-2">Estado</th>
                                <th class="py-2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr class="border-b">
                                <td class="py-2">{{ $user->name }}</td>
                                <td class="py-2">{{ $user->email }}</td>
                                <td class="py-2">
                                    <form action="{{ route('admin.users.cambiarRol', $user) }}" method="POST" class="flex gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role" class="border rounded px-2 py-1 text-sm">
                                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="docente" {{ $user->role == 'docente' ? 'selected' : '' }}>Docente</option>
                                            <option value="alumno" {{ $user->role == 'alumno' ? 'selected' : '' }}>Alumno</option>
                                        </select>
                                        <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded text-sm">Guardar</button>
                                    </form>
                                </td>
                                <td class="py-2">
                                    @if($user->estado == 'pendiente')
                                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm">Pendiente</span>
                                    @else
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">Aprobado</span>
                                    @endif
                                </td>
                                <td class="py-2 flex gap-2">
                                    @if($user->estado == 'pendiente')
                                        <form action="{{ route('admin.users.aprobar', $user) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded text-sm">Aprobar</button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('¿Seguro que querés eliminar este usuario?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded text-sm">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>