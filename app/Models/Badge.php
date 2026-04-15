<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'icono', 'tipo', 'requisito'];

    public function students()
    {
        return $this->belongsToMany(User::class, 'student_badges');
    }
}