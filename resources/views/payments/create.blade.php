<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Make a Payment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-8">
                    <!-- Header -->
                    <div class="mb-8 text-center">
                        <div class="w-16 h-16 bg-gradient-to-r from-green-400 to-blue-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Submit Payment</h3>
                        <p class="text-gray-600">Complete your transaction securely</p>
                    </div>

                    <form method="POST" action="{{ route('payments.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <!-- Tutor Selection -->
                        <div class="bg-blue-50 p-6 rounded-xl border border-blue-100">
                            <label class="flex items-center text-gray-800 font-medium mb-3" for="tutor_id">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                </svg>
                                Tutor Information
                            </label>
                            <input type="number" name="tutor_id" id="tutor_id" 
                                   class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200" 
                                   placeholder="Enter Tutor ID" required>
                            <p class="text-sm text-blue-600 mt-2 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5v3a.75.75 0 001.5 0v-3A.75.75 0 009 9z" clip-rule="evenodd"/>
                                </svg>
                                You can find the Tutor ID in your session details
                            </p>
                        </div>

                        <!-- Session ID -->
                        <div>
                            <label class="flex items-center text-gray-800 font-medium mb-3" for="session_id">
                                <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Session ID <span class="text-gray-500 font-normal">(optional)</span>
                            </label>
                            <input type="number" name="session_id" id="session_id" 
                                   class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                   placeholder="Enter Session ID if applicable">
                        </div>

                        <!-- Amount -->
                        <div>
                            <label class="flex items-center text-gray-800 font-medium mb-3" for="amount">
                                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                </svg>
                                Payment Amount
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">Rp</span>
                                <input type="number" name="amount" id="amount" 
                                       class="w-full pl-12 border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200" 
                                       placeholder="0.00" required step="0.01" min="0">
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div>
                            <label class="flex items-center text-gray-800 font-medium mb-3" for="payment_method">
                                <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                Payment Method
                            </label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="payment_method" value="bank" class="sr-only" required>
                                    <div class="payment-option p-4 border-2 border-gray-200 rounded-xl hover:border-blue-300 transition-all duration-200">
                                        <div class="text-center">
                                            <svg class="w-8 h-8 mx-auto mb-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                            <span class="text-sm font-medium">Bank Transfer</span>
                                        </div>
                                    </div>
                                </label>
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="payment_method" value="ewallet" class="sr-only">
                                    <div class="payment-option p-4 border-2 border-gray-200 rounded-xl hover:border-green-300 transition-all duration-200">
                                        <div class="text-center">
                                            <svg class="w-8 h-8 mx-auto mb-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                            </svg>
                                            <span class="text-sm font-medium">E-Wallet</span>
                                        </div>
                                    </div>
                                </label>
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="payment_method" value="cash" class="sr-only">
                                    <div class="payment-option p-4 border-2 border-gray-200 rounded-xl hover:border-yellow-300 transition-all duration-200">
                                        <div class="text-center">
                                            <svg class="w-8 h-8 mx-auto mb-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                            <span class="text-sm font-medium">Cash</span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Payment Proof -->
                        <div>
                            <label class="flex items-center text-gray-800 font-medium mb-3" for="payment_proof">
                                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                Payment Proof <span class="text-gray-500 font-normal">(optional)</span>
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-indigo-400 transition-colors duration-200">
                                <input type="file" name="payment_proof" id="payment_proof" class="hidden" accept="image/*,.pdf">
                                <label for="payment_proof" class="cursor-pointer">
                                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-gray-600 mb-2">Click to upload receipt or screenshot</p>
                                    <p class="text-sm text-gray-500">PNG, JPG or PDF up to 10MB</p>
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-6 border-t">
                            <button type="submit" 
                                    class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-4 px-6 rounded-xl font-semibold hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:ring-blue-200 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2-2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                Submit Secure Payment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Payment method selection
            const paymentOptions = document.querySelectorAll('input[name="payment_method"]');
            paymentOptions.forEach(option => {
                option.addEventListener('change', function() {
                    document.querySelectorAll('.payment-option').forEach(opt => {
                        opt.classList.remove('border-blue-500', 'bg-blue-50', 'border-green-500', 'bg-green-50', 'border-yellow-500', 'bg-yellow-50');
                        opt.classList.add('border-gray-200');
                    });
                    
                    const selected = this.parentElement.querySelector('.payment-option');
                    const colors = {
                        'bank': ['border-blue-500', 'bg-blue-50'],
                        'ewallet': ['border-green-500', 'bg-green-50'],
                        'cash': ['border-yellow-500', 'bg-yellow-50']
                    };
                    selected.classList.remove('border-gray-200');
                    selected.classList.add(...colors[this.value]);
                });
            });

            // File upload preview
            const fileInput = document.getElementById('payment_proof');
            fileInput.addEventListener('change', function() {
                const label = this.nextElementSibling.querySelector('p');
                if (this.files.length > 0) {
                    label.textContent = `Selected: ${this.files[0].name}`;
                    label.classList.add('text-green-600', 'font-medium');
                }
            });
        });
    </script>
    @endpush
</x-app-layout>