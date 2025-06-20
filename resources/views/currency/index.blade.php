<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Currency Converter') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg shadow-lg mb-8 p-8 text-white">
                <div class="text-center">
                    <h1 class="text-4xl font-bold mb-4">💱 International Currency Converter</h1>
                    <p class="text-xl opacity-90">Get real-time exchange rates for international tutoring payments</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Currency Converter Card -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-xl rounded-lg">
                        <div class="p-6 bg-gradient-to-r from-green-500 to-blue-500 text-white">
                            <h3 class="text-2xl font-bold flex items-center">
                                <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                                </svg>
                                Quick Converter
                            </h3>
                            <p class="opacity-90">Convert amounts between different currencies instantly</p>
                        </div>
                        
                        <div class="p-8">
                            <form id="conversionForm" class="space-y-6">
                                @csrf
                                <!-- Amount Input -->
                                <div>
                                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                                        Amount to Convert
                                    </label>
                                    <input type="number" 
                                           id="amount" 
                                           name="amount" 
                                           value="100"
                                           step="0.01" 
                                           min="0"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-lg font-semibold"
                                           placeholder="Enter amount">
                                </div>

                                <!-- Currency Selection Grid -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- From Currency -->
                                    <div>
                                        <label for="from_currency" class="block text-sm font-medium text-gray-700 mb-2">
                                            From Currency
                                        </label>
                                        <select id="from_currency" 
                                                name="from" 
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            @foreach($currencies as $currency)
                                                <option value="{{ $currency->code }}" 
                                                        {{ $baseCurrency && $baseCurrency->code === $currency->code ? 'selected' : '' }}>
                                                    {{ $currency->symbol }} {{ $currency->code }} - {{ $currency->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- To Currency -->
                                    <div>
                                        <label for="to_currency" class="block text-sm font-medium text-gray-700 mb-2">
                                            To Currency
                                        </label>
                                        <select id="to_currency" 
                                                name="to" 
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            @foreach($currencies as $currency)
                                                <option value="{{ $currency->code }}" 
                                                        {{ $currency->code === 'USD' ? 'selected' : '' }}>
                                                    {{ $currency->symbol }} {{ $currency->code }} - {{ $currency->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Swap Button -->
                                <div class="flex justify-center">
                                    <button type="button" 
                                            id="swapCurrencies"
                                            class="bg-gray-100 hover:bg-gray-200 p-3 rounded-full transition-colors duration-200">
                                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                        </svg>
                                    </button>
                                </div>

                                <!-- Convert Button -->
                                <button type="submit" 
                                        id="convertButton"
                                        class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-4 px-6 rounded-lg font-semibold text-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                                    <span class="flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                        Convert Currency
                                    </span>
                                </button>
                            </form>

                            <!-- Loading Spinner -->
                            <div id="loadingSpinner" class="hidden text-center py-8">
                                <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
                                <p class="mt-2 text-gray-600">Converting...</p>
                            </div>

                            <!-- Conversion Result -->
                            <div id="conversionResult" class="hidden mt-8 p-6 bg-gradient-to-r from-green-50 to-blue-50 rounded-lg border border-green-200">
                                <!-- Result will be populated by JavaScript -->
                            </div>

                            <!-- Error Message -->
                            <div id="errorMessage" class="hidden mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                                <div class="flex">
                                    <svg class="w-5 h-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-red-700" id="errorText"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Exchange Rates Card -->
                <div class="space-y-6">
                    <!-- Live Rates Card -->
                    <div class="bg-white overflow-hidden shadow-xl rounded-lg">
                        <div class="p-4 bg-gradient-to-r from-yellow-500 to-orange-500 text-white">
                            <h3 class="text-lg font-bold flex items-center">
                                <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Live Exchange Rates
                            </h3>
                        </div>
                        <div class="p-4">
                            <div id="exchangeRates" class="space-y-3">
                                <div class="text-center text-gray-500 py-4">
                                    <div class="animate-pulse">Loading rates...</div>
                                </div>
                            </div>
                            <div class="mt-4 text-xs text-gray-500 text-center">
                                <span id="lastUpdated">Rates updated every hour</span>
                            </div>
                        </div>
                    </div>

                    <!-- Popular Conversions -->
                    <div class="bg-white overflow-hidden shadow-xl rounded-lg">
                        <div class="p-4 bg-gradient-to-r from-purple-500 to-pink-500 text-white">
                            <h3 class="text-lg font-bold">💡 Popular Conversions</h3>
                        </div>
                        <div class="p-4 space-y-3">
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="font-medium">USD → IDR</span>
                                <span class="text-blue-600 font-semibold">$ 1 = Rp 15,420</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="font-medium">EUR → IDR</span>
                                <span class="text-blue-600 font-semibold">€ 1 = Rp 18,141</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="font-medium">SGD → IDR</span>
                                <span class="text-blue-600 font-semibold">S$ 1 = Rp 11,422</span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="font-medium">MYR → IDR</span>
                                <span class="text-blue-600 font-semibold">RM 1 = Rp 3,671</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Features Section -->
            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Real-Time Rates</h3>
                    <p class="text-gray-600">Get live exchange rates updated every hour from reliable financial APIs.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">15+ Currencies</h3>
                    <p class="text-gray-600">Support for major international currencies including Asian markets.</p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Easy Integration</h3>
                    <p class="text-gray-600">Seamlessly integrated with our payment system for international tutoring.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Currency Converter -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('conversionForm');
            const amountInput = document.getElementById('amount');
            const fromSelect = document.getElementById('from_currency');
            const toSelect = document.getElementById('to_currency');
            const swapButton = document.getElementById('swapCurrencies');
            const convertButton = document.getElementById('convertButton');
            const loadingSpinner = document.getElementById('loadingSpinner');
            const resultDiv = document.getElementById('conversionResult');
            const errorDiv = document.getElementById('errorMessage');
            const errorText = document.getElementById('errorText');

            // Auto-convert on input change
            let debounceTimer;
            [amountInput, fromSelect, toSelect].forEach(element => {
                element.addEventListener('change', function() {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(convertCurrency, 500);
                });
            });

            // Swap currencies
            swapButton.addEventListener('click', function() {
                const fromValue = fromSelect.value;
                const toValue = toSelect.value;
                
                fromSelect.value = toValue;
                toSelect.value = fromValue;
                
                // Trigger conversion
                convertCurrency();
            });

            // Form submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                convertCurrency();
            });

            // Currency conversion function
            async function convertCurrency() {
                const amount = parseFloat(amountInput.value);
                const from = fromSelect.value;
                const to = toSelect.value;

                if (!amount || amount <= 0) {
                    showError('Please enter a valid amount');
                    return;
                }

                if (from === to) {
                    showResult({
                        original_amount: amount,
                        converted_amount: amount,
                        from_currency: from,
                        to_currency: to,
                        exchange_rate: 1.0,
                        formatted_original: formatCurrency(amount, from),
                        formatted_converted: formatCurrency(amount, to)
                    });
                    return;
                }

                // Show loading
                showLoading();

                try {
                    const response = await fetch('{{ route("currency.convert") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            amount: amount,
                            from: from,
                            to: to
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        showResult(data.data);
                    } else {
                        showError(data.message || 'Conversion failed');
                    }
                } catch (error) {
                    showError('Network error: ' + error.message);
                } finally {
                    hideLoading();
                }
            }

            function showLoading() {
                loadingSpinner.classList.remove('hidden');
                resultDiv.classList.add('hidden');
                errorDiv.classList.add('hidden');
                convertButton.disabled = true;
            }

            function hideLoading() {
                loadingSpinner.classList.add('hidden');
                convertButton.disabled = false;
            }

            function showResult(data) {
                const html = `
                    <div class="text-center">
                        <div class="text-3xl font-bold text-gray-800 mb-2">
                            ${data.formatted_converted}
                        </div>
                        <div class="text-gray-600 mb-4">
                            ${data.formatted_original} =
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-500">Exchange Rate:</span>
                                    <div class="font-semibold">1 ${data.from_currency} = ${data.exchange_rate} ${data.to_currency}</div>
                                </div>
                                <div>
                                    <span class="text-gray-500">Converted:</span>
                                    <div class="font-semibold">${data.converted_amount.toLocaleString()}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                resultDiv.innerHTML = html;
                resultDiv.classList.remove('hidden');
                errorDiv.classList.add('hidden');
            }

            function showError(message) {
                errorText.textContent = message;
                errorDiv.classList.remove('hidden');
                resultDiv.classList.add('hidden');
            }

            function formatCurrency(amount, currencyCode) {
                // Simple formatting - in production, you'd use proper currency formatting
                const symbols = {
                    'USD': '$', 'EUR': '€', 'GBP': '£', 'JPY': '¥', 'IDR': 'Rp',
                    'SGD': 'S$', 'MYR': 'RM', 'THB': '฿', 'PHP': '₱', 'VND': '₫',
                    'AUD': 'A$', 'CAD': 'C$', 'CHF': 'CHF', 'CNY': '¥', 'INR': '₹'
                };
                
                const symbol = symbols[currencyCode] || currencyCode;
                return `${symbol} ${amount.toLocaleString()}`;
            }

            // Load exchange rates
            loadExchangeRates();

            async function loadExchangeRates() {
                try {
                    const response = await fetch('{{ route("currency.rates") }}?base=IDR');
                    const data = await response.json();
                    
                    if (data.success) {
                        displayExchangeRates(data.data);
                    }
                } catch (error) {
                    console.error('Failed to load exchange rates:', error);
                }
            }

            function displayExchangeRates(data) {
                const ratesDiv = document.getElementById('exchangeRates');
                const lastUpdatedSpan = document.getElementById('lastUpdated');
                
                const popularRates = ['USD', 'EUR', 'SGD', 'MYR', 'USD'];
                let html = '';
                
                popularRates.forEach(currency => {
                    if (data.rates[currency]) {
                        const rate = (1 / data.rates[currency]).toFixed(currency === 'JPY' || currency === 'VND' ? 0 : 2);
                        html += `
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="font-medium">1 IDR → ${currency}</span>
                                <span class="text-blue-600 font-semibold">${rate}</span>
                            </div>
                        `;
                    }
                });
                
                ratesDiv.innerHTML = html;
                lastUpdatedSpan.textContent = `Last updated: ${data.last_updated}`;
            }

            // Initial conversion if amount is provided
            if (amountInput.value) {
                convertCurrency();
            }
        });
    </script>
</x-app-layout> 