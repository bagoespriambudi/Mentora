<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Make a Payment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 text-blue-700">Submit a New Payment</h3>
                    <form method="POST" action="{{ route('payments.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1" for="tutor_id">Tutor</label>
                            <input type="number" name="tutor_id" id="tutor_id" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            <span class="text-xs text-gray-400">(Enter Tutor ID for now)</span>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1" for="session_id">Session ID (optional)</label>
                            <input type="number" name="session_id" id="session_id" class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1" for="amount">Amount</label>
                            <input type="number" name="amount" id="amount" class="w-full border-gray-300 rounded-md shadow-sm" required step="0.01">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1" for="payment_method">Payment Method</label>
                            <select name="payment_method" id="payment_method" class="w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="bank">Bank Transfer</option>
                                <option value="ewallet">E-Wallet</option>
                                <option value="cash">Cash</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1" for="payment_proof">Payment Proof (optional)</label>
                            <input type="file" name="payment_proof" id="payment_proof" class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Submit Payment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 