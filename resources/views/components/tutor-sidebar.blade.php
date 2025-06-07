<aside class="w-64 h-screen bg-gradient-to-b from-purple-900 to-purple-800 border-r border-purple-700/50 flex flex-col fixed top-0 left-0 z-30 shadow-2xl">
    <!-- Logo Section -->
    <div class="flex items-center justify-center h-20 border-b border-purple-700/50 bg-purple-800/50">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                <span class="text-white text-xl font-bold">M</span>
            </div>
            <span class="text-2xl font-bold bg-gradient-to-r from-purple-400 to-purple-300 bg-clip-text text-transparent">Mentora</span>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
        <!-- Dashboard -->
        <a href="{{ route('tutor.dashboard') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('tutor.dashboard') ? 'bg-gradient-to-r from-purple-600 to-purple-500 text-white shadow-lg shadow-purple-500/25' : 'text-purple-300 hover:bg-purple-700/50 hover:text-white' }}">
            <div class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg {{ request()->routeIs('tutor.dashboard') ? 'bg-white/20' : 'bg-purple-700/50 group-hover:bg-purple-600/50' }}">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                </svg>
            </div>
            <span class="font-medium">Dashboard</span>
        </a>

        <!-- Payments Section -->
        <div class="pt-6">
            <div class="flex items-center px-4 mb-3">
                <span class="text-xs font-semibold text-purple-400 uppercase tracking-wider">Payments</span>
            </div>
            <a href="{{ route('payments.index') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('payments.index') ? 'bg-gradient-to-r from-orange-600 to-orange-500 text-white shadow-lg shadow-orange-500/25' : 'text-purple-300 hover:bg-purple-700/50 hover:text-white' }}">
                <div class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg {{ request()->routeIs('payments.index') ? 'bg-white/20' : 'bg-purple-700/50 group-hover:bg-purple-600/50' }}">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a2 2 0 00-2 2v6a2 2 0 002 2h8a2 2 0 002-2V6a2 2 0 00-2-2V3a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V5z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <span class="font-medium">Payment History</span>
            </a>
        </div>

        <!-- Reviews Section -->
        <div class="pt-6">
            <div class="flex items-center px-4 mb-3">
                <span class="text-xs font-semibold text-purple-400 uppercase tracking-wider">Reviews</span>
            </div>
            <a href="{{ route('tutor.reviews.index') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('tutor.reviews.index') ? 'bg-gradient-to-r from-yellow-600 to-yellow-500 text-white shadow-lg shadow-yellow-500/25' : 'text-purple-300 hover:bg-purple-700/50 hover:text-white' }}">
                <div class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg {{ request()->routeIs('tutor.reviews.index') ? 'bg-white/20' : 'bg-purple-700/50 group-hover:bg-yellow-600/50' }}">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 15l-3.5 2.1.7-4.1-3-2.9 4.2-.6L10 6l1.6 3.5 4.2.6-3 2.9.7 4.1z"/>
                    </svg>
                </div>
                <span class="font-medium">My Ratings</span>
            </a>
        </div>

        <!-- Content Section -->
        <div class="pt-6">
            <div class="flex items-center px-4 mb-3">
                <span class="text-xs font-semibold text-purple-400 uppercase tracking-wider">Content</span>
            </div>
            <a href="{{ route('contents.index') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('contents.index') ? 'bg-gradient-to-r from-yellow-600 to-yellow-500 text-white shadow-lg shadow-yellow-500/25' : 'text-purple-300 hover:bg-purple-700/50 hover:text-white' }}">
                <div class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg {{ request()->routeIs('contents.index') ? 'bg-white/20' : 'bg-purple-700/50 group-hover:bg-yellow-600/50' }}">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4h12v12H4z"/>
                    </svg>
                </div>
                <span class="font-medium">Contents</span>
            </a>
        </div>

        <!-- Account Section -->
        <div class="pt-6">
            <div class="flex items-center px-4 mb-3">
                <span class="text-xs font-semibold text-purple-400 uppercase tracking-wider">Account</span>
            </div>
            <a href="{{ route('profile.edit') }}" class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('profile.edit') ? 'bg-gradient-to-r from-indigo-600 to-indigo-500 text-white shadow-lg shadow-indigo-500/25' : 'text-purple-300 hover:bg-purple-700/50 hover:text-white' }}">
                <div class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg {{ request()->routeIs('profile.edit') ? 'bg-white/20' : 'bg-purple-700/50 group-hover:bg-purple-600/50' }}">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <span class="font-medium">Profile</span>
            </a>
        </div>
    </nav>

    <!-- User Section & Logout -->
    <div class="p-4 border-t border-purple-700/50 bg-purple-800/30">
        <div class="flex items-center mb-3 p-3 rounded-xl bg-purple-700/30">
            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-orange-600 rounded-full flex items-center justify-center mr-3">
                <span class="text-white text-sm font-semibold">{{ substr(Auth::user()->name ?? 'U', 0, 1) }}</span>
            </div>
            <div>
                <p class="text-sm font-medium text-white">{{ Auth::user()->name ?? 'User' }}</p>
                <p class="text-xs text-purple-400">Tutor</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="group w-full flex items-center px-4 py-3 rounded-xl transition-all duration-200 text-purple-300 hover:bg-red-600/20 hover:text-red-400 border border-purple-600/50 hover:border-red-500/50">
                <div class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg bg-purple-700/50 group-hover:bg-red-600/20">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <span class="font-medium">Logout</span>
            </button>
        </form>
    </div>
</aside> 