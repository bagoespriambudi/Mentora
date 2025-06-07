<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contents') }}
        </h2>
    </x-slot>
    <div class="py-8 max-w-4xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">All Contents</h3>
            <ul class="divide-y divide-gray-200">
                @foreach($contents as $content)
                    <li class="py-4 flex justify-between items-center">
                        <div>
                            <div class="font-semibold">{{ $content->title }}</div>
                            <div class="text-gray-700 mt-1">{{ Str::limit(strip_tags($content->body ?? $content->content), 120) }}</div>
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('contents.show', $content) }}" class="text-blue-600 hover:underline">View</a>
                            @auth
                                <a href="{{ route('contents.report', $content) }}" class="text-red-600 hover:underline">Report</a>
                            @endauth
                        </div>
                    </li>
                @endforeach
            </ul>
            <div class="mt-4">{{ $contents->links() }}</div>
        </div>
    </div>
</x-app-layout> 