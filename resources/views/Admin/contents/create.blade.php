<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Content') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold">Add Content</h2>
                    <p class="text-gray-600">Create new content for your site</p>
                </div>
                @include('admin.contents._form')
            </div>
        </div>
    </div>
</x-app-layout>