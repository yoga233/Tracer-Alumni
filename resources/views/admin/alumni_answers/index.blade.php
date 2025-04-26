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

                <form method="GET" action="">
                    <div class="mb-4">
                        <label class="block text-sm mb-2">Keyword</label>
                        <input type="text" name="keyword" class="w-full p-2 border border-gray-700 rounded-md bg-gray-800 text-gray-100 placeholder-gray-400" placeholder="Cari sesuatu...">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm mb-2">Tanggal Isi</label>
                        <input type="date" name="tanggal" class="w-full p-2 border border-gray-700 rounded-md bg-gray-800 text-gray-100" style="color-scheme: dark;">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm mb-2">Status</label>
                        <select name="status" class="w-full p-2 border border-gray-700 rounded-md bg-gray-800 text-gray-100">
                            <option value="">Semua</option>
                            <option value="Lengkap">Lengkap</option>
                            <option value="Belum Lengkap">Belum Lengkap</option>
                        </select>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                            Cari
                        </button>
                    </div>
                </form>
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

                <div class="overflow-auto bg-white dark:bg-gray-900 shadow-xl rounded-xl border border-gray-200 dark:border-gray-700">
                    <table class="min-w-full table-auto text-sm text-left text-gray-700 dark:text-gray-200" id="dataTable">
                        <thead class="bg-gray-100 dark:bg-gray-800 border-b dark:border-gray-600">
                            <tr>
                                <th class="px-4 py-3 font-semibold whitespace-nowrap">ID</th>
                                @foreach ($questions->take(5) as $question)
                                    <th class="px-4 py-3 font-semibold whitespace-nowrap">
                                        {{ $question->question_text }}
                                    </th>
                                @endforeach
                                <th class="px-4 py-3 font-semibold whitespace-nowrap">Lainnya</th>
                                <th class="px-4 py-3 font-semibold whitespace-nowrap">Waktu Isi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="dataRows">
                            @foreach ($alumniRows as $index => $row)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $index + 1 }}</td>

                                    @foreach ($questions->take(5) as $question)
                                        <td class="px-4 py-2 whitespace-nowrap">
                                            {{ $row[$question->question_text] ?? '-' }}
                                        </td>
                                    @endforeach

                                    <td class="px-4 py-2 whitespace-nowrap">
                                        <button
                                            class="text-blue-600 hover:underline"
                                            data-row='@json($row)'
                                            onclick="showDetails(this)">
                                            Lihat Selengkapnya
                                        </button>
                                    </td>

                                    <td class="px-4 py-2 whitespace-nowrap">
                                        {{ optional($row['created_at'])->format('d M Y, H:i') ?? '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- No Results Notification -->
                    <div id="noResults" class="hidden p-4 text-red-600 bg-red-100 rounded-md">
                        Data tidak ditemukan untuk pencarian Anda.
                    </div>

                    <!-- Pagination (Jika diperlukan) -->
                    <div class="p-4">
                        {{-- {{ $pagination->links() }} --}}
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
                    tr.style.display = 'none';
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
