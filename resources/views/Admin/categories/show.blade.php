<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Category Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $category->name }}</h1>
                        <div class="flex items-center mt-2 space-x-4">
                            <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            <span class="text-sm text-gray-500">
                                {{ $category->services->count() }} services
                            </span>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.categories.index') }}"
                        class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                            </svg>
                            Back
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Description Section -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Description</h2>
                        @if($category->description)
                            <div class="prose prose-gray max-w-none">
                                <p class="text-gray-700 leading-relaxed">{{ $category->description }}</p>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="text-gray-400 text-4xl mb-2">
                                    <svg class="w-12 h-12 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <p class="text-gray-500">No description provided for this category.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Services Section -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold text-gray-900">
                                Services in this Category
                                <span class="text-sm font-normal text-gray-500">({{ $category->services->count() }})</span>
                            </h2>
                            @if($category->services->count() > 0)
                                <button onclick="toggleServicesList()" 
                                        class="text-blue-600 hover:text-blue-800 text-sm font-medium"
                                        id="toggleButton">
                                    Show All
                                </button>
                            @endif
                        </div>

                        @if($category->services->count() > 0)
                            <div id="servicesList" class="space-y-3" style="display: none;">
                                @foreach($category->services as $service)
                                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <h3 class="font-medium text-gray-900">{{ $service->name ?? 'Service #' . $service->id }}</h3>
                                                @if(isset($service->description))
                                                    <p class="text-sm text-gray-600 mt-1">{{ Str::limit($service->description, 100) }}</p>
                                                @endif
                                                <div class="flex items-center mt-2 space-x-4 text-xs text-gray-500">
                                                    <span>Created: {{ $service->created_at->format('M d, Y') }}</span>
                                                    @if(isset($service->is_active))
                                                        <span class="px-2 py-1 rounded-full {{ $service->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                            {{ $service->is_active ? 'Active' : 'Inactive' }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            @if(isset($service->price))
                                                <div class="text-right">
                                                    <p class="font-semibold text-gray-900">${{ number_format($service->price, 2) }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <!-- Services Summary -->
                            <div id="servicesPreview" class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach($category->services->take(4) as $service)
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <p class="font-medium text-gray-900 text-sm">{{ $service->name ?? 'Service #' . $service->id }}</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $service->created_at->format('M d, Y') }}</p>
                                    </div>
                                @endforeach
                                @if($category->services->count() > 4)
                                    <div class="bg-blue-50 rounded-lg p-3 flex items-center justify-center">
                                        <p class="text-blue-700 text-sm font-medium">+{{ $category->services->count() - 4 }} more services</p>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="text-gray-400 text-4xl mb-2">
                                    <svg class="w-12 h-12 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <p class="text-gray-500 mb-2">No services in this category yet.</p>
                                <p class="text-sm text-gray-400">Services will appear here once they are assigned to this category.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Category Information -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Category Information</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">Status</span>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">Total Services</span>
                                <span class="text-sm text-gray-900 font-medium">{{ $category->services->count() }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">Created</span>
                                <span class="text-sm text-gray-900">{{ $category->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-sm font-medium text-gray-600">Last Updated</span>
                                <span class="text-sm text-gray-900">{{ $category->updated_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                        <div class="space-y-3">
                            <a href="{{ route('admin.categories.edit', $category) }}"
                            class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-center block">
                                <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                </svg>
                                Edit Category
                            </a>
                            
                            @if($category->services->count() === 0)
                                <form action="{{ route('admin.categories.destroy', $category) }}" 
                                    method="POST" 
                                    onsubmit="return confirm('Are you sure you want to delete this category? This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                                        <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        Delete Category
                                    </button>
                                </form>
                            @else
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 text-yellow-400 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium text-yellow-800">Cannot Delete</p>
                                            <p class="text-xs text-yellow-700 mt-1">This category has associated services and cannot be deleted.</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Statistics -->
                    @if($category->services->count() > 0)
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistics</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-sm text-gray-600">Active Services</span>
                                    <span class="text-sm font-medium text-green-600">
                                        {{ $category->services->where('is_active', true)->count() ?? $category->services->count() }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-sm text-gray-600">Inactive Services</span>
                                    <span class="text-sm font-medium text-red-600">
                                        {{ $category->services->where('is_active', false)->count() ?? 0 }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @push('scripts')
        <script>
        function toggleServicesList() {
            const servicesList = document.getElementById('servicesList');
            const servicesPreview = document.getElementById('servicesPreview');
            const toggleButton = document.getElementById('toggleButton');
            
            if (servicesList.style.display === 'none') {
                servicesList.style.display = 'block';
                servicesPreview.style.display = 'none';
                toggleButton.textContent = 'Show Less';
            } else {
                servicesList.style.display = 'none';
                servicesPreview.style.display = 'grid';
                toggleButton.textContent = 'Show All';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const servicesList = document.getElementById('servicesList');
            const servicesPreview = document.getElementById('servicesPreview');
            
            if (servicesList && servicesPreview) {
                servicesList.style.display = 'none';
                servicesPreview.style.display = 'grid';
            }
        });
        </script>
        @endpush
</x-app-layout>