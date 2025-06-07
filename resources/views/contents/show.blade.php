<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $content->title }}
        </h2>
    </x-slot>
    <div class="py-8 max-w-3xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6">
            <div class="mb-4 text-gray-700">{!! nl2br(e($content->body ?? $content->content)) !!}</div>
            @auth
                <a href="{{ route('contents.report', $content) }}" class="bg-red-600 text-white px-4 py-2 rounded">Report Content</a>
            @endauth
            <a href="{{ route('contents.index') }}" class="text-blue-600 hover:underline ml-4">Back to Contents</a>
        </div>
    </div>
</x-app-layout> 