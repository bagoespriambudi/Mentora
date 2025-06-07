<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">
                        Edit Category: {{ $category->name }}
                    </h2>
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

                <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <!-- Name Field -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Category Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $category->name) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                            placeholder="Enter category name"
                            required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Category name must be unique and not exceed 255 characters.</p>
                    </div>

                    <!-- Description Field -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea id="description"
                                name="description"
                                rows="4"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                                placeholder="Enter category description (optional)">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Provide a brief description of what this category represents.</p>
                    </div>

                    <!-- Status Field -->
                    <div>
                        <div class="flex items-center">
                            <input type="checkbox"
                                id="is_active"
                                name="is_active"
                                value="1"
                                {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                Active Category
                            </label>
                        </div>
                        @error('is_active')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Inactive categories will not be visible to users.</p>
                    </div>

                    <!-- Category Info -->
                    <div class="bg-blue-50 rounded-lg p-4">
                        <h4 class="font-semibold text-blue-900 mb-2">Category Information</h4>
                        <div class="text-sm text-blue-800 space-y-1">
                            <p><span class="font-medium">Created:</span> {{ $category->created_at->format('d M Y, H:i') }}</p>
                            <p><span class="font-medium">Last Updated:</span> {{ $category->updated_at->format('d M Y, H:i') }}</p>
                            <p><span class="font-medium">Total Services:</span> {{ $category->services()->count() }} services</p>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-between pt-6 border-t border-gray-200">
                        <div class="flex space-x-3">
                            <button type="submit"
                                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Update Category
                            </button>
                            <button type="reset"
                                    class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                Reset Changes
                            </button>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.categories.show', $category) }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                                View
                            </a>
                            <a href="{{ route('admin.categories.index') }}"
                            class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Changes Preview -->
            <div class="mt-6 bg-yellow-50 rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-yellow-900 mb-4">Preview Changes</h3>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-medium text-gray-700 mb-2">Current Values</h4>
                        <div class="bg-white rounded-md p-4 border border-yellow-200">
                            <p class="mb-2"><span class="font-medium">Name:</span> {{ $category->name }}</p>
                            <p class="mb-2"><span class="font-medium">Description:</span> {{ $category->description ?: 'No description' }}</p>
                            <p><span class="font-medium">Status:</span> 
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-medium text-blue-700 mb-2">New Values (Preview)</h4>
                        <div class="bg-white rounded-md p-4 border border-yellow-200">
                            <p class="mb-2"><span class="font-medium">Name:</span> <span id="previewName">{{ $category->name }}</span></p>
                            <p class="mb-2"><span class="font-medium">Description:</span> <span id="previewDescription">{{ $category->description ?: 'No description' }}</span></p>
                            <p><span class="font-medium">Status:</span> 
                                <span id="previewStatus" class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const descriptionInput = document.getElementById('description');
            const statusInput = document.getElementById('is_active');
            const previewName = document.getElementById('previewName');
            const previewDescription = document.getElementById('previewDescription');
            const previewStatus = document.getElementById('previewStatus');

            function updatePreview() {
                previewName.textContent = nameInput.value.trim() || '{{ $category->name }}';
                
                const desc = descriptionInput.value.trim();
                previewDescription.textContent = desc || 'No description';
                
                const isActive = statusInput.checked;
                previewStatus.className = isActive 
                    ? 'inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800'
                    : 'inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800';
                previewStatus.textContent = isActive ? 'Active' : 'Inactive';
            }

            nameInput.addEventListener('input', updatePreview);
            descriptionInput.addEventListener('input', updatePreview);
            statusInput.addEventListener('change', updatePreview);

            document.querySelector('button[type="reset"]').addEventListener('click', function() {
                setTimeout(updatePreview, 10);
            });
        });
        </script>
        @endpush
</x-app-layout>