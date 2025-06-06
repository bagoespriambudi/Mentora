<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('client_id', Auth::id())
                    ->with('service')
                    ->latest()
                    ->get();

        return view('orders.index', compact('orders'));
    }

    public function create(Service $service)
    {
        return view('orders.create', compact('service'));
    }

    public function store(Request $request, Service $service)
    {
        $validated = $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);

        Order::create([
            'service_id' => $service->id,
            'client_id' => Auth::id(),
            'status' => 'pending',
            'notes' => $validated['notes'],
            'order_date' => now(),
            'total_price' => $service->price,
        ]);

        return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    }
}
