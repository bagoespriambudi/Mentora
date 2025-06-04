<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">User Management</h1>
                    
                    <div class="mb-4">
                        <a href="{{ route('admin.users.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Manage Users
                        </a>
                    </div>

                    <div class="mt-8">
                        <h2 class="text-xl font-semibold mb-4">Quick Stats</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="font-medium text-gray-900">Total Users</h3>
                                <p class="text-2xl font-bold text-blue-600">{{ \App\Models\User::count() }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="font-medium text-gray-900">Active Users</h3>
                                <p class="text-2xl font-bold text-green-600">{{ \App\Models\User::where('is_active', true)->count() }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="font-medium text-gray-900">New Users (7d)</h3>
                                <p class="text-2xl font-bold text-indigo-600">{{ \App\Models\User::where('created_at', '>=', now()->subDays(7))->count() }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-purple-50 p-4 rounded-lg">
                                <h3 class="font-medium text-gray-900">Total Tutors</h3>
                                <p class="text-2xl font-bold text-purple-700">{{ \App\Models\User::where('role', 'tutor')->count() }}</p>
                            </div>
                            <div class="bg-yellow-50 p-4 rounded-lg">
                                <h3 class="font-medium text-gray-900">Total Tutees</h3>
                                <p class="text-2xl font-bold text-yellow-600">{{ \App\Models\User::where('role', 'tutee')->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>