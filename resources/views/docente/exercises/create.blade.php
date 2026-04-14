<x-app-layout>
    <x-slot name="header">
        <h2>➕ Nuevo Ejercicio en: {{ $lesson->titulo }}</h2>
        <p style="color: rgba(255,255,255,0.8); font-size: 0.9rem; margin-top: 4px;">{{ $course->titulo }}</p>
    </x-slot>

    <div style="padding: 24px;">
        <div style="max-width: 800px; margin: 0 auto;">

            <div style="margin-bottom: 16px;">
                <a href="{{ route('docente.courses.lessons.exercises.index', [$course, $lesson]) }}" style="color: #2563eb; font-weight: 600; text-decoration: none;">← Volver a Ejercicios</a>
            </div>

            <div style="background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 24px;">
                <form action="{{ route('docente.courses.lessons.exercises.store', [$course, $lesson]) }}" method="POST">
                    @csrf

                    @if($errors->any())
                        <div style="background: #fee2e2; border: 1px solid #fca5a5; color: #dc2626; padding: 12px 16px; border-radius: 10px; margin-bottom: 16px;">
                            <p style="font-weight: 700; margin-bottom: 4px;">Por favor corregí estos errores:</p>
                            <ul style="margin-left: 16px;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 6px;">Pregunta</label>
                        <textarea name="pregunta" rows="3" style="width: 100%; border: 2px solid #e5e7eb; border-radius: 10px; padding: 10px 14px; font-size: 1rem;" required>{{ old('pregunta') }}</textarea>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 6px;">Tipo de ejercicio</label>
                        <select name="tipo" id="tipo" style="width: 100%; border: 2px solid #e5e7eb; border-radius: 10px; padding: 10px 14px; font-size: 1rem;" required onchange="mostrarOpciones()">
                            <option value="">Seleccioná un tipo</option>
                            <option value="multiple_choice" {{ old('tipo') == 'multiple_choice' ? 'selected' : '' }}>Múltiple Choice</option>
                            <option value="verdadero_falso" {{ old('tipo') == 'verdadero_falso' ? 'selected' : '' }}>Verdadero / Falso</option>
                            <option value="completar" {{ old('tipo') == 'completar' ? 'selected' : '' }}>Completar el espacio</option>
                            <option value="ordenar" {{ old('tipo') == 'ordenar' ? 'selected' : '' }}>🔀 Ordenar elementos</option>
                            <option value="unir" {{ old('tipo') == 'unir' ? 'selected' : '' }}>🔗 Unir con flechas</option>
                            <option value="tabla" {{ old('tipo') == 'tabla' ? 'selected' : '' }}>📊 Completar tabla</option>
                        </select>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 6px;">Orden</label>
                        <input type="number" name="orden" value="{{ old('orden', 0) }}" style="width: 100%; border: 2px solid #e5e7eb; border-radius: 10px; padding: 10px 14px; font-size: 1rem;">
                    </div>

                    <!-- Múltiple choice -->
                    <div id="opciones_multiple" style="display: none; margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 12px;">Opciones (marcá la correcta)</label>
                        @for($i = 0; $i < 4; $i++)
                            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                                <input type="radio" name="correcta" value="{{ $i }}" style="width: 18px; height: 18px;">
                                <input type="text" name="opciones[]" placeholder="Opción {{ $i + 1 }}" style="flex: 1; border: 2px solid #e5e7eb; border-radius: 10px; padding: 10px 14px; font-size: 1rem;">
                            </div>
                        @endfor
                    </div>

                    <!-- Verdadero/Falso -->
                    <div id="opciones_vf" style="display: none; margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 12px;">¿Cuál es la respuesta correcta?</label>
                        <div style="display: flex; gap: 16px;">
                            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; background: #f0fdf4; border: 2px solid #86efac; padding: 10px 20px; border-radius: 10px;">
                                <input type="radio" name="correcta" value="0"> ✅ Verdadero
                            </label>
                            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; background: #fef2f2; border: 2px solid #fca5a5; padding: 10px 20px; border-radius: 10px;">
                                <input type="radio" name="correcta" value="1"> ❌ Falso
                            </label>
                        </div>
                        <input type="hidden" name="vf_opciones[0]" value="Verdadero">
                        <input type="hidden" name="vf_opciones[1]" value="Falso">
                    </div>

                    <!-- Completar -->
                    <div id="opciones_completar" style="display: none; margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 6px;">Respuesta correcta</label>
                        <input type="text" name="respuesta_correcta" placeholder="Escribí la respuesta correcta" style="width: 100%; border: 2px solid #e5e7eb; border-radius: 10px; padding: 10px 14px; font-size: 1rem;">
                    </div>

                    <!-- Ordenar -->
                    <div id="opciones_ordenar" style="display: none; margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 6px;">Elementos en el orden correcto</label>
                        <p style="color: #6b7280; font-size: 0.85rem; margin-bottom: 12px;">Escribí los elementos en el orden correcto. El alumno los verá mezclados y deberá ordenarlos.</p>
                        <div id="ordenar-items">
                            @for($i = 0; $i < 4; $i++)
                                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                                    <span style="background: #dbeafe; color: #1d4ed8; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; flex-shrink: 0;">{{ $i + 1 }}</span>
                                    <input type="text" name="opciones[]" placeholder="Elemento {{ $i + 1 }}" style="flex: 1; border: 2px solid #e5e7eb; border-radius: 10px; padding: 10px 14px; font-size: 1rem;">
                                </div>
                            @endfor
                        </div>
                        <button type="button" onclick="agregarOrdenar()" style="background: #dbeafe; color: #1d4ed8; border: none; padding: 8px 16px; border-radius: 8px; cursor: pointer; font-weight: 600; margin-top: 8px;">+ Agregar elemento</button>
                    </div>

                    <!-- Unir con flechas -->
                    <div id="opciones_unir" style="display: none; margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 6px;">Pares a unir</label>
                        <p style="color: #6b7280; font-size: 0.85rem; margin-bottom: 12px;">Escribí los pares que el alumno debe unir con flechas.</p>
                        <div style="display: grid; grid-template-columns: 1fr auto 1fr; gap: 8px; align-items: center; margin-bottom: 8px;">
                            <span style="font-weight: 600; color: #6b7280; font-size: 0.85rem; text-align: center;">Columna izquierda</span>
                            <span></span>
                            <span style="font-weight: 600; color: #6b7280; font-size: 0.85rem; text-align: center;">Columna derecha</span>
                        </div>
                        <div id="unir-pares">
                            @for($i = 0; $i < 3; $i++)
                                <div style="display: grid; grid-template-columns: 1fr auto 1fr; gap: 8px; align-items: center; margin-bottom: 10px;">
                                    <input type="text" name="pares[{{ $i }}][izquierda]" placeholder="Elemento izquierdo" style="border: 2px solid #e5e7eb; border-radius: 10px; padding: 10px 14px; font-size: 1rem;">
                                    <span style="color: #6b7280; font-size: 1.2rem;">↔</span>
                                    <input type="text" name="pares[{{ $i }}][derecha]" placeholder="Elemento derecho" style="border: 2px solid #e5e7eb; border-radius: 10px; padding: 10px 14px; font-size: 1rem;">
                                </div>
                            @endfor
                        </div>
                        <button type="button" onclick="agregarPar()" style="background: #dbeafe; color: #1d4ed8; border: none; padding: 8px 16px; border-radius: 8px; cursor: pointer; font-weight: 600; margin-top: 8px;">+ Agregar par</button>
                    </div>

                    <!-- Tabla -->
                    <div id="opciones_tabla" style="display: none; margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 6px;">Configurar tabla</label>
                        <p style="color: #6b7280; font-size: 0.85rem; margin-bottom: 12px;">Definí los encabezados y dejá las celdas vacías que el alumno debe completar.</p>
                        <div style="margin-bottom: 12px;">
                            <label style="font-weight: 600; color: #374151; font-size: 0.9rem;">Columnas (encabezados):</label>
                            <div id="tabla-columnas" style="display: flex; gap: 8px; margin-top: 8px; flex-wrap: wrap;">
                                @for($i = 0; $i < 3; $i++)
                                    <input type="text" name="columnas[]" placeholder="Columna {{ $i + 1 }}" style="border: 2px solid #e5e7eb; border-radius: 10px; padding: 8px 12px; font-size: 0.9rem; width: 150px;">
                                @endfor
                            </div>
                            <button type="button" onclick="agregarColumna()" style="background: #dbeafe; color: #1d4ed8; border: none; padding: 6px 12px; border-radius: 8px; cursor: pointer; font-weight: 600; margin-top: 8px; font-size: 0.85rem;">+ Columna</button>
                        </div>
                        <div>
                            <label style="font-weight: 600; color: #374151; font-size: 0.9rem;">Filas (dejá vacío lo que el alumno debe completar):</label>
                            <div id="tabla-filas" style="margin-top: 8px;">
                                @for($i = 0; $i < 2; $i++)
                                    <div style="display: flex; gap: 8px; margin-bottom: 8px;">
                                        @for($j = 0; $j < 3; $j++)
                                            <input type="text" name="filas[{{ $i }}][]" placeholder="Celda" style="border: 2px solid #e5e7eb; border-radius: 10px; padding: 8px 12px; font-size: 0.9rem; width: 150px;">
                                        @endfor
                                    </div>
                                @endfor
                            </div>
                            <button type="button" onclick="agregarFila()" style="background: #dbeafe; color: #1d4ed8; border: none; padding: 6px 12px; border-radius: 8px; cursor: pointer; font-weight: 600; margin-top: 8px; font-size: 0.85rem;">+ Fila</button>
                        </div>
                    </div>

                    <div style="display: flex; gap: 12px; margin-top: 24px;">
                        <button type="submit" style="background: linear-gradient(135deg, #2563eb, #0ea5e9); color: white; padding: 12px 28px; border-radius: 10px; font-weight: 700; border: none; cursor: pointer; font-size: 1rem;">
                            ✅ Crear Ejercicio
                        </button>
                        <a href="{{ route('docente.courses.lessons.exercises.index', [$course, $lesson]) }}" style="background: #e5e7eb; color: #374151; padding: 12px 28px; border-radius: 10px; font-weight: 700; text-decoration: none; font-size: 1rem;">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let ordenarCount = 4;
        let unirCount = 3;
        let tablaColumnas = 3;
        let tablaFilas = 2;

        function mostrarOpciones() {
            const tipo = document.getElementById('tipo').value;
            ['multiple', 'vf', 'completar', 'ordenar', 'unir', 'tabla'].forEach(t => {
                document.getElementById('opciones_' + t).style.display = 'none';
            });
            if (tipo) document.getElementById('opciones_' + tipo.replace('multiple_choice', 'multiple').replace('verdadero_falso', 'vf')).style.display = 'block';
        }

        function agregarOrdenar() {
            ordenarCount++;
            const div = document.createElement('div');
            div.style = 'display: flex; align-items: center; gap: 10px; margin-bottom: 10px;';
            div.innerHTML = `<span style="background: #dbeafe; color: #1d4ed8; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; flex-shrink: 0;">${ordenarCount}</span>
                <input type="text" name="opciones[]" placeholder="Elemento ${ordenarCount}" style="flex: 1; border: 2px solid #e5e7eb; border-radius: 10px; padding: 10px 14px; font-size: 1rem;">`;
            document.getElementById('ordenar-items').appendChild(div);
        }

        function agregarPar() {
            const div = document.createElement('div');
            div.style = 'display: grid; grid-template-columns: 1fr auto 1fr; gap: 8px; align-items: center; margin-bottom: 10px;';
            div.innerHTML = `<input type="text" name="pares[${unirCount}][izquierda]" placeholder="Elemento izquierdo" style="border: 2px solid #e5e7eb; border-radius: 10px; padding: 10px 14px; font-size: 1rem;">
                <span style="color: #6b7280; font-size: 1.2rem;">↔</span>
                <input type="text" name="pares[${unirCount}][derecha]" placeholder="Elemento derecho" style="border: 2px solid #e5e7eb; border-radius: 10px; padding: 10px 14px; font-size: 1rem;">`;
            document.getElementById('unir-pares').appendChild(div);
            unirCount++;
        }

        function agregarColumna() {
            tablaColumnas++;
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'columnas[]';
            input.placeholder = `Columna ${tablaColumnas}`;
            input.style = 'border: 2px solid #e5e7eb; border-radius: 10px; padding: 8px 12px; font-size: 0.9rem; width: 150px;';
            document.getElementById('tabla-columnas').appendChild(input);
        }

        function agregarFila() {
            const div = document.createElement('div');
            div.style = 'display: flex; gap: 8px; margin-bottom: 8px;';
            let inputs = '';
            for (let j = 0; j < tablaColumnas; j++) {
                inputs += `<input type="text" name="filas[${tablaFilas}][]" placeholder="Celda" style="border: 2px solid #e5e7eb; border-radius: 10px; padding: 8px 12px; font-size: 0.9rem; width: 150px;">`;
            }
            div.innerHTML = inputs;
            document.getElementById('tabla-filas').appendChild(div);
            tablaFilas++;
        }

        window.onload = mostrarOpciones;
    </script>
</x-app-layout>