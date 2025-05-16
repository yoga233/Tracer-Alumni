<div class="flex flex-col justify-between h-full w-full p-4">
   

    <!-- Sidebar Menu -->
    <nav class="flex-1 space-y-2 px-2 text-sm">

        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 p-3 rounded-xl text-gray-700 dark:text-gray-200 bg-white dark:bg-blue-900/30 hover:bg-blue-50 dark:hover:bg-blue-800/70 hover:shadow-lg transition-all duration-300">
            <i class="fas fa-tachometer-alt text-base"></i>
            <span x-show="!sidebarCollapsed" x-transition>Dashboard</span>
        </a>

        <!-- Pertanyaan -->
        <a href="{{ route('admin.questions.index') }}"
           class="flex items-center gap-3 p-3 rounded-xl text-gray-700 dark:text-gray-200 bg-white dark:bg-blue-900/30 hover:bg-blue-50 dark:hover:bg-blue-800/70 hover:shadow-lg transition-all duration-300">
            <i class="fas fa-question-circle text-base"></i>
            <span x-show="!sidebarCollapsed" x-transition>Pertanyaan</span>
        </a>

        <!-- Jawaban Alumni -->
        <a href="{{ route('admin.alumni-answers.index') }}"
           class="flex items-center gap-3 p-3 rounded-xl text-gray-700 dark:text-gray-200 bg-white dark:bg-blue-900/30 hover:bg-blue-50 dark:hover:bg-blue-800/70 hover:shadow-lg transition-all duration-300">
            <i class="fas fa-clipboard-list text-base"></i>
            <span x-show="!sidebarCollapsed" x-transition>Jawaban Alumni</span>
        </a>

        <!-- Statistik & Laporan -->
        <a href="{{ route('admin.reports.showReport') }}"
           class="flex items-center gap-3 p-3 rounded-xl text-gray-700 dark:text-gray-200 bg-white dark:bg-blue-900/30 hover:bg-blue-50 dark:hover:bg-blue-800/70 hover:shadow-lg transition-all duration-300">
            <i class="fas fa-chart-bar text-base"></i>
            <span x-show="!sidebarCollapsed" x-transition>Statistik & Laporan</span>
        </a>

    </nav>

    <!-- Divider -->
    <div class="border-t border-gray-200 dark:border-white-300 my-4"></div>

    <!-- User Info & Profile Link -->
    <div class="space-y-4">
        <!-- Profile Link -->
        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 p-3 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 z-auto hover:shadow-lg dark:hover:bg-blue-800 transition-all">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}" class="w-10 h-10 rounded-full" alt="User" />
            <div class="flex-1" x-show="!sidebarCollapsed" x-transition>
                <div class="font-semibold">{{ Auth::user()->name }}</div>
                <div class="text-xs">{{ Auth::user()->email }}</div>
            </div>
        </a>

        <!-- Logout Button -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button 
                type="submit"
                class="w-full text-left p-4 rounded-md  text-red-700 dark:text-red-500 hover:text-white hover:bg-red-300 dark:hover:bg-red-500  transition-all flex items-center gap-2"
                :class="sidebarCollapsed ? 'justify-center' : 'justify-start'"
            >
                <i class="fas fa-sign-out-alt w-5 h-5"></i>
                <span x-show="!sidebarCollapsed" x-transition>Log Out</span>
            </button>
        </form>
    </div>

</div>
