<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TutorProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bio',
        'qualification_file',
        'hourly_rate',
        'expertise',
        'availability',
        'is_available',
        'is_available_for_sessions',
    ];

    protected $casts = [
        'expertise' => 'array',
        'availability' => 'array',
        'is_available' => 'boolean',
        'is_available_for_sessions' => 'boolean',
        'hourly_rate' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
} 