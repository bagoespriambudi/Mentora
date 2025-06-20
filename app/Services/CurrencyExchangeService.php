<?php

namespace App\Services;

use App\Models\Currency;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Exception;

class CurrencyExchangeService
{
    private const CACHE_PREFIX = 'currency_rates_';
    private const CACHE_DURATION = 3600; // 1 hour in seconds
    private const API_BASE_URL = 'https://api.exchangerate-api.com/v4/latest/';
    
    // Fallback API (Free tier): https://fixer.io/
    private const FALLBACK_API_URL = 'https://api.fixer.io/latest';
    
    /**
     * Get current exchange rates from external API
     */
    public function getCurrentRates(string $baseCurrency = 'USD'): ?array
    {
        $cacheKey = self::CACHE_PREFIX . strtoupper($baseCurrency);
        
        // Try to get from cache first
        $cachedRates = Cache::get($cacheKey);
        if ($cachedRates) {
            Log::info("Currency rates retrieved from cache for {$baseCurrency}");
            return $cachedRates;
        }
        
        // Fetch from API if not in cache
        try {
            $rates = $this->fetchRatesFromAPI($baseCurrency);
            if ($rates) {
                // Cache the rates
                Cache::put($cacheKey, $rates, self::CACHE_DURATION);
                Log::info("Currency rates fetched and cached for {$baseCurrency}");
                return $rates;
            }
        } catch (Exception $e) {
            Log::error("Failed to fetch currency rates: " . $e->getMessage());
        }
        
        // Return fallback rates if API fails
        return $this->getFallbackRates($baseCurrency);
    }
    
    /**
     * Fetch rates from external API
     */
    private function fetchRatesFromAPI(string $baseCurrency): ?array
    {
        try {
            $response = Http::timeout(10)->get(self::API_BASE_URL . $baseCurrency);
            
            if ($response->successful()) {
                $data = $response->json();
                return [
                    'base' => $data['base'],
                    'rates' => $data['rates'],
                    'timestamp' => now()->timestamp,
                    'source' => 'exchangerate-api.com'
                ];
            }
        } catch (Exception $e) {
            Log::warning("Primary API failed, trying fallback: " . $e->getMessage());
        }
        
        return null;
    }
    
    /**
     * Get fallback rates (static or from database)
     */
    private function getFallbackRates(string $baseCurrency): array
    {
        // Static fallback rates (you can also fetch from database)
        $fallbackRates = [
            'USD' => [
                'EUR' => 0.85,
                'GBP' => 0.73,
                'JPY' => 110.0,
                'IDR' => 15000.0,
                'SGD' => 1.35,
                'MYR' => 4.2,
                'AUD' => 1.35,
                'CAD' => 1.25,
            ]
        ];
        
        $rates = $fallbackRates[$baseCurrency] ?? [];
        $rates[$baseCurrency] = 1.0; // Base currency rate is always 1
        
        return [
            'base' => $baseCurrency,
            'rates' => $rates,
            'timestamp' => now()->timestamp,
            'source' => 'fallback'
        ];
    }
    
    /**
     * Update database with latest rates
     */
    public function updateDatabaseRates(): bool
    {
        try {
            $ratesData = $this->getCurrentRates('USD');
            if (!$ratesData) {
                return false;
            }
            
            $updatedCount = 0;
            
            foreach ($ratesData['rates'] as $currencyCode => $rate) {
                $currency = Currency::where('code', $currencyCode)->first();
                if ($currency) {
                    $currency->update([
                        'rate_to_usd' => $rate,
                        'last_updated' => now()
                    ]);
                    $updatedCount++;
                }
            }
            
            Log::info("Updated {$updatedCount} currency rates in database");
            return true;
            
        } catch (Exception $e) {
            Log::error("Failed to update database rates: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Convert amount between currencies
     */
    public function convert(float $amount, string $fromCurrency, string $toCurrency): ?array
    {
        try {
            $fromCurr = Currency::getByCode($fromCurrency);
            $toCurr = Currency::getByCode($toCurrency);
            
            if (!$fromCurr || !$toCurr) {
                return null;
            }
            
            // If same currency, no conversion needed
            if ($fromCurrency === $toCurrency) {
                return [
                    'original_amount' => $amount,
                    'converted_amount' => $amount,
                    'from_currency' => $fromCurrency,
                    'to_currency' => $toCurrency,
                    'exchange_rate' => 1.0,
                    'formatted_original' => $fromCurr->formatAmount($amount),
                    'formatted_converted' => $toCurr->formatAmount($amount),
                ];
            }
            
            // Get fresh rates for accurate conversion
            $rates = $this->getCurrentRates('USD');
            $fromRate = $rates['rates'][$fromCurrency] ?? $fromCurr->rate_to_usd;
            $toRate = $rates['rates'][$toCurrency] ?? $toCurr->rate_to_usd;
            
            // Convert: amount -> USD -> target currency
            $usdAmount = $amount / $fromRate;
            $convertedAmount = $usdAmount * $toRate;
            $exchangeRate = $toRate / $fromRate;
            
            return [
                'original_amount' => $amount,
                'converted_amount' => round($convertedAmount, $toCurr->decimal_places),
                'from_currency' => $fromCurrency,
                'to_currency' => $toCurrency,
                'exchange_rate' => round($exchangeRate, 6),
                'formatted_original' => $fromCurr->formatAmount($amount),
                'formatted_converted' => $toCurr->formatAmount($convertedAmount),
                'timestamp' => now()->toISOString()
            ];
            
        } catch (Exception $e) {
            Log::error("Currency conversion failed: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Get supported currencies list
     */
    public function getSupportedCurrencies(): array
    {
        return Currency::active()
            ->select('code', 'name', 'symbol')
            ->orderBy('name')
            ->get()
            ->toArray();
    }
    
    /**
     * Clear currency cache
     */
    public function clearCache(): bool
    {
        $currencies = ['USD', 'EUR', 'IDR', 'GBP', 'JPY', 'SGD', 'MYR'];
        
        foreach ($currencies as $currency) {
            Cache::forget(self::CACHE_PREFIX . $currency);
        }
        
        return true;
    }
} 