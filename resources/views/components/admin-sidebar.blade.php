<<<<<<< HEAD
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
=======
<div
    class="relative flex flex-col justify-between h-full w-full p-4 bg-gradient-to-b from-blue-600 via-blue-700 to-blue-900 text-white shadow-xl">
    <!-- Toggle Button -->
    <div class="absolute top-1/2 -right-4 transform -translate-y-1/2 z-20">
        <button @click="sidebarCollapsed = !sidebarCollapsed"
            class="bg-blue-900 hover:bg-blue-900 text-white w-8 h-8 rounded-full shadow-lg flex items-center justify-center transition-all border-4 border-white">
            <i class="fas" :class="sidebarCollapsed ? 'fa-chevron-right' : 'fa-chevron-left'"></i>
        </button>
    </div>

    <!-- Header -->
    <div class="flex justify-center mb-6">
        <template x-if="sidebarCollapsed">
            <div
                class="flex items-center justify-center w-10 h-10 bg-white text-blue-900 font-bold text-sm rounded-full shadow-md">
                TI
            </div>
        </template>
        <template x-if="!sidebarCollapsed">
            <span class="text-xl font-bold tracking-wide text-center transition-all">Tracer Informatika</span>
        </template>
    </div>


    <!-- Divider -->
    <div class="h-px bg-white/30 mb-4"></div>

    <!-- Menu -->
    <nav class="flex-1 space-y-2 text-sm font-medium">

        <!-- GRUP: UTAMA -->
        <div class="text-xs text-white/70 uppercase tracking-wide mb-1 px-3" x-show="!sidebarCollapsed">Utama</div>

        <a href="{{ route('dashboard') }}"
            class="relative group flex p-3 rounded-md hover:bg-blue-400/20 transition-all items-center"
            :class="sidebarCollapsed ? 'justify-center pr-0 pl-2' : 'gap-3 justify-start'">
            <i class="fas fa-tachometer-alt w-5 h-3 text-white"></i>
            <span x-show="!sidebarCollapsed" x-transition>Dashboard</span>
        </a>

        <!-- GRUP: KUESIONER -->
        <div class="h-px bg-white/30 mb-4"></div><br>
        <div class="text-xs text-white/70 uppercase tracking-wide mt-4 mb-1 px-3" x-show="!sidebarCollapsed">Kuesioner
        </div>

        <a href="{{ route('admin.questions.index') }}"
            class="relative group flex p-3 rounded-md hover:bg-blue-400/20 transition-all items-center"
            :class="sidebarCollapsed ? 'justify-center pr-0 pl-2' : 'gap-3 justify-start'">
            <i class="fas fa-question-circle w-5 h-3 text-white"></i>
>>>>>>> new-layout
            <span x-show="!sidebarCollapsed" x-transition>Pertanyaan</span>
        </a>

        <!-- Jawaban Alumni -->
        <a href="{{ route('admin.alumni-answers.index') }}"
<<<<<<< HEAD
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
=======
            class="relative group flex p-3 rounded-md hover:bg-blue-400/20 transition-all items-center"
            :class="sidebarCollapsed ? 'justify-center pr-0 pl-2' : 'gap-3 justify-start'">
            <i class="fas fa-clipboard-list w-5 h-3 text-white"></i>
            <span x-show="!sidebarCollapsed" x-transition>Jawaban Alumni</span>
        </a>

        <a href="{{ route('alumni.form') }}"
            class="relative group flex p-3 rounded-md hover:bg-blue-400/20 transition-all items-center"
            :class="sidebarCollapsed ? 'justify-center pr-0 pl-2' : 'gap-3 justify-start'">
            <i class="fas fa-pen-square w-5 h-3 text-white"></i>
            <span x-show="!sidebarCollapsed" x-transition>Form Pengisian</span>
        </a>

        <!-- GRUP: ANALISIS -->
        <div class="h-px bg-white/30 mb-4"></div><br>
        <div class="text-xs text-white/70 uppercase tracking-wide mt-4 mb-1 px-3" x-show="!sidebarCollapsed">Analisis
        </div>

        <a href="{{ route('admin.reports.showReport') }}"
            class="relative group flex p-3 rounded-md hover:bg-blue-400/20 transition-all items-center"
            :class="sidebarCollapsed ? 'justify-center pr-0 pl-2' : 'gap-3 justify-start'">
            <i class="fas fa-chart-bar w-5 h-3 text-white"></i>
            <span x-show="!sidebarCollapsed" x-transition>Statistik & Laporan</span>
        </a>

        <!-- GRUP: PENGATURAN -->
        <div class="h-px bg-white/30 mb-4"></div><br>
        <div class="text-xs text-white/70 uppercase tracking-wide mt-4 mb-1 px-3" x-show="!sidebarCollapsed">Pengaturan
        </div>

        <a href="{{ route('profile.edit') }}"
            class="relative group flex p-3 rounded-md hover:bg-blue-400/20 transition-all items-center"
            :class="sidebarCollapsed ? 'justify-center pr-0 pl-2' : 'gap-3 justify-start'">
            <i class="fas fa-user-circle w-5 h-3 text-white"></i>
            <span x-show="!sidebarCollapsed" x-transition>Profil</span>
>>>>>>> new-layout
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
<<<<<<< HEAD
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
=======
            <button type="submit"
                class="relative group flex w-full p-3 rounded-md text-red-500 hover:bg-red-500/10 hover:text-red-600 transition-all items-center"
                :class="sidebarCollapsed ? 'justify-center pr-0 pl-2' : 'gap-3 justify-start'">
                <i class="fas fa-sign-out-alt w-5 h-3 group-hover:text-red-600 transition"></i>
                <span x-show="!sidebarCollapsed" x-transition>Logout</span>
            </button>
        </form>

        <div class="h-px bg-white/30 mb-4"></div>
    </nav>
</div>
>>>>>>> new-layout
