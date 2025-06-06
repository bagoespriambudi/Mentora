<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">{{ __('Professional Profile') }}</h2>
                        <a href="{{ route('tutor.profile.edit') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Edit Profile') }}
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Basic Information -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">{{ __('Basic Information') }}</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">{{ __('Bio') }}</label>
                                    <p class="mt-1 text-gray-900">{{ $profile->bio ?? __('No bio provided') }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">{{ __('Hourly Rate') }}</label>
                                    <p class="mt-1 text-gray-900">
                                        {{ $profile && $profile->hourly_rate !== null ? 'Rp' . number_format($profile->hourly_rate, 2) . '/jam' : __('Not set') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Expertise -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">{{ __('Expertise') }}</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($profile->expertise ?? [] as $subject)
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                                        {{ $subject }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <!-- Availability -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">{{ __('Availability') }}</h3>
                            <div class="space-y-2">
                                @foreach($profile->availability ?? [] as $slot)
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">{{ $slot['day'] }}</span>
                                        <span class="text-gray-900">
                                            {{ \Carbon\Carbon::parse($slot['start_time'])->format('H:i') }} - 
                                            {{ \Carbon\Carbon::parse($slot['end_time'])->format('H:i') }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Qualifications -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">{{ __('Qualifications') }}</h3>
                            @if($profile->qualification_file)
                                <a href="{{ route('tutor.profile.qualification.download') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-700 text-white font-bold rounded">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    {{ __('Download Qualifications') }}
                                </a>
                            @else
                                <p class="text-gray-500">{{ __('No qualification file uploaded') }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="mb-6">
                        @if(session('success'))
                            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-2">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-2">{{ session('error') }}</div>
                        @endif
                        @if(!$profile->is_available_for_sessions)
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                                <div class="font-semibold mb-2">{{ __('Profile Completion Checklist') }}</div>
                                <ul class="list-disc pl-6 text-sm">
                                    <li class="{{ $profile->bio ? 'text-green-700' : 'text-red-600' }}">{{ __('Bio') }}</li>
                                    <li class="{{ $profile->hourly_rate ? 'text-green-700' : 'text-red-600' }}">{{ __('Hourly Rate') }}</li>
                                    <li class="{{ !empty($profile->expertise) ? 'text-green-700' : 'text-red-600' }}">{{ __('Expertise') }}</li>
                                    <li class="{{ !empty($profile->availability) ? 'text-green-700' : 'text-red-600' }}">{{ __('Availability') }}</li>
                                    <li class="{{ $profile->qualification_file ? 'text-green-700' : 'text-red-600' }}">{{ __('Qualifications') }}</li>
                                </ul>
                                @if($isProfileComplete)
                                    <form method="POST" action="{{ route('tutor.profile.publish') }}" class="mt-4">
                                        @csrf
                                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">{{ __('Publish Profile & Open for Sessions') }}</button>
                                    </form>
                                @else
                                    <div class="mt-2 text-yellow-800">{{ __('Please complete all fields above to publish your profile.') }}</div>
                                @endif
                            </div>
                        @else
                            <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-4">
                                <span class="font-semibold text-green-700">{{ __('Your profile is public and open for session bookings!') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 