<x-app-layout>
    <x-slot name="header">
        <h2>📝 {{ $lesson->titulo }}</h2>
        <p style="color: rgba(255,255,255,0.8); font-size: 0.9rem; margin-top: 4px;">{{ $course->titulo }}</p>
    </x-slot>

    @php
        $totalCorrectas = $answers->where('es_correcta', true)->count();
        $total = $exercises->count();
        $nota = $total > 0 ? round(($totalCorrectas / $total) * 10, 1) : 0;
    @endphp

    <div style="padding: 24px;">
        <div style="max-width: 1100px; margin: 0 auto;">

            <div style="margin-bottom: 16px; display: flex; justify-content: space-between; align-items: center;">
                <a href="{{ route('alumno.courses.show', $course) }}" style="color: #2563eb; font-weight: 600; text-decoration: none;">← Volver al curso</a>
                @if($total > 0)
                    <div style="display: flex; align-items: center; gap: 8px; background: white; border-radius: 20px; padding: 8px 16px; box-shadow: 0 2px 10px rgba(0,0,0,0.06);">
                        <span style="font-size: 1rem;">🎯</span>
                        <span style="font-weight: 700; color: #1e293b; font-size: 0.9rem;">{{ $totalCorrectas }}/{{ $total }} correctas</span>
                        @if($nota >= 7)
                            <span style="background: #dcfce7; color: #15803d; padding: 2px 10px; border-radius: 20px; font-size: 0.78rem; font-weight: 700;">{{ $nota }}/10 ⭐</span>
                        @elseif($nota > 0)
                            <span style="background: #fef9c3; color: #a16207; padding: 2px 10px; border-radius: 20px; font-size: 0.78rem; font-weight: 700;">{{ $nota }}/10</span>
                        @endif
                    </div>
                @endif
            </div>

            @if(session('success'))
                <div style="background: #dcfce7; border: 1px solid #86efac; color: #15803d; padding: 12px 16px; border-radius: 12px; margin-bottom: 16px; font-weight: 600;">
                    ✅ {{ session('success') }}
                </div>
            @endif

            {{-- Video y contenido --}}
            @if($lesson->video_url && $lesson->contenido)
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
                    <div style="background: white; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden;">
                        <div style="background: linear-gradient(135deg, #1e293b, #334155); padding: 14px 20px; display: flex; align-items: center; gap: 8px;">
                            <span style="color: #f97316; font-size: 1.1rem;">▶</span>
                            <span style="color: white; font-weight: 700; font-size: 0.95rem;">Video explicativo</span>
                        </div>
                        @php preg_match('/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $lesson->video_url, $matches); $videoId = $matches[1] ?? null; @endphp
                        @if($videoId)
                            <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">
                                <iframe style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allowfullscreen></iframe>
                            </div>
                        @endif
                    </div>
                    <div style="background: white; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden;">
                        <div style="background: linear-gradient(135deg, #2563eb, #0ea5e9); padding: 14px 20px; display: flex; align-items: center; gap: 8px;">
                            <span style="color: white; font-size: 1.1rem;">📖</span>
                            <span style="color: white; font-weight: 700; font-size: 0.95rem;">Explicación</span>
                        </div>
                        <div style="padding: 20px; color: #4b5563; line-height: 1.8; font-size: 0.95rem; max-height: 400px; overflow-y: auto;">
                            {!! $lesson->contenido !!}
                        </div>
                    </div>
                </div>
            @else
                @if($lesson->video_url)
                    <div style="background: white; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden; margin-bottom: 24px;">
                        <div style="background: linear-gradient(135deg, #1e293b, #334155); padding: 14px 20px; display: flex; align-items: center; gap: 8px;">
                            <span style="color: #f97316; font-size: 1.1rem;">▶</span>
                            <span style="color: white; font-weight: 700;">Video explicativo</span>
                        </div>
                        @php preg_match('/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $lesson->video_url, $matches); $videoId = $matches[1] ?? null; @endphp
                        @if($videoId)
                            <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">
                                <iframe style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allowfullscreen></iframe>
                            </div>
                        @endif
                    </div>
                @endif
                @if($lesson->contenido)
                    <div style="background: white; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden; margin-bottom: 24px;">
                        <div style="background: linear-gradient(135deg, #2563eb, #0ea5e9); padding: 14px 20px; display: flex; align-items: center; gap: 8px;">
                            <span style="color: white; font-size: 1.1rem;">📖</span>
                            <span style="color: white; font-weight: 700;">Explicación</span>
                        </div>
                        <div style="padding: 24px; color: #4b5563; line-height: 1.8;">{!! $lesson->contenido !!}</div>
                    </div>
                @endif
            @endif

            {{-- Ejercicios --}}
            @if($exercises->isNotEmpty())
                <div style="background: white; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden;">
                    <div style="background: linear-gradient(135deg, #8b5cf6, #ec4899); padding: 14px 20px; display: flex; align-items: center; justify-content: space-between;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span style="color: white; font-size: 1.1rem;">❓</span>
                            <span style="color: white; font-weight: 700;">Ejercicios</span>
                        </div>
                        <span style="background: rgba(255,255,255,0.2); color: white; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">{{ $total }} preguntas</span>
                    </div>

                    <div style="padding: 24px;">

                        @if($answers->isNotEmpty())
                            <div style="background: linear-gradient(135deg, #2563eb, #0ea5e9); color: white; border-radius: 16px; padding: 20px; margin-bottom: 24px; display: flex; align-items: center; gap: 20px;">
                                <span style="font-size: 3rem;">🏆</span>
                                <div style="flex: 1;">
                                    <p style="font-size: 0.85rem; opacity: 0.9; margin-bottom: 4px;">Tu nota actual</p>
                                    <p style="font-size: 2.2rem; font-weight: 800; line-height: 1;">{{ $nota }} / 10</p>
                                    <p style="font-size: 0.85rem; opacity: 0.9; margin-top: 4px;">{{ $totalCorrectas }} de {{ $total }} correctas</p>
                                </div>
                                <div style="text-align: right;">
                                    @if($nota >= 9) <p style="font-size: 2rem;">🌟</p><p style="font-size: 0.85rem; opacity: 0.9;">¡Sobresaliente!</p>
                                    @elseif($nota >= 7) <p style="font-size: 2rem;">😄</p><p style="font-size: 0.85rem; opacity: 0.9;">¡Muy bien!</p>
                                    @elseif($nota >= 5) <p style="font-size: 2rem;">💪</p><p style="font-size: 0.85rem; opacity: 0.9;">¡Buen intento!</p>
                                    @else <p style="font-size: 2rem;">📚</p><p style="font-size: 0.85rem; opacity: 0.9;">¡Seguí estudiando!</p>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('alumno.courses.responder', [$course, $lesson]) }}" method="POST" id="ejercicios-form">
                            @csrf
                            @foreach($exercises as $exercise)
                                <div class="ejercicio-card" id="ejercicio-{{ $loop->index }}" style="display: {{ $loop->first ? 'block' : 'none' }}; border: 2px solid #e5e7eb; border-radius: 16px; padding: 20px; margin-bottom: 16px;
                                    @if(isset($answers[$exercise->id]))
                                        @if($answers[$exercise->id]->es_correcta) border-color: #86efac; background: #f0fdf4;
                                        @else border-color: #fca5a5; background: #fef2f2;
                                        @endif
                                    @endif
                                ">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                                        <div style="display: flex; gap: 6px;">
                                            @foreach($exercises as $dot)
                                                <div style="width: 10px; height: 10px; border-radius: 50%; background: {{ $loop->index === $exercise->getKey() - $exercises->first()->getKey() ? '#8b5cf6' : '#e5e7eb' }};"></div>
                                            @endforeach
                                        </div>
                                        <span style="font-size: 0.85rem; color: #6b7280; font-weight: 600;">{{ $loop->iteration }} de {{ $total }}</span>
                                    </div>

                                    <div style="display: flex; align-items: flex-start; gap: 12px; margin-bottom: 14px;">
                                        <span style="background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.85rem; flex-shrink: 0;">{{ $loop->iteration }}</span>
                                        <p style="font-weight: 700; color: #1e293b; font-size: 1rem; line-height: 1.4;">{{ $exercise->pregunta }}</p>
                                    </div>

                                    @if($exercise->tipo === 'completar')
                                        <input type="text" name="exercise_{{ $exercise->id }}"
                                            value="{{ $answers[$exercise->id]->respuesta ?? '' }}"
                                            style="width: 100%; border: 2px solid #e5e7eb; border-radius: 10px; padding: 12px 14px; font-size: 1rem; font-family: 'Nunito', sans-serif;"
                                            placeholder="Escribí tu respuesta aquí...">
                                        @if(isset($answers[$exercise->id]))
                                            @if($answers[$exercise->id]->es_correcta)
                                                <p style="color: #16a34a; font-weight: 700; margin-top: 8px;">✅ ¡Correcto!</p>
                                            @else
                                                <p style="color: #dc2626; font-weight: 700; margin-top: 8px;">❌ Incorrecto, intentá de nuevo.</p>
                                            @endif
                                        @endif
                                    @else
                                        <div style="display: flex; flex-direction: column; gap: 8px;">
                                            @foreach($exercise->options as $option)
                                                <label style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; cursor: pointer;
                                                    @if(isset($answers[$exercise->id]))
                                                        @if($option->es_correcta) background: #dcfce7; border-color: #86efac;
                                                        @elseif($answers[$exercise->id]->respuesta === $option->texto && !$option->es_correcta) background: #fee2e2; border-color: #fca5a5;
                                                        @endif
                                                    @endif
                                                ">
                                                    <input type="radio" name="exercise_{{ $exercise->id }}"
                                                        value="{{ $option->texto }}"
                                                        {{ isset($answers[$exercise->id]) && $answers[$exercise->id]->respuesta === $option->texto ? 'checked' : '' }}
                                                        style="width: 18px; height: 18px; accent-color: #8b5cf6;">
                                                    <span style="color: #1e293b; font-weight: 600; flex: 1;">{{ $option->texto }}</span>
                                                    @if(isset($answers[$exercise->id]))
                                                        @if($option->es_correcta) <span style="color: #16a34a; font-size: 1.1rem;">✅</span>
                                                        @elseif($answers[$exercise->id]->respuesta === $option->texto && !$option->es_correcta) <span style="color: #dc2626; font-size: 1.1rem;">❌</span>
                                                        @endif
                                                    @endif
                                                </label>
                                            @endforeach
                                        </div>
                                    @endif

                                    <div style="display: flex; gap: 10px; margin-top: 16px;">
                                        @if(!$loop->first)
                                            <button type="button" onclick="irA({{ $loop->index - 1 }})" style="background: #e5e7eb; color: #374151; padding: 10px 20px; border-radius: 10px; font-weight: 700; border: none; cursor: pointer;">
                                                ← Anterior
                                            </button>
                                        @endif
                                        @if(!$loop->last)
                                            <button type="button" onclick="irA({{ $loop->index + 1 }})" style="background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; padding: 10px 20px; border-radius: 10px; font-weight: 700; border: none; cursor: pointer; margin-left: auto;">
                                                Siguiente →
                                            </button>
                                        @else
                                            <button type="submit" style="background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; padding: 10px 20px; border-radius: 10px; font-weight: 800; border: none; cursor: pointer; margin-left: auto; font-family: 'Nunito', sans-serif;">
                                                📨 Enviar todo
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                            @if($answers->isNotEmpty() && $nota >= 7 && $total > 0)
                                <a href="{{ route('alumno.courses.minigame', [$course, $lesson]) }}" style="display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 12px; background: linear-gradient(135deg, #f59e0b, #f97316); color: white; padding: 14px 32px; border-radius: 12px; font-weight: 800; font-size: 1.1rem; text-decoration: none;">
                                    🎮 ¡Desbloquear Minijuego!
                                </a>
                            @endif
                        </form>
                    </div>
                </div>
            @endif

        </div>
    </div>

    <script>
        function irA(index) {
            document.querySelectorAll('.ejercicio-card').forEach((el, i) => {
                el.style.display = i === index ? 'block' : 'none';
            });
            window.scrollTo({ top: document.getElementById('ejercicios-form').offsetTop - 100, behavior: 'smooth' });
        }
    </script>
</x-app-layout>