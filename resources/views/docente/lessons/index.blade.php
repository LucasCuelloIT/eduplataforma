<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lecciones de: {{ $course->titulo }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4 flex gap-2">
                <a href="{{ route('docente.courses.lessons.create', $course) }}" class="bg-blue-500 text-white px-4 py-2 rounded">
                    + Nueva Lección
                </a>
                <a href="{{ route('docente.courses.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded">
                    Volver a Cursos
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($lessons->isEmpty())
                        <p class="text-gray-500">Este curso no tiene lecciones todavía.</p>
                    @else
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b">
                                    <th class="py-2">Orden</th>
                                    <th class="py-2">Título</th>
                                    <th class="py-2">Video</th>
                                    <th class="py-2">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lessons as $lesson)
                                <tr class="border-b">
                                    <td class="py-2">{{ $lesson->orden }}</td>
                                    <td class="py-2">{{ $lesson->titulo }}</td>
                                    <td class="py-2">
                                        @if($lesson->video_url)
                                            <a href="{{ $lesson->video_url }}" target="_blank" class="text-blue-500 text-sm">Ver video</a>
                                        @else
                                            <span class="text-gray-400 text-sm">Sin video</span>
                                        @endif
                                    </td>
                                    <td class="py-2 flex gap-2">
                                        <a href="{{ route('docente.courses.lessons.edit', [$course, $lesson]) }}" class="bg-yellow-500 text-white px-2 py-1 rounded text-sm">Editar</a>
                                        <form action="{{ route('docente.courses.lessons.destroy', [$course, $lesson]) }}" method="POST" onsubmit="return confirm('¿Seguro que querés eliminar esta lección?')">
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