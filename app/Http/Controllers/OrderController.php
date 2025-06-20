<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Tampilkan hanya order milik user yang login dengan relasi yang diperlukan
        $orders = Order::where('client_id', auth()->id())
                      ->with(['service.tutor', 'service.category', 'payments'])
                      ->latest('order_date')
                      ->get();
                      
        return view('orders.index', compact('orders'));
    }

    public function create(Service $service = null)
    {
        // Jika service diberikan sebagai parameter route
        if ($service) {
            // Load relasi yang diperlukan
            $service->load(['tutor', 'category']);
            return view('orders.create', compact('service'));
        }
        
        // Jika tidak ada service, redirect ke halaman lain
        return redirect()->route('services.index')->with('error', 'No service selected');
    }

    public function store(Request $request, Service $service = null)
    {
        // Validasi input
        $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);

        // Pastikan service aktif
        if (!$service || !$service->is_active) {
            return redirect()->route('services.index')->with('error', 'Service is not available.');
        }

        // Pastikan user adalah tutee
        if (auth()->user()->role !== 'tutee') {
            return redirect()->route('services.index')->with('error', 'Only tutees can place orders.');
        }

        // Buat order baru
        $order = new Order();
        $order->service_id = $service->id;
        $order->client_id = auth()->id();
        $order->status = 'pending';
        $order->notes = $request->notes;
        $order->order_date = now();
        $order->total_price = $service->price;
        $order->save();

        return redirect()->route('orders.show', $order)->with('success', 'Order created successfully! Waiting for tutor approval.');
    }

    public function show(Order $order)
    {
        // Pastikan user hanya bisa melihat order miliknya
        if ($order->client_id != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Load relasi yang diperlukan
        $order->load(['service.tutor', 'service.category', 'payments']);
        
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        // Pastikan user hanya bisa mengedit order miliknya
        if ($order->client_id != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Pastikan order masih bisa diedit (pending dan belum dibayar)
        if ($order->status !== 'pending' || $order->isPaid()) {
            return redirect()->route('orders.show', $order)->with('error', 'This order cannot be edited.');
        }
        
        // Load relasi yang diperlukan
        $order->load(['service.tutor', 'service.category']);
        
        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        if ($order->client_id != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Pastikan order masih bisa diedit
        if ($order->status !== 'pending' || $order->isPaid()) {
            return redirect()->route('orders.show', $order)->with('error', 'This order cannot be edited.');
        }
    
        $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);
    
        $order->update([
            'notes' => $request->notes,
        ]);
    
        return redirect()->route('orders.show', $order)->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        // Pastikan user hanya bisa menghapus order miliknya
        if ($order->client_id != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Pastikan order bisa dibatalkan (pending dan belum dibayar)
        if ($order->status !== 'pending' || $order->isPaid()) {
            return redirect()->route('orders.show', $order)->with('error', 'This order cannot be cancelled.');
        }
        
        // Ubah status menjadi cancelled daripada menghapus
        $order->update(['status' => 'cancelled']);

        return redirect()->route('orders.index')->with('success', 'Order cancelled successfully.');
    }
}
