<x-app-layout>
    <x-slot name="header">
        <h2>📚 {{ $course->titulo }}</h2>
        <div style="display: flex; gap: 8px; margin-top: 8px;">
            <span style="background: rgba(255,255,255,0.3); color: white; padding: 2px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">{{ $course->materia }}</span>
            <span style="background: rgba(255,255,255,0.3); color: white; padding: 2px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">{{ $course->grado }}</span>
        </div>
    </x-slot>

    <div style="padding: 24px;">
        <div style="max-width: 1200px; margin: 0 auto;">

            <div style="margin-bottom: 16px;">
                <a href="{{ route('alumno.courses.index') }}" style="color: #2563eb; font-weight: 600; text-decoration: none;">← Volver a mis cursos</a>
            </div>

            @if($course->descripcion)
                <div style="background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 24px; margin-bottom: 24px;">
                    <p style="color: #4b5563;">{{ $course->descripcion }}</p>
                </div>
            @endif

            <div style="background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 24px;">
                <h3 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 16px;">📖 Lecciones</h3>

                @if($lessons->isEmpty())
                    <p style="color: #9ca3af;">Este curso no tiene lecciones todavía.</p>
                @else
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        @foreach($lessons as $index => $lesson)
                            <a href="{{ route('alumno.courses.lesson', [$course, $lesson]) }}" style="display: flex; align-items: center; gap: 16px; border: 2px solid #e5e7eb; border-radius: 12px; padding: 16px; text-decoration: none; transition: all 0.2s;">
                                <div style="background: linear-gradient(135deg, #2563eb, #0ea5e9); color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1rem; flex-shrink: 0;">
                                    {{ $index + 1 }}
                                </div>
                                <div style="flex: 1;">
                                    <h4 style="font-weight: 700; color: #1e293b; margin-bottom: 4px;">{{ $lesson->titulo }}</h4>
                                    <div style="display: flex; gap: 8px;">
                                        @if($lesson->video_url)
                                            <span style="color: #6b7280; font-size: 0.8rem;">▶ Video disponible</span>
                                        @endif
                                        @if($lesson->exercises->count() > 0)
                                            <span style="color: #6b7280; font-size: 0.8rem;">❓ {{ $lesson->exercises->count() }} ejercicios</span>
                                        @endif
                                    </div>
                                </div>
                                <span style="color: #2563eb; font-size: 1.2rem;">→</span>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>