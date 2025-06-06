<?php

namespace App\Http\Controllers;

use App\Models\PaymentTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $transactions = PaymentTransaction::where('user_id', Auth::id())
            ->with(['tutor', 'session'])
            ->latest()
            ->paginate(10);

        return view('payments.index', compact('transactions'));
    }

    public function create()
    {
        return view('payments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tutor_id' => 'required|exists:users,id',
            'session_id' => 'nullable|exists:sessions,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
            'payment_proof' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payment-proofs', 'public');
            $validated['payment_proof'] = $path;
        }

        $validated['user_id'] = Auth::id();
        $validated['transaction_date'] = now();
        $validated['status'] = 'pending';

        PaymentTransaction::create($validated);

        return redirect()->route('payments.index')
            ->with('success', 'Payment submitted successfully.');
    }

    public function show(PaymentTransaction $payment)
    {
        $this->authorize('view', $payment);
        return view('payments.show', compact('payment'));
    }
}
