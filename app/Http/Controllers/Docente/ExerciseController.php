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
            'tipo'               => 'required|in:multiple_choice,verdadero_falso,completar',
            'orden'              => 'integer',
            'opciones'           => 'required_unless:tipo,completar|array',
            'opciones.*'         => 'string',
            'correcta'           => 'required_unless:tipo,completar',
            'respuesta_correcta' => 'required_if:tipo,completar|nullable|string',
        ]);

        $exercise = $lesson->exercises()->create([
            'pregunta' => $request->pregunta,
            'tipo'     => $request->tipo,
            'orden'    => $request->orden ?? 0,
        ]);

        if ($request->tipo === 'completar') {
            $exercise->options()->create([
                'texto'       => $request->respuesta_correcta,
                'es_correcta' => true,
            ]);
        } else {
            foreach ($request->opciones as $index => $opcion) {
                $exercise->options()->create([
                    'texto'       => $opcion,
                    'es_correcta' => ($index == $request->correcta),
                ]);
            }
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
            'orden'              => 'integer',
            'opciones'           => 'required_unless:tipo,completar|array',
            'opciones.*'         => 'string',
            'correcta'           => 'required_unless:tipo,completar',
            'respuesta_correcta' => 'required_if:tipo,completar|nullable|string',
        ]);

        $exercise->update([
            'pregunta' => $request->pregunta,
            'orden'    => $request->orden ?? 0,
        ]);

        // Borramos las opciones anteriores y las recreamos
        $exercise->options()->delete();

        if ($exercise->tipo === 'completar') {
            $exercise->options()->create([
                'texto'       => $request->respuesta_correcta,
                'es_correcta' => true,
            ]);
        } else {
            foreach ($request->opciones as $index => $opcion) {
                $exercise->options()->create([
                    'texto'       => $opcion,
                    'es_correcta' => ($index == $request->correcta),
                ]);
            }
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