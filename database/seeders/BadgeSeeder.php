<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    public function run(): void
    {
        $badges = [
            // Lecciones completadas
            ['nombre' => '¡Primera lección!', 'descripcion' => 'Completaste tu primera lección', 'icono' => '🌟', 'tipo' => 'lecciones', 'requisito' => 1],
            ['nombre' => 'Estudiante', 'descripcion' => 'Completaste 5 lecciones', 'icono' => '📚', 'tipo' => 'lecciones', 'requisito' => 5],
            ['nombre' => 'Dedicado', 'descripcion' => 'Completaste 10 lecciones', 'icono' => '🎓', 'tipo' => 'lecciones', 'requisito' => 10],
            ['nombre' => 'Sabio', 'descripcion' => 'Completaste 25 lecciones', 'icono' => '🦉', 'tipo' => 'lecciones', 'requisito' => 25],

            // Ejercicios correctos
            ['nombre' => '¡Buen comienzo!', 'descripcion' => 'Respondiste 10 ejercicios correctamente', 'icono' => '✅', 'tipo' => 'correctas', 'requisito' => 10],
            ['nombre' => 'Preciso', 'descripcion' => 'Respondiste 50 ejercicios correctamente', 'icono' => '🎯', 'tipo' => 'correctas', 'requisito' => 50],
            ['nombre' => 'Experto', 'descripcion' => 'Respondiste 100 ejercicios correctamente', 'icono' => '🏆', 'tipo' => 'correctas', 'requisito' => 100],

            // Puntaje
            ['nombre' => 'Acumulador', 'descripcion' => 'Juntaste 100 puntos', 'icono' => '💰', 'tipo' => 'puntos', 'requisito' => 100],
            ['nombre' => 'Rico en saber', 'descripcion' => 'Juntaste 500 puntos', 'icono' => '💎', 'tipo' => 'puntos', 'requisito' => 500],
            ['nombre' => 'Millonario del conocimiento', 'descripcion' => 'Juntaste 1000 puntos', 'icono' => '👑', 'tipo' => 'puntos', 'requisito' => 1000],

            // Nota perfecta
            ['nombre' => '¡Perfecto!', 'descripcion' => 'Obtuviste 10/10 en una lección', 'icono' => '💯', 'tipo' => 'perfecto', 'requisito' => 1],
            ['nombre' => 'Infalible', 'descripcion' => 'Obtuviste 10/10 en 5 lecciones', 'icono' => '⚡', 'tipo' => 'perfecto', 'requisito' => 5],
        ];

        foreach ($badges as $badge) {
            Badge::firstOrCreate(['nombre' => $badge['nombre']], $badge);
        }
    }
}