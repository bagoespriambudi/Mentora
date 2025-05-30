<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Welcome, {{ Auth::user()->name }}!</h3>
                    
                    <!-- Tutee Dashboard Content -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Find Tutors Card -->
                        <div class="bg-blue-50 p-6 rounded-lg shadow-sm">
                            <h4 class="text-lg font-semibold text-blue-800 mb-2">Find Tutors</h4>
                            <p class="text-blue-600 mb-4">Browse and connect with expert tutors</p>
                            <a href="#" class="text-blue-600 hover:text-blue-800">Browse Tutors →</a>
                        </div>

                        <!-- My Sessions Card -->
                        <div class="bg-green-50 p-6 rounded-lg shadow-sm">
                            <h4 class="text-lg font-semibold text-green-800 mb-2">My Sessions</h4>
                            <p class="text-green-600 mb-4">View and manage your tutoring sessions</p>
                            <a href="#" class="text-green-600 hover:text-green-800">View Sessions →</a>
                        </div>

                        <!-- Learning Progress Card -->
                        <div class="bg-purple-50 p-6 rounded-lg shadow-sm">
                            <h4 class="text-lg font-semibold text-purple-800 mb-2">Learning Progress</h4>
                            <p class="text-purple-600 mb-4">Track your learning journey</p>
                            <a href="#" class="text-purple-600 hover:text-purple-800">View Progress →</a>
                        </div>

                        <!-- Profile Settings Card -->
                        <div class="bg-yellow-50 p-6 rounded-lg shadow-sm">
                            <h4 class="text-lg font-semibold text-yellow-800 mb-2">Profile Settings</h4>
                            <p class="text-yellow-600 mb-4">Manage your student profile</p>
                            <a href="#" class="text-yellow-600 hover:text-yellow-800">Edit Profile →</a>
                        </div>

                        <!-- Learning Resources Card -->
                        <div class="bg-red-50 p-6 rounded-lg shadow-sm">
                            <h4 class="text-lg font-semibold text-red-800 mb-2">Learning Resources</h4>
                            <p class="text-red-600 mb-4">Access study materials and resources</p>
                            <a href="#" class="text-red-600 hover:text-red-800">View Resources →</a>
                        </div>

                        <!-- Payment History Card -->
                        <div class="bg-indigo-50 p-6 rounded-lg shadow-sm">
                            <h4 class="text-lg font-semibold text-indigo-800 mb-2">Payment History</h4>
                            <p class="text-indigo-600 mb-4">View your tutoring payment history</p>
                            <a href="#" class="text-indigo-600 hover:text-indigo-800">View History →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 