<x-app-layout>
    <x-slot name="header">
        <h2>📝 {{ $lesson->titulo }}</h2>
        <p style="color: rgba(255,255,255,0.8); font-size: 0.9rem; margin-top: 4px;">{{ $course->titulo }}</p>
    </x-slot>

    @php
        $totalCorrectas = $answersForDisplay->where('es_correcta', true)->count();
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

            {{-- Pizarra --}}
            @if($lesson->pizarra)
                <div style="background: white; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden; margin-bottom: 24px;">
                    <div style="background: linear-gradient(135deg, #f59e0b, #f97316); padding: 14px 20px; display: flex; align-items: center; gap: 8px;">
                        <span style="color: white; font-size: 1.1rem;">🎨</span>
                        <span style="color: white; font-weight: 700; font-size: 0.95rem;">Pizarra del docente</span>
                    </div>
                    <div style="padding: 16px;">
                        <img src="{{ $lesson->pizarra }}" style="width: 100%; border-radius: 10px; border: 2px solid #e5e7eb;" alt="Pizarra">
                    </div>
                </div>
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

                        @if($answersForDisplay->isNotEmpty())
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
                                <div class="ejercicio-card" id="ejercicio-{{ $loop->index }}" style="display: {{ $loop->first ? 'block' : 'none' }}; border: 2px solid #e5e7eb; border-radius: 16px; padding: 20px; margin-bottom: 16px;">

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
                                            value=""
                                            style="width: 100%; border: 2px solid #e5e7eb; border-radius: 10px; padding: 12px 14px; font-size: 1rem; font-family: 'Nunito', sans-serif;"
                                            placeholder="Escribí tu respuesta aquí...">

                                    @elseif($exercise->tipo === 'ordenar')
                                        @php $elementos = $exercise->options->pluck('texto')->shuffle(); @endphp
                                        <p style="color: #6b7280; font-size: 0.85rem; margin-bottom: 12px;">Arrastrá los elementos para ordenarlos correctamente.</p>
                                        <div id="sortable-{{ $exercise->id }}" style="display: flex; flex-direction: column; gap: 8px;">
                                            @foreach($elementos as $elemento)
                                                <div class="sortable-item" data-exercise="{{ $exercise->id }}" data-value="{{ $elemento }}" style="background: #f8faff; border: 2px solid #e5e7eb; border-radius: 10px; padding: 12px 16px; cursor: grab; display: flex; align-items: center; gap: 10px; font-weight: 600; color: #1e293b;">
                                                    <span style="color: #9ca3af;">⠿</span> {{ $elemento }}
                                                </div>
                                            @endforeach
                                        </div>
                                        <input type="hidden" name="exercise_{{ $exercise->id }}" id="order-{{ $exercise->id }}" value="">

                                    @elseif($exercise->tipo === 'unir')
                                        @php
                                            $pares = $exercise->options->map(fn($o) => explode('|', $o->texto));
                                            $izquierda = $pares->pluck(0)->shuffle();
                                            $derecha = $pares->pluck(1)->shuffle();
                                        @endphp
                                        <p style="color: #6b7280; font-size: 0.85rem; margin-bottom: 12px;">Hacé clic en un elemento de la izquierda y luego en el de la derecha para unirlos.</p>
                                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                                            <div style="display: flex; flex-direction: column; gap: 8px;">
                                                @foreach($izquierda as $item)
                                                    <div onclick="seleccionarIzq(this)"
                                                        data-exercise="{{ $exercise->id }}"
                                                        data-value="{{ $item }}"
                                                        style="background: #dbeafe; border: 2px solid #93c5fd; border-radius: 10px; padding: 10px 14px; cursor: pointer; font-weight: 600; color: #1d4ed8; text-align: center; user-select: none;">
                                                        {{ $item }}
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div style="display: flex; flex-direction: column; gap: 8px;">
                                                @foreach($derecha as $item)
                                                    <div onclick="seleccionarDer(this)"
                                                        data-exercise="{{ $exercise->id }}"
                                                        data-value="{{ $item }}"
                                                        style="background: #dcfce7; border: 2px solid #86efac; border-radius: 10px; padding: 10px 14px; cursor: pointer; font-weight: 600; color: #15803d; text-align: center; user-select: none;">
                                                        {{ $item }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <input type="hidden" name="exercise_{{ $exercise->id }}" id="unir-{{ $exercise->id }}" value="">

                                    @elseif($exercise->tipo === 'tabla')
                                        @php
                                            $tablaData = json_decode($exercise->options->first()?->texto, true);
                                            $columnas = $tablaData['columnas'] ?? [];
                                            $filas = $tablaData['filas'] ?? [];
                                        @endphp
                                        <p style="color: #6b7280; font-size: 0.85rem; margin-bottom: 12px;">Completá las celdas vacías de la tabla.</p>
                                        <div style="overflow-x: auto;">
                                            <table style="width: 100%; border-collapse: collapse;">
                                                <thead>
                                                    <tr>
                                                        @foreach($columnas as $col)
                                                            <th style="background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; padding: 10px 14px; text-align: center; font-weight: 700;">{{ $col }}</th>
                                                        @endforeach
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($filas as $fi => $fila)
                                                        <tr>
                                                            @foreach($fila as $ci => $celda)
                                                                <td style="border: 2px solid #e5e7eb; padding: 8px;">
                                                                    @if(empty($celda))
                                                                        <input type="text" name="exercise_{{ $exercise->id }}_tabla_{{ $fi }}_{{ $ci }}"
                                                                            style="width: 100%; border: none; outline: none; font-size: 0.9rem; text-align: center; font-family: 'Nunito', sans-serif;"
                                                                            placeholder="...">
                                                                    @else
                                                                        <span style="display: block; text-align: center; font-weight: 600; color: #1e293b;">{{ $celda }}</span>
                                                                    @endif
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                    @else
                                        <div style="display: flex; flex-direction: column; gap: 8px;">
                                            @foreach($exercise->options as $option)
                                                <label style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 10px; cursor: pointer;">
                                                    <input type="radio" name="exercise_{{ $exercise->id }}"
                                                        value="{{ $option->texto }}"
                                                        style="width: 18px; height: 18px; accent-color: #8b5cf6;">
                                                    <span style="color: #1e293b; font-weight: 600; flex: 1;">{{ $option->texto }}</span>
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
                                            <button type="button" onclick="enviarRespuestas()" style="background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; padding: 10px 20px; border-radius: 10px; font-weight: 800; border: none; cursor: pointer; margin-left: auto; font-family: 'Nunito', sans-serif;">
                                                📨 Enviar todo
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                            @if($answersForDisplay->isNotEmpty() && $nota >= 7 && $total > 0)
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.2/Sortable.min.js"></script>
    <script>
        // 🎵 Sonidos
        const AudioCtx = window.AudioContext || window.webkitAudioContext;
        let audioCtx = null;
        function getAudioCtx() {
            if (!audioCtx) audioCtx = new AudioCtx();
            return audioCtx;
        }
        function playSound(type) {
            try {
                const ctx = getAudioCtx();
                const oscillator = ctx.createOscillator();
                const gainNode = ctx.createGain();
                oscillator.connect(gainNode);
                gainNode.connect(ctx.destination);
                if (type === 'correct') {
                    oscillator.type = 'sine';
                    oscillator.frequency.setValueAtTime(523, ctx.currentTime);
                    oscillator.frequency.setValueAtTime(659, ctx.currentTime + 0.1);
                    oscillator.frequency.setValueAtTime(784, ctx.currentTime + 0.2);
                    gainNode.gain.setValueAtTime(0.3, ctx.currentTime);
                    gainNode.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.4);
                    oscillator.start(ctx.currentTime);
                    oscillator.stop(ctx.currentTime + 0.4);
                } else if (type === 'wrong') {
                    oscillator.type = 'sawtooth';
                    oscillator.frequency.setValueAtTime(300, ctx.currentTime);
                    oscillator.frequency.setValueAtTime(200, ctx.currentTime + 0.1);
                    gainNode.gain.setValueAtTime(0.15, ctx.currentTime);
                    gainNode.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.3);
                    oscillator.start(ctx.currentTime);
                    oscillator.stop(ctx.currentTime + 0.3);
                } else if (type === 'complete') {
                    const notes = [523, 659, 784, 1047];
                    notes.forEach((freq, i) => {
                        const osc = ctx.createOscillator();
                        const gain = ctx.createGain();
                        osc.connect(gain);
                        gain.connect(ctx.destination);
                        osc.type = 'sine';
                        osc.frequency.setValueAtTime(freq, ctx.currentTime + i * 0.12);
                        gain.gain.setValueAtTime(0.3, ctx.currentTime + i * 0.12);
                        gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + i * 0.12 + 0.3);
                        osc.start(ctx.currentTime + i * 0.12);
                        osc.stop(ctx.currentTime + i * 0.12 + 0.3);
                    });
                } else if (type === 'click') {
                    oscillator.type = 'sine';
                    oscillator.frequency.setValueAtTime(440, ctx.currentTime);
                    gainNode.gain.setValueAtTime(0.1, ctx.currentTime);
                    gainNode.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.1);
                    oscillator.start(ctx.currentTime);
                    oscillator.stop(ctx.currentTime + 0.1);
                }
            } catch(e) {}
        }
        window.playSound = playSound;

        function irA(index) {
            playSound('click');
            document.querySelectorAll('.ejercicio-card').forEach((el, i) => {
                el.style.display = i === index ? 'block' : 'none';
            });
            window.scrollTo({ top: document.getElementById('ejercicios-form').offsetTop - 100, behavior: 'smooth' });
        }

        function enviarRespuestas() {
            playSound('complete');
            setTimeout(() => document.getElementById('ejercicios-form').submit(), 600);
        }

        // Unir con flechas
        window.selectedIzq = null;
