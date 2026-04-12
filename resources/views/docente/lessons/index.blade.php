<x-app-layout>
    <x-slot name="header">
        <h2>📝 Lecciones de: {{ $course->titulo }}</h2>
    </x-slot>

    <div style="padding: 24px;">
        <div style="max-width: 1200px; margin: 0 auto;">

            @if(session('success'))
                <div style="background: #dcfce7; border: 1px solid #86efac; color: #15803d; padding: 12px 16px; border-radius: 12px; margin-bottom: 16px; font-weight: 600;">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <div style="margin-bottom: 16px;">
                <a href="{{ route('docente.courses.index') }}" style="color: #2563eb; font-weight: 600; text-decoration: none;">← Volver a Cursos</a>
            </div>

            <div style="margin-bottom: 20px;">
                <a href="{{ route('docente.courses.lessons.create', $course) }}" style="background: linear-gradient(135deg, #2563eb, #0ea5e9); color: white; padding: 12px 24px; border-radius: 12px; text-decoration: none; font-weight: 700;">
                    + Nueva Lección
                </a>
            </div>

            <div style="background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 24px;">
                @if($lessons->isEmpty())
                    <p style="color: #9ca3af;">Este curso no tiene lecciones todavía.</p>
                @else
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        @foreach($lessons as $lesson)
                            <div style="border: 2px solid #e5e7eb; border-radius: 12px; padding: 16px; display: flex; align-items: center; gap: 16px;">
                                <div style="background: linear-gradient(135deg, #2563eb, #0ea5e9); color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; flex-shrink: 0;">
                                    {{ $lesson->orden }}
                                </div>
                                <div style="flex: 1;">
                                    <h4 style="font-weight: 700; color: #1e293b; margin-bottom: 4px;">{{ $lesson->titulo }}</h4>
                                    <div style="display: flex; gap: 8px;">
                                        @if($lesson->video_url)
                                            <span style="color: #6b7280; font-size: 0.8rem;">▶ Video</span>
                                        @endif
                                        <span style="color: #6b7280; font-size: 0.8rem;">❓ {{ $lesson->exercises->count() }} ejercicios</span>
                                    </div>
                                </div>
                                <div style="display: flex; gap: 8px;">
                                    <a href="{{ route('docente.courses.lessons.exercises.index', [$course, $lesson]) }}" style="background: linear-gradient(135deg, #16a34a, #22c55e); color: white; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 0.85rem;">
                                        ❓ Ejercicios
                                    </a>
                                    <a href="{{ route('docente.courses.lessons.edit', [$course, $lesson]) }}" style="background: linear-gradient(135deg, #d97706, #f59e0b); color: white; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 0.85rem;">
                                        ✏️ Editar
                                    </a>
                                    <form action="{{ route('docente.courses.lessons.destroy', [$course, $lesson]) }}" method="POST" onsubmit="return confirm('¿Seguro?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: linear-gradient(135deg, #dc2626, #ef4444); color: white; padding: 8px 16px; border-radius: 8px; font-weight: 600; font-size: 0.85rem; border: none; cursor: pointer;">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>