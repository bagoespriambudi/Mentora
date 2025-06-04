<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 text-blue-700">Your Profile</h3>
                    @if(session('success'))
                        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1" for="name">Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1" for="email">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1" for="password">New Password</label>
                            <input type="password" name="password" id="password" class="w-full border-gray-300 rounded-md shadow-sm">
                            <span class="text-xs text-gray-400">Leave blank to keep current password</span>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 mb-1" for="password_confirmation">Confirm New Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 