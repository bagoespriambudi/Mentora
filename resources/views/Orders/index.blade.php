@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">My Orders</h1>
    @forelse ($orders as $order)
        <div class="border p-4 rounded mb-4 bg-white shadow">
            <h2 class="text-lg font-semibold">{{ $order->service->title }}</h2>
            <p>Status: <span class="font-medium">{{ ucfirst($order->status) }}</span></p>
            <p>Order Date: {{ $order->order_date->format('d M Y H:i') }}</p>
            <p>Total: Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>
            @if ($order->notes)
                <p class="mt-2">Notes: {{ $order->notes }}</p>
            @endif
        </div>
    @empty
        <p>You have no orders.</p>
    @endforelse
</div>
@endsection
