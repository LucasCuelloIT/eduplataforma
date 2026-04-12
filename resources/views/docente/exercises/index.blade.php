<x-app-layout>
    <x-slot name="header">
        <h2>❓ Ejercicios de: {{ $lesson->titulo }}</h2>
        <p style="color: rgba(255,255,255,0.8); font-size: 0.9rem; margin-top: 4px;">{{ $course->titulo }}</p>
    </x-slot>

    <div style="padding: 24px;">
        <div style="max-width: 1200px; margin: 0 auto;">

            @if(session('success'))
                <div style="background: #dcfce7; border: 1px solid #86efac; color: #15803d; padding: 12px 16px; border-radius: 12px; margin-bottom: 16px; font-weight: 600;">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <div style="margin-bottom: 16px;">
                <a href="{{ route('docente.courses.lessons.index', $course) }}" style="color: #2563eb; font-weight: 600; text-decoration: none;">← Volver a Lecciones</a>
            </div>

            <div style="margin-bottom: 20px;">
                <a href="{{ route('docente.courses.lessons.exercises.create', [$course, $lesson]) }}" style="background: linear-gradient(135deg, #2563eb, #0ea5e9); color: white; padding: 12px 24px; border-radius: 12px; text-decoration: none; font-weight: 700;">
                    + Nuevo Ejercicio
                </a>
            </div>

            <div style="background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 24px;">
                @if($exercises->isEmpty())
                    <p style="color: #9ca3af;">Esta lección no tiene ejercicios todavía.</p>
                @else
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        @foreach($exercises as $exercise)
                            <div style="border: 2px solid #e5e7eb; border-radius: 12px; padding: 16px; display: flex; align-items: center; gap: 16px;">
                                <div style="background: linear-gradient(135deg, #2563eb, #0ea5e9); color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; flex-shrink: 0;">
                                    {{ $exercise->orden }}
                                </div>
                                <div style="flex: 1;">
                                    <p style="font-weight: 700; color: #1e293b; margin-bottom: 4px;">{{ $exercise->pregunta }}</p>
                                    <div>
                                        @if($exercise->tipo == 'multiple_choice')
                                            <span style="background: #dbeafe; color: #1d4ed8; padding: 2px 10px; border-radius: 20px; font-size: 0.78rem; font-weight: 600;">Múltiple Choice</span>
                                        @elseif($exercise->tipo == 'verdadero_falso')
                                            <span style="background: #f3e8ff; color: #7e22ce; padding: 2px 10px; border-radius: 20px; font-size: 0.78rem; font-weight: 600;">Verdadero/Falso</span>
                                        @else
                                            <span style="background: #fef9c3; color: #a16207; padding: 2px 10px; border-radius: 20px; font-size: 0.78rem; font-weight: 600;">Completar</span>
                                        @endif
                                    </div>
                                </div>
                                <form action="{{ route('docente.courses.lessons.exercises.destroy', [$course, $lesson, $exercise]) }}" method="POST" onsubmit="return confirm('¿Seguro?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: linear-gradient(135deg, #dc2626, #ef4444); color: white; padding: 8px 16px; border-radius: 8px; font-weight: 600; font-size: 0.85rem; border: none; cursor: pointer;">
                                        🗑️ Eliminar
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>