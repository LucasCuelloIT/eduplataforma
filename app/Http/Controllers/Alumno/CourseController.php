<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\StudentAnswer;
use App\Services\GamificationService;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    protected GamificationService $gamification;

    public function __construct(GamificationService $gamification)
    {
        $this->gamification = $gamification;
    }

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
        $answersForDisplay = StudentAnswer::where('user_id', auth()->id())
            ->whereIn('exercise_id', $exercises->pluck('id'))
            ->get()
            ->keyBy('exercise_id');

        return view('alumno.courses.lesson', compact('course', 'lesson', 'exercises', 'answersForDisplay'));
    }

    public function responder(Request $request, Course $course, Lesson $lesson)
    {
        $exercises = $lesson->exercises()->orderBy('orden')->get();
        $user = auth()->user();
        $puntosGanados = 0;
        $nuevosCorrects = 0;

        foreach ($exercises as $exercise) {

            $yaRespondioCorrect = StudentAnswer::where('user_id', $user->id)
                ->where('exercise_id', $exercise->id)
                ->where('es_correcta', true)
                ->exists();

            switch ($exercise->tipo) {

                case 'completar':
                    $respuesta = $request->input('exercise_' . $exercise->id);
                    if ($respuesta === null) continue 2;
                    $correcta = $exercise->options()->where('es_correcta', true)->first();
                    $esCorrecta = $correcta && strtolower(trim($correcta->texto)) === strtolower(trim($respuesta));
                    StudentAnswer::updateOrCreate(
                        ['user_id' => $user->id, 'exercise_id' => $exercise->id],
                        ['respuesta' => $respuesta, 'es_correcta' => $esCorrecta]
                    );
                    if ($esCorrecta && !$yaRespondioCorrect) { $puntosGanados += 10; $nuevosCorrects++; }
                    break;

                case 'ordenar':
                    $respuesta = $request->input('exercise_' . $exercise->id);
                    if (empty($respuesta)) continue 2;
                    $correctas = $exercise->options()->orderBy('id')->pluck('texto')->implode('|');
                    $esCorrecta = $respuesta === $correctas;
                    StudentAnswer::updateOrCreate(
                        ['user_id' => $user->id, 'exercise_id' => $exercise->id],
                        ['respuesta' => $respuesta, 'es_correcta' => $esCorrecta]
                    );
                    if ($esCorrecta && !$yaRespondioCorrect) { $puntosGanados += 15; $nuevosCorrects++; }
                    break;

                case 'unir':
    $respuesta = $request->input('exercise_' . $exercise->id);
    if (empty($respuesta)) continue 2;

    // Normalizar pares correctos
    $paresCorrectos = $exercise->options->map(function($o) {
        $partes = explode('|', $o->texto);
        return strtolower(trim($partes[0])) . '|' . strtolower(trim($partes[1]));
    })->sort()->values()->implode(',');

    // Normalizar pares del alumno
    $paresAlumno = collect(explode(',', $respuesta))->map(function($par) {
        $partes = explode('|', $par);
        return strtolower(trim($partes[0])) . '|' . strtolower(trim($partes[1]));
    })->sort()->values()->implode(',');

    $esCorrecta = $paresCorrectos === $paresAlumno;

    StudentAnswer::updateOrCreate(
        ['user_id' => $user->id, 'exercise_id' => $exercise->id],
        ['respuesta' => $respuesta, 'es_correcta' => $esCorrecta]
    );
    if ($esCorrecta && !$yaRespondioCorrect) { $puntosGanados += 15; $nuevosCorrects++; }
    break;

                case 'tabla':
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
                        ['user_id' => $user->id, 'exercise_id' => $exercise->id],
                        ['respuesta' => $respuesta, 'es_correcta' => $todasCorrectas && !empty($respuesta)]
                    );
                    if ($todasCorrectas && !$yaRespondioCorrect) { $puntosGanados += 20; $nuevosCorrects++; }
                    break;

                default:
                    $respuesta = $request->input('exercise_' . $exercise->id);
                    if ($respuesta === null) continue 2;
                    $correcta = $exercise->options()->where('es_correcta', true)->first();
                    $esCorrecta = $correcta && strtolower(trim($correcta->texto)) === strtolower(trim($respuesta));
                    StudentAnswer::updateOrCreate(
                        ['user_id' => $user->id, 'exercise_id' => $exercise->id],
                        ['respuesta' => $respuesta, 'es_correcta' => $esCorrecta]
                    );
                    if ($esCorrecta && !$yaRespondioCorrect) { $puntosGanados += 10; $nuevosCorrects++; }
                    break;
            }
        }

        // Agregar puntos y verificar badges
        if ($puntosGanados > 0) {
            $this->gamification->agregarPuntos($user, $puntosGanados, "Ejercicios correctos en: {$lesson->titulo}");
        }

        // Puntos extra por lección completa
        $totalEjercicios = $exercises->count();
        $totalCorrectas = StudentAnswer::where('user_id', $user->id)
            ->whereIn('exercise_id', $exercises->pluck('id'))
            ->where('es_correcta', true)
            ->count();

        if ($totalEjercicios > 0 && $totalCorrectas === $totalEjercicios) {
            $this->gamification->agregarPuntos($user, 50, "¡Lección perfecta!: {$lesson->titulo}");
        }

        $nuevosBadges = $this->gamification->verificarBadges($user);

        $mensaje = '¡Respuestas guardadas!';
        if ($puntosGanados > 0) $mensaje .= " +{$puntosGanados} puntos 🌟";
        if (!empty($nuevosBadges)) {
            $nombres = collect($nuevosBadges)->map(fn($b) => $b->icono . ' ' . $b->nombre)->implode(', ');
            $mensaje .= " | Nuevo badge: {$nombres}";
        }

        return redirect()->route('alumno.courses.lesson', [$course, $lesson])
            ->with('success', $mensaje);
    }
}