<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Tracer Alumni') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900" x-data="{ sidebarOpen: false }">
        <div class="min-h-screen flex">

            <!-- Sidebar -->
            <div
                x-show="sidebarOpen"
                @click.away="sidebarOpen = false"
                x-transition:enter="transition transform duration-300"
                x-transition:enter-start="-translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transition transform duration-300"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full"
                class="fixed z-40 inset-y-0 left-0 w-64 bg-white dark:bg-gray-900 shadow-md lg:static lg:translate-x-0 lg:block"
            >
                @include('components.admin-sidebar')
            </div>

            <!-- Overlay Mobile -->
            <div x-show="sidebarOpen" class="fixed inset-0 bg-black opacity-50 z-30 lg:hidden" @click="sidebarOpen = false"></div>

            <div :class="sidebarOpen ? 'lg:ml-64 ml-0' : 'ml-0'" class="flex-1 flex flex-col transition-all duration-300 ease-in-out relative">

                <!-- Navigation -->
                @include('layouts.navigation')

                <!-- Page Header -->
                @isset($header)
                    <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $header }}
                            </h1>
                        </div>
                    </header>
                @endisset

                <!-- Flash Message -->
                @if (session('success'))
                    <div class="max-w-7xl mx-auto mt-4 px-4">
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                <!-- Main Slot -->
                <main class="flex-1 py-8">
                    <div class="w-full px-4 sm:px-6 lg:px-8">

                        {{ $slot }}
                    </div>
                </main>

                <!-- Footer -->
                <footer class="bg-white border-t border-gray-200 dark:bg-gray-800 dark:border-gray-700 shadow-inner">
                    <div class="w-full py-4 px-4 flex justify-center items-center text-sm text-gray-500 dark:text-gray-400">
                        &copy; {{ date('Y') }} Tracer Alumni. Dibuat dengan ❤️ oleh Tim Dewa Frontend.
                    </div>
                </footer>
            </div>
        </div>
    </body>

</html>
