<?php

namespace App\Http\Controllers;

use App\Models\PaymentTransaction;
use App\Models\Booking;
use App\Models\Order;
use App\Models\Currency;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function index()
    {
        $transactions = PaymentTransaction::where('user_id', Auth::id())
            ->with(['tutor', 'session', 'order.service'])
            ->latest()
            ->paginate(10);

        return view('payments.index', compact('transactions'));
    }

    public function create()
    {
        $tutors = User::where('role', 'tutor')->get();
        $currencies = Currency::where('is_active', true)->get();
        
        return view('payments.create', compact('tutors', 'currencies'));
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
        $currencies = Currency::where('is_active', true)->orderBy('name')->get();
        $baseCurrency = Currency::where('is_base_currency', true)->first();

        return view('payments.create-from-order', compact('order', 'currencies', 'baseCurrency'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tutor_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1',
            'currency' => 'required|string|size:3|exists:currencies,code',
            'payment_method' => 'required|string',
            'payment_proof' => 'nullable|image|max:2048',
            'notes' => 'nullable|string'
        ]);

        // Handle file upload
        if ($request->hasFile('payment_proof')) {
            $validated['payment_proof'] = $request->file('payment_proof')->store('payment-proofs', 'public');
        }

        // Get currency for USD conversion (static rate)
        $currency = Currency::where('code', $validated['currency'])->first();
        $usdAmount = $validated['amount'] / ($currency->rate_to_usd ?? 1);

        $paymentData = array_merge($validated, [
            'user_id' => Auth::id(),
            'amount_usd' => $usdAmount,
            'exchange_rate' => $currency->rate_to_usd ?? 1,
            'status' => 'pending',
            'transaction_date' => now()
        ]);

        $payment = PaymentTransaction::create($paymentData);

        return redirect()->route('payments.index')->with('success', 'Payment submitted successfully!');
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

        // Get order price and convert to selected currency using static rates
        $orderAmountIDR = $order->total_price; // Assuming order price is in IDR
        $selectedCurrency = $validated['currency'];
        
        $paymentAmount = $orderAmountIDR;
        $exchangeRate = 1.000000;
        
        if ($selectedCurrency !== 'IDR') {
            $currency = Currency::where('code', $selectedCurrency)->first();
            if ($currency && $currency->rate_to_usd) {
                // Convert IDR to selected currency via USD
                $idrCurrency = Currency::where('code', 'IDR')->first();
                if ($idrCurrency && $idrCurrency->rate_to_usd) {
                    $usdAmount = $orderAmountIDR / $idrCurrency->rate_to_usd;
                    $paymentAmount = $usdAmount * $currency->rate_to_usd;
                    $exchangeRate = $paymentAmount / $orderAmountIDR;
                }
            }
        }

        // Get USD conversion for reference
        $usdAmount = $paymentAmount;
        if ($selectedCurrency !== 'USD') {
            $currency = Currency::where('code', $selectedCurrency)->first();
            if ($currency && $currency->rate_to_usd) {
                $usdAmount = $paymentAmount / $currency->rate_to_usd;
            }
        }

        $paymentData = [
            'user_id' => Auth::id(),
            'tutor_id' => $order->service->tutor_id,
            'order_id' => $order->id,
            'amount' => $paymentAmount,
            'currency' => $selectedCurrency,
            'amount_usd' => $usdAmount,
            'exchange_rate' => $exchangeRate,
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
            number_format($paymentAmount, 2) . 
            ". Waiting for tutor confirmation."
        );
    }

    public function show(PaymentTransaction $payment)
    {
        // Load relasi yang diperlukan
        $payment->load(['tutor', 'session', 'order.service']);
        
        return view('payments.show', compact('payment'));
    }

    public function update(Request $request, PaymentTransaction $payment)
    {
        if ($payment->status !== 'pending') {
            return redirect()->route('payments.show', $payment)->with('error', 'Only pending payments can be updated.');
        }
        
        $validated = $request->validate([
            'payment_method' => 'required|string',
            'payment_proof' => 'nullable|image|max:2048'
        ]);

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
