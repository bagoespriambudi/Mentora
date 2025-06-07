<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 flex">
            @auth
                @if(auth()->user()->role === 'tutee')
                    <x-sidebar />
                @elseif(auth()->user()->role === 'tutor')
                    <x-tutor-sidebar />
                @elseif(auth()->user()->role === 'admin')
                    <x-admin-sidebar />
                @endif
            @endauth
            <div class="flex-1 ml-0 @auth @if(in_array(auth()->user()->role, ['tutee', 'tutor', 'admin'])) ml-64 @endif @endauth">
                @include('layouts.navigation')

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

              <!-- Page Content -->
<main>
    {{-- Flash Messages --}}
    <div class="max-w-4xl mx-auto mt-6 px-4">
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                {{ session('error') }}
            </div>
        @endif
    </div>

    @yield('content')
</main>
            </div>
        </div>
        @stack('scripts')
    </body>
</html>
