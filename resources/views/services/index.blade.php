<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Browse Services') }}
        </h2>
    </x-slot>
    <div class="py-8 max-w-6xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($services as $service)
                <div class="bg-white rounded-xl shadow-md p-6 flex flex-col justify-between">
                    <div>
                        <div class="mb-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $service->category->name ?? '-' }}
                            </span>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-2">{{ $service->title }}</h2>
                        <p class="text-gray-600 mb-4 line-clamp-3">{{ Str::limit($service->description, 100) }}</p>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <div class="text-lg font-bold text-indigo-700">Rp {{ number_format($service->price, 0, ',', '.') }}</div>
                        <a href="{{ route('services.show', $service) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-200">
                            View
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-16">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No services available</h3>
                    <p class="text-gray-600 mb-6">Please check back later for new sessions and services.</p>
                </div>
            @endforelse
        </div>
        @if($services->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $services->links() }}
            </div>
        @endif
    </div>
</x-app-layout> 