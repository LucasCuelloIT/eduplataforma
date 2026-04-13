<?php

namespace App\Http\Controllers\Docente;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\StudentAnswer;

class ReportController extends Controller
{
    public function index()
    {
        $courses = Course::where('user_id', auth()->id())
            ->with(['alumnos', 'lessons.exercises'])
            ->get();

        return view('docente.reports.index', compact('courses'));
    }

    public function show(Course $course)
    {
        $course->load(['alumnos', 'lessons.exercises.options']);

        $totalLecciones = $course->lessons->count();
        $totalEjercicios = $course->lessons->sum(fn($l) => $l->exercises->count());

        $reporte = [];

        foreach ($course->alumnos as $alumno) {
            $ejerciciosRespondidos = StudentAnswer::where('user_id', $alumno->id)
                ->whereHas('exercise.lesson', fn($q) => $q->where('course_id', $course->id))
                ->count();

            $ejerciciosCorrectos = StudentAnswer::where('user_id', $alumno->id)
                ->where('es_correcta', true)
                ->whereHas('exercise.lesson', fn($q) => $q->where('course_id', $course->id))
                ->count();

            $leccionesCompletadas = 0;
            foreach ($course->lessons as $lesson) {
                $ejerciciosDeLeccion = $lesson->exercises->count();
                if ($ejerciciosDeLeccion === 0) continue;
                $respondidos = StudentAnswer::where('user_id', $alumno->id)
                    ->whereIn('exercise_id', $lesson->exercises->pluck('id'))
                    ->count();
                if ($respondidos >= $ejerciciosDeLeccion) {
                    $leccionesCompletadas++;
                }
            }

            $porcentajeCompletado = $totalLecciones > 0
                ? round(($leccionesCompletadas / $totalLecciones) * 100)
                : 0;

            $nota = $totalEjercicios > 0
                ? round(($ejerciciosCorrectos / $totalEjercicios) * 10, 1)
                : 0;

            $reporte[] = [
                'alumno'                 => $alumno,
                'ejerciciosCorrectos'    => $ejerciciosCorrectos,
                'totalEjercicios'        => $totalEjercicios,
                'leccionesCompletadas'   => $leccionesCompletadas,
                'totalLecciones'         => $totalLecciones,
                'porcentajeCompletado'   => $porcentajeCompletado,
                'nota'                   => $nota,
            ];
        }

        return view('docente.reports.show', compact('course', 'reporte'));
    }
}