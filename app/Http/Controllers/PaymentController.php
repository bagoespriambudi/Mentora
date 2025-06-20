<?php

namespace App\Http\Controllers;

use App\Models\PaymentTransaction;
use App\Models\Booking;
use App\Models\Order;
use App\Models\Currency;
use App\Services\CurrencyExchangeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    private CurrencyExchangeService $currencyService;

    public function __construct(CurrencyExchangeService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    public function index()
    {
        $transactions = PaymentTransaction::where('user_id', Auth::id())
            ->with(['tutor', 'session', 'order.service', 'currency'])
            ->latest()
            ->paginate(10);

        return view('payments.index', compact('transactions'));
    }

    public function create()
    {
        $currencies = Currency::active()->orderBy('name')->get();
        return view('payments.create', compact('currencies'));
    }

    // New method for creating payment from order
    public function createFromOrder(Order $order)
    {
        // Pastikan user adalah pemilik order
        if ($order->client_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Pastikan order belum dibayar dan tidak dalam status cancelled
        if ($order->isPaid() || $order->hasPendingPayment() || $order->status === 'cancelled') {
            return redirect()->route('orders.show', $order)->with('error', 'This order cannot be paid.');
        }

        // Load relasi yang diperlukan
        $order->load(['service.tutor', 'service.category']);
        
        // Get available currencies for payment
        $currencies = Currency::active()->orderBy('name')->get();
        $baseCurrency = Currency::getBaseCurrency();

        return view('payments.create-from-order', compact('order', 'currencies', 'baseCurrency'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3|exists:currencies,code',
            'payment_method' => 'required|string',
            'payment_proof' => 'nullable|image|max:2048'
        ]);

        $user = Auth::user();
        // Find outstanding bookings for this tutee and link them to this payment
        $outstandingBookings = Booking::where('tutee_id', $user->id)
            ->whereNull('payment_id')
            ->whereNotIn('status', ['cancelled', 'completed'])
            ->with('session')
            ->get();

        if ($outstandingBookings->isEmpty()) {
            return redirect()->route('payments.create')->with('error', 'No outstanding bookings to pay for.');
        }

        // Use the tutor_id from the first outstanding booking's session
        $firstBooking = $outstandingBookings->first();
        $session = $firstBooking->session;
        if (!$session) {
            return redirect()->route('payments.create')->with('error', 'Booking session not found.');
        }

        // Get currency conversion data
        $currency = Currency::where('code', $validated['currency'])->first();
        $conversion = null;
        
        if ($validated['currency'] !== 'USD') {
            $conversion = $this->currencyService->convert(
                $validated['amount'], 
                $validated['currency'], 
                'USD'
            );
        }

        $validated['tutor_id'] = $session->tutor_id;
        $validated['user_id'] = $user->id;
        $validated['status'] = 'pending';
        $validated['transaction_date'] = now();
        
        // Add currency data
        if ($conversion) {
            $validated['amount_usd'] = $conversion['converted_amount'];
            $validated['exchange_rate'] = $conversion['exchange_rate'];
        } else {
            $validated['amount_usd'] = $validated['amount'];
            $validated['exchange_rate'] = 1.000000;
        }

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            $validated['payment_proof'] = $path;
        }

        $payment = PaymentTransaction::create($validated);

        foreach ($outstandingBookings as $booking) {
            $booking->update(['payment_id' => $payment->id]);
        }

        return redirect()->route('payments.show', $payment)->with('success', 'Payment created successfully.');
    }

    // New method for storing payment from order with currency conversion
    public function storeFromOrder(Request $request, Order $order)
    {
        // Pastikan user adalah pemilik order
        if ($order->client_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Pastikan order belum dibayar
        if ($order->isPaid() || $order->hasPendingPayment() || $order->status === 'cancelled') {
            return redirect()->route('orders.show', $order)->with('error', 'This order cannot be paid.');
        }

        $validated = $request->validate([
            'currency' => 'required|string|size:3|exists:currencies,code',
            'payment_method' => 'required|string',
            'payment_proof' => 'nullable|image|max:2048'
        ]);

        // Convert order price to selected currency
        $orderAmountIDR = $order->total_price; // Assuming order price is in IDR
        $selectedCurrency = $validated['currency'];
        
        $conversion = null;
        if ($selectedCurrency !== 'IDR') {
            $conversion = $this->currencyService->convert($orderAmountIDR, 'IDR', $selectedCurrency);
            if (!$conversion) {
                return redirect()->back()->with('error', 'Currency conversion failed. Please try again.');
            }
            $paymentAmount = $conversion['converted_amount'];
        } else {
            $paymentAmount = $orderAmountIDR;
        }

        // Get USD conversion for reference
        $usdConversion = null;
        if ($selectedCurrency !== 'USD') {
            $usdConversion = $this->currencyService->convert($paymentAmount, $selectedCurrency, 'USD');
        }

        $paymentData = [
            'user_id' => Auth::id(),
            'tutor_id' => $order->service->tutor_id,
            'order_id' => $order->id,
            'amount' => $paymentAmount,
            'currency' => $selectedCurrency,
            'amount_usd' => $usdConversion ? $usdConversion['converted_amount'] : $paymentAmount,
            'exchange_rate' => $conversion ? $conversion['exchange_rate'] : 1.000000,
            'payment_method' => $validated['payment_method'],
            'status' => 'pending',
            'transaction_date' => now()
        ];

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            $paymentData['payment_proof'] = $path;
        }

        $payment = PaymentTransaction::create($paymentData);

        return redirect()->route('orders.show', $order)->with('success', 
            "Payment submitted successfully in {$selectedCurrency}! Amount: " . 
            Currency::where('code', $selectedCurrency)->first()->formatAmount($paymentAmount) . 
            ". Waiting for tutor confirmation."
        );
    }

    public function show(PaymentTransaction $payment)
    {
        // Load relasi yang diperlukan
        $payment->load(['tutor', 'session', 'order.service', 'currency']);
        
        // Get conversion data for display
        $conversions = [];
        $popularCurrencies = ['USD', 'EUR', 'SGD', 'MYR'];
        
        foreach ($popularCurrencies as $currencyCode) {
            if ($currencyCode !== $payment->currency) {
                $convertedAmount = $payment->convertTo($currencyCode);
                if ($convertedAmount) {
                    $currency = Currency::where('code', $currencyCode)->first();
                    $conversions[$currencyCode] = [
                        'amount' => $convertedAmount,
                        'formatted' => $currency ? $currency->formatAmount($convertedAmount) : $convertedAmount
                    ];
                }
            }
        }
        
        return view('payments.show', compact('payment', 'conversions'));
    }

    public function update(Request $request, PaymentTransaction $payment)
    {
        if ($payment->status !== 'pending') {
            return redirect()->route('payments.show', $payment)->with('error', 'Only pending payments can be updated.');
        }
        
        $validated = $request->validate([
            'currency' => 'sometimes|string|size:3|exists:currencies,code',
            'payment_method' => 'required|string',
            'payment_proof' => 'nullable|image|max:2048'
        ]);

        // If currency is being updated, recalculate conversions
        if (isset($validated['currency']) && $validated['currency'] !== $payment->currency) {
            $conversion = $this->currencyService->convert(
                $payment->amount, 
                $payment->currency, 
                $validated['currency']
            );
            
            if ($conversion) {
                $validated['amount'] = $conversion['converted_amount'];
                $validated['exchange_rate'] = $conversion['exchange_rate'];
                
                // Update USD amount
                $usdConversion = $this->currencyService->convert(
                    $validated['amount'], 
                    $validated['currency'], 
                    'USD'
                );
                if ($usdConversion) {
                    $validated['amount_usd'] = $usdConversion['converted_amount'];
                }
            }
        }

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            $validated['payment_proof'] = $path;
        }
        
        $payment->update($validated);
        return redirect()->route('payments.show', $payment)->with('success', 'Payment updated successfully.');
    }

    public function cancel(PaymentTransaction $payment)
    {
        if ($payment->status !== 'pending') {
            return redirect()->route('payments.show', $payment)->with('error', 'Only pending payments can be cancelled.');
        }
        $payment->update(['status' => 'cancelled']);
        // Optionally, unlink bookings from this payment
        Booking::where('payment_id', $payment->id)->update(['payment_id' => null]);
        return redirect()->route('payments.index')->with('success', 'Payment cancelled successfully.');
    }
}
