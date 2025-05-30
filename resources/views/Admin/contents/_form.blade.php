<form action="{{ isset($content) ? route('admin.contents.update', $content) : route('admin.contents.store') }}"
      method="POST"
      class="space-y-6">
    @csrf
    @if(isset($content))
        @method('PUT')
    @endif
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Title -->
        <div class="col-span-2">
            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
            <input type="text"
                   name="title"
                   id="title"
                   value="{{ old('title', $content->title ?? '') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                   required>
            @error('title')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <!-- Type -->
        <div>
            <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
            <select name="type"
                    id="type"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    required>
                <option value="">Select Type</option>
                <option value="faq" {{ old('type', $content->type ?? '') === 'faq' ? 'selected' : '' }}>FAQ</option>
                <option value="guide" {{ old('type', $content->type ?? '') === 'guide' ? 'selected' : '' }}>Guide</option>
                <option value="policy" {{ old('type', $content->type ?? '') === 'policy' ? 'selected' : '' }}>Policy</option>
            </select>
            @error('type')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <!-- Order -->
        <div>
            <label for="order" class="block text-sm font-medium text-gray-700">Display Order</label>
            <input type="number"
                   name="order"
                   id="order"
                   min="1"
                   value="{{ old('order', $content->order ?? 1) }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('order')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <!-- Content Editor -->
    <div x-data="setupEditor(`{{ old('content', $content->content ?? '') }}`)"
         x-init="init($refs.editor)"
         x-on:destroy="destroy()"
         class="col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-2">Content</label>
        <!-- Editor Toolbar -->
        <div class="border rounded-t-lg bg-gray-50 p-2 flex gap-2">
            <button type="button"
                    @click="editor.chain().focus().toggleBold().run()"
                    data-toolbar-button="bold"
                    class="p-2 rounded hover:bg-gray-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M6 4h8a4 4 0 014 4 4 4 0 01-4 4H6z"></path>
                    <path d="M6 12h9a4 4 0 014 4 4 4 0 01-4 4H6z"></path>
                </svg>
            </button>
            <button type="button"
                    @click="editor.chain().focus().toggleItalic().run()"
                    data-toolbar-button="italic"
                    class="p-2 rounded hover:bg-gray-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <line x1="19" y1="4" x2="10" y2="4"></line>
                    <line x1="14" y1="20" x2="5" y2="20"></line>
                    <line x1="15" y1="4" x2="9" y2="20"></line>
                </svg>
            </button>
            <button type="button"
                    @click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
                    class="p-2 rounded hover:bg-gray-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16"></path>
                </svg>
            </button>
        </div>
        <!-- Editor Content -->
        <div x-ref="editor"
             class="prose max-w-none border border-t-0 rounded-b-lg p-4 min-h-[200px]">
        </div>
        <!-- Hidden input for form submission -->
        <input type="hidden"
               name="content"
               id="content"
               :value="content">
        @error('content')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
    <!-- Active Status -->
    <div>
        <label class="inline-flex items-center">
            <input type="checkbox"
                   name="is_active"
                   value="1"
                   {{ old('is_active', $content->is_active ?? true) ? 'checked' : '' }}
                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            <span class="ml-2 text-sm text-gray-600">Active</span>
        </label>
    </div>
    <!-- Form Actions -->
    <div class="flex justify-end gap-4">
        <a href="{{ route('admin.contents.index') }}"
           class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-500">
            Cancel
        </a>
        <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
            {{ isset($content) ? 'Update' : 'Create' }} Content
        </button>
    </div>
</form>