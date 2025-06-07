<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Tampilkan hanya order milik user yang login
        $orders = Order::where('client_id', auth()->id())
                      ->with('service')
                      ->latest('order_date')
                      ->get();
                      
        return view('Orders.index', compact('orders'));
    }

    public function create(Service $service = null)
    {
        // Jika service diberikan sebagai parameter route
        if ($service) {
            return view('Orders.create', compact('service'));
        }
        
        // Jika tidak ada service, redirect ke halaman lain
        return redirect()->route('dashboard')->with('error', 'No service selected');
    }

    public function store(Request $request, Service $service = null)
    {
        // Validasi input
        $request->validate([
            'notes' => 'nullable|string',
        ]);

        // Buat order baru
        $order = new Order();
        $order->service_id = $service->id;
        $order->client_id = auth()->id();
        $order->status = 'pending';
        $order->notes = $request->notes;
        $order->order_date = now();
        $order->total_price = $service->price;
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    public function show(Order $order)
    {
        // Pastikan user hanya bisa melihat order miliknya
        if ($order->client_id != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('Orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        // Pastikan user hanya bisa mengedit order miliknya
        if ($order->client_id != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('Orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        if ($order->client_id != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
    
        $request->validate([
            'notes' => 'nullable|string',
        ]);
    
        $order->update([
            'notes' => $request->notes,
        ]);
    
        // Redirect ke halaman list order (index)
        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        // Pastikan user hanya bisa menghapus order miliknya
        if ($order->client_id != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Alternatif: Ubah status menjadi cancelled daripada menghapus
        $order->update(['status' => 'cancelled']);
        
        // Atau jika ingin benar-benar menghapus:
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order cancelled successfully.');
    }
}
