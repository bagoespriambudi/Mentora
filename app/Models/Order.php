<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'service_id',
        'total_price',
        'status',
        'notes',
        'additional_requirements'
    ];

    protected $casts = [
        'total_price' => 'decimal:2'
    ];

    // Relationships
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function payments()
    {
        return $this->hasMany(PaymentTransaction::class);
    }

    public function latestPayment()
    {
        return $this->hasOne(PaymentTransaction::class)->latestOfMany();
    }

    // Status methods
    public function isPaid()
    {
        return $this->payments()->where('status', 'completed')->exists();
    }

    public function hasPendingPayment()
    {
        return $this->payments()->where('status', 'pending')->exists();
    }

    public function getTotalPaidAmount()
    {
        return $this->payments()->where('status', 'completed')->sum('amount');
    }

    // Scopes
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

    // Helper methods
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'yellow',
            'confirmed' => 'blue',
            'completed' => 'green',
            'cancelled' => 'red',
            default => 'gray'
        };
    }
}
