<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'bio',
        'education_level',
        'subjects',
        'hourly_rate',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'subjects' => 'array',
        'hourly_rate' => 'decimal:2',
    ];

    public function isTutor(): bool
    {
        return $this->role === 'tutor';
    }

    public function isTutee(): bool
    {
        return $this->role === 'tutee';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
