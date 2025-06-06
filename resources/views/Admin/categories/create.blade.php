<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">
                    Create New Category
                </h2>
                <a href="{{ route('admin.categories.index') }}"
                class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                        </svg>
                        Back
                </a>
            </div>

            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Category Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name') }}"
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
                              placeholder="Enter category description (optional)">{{ old('description') }}</textarea>
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
                               {{ old('is_active', true) ? 'checked' : '' }}
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

                <!-- Submit Buttons -->
                <div class="flex justify-between pt-6 border-t border-gray-200">
                    <div class="flex space-x-3">
                        <button type="submit"
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Create Category
                        </button>
                        <button type="reset"
                                class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                            Reset
                        </button>
                    </div>
                    <a href="{{ route('admin.categories.index') }}"
                       class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Preview Card -->
        <div id="previewCard" class="mt-6 bg-blue-50 rounded-lg shadow-sm p-6" style="display: none;">
            <h3 class="text-lg font-semibold text-blue-900 mb-4">Preview</h3>
            <div class="bg-white rounded-md p-4 border border-blue-200">
                <h4 class="font-bold text-gray-900" id="previewName">Category Name</h4>
                <p class="text-gray-600 mt-1" id="previewDescription">No description provided</p>
                <span id="previewStatus" class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 mt-2">
                    Active
                </span>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.getElementById('name');
        const descriptionInput = document.getElementById('description');
        const statusInput = document.getElementById('is_active');
        const previewCard = document.getElementById('previewCard');
        const previewName = document.getElementById('previewName');
        const previewDescription = document.getElementById('previewDescription');
        const previewStatus = document.getElementById('previewStatus');

        function updatePreview() {
            const name = nameInput.value.trim();
            const description = descriptionInput.value.trim();
            const isActive = statusInput.checked;

            if (name) {
                previewCard.style.display = 'block';
                previewName.textContent = name;
                previewDescription.textContent = description || 'No description provided';
                
                if (isActive) {
                    previewStatus.className = 'inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 mt-2';
                    previewStatus.textContent = 'Active';
                } else {
                    previewStatus.className = 'inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 mt-2';
                    previewStatus.textContent = 'Inactive';
                }
            } else {
                previewCard.style.display = 'none';
            }
        }

        nameInput.addEventListener('input', updatePreview);
        descriptionInput.addEventListener('input', updatePreview);
        statusInput.addEventListener('change', updatePreview);

        updatePreview();
    });
    </script>
    @endpush
</x-app-layout>