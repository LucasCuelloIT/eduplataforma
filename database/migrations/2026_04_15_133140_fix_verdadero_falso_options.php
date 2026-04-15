<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Obtener todos los ejercicios que NO son de tipo verdadero_falso
        // pero tienen opciones "Verdadero" o "Falso"
        $exercises = DB::table('exercises')
            ->where('tipo', '!=', 'verdadero_falso')
            ->pluck('id');

        if ($exercises->isEmpty()) return;

        // Borrar las opciones "Verdadero" y "Falso" de esos ejercicios
        DB::table('exercise_options')
            ->whereIn('exercise_id', $exercises)
            ->whereIn('texto', ['Verdadero', 'Falso'])
            ->delete();
    }

    public function down(): void
    {
        // No revertible
    }
};