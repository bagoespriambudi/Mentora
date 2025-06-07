<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payment Details') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Main Payment Card -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                <!-- Header Section -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-100">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Payment #{{ $payment->id }}</h3>
                            <p class="text-sm text-gray-600">{{ $payment->transaction_date->format('d M Y, H:i') }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                @if($payment->status === 'completed') bg-green-100 text-green-700 border border-green-200
                                @elseif($payment->status === 'pending') bg-yellow-100 text-yellow-700 border border-yellow-200
                                @elseif($payment->status === 'refunded') bg-red-100 text-red-700 border border-red-200
                                @endif">
                                {{ ucfirst($payment->status) }}
                            </span>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                                <p class="text-sm text-gray-500">{{ ucfirst($payment->payment_method) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content Section -->
                <div class="p-6 space-y-6">
                    <!-- Transaction Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">Transaction ID</span>
                                <span class="font-semibold text-gray-900">{{ $payment->id }}</span>
                            </div>
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">Payment Method</span>
                                <span class="font-semibold text-gray-900">{{ ucfirst($payment->payment_method) }}</span>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">Tutor</span>
                                <span class="font-semibold text-gray-900">{{ $payment->tutor->name }}</span>
                            </div>
                            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">Date</span>
                                <span class="font-semibold text-gray-900">{{ $payment->transaction_date->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Proof -->
                    @if($payment->payment_proof)
                        <div class="border-t border-gray-100 pt-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Payment Proof
                            </h4>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <img src="{{ Storage::url($payment->payment_proof) }}" alt="Payment Proof" 
                                     class="max-w-full h-auto max-h-96 rounded-lg shadow-md mx-auto">
                            </div>
                        </div>
                    @endif

                    <!-- Refund Request -->
                    @if($payment->refundRequest)
                        <div class="border-t border-gray-100 pt-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Refund Request
                            </h4>
                            <div class="bg-orange-50 border border-orange-200 rounded-lg p-4 space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-600">Status</span>
                                    <span class="px-2 py-1 rounded-full text-xs font-medium
                                        @if($payment->refundRequest->status === 'approved') bg-green-100 text-green-700
                                        @elseif($payment->refundRequest->status === 'pending') bg-yellow-100 text-yellow-700
                                        @elseif($payment->refundRequest->status === 'rejected') bg-red-100 text-red-700
                                        @endif">
                                        {{ ucfirst($payment->refundRequest->status) }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-600">Reason</span>
                                    <p class="mt-1 text-gray-900">{{ $payment->refundRequest->reason }}</p>
                                </div>
                                @if($payment->refundRequest->admin_notes)
                                    <div>
                                        <span class="text-sm font-medium text-gray-600">Admin Notes</span>
                                        <p class="mt-1 text-gray-900">{{ $payment->refundRequest->admin_notes }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Update Form for Pending Payments -->
                    @if($payment->status === 'pending')
                        <div class="border-t border-gray-100 pt-6">
                            <h4 class="text-lg font-semibold text-green-700 mb-4">Update Payment</h4>
                            <form method="POST" action="{{ route('payments.update', $payment) }}" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                @method('PUT')
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                                        <select name="payment_method" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                            <option value="bank" {{ $payment->payment_method === 'bank' ? 'selected' : '' }}>Bank Transfer</option>
                                            <option value="ewallet" {{ $payment->payment_method === 'ewallet' ? 'selected' : '' }}>E-Wallet</option>
                                            <option value="cash" {{ $payment->payment_method === 'cash' ? 'selected' : '' }}>Cash</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Payment Proof</label>
                                        <input type="file" name="payment_proof" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>
                                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                                    Update Payment
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                    <div class="flex flex-col sm:flex-row gap-3 sm:justify-between">
                        <a href="{{ route('payments.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors font-medium">
                            ← Back to Payments
                        </a>
                        @if($payment->status === 'completed' && !$payment->refundRequest)
                            <a href="{{ route('refunds.create', $payment) }}" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
                                Request Refund
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>