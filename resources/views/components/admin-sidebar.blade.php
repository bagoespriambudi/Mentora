<aside class="w-64 h-screen bg-gradient-to-b from-red-900 to-blue-900 border-r border-red-700/50 flex flex-col fixed top-0 left-0 z-30 shadow-2xl">
    <!-- Logo Section -->
    <div class="flex items-center justify-center h-20 border-b border-red-700/50 bg-red-800/50">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                <span class="text-white text-xl font-bold">M</span>
            </div>
            <span class="text-2xl font-bold bg-gradient-to-r from-red-400 to-blue-300 bg-clip-text text-transparent">Mentora</span>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-red-600 to-blue-500 text-white shadow-lg shadow-red-500/25' : 'text-red-300 hover:bg-red-700/50 hover:text-white' }}">
            <div class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : 'bg-red-700/50 group-hover:bg-red-600/50' }}">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                </svg>
            </div>
            <span class="font-medium">Dashboard</span>
        </a>

        <!-- User Management -->
        <div class="pt-6">
            <div class="flex items-center px-4 mb-3">
                <span class="text-xs font-semibold text-red-400 uppercase tracking-wider">Management</span>
            </div>
            <a href="{{ route('admin.users.index') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-blue-600 to-blue-500 text-white shadow-lg shadow-blue-500/25' : 'text-blue-300 hover:bg-blue-700/50 hover:text-white' }}">
                <div class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-white/20' : 'bg-blue-700/50 group-hover:bg-blue-600/50' }}">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                    </svg>
                </div>
                <span class="font-medium">User Management</span>
            </a>

            <a href="{{ route('admin.currencies.index') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.currencies.*') ? 'bg-gradient-to-r from-blue-600 to-blue-500 text-white shadow-lg shadow-blue-500/25' : 'text-blue-300 hover:bg-blue-700/50 hover:text-white' }}">
                <div class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg {{ request()->routeIs('admin.currencies.*') ? 'bg-white/20' : 'bg-blue-700/50 group-hover:bg-blue-600/50' }}">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <span class="font-medium">Currency Management</span>
            </a>

            <!-- Session Management -->
            <a href="#" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 text-blue-300 hover:bg-blue-700/50 hover:text-white">
                <div class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg bg-blue-700/50 group-hover:bg-blue-600/50">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8 2a2 2 0 00-2 2v2H5a2 2 0 00-2 2v8a2 2 0 002 2h10a2 2 0 002-2V6a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H8zm0 2h4v2H8V4z"/>
                    </svg>
                </div>
                <span class="font-medium">Session Management</span>
            </a>

            <!-- Category Management -->
            <a href="{{ route('admin.categories.index') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.categories.*') ? 'bg-gradient-to-r from-blue-600 to-blue-500 text-white shadow-lg shadow-blue-500/25' : 'text-blue-300 hover:bg-blue-700/50 hover:text-white' }}">
                <div class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg {{ request()->routeIs('admin.categories.*') ? 'bg-white/20' : 'bg-blue-700/50 group-hover:bg-blue-600/50' }}">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 4a2 2 0 012-2h4l2 2h6a2 2 0 012 2v1H2V4zM2 7h16v9a2 2 0 01-2 2H4a2 2 0 01-2-2V7z"/>
                    </svg>
                </div>
                <span class="font-medium">Category Management</span>
            </a>
        </div>

        <!-- Financial Management -->
        <div class="pt-6">
            <div class="flex items-center px-4 mb-3">
                <span class="text-xs font-semibold text-blue-400 uppercase tracking-wider">Finance</span>
            </div>
            <a href="{{ route('admin.financial.index') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.financial.*') ? 'bg-gradient-to-r from-blue-600 to-blue-500 text-white shadow-lg shadow-blue-500/25' : 'text-blue-300 hover:bg-blue-700/50 hover:text-white' }}">
                <div class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg {{ request()->routeIs('admin.financial.*') ? 'bg-white/20' : 'bg-blue-700/50 group-hover:bg-blue-600/50' }}">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zm-2 5v6a2 2 0 002 2h12a2 2 0 002-2V9H2zm6 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <span class="font-medium">Financial Management</span>
            </a>
        </div>

        <!-- Content Management -->
        <div class="pt-6">
            <div class="flex items-center px-4 mb-3">
                <span class="text-xs font-semibold text-purple-400 uppercase tracking-wider">Content</span>
            </div>
            <a href="{{ route('admin.contents.index') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.contents.*') ? 'bg-gradient-to-r from-purple-600 to-purple-500 text-white shadow-lg shadow-purple-500/25' : 'text-purple-300 hover:bg-purple-700/50 hover:text-white' }}">
                <div class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg {{ request()->routeIs('admin.contents.*') ? 'bg-white/20' : 'bg-purple-700/50 group-hover:bg-purple-600/50' }}">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/>
                    </svg>
                </div>
                <span class="font-medium">Content Management</span>
            </a>
            <a href="{{ route('admin.contents.reported') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.contents.reported') ? 'bg-gradient-to-r from-red-600 to-red-500 text-white shadow-lg shadow-red-500/25' : 'text-red-300 hover:bg-red-700/50 hover:text-white' }}">
                <div class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg {{ request()->routeIs('admin.contents.reported') ? 'bg-white/20' : 'bg-red-700/50 group-hover:bg-red-600/50' }}">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M18.364 5.636a9 9 0 11-12.728 0 9 9 0 0112.728 0zM9 9v2h2V9H9zm0 4h2v2H9v-2z"/>
                    </svg>
                </div>
                <span class="font-medium">Reported Contents</span>
            </a>
        </div>
    </nav>

    <!-- User Section & Logout -->
    <div class="p-4 border-t border-red-700/50 bg-red-800/30">
        <div class="flex items-center mb-3 p-3 rounded-xl bg-red-700/30">
            <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-blue-600 rounded-full flex items-center justify-center mr-3">
                <span class="text-white text-sm font-semibold">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</span>
            </div>
            <div>
                <p class="text-sm font-medium text-white">{{ Auth::user()->name ?? 'Admin' }}</p>
                <p class="text-xs text-red-400">Admin</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="group w-full flex items-center px-4 py-3 rounded-xl transition-all duration-200 text-red-300 hover:bg-red-600/20 hover:text-red-400 border border-red-600/50 hover:border-red-500/50">
                <div class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg bg-red-700/50 group-hover:bg-red-600/20">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <span class="font-medium">Logout</span>
            </button>
        </form>
    </div>
</aside> 