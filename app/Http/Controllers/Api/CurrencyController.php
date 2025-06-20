<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Services\CurrencyExchangeService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class CurrencyController extends Controller
{
    private CurrencyExchangeService $currencyService;

    public function __construct(CurrencyExchangeService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    /**
     * Get all supported currencies
     * GET /api/currencies
     */
    public function index(): JsonResponse
    {
        try {
            $currencies = $this->currencyService->getSupportedCurrencies();
            
            return response()->json([
                'success' => true,
                'message' => 'Currencies retrieved successfully',
                'data' => $currencies,
                'meta' => [
                    'total' => count($currencies),
                    'timestamp' => now()->toISOString()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve currencies',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get current exchange rates
     * GET /api/currencies/rates?base=USD
     */
    public function getRates(Request $request): JsonResponse
    {
        try {
            $baseCurrency = $request->get('base', 'USD');
            
            // Validate base currency
            if (!Currency::getByCode($baseCurrency)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid base currency code',
                    'error' => "Currency code '{$baseCurrency}' is not supported"
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
                'message' => 'Exchange rates retrieved successfully',
                'data' => [
                    'base_currency' => $rates['base'],
                    'rates' => $rates['rates'],
                    'source' => $rates['source'],
                    'last_updated' => date('Y-m-d H:i:s', $rates['timestamp'])
                ],
                'meta' => [
                    'total_currencies' => count($rates['rates']),
                    'cache_source' => isset($rates['cached']) ? 'cache' : 'api',
                    'timestamp' => now()->toISOString()
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve exchange rates',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Convert currency amount
     * POST /api/currencies/convert
     */
    public function convert(Request $request): JsonResponse
    {
        try {
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
                    'message' => 'Currency conversion failed',
                    'error' => 'One or both currency codes are not supported'
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => 'Currency converted successfully',
                'data' => $conversion,
                'meta' => [
                    'conversion_time' => now()->toISOString(),
                    'api_version' => '1.0'
                ]
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Currency conversion failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get specific currency details
     * GET /api/currencies/{code}
     */
    public function show(string $code): JsonResponse
    {
        try {
            $currency = Currency::getByCode($code);
            
            if (!$currency) {
                return response()->json([
                    'success' => false,
                    'message' => 'Currency not found',
                    'error' => "Currency code '{$code}' is not supported"
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Currency details retrieved successfully',
                'data' => [
                    'code' => $currency->code,
                    'name' => $currency->name,
                    'symbol' => $currency->symbol,
                    'decimal_places' => $currency->decimal_places,
                    'rate_to_usd' => $currency->rate_to_usd,
                    'is_base_currency' => $currency->is_base_currency,
                    'last_updated' => $currency->last_updated?->toISOString()
                ],
                'meta' => [
                    'timestamp' => now()->toISOString()
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve currency details',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk convert multiple amounts
     * POST /api/currencies/bulk-convert
     */
    public function bulkConvert(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'conversions' => 'required|array|max:10',
                'conversions.*.amount' => 'required|numeric|min:0',
                'conversions.*.from' => 'required|string|size:3',
                'conversions.*.to' => 'required|string|size:3',
            ]);

            $results = [];
            foreach ($validated['conversions'] as $index => $conversionData) {
                $conversion = $this->currencyService->convert(
                    $conversionData['amount'],
                    strtoupper($conversionData['from']),
                    strtoupper($conversionData['to'])
                );

                $results[] = [
                    'index' => $index,
                    'success' => $conversion !== null,
                    'data' => $conversion,
                    'error' => $conversion === null ? 'Invalid currency codes' : null
                ];
            }

            $successCount = count(array_filter($results, fn($r) => $r['success']));

            return response()->json([
                'success' => true,
                'message' => "Bulk conversion completed: {$successCount}/" . count($results) . " successful",
                'data' => $results,
                'meta' => [
                    'total_conversions' => count($results),
                    'successful_conversions' => $successCount,
                    'timestamp' => now()->toISOString()
                ]
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Bulk conversion failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update exchange rates (Admin only)
     * POST /api/currencies/update-rates
     */
    public function updateRates(Request $request): JsonResponse
    {
        try {
            // Check if user is admin
            if (!auth()->check() || auth()->user()->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. Admin access required.'
                ], 403);
            }

            $updated = $this->currencyService->updateDatabaseRates();
            
            if ($updated) {
                // Clear cache to force fresh data
                $this->currencyService->clearCache();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Exchange rates updated successfully',
                    'data' => [
                        'updated_at' => now()->toISOString(),
                        'cache_cleared' => true
                    ]
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update exchange rates'
                ], 503);
            }
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update exchange rates',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clear currency cache (Admin only)
     * DELETE /api/currencies/cache
     */
    public function clearCache(Request $request): JsonResponse
    {
        try {
            // Check if user is admin
            if (!auth()->check() || auth()->user()->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. Admin access required.'
                ], 403);
            }

            $cleared = $this->currencyService->clearCache();
            
            return response()->json([
                'success' => true,
                'message' => 'Currency cache cleared successfully',
                'data' => [
                    'cleared_at' => now()->toISOString()
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear cache',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create a new currency (Admin only)
     * POST /api/currencies
     */
    public function store(Request $request): JsonResponse
    {
        try {
            // Check if user is admin
            if (!auth()->check() || auth()->user()->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. Admin access required.'
                ], 403);
            }

            $validated = $request->validate([
                'code' => 'required|string|size:3|unique:currencies,code',
                'name' => 'required|string|max:255',
                'symbol' => 'required|string|max:10',
                'rate_to_usd' => 'required|numeric|min:0.000001',
                'decimal_places' => 'required|integer|min:0|max:6',
                'is_active' => 'boolean'
            ]);

            // Ensure code is uppercase
            $validated['code'] = strtoupper($validated['code']);

            // Create the currency
            $currency = Currency::create([
                'code' => $validated['code'],
                'name' => $validated['name'],
                'symbol' => $validated['symbol'],
                'rate_to_usd' => $validated['rate_to_usd'],
                'decimal_places' => $validated['decimal_places'],
                'is_active' => $validated['is_active'] ?? true,
                'is_base_currency' => false, // New currencies cannot be base by default
                'last_updated' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Currency created successfully',
                'data' => [
                    'id' => $currency->id,
                    'code' => $currency->code,
                    'name' => $currency->name,
                    'symbol' => $currency->symbol,
                    'rate_to_usd' => $currency->rate_to_usd,
                    'decimal_places' => $currency->decimal_places,
                    'is_active' => $currency->is_active,
                    'created_at' => $currency->created_at->toISOString()
                ]
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create currency',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update a specific currency (Admin only)
     * PUT /api/currencies/{code}
     */
    public function update(Request $request, string $code): JsonResponse
    {
        try {
            // Check if user is admin
            if (!auth()->check() || auth()->user()->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. Admin access required.'
                ], 403);
            }

            $currency = Currency::where('code', strtoupper($code))->first();
            
            if (!$currency) {
                return response()->json([
                    'success' => false,
                    'message' => 'Currency not found',
                    'error' => "Currency code '{$code}' does not exist"
                ], 404);
            }

            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
                'symbol' => 'sometimes|string|max:10',
                'rate_to_usd' => 'sometimes|numeric|min:0.000001',
                'decimal_places' => 'sometimes|integer|min:0|max:6',
                'is_active' => 'sometimes|boolean'
            ]);

            // Prevent deactivating base currency
            if (isset($validated['is_active']) && !$validated['is_active'] && $currency->is_base_currency) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot deactivate base currency'
                ], 400);
            }

            // Update the currency
            $currency->update(array_merge($validated, ['last_updated' => now()]));

            return response()->json([
                'success' => true,
                'message' => 'Currency updated successfully',
                'data' => [
                    'code' => $currency->code,
                    'name' => $currency->name,
                    'symbol' => $currency->symbol,
                    'rate_to_usd' => $currency->rate_to_usd,
                    'decimal_places' => $currency->decimal_places,
                    'is_active' => $currency->is_active,
                    'is_base_currency' => $currency->is_base_currency,
                    'last_updated' => $currency->last_updated->toISOString()
                ]
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update currency',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a specific currency (Admin only)
     * DELETE /api/currencies/{code}
     */
    public function destroy(string $code): JsonResponse
    {
        try {
            // Check if user is admin
            if (!auth()->check() || auth()->user()->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. Admin access required.'
                ], 403);
            }

            $currency = Currency::where('code', strtoupper($code))->first();
            
            if (!$currency) {
                return response()->json([
                    'success' => false,
                    'message' => 'Currency not found',
                    'error' => "Currency code '{$code}' does not exist"
                ], 404);
            }

            // Prevent deleting base currency
            if ($currency->is_base_currency) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete base currency',
                    'error' => 'Base currency is required for the system to function'
                ], 400);
            }

            // Check if currency is being used in any transactions/orders
            // This would depend on your business logic - for now we'll just check if it's active
            if ($currency->is_active) {
                // Instead of hard delete, we'll deactivate
                $currency->update(['is_active' => false, 'last_updated' => now()]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Currency deactivated instead of deletion (safety measure)',
                    'data' => [
                        'code' => $currency->code,
                        'is_active' => false,
                        'action' => 'deactivated'
                    ]
                ]);
            }

            // Delete the currency
            $currencyData = [
                'code' => $currency->code,
                'name' => $currency->name
            ];
            
            $currency->delete();

            return response()->json([
                'success' => true,
                'message' => 'Currency deleted successfully',
                'data' => array_merge($currencyData, ['action' => 'deleted'])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete currency',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
