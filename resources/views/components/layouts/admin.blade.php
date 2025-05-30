<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div x-data="{ sidebarOpen: true }">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-64 bg-[#0E7EB3] transform transition-transform duration-300 ease-in-out"
             :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">
            <!-- Logo -->
            <div class="flex items-center justify-center h-16 bg-[#0E7EB3] text-white">
            </div>
            <!-- Navigation -->
            <nav class="mt-5">
                <a href="{{ route('admin.dashboard') }}"
                   class="group flex items-center px-2 py-2 text-base leading-6 font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-white text-primary' : 'text-white' }} hover:bg-white hover:text-primary focus:outline-none transition ease-in-out duration-150">
                    <svg class="mr-4 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}"
                   class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-medium {{ request()->routeIs('admin.users.*') ? 'bg-white text-primary' : 'text-white' }} hover:bg-white hover:text-primary focus:outline-none transition ease-in-out duration-150">
                    <svg class="mr-4 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Users
                </a>
                <a href="{{ route('admin.categories.index') }}"
                   class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-medium {{ request()->routeIs('admin.categories.*') ? 'bg-white text-primary' : 'text-white' }} hover:bg-white hover:text-primary focus:outline-none transition ease-in-out duration-150">
                    <svg class="mr-4 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    Categories
                </a>
                <a href="{{ route('admin.contents.index') }}"
                   class="mt-1 group flex items-center px-2 py-2 text-base leading-6 font-medium {{ request()->routeIs('admin.content.*') ? 'bg-white text-primary' : 'text-white' }} hover:bg-white hover:text-primary focus:outline-none transition ease-in-out duration-150">
                    <svg class="mr-4 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                    Content
                </a>
            </nav>
        </div>
        <!-- Main Content -->
        <div class="flex-1" :class="{'ml-64': sidebarOpen, 'ml-0': !sidebarOpen}">
            <!-- Top Bar -->
            <div class="bg-white h-16 fixed w-full z-40 flex items-center justify-between px-4 shadow">
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <div class="flex items-center">
                    <span class="text-gray-800 text-sm mr-4">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-gray-800">Logout</button>
                    </form>
                </div>
            </div>
            <!-- Page Content -->
            <div class="pt-16 pb-8">
                <main class="px-4 py-8">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </div>
</body>
</html>