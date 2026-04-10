<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'materia',
        'grado',
        'user_id',
    ];

    public function creador()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function alumnos()
    {
        return $this->belongsToMany(User::class, 'course_user');
    }
    public function lessons()
{
    return $this->hasMany(Lesson::class)->orderBy('orden');
}
}