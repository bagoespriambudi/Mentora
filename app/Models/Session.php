<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Session extends Model
{
    use HasFactory;

    protected $table = 'tutor_sessions';

    protected $fillable = [
        'tutor_id',
        'category_id',
        'title',
        'description',
        'price',
        'duration_days',
        'thumbnail',
        'gallery',
        'is_active',
        'schedule',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'gallery' => 'array',
        'schedule' => 'datetime',
    ];

    public function tutor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
} 