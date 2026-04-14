<?php

namespace App\Http\Controllers\Docente;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Exercise;
use App\Models\Lesson;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    public function index(Course $course, Lesson $lesson)
    {
        $exercises = $lesson->exercises()->orderBy('orden')->get();
        return view('docente.exercises.index', compact('course', 'lesson', 'exercises'));
    }

    public function create(Course $course, Lesson $lesson)
    {
        return view('docente.exercises.create', compact('course', 'lesson'));
    }

    public function store(Request $request, Course $course, Lesson $lesson)
    {
        $request->validate([
            'pregunta'           => 'required|string',
            'tipo'               => 'required|in:multiple_choice,verdadero_falso,completar,ordenar,unir,tabla',
            'orden'              => 'nullable|integer',
            'opciones'           => 'nullable|array',
            'opciones.*'         => 'nullable|string',
            'correcta'           => 'nullable',
            'respuesta_correcta' => 'nullable|string',
            'pares'              => 'nullable|array',
            'pares.*.izquierda'  => 'nullable|string',
            'pares.*.derecha'    => 'nullable|string',
            'columnas'           => 'nullable|array',
            'filas'              => 'nullable|array',
        ]);

        $exercise = $lesson->exercises()->create([
            'pregunta' => $request->pregunta,
            'tipo'     => $request->tipo,
            'orden'    => $request->orden ?? 0,
        ]);

        switch ($request->tipo) {
            case 'completar':
                $exercise->options()->create([
                    'texto' => $request->respuesta_correcta,
                    'es_correcta' => true,
                ]);
                break;

            case 'ordenar':
                // Guardar los elementos en el orden correcto
                foreach ($request->opciones as $index => $opcion) {
                    if (empty($opcion)) continue;
                    $exercise->options()->create([
                        'texto' => $opcion,
                        'es_correcta' => true, // el orden correcto es el ingresado
                    ]);
                }
                break;

            case 'unir':
                // Guardar pares izquierda|derecha
                foreach ($request->pares as $par) {
                    if (empty($par['izquierda']) || empty($par['derecha'])) continue;
                    $exercise->options()->create([
                        'texto' => $par['izquierda'] . '|' . $par['derecha'],
                        'es_correcta' => true,
                    ]);
                }
                break;

            case 'tabla':
                // Guardar estructura: columnas y filas como JSON
                $exercise->options()->create([
                    'texto' => json_encode([
                        'columnas' => $request->columnas ?? [],
                        'filas'    => $request->filas ?? [],
                    ]),
                    'es_correcta' => true,
                ]);
                break;

            default:
                // multiple_choice y verdadero_falso
                foreach ($request->opciones as $index => $opcion) {
                    if (empty($opcion)) continue;
                    $exercise->options()->create([
                        'texto'       => $opcion,
                        'es_correcta' => ($index == $request->correcta),
                    ]);
                }
                break;
        }

        return redirect()->route('docente.courses.lessons.exercises.index', [$course, $lesson])
            ->with('success', 'Ejercicio creado correctamente.');
    }

    public function edit(Course $course, Lesson $lesson, Exercise $exercise)
    {
        $exercise->load('options');
        return view('docente.exercises.edit', compact('course', 'lesson', 'exercise'));
    }

    public function update(Request $request, Course $course, Lesson $lesson, Exercise $exercise)
    {
        $request->validate([
            'pregunta'           => 'required|string',
            'orden'              => 'nullable|integer',
            'opciones'           => 'nullable|array',
            'opciones.*'         => 'nullable|string',
            'correcta'           => 'nullable',
            'respuesta_correcta' => 'nullable|string',
            'pares'              => 'nullable|array',
            'pares.*.izquierda'  => 'nullable|string',
            'pares.*.derecha'    => 'nullable|string',
            'columnas'           => 'nullable|array',
            'filas'              => 'nullable|array',
        ]);

        $exercise->update([
            'pregunta' => $request->pregunta,
            'orden'    => $request->orden ?? 0,
        ]);

        $exercise->options()->delete();

        switch ($exercise->tipo) {
            case 'completar':
                $exercise->options()->create([
                    'texto' => $request->respuesta_correcta,
                    'es_correcta' => true,
                ]);
                break;

            case 'ordenar':
                foreach ($request->opciones as $index => $opcion) {
                    if (empty($opcion)) continue;
                    $exercise->options()->create([
                        'texto' => $opcion,
                        'es_correcta' => true,
                    ]);
                }
                break;

            case 'unir':
                foreach ($request->pares as $par) {
                    if (empty($par['izquierda']) || empty($par['derecha'])) continue;
                    $exercise->options()->create([
                        'texto' => $par['izquierda'] . '|' . $par['derecha'],
                        'es_correcta' => true,
                    ]);
                }
                break;

            case 'tabla':
                $exercise->options()->create([
                    'texto' => json_encode([
                        'columnas' => $request->columnas ?? [],
                        'filas'    => $request->filas ?? [],
                    ]),
                    'es_correcta' => true,
                ]);
                break;

            default:
                foreach ($request->opciones as $index => $opcion) {
                    if (empty($opcion)) continue;
                    $exercise->options()->create([
                        'texto'       => $opcion,
                        'es_correcta' => ($index == $request->correcta),
                    ]);
                }
                break;
        }

        return redirect()->route('docente.courses.lessons.exercises.index', [$course, $lesson])
            ->with('success', 'Ejercicio actualizado correctamente.');
    }

    public function destroy(Course $course, Lesson $lesson, Exercise $exercise)
    {
        $exercise->delete();
        return redirect()->route('docente.courses.lessons.exercises.index', [$course, $lesson])
            ->with('success', 'Ejercicio eliminado correctamente.');
    }
}