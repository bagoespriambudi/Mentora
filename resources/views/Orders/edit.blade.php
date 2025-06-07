@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-amber-50 via-white to-orange-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb Navigation -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('orders.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-indigo-600 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L9 5.414V17a1 1 0 102 0V5.414l5.293 5.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        My Orders
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500">Edit Order</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-amber-500 to-orange-500 px-8 py-10 text-white relative overflow-hidden">
                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <pattern id="edit-pattern" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                                <circle cx="2" cy="2" r="1" fill="currentColor" opacity="0.4"/>
                                <circle cx="12" cy="12" r="1" fill="currentColor" opacity="0.4"/>
                            </pattern>
                        </defs>
                        <rect width="100%" height="100%" fill="url(#edit-pattern)"/>
                    </svg>
                </div>
                
                <div class="relative">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-14 h-14 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-4">
                                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold mb-1">Edit Order</h1>
                                <p class="text-amber-100 text-lg">Modify your service order details</p>
                            </div>
                        </div>
                        
                        <!-- Order Status Badge -->
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                'processing' => 'bg-blue-100 text-blue-800 border-blue-200',
                                'completed' => 'bg-green-100 text-green-800 border-green-200',
                                'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                            ];
                            $statusClass = $statusColors[strtolower($order->status)] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                        @endphp
                        <div class="text-right">
                            <div class="text-sm text-amber-100 mb-2">Current Status</div>
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold border {{ $statusClass }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Information Section -->
            <div class="px-8 py-6 bg-gradient-to-r from-gray-50 to-gray-100 border-b">
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Service Details -->
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"></path>
                            </svg>
                            Service Details
                        </h3>
                        <div class="space-y-3">
                            <div>
                                <div class="text-sm text-gray-500">Service Name</div>
                                <div class="font-semibold text-gray-900">{{ $order->service->title }}</div>
                            </div>
                            @if(isset($order->service->description))
                                <div>
                                    <div class="text-sm text-gray-500">Description</div>
                                    <div class="text-gray-700">{{ $order->service->description }}</div>
                                </div>
                            @endif
                            <div>
                                <div class="text-sm text-gray-500">Service Price</div>
                                <div class="text-2xl font-bold text-indigo-600">
                                    Rp{{ number_format($order->service->price, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Information -->
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                            Order Information
                        </h3>
                        <div class="space-y-3">
                            <div>
                                <div class="text-sm text-gray-500">Order ID</div>
                                <div class="font-mono text-gray-900">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500">Order Date</div>
                                <div class="text-gray-900">{{ $order->order_date->format('d M Y, H:i') }}</div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500">Total Amount</div>
                                <div class="text-2xl font-bold text-amber-600">
                                    Rp{{ number_format($order->total_price, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <div class="px-8 py-8">
                <form method="POST" action="{{ route('orders.update', $order) }}" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <!-- Notice -->
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                        <div class="flex">
                            <svg class="w-5 h-5 text-blue-400 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <h4 class="text-sm font-semibold text-blue-800 mb-1">Important Notice</h4>
                                <p class="text-sm text-blue-700">
                                    You can only modify the notes for this order. Service details and pricing cannot be changed after order placement.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Notes Section -->
                    <div class="space-y-4">
                        <div>
                            <label for="notes" class="block text-lg font-semibold text-gray-900 mb-2">
                                Order Notes
                                <span class="text-sm font-normal text-gray-500">(Optional)</span>
                            </label>
                            <p class="text-sm text-gray-600 mb-3">
                                Update any specific requirements or instructions for your service order.
                            </p>
                            <div class="relative">
                                <textarea 
                                    id="notes"
                                    name="notes" 
                                    rows="6"
                                    placeholder="Add or update your service requirements, special instructions, or any other relevant details..."
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors duration-200 resize-none"
                                >{{ old('notes', $order->notes) }}</textarea>
                                <div class="absolute bottom-3 right-3 text-xs text-gray-400">
                                    <span id="charCount">{{ strlen($order->notes ?? '') }}</span>/500
                                </div>
                            </div>
                            @error('notes')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Summary Section -->
                    <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl p-6 border border-amber-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenoevenodd"></path>
                            </svg>
                            Update Summary
                        </h3>
                        
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <div class="text-sm text-gray-600">What you're updating:</div>
                                <div class="font-medium text-gray-900">Order notes and requirements</div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-600">Order remains:</div>
                                <div class="font-medium text-gray-900">Same service and pricing</div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6">
                        <a href="{{ route('orders.index') }}"
                           class="flex-1 px-6 py-4 border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Cancel Changes
                        </a>
                        
                        <button 
                            type="submit"
                            class="flex-1 px-6 py-4 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Update Order
                        </button>
                    </div>

                    <!-- Security Notice -->
                    <div class="flex items-center justify-center pt-4 text-sm text-gray-500">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        All changes are secured and logged for your protection
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById('notes');
    const charCount = document.getElementById('charCount');
    const maxLength = 500;
    
    // Update character count on input
    textarea.addEventListener('input', function() {
        const currentLength = this.value.length;
        charCount.textContent = currentLength;
        
        // Color coding for character count
        if (currentLength > maxLength * 0.8) {
            charCount.style.color = '#f59e0b'; // amber
        }
        if (currentLength > maxLength * 0.9) {
            charCount.style.color = '#ef4444'; // red
        }
        if (currentLength <= maxLength * 0.8) {
            charCount.style.color = '#9ca3af'; // gray
        }
    });
    
    // Prevent typing beyond limit
    textarea.addEventListener('keydown', function(e) {
        if (this.value.length >= maxLength && !['Backspace', 'Delete', 'Tab', 'Escape', 'Enter', 'Home', 'End', 'ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown'].includes(e.key)) {
            e.preventDefault();
        }
    });

    // Auto-resize textarea
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
});
</script>
@endsection