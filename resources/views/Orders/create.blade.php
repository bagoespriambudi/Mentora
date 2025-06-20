<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Order') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Back Navigation -->
        <div class="mb-6">
                <a href="{{ route('services.show', $service) }}" 
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                    Back to Service
            </a>
        </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-6">Order Details</h3>

                            @if(session('error'))
                                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <form action="{{ route('orders.store', $service) }}" method="POST" class="space-y-6">
                                @csrf

                                <!-- Service Information Display -->
                                <div class="bg-gray-50 rounded-lg p-6">
                                    <h4 class="text-md font-semibold text-gray-900 mb-4">Service Information</h4>
                                    
                                    <div class="flex items-start space-x-4">
                                        @if($service->thumbnail)
                                            <img src="{{ Storage::url($service->thumbnail) }}" 
                                                 alt="{{ $service->title }}" 
                                                 class="w-20 h-20 object-cover rounded-lg border border-gray-200">
                                        @endif
                                        
                                        <div class="flex-1">
                                            <h5 class="text-lg font-medium text-gray-900">{{ $service->title }}</h5>
                                            <p class="text-sm text-gray-600">{{ $service->category->name }}</p>
                                            <p class="text-sm text-gray-500 mt-2">{{ Str::limit($service->description, 200) }}</p>
                                            
                                            <div class="mt-4 flex items-center space-x-4 text-sm text-gray-600">
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                    </svg>
                                                    {{ $service->tutor->name }}
                                                </div>
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                                                    {{ $service->duration_days }} days delivery
                </div>
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                                                    Rp {{ number_format($service->price, 0, ',', '.') }}
                        </div>
                        </div>
                    </div>
                </div>
            </div>

                                <!-- Order Notes -->
                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                        Additional Notes (Optional)
                                    </label>
                                    <textarea id="notes" 
                                              name="notes" 
                                              rows="4" 
                                              class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                              placeholder="Any specific requirements or instructions for the tutor...">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-2 text-sm text-gray-500">
                                        Let the tutor know about any specific requirements, deadlines, or preferences you have for this service.
                                    </p>
                                </div>
                        
                                <!-- Terms and Conditions -->
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-medium text-blue-800">Order Information</h3>
                                            <div class="mt-2 text-sm text-blue-700">
                                                <ul class="list-disc list-inside space-y-1">
                                                    <li>Your order will be pending until the tutor approves it</li>
                                                    <li>You can edit or cancel your order while it's in pending status</li>
                                                    <li>Payment will be required after the tutor approves your order</li>
                                                    <li>The tutor will begin work after payment confirmation</li>
                                                </ul>
                                            </div>
                                        </div>
                        </div>
                    </div>
                    
                                <!-- Submit Buttons -->
                                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                                    <a href="{{ route('services.show', $service) }}" 
                                       class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Cancel
                                    </a>
                                    <button type="submit" 
                                            class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                        </svg>
                                        Place Order
                                    </button>
                            </div>
                            </form>
                    </div>
                </div>
            </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Order Summary -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg sticky top-8">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h3>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Service</span>
                                    <span class="text-sm font-medium text-gray-900">{{ $service->title }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Category</span>
                                    <span class="text-sm text-gray-900">{{ $service->category->name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Tutor</span>
                                    <span class="text-sm text-gray-900">{{ $service->tutor->name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Delivery Time</span>
                                    <span class="text-sm text-gray-900">{{ $service->duration_days }} days</span>
                                </div>
                                <div class="border-t border-gray-200 pt-3">
                                    <div class="flex justify-between">
                                        <span class="text-base font-medium text-gray-900">Total Price</span>
                                        <span class="text-lg font-bold text-gray-900">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 text-xs text-gray-500">
                                <p class="mb-2">
                                    <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    No hidden fees
                                </p>
                                <p class="mb-2">
                                    <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Edit/cancel before approval
                                </p>
                                <p>
                                    <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Pay only after approval
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Tutor Information -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Tutor Information</h3>
                            
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $service->tutor->name }}</p>
                                    <p class="text-xs text-gray-500">Professional Tutor</p>
                                </div>
                            </div>

                            <div class="text-sm text-gray-600 space-y-2">
                                <p>Specializes in {{ $service->category->name }}</p>
                                <p>Average delivery: {{ $service->duration_days }} days</p>
                            </div>

                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <a href="{{ route('services.show', $service) }}" 
                                   class="text-sm text-blue-600 hover:text-blue-900">
                                    View full service details →
                                </a>
                            </div>
                        </div>
                    </div>
                    </div>
            </div>
        </div>
    </div>
</x-app-layout>