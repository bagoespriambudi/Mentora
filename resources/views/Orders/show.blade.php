@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white rounded shadow">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Order Detail</h1>
        <a href="{{ route('orders.index') }}" class="text-blue-600 hover:underline">Back to Orders</a>
    </div>
    
    <div class="border-b pb-4 mb-4">
        <h2 class="text-xl font-semibold mb-2">{{ $order->service->title }}</h2>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-gray-600">Status</p>
                <p class="font-medium">{{ ucfirst($order->status) }}</p>
            </div>
            <div>
                <p class="text-gray-600">Order Date</p>
                <p>{{ $order->order_date->format('d M Y H:i') }}</p>
            </div>
            <div>
                <p class="text-gray-600">Total Price</p>
                <p class="font-medium">Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
    
    @if ($order->notes)
    <div class="mb-4">
        <h3 class="font-semibold mb-2">Notes</h3>
        <p class="bg-gray-50 p-3 rounded">{{ $order->notes }}</p>
    </div>
    @endif
    
    <div class="mt-6 flex space-x-4">
        <a href="{{ route('orders.edit', $order) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Edit Order</a>
        
        <form method="POST" action="{{ route('orders.destroy', $order) }}" onsubmit="return confirm('Are you sure you want to cancel this order?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Cancel Order</button>
        </form>
    </div>
</div>
@endsection