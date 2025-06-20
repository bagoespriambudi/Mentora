<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Welcome Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Welcome, {{ Auth::user()->name }}!</h3>
                    <p class="mb-2">You're logged in as a <span class="font-bold text-blue-600">Tutee</span>.</p>
                    <p class="text-gray-600">Manage your orders, payments, and find new services from our tutors.</p>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Total Orders -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $totalOrders }}</div>
                        <div class="text-sm text-gray-600">Total Orders</div>
                    </div>
                </div>

                <!-- Pending Orders -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-2xl font-bold text-yellow-600">{{ $pendingOrders }}</div>
                        <div class="text-sm text-gray-600">Pending Orders</div>
                    </div>
                </div>

                <!-- Unpaid Orders -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-2xl font-bold text-red-600">{{ $unpaidOrders->count() }}</div>
                        <div class="text-sm text-gray-600">Unpaid Orders</div>
                    </div>
                </div>

                <!-- Outstanding Balance -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-2xl font-bold text-purple-600">Rp {{ number_format($outstandingBalance, 0, ',', '.') }}</div>
                        <div class="text-sm text-gray-600">Outstanding Balance</div>
                    </div>
                </div>
            </div>

            <!-- Orders Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-green-700 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            Orders
                        </h3>
                        <a href="{{ route('orders.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            View All Orders →
                        </a>
                    </div>

                    @if($recentOrders->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentOrders as $order)
                                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors duration-150">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h4 class="font-medium text-gray-900">{{ $order->service->title }}</h4>
                                            <p class="text-sm text-gray-600">Order #{{ $order->id }} • {{ $order->created_at->format('M d, Y') }}</p>
                                            <div class="flex items-center space-x-4 mt-2">
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                    @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                                    @elseif($order->status === 'approved') bg-blue-100 text-blue-800
                                                    @elseif($order->status === 'in_progress') bg-indigo-100 text-indigo-800
                                                    @elseif($order->status === 'completed') bg-green-100 text-green-800
                                                    @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                                    @else bg-gray-100 text-gray-800
                                                    @endif">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                                @if($order->isPaid())
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                        Paid
                                                    </span>
                                                @elseif($order->hasPendingPayment())
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        Payment Pending
                                                    </span>
                                                @else
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                        Unpaid
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="font-semibold text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                                            <div class="flex space-x-2 mt-2">
                                                <a href="{{ route('orders.show', $order) }}" 
                                                   class="text-blue-600 hover:text-blue-800 text-sm">View</a>
                                                @if(!$order->isPaid() && !$order->hasPendingPayment() && $order->status !== 'cancelled')
                                                    <a href="{{ route('payments.create.order', $order) }}" 
                                                       class="text-green-600 hover:text-green-800 text-sm">Pay</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Quick Actions for Orders -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <a href="{{ route('orders.index') }}" 
                                   class="bg-green-50 p-4 rounded-lg shadow-sm flex flex-col items-center hover:bg-green-100 transition">
                                    <svg class="w-8 h-8 text-green-600 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                    <span class="text-sm text-green-700 font-medium">View All Orders</span>
                                    <span class="text-xs text-green-500">Manage your orders</span>
                                </a>

                                @if($unpaidOrders->count() > 0)
                                    <a href="{{ route('payments.create.order', $unpaidOrders->first()) }}" 
                                       class="bg-red-50 p-4 rounded-lg shadow-sm flex flex-col items-center hover:bg-red-100 transition">
                                        <svg class="w-8 h-8 text-red-600 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        <span class="text-sm text-red-700 font-medium">Pay Pending Order</span>
                                        <span class="text-xs text-red-500">{{ $unpaidOrders->count() }} order(s) need payment</span>
                                    </a>
                                @else
                                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm flex flex-col items-center">
                                        <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="text-sm text-gray-600 font-medium">All Paid Up!</span>
                                        <span class="text-xs text-gray-500">No pending payments</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No orders yet</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by browsing our services and placing your first order.</p>
                            <div class="mt-6">
                                <a href="{{ route('services.index') }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    Browse Services
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Payments Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 text-blue-700 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0 10c-4.418 0-8-1.79-8-4V7a2 2 0 012-2h12a2 2 0 012 2v7c0 2.21-3.582 4-8 4z"/>
                        </svg>
                        Payments
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Outstanding Balance Card -->
                        <div class="bg-blue-50 p-4 rounded-lg shadow-sm flex flex-col items-center">
                            <span class="text-sm text-blue-700 mb-1">Outstanding Balance</span>
                            <span class="text-2xl font-bold text-blue-900">Rp {{ number_format($outstandingBalance, 0, ',', '.') }}</span>
                        </div>
                        <!-- Make a Payment Card -->
                        <a href="{{ route('payments.create') }}" class="bg-green-50 p-4 rounded-lg shadow-sm flex flex-col items-center hover:bg-green-100 transition">
                            <span class="text-sm text-green-700 mb-1">Make a Payment</span>
                            <svg class="w-8 h-8 text-green-600 mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span class="text-xs text-green-400">Pay for your sessions</span>
                        </a>
                        <!-- Payment History Card -->
                        <a href="{{ route('payments.index') }}" class="bg-yellow-50 p-4 rounded-lg shadow-sm flex flex-col items-center hover:bg-yellow-100 transition">
                            <span class="text-sm text-yellow-700 mb-1">Payment History</span>
                            <svg class="w-8 h-8 text-yellow-600 mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M9 16h6"/>
                            </svg>
                            <span class="text-xs text-yellow-400">View all your payments</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 