<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ sidebarOpen: false, sidebarCollapsed: false }"
      class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Tracer Alumni') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
      rel="stylesheet"
    />
    <link
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
  rel="stylesheet"
/>

    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
    <div class="min-h-screen flex relative">

        {{-- <!-- Sidebar Desktop -->
        <aside
            :class="sidebarCollapsed ? 'w-20' : 'w-64'"
            class="fixed inset-y-0 left-0 z-40 hidden lg:flex flex-col transition-all duration-300 bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-700">
            @include('components.admin-sidebar')
        </aside> --}}
        <!-- Sidebar Desktop -->
        <aside
        :class="sidebarCollapsed ? 'w-20' : 'w-64'"
        class="fixed inset-y-0 left-0 z-40 hidden lg:flex flex-col transition-all duration-300 bg-white border-r border-blue-200 shadow-lg dark:bg-gray-900 dark:border-gray-700">
        
        <!-- Header Sidebar -->
        <div class="flex items-center justify-between h-16 px-4 bg-blue-600 text-white font-semibold transition-all duration-300">
            <span x-show="!sidebarCollapsed" class="text-base truncate">TRACER ALUMNI ITATS</span>
            {{-- <span x-show="sidebarCollapsed" class="text-lg font-bold">T</span> --}}

            <button @click="sidebarCollapsed = !sidebarCollapsed"
                class="ml-auto text-white hover:text-blue-200 transition p-1 rounded-md focus:outline-none">
                <i class="fas" :class="sidebarCollapsed ? 'fa-angle-double-right' : 'fa-angle-double-left'"></i>
            </button>
        </div>

        <hr class="border-t border-blue-300">

        <!-- Isi Sidebar -->
        <div class="flex-1 overflow-y-auto text-blue-700 bg-white dark:text-white dark:bg-blue-900">
            @include('components.admin-sidebar')
        </div>

        <hr class="border-t border-blue-300">

        <!-- Footer Sidebar -->
        <div class="p-4 text-sm text-center text-blue-700 bg-white dark:text-white dark:bg-blue-900">
            <span x-show="!sidebarCollapsed">&copy; 2025 AdminPanel</span>
        </div>
    </aside>


        <!-- Sidebar Mobile -->
        <div x-show="sidebarOpen" x-cloak class="fixed inset-0 z-50 flex lg:hidden">
            <!-- Backdrop -->
            <div @click="sidebarOpen = false" class="fixed inset-0 bg-black bg-opacity-50"></div>

            <!-- Sidebar Panel -->
            <aside class="relative flex flex-col w-64 h-full bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-700">
                @include('components.admin-sidebar')
            </aside>
        </div>

        <!-- Main Content -->
        <div :class="sidebarCollapsed ? 'lg:pl-20' : 'lg:pl-64'" class="min-h-screen  flex-1 flex flex-col transition-all duration-300">
            <main class="flex-1 ">
                 {{-- Header Area --}}
                @isset($header)
                    <div class="w-full bg-blue-800 py-4 px-6 shadow">
                        <h1 class="text-2xl font-bold text-white">
                            {{ $header }}
                        </h1>
                    </div>
                @endisset


                @if (session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 text-sm text-center py-4 text-gray-500 dark:text-gray-400">
                &copy; {{ date('Y') }} Tracer Alumni. Dibuat dengan Tangan oleh Tim SatSet
            </footer>
        </div>
    </div>
</body>

</html>
