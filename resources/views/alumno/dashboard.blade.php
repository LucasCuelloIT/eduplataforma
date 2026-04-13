<x-app-layout>
    <x-slot name="header">
        <h2>👋 ¡Hola, {{ auth()->user()->name }}!</h2>
        <p style="color: rgba(255,255,255,0.8); font-size: 0.95rem; margin-top: 4px;">¿Qué aprendemos hoy?</p>
    </x-slot>

    @php
        $totalRespondidos = auth()->user()->studentAnswers()->count();
        $totalCorrectas = auth()->user()->studentAnswers()->where('es_correcta', true)->count();
        $totalCursos = auth()->user()->courses->count();
        $porcentajeAciertos = $totalRespondidos > 0 ? round(($totalCorrectas / $totalRespondidos) * 100) : 0;
    @endphp

    <div style="padding: 24px;">
        <div style="max-width: 1200px; margin: 0 auto;">

            <!-- Stats animadas -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
                
                <div style="background: linear-gradient(135deg, #2563eb, #0ea5e9); border-radius: 20px; padding: 24px; color: white; position: relative; overflow: hidden;">
                    <div style="position: absolute; top: -20px; right: -20px; font-size: 5rem; opacity: 0.15;">📚</div>
                    <p style="font-size: 0.85rem; opacity: 0.9; margin-bottom: 4px;">Mis Cursos</p>
                    <p style="font-size: 2.5rem; font-weight: 800;">{{ $totalCursos }}</p>
                    <p style="font-size: 0.8rem; opacity: 0.8; margin-top: 4px;">cursos activos</p>
                </div>

                <div style="background: linear-gradient(135deg, #16a34a, #22c55e); border-radius: 20px; padding: 24px; color: white; position: relative; overflow: hidden;">
                    <div style="position: absolute; top: -20px; right: -20px; font-size: 5rem; opacity: 0.15;">✅</div>
                    <p style="font-size: 0.85rem; opacity: 0.9; margin-bottom: 4px;">Ejercicios</p>
                    <p style="font-size: 2.5rem; font-weight: 800;">{{ $totalRespondidos }}</p>
                    <p style="font-size: 0.8rem; opacity: 0.8; margin-top: 4px;">respondidos</p>
                </div>

                <div style="background: linear-gradient(135deg, #f59e0b, #f97316); border-radius: 20px; padding: 24px; color: white; position: relative; overflow: hidden;">
                    <div style="position: absolute; top: -20px; right: -20px; font-size: 5rem; opacity: 0.15;">⭐</div>
                    <p style="font-size: 0.85rem; opacity: 0.9; margin-bottom: 4px;">Correctas</p>
                    <p style="font-size: 2.5rem; font-weight: 800;">{{ $totalCorrectas }}</p>
                    <p style="font-size: 0.8rem; opacity: 0.8; margin-top: 4px;">respuestas correctas</p>
                </div>

                <div style="background: linear-gradient(135deg, #8b5cf6, #ec4899); border-radius: 20px; padding: 24px; color: white; position: relative; overflow: hidden;">
                    <div style="position: absolute; top: -20px; right: -20px; font-size: 5rem; opacity: 0.15;">🎯</div>
                    <p style="font-size: 0.85rem; opacity: 0.9; margin-bottom: 4px;">Precisión</p>
                    <p style="font-size: 2.5rem; font-weight: 800;">{{ $porcentajeAciertos }}%</p>
                    <p style="font-size: 0.8rem; opacity: 0.8; margin-top: 4px;">de aciertos</p>
                </div>

            </div>

            <!-- Barra de progreso general -->
            @if($totalRespondidos > 0)
            <div style="background: white; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 24px; margin-bottom: 24px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                    <h3 style="font-size: 1rem; font-weight: 700; color: #1e293b;">🎯 Tu progreso general</h3>
                    <span style="font-size: 0.9rem; color: #6b7280; font-weight: 600;">{{ $porcentajeAciertos }}% de precisión</span>
                </div>
                <div style="background: #f1f5f9; border-radius: 20px; height: 16px; overflow: hidden;">
                    <div style="background: linear-gradient(135deg, #2563eb, #0ea5e9); height: 100%; border-radius: 20px; width: {{ $porcentajeAciertos }}%; transition: width 1s ease;" id="progress-bar"></div>
                </div>
                <div style="display: flex; justify-content: space-between; margin-top: 8px;">
                    <span style="font-size: 0.8rem; color: #9ca3af;">0%</span>
                    @if($porcentajeAciertos >= 70)
                        <span style="font-size: 0.8rem; color: #16a34a; font-weight: 700;">🏆 ¡Excelente nivel!</span>
                    @elseif($porcentajeAciertos >= 50)
                        <span style="font-size: 0.8rem; color: #f59e0b; font-weight: 700;">💪 ¡Buen progreso!</span>
                    @else
                        <span style="font-size: 0.8rem; color: #6b7280; font-weight: 700;">🚀 ¡Seguí practicando!</span>
                    @endif
                    <span style="font-size: 0.8rem; color: #9ca3af;">100%</span>
                </div>
            </div>
            @endif

            <!-- Cursos -->
            <div style="background: white; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 24px;">
                <h3 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 16px;">📖 Mis cursos activos</h3>
                @if(auth()->user()->courses->isEmpty())
                    <div style="text-align: center; padding: 40px;">
                        <p style="font-size: 3rem; margin-bottom: 12px;">📭</p>
                        <p style="color: #9ca3af; font-size: 1rem;">Todavía no tenés cursos asignados.</p>
                        <p style="color: #9ca3af; font-size: 0.85rem; margin-top: 4px;">Tu docente te asignará cursos pronto.</p>
                    </div>
                @else
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 16px;">
                        @foreach(auth()->user()->courses as $course)
                            @php
                                $totalLecciones = $course->lessons->count();
                                $leccionesCompletadas = 0;
                                foreach($course->lessons as $lesson) {
                                    $ejsLeccion = $lesson->exercises->count();
                                    if($ejsLeccion === 0) continue;
                                    $respondidos = auth()->user()->studentAnswers()->whereIn('exercise_id', $lesson->exercises->pluck('id'))->count();
                                    if($respondidos >= $ejsLeccion) $leccionesCompletadas++;
                                }
                                $pctCurso = $totalLecciones > 0 ? round(($leccionesCompletadas / $totalLecciones) * 100) : 0;
                                $colorGradient = match(true) {
                                    $pctCurso >= 70 => 'linear-gradient(135deg, #16a34a, #22c55e)',
                                    $pctCurso >= 30 => 'linear-gradient(135deg, #f59e0b, #f97316)',
                                    default => 'linear-gradient(135deg, #2563eb, #0ea5e9)',
                                };
                            @endphp
                            <a href="{{ route('alumno.courses.show', $course) }}" style="display: block; border: 2px solid #e5e7eb; border-radius: 16px; padding: 20px; text-decoration: none; transition: all 0.2s; overflow: hidden; position: relative;">
                                
                                <!-- Barra de color superior -->
                                <div style="background: {{ $colorGradient }}; height: 6px; border-radius: 10px; margin-bottom: 16px;"></div>

                                <h4 style="font-weight: 800; color: #1e293b; margin-bottom: 8px; font-size: 1rem;">{{ $course->titulo }}</h4>
                                
                                <div style="display: flex; gap: 6px; margin-bottom: 12px;">
                                    <span style="background: #dbeafe; color: #1d4ed8; padding: 2px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">{{ $course->materia }}</span>
                                    <span style="background: #dcfce7; color: #15803d; padding: 2px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">{{ $course->grado }}</span>
                                </div>

                                <!-- Progreso del curso -->
                                <div style="margin-bottom: 8px;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                        <span style="font-size: 0.78rem; color: #6b7280;">Progreso</span>
                                        <span style="font-size: 0.78rem; font-weight: 700; color: #1e293b;">{{ $pctCurso }}%</span>
                                    </div>
                                    <div style="background: #f1f5f9; border-radius: 10px; height: 8px; overflow: hidden;">
                                        <div style="background: {{ $colorGradient }}; height: 100%; border-radius: 10px; width: {{ $pctCurso }}%;"></div>
                                    </div>
                                </div>

                                <p style="color: #9ca3af; font-size: 0.8rem;">{{ $leccionesCompletadas }} de {{ $totalLecciones }} lecciones completadas</p>

                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>

    <script>
        // Animar la barra de progreso al cargar
        window.addEventListener('load', () => {
            const bar = document.getElementById('progress-bar');
            if (bar) {
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = '{{ $porcentajeAciertos }}%';
                }, 300);
            }
        });
    </script>
</x-app-layout>