<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class CourseAssignController extends Controller
{
    public function index()
    {
        $alumnos = User::where('role', 'alumno')->where('estado', 'aprobado')->get();
        $courses = Course::all();
        return view('admin.courses.assign', compact('alumnos', 'courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'   => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        $alumno = User::findOrFail($request->user_id);
        $alumno->courses()->syncWithoutDetaching([$request->course_id]);

        return back()->with('success', 'Curso asignado correctamente.');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'user_id'   => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        $alumno = User::findOrFail($request->user_id);
        $alumno->courses()->detach($request->course_id);

        return back()->with('success', 'Curso removido correctamente.');
    }
}