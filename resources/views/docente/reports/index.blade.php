<x-app-layout>
    <x-slot name="header">
        <h2>📊 Reportes de Alumnos</h2>
    </x-slot>

    <div style="padding: 24px;">
        <div style="max-width: 1200px; margin: 0 auto;">

            <div style="margin-bottom: 16px;">
                <a href="{{ route('docente.dashboard') }}" style="color: #2563eb; font-weight: 600; text-decoration: none;">← Volver al Dashboard</a>
            </div>

            <div style="background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 24px;">
                <h3 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 16px;">Seleccioná un curso para ver el reporte</h3>

                @if($courses->isEmpty())
                    <p style="color: #9ca3af;">No tenés cursos creados todavía.</p>
                @else
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 16px;">
                        @foreach($courses as $course)
                            <a href="{{ route('docente.reports.show', $course) }}" style="display: block; border: 2px solid #e5e7eb; border-radius: 12px; padding: 20px; text-decoration: none; transition: all 0.2s;">
                                <h4 style="font-weight: 700; color: #1e293b; margin-bottom: 8px;">{{ $course->titulo }}</h4>
                                <div style="display: flex; gap: 8px; margin-bottom: 12px;">
                                    <span style="background: #dbeafe; color: #1d4ed8; padding: 2px 10px; border-radius: 20px; font-size: 0.78rem; font-weight: 600;">{{ $course->materia }}</span>
                                    <span style="background: #dcfce7; color: #15803d; padding: 2px 10px; border-radius: 20px; font-size: 0.78rem; font-weight: 600;">{{ $course->grado }}</span>
                                </div>
                                <div style="display: flex; gap: 16px;">
                                    <span style="color: #6b7280; font-size: 0.85rem;">👥 {{ $course->alumnos->count() }} alumnos</span>
                                    <span style="color: #6b7280; font-size: 0.85rem;">📝 {{ $course->lessons->count() }} lecciones</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>