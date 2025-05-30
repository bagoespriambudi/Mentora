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
                    <h3 class="text-lg font-semibold mb-4">Welcome, {{ Auth::user()->name }}!</h3>
                    
                    <!-- Admin Dashboard Content -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- User Management Card -->
                        <div class="bg-blue-50 p-6 rounded-lg shadow-sm">
                            <h4 class="text-lg font-semibold text-blue-800 mb-2">User Management</h4>
                            <p class="text-blue-600 mb-4">Manage tutors, tutees, and their accounts</p>
                            <a href="#" class="text-blue-600 hover:text-blue-800">View Users →</a>
                        </div>

                        <!-- Content Moderation Card -->
                        <div class="bg-green-50 p-6 rounded-lg shadow-sm">
                            <h4 class="text-lg font-semibold text-green-800 mb-2">Content Moderation</h4>
                            <p class="text-green-600 mb-4">Review and moderate platform content</p>
                            <a href="#" class="text-green-600 hover:text-green-800">Moderate Content →</a>
                        </div>

                        <!-- Analytics Card -->
                        <div class="bg-purple-50 p-6 rounded-lg shadow-sm">
                            <h4 class="text-lg font-semibold text-purple-800 mb-2">Platform Analytics</h4>
                            <p class="text-purple-600 mb-4">View platform statistics and reports</p>
                            <a href="#" class="text-purple-600 hover:text-purple-800">View Analytics →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 