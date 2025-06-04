<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tutor Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Welcome, {{ Auth::user()->name }}!</h3>
                    <p class="mb-2">You're logged in as a <span class="font-bold text-purple-600">Tutor</span>.</p>
                </div>
            </div>

            <!-- Payments Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 text-purple-700 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-purple-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0 10c-4.418 0-8-1.79-8-4V7a2 2 0 012-2h12a2 2 0 012 2v7c0 2.21-3.582 4-8 4z"/></svg>
                        Payments
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Payment History Card -->
                        <a href="{{ route('payments.index') }}" class="bg-yellow-50 p-4 rounded-lg shadow-sm flex flex-col items-center hover:bg-yellow-100 transition">
                            <span class="text-sm text-yellow-700 mb-1">Payment History</span>
                            <svg class="w-8 h-8 text-yellow-600 mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M9 16h6"/></svg>
                            <span class="text-xs text-yellow-400">View all your payments</span>
                        </a>
                        <!-- Earnings Card (placeholder) -->
                        <div class="bg-green-50 p-4 rounded-lg shadow-sm flex flex-col items-center">
                            <span class="text-sm text-green-700 mb-1">Earnings</span>
                            <span class="text-2xl font-bold text-green-900">Rp 0</span>
                            <span class="text-xs text-green-400">(Feature coming soon)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 