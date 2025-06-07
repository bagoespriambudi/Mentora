<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payment History') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 text-blue-700">Your Payment Transactions</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tutor</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Method</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($transactions as $transaction)
                                    <tr>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ $transaction->transaction_date->format('d M Y') }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ $transaction->tutor->name ?? '-' }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">Rp {{ number_format($transaction->amount, 2, ',', '.') }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ ucfirst($transaction->payment_method) }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            <span class="inline-block px-2 py-1 rounded text-xs font-semibold
                                                @if($transaction->status === 'completed') bg-green-100 text-green-800
                                                @elseif($transaction->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($transaction->status === 'refunded') bg-red-100 text-red-800
                                                @endif">
                                                {{ ucfirst($transaction->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            <a href="{{ route('payments.show', $transaction) }}" class="text-blue-600 hover:underline">Details</a>
                                            @if($transaction->status === 'pending')
                                                <span class="mx-1">|</span>
                                                <a href="{{ route('payments.show', $transaction) }}#update-form" class="text-green-600 hover:underline">Update</a>
                                                <span class="mx-1">|</span>
                                                <form action="{{ route('payments.cancel', $transaction) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Are you sure you want to cancel this payment?')">Cancel</button>
                                                </form>
                                            @endif
                                            @if($transaction->status === 'completed' && !$transaction->refundRequest)
                                                <span class="mx-1">|</span>
                                                <a href="{{ route('refunds.create', $transaction) }}" class="text-red-600 hover:underline">Request Refund</a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-4 text-center text-gray-500">No payment transactions found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 