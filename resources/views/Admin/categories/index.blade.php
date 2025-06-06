<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Category Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold mb-4">
                            Category List
                        </h1>
                        <a href="{{ route('admin.categories.create') }}"
                           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            Add Category
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($categories->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-blue-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">Description</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">Services</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-700 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($categories as $category)
                                        <tr class="hover:bg-blue-50 transition">
                                            <td class="px-6 py-4 font-medium text-gray-900">{{ $category->name }}</td>
                                            <td class="px-6 py-4 text-gray-600">
                                                {{ Str::limit($category->description, 50) ?: 'No description' }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                                                    {{ $category->services_count }} services
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex space-x-3">
                                                    <a href="{{ route('admin.categories.show', $category) }}"
                                                       class="text-gray-600 hover:text-gray-900 transition">
                                                        View
                                                    </a>
                                                    <a href="{{ route('admin.categories.edit', $category) }}"
                                                       class="text-blue-600 hover:text-blue-900 transition">
                                                        Edit
                                                    </a>
                                                    @if($category->services_count === 0)
                                                        <form action="{{ route('admin.categories.destroy', $category) }}"
                                                              method="POST"
                                                              onsubmit="return confirm('Are you sure you want to delete this category?');"
                                                              class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-900 transition">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $categories->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-blue-300 text-6xl mb-4">
                                <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-blue-900 mb-2">No categories found</h3>
                            <p class="text-blue-600 mb-4">Start by creating your first category</p>
                            <a href="{{ route('admin.categories.create') }}" 
                               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                                Create Category
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>