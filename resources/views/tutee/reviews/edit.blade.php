<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Review') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Session Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Tutor</p>
                                <p class="font-medium">{{ $review->tutor->name ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Service</p>
                                <p class="font-medium">{{ $review->session->title ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('tutee.reviews.update', $review->id) }}" class="space-y-6">
                        @csrf
                        @method('PUT')
                        <div>
                            <x-input-label for="rating" :value="__('Rating')" />
                            <div class="mt-2 flex items-center space-x-4">
                                @for($i = 1; $i <= 5; $i++)
                                    <label class="relative">
                                        <input type="radio" name="rating" value="{{ $i }}" class="sr-only" required {{ $review->rating == $i ? 'checked' : '' }}>
                                        <svg class="w-8 h-8 cursor-pointer {{ $review->rating >= $i ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </label>
                                @endfor
                            </div>
                            <x-input-error :messages="$errors->get('rating')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="review" :value="__('Your Review')" />
                            <textarea
                                id="review"
                                name="review"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50"
                                rows="4"
                                required
                                placeholder="Share your experience with this tutor..."
                            >{{ old('review', $review->review) }}</textarea>
                            <x-input-error :messages="$errors->get('review')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Update Review') }}</x-primary-button>
                            <a href="{{ route('tutee.reviews.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 