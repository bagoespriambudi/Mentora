<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Reviews') }}
        </h2>
    </x-slot>
    <div class="py-8 max-w-4xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Your Finished Bookings & Reviews</h3>
            @if($finishedBookings->isEmpty())
                <p class="text-gray-500">You have no finished bookings yet.</p>
            @else
                <ul class="divide-y divide-gray-200">
                    @foreach($finishedBookings as $booking)
                        <li class="py-4">
                            <div class="flex justify-between items-center">
                                <div>
                                    <div class="font-semibold">Session: {{ $booking->session->title ?? '-' }}</div>
                                    <div class="text-sm text-gray-600">Tutor: {{ $booking->session->tutor->name ?? '-' }}</div>
                                    @php
                                        $review = $reviews->firstWhere('session_id', $booking->session_id);
                                    @endphp
                                    @if($review)
                                        <div class="text-sm text-gray-600 mt-1">Rating: {{ $review->rating }}/5</div>
                                        <div class="text-gray-700 mt-1">{{ $review->review }}</div>
                                        @if($review->response)
                                            <div class="mt-2 text-xs text-blue-700">Tutor Response: {{ $review->response }}</div>
                                        @endif
                                        <div class="mt-2 flex gap-2">
                                            <a href="{{ route('tutee.reviews.edit', $review->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                            <form action="{{ route('tutee.reviews.destroy', $review->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline ml-2" onclick="return confirm('Are you sure you want to delete this review?')">Delete</button>
                                            </form>
                                        </div>
                                    @else
                                        <a href="{{ route('tutee.reviews.create', $booking->session_id) }}" class="inline-block px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Add Review</a>
                                    @endif
                                </div>
                                <div class="text-xs text-gray-400">Booked: {{ $booking->scheduled_at ? \Carbon\Carbon::parse($booking->scheduled_at)->format('d M Y') : '-' }}</div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-app-layout> 