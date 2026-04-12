<x-app-layout>
    <x-slot name="header">
        <h2>📚 Mis Cursos</h2>
    </x-slot>

    <div style="padding: 24px;">
        <div style="max-width: 1200px; margin: 0 auto;">

            @if(session('success'))
                <div style="background: #dcfce7; border: 1px solid #86efac; color: #15803d; padding: 12px 16px; border-radius: 12px; margin-bottom: 16px; font-weight: 600;">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <div style="margin-bottom: 20px;">
                <a href="{{ route('docente.courses.create') }}" style="background: linear-gradient(135deg, #2563eb, #0ea5e9); color: white; padding: 12px 24px; border-radius: 12px; text-decoration: none; font-weight: 700;">
                    + Nuevo Curso
                </a>
            </div>

            <div style="background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 24px;">
                @if($courses->isEmpty())
                    <p style="color: #9ca3af;">No tenés cursos creados todavía.</p>
                @else
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 16px;">
                        @foreach($courses as $course)
                            <div style="border: 2px solid #e5e7eb; border-radius: 12px; padding: 20px;">
                                <h4 style="font-weight: 700; color: #1e293b; margin-bottom: 8px; font-size: 1.1rem;">{{ $course->titulo }}</h4>
                                <div style="display: flex; gap: 8px; margin-bottom: 12px;">
                                    <span style="background: #dbeafe; color: #1d4ed8; padding: 2px 10px; border-radius: 20px; font-size: 0.78rem; font-weight: 600;">{{ $course->materia }}</span>
                                    <span style="background: #dcfce7; color: #15803d; padding: 2px 10px; border-radius: 20px; font-size: 0.78rem; font-weight: 600;">{{ $course->grado }}</span>
                                </div>
                                <p style="color: #6b7280; font-size: 0.85rem; margin-bottom: 16px;">{{ $course->descripcion }}</p>
                                <div style="display: flex; gap: 8px;">
                                    <a href="{{ route('docente.courses.lessons.index', $course) }}" style="background: linear-gradient(135deg, #2563eb, #0ea5e9); color: white; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 0.85rem;">
                                        📝 Lecciones
                                    </a>
                                    <a href="{{ route('docente.courses.edit', $course) }}" style="background: linear-gradient(135deg, #d97706, #f59e0b); color: white; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 0.85rem;">
                                        ✏️ Editar
                                    </a>
                                    <form action="{{ route('docente.courses.destroy', $course) }}" method="POST" onsubmit="return confirm('¿Seguro que querés eliminar este curso?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: linear-gradient(135deg, #dc2626, #ef4444); color: white; padding: 8px 16px; border-radius: 8px; font-weight: 600; font-size: 0.85rem; border: none; cursor: pointer;">
                                            🗑️ Eliminar
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