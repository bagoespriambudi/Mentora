<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Review Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">All Reviews</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tutee</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tutor</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Review</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Response</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($reviews as $review)
                                        <tr>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">
                                                {{ $review->created_at->format('d M Y') }}
                                            </td>
                                            <td class="px-4 py-2 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $review->tutee->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $review->tutee->email }}</div>
                                            </td>
                                            <td class="px-4 py-2 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $review->tutor->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $review->tutor->email }}</div>
                                            </td>
                                            <td class="px-4 py-2 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                    @endfor
                                                </div>
                                            </td>
                                            <td class="px-4 py-2">
                                                <div class="text-sm text-gray-900">{{ Str::limit($review->review, 100) }}</div>
                                            </td>
                                            <td class="px-4 py-2">
                                                @if($review->response)
                                                    <div class="text-sm text-gray-900">{{ Str::limit($review->response, 100) }}</div>
                                                @else
                                                    <span class="text-sm text-gray-500">No response yet</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 whitespace-nowrap text-sm font-medium">
                                                <button type="button" class="text-blue-600 hover:text-blue-900" onclick="showReviewDetails({{ $review->id }})">
                                                    View Details
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-4 py-4 text-center text-gray-500">No reviews found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $reviews->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Review Details Modal -->
    <div id="reviewModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg max-w-2xl w-full">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Review Details</h3>
                        <button type="button" class="text-gray-400 hover:text-gray-500" onclick="hideReviewDetails()">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div id="reviewDetails" class="space-y-4">
                        <!-- Content will be loaded dynamically -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function showReviewDetails(reviewId) {
            const modal = document.getElementById('reviewModal');
            const detailsContainer = document.getElementById('reviewDetails');
            
            // Show loading state
            detailsContainer.innerHTML = '<div class="text-center"><svg class="animate-spin h-8 w-8 text-blue-500 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg></div>';
            modal.classList.remove('hidden');

            // Fetch review details
            fetch(`/api/reviews/${reviewId}`)
                .then(response => response.json())
                .then(data => {
                    detailsContainer.innerHTML = `
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Tutee</p>
                                <p class="font-medium">${data.tutee.name}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Tutor</p>
                                <p class="font-medium">${data.tutor.name}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Rating</p>
                                <div class="flex items-center">
                                    ${Array(5).fill().map((_, i) => `
                                        <svg class="w-5 h-5 ${i < data.rating ? 'text-yellow-400' : 'text-gray-300'}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    `).join('')}
                                </div>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Date</p>
                                <p class="font-medium">${new Date(data.created_at).toLocaleDateString()}</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Review</p>
                            <p class="mt-1 text-gray-900">${data.review}</p>
                        </div>
                        ${data.response ? `
                            <div>
                                <p class="text-sm text-gray-600">Tutor's Response</p>
                                <p class="mt-1 text-gray-900">${data.response}</p>
                            </div>
                        ` : ''}
                    `;
                })
                .catch(error => {
                    detailsContainer.innerHTML = '<div class="text-red-500">Error loading review details.</div>';
                });
        }

        function hideReviewDetails() {
            const modal = document.getElementById('reviewModal');
            modal.classList.add('hidden');
        }
    </script>
    @endpush
</x-app-layout> 