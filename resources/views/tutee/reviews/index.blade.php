<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Reviews') }}
        </h2>
    </x-slot>
    <div class="py-8 max-w-4xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Reviews You've Given</h3>
            @if($reviews->isEmpty())
                <p class="text-gray-500">You haven't left any reviews yet.</p>
            @else
                <ul class="divide-y divide-gray-200">
                    @foreach($reviews as $review)
                        <li class="py-4">
                            <div class="flex justify-between items-center">
                                <div>
                                    <div class="font-semibold">To: {{ $review->tutor->name }}</div>
                                    <div class="text-sm text-gray-600">Rating: {{ $review->rating }}/5</div>
                                    <div class="text-gray-700 mt-1">{{ $review->review }}</div>
                                    @if($review->response)
                                        <div class="mt-2 text-xs text-blue-700">Tutor Response: {{ $review->response }}</div>
                                    @endif
                                </div>
                                <div class="text-xs text-gray-400">{{ $review->created_at->format('d M Y') }}</div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-app-layout> 