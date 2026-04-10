<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear Nuevo Curso
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('docente.courses.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1">Título</label>
                            <input type="text" name="titulo" value="{{ old('titulo') }}" class="w-full border rounded px-3 py-2" required>
                            @error('titulo') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1">Descripción</label>
                            <textarea name="descripcion" rows="3" class="w-full border rounded px-3 py-2">{{ old('descripcion') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1">Materia</label>
                            <select name="materia" class="w-full border rounded px-3 py-2" required>
                                <option value="">Seleccioná una materia</option>
                                <option value="Matemática">Matemática</option>
                                <option value="Lengua">Lengua</option>
                                <option value="Ciencias Naturales">Ciencias Naturales</option>
                                <option value="Ciencias Sociales">Ciencias Sociales</option>
                                <option value="Inglés">Inglés</option>
                                <option value="Historia">Historia</option>
                                <option value="Geografía">Geografía</option>
                                <option value="Física">Física</option>
                                <option value="Química">Química</option>
                                <option value="Biología">Biología</option>
                            </select>
                            @error('materia') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1">Grado</label>
                            <select name="grado" class="w-full border rounded px-3 py-2" required>
                                <option value="">Seleccioná un grado</option>
                                <optgroup label="Primaria">
                                    <option value="1° Primaria">1° Primaria</option>
                                    <option value="2° Primaria">2° Primaria</option>
                                    <option value="3° Primaria">3° Primaria</option>
                                    <option value="4° Primaria">4° Primaria</option>
                                    <option value="5° Primaria">5° Primaria</option>
                                    <option value="6° Primaria">6° Primaria</option>
                                    <option value="7° Primaria">7° Primaria</option>
                                </optgroup>
                                <optgroup label="Secundaria">
                                    <option value="1° Secundaria">1° Secundaria</option>
                                    <option value="2° Secundaria">2° Secundaria</option>
                                    <option value="3° Secundaria">3° Secundaria</option>
                                    <option value="4° Secundaria">4° Secundaria</option>
                                    <option value="5° Secundaria">5° Secundaria</option>
                                    <option value="6° Secundaria">6° Secundaria</option>
                                </optgroup>
                            </select>
                            @error('grado') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Crear Curso</button>
                            <a href="{{ route('docente.courses.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>