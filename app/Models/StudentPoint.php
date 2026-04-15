<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPoint extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'puntos', 'motivo'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}