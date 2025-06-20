<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'symbol',
        'rate_to_usd',
        'is_active',
        'is_base_currency',
        'decimal_places',
        'last_updated'
    ];

    protected $casts = [
        'rate_to_usd' => 'decimal:6',
        'is_active' => 'boolean',
        'is_base_currency' => 'boolean',
        'last_updated' => 'datetime'
    ];

    // Scopes
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeBaseCurrency(Builder $query): Builder
    {
        return $query->where('is_base_currency', true);
    }

    // Helper Methods
    public function formatAmount($amount): string
    {
        return $this->symbol . ' ' . number_format($amount, $this->decimal_places, '.', ',');
    }

    public function convertFromUSD($usdAmount): float
    {
        return $usdAmount * $this->rate_to_usd;
    }

    public function convertToUSD($amount): float
    {
        return $amount / $this->rate_to_usd;
    }

    public function convertTo(Currency $targetCurrency, $amount): float
    {
        // Convert to USD first, then to target currency
        $usdAmount = $this->convertToUSD($amount);
        return $targetCurrency->convertFromUSD($usdAmount);
    }

    // Static methods
    public static function getBaseCurrency(): ?Currency
    {
        return static::baseCurrency()->first();
    }

    public static function getByCode(string $code): ?Currency
    {
        return static::where('code', strtoupper($code))->active()->first();
    }

    public static function getActiveList(): array
    {
        return static::active()
            ->orderBy('name')
            ->pluck('name', 'code')
            ->toArray();
    }
}
