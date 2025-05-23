<!-- Main Content -->
<div class="flex-1 flex flex-col">

    <!-- Page Content -->
    <main class="flex-1 p-6">
        @isset($header)
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $header }}</h1>
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
        &copy; {{ date('Y') }} Tracer Alumni. Dibuat dengan ❤️ oleh Tim Dewa Frontend.
    </footer>
</div>
