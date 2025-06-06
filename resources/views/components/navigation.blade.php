@php
$navigation = [];

if (!auth()->check() || in_array(auth()->user()->role ?? null, ['tutee', 'tutor'])) {
    $navigation['Browse Tutors'] = route('tutors.index');
    $navigation['Articles & Tips'] = route('articles.index');
}

if (auth()->check()) {
    switch (auth()->user()->role) {
        case 'admin':
            $navigation['Admin Dashboard'] = route('admin.dashboard');
            break;
        case 'tutor':
            $navigation['My Sessions'] = route('tutor.sessions');
            break;
        case 'tutee':
            $navigation['My Bookings'] = route('tutee.sessions');
            break;
        case 'client':
            $navigation['My Orders'] = route('orders.index');
            break;
    }
}
@endphp

<nav class="bg-white border-b border-gray-200">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-primary font-bold text-xl">
                        Mentora
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @foreach($navigation as $name => $url)
                        <a href="{{ $url }}" @class([
                            'inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none',
                            'text-blue-600' => request()->url() === $url,
                            'text-gray-500 hover:text-gray-700' => request()->url() !== $url,
                        ])>
                            {{ $name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-4">
                @guest
                    <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}" class="bg-primary text-white rounded-lg px-4 py-2 hover:bg-blue-700">
                        Get Started
                    </a>
                @else
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" class="flex items-center text-gray-500 hover:text-gray-700">
                            <span>{{ auth()->user()->name }}</span>
                            <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 z-50 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Profile
                            </a>

                            @if(auth()->user()->role === 'client')
                                <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    My Orders
                                </a>
                            @endif

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center sm:hidden">
                <button type="button"
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': mobileMenuOpen, 'inline-flex': !mobileMenuOpen }"
                              class="inline-flex"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !mobileMenuOpen, 'inline-flex': mobileMenuOpen }"
                              class="hidden"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="mobileMenuOpen" class="sm:hidden" style="display: none;">
        <div class="pt-2 pb-3 space-y-1">
            @foreach($navigation as $name => $url)
                <a href="{{ $url }}" @class([
                    'block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition duration-150 ease-in-out focus:outline-none',
                    'border-blue-400 text-blue-700 bg-blue-50' => request()->url() === $url,
                    'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' => request()->url() !== $url,
                ])>
                    {{ $name }}
                </a>
            @endforeach
        </div>

        <!-- Mobile menu auth links -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ auth()->user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <a href="{{ route('profile.edit') }}"
                       class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300">
                        Profile
                    </a>

                    @if(auth()->user()->role === 'client')
                        <a href="{{ route('orders.index') }}"
                           class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300">
                            My Orders
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="block w-full text-left pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300">
                            Sign Out
                        </button>
                    </form>
                </div>
            @else
                <div class="mt-3 space-y-1">
                    <a href="{{ route('login') }}"
                       class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}"
                       class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300">
                        Get Started
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>
