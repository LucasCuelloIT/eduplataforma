<?php

namespace App\Http\Controllers\Docente;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::where('user_id', auth()->id())->get();
        return view('docente.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('docente.courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'materia'     => 'required|string|max:255',
            'grado'       => 'required|string|max:255',
        ]);

        Course::create([
            'titulo'      => $request->titulo,
            'descripcion' => $request->descripcion,
            'materia'     => $request->materia,
            'grado'       => $request->grado,
            'user_id'     => auth()->id(),
        ]);

        return redirect()->route('docente.courses.index')->with('success', 'Curso creado correctamente.');
    }

    public function edit(Course $course)
    {
        return view('docente.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'titulo'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'materia'     => 'required|string|max:255',
            'grado'       => 'required|string|max:255',
        ]);

        $course->update($request->all());
        return redirect()->route('docente.courses.index')->with('success', 'Curso actualizado correctamente.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('docente.courses.index')->with('success', 'Curso eliminado correctamente.');
    }
}