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
}
