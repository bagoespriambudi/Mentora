<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tutor_id',
        'session_id',
        'order_id',
        'amount',
        'currency',
        'amount_usd',
        'exchange_rate',
        'payment_method',
        'payment_proof',
        'status',
        'notes',
        'transaction_date',
    ];

    protected $casts = [
        'transaction_date' => 'datetime',
        'amount' => 'decimal:6',
        'amount_usd' => 'decimal:6',
        'exchange_rate' => 'decimal:6'
    ];

    protected $dates = [
        'transaction_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function refundRequest()
    {
        return $this->hasOne(RefundRequest::class, 'transaction_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency', 'code');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'yellow',
            'completed' => 'green',
            'cancelled' => 'red',
            'refunded' => 'blue',
            default => 'gray'
        };
    }

    public function getFormattedAmountAttribute()
    {
        $currency = Currency::where('code', $this->currency)->first();
        if ($currency) {
            return $currency->symbol . ' ' . number_format($this->amount, 2);
        }
        return $this->currency . ' ' . number_format($this->amount, 2);
    }

    public function getFormattedAmountUsdAttribute()
    {
        return '$' . number_format($this->amount_usd, 2);
    }
}
