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
            $respuesta = $request->input('exercise_' . $exercise->id);
            if ($respuesta === null) continue;

            $correcta = $exercise->options()
                ->where('es_correcta', true)
                ->first();

            $esCorrecta = $correcta && strtolower(trim($correcta->texto)) === strtolower(trim($respuesta));

            StudentAnswer::updateOrCreate(
                ['user_id' => auth()->id(), 'exercise_id' => $exercise->id],
                ['respuesta' => $respuesta, 'es_correcta' => $esCorrecta]
            );
        }

        return redirect()->route('alumno.courses.lesson', [$course, $lesson])
            ->with('success', '¡Respuestas guardadas!');
    }
}