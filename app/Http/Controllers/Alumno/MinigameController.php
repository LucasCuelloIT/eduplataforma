<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\MinigameScore;
use App\Models\StudentAnswer;
use Illuminate\Http\Request;

class MinigameController extends Controller
{
    public function show(Course $course, Lesson $lesson)
    {
        // Verificar que el alumno tenga acceso al curso
        $alumno = auth()->user();
        if (!$alumno->courses->contains($course->id)) {
            abort(403);
        }

        // Verificar que haya aprobado con 70% o más
        $exercises = $lesson->exercises()->with('options')->get();
        $total = $exercises->count();

        if ($total === 0) {
            return redirect()->route('alumno.courses.lesson', [$course, $lesson])
                ->with('error', 'Esta lección no tiene ejercicios.');
        }

        $correctas = StudentAnswer::where('user_id', $alumno->id)
            ->whereIn('exercise_id', $exercises->pluck('id'))
            ->where('es_correcta', true)
            ->count();

        $porcentaje = round(($correctas / $total) * 100);

        if ($porcentaje < 70) {
            return redirect()->route('alumno.courses.lesson', [$course, $lesson])
                ->with('error', 'Necesitás al menos 70% para desbloquear el minijuego.');
        }

        // Armar preguntas para el minijuego
        $preguntas = $exercises->map(function ($exercise) {
            $correcta = $exercise->options->firstWhere('es_correcta', true);
            $incorrectas = $exercise->options->where('es_correcta', false)->take(2);
            $opciones = $incorrectas->push($correcta)->shuffle();

            return [
                'pregunta'  => $exercise->pregunta,
                'opciones'  => $opciones->pluck('texto')->values(),
                'correcta'  => $correcta?->texto,
            ];
        })->take(5); // Máximo 5 preguntas por juego

        $score = MinigameScore::where('user_id', $alumno->id)
            ->where('lesson_id', $lesson->id)
            ->first();

        return view('alumno.minigame', compact('course', 'lesson', 'preguntas', 'score'));
    }

    public function store(Request $request, Course $course, Lesson $lesson)
    {
        $request->validate([
            'score'     => 'required|integer|min:0',
            'max_score' => 'required|integer|min:1',
        ]);

        MinigameScore::updateOrCreate(
            ['user_id' => auth()->id(), 'lesson_id' => $lesson->id],
            [
                'score'      => $request->score,
                'max_score'  => $request->max_score,
                'completado' => $request->score >= $request->max_score,
            ]
        );

        return response()->json(['success' => true]);
    }
}