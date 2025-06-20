<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Make Payment') }} - Order #{{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Back Navigation -->
            <div class="mb-6">
                <a href="{{ route('orders.show', $order) }}" 
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Order
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-6">Payment Information</h3>

                            @if(session('error'))
                                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <form action="{{ route('payments.store.order', $order) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                                @csrf

                                <!-- Order Information Display -->
                                <div class="bg-gray-50 rounded-lg p-6">
                                    <h4 class="text-md font-semibold text-gray-900 mb-4">Order Details</h4>
                                    
                                    <div class="flex items-start space-x-4">
                                        @if($order->service->thumbnail)
                                            <img src="{{ Storage::url($order->service->thumbnail) }}" 
                                                 alt="{{ $order->service->title }}" 
                                                 class="w-20 h-20 object-cover rounded-lg border border-gray-200">
                                        @endif
                                        
                                        <div class="flex-1">
                                            <h5 class="text-lg font-medium text-gray-900">{{ $order->service->title }}</h5>
                                            <p class="text-sm text-gray-600">{{ $order->service->category->name }}</p>
                                            <p class="text-sm text-gray-500 mt-2">{{ Str::limit($order->service->description, 200) }}</p>
                                            
                                            <div class="mt-4 flex items-center space-x-4 text-sm text-gray-600">
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                    </svg>
                                                    {{ $order->service->tutor->name }}
                                                </div>
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    {{ $order->service->duration_days }} days delivery
                                                </div>
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 12a4 4 0 110-8 4 4 0 010 8zm0 0V9a4 4 0 118 0v4"/>
                                                    </svg>
                                                    Order #{{ $order->id }}
                                                </div>
                                            </div>

                                            @if($order->notes)
                                                <div class="mt-4">
                                                    <p class="text-sm text-gray-600 font-medium">Order Notes:</p>
                                                    <p class="text-sm text-gray-500 bg-white rounded p-2 border">{{ $order->notes }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Payment Method -->
                                <div>
                                    <label for="currency" class="block text-sm font-medium text-gray-700 mb-2">
                                        Payment Currency <span class="text-red-500">*</span>
                                    </label>
                                    <select id="currency" 
                                            name="currency" 
                                            required
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                        <option value="">Select Currency</option>
                                        @foreach($currencies as $currency)
                                            <option value="{{ $currency->code }}" 
                                                    data-rate="{{ $currency->rate_to_usd }}"
                                                    data-symbol="{{ $currency->symbol }}"
                                                    data-decimals="{{ $currency->decimal_places }}"
                                                    {{ old('currency', $baseCurrency->code ?? 'IDR') === $currency->code ? 'selected' : '' }}>
                                                {{ $currency->symbol }} {{ $currency->code }} - {{ $currency->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('currency')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Currency Conversion Display -->
                                <div id="currency-conversion" class="hidden bg-blue-50 border border-blue-200 rounded-lg p-4">
                                    <div class="flex items-center mb-2">
                                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="font-medium text-blue-900">Currency Conversion</span>
                                    </div>
                                    <div class="space-y-2 text-sm">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Original Amount (IDR):</span>
                                            <span class="font-medium">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">You'll Pay:</span>
                                            <span class="font-bold text-blue-900" id="converted-amount">-</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Exchange Rate:</span>
                                            <span class="text-gray-700" id="exchange-rate">-</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Payment Method -->
                                <div>
                                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">
                                        Payment Method <span class="text-red-500">*</span>
                                    </label>
                                    <select id="payment_method" 
                                            name="payment_method" 
                                            required
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                        <option value="">Select Payment Method</option>
                                        <option value="bank_transfer" {{ old('payment_method') === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                        <option value="e_wallet" {{ old('payment_method') === 'e_wallet' ? 'selected' : '' }}>E-Wallet (OVO, GoPay, DANA)</option>
                                        <option value="virtual_account" {{ old('payment_method') === 'virtual_account' ? 'selected' : '' }}>Virtual Account</option>
                                        <option value="credit_card" {{ old('payment_method') === 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                                    </select>
                                    @error('payment_method')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Payment Proof -->
                                <div>
                                    <label for="payment_proof" class="block text-sm font-medium text-gray-700 mb-2">
                                        Payment Proof (Optional)
                                    </label>
                                    <input type="file" 
                                           id="payment_proof" 
                                           name="payment_proof" 
                                           accept="image/*"
                                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                    @error('payment_proof')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-2 text-sm text-gray-500">
                                        Upload a screenshot or photo of your payment confirmation. Supported formats: JPG, PNG, GIF. Max size: 2MB.
                                    </p>
                                </div>

                                <!-- Payment Instructions -->
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-medium text-blue-800">Payment Instructions</h3>
                                            <div class="mt-2 text-sm text-blue-700">
                                                <ul class="list-disc list-inside space-y-1">
                                                    <li>Make payment of Rp {{ number_format($order->total_price, 0, ',', '.') }} using your chosen payment method</li>
                                                    <li>Upload payment proof (optional but recommended for faster processing)</li>
                                                    <li>Your payment will be reviewed by the tutor</li>
                                                    <li>Once approved, work will begin on your order</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Buttons -->
                                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                                    <a href="{{ route('orders.show', $order) }}" 
                                       class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Cancel
                                    </a>
                                    <button type="submit" 
                                            class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        Submit Payment
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Payment Summary -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sticky top-8">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Summary</h3>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Order ID</span>
                                    <span class="text-sm font-medium text-gray-900">#{{ $order->id }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Service</span>
                                    <span class="text-sm text-gray-900 text-right">{{ Str::limit($order->service->title, 25) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Tutor</span>
                                    <span class="text-sm text-gray-900">{{ $order->service->tutor->name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Order Date</span>
                                    <span class="text-sm text-gray-900">{{ $order->order_date->format('M d, Y') }}</span>
                                </div>
                                <div class="border-t border-gray-200 pt-3">
                                    <div class="flex justify-between">
                                        <span class="text-base font-medium text-gray-900">Total Amount</span>
                                        <span class="text-lg font-bold text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 text-xs text-gray-500">
                                <p class="mb-2">
                                    <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Secure payment processing
                                </p>
                                <p class="mb-2">
                                    <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Payment verification required
                                </p>
                                <p>
                                    <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Work starts after approval
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Order Status -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Status</h3>
                            
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Order Placed</p>
                                        <p class="text-sm text-gray-500">{{ $order->order_date->format('M d, Y') }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        @if($order->status === 'approved' || $order->status === 'in_progress' || $order->status === 'completed')
                                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Order Approved</p>
                                        <p class="text-sm text-gray-500">
                                            @if($order->status === 'approved' || $order->status === 'in_progress' || $order->status === 'completed')
                                                Approved by tutor
                                            @else
                                                Waiting for approval
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Payment Processing</p>
                                        <p class="text-sm text-gray-500">Submitting payment...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Currency Conversion -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const currencySelect = document.getElementById('currency');
            const conversionDiv = document.getElementById('currency-conversion');
            const convertedAmountSpan = document.getElementById('converted-amount');
            const exchangeRateSpan = document.getElementById('exchange-rate');
            const orderAmount = {{ $order->total_price }}; // IDR amount

            currencySelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const selectedCurrency = this.value;
                
                if (!selectedCurrency) {
                    conversionDiv.classList.add('hidden');
                    return;
                }

                if (selectedCurrency === 'IDR') {
                    // Same currency, no conversion needed
                    conversionDiv.classList.add('hidden');
                    return;
                }

                // Show loading state
                conversionDiv.classList.remove('hidden');
                convertedAmountSpan.textContent = 'Converting...';
                exchangeRateSpan.textContent = 'Loading...';

                // Call conversion API
                fetch('{{ route("currency.convert") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        amount: orderAmount,
                        from: 'IDR',
                        to: selectedCurrency
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const symbol = selectedOption.dataset.symbol;
                        const decimals = parseInt(selectedOption.dataset.decimals);
                        
                        // Format the converted amount
                        const formattedAmount = symbol + ' ' + data.data.converted_amount.toLocaleString('en-US', {
                            minimumFractionDigits: decimals,
                            maximumFractionDigits: decimals
                        });
                        
                        convertedAmountSpan.textContent = formattedAmount;
                        exchangeRateSpan.textContent = `1 IDR = ${data.data.exchange_rate.toFixed(6)} ${selectedCurrency}`;
                        
                        // Update the payment summary if it exists
                        updatePaymentSummary(formattedAmount, selectedCurrency);
                    } else {
                        convertedAmountSpan.textContent = 'Conversion failed';
                        exchangeRateSpan.textContent = 'Please try again';
                        console.error('Conversion error:', data.message);
                    }
                })
                .catch(error => {
                    convertedAmountSpan.textContent = 'Error';
                    exchangeRateSpan.textContent = 'Network error';
                    console.error('Network error:', error);
                });
            });

            function updatePaymentSummary(formattedAmount, currency) {
                // Update the sidebar payment summary if it exists
                const totalAmountElement = document.querySelector('.payment-summary .total-amount');
                if (totalAmountElement) {
                    totalAmountElement.textContent = formattedAmount;
                }
            }

            // Trigger conversion for initially selected currency
            if (currencySelect.value) {
                currencySelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
</x-app-layout> 