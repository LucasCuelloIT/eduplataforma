<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'pregunta',
        'tipo',
        'orden',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function options()
    {
        return $this->hasMany(ExerciseOption::class);
    }

    public function correctOption()
    {
        return $this->hasOne(ExerciseOption::class)->where('es_correcta', true);
    }
}