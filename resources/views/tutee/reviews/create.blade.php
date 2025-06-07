<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Write a Review') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-8">
                    <!-- Session Info -->
                    <div class="mb-8 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-100">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Session Details
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Tutor</p>
                                    <p class="font-semibold text-gray-900">{{ $service->tutor->name ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z M4 5a2 2 0 012-2v1a1 1 0 001 1h6a1 1 0 001-1V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zM7 10a2 2 0 10-4 0 2 2 0 004 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Service</p>
                                    <p class="font-semibold text-gray-900">{{ $service->title ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('tutee.reviews.store', $service) }}" class="space-y-8">
                        @csrf
                        
                        <!-- Rating Section -->
                        <div>
                            <x-input-label for="rating" :value="__('Rating')" class="text-lg font-medium mb-3" />
                            <div class="flex items-center space-x-2" id="star-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <label class="cursor-pointer group">
                                        <input type="radio" name="rating" value="{{ $i }}" class="sr-only" required>
                                        <svg class="w-10 h-10 text-gray-300 hover:text-yellow-400 group-hover:scale-110 transition-all duration-200" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </label>
                                @endfor
                                <span class="ml-4 text-sm text-gray-500" id="rating-text">Click to rate</span>
                            </div>
                            <x-input-error :messages="$errors->get('rating')" class="mt-2" />
                        </div>

                        <!-- Review Text -->
                        <div>
                            <x-input-label for="review" :value="__('Your Review')" class="text-lg font-medium mb-3" />
                            <textarea
                                id="review"
                                name="review"
                                class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                rows="5"
                                required
                                placeholder="Share your experience with this tutor... What did you learn? How was their teaching style?"
                            >{{ old('review') }}</textarea>
                            <x-input-error :messages="$errors->get('review')" class="mt-2" />
                        </div>

                        <!-- Info Notice -->
                        <div class="bg-amber-50 border-l-4 border-amber-400 p-4 rounded-r-lg">
                            <div class="flex">
                                <svg class="h-5 w-5 text-amber-400 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <p class="ml-3 text-sm text-amber-700">
                                    Your honest feedback helps improve our community and guides future students in choosing the right tutor.
                                </p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between pt-6 border-t">
                            <a href="{{ route('tutee.reviews.index') }}" 
                               class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-xl font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 border border-transparent rounded-xl font-semibold text-white hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:ring-blue-200 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                                Submit Review
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ratingInputs = document.querySelectorAll('input[name="rating"]');
            const stars = document.querySelectorAll('#star-rating svg');
            const ratingText = document.getElementById('rating-text');
            const labels = ['Poor', 'Fair', 'Good', 'Very Good', 'Excellent'];

            ratingInputs.forEach((input, index) => {
                input.addEventListener('change', function() {
                    stars.forEach((star, i) => {
                        star.classList.toggle('text-yellow-400', i <= index);
                        star.classList.toggle('text-gray-300', i > index);
                    });
                    ratingText.textContent = labels[index] || 'Click to rate';
                });
            });

            // Hover effects
            stars.forEach((star, index) => {
                star.addEventListener('mouseenter', () => {
                    ratingText.textContent = labels[index] || 'Click to rate';
                });
            });

            document.getElementById('star-rating').addEventListener('mouseleave', () => {
                const checked = document.querySelector('input[name="rating"]:checked');
                ratingText.textContent = checked ? labels[checked.value - 1] : 'Click to rate';
            });
        });
    </script>
    @endpush
</x-app-layout>