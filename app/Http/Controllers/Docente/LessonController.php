<?php

namespace App\Http\Controllers\Docente;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index(Course $course)
    {
        $lessons = $course->lessons;
        return view('docente.lessons.index', compact('course', 'lessons'));
    }

    public function create(Course $course)
    {
        return view('docente.lessons.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $request->validate([
            'titulo'    => 'required|string|max:255',
            'contenido' => 'nullable|string',
            'video_url' => 'nullable|url',
            'pizarra'   => 'nullable|string',
            'orden'     => 'nullable|integer',
        ]);

        $course->lessons()->create([
            'titulo'    => $request->titulo,
            'contenido' => $request->contenido,
            'video_url' => $request->video_url,
            'pizarra'   => $request->pizarra,
            'orden'     => $request->orden ?? 0,
        ]);

        return redirect()->route('docente.courses.lessons.index', $course)
            ->with('success', 'Lección creada correctamente.');
    }

    public function edit(Course $course, Lesson $lesson)
    {
        return view('docente.lessons.edit', compact('course', 'lesson'));
    }

    public function update(Request $request, Course $course, Lesson $lesson)
    {
        $request->validate([
            'titulo'    => 'required|string|max:255',
            'contenido' => 'nullable|string',
            'video_url' => 'nullable|url',
            'pizarra'   => 'nullable|string',
            'orden'     => 'nullable|integer',
        ]);

        $lesson->update([
            'titulo'    => $request->titulo,
            'contenido' => $request->contenido,
            'video_url' => $request->video_url,
            'pizarra'   => $request->pizarra,
            'orden'     => $request->orden ?? 0,
        ]);

        return redirect()->route('docente.courses.lessons.index', $course)
            ->with('success', 'Lección actualizada correctamente.');
    }

    public function destroy(Course $course, Lesson $lesson)
    {
        $lesson->delete();
        return redirect()->route('docente.courses.lessons.index', $course)
            ->with('success', 'Lección eliminada correctamente.');
    }
}