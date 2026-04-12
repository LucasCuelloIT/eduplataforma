<x-app-layout>
    <x-slot name="header">
        <h2>📚 Asignar Cursos a Alumnos</h2>
    </x-slot>

    <div style="padding: 24px;">
        <div style="max-width: 1200px; margin: 0 auto;">

            <div style="margin-bottom: 16px;">
                <a href="{{ route('admin.dashboard') }}" style="color: #2563eb; font-weight: 600; text-decoration: none;">← Volver al Dashboard</a>
            </div>

            @if(session('success'))
                <div style="background: #dcfce7; border: 1px solid #86efac; color: #15803d; padding: 12px 16px; border-radius: 12px; margin-bottom: 16px; font-weight: 600;">
                    ✅ {{ session('success') }}
                </div>
            @endif

            {{-- Formulario de asignación --}}
            <div style="background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 24px; margin-bottom: 24px;">
                <h3 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 16px;">➕ Asignar nuevo curso</h3>
                <form action="{{ route('admin.courses.assign.store') }}" method="POST" style="display: flex; gap: 12px; flex-wrap: wrap;">
                    @csrf
                    <select name="user_id" style="border: 2px solid #e5e7eb; border-radius: 10px; padding: 10px 14px; font-size: 0.95rem; flex: 1; min-width: 200px;" required>
                        <option value="">👤 Seleccioná un alumno</option>
                        @foreach($alumnos as $alumno)
                            <option value="{{ $alumno->id }}">{{ $alumno->name }} ({{ $alumno->email }})</option>
                        @endforeach
                    </select>
                    <select name="course_id" style="border: 2px solid #e5e7eb; border-radius: 10px; padding: 10px 14px; font-size: 0.95rem; flex: 1; min-width: 200px;" required>
                        <option value="">📚 Seleccioná un curso</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->titulo }} — {{ $course->materia }} {{ $course->grado }}</option>
                        @endforeach
                    </select>
                    <button type="submit" style="background: linear-gradient(135deg, #2563eb, #0ea5e9); color: white; padding: 10px 24px; border-radius: 10px; font-weight: 700; border: none; cursor: pointer; font-size: 0.95rem;">
                        Asignar
                    </button>
                </form>
            </div>

            {{-- Cursos asignados por alumno --}}
            <div style="background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 24px;">
                <h3 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 20px;">🎓 Cursos asignados por alumno</h3>

                @forelse($alumnos as $alumno)
                    <div style="margin-bottom: 28px;">
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                            <div style="background: linear-gradient(135deg, #2563eb, #0ea5e9); color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; flex-shrink: 0;">
                                {{ strtoupper(substr($alumno->name, 0, 1)) }}
                            </div>
                            <div>
                                <p style="font-weight: 700; color: #1e293b;">{{ $alumno->name }}</p>
                                <p style="color: #6b7280; font-size: 0.8rem;">{{ $alumno->email }}</p>
                            </div>
                        </div>

                        @if($alumno->courses->isEmpty())
                            <p style="color: #9ca3af; font-size: 0.85rem; padding-left: 48px;">Sin cursos asignados.</p>
                        @else
                            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 12px; padding-left: 48px;">
                                @foreach($alumno->courses as $course)
                                    <div style="border: 2px solid #e5e7eb; border-radius: 12px; padding: 14px; display: flex; flex-direction: column; gap: 8px;">
                                        <h4 style="font-weight: 700; color: #1e293b; font-size: 0.95rem;">{{ $course->titulo }}</h4>
                                        <div style="display: flex; gap: 6px;">
                                            <span style="background: #dbeafe; color: #1d4ed8; padding: 2px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">{{ $course->materia }}</span>
                                            <span style="background: #dcfce7; color: #15803d; padding: 2px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">{{ $course->grado }}</span>
                                        </div>
                                        <form action="{{ route('admin.courses.assign.destroy') }}" method="POST" onsubmit="return confirm('¿Seguro que querés quitar este curso?')">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="user_id" value="{{ $alumno->id }}">
                                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                                            <button type="submit" style="background: linear-gradient(135deg, #dc2626, #ef4444); color: white; padding: 6px 14px; border-radius: 8px; font-weight: 600; font-size: 0.8rem; border: none; cursor: pointer;">
                                                🗑️ Quitar curso
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <hr style="margin-top: 20px; border-color: #f1f5f9;">
                    </div>
                @empty
                    <p style="color: #9ca3af;">No hay alumnos aprobados todavía.</p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>