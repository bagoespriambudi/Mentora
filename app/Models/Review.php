<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'tutee_id',
        'tutor_id',
        'session_id',
        'rating',
        'review',
        'response',
    ];

    public function tutee()
    {
        return $this->belongsTo(User::class, 'tutee_id');
    }

    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }
}
