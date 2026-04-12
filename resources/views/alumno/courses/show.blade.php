<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $course->titulo }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-4">
                <a href="{{ route('alumno.courses.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded">
                    ← Volver a mis cursos
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <p class="text-gray-600 mb-6">{{ $course->descripcion }}</p>

                    @if($lessons->isEmpty())
                        <p class="text-gray-500">Este curso no tiene lecciones todavía.</p>
                    @else
                        <h3 class="font-semibold text-lg mb-4">Lecciones</h3>
                        <div class="space-y-3">
                            @foreach($lessons as $lesson)
                                <a href="{{ route('alumno.courses.lesson', [$course, $lesson]) }}" class="block border rounded-lg p-4 hover:shadow-md transition">
                                    <div class="flex items-center gap-3">
                                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">{{ $lesson->orden }}</span>
                                        <span class="font-semibold text-gray-800">{{ $lesson->titulo }}</span>
                                        @if($lesson->video_url)
                                            <span class="text-sm text-gray-400">▶ Video disponible</span>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>