<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Monitor Reviews & Ratings') }}
        </h2>
    </x-slot>
    <div class="py-8 max-w-5xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">All Reviews</h3>
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Tutee</th>
                        <th class="px-4 py-2">Tutor</th>
                        <th class="px-4 py-2">Rating</th>
                        <th class="px-4 py-2">Review</th>
                        <th class="px-4 py-2">Response</th>
                        <th class="px-4 py-2">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reviews as $review)
                        <tr>
                            <td class="px-4 py-2">{{ $review->tutee->name ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $review->tutor->name ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $review->rating }}/5</td>
                            <td class="px-4 py-2">{{ $review->review }}</td>
                            <td class="px-4 py-2">{{ $review->response ?? '-' }}</td>
                            <td class="px-4 py-2 text-xs text-gray-400">{{ $review->created_at->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">{{ $reviews->links() }}</div>
        </div>
    </div>
</x-app-layout> 