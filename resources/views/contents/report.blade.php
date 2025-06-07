<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Report Content') }}
        </h2>
    </x-slot>
    <div class="py-8 max-w-2xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Report: {{ $content->title }}</h3>
            <form method="POST" action="{{ route('contents.report.submit', $content) }}">
                @csrf
                <label for="reason" class="block font-medium">Reason for reporting:</label>
                <textarea name="reason" id="reason" class="w-full border rounded p-2 mb-2" required></textarea>
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Submit Report</button>
                <a href="{{ route('contents.show', $content) }}" class="text-blue-600 hover:underline ml-4">Cancel</a>
            </form>
        </div>
    </div>
</x-app-layout> 