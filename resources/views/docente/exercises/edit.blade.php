<x-app-layout>
    <x-slot name="header">
        <h2>✏️ Editar Ejercicio</h2>
        <p style="color: rgba(255,255,255,0.8); font-size: 0.9rem; margin-top: 4px;">{{ $lesson->titulo }} — {{ $course->titulo }}</p>
    </x-slot>

    <div style="padding: 24px;">
        <div style="max-width: 800px; margin: 0 auto;">

            <div style="margin-bottom: 16px;">
                <a href="{{ route('docente.courses.lessons.exercises.index', [$course, $lesson]) }}" style="color: #2563eb; font-weight: 600; text-decoration: none;">← Volver a Ejercicios</a>
            </div>

            <div style="background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 24px;">
                <form action="{{ route('docente.courses.lessons.exercises.update', [$course, $lesson, $exercise]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 6px;">Pregunta</label>
                        <textarea name="pregunta" rows="3" style="width: 100%; border: 2px solid #e5e7eb; border-radius: 10px; padding: 10px 14px; font-size: 1rem;" required>{{ old('pregunta', $exercise->pregunta) }}</textarea>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 6px;">Orden</label>
                        <input type="number" name="orden" value="{{ old('orden', $exercise->orden) }}" style="width: 100%; border: 2px solid #e5e7eb; border-radius: 10px; padding: 10px 14px; font-size: 1rem;">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 6px;">Tipo: 
                            <span style="background: #dbeafe; color: #1d4ed8; padding: 2px 10px; border-radius: 20px; font-size: 0.8rem;">
                                {{ $exercise->tipo == 'multiple_choice' ? 'Múltiple Choice' : ($exercise->tipo == 'verdadero_falso' ? 'Verdadero/Falso' : 'Completar') }}
                            </span>
                        </label>
                    </div>

                    @if($exercise->tipo === 'completar')
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 6px;">Respuesta correcta</label>
                            <input type="text" name="respuesta_correcta" value="{{ old('respuesta_correcta', $exercise->options->first()?->texto) }}"
                                style="width: 100%; border: 2px solid #e5e7eb; border-radius: 10px; padding: 10px 14px; font-size: 1rem;" required>
                        </div>

                    @else
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 12px;">Opciones (marcá la correcta)</label>
                            @foreach($exercise->options as $index => $option)
                                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 10px;">
                                    <input type="radio" name="correcta" value="{{ $index }}" {{ $option->es_correcta ? 'checked' : '' }}>
                                    <input type="text" name="opciones[]" value="{{ old('opciones.' . $index, $option->texto) }}"
                                        style="flex: 1; border: 2px solid #e5e7eb; border-radius: 10px; padding: 10px 14px; font-size: 1rem;"
                                        {{ $exercise->tipo === 'verdadero_falso' ? 'readonly' : '' }}>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div style="display: flex; gap: 12px;">
                        <button type="submit" style="background: linear-gradient(135deg, #2563eb, #0ea5e9); color: white; padding: 12px 28px; border-radius: 10px; font-weight: 700; border: none; cursor: pointer; font-size: 1rem;">
                            💾 Guardar Cambios
                        </button>
                        <a href="{{ route('docente.courses.lessons.exercises.index', [$course, $lesson]) }}" style="background: #e5e7eb; color: #374151; padding: 12px 28px; border-radius: 10px; font-weight: 700; text-decoration: none; font-size: 1rem;">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>