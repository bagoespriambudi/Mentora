<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $service->title }}
        </h2>
    </x-slot>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Back Navigation -->
            <div class="mb-6">
                <a href="{{ url()->previous() }}" 
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Service Header -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 mb-3">
                                    {{ $service->category->name }}
                                </span>
                                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $service->title }}</h1>
                                <div class="flex items-center space-x-4 text-sm text-gray-600">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        By {{ $service->user->name }}
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $service->duration_days }} days delivery
                                    </div>
                                    <div class="flex items-center">
                                        @if($service->is_active)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <svg class="w-1.5 h-1.5 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                                    <circle cx="4" cy="4" r="3"/>
                                                </svg>
                                                Active
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                <svg class="w-1.5 h-1.5 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                                    <circle cx="4" cy="4" r="3"/>
                                                </svg>
                                                Inactive
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold text-gray-900">Rp {{ number_format($service->price, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Service Images -->
                    @if($service->thumbnail || ($service->gallery && count($service->gallery) > 0))
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Session Images</h3>
                            
                            @if($service->thumbnail)
                                <div class="mb-6">
                                    <img src="{{ Storage::url($service->thumbnail) }}" 
                                         alt="{{ $service->title }}" 
                                         class="w-full h-64 sm:h-80 object-cover rounded-lg border border-gray-200">
                                </div>
                            @endif

                            @if($service->gallery && count($service->gallery) > 0)
                                <div>
                                    <h4 class="text-md font-medium text-gray-700 mb-3">Gallery</h4>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                                        @foreach($service->gallery as $image)
                                            <img src="{{ Storage::url($image) }}" 
                                                 alt="Gallery image" 
                                                 class="w-full h-32 object-cover rounded-lg border border-gray-200 hover:opacity-75 transition-opacity duration-150 cursor-pointer">
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Description -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Description</h3>
                        <div class="prose prose-gray max-w-none">
                            <p class="text-gray-700 leading-relaxed">{{ $service->description }}</p>
                        </div>
                    </div>

                    <!-- Service Details -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Service Details</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Delivery Time</p>
                                    <p class="text-sm text-gray-600">{{ $service->duration_days }} days</p>
                                </div>
                            </div>
                            <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Status</p>
                                    <p class="text-sm text-gray-600">{{ $service->is_active ? 'Active' : 'Inactive' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Order/Management Card -->
                    <div class="bg-white rounded-lg shadow-sm p-6 sticky top-8">
                        @auth
                            @if(auth()->user()->role === 'tutee' && $service->is_active)
                                <!-- Tutee can order -->
                                <div class="text-center">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Order This Session</h3>
                                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-sm text-gray-600">Price</span>
                                            <span class="text-lg font-bold text-gray-900">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-sm text-gray-600">Delivery</span>
                                            <span class="text-sm text-gray-900">{{ $service->duration_days }} days</span>
                                        </div>
                                        <hr class="my-3">
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm font-medium text-gray-900">Total</span>
                                            <span class="text-xl font-bold text-gray-900">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('orders.create', $service) }}" 
                                       class="w-full inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-200">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                        </svg>
                                        Order Now
                                    </a>
                                </div>
                            @elseif(auth()->user()->role === 'tutor' && $service->user_id === auth()->id())
                                <!-- Tutor can edit their own service -->
                                <div class="text-center">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Manage Session</h3>
                                    <p class="text-sm text-gray-600 mb-6">This is your session. You can edit the details below.</p>
                                    <a href="{{ route('services.edit', $service) }}" 
                                       class="w-full inline-flex items-center justify-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-200">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit Session
                                    </a>
                                </div>
                            @elseif(auth()->user()->role === 'tutee' && !$service->is_active)
                                <!-- Service is inactive -->
                                <div class="text-center">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Session Unavailable</h3>
                                    <p class="text-sm text-gray-600">This session is currently not available for ordering.</p>
                                </div>
                            @elseif(auth()->user()->role === 'tutor' && $service->user_id !== auth()->id())
                                <!-- Tutor viewing other tutor's service -->
                                <div class="text-center">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Session Info</h3>
                                    <p class="text-sm text-gray-600">This session is offered by another tutor.</p>
                                </div>
                            @else
                                <!-- Fallback for other scenarios -->
                                <div class="text-center">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Session Unavailable</h3>
                                    <p class="text-sm text-gray-600">This session is currently not available for ordering.</p>
                                </div>
                            @endif
                        @else
                            <!-- Not logged in -->
                            <div class="text-center">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Ready to Order?</h3>
                                <p class="text-sm text-gray-600 mb-6">Login to your account to place an order for this session.</p>
                                <a href="{{ route('login') }}" 
                                   class="w-full inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                    </svg>
                                    Login to Order
                                </a>
                            </div>
                        @endauth
                    </div>

                    <!-- Tutor Info Card -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">About the Tutor</h3>
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-grow">
                                <h4 class="text-base font-medium text-gray-900">{{ $service->user->name }}</h4>
                                <p class="text-sm text-gray-600">Member since {{ $service->user->created_at->format('M Y') }}</p>
                                
                                <div class="mt-4 space-y-2">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Verified tutor
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Quick response time
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Info Card -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h4 class="text-sm font-medium text-blue-900">Need help?</h4>
                                <p class="mt-1 text-sm text-blue-700">
                                    Have questions about this session? Contact the tutor for more details before placing your order.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>