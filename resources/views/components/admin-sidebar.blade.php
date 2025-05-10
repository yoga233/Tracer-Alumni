<div class="flex flex-col justify-between h-full w-full p-4">
    <!-- Sidebar Header -->
    <div class="flex items-center justify-between mb-6">
        <span class="text-xl font-bold text-gray-800 dark:text-white" x-show="!sidebarCollapsed" x-transition>Tracer</span>
        <button @click="sidebarCollapsed = !sidebarCollapsed"
                class="text-gray-500 dark:text-gray-400 hover:text-indigo-600 transition p-1 rounded-md">
            <i class="fas" :class="sidebarCollapsed ? 'fa-angle-double-right' : 'fa-angle-double-left'"></i>
        </button>
    </div>

    <!-- Sidebar Menu -->
    <nav class="flex-1 space-y-2 text-sm">
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 p-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
            <i class="fas fa-tachometer-alt w-5 h-5"></i>
            <span x-show="!sidebarCollapsed" x-transition>Dashboard</span>
        </a>

        <a href="{{ route('admin.questions.index') }}"
           class="flex items-center gap-3 p-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
            <i class="fas fa-question-circle w-5 h-5"></i>
            <span x-show="!sidebarCollapsed" x-transition>Pertanyaan</span>
        </a>

        <a href="{{ route('admin.alumni-answers.index') }}"
           class="flex items-center gap-3 p-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
            <i class="fas fa-clipboard-list w-5 h-5"></i>
            <span x-show="!sidebarCollapsed" x-transition>Jawaban Alumni</span>
        </a>

        <a href="{{ route('admin.reports.showReport') }}"
   class="flex items-center gap-3 p-2 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
    <i class="fas fa-chart-bar w-5 h-5"></i>
    <span x-show="!sidebarCollapsed" x-transition>Statistik & Laporan</span>
</a>

    </nav>

    <!-- Divider -->
    <div class="border-t border-gray-200 dark:border-gray-700 my-4"></div>

    <!-- User Info & Profile Link -->
    <div class="space-y-4">
        <!-- Profile Link -->
        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 p-3 rounded-md text-gray-700 dark:text-gray-300 hover:bg-indigo-600 dark:hover:bg-indigo-800 transition-all">
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
                class="w-full text-left p-4 rounded-md text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-600 transition-all flex items-center gap-3"
                :class="sidebarCollapsed ? 'justify-center' : 'justify-start'"
            >
                <i class="fas fa-sign-out-alt w-5 h-5"></i>
                <span x-show="!sidebarCollapsed" x-transition>Log Out</span>
            </button>
        </form>


    </div>
</div>
