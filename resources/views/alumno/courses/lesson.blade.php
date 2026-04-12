<x-app-layout>
    <x-slot name="header">
        <h2>📝 {{ $lesson->titulo }}</h2>
        <p style="color: rgba(255,255,255,0.8); font-size: 0.9rem; margin-top: 4px;">{{ $course->titulo }}</p>
    </x-slot>

    <div style="padding: 24px;">
        <div style="max-width: 900px; margin: 0 auto;">

            <div style="margin-bottom: 16px;">
                <a href="{{ route('alumno.courses.show', $course) }}" style="color: #2563eb; font-weight: 600; text-decoration: none;">← Volver al curso</a>
            </div>

            @if(session('success'))
                <div style="background: #dcfce7; border: 1px solid #86efac; color: #15803d; padding: 12px 16px; border-radius: 12px; margin-bottom: 16px; font-weight: 600;">
                    ✅ {{ session('success') }}
                </div>
            @endif

            {{-- Video --}}
            @if($lesson->video_url)
                <div style="background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 24px; margin-bottom: 24px;">
                    <h3 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 16px;">▶ Video explicativo</h3>
                    @php
                        preg_match('/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $lesson->video_url, $matches);
                        $videoId = $matches[1] ?? null;
                    @endphp
                    @if($videoId)
                        <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 12px;">
                            <iframe
                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
                                src="https://www.youtube.com/embed/{{ $videoId }}"
                                frameborder="0"
                                allowfullscreen>
                            </iframe>
                        </div>
                    @else
                        <a href="{{ $lesson->video_url }}" target="_blank" style="color: #2563eb;">Ver video</a>
                    @endif
                </div>
            @endif

            {{-- Contenido --}}
            @if($lesson->contenido)
                <div style="background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 24px; margin-bottom: 24px;">
                    <h3 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 16px;">📖 Explicación</h3>
                    <div style="color: #4b5563; line-height: 1.8; font-size: 1rem;">
                        {!! nl2br(e($lesson->contenido)) !!}
                    </div>
                </div>
            @endif

            {{-- Ejercicios --}}
            @if($exercises->isNotEmpty())
                <div style="background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 24px;">
                    <h3 style="font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 8px;">❓ Ejercicios</h3>

                    @php
                        $totalCorrectas = $answers->where('es_correcta', true)->count();
                        $total = $exercises->count();
                        $nota = $total > 0 ? round(($totalCorrectas / $total) * 10, 1) : 0;
                    @endphp

                    @if($answers->isNotEmpty())
                        <div style="background: linear-gradient(135deg, #2563eb, #0ea5e9); color: white; border-radius: 12px; padding: 16px; margin-bottom: 24px; display: flex; align-items: center; gap: 16px;">
                            <span style="font-size: 2.5rem;">🏆</span>
                            <div>
                                <p style="font-size: 0.85rem; opacity: 0.9;">Tu nota actual</p>
                                <p style="font-size: 2rem; font-weight: 800;">{{ $nota }} / 10</p>
                                <p style="font-size: 0.85rem; opacity: 0.9;">{{ $totalCorrectas }} de {{ $total }} correctas</p>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('alumno.courses.responder', [$course, $lesson]) }}" method="POST">
                        @csrf
                        @foreach($exercises as $exercise)
                            <div style="border: 2px solid #e5e7eb; border-radius: 12px; padding: 20px; margin-bottom: 16px;">
                                <p style="font-weight: 700; color: #1e293b; margin-bottom: 12px;">{{ $loop->iteration }}. {{ $exercise->pregunta }}</p>

                                @if($exercise->tipo === 'completar')
                                    <input
                                        type="text"
                                        name="exercise_{{ $exercise->id }}"
                                        value="{{ $answers[$exercise->id]->respuesta ?? '' }}"
                                        style="width: 100%; border: 2px solid #e5e7eb; border-radius: 8px; padding: 10px 14px; font-size: 1rem;"
                                        placeholder="Escribí tu respuesta">

                                    @if(isset($answers[$exercise->id]))
                                        @if($answers[$exercise->id]->es_correcta)
                                            <p style="color: #16a34a; font-weight: 600; margin-top: 8px;">✅ ¡Correcto!</p>
                                        @else
                                            <p style="color: #dc2626; font-weight: 600; margin-top: 8px;">❌ Incorrecto, intentá de nuevo.</p>
                                        @endif
                                    @endif

                                @else
                                    @foreach($exercise->options as $option)
                                        <label style="display: flex; align-items: center; gap: 10px; padding: 10px 14px; border: 2px solid #e5e7eb; border-radius: 8px; margin-bottom: 8px; cursor: pointer;
                                            @if(isset($answers[$exercise->id]))
                                                @if($option->es_correcta) background: #dcfce7; border-color: #86efac;
                                                @elseif($answers[$exercise->id]->respuesta === $option->texto && !$option->es_correcta) background: #fee2e2; border-color: #fca5a5;
                                                @endif
                                            @endif
                                        ">
                                            <input
                                                type="radio"
                                                name="exercise_{{ $exercise->id }}"
                                                value="{{ $option->texto }}"
                                                {{ isset($answers[$exercise->id]) && $answers[$exercise->id]->respuesta === $option->texto ? 'checked' : '' }}>
                                            <span style="color: #1e293b;">{{ $option->texto }}</span>
                                            @if(isset($answers[$exercise->id]))
                                                @if($option->es_correcta)
                                                    <span style="color: #16a34a; margin-left: auto;">✅</span>
                                                @elseif($answers[$exercise->id]->respuesta === $option->texto && !$option->es_correcta)
                                                    <span style="color: #dc2626; margin-left: auto;">❌</span>
                                                @endif
                                            @endif
                                        </label>
                                    @endforeach
                                @endif
                            </div>
                        @endforeach

                        <button type="submit" style="background: linear-gradient(135deg, #2563eb, #0ea5e9); color: white; padding: 14px 32px; border-radius: 12px; font-weight: 700; font-size: 1rem; border: none; cursor: pointer; width: 100%;">
                            📨 Enviar respuestas
                        </button>
                    </form>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>