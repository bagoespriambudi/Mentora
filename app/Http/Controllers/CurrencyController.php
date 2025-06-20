<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Currency;
use Illuminate\Http\JsonResponse;

class CurrencyController extends Controller
{
    /**
     * Display currency converter page
     */
    public function index()
    {
        $currencies = Currency::where('is_active', true)->orderBy('name')->get();
        return view('currency.index', compact('currencies'));
    }

    /**
     * Handle AJAX conversion request
     */
    public function convert(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'from' => 'required|string|size:3',
            'to' => 'required|string|size:3'
        ]);

        $fromCurrency = Currency::where('code', strtoupper($validated['from']))->first();
        $toCurrency = Currency::where('code', strtoupper($validated['to']))->first();

        if (!$fromCurrency || !$toCurrency) {
            return response()->json([
                'success' => false,
                'message' => 'Currency not found'
            ], 400);
        }

        // Simple conversion using static rates via USD
        $amount = $validated['amount'];
        $convertedAmount = $amount;
        $exchangeRate = 1;

        if ($validated['from'] !== $validated['to']) {
            // Convert to USD first, then to target currency
            $usdAmount = $amount / $fromCurrency->rate_to_usd;
            $convertedAmount = $usdAmount * $toCurrency->rate_to_usd;
            $exchangeRate = $convertedAmount / $amount;
        }

        return response()->json([
            'success' => true,
            'data' => [
                'original_amount' => $amount,
                'converted_amount' => round($convertedAmount, 2),
                'exchange_rate' => round($exchangeRate, 6),
                'from_currency' => strtoupper($validated['from']),
                'to_currency' => strtoupper($validated['to']),
                'from_symbol' => $fromCurrency->symbol,
                'to_symbol' => $toCurrency->symbol
            ]
        ]);
    }

    /**
     * Get current exchange rates for a specific currency
     */
    public function getRates(Request $request): JsonResponse
    {
        $baseCurrency = $request->get('base', 'USD');
        
        $currency = Currency::where('code', $baseCurrency)->where('is_active', true)->first();
        if (!$currency) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid base currency'
            ], 400);
        }

        // Return all active currencies with their rates relative to base currency
        $currencies = Currency::where('is_active', true)->get();
        $rates = [];
        
        foreach ($currencies as $curr) {
            if ($curr->code !== $baseCurrency) {
                // Convert via USD
                $baseToUsd = 1 / $currency->rate_to_usd;
                $usdToTarget = $curr->rate_to_usd;
                $rates[$curr->code] = $baseToUsd * $usdToTarget;
            } else {
                $rates[$curr->code] = 1;
            }
        }

        return response()->json([
            'success' => true,
            'data' => $rates
        ]);
    }

    /**
     * Display currency management page (Admin only)
     */
    public function adminIndex()
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $currencies = Currency::orderBy('name')->get();
        $totalCurrencies = Currency::count();
        $activeCurrencies = Currency::where('is_active', true)->count();
        $baseCurrency = Currency::where('is_base_currency', true)->first();
        $lastUpdate = Currency::max('last_updated');
        
        return view('admin.currencies.index', compact('currencies', 'totalCurrencies', 'activeCurrencies', 'baseCurrency', 'lastUpdate'));
    }

    /**
     * Display currency management page (Admin only) - Legacy method
     */
    public function manage()
    {
        return $this->adminIndex();
    }

    /**
     * Update exchange rates (Admin only)
     */
    public function updateRates(Request $request)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'rates' => 'required|array',
            'rates.*.code' => 'required|string|size:3',
            'rates.*.rate' => 'required|numeric|min:0'
        ]);

        foreach ($request->rates as $rateData) {
            Currency::where('code', $rateData['code'])
                   ->update([
                       'rate_to_usd' => $rateData['rate'],
                       'last_updated' => now()
                   ]);
        }

        return redirect()->back()->with('success', 'Exchange rates updated successfully.');
    }

    /**
     * Toggle currency status (Admin only)
     */
    public function toggleStatus(Currency $currency)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $currency->update(['is_active' => !$currency->is_active]);
        
        return redirect()->back()->with('success', 
            "Currency {$currency->name} " . ($currency->is_active ? 'activated' : 'deactivated') . " successfully."
        );
    }

    /**
     * Handle AJAX currency conversion for payment forms
     */
    public function ajaxConvert(Request $request): JsonResponse
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'from' => 'required|string|size:3',
            'to' => 'required|string|size:3'
        ]);

        $fromCurrency = Currency::where('code', strtoupper($request->from))->first();
        $toCurrency = Currency::where('code', strtoupper($request->to))->first();

        if (!$fromCurrency || !$toCurrency) {
            return response()->json([
                'success' => false,
                'message' => 'Currency not found'
            ], 400);
        }

        // Simple conversion using static rates via USD
        $amount = $request->amount;
        $convertedAmount = $amount;
        $exchangeRate = 1;

        if ($request->from !== $request->to) {
            // Convert to USD first, then to target currency
            $usdAmount = $amount / $fromCurrency->rate_to_usd;
            $convertedAmount = $usdAmount * $toCurrency->rate_to_usd;
            $exchangeRate = $convertedAmount / $amount;
        }

        return response()->json([
            'success' => true,
            'data' => [
                'original_amount' => $amount,
                'converted_amount' => round($convertedAmount, 2),
                'exchange_rate' => round($exchangeRate, 6),
                'from_currency' => strtoupper($request->from),
                'to_currency' => strtoupper($request->to),
                'from_symbol' => $fromCurrency->symbol,
                'to_symbol' => $toCurrency->symbol
            ]
        ]);
    }
}
