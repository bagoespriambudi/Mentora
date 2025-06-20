<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'client_id',
        'status',
        'notes',
        'order_date',
        'total_price'
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'total_price' => 'decimal:2'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    // Add relationship to payments
    public function payments()
    {
        return $this->hasMany(PaymentTransaction::class, 'order_id');
    }

    // Get the latest payment for this order
    public function latestPayment()
    {
        return $this->hasOne(PaymentTransaction::class, 'order_id')->latest();
    }

    // Check if order is paid
    public function isPaid()
    {
        return $this->payments()->where('status', 'completed')->exists();
    }

    // Get total paid amount
    public function getTotalPaidAmount()
    {
        return $this->payments()->where('status', 'completed')->sum('amount');
    }

    // Check if order has pending payment
    public function hasPendingPayment()
    {
        return $this->payments()->where('status', 'pending')->exists();
    }
}
