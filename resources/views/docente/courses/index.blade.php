<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mis Cursos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4">
                <a href="{{ route('docente.courses.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
                    + Nuevo Curso
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($courses->isEmpty())
                        <p class="text-gray-500">No tenés cursos creados todavía.</p>
                    @else
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b">
                                    <th class="py-2">Título</th>
                                    <th class="py-2">Materia</th>
                                    <th class="py-2">Grado</th>
                                    <th class="py-2">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($courses as $course)
                                <tr class="border-b">
                                    <td class="py-2">{{ $course->titulo }}</td>
                                    <td class="py-2">{{ $course->materia }}</td>
                                    <td class="py-2">{{ $course->grado }}</td>
                                    <td class="py-2 flex gap-2">
                                        <a href="{{ route('docente.courses.edit', $course) }}" class="bg-yellow-500 text-white px-2 py-1 rounded text-sm">Editar</a>
                                        <form action="{{ route('docente.courses.destroy', $course) }}" method="POST" onsubmit="return confirm('¿Seguro que querés eliminar este curso?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded text-sm">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>