<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\CurrencyExchangeService;

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

    // Currency-related methods
    public function getPriceInCurrency(string $currencyCode)
    {
        if ($currencyCode === 'IDR') {
            return $this->total_price; // Assuming orders are stored in IDR
        }

        $currencyService = app(CurrencyExchangeService::class);
        $conversion = $currencyService->convert($this->total_price, 'IDR', $currencyCode);
        
        return $conversion ? $conversion['converted_amount'] : null;
    }

    public function getFormattedPrice(string $currencyCode = 'IDR')
    {
        $amount = $this->getPriceInCurrency($currencyCode);
        if ($amount === null) {
            return 'N/A';
        }

        $currency = Currency::where('code', $currencyCode)->first();
        if ($currency) {
            return $currency->formatAmount($amount);
        }

        return $currencyCode . ' ' . number_format($amount, 2);
    }

    public function getPopularCurrencyPrices()
    {
        $popularCurrencies = ['USD', 'EUR', 'SGD', 'MYR'];
        $prices = [];
        
        foreach ($popularCurrencies as $currencyCode) {
            $price = $this->getPriceInCurrency($currencyCode);
            if ($price !== null) {
                $currency = Currency::where('code', $currencyCode)->first();
                $prices[$currencyCode] = [
                    'amount' => $price,
                    'formatted' => $currency ? $currency->formatAmount($price) : ($currencyCode . ' ' . number_format($price, 2))
                ];
            }
        }
        
        return $prices;
    }
}
