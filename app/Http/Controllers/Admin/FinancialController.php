<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FinancialReport;
use App\Models\PaymentTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinancialController extends Controller
{
    public function index()
    {
        $transactions = PaymentTransaction::with(['user', 'tutor'])
            ->latest()
            ->paginate(15);

        $summary = [
            'total_revenue' => PaymentTransaction::where('status', 'completed')->sum('amount'),
            'pending_payments' => PaymentTransaction::where('status', 'pending')->count(),
            'refunded_amount' => PaymentTransaction::where('status', 'refunded')->sum('amount'),
        ];

        return view('admin.financial.index', compact('transactions', 'summary'));
    }

    public function generateReport(Request $request)
    {
        $validated = $request->validate([
            'report_type' => 'required|in:daily,weekly,monthly',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $transactions = PaymentTransaction::whereBetween('transaction_date', [
            $validated['start_date'],
            $validated['end_date']
        ])->get();

        $total_revenue = $transactions->where('status', 'completed')->sum('amount');
        $total_refunds = $transactions->where('status', 'refunded')->sum('amount');
        $net_revenue = $total_revenue - $total_refunds;

        $report = FinancialReport::create([
            'report_type' => $validated['report_type'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'total_revenue' => $total_revenue,
            'total_refunds' => $total_refunds,
            'net_revenue' => $net_revenue
        ]);

        return view('admin.financial.report', compact('report', 'transactions'));
    }

    public function exportReport(FinancialReport $report)
    {
        // Implementation for exporting report to CSV/Excel
        // This will be implemented based on your preferred export method
    }
}
