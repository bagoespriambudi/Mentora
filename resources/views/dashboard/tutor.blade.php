<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tutor Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Welcome, {{ Auth::user()->name }}!</h3>
                    
                    <!-- Tutor Dashboard Content -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Teaching Schedule Card -->
                        <div class="bg-blue-50 p-6 rounded-lg shadow-sm">
                            <h4 class="text-lg font-semibold text-blue-800 mb-2">Teaching Schedule</h4>
                            <p class="text-blue-600 mb-4">View and manage your tutoring sessions</p>
                            <a href="#" class="text-blue-600 hover:text-blue-800">View Schedule →</a>
                        </div>

                        <!-- Student Requests Card -->
                        <div class="bg-green-50 p-6 rounded-lg shadow-sm">
                            <h4 class="text-lg font-semibold text-green-800 mb-2">Student Requests</h4>
                            <p class="text-green-600 mb-4">View and respond to tutoring requests</p>
                            <a href="#" class="text-green-600 hover:text-green-800">View Requests →</a>
                        </div>

                        <!-- Earnings Card -->
                        <div class="bg-purple-50 p-6 rounded-lg shadow-sm">
                            <h4 class="text-lg font-semibold text-purple-800 mb-2">Earnings</h4>
                            <p class="text-purple-600 mb-4">Track your tutoring income</p>
                            <a href="#" class="text-purple-600 hover:text-purple-800">View Earnings →</a>
                        </div>

                        <!-- Profile Settings Card -->
                        <div class="bg-yellow-50 p-6 rounded-lg shadow-sm">
                            <h4 class="text-lg font-semibold text-yellow-800 mb-2">Profile Settings</h4>
                            <p class="text-yellow-600 mb-4">Manage your tutoring profile and preferences</p>
                            <a href="#" class="text-yellow-600 hover:text-yellow-800">Edit Profile →</a>
                        </div>

                        <!-- Teaching Materials Card -->
                        <div class="bg-red-50 p-6 rounded-lg shadow-sm">
                            <h4 class="text-lg font-semibold text-red-800 mb-2">Teaching Materials</h4>
                            <p class="text-red-600 mb-4">Upload and manage your teaching resources</p>
                            <a href="#" class="text-red-600 hover:text-red-800">Manage Materials →</a>
                        </div>

                        <!-- Reviews Card -->
                        <div class="bg-indigo-50 p-6 rounded-lg shadow-sm">
                            <h4 class="text-lg font-semibold text-indigo-800 mb-2">Student Reviews</h4>
                            <p class="text-indigo-600 mb-4">View feedback from your students</p>
                            <a href="#" class="text-indigo-600 hover:text-indigo-800">View Reviews →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 