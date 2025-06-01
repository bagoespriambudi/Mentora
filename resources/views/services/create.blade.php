<x-layouts.app>
    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4">
            <a href="{{ route('services.manage') }}" class="text-sm text-blue-600 hover:underline mb-4 inline-block">
                &larr; Back to Services
            </a>

            <h2 class="text-xl font-semibold mb-1">Create New Service on Mentora</h2>
            <p class="text-sm text-gray-600 mb-6">Add a new service to your Mentora portfolio</p>

            <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                {{-- Title --}}
                <div>
                    <label class="block text-sm">Service Title</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                        class="w-full mt-1 border rounded p-2 text-sm" required>
                    @error('title') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Category --}}
                <div>
                    <label class="block text-sm">Category</label>
                    <select name="category_id" class="w-full mt-1 border rounded p-2 text-sm" required>
                        <option value="">Select category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-sm">Description</label>
                    <textarea name="description" rows="4"
                        class="w-full mt-1 border rounded p-2 text-sm" required>{{ old('description') }}</textarea>
                    @error('description') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Price and Duration --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm">Price ($)</label>
                        <input type="number" name="price" value="{{ old('price') }}" min="1" step="0.01"
                            class="w-full mt-1 border rounded p-2 text-sm" required>
                        @error('price') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm">Delivery Time (days)</label>
                        <input type="number" name="duration_days" value="{{ old('duration_days') }}" min="1"
                            class="w-full mt-1 border rounded p-2 text-sm" required>
                        @error('duration_days') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Thumbnail --}}
                <div>
                    <label class="block text-sm">Thumbnail Image</label>
                    <input type="file" name="thumbnail" accept="image/*" class="mt-1 text-sm" required>
                    @error('thumbnail') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    <div id="thumbnail-preview" class="mt-2 hidden">
                        <img src="" alt="Preview" class="w-24 h-24 object-cover rounded">
                    </div>
                </div>

                {{-- Gallery --}}
                <div>
                    <label class="block text-sm">Gallery Images</label>
                    <input type="file" name="gallery[]" multiple accept="image/*" class="mt-1 text-sm">
                    @error('gallery') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    <div id="gallery-preview" class="grid grid-cols-4 gap-2 mt-2"></div>
                </div>

                {{-- Submit --}}
                <div class="text-right">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                        Create Service
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        // Thumbnail preview
        document.querySelector('input[name="thumbnail"]').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('thumbnail-preview');
                    preview.querySelector('img').src = e.target.result;
                    preview.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        // Gallery preview
        document.querySelector('input[name="gallery[]"]').addEventListener('change', function(e) {
            const container = document.getElementById('gallery-preview');
            container.innerHTML = '';
            [...e.target.files].forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-full h-24 object-cover rounded';
                    container.appendChild(img);
                }
                reader.readAsDataURL(file);
            });
        });
    </script>
    @endpush
</x-layouts.app>