<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'estado'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function courses()
{
    return $this->belongsToMany(Course::class, 'course_user');
}
public function studentAnswers()
{
    return $this->hasMany(\App\Models\StudentAnswer::class);
}
public function points()
{
    return $this->hasMany(StudentPoint::class);
}

public function totalPoints()
{
    return $this->points()->sum('puntos');
}

public function badges()
{
    return $this->belongsToMany(Badge::class, 'student_badges');
}

}
