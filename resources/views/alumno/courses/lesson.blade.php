<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $lesson->titulo }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-4">
                <a href="{{ route('alumno.courses.show', $course) }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded">
                    ← Volver al curso
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Video --}}
            @if($lesson->video_url)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="font-semibold text-lg mb-4">Video</h3>
                        @php
                            preg_match('/(?:v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $lesson->video_url, $matches);
                            $videoId = $matches[1] ?? null;
                        @endphp
                        @if($videoId)
                            <div class="relative" style="padding-bottom: 56.25%;">
                                <iframe
                                    class="absolute top-0 left-0 w-full h-full rounded"
                                    src="https://www.youtube.com/embed/{{ $videoId }}"
                                    frameborder="0"
                                    allowfullscreen>
                                </iframe>
                            </div>
                        @else
                            <a href="{{ $lesson->video_url }}" target="_blank" class="text-blue-500">Ver video</a>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Contenido --}}
            @if($lesson->contenido)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="font-semibold text-lg mb-4">Explicación</h3>
                        <div class="text-gray-700 leading-relaxed">
                            {!! nl2br(e($lesson->contenido)) !!}
                        </div>
                    </div>
                </div>
            @endif

            {{-- Ejercicios --}}
            @if($exercises->isNotEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="font-semibold text-lg mb-4">Ejercicios</h3>

                        @php
                            $totalCorrectas = $answers->where('es_correcta', true)->count();
                            $total = $exercises->count();
                            $nota = $total > 0 ? round(($totalCorrectas / $total) * 10, 1) : 0;
                        @endphp

                        @if($answers->isNotEmpty())
                            <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded">
                                <p class="text-blue-800 font-semibold">Tu nota: {{ $nota }} / 10 ({{ $totalCorrectas }} de {{ $total }} correctas)</p>
                            </div>
                        @endif

                        <form action="{{ route('alumno.courses.responder', [$course, $lesson]) }}" method="POST">
                            @csrf
                            @foreach($exercises as $exercise)
                                <div class="mb-6 border rounded p-4">
                                    <p class="font-semibold mb-3">{{ $loop->iteration }}. {{ $exercise->pregunta }}</p>

                                    @if($exercise->tipo === 'completar')
                                        <input
                                            type="text"
                                            name="exercise_{{ $exercise->id }}"
                                            value="{{ $answers[$exercise->id]->respuesta ?? '' }}"
                                            class="w-full border rounded px-3 py-2"
                                            placeholder="Escribí tu respuesta">

                                        @if(isset($answers[$exercise->id]))
                                            @if($answers[$exercise->id]->es_correcta)
                                                <p class="text-green-600 text-sm mt-1">✓ Correcto</p>
                                            @else
                                                <p class="text-red-600 text-sm mt-1">✗ Incorrecto</p>
                                            @endif
                                        @endif

                                    @else
                                        @foreach($exercise->options as $option)
                                            <label class="flex items-center gap-2 mb-2 cursor-pointer">
                                                <input
                                                    type="radio"
                                                    name="exercise_{{ $exercise->id }}"
                                                    value="{{ $option->texto }}"
                                                    {{ isset($answers[$exercise->id]) && $answers[$exercise->id]->respuesta === $option->texto ? 'checked' : '' }}>
                                                <span>{{ $option->texto }}</span>
                                                @if(isset($answers[$exercise->id]))
                                                    @if($option->es_correcta)
                                                        <span class="text-green-600 text-sm">✓</span>
                                                    @elseif($answers[$exercise->id]->respuesta === $option->texto && !$option->es_correcta)
                                                        <span class="text-red-600 text-sm">✗</span>
                                                    @endif
                                                @endif
                                            </label>
                                        @endforeach
                                    @endif
                                </div>
                            @endforeach

                            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded">
                                Enviar respuestas
                            </button>
                        </form>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>