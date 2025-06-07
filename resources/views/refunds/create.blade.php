<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Request Refund') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Transaction ID</p>
                                <p class="font-medium">{{ $payment->id }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Date</p>
                                <p class="font-medium">{{ $payment->transaction_date->format('d M Y H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Amount</p>
                                <p class="font-medium">Rp {{ number_format($payment->amount, 2, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Tutor</p>
                                <p class="font-medium">{{ $payment->tutor->name }}</p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('refunds.store', $payment) }}" class="space-y-6">
                        @csrf
                        
                        <div>
                            <x-input-label for="reason" :value="__('Reason for Refund')" />
                            <x-textarea
                                id="reason"
                                name="reason"
                                class="mt-1 block w-full"
                                rows="4"
                                required
                                placeholder="Please provide a detailed explanation for your refund request..."
                            />
                            <x-input-error :messages="$errors->get('reason')" class="mt-2" />
                        </div>

                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        Please note that refund requests are subject to review by our team. We will process your request within 3-5 business days.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Submit Refund Request') }}</x-primary-button>
                            <a href="{{ route('payments.show', $payment) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 