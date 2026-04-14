<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // MySQL (producción)
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE exercises MODIFY COLUMN tipo ENUM('multiple_choice', 'verdadero_falso', 'completar', 'ordenar', 'unir', 'tabla') NOT NULL");
        }
        // SQLite (desarrollo local) - no necesita cambios ya que no tiene ENUM estricto
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE exercises MODIFY COLUMN tipo ENUM('multiple_choice', 'verdadero_falso', 'completar') NOT NULL");
        }
    }
};