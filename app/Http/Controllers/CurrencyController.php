<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Currency;
use App\Services\CurrencyExchangeService;
use Illuminate\Http\JsonResponse;

class CurrencyController extends Controller
{
    private CurrencyExchangeService $currencyService;

    public function __construct(CurrencyExchangeService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    /**
     * Display currency converter page
     */
    public function index()
    {
        $currencies = Currency::active()->orderBy('name')->get();
        $baseCurrency = Currency::getBaseCurrency();
        
        return view('currency.index', compact('currencies', 'baseCurrency'));
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

        $conversion = $this->currencyService->convert(
            $validated['amount'],
            strtoupper($validated['from']),
            strtoupper($validated['to'])
        );

        if (!$conversion) {
            return response()->json([
                'success' => false,
                'message' => 'Currency conversion failed. Please check your currency codes.'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $conversion
        ]);
    }

    /**
     * Get current exchange rates for a specific currency
     */
    public function getRates(Request $request): JsonResponse
    {
        $baseCurrency = $request->get('base', 'USD');
        
        if (!Currency::getByCode($baseCurrency)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid base currency'
            ], 400);
        }

        $rates = $this->currencyService->getCurrentRates($baseCurrency);
        
        if (!$rates) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve exchange rates'
            ], 503);
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

        $currencies = Currency::orderBy('name')->paginate(15);
        $totalCurrencies = Currency::count();
        $activeCurrencies = Currency::active()->count();
        $baseCurrency = Currency::getBaseCurrency();
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

        $updated = $this->currencyService->updateDatabaseRates();
        
        if ($updated) {
            return redirect()->back()->with('success', 'Exchange rates updated successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to update exchange rates.');
        }
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
        
        $status = $currency->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "Currency {$currency->name} has been {$status}.");
    }

    /**
     * Handle AJAX currency conversion for payment forms
     */
    public function ajaxConvert(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'from' => 'required|string|size:3',
            'to' => 'required|string|size:3'
        ]);

        try {
            $conversion = $this->currencyService->convert(
                $request->amount,
                $request->from,
                $request->to
            );

            if ($conversion) {
                return response()->json([
                    'success' => true,
                    'data' => $conversion
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Currency conversion failed'
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during conversion'
            ], 500);
        }
    }
}
