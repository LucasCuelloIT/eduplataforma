<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    public function aprobar(User $user)
    {
        $user->update(['estado' => 'aprobado']);
        return back()->with('success', 'Usuario aprobado correctamente.');
    }

    public function cambiarRol(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,docente,alumno'
        ]);
        $user->update(['role' => $request->role]);
        return back()->with('success', 'Rol actualizado correctamente.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'Usuario eliminado correctamente.');
    }
}