window.conexiones = {};

function seleccionarIzq(el) {
    document.querySelectorAll('[onclick="seleccionarIzq(this)"]').forEach(e => {
        e.style.borderColor = '#93c5fd';
        e.style.borderWidth = '2px';
        e.style.background = '#dbeafe';
    });
    el.style.borderColor = '#2563eb';
    el.style.borderWidth = '3px';
    el.style.background = '#bfdbfe';
    window.selectedIzq = el;
    playSound('click');
}

        function seleccionarDer(el) {
    if (!window.selectedIzq) return;
    const exerciseId = el.dataset.exercise;
    const izqVal = window.selectedIzq.dataset.value;
    const derVal = el.dataset.value;
    window.conexiones[izqVal] = derVal;
    window.selectedIzq.style.background = '#dcfce7';
    window.selectedIzq.style.borderColor = '#86efac';
    el.style.background = '#dbeafe';
    el.style.borderColor = '#93c5fd';
    const pairs = Object.entries(window.conexiones).map(([k, v]) => k + '|' + v).join(',');
    const input = document.getElementById('unir-' + exerciseId);
    if (input) input.value = pairs;
    window.selectedIzq = null;
    playSound('click');
    // Forzar re-render visual
    el.offsetHeight;
}

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('input[type="radio"]').forEach(radio => {
                radio.addEventListener('change', () => playSound('click'));
            });

            document.querySelectorAll('[id^="sortable-"]').forEach(container => {
                const exerciseId = container.id.replace('sortable-', '');
                new Sortable(container, {
                    animation: 150,
                    handle: '.sortable-item',
                    onEnd: function() {
                        const items = container.querySelectorAll('.sortable-item');
                        const order = [...items].map(i => i.dataset.value);
                        document.getElementById('order-' + exerciseId).value = order.join('|');
                    }
                });
            });
        });
    </script>

    <!-- Botón flotante de herramientas -->
    <div id="tools-container" style="position: fixed; bottom: 24px; right: 24px; z-index: 1000;">
        <div id="tools-panel" style="display: none; flex-direction: column; gap: 10px; margin-bottom: 12px;">

            <div id="calc-panel" style="display: none; background: white; border-radius: 16px; box-shadow: 0 8px 30px rgba(0,0,0,0.15); padding: 16px; width: 240px;">
                <p style="font-weight: 800; color: #1e293b; margin-bottom: 10px;">🧮 Calculadora</p>
                <input id="calc-display" type="text" readonly style="width: 100%; border: 2px solid #e5e7eb; border-radius: 8px; padding: 8px 12px; font-size: 1.1rem; text-align: right; margin-bottom: 8px; font-family: monospace;">
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 6px;">
                    @foreach(['7','8','9','÷','4','5','6','×','1','2','3','-','0','.','=','+'] as $btn)
                        <button onclick="calcPress('{{ $btn }}')" style="padding: 10px; border-radius: 8px; border: none; cursor: pointer; font-weight: 700; font-size: 0.95rem;
                            {{ in_array($btn, ['÷','×','-','+','=']) ? 'background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white;' : 'background: #f1f5f9; color: #1e293b;' }}">
                            {{ $btn }}
                        </button>
                    @endforeach
                    <button onclick="calcClear()" style="grid-column: span 4; padding: 8px; border-radius: 8px; border: none; cursor: pointer; background: #fee2e2; color: #dc2626; font-weight: 700;">
                        C Limpiar
                    </button>
                </div>
            </div>

            <div id="tabla-panel" style="display: none; background: white; border-radius: 16px; box-shadow: 0 8px 30px rgba(0,0,0,0.15); padding: 16px; width: 240px;">
                <p style="font-weight: 800; color: #1e293b; margin-bottom: 10px;">📐 Tabla de multiplicar</p>
                <select id="tabla-select" onchange="mostrarTabla()" style="width: 100%; border: 2px solid #e5e7eb; border-radius: 8px; padding: 8px; margin-bottom: 10px; font-weight: 600;">
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}">Tabla del {{ $i }}</option>
                    @endfor
                </select>
                <div id="tabla-contenido" style="font-size: 0.9rem; line-height: 1.8; color: #1e293b;"></div>
            </div>

            <div id="notas-panel" style="display: none; background: white; border-radius: 16px; box-shadow: 0 8px 30px rgba(0,0,0,0.15); padding: 16px; width: 240px;">
                <p style="font-weight: 800; color: #1e293b; margin-bottom: 10px;">📝 Mis notas</p>
                <textarea id="notas-texto" placeholder="Escribí tus notas acá..." style="width: 100%; border: 2px solid #e5e7eb; border-radius: 8px; padding: 10px; font-size: 0.9rem; height: 150px; resize: none; font-family: 'Nunito', sans-serif;"></textarea>
                <button onclick="guardarNotas()" style="width: 100%; margin-top: 8px; background: linear-gradient(135deg, #2563eb, #0ea5e9); color: white; padding: 8px; border-radius: 8px; border: none; cursor: pointer; font-weight: 700;">
                    💾 Guardar notas
                </button>
                <p id="notas-saved" style="color: #16a34a; font-size: 0.8rem; margin-top: 4px; display: none;">✅ Guardado</p>
            </div>

            <div style="display: flex; flex-direction: column; gap: 8px; align-items: flex-end;">
                <button onclick="toggleTool('calc')" style="background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; border: none; border-radius: 12px; padding: 10px 16px; cursor: pointer; font-weight: 700; font-size: 0.85rem; box-shadow: 0 4px 15px rgba(139,92,246,0.4);">🧮 Calculadora</button>
                <button onclick="toggleTool('tabla')" style="background: linear-gradient(135deg, #2563eb, #0ea5e9); color: white; border: none; border-radius: 12px; padding: 10px 16px; cursor: pointer; font-weight: 700; font-size: 0.85rem; box-shadow: 0 4px 15px rgba(37,99,235,0.4);">📐 Tablas</button>
                <button onclick="toggleTool('notas')" style="background: linear-gradient(135deg, #16a34a, #22c55e); color: white; border: none; border-radius: 12px; padding: 10px 16px; cursor: pointer; font-weight: 700; font-size: 0.85rem; box-shadow: 0 4px 15px rgba(22,163,74,0.4);">📝 Notas</button>
            </div>
        </div>

        <button onclick="toggleTools()" id="tools-btn" style="background: linear-gradient(135deg, #f59e0b, #f97316); color: white; border: none; border-radius: 50%; width: 60px; height: 60px; font-size: 1.5rem; cursor: pointer; box-shadow: 0 4px 20px rgba(245,158,11,0.5); display: block; margin-left: auto;">
            🛠️
        </button>
    </div>

    <script>
        function toggleTools() {
            const panel = document.getElementById('tools-panel');
            panel.style.display = panel.style.display === 'none' ? 'flex' : 'none';
        }

        function toggleTool(tool) {
            const panels = ['calc', 'tabla', 'notas'];
            panels.forEach(p => {
                const el = document.getElementById(p + '-panel');
                el.style.display = p === tool && el.style.display === 'none' ? 'block' : 'none';
            });
            if (tool === 'tabla') mostrarTabla();
            if (tool === 'notas') cargarNotas();
        }

        let calcExpr = '';
        function calcPress(btn) {
            const display = document.getElementById('calc-display');
            if (btn === '=') {
                try { calcExpr = String(eval(calcExpr.replace('×', '*').replace('÷', '/'))); }
                catch { calcExpr = 'Error'; }
            } else { calcExpr += btn; }
            display.value = calcExpr;
        }
        function calcClear() {
            calcExpr = '';
            document.getElementById('calc-display').value = '';
        }

        function mostrarTabla() {
            const n = parseInt(document.getElementById('tabla-select').value);
            let html = '';
            for (let i = 1; i <= 10; i++) {
                html += `<div style="display: flex; justify-content: space-between; padding: 2px 0; border-bottom: 1px solid #f1f5f9;"><span>${n} × ${i}</span><strong>${n * i}</strong></div>`;
            }
            document.getElementById('tabla-contenido').innerHTML = html;
        }

        const notasKey = 'notas_lesson_{{ $lesson->id }}';
        function cargarNotas() {
            const saved = localStorage.getItem(notasKey);
            if (saved) document.getElementById('notas-texto').value = saved;
        }
        function guardarNotas() {
            localStorage.setItem(notasKey, document.getElementById('notas-texto').value);
            const msg = document.getElementById('notas-saved');
            msg.style.display = 'block';
            setTimeout(() => msg.style.display = 'none', 2000);
        }

        mostrarTabla();
    </script>
</x-app-layout>