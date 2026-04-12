<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mis Cursos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($courses->isEmpty())
                        <p class="text-gray-500">No tenés cursos asignados todavía.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($courses as $course)
                                <a href="{{ route('alumno.courses.show', $course) }}" class="block border rounded-lg p-4 hover:shadow-md transition">
                                    <h3 class="font-semibold text-lg text-gray-800">{{ $course->titulo }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">{{ $course->materia }} — {{ $course->grado }}</p>
                                    <p class="text-sm text-gray-600 mt-2">{{ $course->descripcion }}</p>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>