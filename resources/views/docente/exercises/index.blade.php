<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ejercicios de: {{ $lesson->titulo }}
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
                <a href="{{ route('docente.courses.lessons.exercises.create', [$course, $lesson]) }}" class="bg-blue-500 text-white px-4 py-2 rounded">
                    + Nuevo Ejercicio
                </a>
                <a href="{{ route('docente.courses.lessons.index', $course) }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded">
                    Volver a Lecciones
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($exercises->isEmpty())
                        <p class="text-gray-500">Esta lección no tiene ejercicios todavía.</p>
                    @else
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b">
                                    <th class="py-2">Orden</th>
                                    <th class="py-2">Pregunta</th>
                                    <th class="py-2">Tipo</th>
                                    <th class="py-2">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($exercises as $exercise)
                                <tr class="border-b">
                                    <td class="py-2">{{ $exercise->orden }}</td>
                                    <td class="py-2">{{ $exercise->pregunta }}</td>
                                    <td class="py-2">
                                        @if($exercise->tipo == 'multiple_choice')
                                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">Múltiple choice</span>
                                        @elseif($exercise->tipo == 'verdadero_falso')
                                            <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-sm">Verdadero/Falso</span>
                                        @else
                                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm">Completar</span>
                                        @endif
                                    </td>
                                    <td class="py-2">
                                        <form action="{{ route('docente.courses.lessons.exercises.destroy', [$course, $lesson, $exercise]) }}" method="POST" onsubmit="return confirm('¿Seguro que querés eliminar este ejercicio?')">
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