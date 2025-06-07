@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ url()->previous() }}" 
               class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Services
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-12 text-white relative overflow-hidden">
                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" viewBox="0 0 100 20" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                                <path d="M 10 0 L 0 0 0 10" fill="none" stroke="currentColor" stroke-width="0.5"/>
                            </pattern>
                        </defs>
                        <rect width="100%" height="100%" fill="url(#grid)"/>
                    </svg>
                </div>
                
                <div class="relative">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold mb-2">Place Your Order</h1>
                            <p class="text-indigo-100 text-lg">Complete your service booking</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service Details Section -->
            <div class="px-8 py-6 bg-gray-50 border-b">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $service->title }}</h2>
                        @if(isset($service->description))
                            <p class="text-gray-600 mb-4">{{ $service->description }}</p>
                        @endif
                        
                        <!-- Service Features/Benefits -->
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full">✓ Professional Service</span>
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">✓ Fast Delivery</span>
                            <span class="px-3 py-1 bg-purple-100 text-purple-800 text-sm font-medium rounded-full">✓ Quality Guaranteed</span>
                        </div>
                    </div>
                    
                    <!-- Price Display -->
                    <div class="ml-6 text-right">
                        <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-200">
                            <div class="text-sm text-gray-500 mb-1">Service Price</div>
                            <div class="text-3xl font-bold text-gray-900">
                                Rp{{ number_format($service->price, 0, ',', '.') }}
                            </div>
                            <div class="text-sm text-gray-500 mt-1">per service</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Form -->
            <div class="px-8 py-8">
                <form method="POST" action="{{ route('orders.store', $service) }}" class="space-y-6">
                    @csrf
                    
                    <!-- Notes Section -->
                    <div class="space-y-4">
                        <div>
                            <label for="notes" class="block text-lg font-semibold text-gray-900 mb-2">
                                Additional Notes
                                <span class="text-sm font-normal text-gray-500">(Optional)</span>
                            </label>
                            <p class="text-sm text-gray-600 mb-3">
                                Please provide any specific requirements or instructions for your service order.
                            </p>
                            <div class="relative">
                                <textarea 
                                    id="notes"
                                    name="notes" 
                                    rows="4"
                                    placeholder="Example: Please complete the work by Friday afternoon, or any specific requirements you have..."
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 resize-none"
                                ></textarea>
                                <div class="absolute bottom-3 right-3 text-xs text-gray-400">
                                    <span id="charCount">0</span>/500
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            Order Summary
                        </h3>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-600">Service</span>
                                <span class="font-medium text-gray-900">{{ $service->title }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-600">Quantity</span>
                                <span class="font-medium text-gray-900">1x</span>
                            </div>
                            <div class="border-t border-gray-300 pt-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-xl font-semibold text-gray-900">Total Amount</span>
                                    <span class="text-2xl font-bold text-indigo-600">
                                        Rp{{ number_format($service->price, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6">
                        <button 
                            type="button"
                            onclick="window.history.back()"
                            class="flex-1 px-6 py-4 border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Cancel
                        </button>
                        
                        <button 
                            type="submit"
                            class="flex-1 px-6 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zM8 6a2 2 0 114 0v1H8V6zm0 3a1 1 0 012 0 1 1 0 11-2 0zm4 0a1 1 0 012 0 1 1 0 11-2 0z" clip-rule="evenodd"></path>
                            </svg>
                            Place Order
                        </button>
                    </div>

                    <!-- Security Notice -->
                    <div class="flex items-center justify-center pt-4 text-sm text-gray-500">
                        <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Your order is secured with SSL encryption
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
    
    textarea.addEventListener('input', function() {
        const currentLength = this.value.length;
        charCount.textContent = currentLength;
        
        if (currentLength > maxLength * 0.8) {
            charCount.style.color = '#f59e0b'; // yellow
        }
        if (currentLength > maxLength * 0.9) {
            charCount.style.color = '#ef4444'; // red
        }
        if (currentLength <= maxLength * 0.8) {
            charCount.style.color = '#9ca3af'; // gray
        }
    });
    
    // Prevent form submission if textarea exceeds limit
    textarea.addEventListener('keydown', function(e) {
        if (this.value.length >= maxLength && !['Backspace', 'Delete', 'Tab', 'Escape', 'Enter', 'Home', 'End', 'ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown'].includes(e.key)) {
            e.preventDefault();
        }
    });
});
</script>
@endsection