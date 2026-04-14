<x-app-layout>
    <x-slot name="header">
        <h2>Nueva Lección en: {{ $course->titulo }}</h2>
    </x-slot>

    <div style="padding: 24px;">
        <div style="max-width: 900px; margin: 0 auto;">

            <div style="margin-bottom: 16px;">
                <a href="{{ route('docente.courses.lessons.index', $course) }}" style="color: #2563eb; font-weight: 600; text-decoration: none;">← Volver a Lecciones</a>
            </div>

            <div style="background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); padding: 24px;">
                <form action="{{ route('docente.courses.lessons.store', $course) }}" method="POST">
                    @csrf

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 6px;">Título</label>
                        <input type="text" name="titulo" value="{{ old('titulo') }}"
                            style="width: 100%; border: 2px solid #e5e7eb; border-radius: 10px; padding: 10px 14px; font-size: 1rem;"
                            required>
                        @error('titulo') <p style="color: #dc2626; font-size: 0.85rem; margin-top: 4px;">{{ $message }}</p> @enderror
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 6px;">Contenido / Explicación</label>

                        <!-- Barra de herramientas -->
                        <div id="editor-toolbar" style="display: flex; flex-wrap: wrap; gap: 6px; background: #f8faff; border: 2px solid #e5e7eb; border-bottom: none; border-radius: 10px 10px 0 0; padding: 10px;">
                            <button type="button" data-action="bold" title="Negrita" style="padding: 6px 10px; border-radius: 6px; border: 1px solid #e5e7eb; background: white; cursor: pointer; font-weight: 800;">B</button>
                            <button type="button" data-action="italic" title="Cursiva" style="padding: 6px 10px; border-radius: 6px; border: 1px solid #e5e7eb; background: white; cursor: pointer; font-style: italic;">I</button>
                            <button type="button" data-action="h2" title="Título grande" style="padding: 6px 10px; border-radius: 6px; border: 1px solid #e5e7eb; background: white; cursor: pointer; font-weight: 700;">H2</button>
                            <button type="button" data-action="h3" title="Título mediano" style="padding: 6px 10px; border-radius: 6px; border: 1px solid #e5e7eb; background: white; cursor: pointer; font-weight: 700;">H3</button>
                            <button type="button" data-action="bullet" title="Lista con viñetas" style="padding: 6px 10px; border-radius: 6px; border: 1px solid #e5e7eb; background: white; cursor: pointer;">• Lista</button>
                            <button type="button" data-action="ordered" title="Lista numerada" style="padding: 6px 10px; border-radius: 6px; border: 1px solid #e5e7eb; background: white; cursor: pointer;">1. Lista</button>
                            <button type="button" data-action="link" title="Agregar link" style="padding: 6px 10px; border-radius: 6px; border: 1px solid #e5e7eb; background: white; cursor: pointer;">🔗 Link</button>
                            <button type="button" data-action="unlink" title="Quitar link" style="padding: 6px 10px; border-radius: 6px; border: 1px solid #e5e7eb; background: white; cursor: pointer;">🚫 Link</button>
                            <button type="button" data-action="clear" title="Limpiar formato" style="padding: 6px 10px; border-radius: 6px; border: 1px solid #e5e7eb; background: white; cursor: pointer;">✕ Formato</button>
                        </div>

                        <!-- Editor -->
                        <div id="editor" style="border: 2px solid #e5e7eb; border-radius: 0 0 10px 10px; padding: 16px; min-height: 200px; font-size: 1rem; line-height: 1.7; background: white;"></div>

                        <!-- Input oculto que guarda el HTML -->
                        <input type="hidden" name="contenido" id="contenido" value="{{ old('contenido') }}">
                        @error('contenido') <p style="color: #dc2626; font-size: 0.85rem; margin-top: 4px;">{{ $message }}</p> @enderror
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 6px;">URL del Video (YouTube)</label>
                        <input type="url" name="video_url" value="{{ old('video_url') }}"
                            style="width: 100%; border: 2px solid #e5e7eb; border-radius: 10px; padding: 10px 14px; font-size: 1rem;"
                            placeholder="https://www.youtube.com/watch?v=...">
                        @error('video_url') <p style="color: #dc2626; font-size: 0.85rem; margin-top: 4px;">{{ $message }}</p> @enderror
                    </div>

                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 6px;">Orden</label>
                        <input type="number" name="orden" value="{{ old('orden', 0) }}"
                            style="width: 100%; border: 2px solid #e5e7eb; border-radius: 10px; padding: 10px 14px; font-size: 1rem;">
                    </div>
                    <div style="margin-bottom: 24px;">
    <label style="display: block; font-weight: 600; color: #374151; margin-bottom: 6px;">🎨 Pizarra virtual</label>

    <!-- Toolbar -->
    <div style="display: flex; flex-wrap: wrap; gap: 8px; background: #f8faff; border: 2px solid #e5e7eb; border-bottom: none; border-radius: 10px 10px 0 0; padding: 10px;">
        <button type="button" id="pizarra-draw" style="padding: 6px 12px; border-radius: 6px; border: 1px solid #e5e7eb; background: linear-gradient(135deg, #2563eb, #0ea5e9); color: white; cursor: pointer; font-weight: 700; font-size: 0.85rem;">✏️ Dibujar</button>
        <button type="button" id="pizarra-text" style="padding: 6px 12px; border-radius: 6px; border: 1px solid #e5e7eb; background: white; cursor: pointer; font-weight: 700; font-size: 0.85rem;">T Texto</button>
        <button type="button" id="pizarra-select" style="padding: 6px 12px; border-radius: 6px; border: 1px solid #e5e7eb; background: white; cursor: pointer; font-weight: 700; font-size: 0.85rem;">↖ Seleccionar</button>
        <button type="button" id="pizarra-delete" style="padding: 6px 12px; border-radius: 6px; border: 1px solid #e5e7eb; background: #fee2e2; color: #dc2626; cursor: pointer; font-weight: 700; font-size: 0.85rem;">🗑️ Borrar</button>
        <button type="button" id="pizarra-clear" style="padding: 6px 12px; border-radius: 6px; border: 1px solid #e5e7eb; background: #fef9c3; color: #a16207; cursor: pointer; font-weight: 700; font-size: 0.85rem;">🧹 Limpiar todo</button>
        <input type="color" id="pizarra-color" value="#1e293b" title="Color" style="width: 36px; height: 36px; border: 2px solid #e5e7eb; border-radius: 6px; cursor: pointer; padding: 2px;">
        <input type="range" id="pizarra-size" min="1" max="20" value="3" style="width: 80px; accent-color: #2563eb;">
        <button type="button" id="pizarra-save" style="padding: 6px 12px; border-radius: 6px; border: none; background: linear-gradient(135deg, #16a34a, #22c55e); color: white; cursor: pointer; font-weight: 700; font-size: 0.85rem;">💾 Guardar pizarra</button>
        <span id="pizarra-saved" style="display: none; color: #16a34a; font-weight: 700; font-size: 0.85rem; align-self: center;">✅ Guardado</span>
    </div>

    <!-- Canvas -->
    <div style="border: 2px solid #e5e7eb; border-radius: 0 0 10px 10px; overflow: hidden; background: white;">
        <canvas id="pizarra-canvas"></canvas>
    </div>

    <!-- Input oculto -->
    <input type="hidden" name="pizarra" id="pizarra-data" value="{{ old('pizarra') }}">
</div>

                    <div style="display: flex; gap: 12px;">
                        <button type="submit" style="background: linear-gradient(135deg, #2563eb, #0ea5e9); color: white; padding: 12px 28px; border-radius: 10px; font-weight: 700; border: none; cursor: pointer; font-size: 1rem;">
                            💾 Crear Lección
                        </button>
                        <a href="{{ route('docente.courses.lessons.index', $course) }}" style="background: #e5e7eb; color: #374151; padding: 12px 28px; border-radius: 10px; font-weight: 700; text-decoration: none; font-size: 1rem;">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        @vite('resources/js/tiptap-editor.js')
        @vite('resources/js/pizarra.js')
    @endpush
</x-app-layout>