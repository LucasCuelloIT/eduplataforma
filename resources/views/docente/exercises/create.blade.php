<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nuevo Ejercicio en: {{ $lesson->titulo }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('docente.courses.lessons.exercises.store', [$course, $lesson]) }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1">Pregunta</label>
                            <textarea name="pregunta" rows="3" class="w-full border rounded px-3 py-2" required>{{ old('pregunta') }}</textarea>
                            @error('pregunta') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1">Tipo de ejercicio</label>
                            <select name="tipo" id="tipo" class="w-full border rounded px-3 py-2" required onchange="mostrarOpciones()">
                                <option value="">Seleccioná un tipo</option>
                                <option value="multiple_choice" {{ old('tipo') == 'multiple_choice' ? 'selected' : '' }}>Múltiple Choice</option>
                                <option value="verdadero_falso" {{ old('tipo') == 'verdadero_falso' ? 'selected' : '' }}>Verdadero / Falso</option>
                                <option value="completar" {{ old('tipo') == 'completar' ? 'selected' : '' }}>Completar el espacio</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1">Orden</label>
                            <input type="number" name="orden" value="{{ old('orden', 0) }}" class="w-full border rounded px-3 py-2">
                        </div>

                        <!-- Múltiple choice -->
                        <div id="opciones_multiple" class="hidden mb-4">
                            <label class="block text-gray-700 mb-2">Opciones (marcá la correcta)</label>
                            @for($i = 0; $i < 4; $i++)
                                <div class="flex items-center gap-2 mb-2">
                                    <input type="radio" name="correcta" value="{{ $i }}" class="mt-1">
                                    <input type="text" name="opciones[]" placeholder="Opción {{ $i + 1 }}" class="w-full border rounded px-3 py-2">
                                </div>
                            @endfor
                        </div>

                        <!-- Verdadero/Falso -->
                        <div id="opciones_vf" class="hidden mb-4">
                            <label class="block text-gray-700 mb-2">¿Cuál es la respuesta correcta?</label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="correcta" value="0"> Verdadero
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="correcta" value="1"> Falso
                                </label>
                            </div>
                            <input type="hidden" name="opciones[]" value="Verdadero">
                            <input type="hidden" name="opciones[]" value="Falso">
                        </div>

                        <!-- Completar -->
                        <div id="opciones_completar" class="hidden mb-4">
                            <label class="block text-gray-700 mb-1">Respuesta correcta</label>
                            <input type="text" name="respuesta_correcta" placeholder="Escribí la respuesta correcta" class="w-full border rounded px-3 py-2">
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Crear Ejercicio</button>
                            <a href="{{ route('docente.courses.lessons.exercises.index', [$course, $lesson]) }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function mostrarOpciones() {
            const tipo = document.getElementById('tipo').value;
            document.getElementById('opciones_multiple').classList.add('hidden');
            document.getElementById('opciones_vf').classList.add('hidden');
            document.getElementById('opciones_completar').classList.add('hidden');

            if (tipo === 'multiple_choice') {
                document.getElementById('opciones_multiple').classList.remove('hidden');
            } else if (tipo === 'verdadero_falso') {
                document.getElementById('opciones_vf').classList.remove('hidden');
            } else if (tipo === 'completar') {
                document.getElementById('opciones_completar').classList.remove('hidden');
            }
        }

        // Ejecutar al cargar si hay un valor seleccionado
        window.onload = mostrarOpciones;
    </script>
</x-app-layout>