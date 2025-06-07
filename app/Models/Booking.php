<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'tutee_id',
        'status',
        'notes',
        'scheduled_at',
    ];

    public function session()
    {
        return $this->belongsTo(\App\Models\Session::class, 'session_id');
    }

    public function tutee()
    {
        return $this->belongsTo(User::class, 'tutee_id');
    }

    public function payment()
    {
        return $this->belongsTo(\App\Models\PaymentTransaction::class, 'payment_id');
    }
} 