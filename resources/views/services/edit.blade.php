<x-layouts.app>
    <div class="min-h-screen bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header Section -->
            <div class="mb-8">
                <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-4">
                    <a href="{{ route('services.manage') }}" class="hover:text-gray-700 transition-colors duration-150">
                        My Sessions
                    </a>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <span class="text-gray-900">Edit Session</span>
                </nav>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('services.manage') }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Sessions
                    </a>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Edit Session</h1>
                        <p class="text-gray-600 mt-1">Update your session information</p>
                    </div>
                </div>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-green-800 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-red-800 font-medium">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <!-- Form Section -->
            <div class="bg-white shadow-sm rounded-lg">
                <form action="{{ route('services.update', $service) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Basic Information -->
                    <div class="border-b border-gray-200 pb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Session Title -->
                            <div class="md:col-span-2">
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                    Session Title <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="title" 
                                       name="title" 
                                       value="{{ old('title', $service->title) }}" 
                                       required 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-150">
                                @error('title') 
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p> 
                                @enderror
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Category <span class="text-red-500">*</span>
                                </label>
                                <select id="category_id" 
                                        name="category_id" 
                                        required 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-150">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $service->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id') 
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p> 
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="flex items-center">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                    <div class="flex items-center space-x-3">
                                        <input type="hidden" name="is_active" value="0">
                                        <input type="checkbox" 
                                               id="is_active" 
                                               name="is_active" 
                                               value="1" 
                                               {{ old('is_active', $service->is_active) ? 'checked' : '' }}
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label for="is_active" class="text-sm text-gray-700">Session is active</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mt-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Description <span class="text-red-500">*</span>
                            </label>
                            <textarea id="description" 
                                      name="description" 
                                      rows="4" 
                                      required 
                                      placeholder="Describe what you offer in this session..."
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-150">{{ old('description', $service->description) }}</textarea>
                            @error('description') 
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p> 
                            @enderror
                        </div>
                    </div>

                    <!-- Pricing & Delivery -->
                    <div class="border-b border-gray-200 pb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Pricing & Delivery</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Price -->
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                    Price (IDR) <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">Rp.</span>
                                    </div>
                                    <input type="number" 
                                           id="price" 
                                           name="price" 
                                           min="1" 
                                           step="0.01" 
                                           value="{{ old('price', $service->price) }}" 
                                           required 
                                           class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-150">
                                </div>
                                @error('price') 
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p> 
                                @enderror
                            </div>

                            <!-- Delivery Time -->
                            <div>
                                <label for="duration_days" class="block text-sm font-medium text-gray-700 mb-2">
                                    Delivery Time <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number" 
                                           id="duration_days" 
                                           name="duration_days" 
                                           min="1" 
                                           value="{{ old('duration_days', $service->duration_days) }}" 
                                           required 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-150">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">days</span>
                                    </div>
                                </div>
                                @error('duration_days') 
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p> 
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Images -->
                    <div class="pb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Images</h3>
                        
                        <!-- Thumbnail -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Thumbnail Image</label>
                            @if($service->thumbnail)
                                <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                                    <div class="flex items-start space-x-4">
                                        <img src="{{ Storage::url($service->thumbnail) }}" 
                                             alt="Current thumbnail" 
                                             class="w-24 h-24 object-cover rounded-lg border border-gray-200">
                                        <div>
                                            <p class="text-sm text-gray-600 mb-2">Current thumbnail</p>
                                            <label class="flex items-center space-x-2">
                                                <input type="checkbox" 
                                                       name="remove_thumbnail" 
                                                       value="1"
                                                       class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                                                <span class="text-sm text-red-600">Remove existing thumbnail</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="mt-2">
                                <input type="file" 
                                       id="thumbnail" 
                                       name="thumbnail" 
                                       accept="image/*"
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <p class="mt-1 text-sm text-gray-500">PNG, JPG, GIF up to 10MB</p>
                            </div>
                            @error('thumbnail') 
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p> 
                            @enderror
                        </div>

                        <!-- Gallery -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Gallery Images</label>
                            @if($service->gallery && count($service->gallery) > 0)
                                <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                                    <p class="text-sm text-gray-600 mb-3">Current gallery images</p>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                                        @foreach($service->gallery as $index => $image)
                                            <div class="relative">
                                                <img src="{{ Storage::url($image) }}" 
                                                     alt="Gallery image" 
                                                     class="w-full h-24 object-cover rounded-lg border border-gray-200">
                                                <label class="absolute top-2 right-2 bg-white rounded-full p-1 shadow-sm">
                                                    <input type="checkbox" 
                                                           name="removed_gallery_images[]" 
                                                           value="{{ $index }}"
                                                           class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <p class="text-xs text-red-600 mt-2">Check images you want to remove</p>
                                </div>
                            @endif
                            <div class="mt-2">
                                <input type="file" 
                                       id="gallery" 
                                       name="gallery[]" 
                                       accept="image/*" 
                                       multiple
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <p class="mt-1 text-sm text-gray-500">Select multiple images for gallery. PNG, JPG, GIF up to 10MB each</p>
                            </div>
                            @error('gallery') 
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p> 
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-end space-x-4 pt-6">
                        <a href="{{ route('services.manage') }}" 
                           class="px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-150">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Update Session
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>