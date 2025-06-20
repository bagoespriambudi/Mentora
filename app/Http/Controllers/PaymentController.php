<?php

namespace App\Http\Controllers;

use App\Models\PaymentTransaction;
use App\Models\Booking;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('payments.create');
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

        return view('payments.create-from-order', compact('order'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
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
        $validated['tutor_id'] = $session->tutor_id;
        $validated['user_id'] = $user->id;
        $validated['status'] = 'pending';
        $validated['transaction_date'] = now();

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

    // New method for storing payment from order
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
            'payment_method' => 'required|string',
            'payment_proof' => 'nullable|image|max:2048'
        ]);

        $validated['user_id'] = Auth::id();
        $validated['tutor_id'] = $order->service->tutor_id;
        $validated['order_id'] = $order->id;
        $validated['amount'] = $order->total_price;
        $validated['status'] = 'pending';
        $validated['transaction_date'] = now();

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            $validated['payment_proof'] = $path;
        }

        $payment = PaymentTransaction::create($validated);

        return redirect()->route('orders.show', $order)->with('success', 'Payment submitted successfully! Waiting for tutor confirmation.');
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
