<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Docente\DashboardController as DocenteDashboard;
use App\Http\Controllers\Alumno\DashboardController as AlumnoDashboard;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    if ($role === 'admin') return redirect()->route('admin.dashboard');
    if ($role === 'docente') return redirect()->route('docente.dashboard');
    if ($role === 'alumno') return redirect()->route('alumno.dashboard');
    abort(403);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/aprobar', [AdminUserController::class, 'aprobar'])->name('users.aprobar');
    Route::patch('/users/{user}/rol', [AdminUserController::class, 'cambiarRol'])->name('users.cambiarRol');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
});

Route::middleware(['auth', 'verified', 'role:docente'])->prefix('docente')->name('docente.')->group(function () {
    Route::get('/dashboard', [DocenteDashboard::class, 'index'])->name('dashboard');
    Route::resource('/courses', \App\Http\Controllers\Docente\CourseController::class);
    Route::resource('/courses.lessons', \App\Http\Controllers\Docente\LessonController::class);
});

Route::middleware(['auth', 'verified', 'role:alumno'])->prefix('alumno')->name('alumno.')->group(function () {
    Route::get('/dashboard', [AlumnoDashboard::class, 'index'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';