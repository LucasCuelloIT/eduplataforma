<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\StudentAnswer;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = auth()->user()->courses;
        return view('alumno.courses.index', compact('courses'));
    }

    public function show(Course $course)
    {
        $lessons = $course->lessons;
        return view('alumno.courses.show', compact('course', 'lessons'));
    }

    public function lesson(Course $course, Lesson $lesson)
    {
        $exercises = $lesson->exercises()->orderBy('orden')->get();
        $answers = StudentAnswer::where('user_id', auth()->id())
            ->whereIn('exercise_id', $exercises->pluck('id'))
            ->get()
            ->keyBy('exercise_id');
        return view('alumno.courses.lesson', compact('course', 'lesson', 'exercises', 'answers'));
    }

    public function responder(Request $request, Course $course, Lesson $lesson)
    {
        $exercises = $lesson->exercises()->orderBy('orden')->get();

        foreach ($exercises as $exercise) {

            switch ($exercise->tipo) {

                case 'completar':
                    $respuesta = $request->input('exercise_' . $exercise->id);
                    if ($respuesta === null) continue 2;
                    $correcta = $exercise->options()->where('es_correcta', true)->first();
                    $esCorrecta = $correcta && strtolower(trim($correcta->texto)) === strtolower(trim($respuesta));
                    StudentAnswer::updateOrCreate(
                        ['user_id' => auth()->id(), 'exercise_id' => $exercise->id],
                        ['respuesta' => $respuesta, 'es_correcta' => $esCorrecta]
                    );
                    break;

                case 'ordenar':
                    $respuesta = $request->input('exercise_' . $exercise->id);
                    if (empty($respuesta)) continue 2;
                    $correctas = $exercise->options()->orderBy('id')->pluck('texto')->implode('|');
                    $esCorrecta = $respuesta === $correctas;
                    StudentAnswer::updateOrCreate(
                        ['user_id' => auth()->id(), 'exercise_id' => $exercise->id],
                        ['respuesta' => $respuesta, 'es_correcta' => $esCorrecta]
                    );
                    break;

                case 'unir':
                    $respuesta = $request->input('exercise_' . $exercise->id);
                    if (empty($respuesta)) continue 2;
                    // Verificar que todos los pares sean correctos
                    $paresCorrectos = $exercise->options->map(fn($o) => $o->texto)->sort()->values()->implode(',');
                    $paresAlumno = collect(explode(',', $respuesta))->sort()->values()->implode(',');
                    $esCorrecta = $paresCorrectos === $paresAlumno;
                    StudentAnswer::updateOrCreate(
                        ['user_id' => auth()->id(), 'exercise_id' => $exercise->id],
                        ['respuesta' => $respuesta, 'es_correcta' => $esCorrecta]
                    );
                    break;

                case 'tabla':
                    // Recolectar todas las celdas de la tabla
                    $tablaData = json_decode($exercise->options->first()?->texto, true);
                    $filas = $tablaData['filas'] ?? [];
                    $respuestas = [];
                    $todasCorrectas = true;
                    foreach ($filas as $fi => $fila) {
                        foreach ($fila as $ci => $celda) {
                            if (empty($celda)) {
                                $input = $request->input("exercise_{$exercise->id}_tabla_{$fi}_{$ci}");
                                $respuestas[] = $input ?? '';
                                if (empty($input)) $todasCorrectas = false;
                            }
                        }
                    }
                    $respuesta = implode('|', $respuestas);
                    StudentAnswer::updateOrCreate(
                        ['user_id' => auth()->id(), 'exercise_id' => $exercise->id],
                        ['respuesta' => $respuesta, 'es_correcta' => $todasCorrectas && !empty($respuesta)]
                    );
                    break;

                default:
                    // multiple_choice y verdadero_falso
                    $respuesta = $request->input('exercise_' . $exercise->id);
                    if ($respuesta === null) continue 2;
                    $correcta = $exercise->options()->where('es_correcta', true)->first();
                    $esCorrecta = $correcta && strtolower(trim($correcta->texto)) === strtolower(trim($respuesta));
                    StudentAnswer::updateOrCreate(
                        ['user_id' => auth()->id(), 'exercise_id' => $exercise->id],
                        ['respuesta' => $respuesta, 'es_correcta' => $esCorrecta]
                    );
                    break;
            }
        }

        return redirect()->route('alumno.courses.lesson', [$course, $lesson])
            ->with('success', '¡Respuestas guardadas!');
    }
}