<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">
            Jawaban Alumni (Tampilan Tabel)
        </h2>
    </x-slot>

    <div class="flex">
        <!-- Sidebar Filter -->
        <div id="filterSidebar" class="fixed inset-y-0 right-0 w-80 bg-gray-900 text-gray-100 shadow-lg transform translate-x-full transition-transform duration-300 z-50 overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Filter</h3>
                    <button onclick="toggleFilter()" class="text-gray-300 hover:text-gray-400">
                        ✖
                    </button>
                </div>

                <form method="GET" action="{{ route('admin.alumni-answers.index') }}" class="mb-6 space-y-4">

                    {{-- pencarian keyword pertanyaan --}}
                    <div>
                        <label class="block text-sm font-medium text-white">Keyword Pertanyaan</label>
                        <input type="text" name="keyword" value="{{ request('keyword') }}"
                            class="w-full p-2 border border-gray-700 rounded-md bg-gray-800 text-white placeholder-gray-400"
                            placeholder="Cari pertanyaan...">
                    </div>
                
                    {{-- pengisian --}}
                    <div class="flex space-x-2">
                        <div class="w-1/2">
                            <label class="block text-sm font-medium text-white">Waktu Pengisian</label>
                            <input type="date" name="start_date" value="{{ request('start_date') }}"
                                class="w-full p-2 border border-gray-700 rounded-md bg-gray-800 text-white">
                        </div>
                    </div>

                    {{-- tahun lulus --}}
                    <div class="flex space-x-2">
                        <div class="w-1/2">
                            <label class="block text-sm font-medium text-white">Tahun Lulus</label>
                            <select name="graduation_year" class="w-full p-2 border border-gray-700 rounded-md bg-gray-800 text-white">
                                {{-- <option value="all">Semua</option>
                                @foreach (collect($alumniRows)->pluck('alumni.graduation_year')->unique()->filter()->values() as $year)
                                    <option value="{{ $year }}" {{ request('graduation_year') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach --}}
                                <option value="all">Semua</option>
                                @foreach ($graduationYears as $year)
                                    <option value="{{ $year }}" {{ request('graduation_year') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                
                    {{-- filter status --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-white" for="status">Status Pekerjaan</label>
                        <select class="w-full p-2 border border-gray-700 rounded-md bg-gray-800 text-white" name="status" id="status">
                            <option value="all">Semua</option>
                            @foreach ($employmentStatuses as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                
                    <div>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-all duration-150">
                            Filter
                        </button>
                    </div>
                </form>

                <hr class="my-4 border-gray-700">                

                {{-- //gambarlogo --}}

                <div class="mt-4">
                    <img src="{{ asset('../assets/logo.png') }}" alt="Logo" class="w-48 h-40 mx-auto border border-gray-700">
                </div>

            </div>
        </div>

        <!-- Main Content -->
        <div class="py-10 flex-1">
            <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between mb-4">
                    <!-- Modern Search Bar (on the left) -->
                    <div class="relative w-full max-w-sm flex-1">
                        <input
                            type="text"
                            id="tableSearchInput"
                            class="w-full p-3 pl-10 pr-4 border border-gray-700 rounded-md bg-gray-800 text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all"
                            placeholder="Cari jawaban atau ID..."
                            onkeyup="searchTable()"
                        >
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5a7 7 0 11-7 7 7 7 0 017-7zM21 21l-4.35-4.35" />
                        </svg>
                    </div>

                    <!-- Filter Button (on the right) -->
                    <button onclick="toggleFilter()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L15 14.414V19a1 1 0 01-1.447.894l-4-2A1 1 0 019 17v-2.586L3.293 6.707A1 1 0 013 6V4z" />
                        </svg>
                        <span>Filter</span>
                    </button>
                </div>

                {{-- Table --}}
                <div class="overflow-auto bg-white dark:bg-gray-900 shadow-xl rounded-xl border border-gray-200 dark:border-gray-700">
                    
                    <table class="min-w-full table-auto text-sm text-left text-gray-700 dark:text-gray-200" id="dataTable">
                        <thead class="bg-gray-100 dark:bg-gray-800 border-b dark:border-gray-600">
                            <tr>
                                <th class="px-4 py-3 font-semibold whitespace-nowrap border border-gray-300 dark:border-gray-600">ID</th>
                                <th class="px-4 py-3 font-semibold whitespace-nowrap border border-gray-300 dark:border-gray-600">Nama</th>
                                <th class="px-4 py-3 font-semibold whitespace-nowrap border border-gray-300 dark:border-gray-600">Email</th>
                                <th class="px-4 py-3 font-semibold whitespace-nowrap border border-gray-300 dark:border-gray-600">Jurusan</th>
                                <th class="px-4 py-3 font-semibold whitespace-nowrap border border-gray-300 dark:border-gray-600">Tahun Lulus</th>
                                @foreach ($questions->take(5) as $question)
                                    <th class="px-4 py-3 font-semibold whitespace-nowrap border border-gray-300 dark:border-gray-600">
                                        {{ $question->question_text }}
                                    </th>
                                @endforeach
                                <th class="px-4 py-3 font-semibold whitespace-nowrap border border-gray-300 dark:border-gray-600">Waktu Isi</th>
                                <th class="px-4 py-3 font-semibold whitespace-nowrap border border-gray-300 dark:border-gray-600">Lainnya</th>
                                <th class="px-4 py-3 font-semibold whitespace-nowrap border border-gray-300 dark:border-gray-600">Aksi</th>
                            </tr>
                        </thead>                        
                
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-center" id="dataRows">
                            @foreach ($alumniRows as $index => $row)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                    <td class="px-4 py-2 whitespace-nowrap border border-gray-300 dark:border-gray-600">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap border border-gray-300 dark:border-gray-600">{{ $row['alumni']->name ?? '-' }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap border border-gray-300 dark:border-gray-600">{{ $row['alumni']->email ?? '-' }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap border border-gray-300 dark:border-gray-600">{{ $row['alumni']->major ?? '-' }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap border border-gray-300 dark:border-gray-600">{{ $row['alumni']->graduation_year ?? '-' }}</td>
                                    @foreach ($questions->take(5) as $question)
                                        <td class="px-4 py-2 whitespace-nowrap border border-gray-300 dark:border-gray-600">
                                            {{ $row[$question->question_text] ?? '-' }}
                                        </td>
                                    @endforeach
                                    <td class="px-4 py-2 whitespace-nowrap border border-gray-300 dark:border-gray-600">
                                        {{ optional($row['created_at'])->format('d M Y, H:i') ?? '-' }}
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap border border-gray-300 dark:border-gray-600">
                                        <button class="text-blue-600 hover:underline" data-row='@json($row)' onclick="showDetails(this)">
                                            Lihat Selengkapnya
                                        </button>
                                    </td>
                                    <td class="px-4 py-2 whitespace-nowrap border border-gray-300 dark:border-gray-600">
                                        <form action="{{ route('admin.alumni_answers.destroy', $row['submission_id']) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data alumni ini beserta jawabannya?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:scale-125 hover:underline transition-all duration-150">
                                                Hapus
                                            </button>
                                        </form>                                                                           
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>                        
                    </table>
                
                    <!-- no notification -->
                    <div id="noResults" class="hidden p-4 text-red-600 bg-red-100 rounded-md">
                        Data tidak ditemukan untuk pencarian Anda.
                    </div>
                    <!-- pagination (Jika diperlukan) -->
                    <div class="p-4">
                        {{-- {{ $alumniRows->links() }} --}}
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Scroll Up Button -->
    <button id="scrollUpBtn" class="fixed bottom-4 right-4 bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-full shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all transform scale-0 opacity-0" onclick="scrollToTop()">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11l-7-7-7 7" />
        </svg>
    </button>

    <script>
        // Fungsi untuk menampilkan atau menyembunyikan sidebar filter
        function toggleFilter() {
            const sidebar = document.getElementById('filterSidebar');
            sidebar.classList.toggle('translate-x-full');
        }

        //submit filter
        function submitFilter() {
            const form = document.getElementById('filterForm');
            form.submit();
        }

        // Fungsi untuk menampilkan detail jawaban alumni
        function showDetails(button) {
            const data = JSON.parse(button.getAttribute('data-row'));

            let detail = "Detail Jawaban Alumni:\n\n";
            Object.entries(data).forEach(([key, value]) => {
                if (!['created_at', 'submission_id'].includes(key)) {
                    // Gunakan backticks (`) untuk template literal
                    detail += `${key}: ${value}\n`;
                }
            });

            alert(detail);
        }


        // Fungsi pencarian untuk tabel
        function searchTable() {
            const input = document.getElementById('tableSearchInput');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('dataTable');
            const trs = table.querySelectorAll('tbody tr');
            let found = false;

            trs.forEach(tr => {
                const text = tr.textContent.toLowerCase();
                if (text.includes(filter)) {
                    tr.style.display = '';
                    found = true;
                } else {
                    found = false;
                    tr.style.display = 'data tidak ditemukan,harap masukkan kata kunci pencarian yang sesuai!!';
                }
            });

            // Menampilkan notifikasi jika tidak ditemukan
            const noResults = document.getElementById('noResults');
            if (!found) {
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');
            }
        }

                // Fungsi untuk scroll kembali ke atas
                function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        }

        // Menampilkan dan menyembunyikan tombol Scroll Up berdasarkan posisi scroll
        window.onscroll = function () {
            const scrollUpBtn = document.getElementById("scrollUpBtn");
            if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
                scrollUpBtn.classList.remove("scale-0", "opacity-0");
                scrollUpBtn.classList.add("scale-100", "opacity-100");
            } else {
                scrollUpBtn.classList.remove("scale-100", "opacity-100");
                scrollUpBtn.classList.add("scale-0", "opacity-0");
            }
        }
    </script>
</x-app-layout>
