<?php

namespace App\Http\Controllers;

use App\Models\PaymentTransaction;
use App\Models\RefundRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RefundController extends Controller
{
    public function create(PaymentTransaction $payment)
    {
        $this->authorize('create', [RefundRequest::class, $payment]);
        return view('refunds.create', compact('payment'));
    }

    public function store(Request $request, PaymentTransaction $payment)
    {
        $this->authorize('create', [RefundRequest::class, $payment]);

        $validated = $request->validate([
            'reason' => 'required|string|min:10',
        ]);

        $refund = RefundRequest::create([
            'transaction_id' => $payment->id,
            'user_id' => Auth::id(),
            'reason' => $validated['reason'],
            'amount' => $payment->amount,
            'status' => 'pending'
        ]);

        return redirect()->route('payments.show', $payment)
            ->with('success', 'Refund request submitted successfully.');
    }

    public function approve(RefundRequest $refund)
    {
        $this->authorize('approve', $refund);

        DB::transaction(function () use ($refund) {
            $refund->update(['status' => 'approved']);
            $refund->transaction->update(['status' => 'refunded']);
        });

        return redirect()->route('admin.dashboard')
            ->with('success', 'Refund request approved.');
    }

    public function reject(Request $request, RefundRequest $refund)
    {
        $this->authorize('reject', $refund);

        $validated = $request->validate([
            'admin_notes' => 'required|string|min:10'
        ]);

        $refund->update([
            'status' => 'rejected',
            'admin_notes' => $validated['admin_notes']
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Refund request rejected.');
    }
}
