<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\StudentPoint;
use App\Models\User;

class GamificationService
{
    public function agregarPuntos(User $user, int $puntos, string $motivo): void
    {
        StudentPoint::create([
            'user_id' => $user->id,
            'puntos'  => $puntos,
            'motivo'  => $motivo,
        ]);

        $this->verificarBadges($user);
    }

    public function verificarBadges(User $user): array
    {
        $nuevos = [];
        $badges = Badge::all();
        $badgesActuales = $user->badges->pluck('id')->toArray();

        foreach ($badges as $badge) {
            if (in_array($badge->id, $badgesActuales)) continue;

            $otorgar = false;

            switch ($badge->tipo) {
                case 'lecciones':
                    $lecciones = \App\Models\StudentAnswer::where('user_id', $user->id)
                        ->distinct('exercise_id')
                        ->join('exercises', 'student_answers.exercise_id', '=', 'exercises.id')
                        ->distinct('exercises.lesson_id')
                        ->count('exercises.lesson_id');
                    $otorgar = $lecciones >= $badge->requisito;
                    break;

                case 'correctas':
                    $correctas = \App\Models\StudentAnswer::where('user_id', $user->id)
                        ->where('es_correcta', true)
                        ->count();
                    $otorgar = $correctas >= $badge->requisito;
                    break;

                case 'puntos':
                    $total = StudentPoint::where('user_id', $user->id)->sum('puntos');
                    $otorgar = $total >= $badge->requisito;
                    break;

                case 'perfecto':
                    // Contar lecciones con 10/10
                    $perfectas = 0;
                    $lecciones = \App\Models\Lesson::whereHas('course.alumnos', fn($q) => $q->where('users.id', $user->id))->get();
                    foreach ($lecciones as $leccion) {
                        $exercises = $leccion->exercises;
                        if ($exercises->isEmpty()) continue;
                        $correctas = \App\Models\StudentAnswer::where('user_id', $user->id)
                            ->whereIn('exercise_id', $exercises->pluck('id'))
                            ->where('es_correcta', true)
                            ->count();
                        if ($correctas === $exercises->count()) $perfectas++;
                    }
                    $otorgar = $perfectas >= $badge->requisito;
                    break;
            }

            if ($otorgar) {
                $user->badges()->attach($badge->id);
                $nuevos[] = $badge;
            }
        }

        return $nuevos;
    }
}