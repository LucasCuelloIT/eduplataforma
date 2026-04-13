<x-app-layout>
    <x-slot name="header">
        <h2>📊 Reporte: {{ $course->titulo }}</h2>
        <div style="display: flex; gap: 8px; margin-top: 8px;">
            <span style="background: rgba(255,255,255,0.3); color: white; padding: 2px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">{{ $course->materia }}</span>
            <span style="background: rgba(255,255,255,0.3); color: white; padding: 2px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">{{ $course->grado }}</span>
        </div>
    </x-slot>

    <div style="padding: 24px;">
        <div style="max-width: 1200px; margin: 0 auto;">

            <div style="margin-bottom: 16px;">
                <a href="{{ route('docente.reports.index') }}" style="color: #2563eb; font-weight: 600; text-decoration: none;">← Volver a Reportes</a>
            </div>

            <!-- Stats generales -->
            <div style="display: flex; gap: 16px; margin-bottom: 24px;">
                <div style="background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 20px; flex: 1; display: flex; align-items: center; gap: 16px;">
                    <span style="font-size: 2rem;">👥</span>
                    <div>
                        <p style="color: #6b7280; font-size: 0.85rem;">Alumnos</p>
                        <p style="color: #2563eb; font-size: 1.8rem; font-weight: 800;">{{ count($reporte) }}</p>
                    </div>
                </div>
                <div style="background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 20px; flex: 1; display: flex; align-items: center; gap: 16px;">
                    <span style="font-size: 2rem;">📝</span>
                    <div>
                        <p style="color: #6b7280; font-size: 0.85rem;">Lecciones</p>
                        <p style="color: #16a34a; font-size: 1.8rem; font-weight: 800;">{{ $reporte[0]['totalLecciones'] ?? 0 }}</p>
                    </div>
                </div>
                <div style="background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 20px; flex: 1; display: flex; align-items: center; gap: 16px;">
                    <span style="font-size: 2rem;">❓</span>
                    <div>
                        <p style="color: #6b7280; font-size: 0.85rem;">Total Ejercicios</p>
                        <p style="color: #d97706; font-size: 1.8rem; font-weight: 800;">{{ $reporte[0]['totalEjercicios'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <!-- Grilla de alumnos -->
            <div style="background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 24px;">
                <h3 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 16px;">🎓 Progreso por alumno</h3>

                @if(empty($reporte))
                    <p style="color: #9ca3af;">No hay alumnos asignados a este curso todavía.</p>
                @else
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 2px solid #f1f5f9;">
                                <th style="text-align: left; padding: 12px 8px; color: #6b7280; font-size: 0.85rem; font-weight: 600;">Alumno</th>
                                <th style="text-align: center; padding: 12px 8px; color: #6b7280; font-size: 0.85rem; font-weight: 600;">Lecciones completadas</th>
                                <th style="text-align: center; padding: 12px 8px; color: #6b7280; font-size: 0.85rem; font-weight: 600;">% Completado</th>
                                <th style="text-align: center; padding: 12px 8px; color: #6b7280; font-size: 0.85rem; font-weight: 600;">Respuestas correctas</th>
                                <th style="text-align: center; padding: 12px 8px; color: #6b7280; font-size: 0.85rem; font-weight: 600;">Nota</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reporte as $fila)
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td style="padding: 14px 8px;">
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <div style="background: linear-gradient(135deg, #2563eb, #0ea5e9); color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; flex-shrink: 0;">
                                                {{ strtoupper(substr($fila['alumno']->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p style="font-weight: 700; color: #1e293b;">{{ $fila['alumno']->name }}</p>
                                                <p style="color: #6b7280; font-size: 0.8rem;">{{ $fila['alumno']->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="text-align: center; padding: 14px 8px;">
                                        <span style="font-weight: 600; color: #1e293b;">{{ $fila['leccionesCompletadas'] }} / {{ $fila['totalLecciones'] }}</span>
                                    </td>
                                    <td style="text-align: center; padding: 14px 8px;">
                                        <div style="background: #f1f5f9; border-radius: 20px; height: 8px; width: 100px; margin: 0 auto; overflow: hidden;">
                                            <div style="background: linear-gradient(135deg, #2563eb, #0ea5e9); height: 100%; width: {{ $fila['porcentajeCompletado'] }}%; border-radius: 20px;"></div>
                                        </div>
                                        <span style="font-size: 0.8rem; color: #6b7280; margin-top: 4px; display: block;">{{ $fila['porcentajeCompletado'] }}%</span>
                                    </td>
                                    <td style="text-align: center; padding: 14px 8px;">
                                        <span style="font-weight: 600; color: #1e293b;">{{ $fila['ejerciciosCorrectos'] }} / {{ $fila['totalEjercicios'] }}</span>
                                    </td>
                                    <td style="text-align: center; padding: 14px 8px;">
                                        @php
                                            $color = $fila['nota'] >= 7 ? '#16a34a' : ($fila['nota'] >= 5 ? '#d97706' : '#dc2626');
                                        @endphp
                                        <span style="background: {{ $color }}20; color: {{ $color }}; padding: 4px 14px; border-radius: 20px; font-weight: 800; font-size: 1rem;">
                                            {{ $fila['nota'] }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>