<x-app-layout>
    <x-slot name="header">
        <h2>👨‍🏫 Panel Docente</h2>
    </x-slot>

    <div style="padding: 24px;">
        <div style="max-width: 1200px; margin: 0 auto;">

            <!-- Stats -->
            <div style="display: flex; gap: 16px; margin-bottom: 24px;">
                <div style="background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 24px; flex: 1; display: flex; align-items: center; gap: 16px;">
                    <span style="font-size: 2.5rem;">📚</span>
                    <div>
                        <p style="color: #6b7280; font-size: 0.85rem;">Mis Cursos</p>
                        <p style="color: #2563eb; font-size: 1.8rem; font-weight: 800;">{{ \App\Models\Course::where('user_id', auth()->id())->count() }}</p>
                    </div>
                </div>
                <div style="background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 24px; flex: 1; display: flex; align-items: center; gap: 16px;">
                    <span style="font-size: 2.5rem;">📝</span>
                    <div>
                        <p style="color: #6b7280; font-size: 0.85rem;">Total Lecciones</p>
                        <p style="color: #16a34a; font-size: 1.8rem; font-weight: 800;">{{ \App\Models\Lesson::whereHas('course', fn($q) => $q->where('user_id', auth()->id()))->count() }}</p>
                    </div>
                </div>
                <div style="background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 24px; flex: 1; display: flex; align-items: center; gap: 16px;">
                    <span style="font-size: 2.5rem;">❓</span>
                    <div>
                        <p style="color: #6b7280; font-size: 0.85rem;">Total Ejercicios</p>
                        <p style="color: #d97706; font-size: 1.8rem; font-weight: 800;">{{ \App\Models\Exercise::whereHas('lesson.course', fn($q) => $q->where('user_id', auth()->id()))->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Cursos recientes -->
            <div style="background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 24px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                    <h3 style="font-size: 1.1rem; font-weight: 700; color: #1e293b;">📖 Mis cursos</h3>
                    <a href="{{ route('docente.courses.create') }}" style="background: linear-gradient(135deg, #2563eb, #0ea5e9); color: white; padding: 10px 20px; border-radius: 10px; text-decoration: none; font-weight: 700; font-size: 0.9rem;">
                        + Nuevo Curso
                    </a>
                </div>
                @php $courses = \App\Models\Course::where('user_id', auth()->id())->latest()->take(5)->get(); @endphp
                @if($courses->isEmpty())
                    <p style="color: #9ca3af;">Todavía no creaste ningún curso.</p>
                @else
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 16px;">
                        @foreach($courses as $course)
                            <a href="{{ route('docente.courses.lessons.index', $course) }}" style="display: block; border: 2px solid #e5e7eb; border-radius: 12px; padding: 16px; text-decoration: none; transition: all 0.2s;">
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