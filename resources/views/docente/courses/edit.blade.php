<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Curso
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('docente.courses.update', $course) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1">Título</label>
                            <input type="text" name="titulo" value="{{ old('titulo', $course->titulo) }}" class="w-full border rounded px-3 py-2" required>
                            @error('titulo') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1">Descripción</label>
                            <textarea name="descripcion" rows="3" class="w-full border rounded px-3 py-2">{{ old('descripcion', $course->descripcion) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1">Materia</label>
                            <select name="materia" class="w-full border rounded px-3 py-2" required>
                                <option value="">Seleccioná una materia</option>
                                @foreach(['Matemática','Lengua','Ciencias Naturales','Ciencias Sociales','Inglés','Historia','Geografía','Física','Química','Biología'] as $materia)
                                    <option value="{{ $materia }}" {{ $course->materia == $materia ? 'selected' : '' }}>{{ $materia }}</option>
                                @endforeach
                            </select>
                            @error('materia') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1">Grado</label>
                            <select name="grado" class="w-full border rounded px-3 py-2" required>
                                <option value="">Seleccioná un grado</option>
                                <optgroup label="Primaria">
                                    @foreach(['1° Primaria','2° Primaria','3° Primaria','4° Primaria','5° Primaria','6° Primaria','7° Primaria'] as $grado)
                                        <option value="{{ $grado }}" {{ $course->grado == $grado ? 'selected' : '' }}>{{ $grado }}</option>
                                    @endforeach
                                </optgroup>
                                <optgroup label="Secundaria">
                                    @foreach(['1° Secundaria','2° Secundaria','3° Secundaria','4° Secundaria','5° Secundaria','6° Secundaria'] as $grado)
                                        <option value="{{ $grado }}" {{ $course->grado == $grado ? 'selected' : '' }}>{{ $grado }}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                            @error('grado') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Actualizar Curso</button>
                            <a href="{{ route('docente.courses.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>