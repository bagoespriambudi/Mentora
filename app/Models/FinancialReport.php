<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FinancialReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_type',
        'start_date',
        'end_date',
        'total_revenue',
        'total_refunds',
        'net_revenue'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'total_revenue' => 'decimal:2',
        'total_refunds' => 'decimal:2',
        'net_revenue' => 'decimal:2'
    ];
}
