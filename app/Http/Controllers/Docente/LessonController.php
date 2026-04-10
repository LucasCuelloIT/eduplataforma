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
            'orden'     => 'integer',
        ]);

        $course->lessons()->create($request->all());

        return redirect()->route('docente.courses.lessons.index', $course)->with('success', 'Lección creada correctamente.');
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
            'orden'     => 'integer',
        ]);

        $lesson->update($request->all());

        return redirect()->route('docente.courses.lessons.index', $course)->with('success', 'Lección actualizada correctamente.');
    }

    public function destroy(Course $course, Lesson $lesson)
    {
        $lesson->delete();
        return redirect()->route('docente.courses.lessons.index', $course)->with('success', 'Lección eliminada correctamente.');
    }
}