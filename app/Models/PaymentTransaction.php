<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Services\CurrencyExchangeService;

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
        'status',
        'transaction_date',
        'payment_proof'
    ];

    protected $casts = [
        'transaction_date' => 'datetime',
        'amount' => 'decimal:6',
        'amount_usd' => 'decimal:6',
        'exchange_rate' => 'decimal:6'
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

    // Currency-related methods
    public function getFormattedAmountAttribute()
    {
        $currency = Currency::where('code', $this->currency)->first();
        if ($currency) {
            return $currency->formatAmount($this->amount);
        }
        return $this->currency . ' ' . number_format($this->amount, 2);
    }

    public function getFormattedAmountUsdAttribute()
    {
        if ($this->amount_usd) {
            return '$ ' . number_format($this->amount_usd, 2);
        }
        return null;
    }

    public function convertToUSD()
    {
        if ($this->currency === 'USD') {
            return $this->amount;
        }
        
        if ($this->amount_usd) {
            return $this->amount_usd;
        }
        
        // Calculate using current exchange rate if not stored
        $currencyService = app(CurrencyExchangeService::class);
        $conversion = $currencyService->convert($this->amount, $this->currency, 'USD');
        
        return $conversion ? $conversion['converted_amount'] : null;
    }

    public function convertTo(string $targetCurrency)
    {
        if ($this->currency === $targetCurrency) {
            return $this->amount;
        }
        
        $currencyService = app(CurrencyExchangeService::class);
        $conversion = $currencyService->convert($this->amount, $this->currency, $targetCurrency);
        
        return $conversion ? $conversion['converted_amount'] : null;
    }

    public function updateExchangeRateAndUSD()
    {
        if ($this->currency !== 'USD') {
            $currencyService = app(CurrencyExchangeService::class);
            $conversion = $currencyService->convert($this->amount, $this->currency, 'USD');
            
            if ($conversion) {
                $this->update([
                    'amount_usd' => $conversion['converted_amount'],
                    'exchange_rate' => $conversion['exchange_rate']
                ]);
            }
        } else {
            $this->update([
                'amount_usd' => $this->amount,
                'exchange_rate' => 1.000000
            ]);
        }
    }
}
