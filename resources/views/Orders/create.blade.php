@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-xl font-semibold mb-4">Order: {{ $service->title }}</h1>
    <form method="POST" action="{{ route('orders.store', $service) }}">
        @csrf
        <div class="mb-4">
            <label class="block mb-1">Notes (optional)</label>
            <textarea name="notes" class="w-full border rounded p-2" rows="4"></textarea>
        </div>
        <div class="mb-4">
            <strong>Price:</strong> Rp{{ number_format($service->price, 0, ',', '.') }}
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Place Order</button>
    </form>
</div>
@endsection
