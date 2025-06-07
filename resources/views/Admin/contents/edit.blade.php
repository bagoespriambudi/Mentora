<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Content
        </h2>
    </x-slot>
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="mb-6">
            <h2 class="text-2xl font-bold">Edit Content</h2>
            <p class="text-gray-600">Update content information</p>
        </div>
        @include('admin.contents._form')
    </div>
</x-app-layout>