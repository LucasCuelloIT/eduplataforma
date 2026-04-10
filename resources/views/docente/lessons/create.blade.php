<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nueva Lección en: {{ $course->titulo }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('docente.courses.lessons.store', $course) }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1">Título</label>
                            <input type="text" name="titulo" value="{{ old('titulo') }}" class="w-full border rounded px-3 py-2" required>
                            @error('titulo') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1">Contenido / Explicación</label>
                            <textarea name="contenido" rows="6" class="w-full border rounded px-3 py-2">{{ old('contenido') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1">URL del Video (YouTube)</label>
                            <input type="url" name="video_url" value="{{ old('video_url') }}" class="w-full border rounded px-3 py-2" placeholder="https://www.youtube.com/watch?v=...">
                            @error('video_url') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1">Orden</label>
                            <input type="number" name="orden" value="{{ old('orden', 0) }}" class="w-full border rounded px-3 py-2">
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Crear Lección</button>
                            <a href="{{ route('docente.courses.lessons.index', $course) }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>