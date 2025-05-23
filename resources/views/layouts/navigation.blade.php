<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome untuk ikon bell -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-XxX..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Alpine.js untuk dropdown -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <!-- Header/Navbar -->
    <header id="navbar" class="fixed top-0 left-0 right-0 z-30 bg-white border-b border-gray-200 shadow-sm h-14 flex items-center px-4 lg:pl-64 transition-all duration-300">
        <div class="flex justify-between items-center w-full">

            <!-- Right Items -->
            <div class="flex items-center space-x-4 ml-auto">

                <!-- Notifikasi dengan Dropdown -->
                <div x-data="{ open: false }" class="relative">
                    <!-- Tombol Notifikasi -->
                    <button 
                        @click="open = !open" 
                        @click.away="open = false" 
                        class="relative text-gray-600 hover:text-gray-800 focus:outline-none"
                        aria-label="Notifikasi"
                    >
                        <i class="fas fa-bell fa-lg"></i>
                        <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full">3+</span>
                    </button>

                    <!-- Dropdown Notifikasi -->
                    <div 
                        x-show="open"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-1"
                        class="absolute right-0 mt-2 w-72 bg-white border border-gray-200 rounded-md shadow-lg z-50"
                        style="display: none;"
                    >
                        <div class="p-4 text-sm text-gray-700 font-semibold border-b border-gray-100">
                            Notifikasi
                        </div>
                        <ul class="max-h-60 overflow-y-auto divide-y divide-gray-100">
                            <li class="px-4 py-3 hover:bg-gray-50 cursor-pointer flex items-start space-x-2">
                                <span class="text-blue-500 text-lg">📢</span>
                                <div>
                                    <p class="text-sm">Update sistem terbaru tersedia.</p>
                                    <p class="text-xs text-gray-400">1 jam lalu</p>
                                </div>
                            </li>
                            <li class="px-4 py-3 hover:bg-gray-50 cursor-pointer flex items-start space-x-2">
                                <span class="text-green-500 text-lg">✅</span>
                                <div>
                                    <p class="text-sm">Tugas Anda telah diselesaikan.</p>
                                    <p class="text-xs text-gray-400">2 jam lalu</p>
                                </div>
                            </li>
                            <li class="px-4 py-3 hover:bg-gray-50 cursor-pointer flex items-start space-x-2">
                                <span class="text-purple-500 text-lg">💬</span>
                                <div>
                                    <p class="text-sm">Anda menerima pesan baru.</p>
                                    <p class="text-xs text-gray-400">3 jam lalu</p>
                                </div>
                            </li>
                        </ul>
                        <div class="text-center p-2 border-t border-gray-100">
                            <a href="#" class="text-blue-600 text-sm hover:underline">Lihat semua notifikasi</a>
                        </div>
                    </div>
                </div>

                <!-- Pemisah -->
                <div class="h-6 w-px bg-gray-300"></div>

                <!-- Profil -->
                <a href="{{ route('profile.edit') }}" class="flex items-center space-x-2 focus:outline-none">
                    <span class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</span>
                    <div class="w-8 h-8 rounded-full bg-[#3b82f6] text-white flex items-center justify-center font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                </a>

            </div>
        </div>
    </header>

    <!-- Spacer agar konten tidak tertutup navbar -->
    <div class="h-14"></div>
    
</body>
</html>
