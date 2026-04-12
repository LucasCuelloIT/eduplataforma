<x-app-layout>
    <x-slot name="header">
        <h2>👋 ¡Hola, {{ auth()->user()->name }}!</h2>
    </x-slot>

    <div style="padding: 24px;">
        <div style="max-width: 1200px; margin: 0 auto;">

            <!-- Stats -->
            <div style="display: flex; gap: 16px; margin-bottom: 24px;">
                <div style="background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 24px; flex: 1; display: flex; align-items: center; gap: 16px;">
                    <span style="font-size: 2.5rem;">📚</span>
                    <div>
                        <p style="color: #6b7280; font-size: 0.85rem;">Mis Cursos</p>
                        <p style="color: #2563eb; font-size: 1.8rem; font-weight: 800;">{{ auth()->user()->courses->count() }}</p>
                    </div>
                </div>
                <div style="background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 24px; flex: 1; display: flex; align-items: center; gap: 16px;">
                    <span style="font-size: 2.5rem;">✅</span>
                    <div>
                        <p style="color: #6b7280; font-size: 0.85rem;">Ejercicios Respondidos</p>
                        <p style="color: #16a34a; font-size: 1.8rem; font-weight: 800;">{{ auth()->user()->studentAnswers()->count() }}</p>
                    </div>
                </div>
                <div style="background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 24px; flex: 1; display: flex; align-items: center; gap: 16px;">
                    <span style="font-size: 2.5rem;">⭐</span>
                    <div>
                        <p style="color: #6b7280; font-size: 0.85rem;">Respuestas Correctas</p>
                        <p style="color: #d97706; font-size: 1.8rem; font-weight: 800;">{{ auth()->user()->studentAnswers()->where('es_correcta', true)->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Cursos -->
            <div style="background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 24px;">
                <h3 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 16px;">📖 Mis cursos activos</h3>
                @if(auth()->user()->courses->isEmpty())
                    <p style="color: #9ca3af;">Todavía no tenés cursos asignados.</p>
                @else
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 16px;">
                        @foreach(auth()->user()->courses as $course)
                            <a href="{{ route('alumno.courses.show', $course) }}" style="display: block; border: 2px solid #e5e7eb; border-radius: 12px; padding: 16px; text-decoration: none; transition: all 0.2s;">
                                <h4 style="font-weight: 700; color: #1e293b; margin-bottom: 8px;">{{ $course->titulo }}</h4>
                                <div style="display: flex; gap: 8px; margin-bottom: 8px;">
                                    <span style="background: #dbeafe; color: #1d4ed8; padding: 2px 10px; border-radius: 20px; font-size: 0.78rem; font-weight: 600;">{{ $course->materia }}</span>
                                    <span style="background: #dcfce7; color: #15803d; padding: 2px 10px; border-radius: 20px; font-size: 0.78rem; font-weight: 600;">{{ $course->grado }}</span>
                                </div>
                                <p style="color: #6b7280; font-size: 0.85rem;">{{ $course->descripcion }}</p>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>