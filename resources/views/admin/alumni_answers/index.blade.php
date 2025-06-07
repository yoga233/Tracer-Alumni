<x-app-layout>
    <x-slot name="header">
        <div class="mb-6 flex items-start gap-4 animate-fade-in">
            <div class="border-l-4 border-blue-600 pl-4">
                <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-users text-blue-600"></i>
                    Jawaban Alumni
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Tinjau data hasil pengisian survei alumni yang mencakup identitas, status, dan tanggapan mereka terhadap pertanyaan yang diberikan.
                </p>
            </div>
        </div>

        <style>
            .custom-scrollbar::-webkit-scrollbar {
                width: 8px;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb {
                background-color: #94a3b8;
                border-radius: 10px;
            }
            .custom-scrollbar::-webkit-scrollbar-track {
                background-color: transparent;
            }
        </style>

    </x-slot>

    <div class="flex">
        <!-- Sidebar Filter -->
        <div id="filterSidebar" class="fixed inset-y-0 right-0 w-80 bg-white text-gray-900 shadow-lg transform translate-x-full transition-transform duration-300 z-50 overflow-y-auto">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4 border-b border-gray-600 pb-2">
                    <h3 class="text-lg font-semibold text-black">Filter</h3>
                    
                    <button 
                      type="button"
                      onclick="toggleFilter()" 
                      class="text-gray-400 hover:text-red-500 transition duration-200 ease-in-out"
                      aria-label="Tutup Filter"
                      title="Tutup Filter">
                      <svg 
                        xmlns="http://www.w3.org/2000/svg" 
                        fill="none" 
                        viewBox="0 0 24 24" 
                        stroke-width="2" 
                        stroke="currentColor" 
                        class="w-6 h-6" >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                      </svg>
                    </button>
                  </div>                  
                

                {{-- Form Filter --}}
                <form method="GET" action="{{ route('admin.alumni-answers.index') }}" class="mb-6 space-y-5">

                    {{-- Pencarian Keyword Pertanyaan --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Keyword Pertanyaan</label>
                        <input
                            type="text"
                            id="filterKeyword"
                            name="keyword"
                            value="{{ request('keyword') }}"
                            placeholder="Cari pertanyaan..."
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm text-gray-800 placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        >
                    </div>

                    {{-- Waktu Pengisian --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Pengisian</label>
                        <input
                            type="date"
                            name="start_date"
                            value="{{ request('start_date') }}"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        >
                    </div>

                    {{-- Tahun Lulus --}}
                    <div>
                        <label name="tahun_lulus" class="block text-sm font-medium text-gray-700 mb-1">Tahun Lulus</label>
                        <select
                            name="tahun_lulus"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm text-gray-800 bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        >
                            <option value="all">Semua</option>
                            @foreach ($graduationYears as $year)
                                <option value="{{ $year }}" {{ request('tahun_lulus') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Status Pekerjaan --}}
                    <div>
                        <label for="status_kerja" class="block text-sm font-medium text-gray-700 mb-1">Status Pekerjaan</label>
                        <select
                            name="status_kerja"
                            id="status"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm text-gray-800 bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        >
                            <option value="all">Semua</option>
                            @foreach ($employmentStatuses as $status)
                                <option value="{{ $status }}" {{ request('status_kerja') == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex justify-between pt-2">
                        <button
                            type="submit"
                            class="px-6 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold transition"
                        >
                            Filter
                        </button>

                        <button
                            type="button"
                            onclick="resetFilter()"
                            class="px-6 py-2 rounded-lg bg-red-500 hover:bg-red-600 text-white font-semibold transition"
                        >
                            Reset
                        </button>

                    </div>

                </form>


                
                <hr class="my-4 border-gray-700">                

            </div>
        </div>



        <!-- Main Content -->
        <div class="py-10 flex-1">
            <!-- Modal Detail Redesain dengan Animasi Transisi -->
         <div id="detailModal" class="fixed inset-0 z-50 bg-black bg-opacity-60 items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300 ease-in-out hidden">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl p-8 relative overflow-hidden max-h-[90vh] border border-gray-300 dark:border-gray-700">
                <!-- Header -->
                <div class="flex justify-between items-start mb-6 border-b pb-4 border-gray-200">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">📋 Detail Jawaban Alumni</h3>
                        <p class="text-sm text-gray-500">Data lengkap yang diisi oleh alumni</p>
                    </div>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-red-500 transition text-4xl font-bold">&times;</button>
                </div>

                <!-- Content -->
                <div id="modalContent" class="space-y-3 text-sm text-gray-800 max-h-[60vh] overflow-y-auto pr-2 custom-scrollbar">
                    <!-- Diisi via JS -->
                </div>

                <!-- Footer -->
                <div class="mt-6 pt-4 border-t border-gray-200 text-right">
                    <button onclick="closeModal()" class="px-5 py-2 rounded-lg text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200 dark:hover:bg-gray-700 transition">Tutup</button>
                </div>
            </div>
        </div>


            <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between mb-4">
                    <!-- Modern Search Bar (on the left) -->
                    <div class="relative w-full max-w-sm flex-1">
                        <input
                            type="text"
                            id="tableSearchInput"
                            class="w-full py-3 pl-11 pr-4 bg-white border border-gray-300 rounded-lg shadow-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                            placeholder="Cari jawaban alumni..."
                            onkeyup="searchTable()"
                        >
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                
                <div class="w-full overflow-x-auto rounded-xl shadow-md">
                    <table class="min-w-max divide-y divide-gray-200 text-sm text-left text-gray-700 table-auto" id="dataTable">
                        <thead class="bg-blue-100 text-blue-900 font-semibold uppercase text-xs tracking-wider">
                            <tr>
                                <th class="px-4 py-3 font-semibold whitespace-nowrap">ID</th>
                                <th class="px-4 py-3 font-semibold whitespace-nowrap">Nama</th>
                                <th class="px-4 py-3 font-semibold whitespace-nowrap">Email</th>
                                <th class="px-4 py-3 font-semibold whitespace-nowrap">NPM</th>
                                <th class="px-4 py-3 font-semibold whitespace-nowrap">Tahun <br> Lulus</th>
                                <th class="px-4 py-3 font-semibold whitespace-nowrap">Status Kerja</th>
                                <th class="px-4 py-3 font-semibold whitespace-nowrap">Waktu tunggu kerja <br> setelah lulus</th>


                                @foreach ($questions->take(4) as $question)
                                    <th data-question @if ($withQuestions) data-question-matched @endif class="px-4 py-3 font-semibold whitespace-nowrap">
                                        {{ $question->question_text }}
                                    </th>
                                @endforeach

                                @foreach ($questions->skip(4) as $question)
                                    <th class="px-4 py-3 font-semibold whitespace-nowrap hidden">
                                        {{ $question->question_text }}
                                    </th>
                                @endforeach

                                <th class="px-4 py-3 font-semibold whitespace-nowrap">Waktu Isi</th>
                                <th class="px-4 py-3 font-semibold whitespace-nowrap">Lainnya</th>
                                <th class="px-4 py-3 font-semibold whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 bg-white" id="dataRows">
                            @foreach ($alumniRows as $index => $row)
                                <tr class="hover:bg-gray-100 text-left">
                                         <td class="px-4 py-2 whitespace-nowrap">{{ ($row['alumni'])->id ?? '-' }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ ($row['alumni'])->nama_mahasiswa ?? '-' }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ ($row['alumni'])->email ?? '-' }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ ($row['alumni'])->npm ?? '-' }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ ($row['alumni'])->tahun_lulus ?? '-' }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ ($row['alumni'])->status_saat_ini ?? '-' }}</td>
                                        <td class="px-4 py-2 whitespace-nowrap">{{ $row['waktu_tunggu']->waktu_tunggu_bulan ?? '-' }} </td>

                                    @foreach ($questions->take(4) as $question)
                                        <td data-question @if ($withQuestions) data-question-matched @endif class="px-4 py-2 whitespace-nowrap">
                                            {{ $row[$question->question_text] ?? '-' }}
                                        </td>
                                    @endforeach

                                    @foreach ($questions->skip(4) as $question)
                                        <td class="px-4 py-2 whitespace-nowrap hidden">
                                            {{ $row[$question->question_text] ?? '-' }}
                                        </td>
                                    @endforeach

                                    <td class="px-4 py-2 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($row['created_at'])->translatedFormat('j F Y, H:i') ?? '-' }}
                                    </td>

                                    <td class="px-4 py-2 whitespace-nowrap">
                                        <button 
                                            class="inline-flex items-center px-4 py-2 bg-blue-500 text-white text-sm font-semibold rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75 transition duration-200"
                                            onclick="loadDetails({{ $row['submission_id'] }})"
                                        >
                                            Details
                                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M5 12h14M13 6l6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </button>
                                    </td>

                                    <td class="px-4 py-2 whitespace-nowrap">
                                        <form action="{{ route('admin.alumni_answers.destroy', $row['submission_id']) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus data alumni ini beserta jawabannya?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-2 bg-red-500 text-white text-sm font-semibold rounded-lg shadow-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-75 transition-all duration-200">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19 7L5 7M10 11V17M14 11V17M5 7L6 19C6 20.1 6.9 21 8 21H16C17.1 21 18 20.1 18 19L19 7M9 7V4H15V7" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- no notification -->
                <div id="noResults" class="hidden p-4 text-red-600 bg-red-100 rounded-md">
                    Data tidak ditemukan untuk pencarian Anda.
                </div>
                <div class="mt-6 flex justify-center">
                    {{ $submissions->links('components.pagination-question') }}
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

        // reset
        function resetFilter() {
            const form = document.querySelector('#filterSidebar form');

            if (!form) return;
            // Reset semua input dan select
            const inputs = form.querySelectorAll('input, select');
            inputs.forEach(input => {
                if (input.tagName === 'INPUT' && (input.type === 'text' || input.type === 'date')) {
                    input.value = '';
                } else if (input.tagName === 'SELECT') {
                    input.selectedIndex = 0;
                }
            });

            form.submit();
            document.body.style.opacity = 0.6;
        }

        // menyembunyikan filter
        const withQuestions = @json($withQuestions);
        document.addEventListener('DOMContentLoaded', () => {
            if (withQuestions) {
                const allQuestionCols = document.querySelectorAll('th[data-question], td[data-question]');
                allQuestionCols.forEach(el => el.classList.add('hidden'));
                const matchingCols = document.querySelectorAll('th[data-question-matched], td[data-question-matched]');
                matchingCols.forEach(el => el.classList.remove('hidden'));
            }
        });

  const loadDetails = async (submissionId) => {
    const modal = document.getElementById('detailModal');
    const modalContent = document.getElementById('modalContent');
    const response = await fetch(`/admin/alumni_answers/detail/${submissionId}`);
    const textResponse = await response.text();

    let data;
    try {
        data = JSON.parse(textResponse);
    } catch (error) {
        console.error('Gagal parse JSON:', error);
        return;
    }

    const alumniLabels = {
        nama_mahasiswa: 'Nama Mahasiswa',
        nik: 'NIK',
        email: 'Email',
        npm: 'NPM',
        tahun_lulus: 'Tahun Lulus',
        tanggal_lahir: 'Tanggal Lahir',
        nomor_telepon: 'Nomor Telepon',
        npwp: 'NPWP',
        nama_dosen_pembimbing: 'Dosen Pembimbing',
        sumber_pembiayaan_kuliah: 'Sumber Pembiayaan Kuliah',
        status_saat_ini: 'Status Saat Ini',
    };

    const waktuTungguLabels = {
        waktu_tunggu_kerja: 'Waktu Tunggu Kerja (bulan)', // tambahkan koma
    };

    const jenisPerusahaanLabels = {
        jenis_perusahaan: 'Jenis Perusahaan',
    };

    const keeratanStudiKerjaLabels = {
        keeratan_studi_kerja: 'Keeratan Studi dengan Pekerjaan',
    };

    const kompetensiLulusLabels = {
        etika: 'Etika',
        keahlian_bidang_ilmu: 'Keahlian Berdasarkan Bidang Ilmu',
        bahasa_inggris: 'Bahasa Inggris',
        penggunaan_teknologi_informasi: 'Penggunaan Teknologi Informasi',
        komunikasi: 'Komunikasi',
        kerjasama_tim: 'Kerja Sama Tim',
        pengembangan_diri: 'Pengembangan Diri',
    };

    const kompetensiKerjaLabels = {
        etika: 'Etika',
        keahlian_bidang_ilmu: 'Keahlian Berdasarkan Bidang Ilmu',
        bahasa_inggris: 'Bahasa Inggris',
        penggunaan_teknologi_informasi: 'Penggunaan Teknologi Informasi',
        komunikasi: 'Komunikasi',
        kerjasama_tim: 'Kerja Sama Tim',
        pengembangan_diri: 'Pengembangan Diri',
    };

    let html = `
        <div class="overflow-y-auto max-h-[60vh] pr-2 custom-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-300 dark:border-gray-200 bg-blue-100 dark:bg-blue-800 text-blue-800 dark:text-blue-100">
                        <th class="py-2 px-3 font-semibold text-center text-sm border-r border-gray-300 dark:border-gray-600 w-1/3">PERTANYAAN</th>
                        <th class="py-2 px-3 text-center text-sm">JAWABAN</th>
                    </tr>
                </thead>
                <tbody>
    `;

    // Data Alumni
    if (data.alumni && typeof data.alumni === 'object') {
        Object.entries(alumniLabels).forEach(([field, label]) => {
            html += `
                <tr class="border-b border-gray-300 dark:border-gray-600">
                    <th class="py-2 px-3 font-medium text-lg border-r border-gray-300 dark:border-gray-600 align-top">${label}</th>
                    <td class="py-2 px-3 text-lg whitespace-pre-line">${data.alumni[field] ?? '-'}</td>
                </tr>
            `;
        });
    } else {
        html += `
            <tr>
                <td colspan="2" class="py-4 px-3 text-center text-red-600 italic">Data alumni belum tersedia</td>
            </tr>
        `;
    }

    // Waktu Tunggu Kerja
    html += `<tr class="bg-gray-100"><th colspan="2" class="py-2 px-3 font-bold text-blue-700">Waktu Tunggu Kerja</th></tr>`;
    if (data.waktu_kerja && typeof data.waktu_kerja === 'object') {
        Object.entries(waktuTungguLabels).forEach(([field, label]) => {
            html += `
                <tr class="border-b border-gray-300 dark:border-gray-600">
                    <th class="py-2 px-3 font-medium text-lg border-r border-gray-300 dark:border-gray-600 align-top">${label}</th>
                    <td class="py-2 px-3 text-lg whitespace-pre-line">${data.waktu_kerja[field] ?? '-'}</td>
                </tr>
            `;
        });
    } else {
        html += `
            <tr>
                <td colspan="2" class="py-4 px-3 text-center text-red-600 italic">Data waktu tunggu kerja belum tersedia</td>
            </tr>
        `;
    }

    // Jenis Perusahaan
    html += `<tr class="bg-gray-100"><th colspan="2" class="py-2 px-3 font-bold text-blue-700">Jenis Perusahaan</th></tr>`;
    if (data.jenis_perusahaan && typeof data.jenis_perusahaan === 'object') {
        Object.entries(jenisPerusahaanLabels).forEach(([field, label]) => {
            html += `
                <tr class="border-b border-gray-300 dark:border-gray-600">
                    <th class="py-2 px-3 font-medium text-lg border-r border-gray-300 dark:border-gray-600 align-top">${label}</th>
                    <td class="py-2 px-3 text-lg whitespace-pre-line">${data.jenis_perusahaan[field] ?? '-'}</td>
                </tr>
            `;
        });
    } else {
        html += `
            <tr>
                <td colspan="2" class="py-4 px-3 text-center text-red-600 italic">Data jenis perusahaan belum tersedia</td>
            </tr>
        `;
    }

    // Keeratan Studi Kerja
    html += `<tr class="bg-gray-100"><th colspan="2" class="py-2 px-3 font-bold text-blue-700">Keeratan Studi dengan Pekerjaan</th></tr>`;
    if (data.keeratan_studi_kerja && typeof data.keeratan_studi_kerja === 'object') {
        Object.entries(keeratanStudiKerjaLabels).forEach(([field, label]) => {
            html += `
                <tr class="border-b border-gray-300 dark:border-gray-600">
                    <th class="py-2 px-3 font-medium text-lg border-r border-gray-300 dark:border-gray-600 align-top">${label}</th>
                    <td class="py-2 px-3 text-lg whitespace-pre-line">${data.keeratan_studi_kerja[field] ?? '-'}</td>
                </tr>
            `;
        });
    } else {
        html += `
            <tr>
                <td colspan="2" class="py-4 px-3 text-center text-red-600 italic">Data keeratan studi kerja belum tersedia</td>
            </tr>
        `;
    }

    // Kompetensi Saat Lulus
    html += `<tr class="bg-gray-100"><th colspan="2" class="py-2 px-3 font-bold text-blue-700">Kompetensi Saat Lulus</th></tr>`;
    if (data.kompetensiLulus && typeof data.kompetensiLulus === 'object') {
        Object.entries(kompetensiLulusLabels).forEach(([field, label]) => {
            html += `
                <tr class="border-b border-gray-300 dark:border-gray-600">
                    <th class="py-2 px-3 font-medium text-lg border-r border-gray-300 dark:border-gray-600 align-top">${label}</th>
                    <td class="py-2 px-3 text-lg whitespace-pre-line">${data.kompetensiLulus[field] ?? '-'}</td>
                </tr>
            `;
        });
    } else {
        html += `
            <tr>
                <td colspan="2" class="py-4 px-3 text-center text-red-600 italic">Data kompetensi saat lulus belum tersedia</td>
            </tr>
        `;
    }

    // Kompetensi Saat Bekerja
    html += `<tr class="bg-gray-100"><th colspan="2" class="py-2 px-3 font-bold text-blue-700">Kompetensi Saat Bekerja</th></tr>`;
    if (data.kompetensiKerja && typeof data.kompetensiKerja === 'object') {
        Object.entries(kompetensiKerjaLabels).forEach(([field, label]) => {
            html += `
                <tr class="border-b border-gray-300 dark:border-gray-600">
                    <th class="py-2 px-3 font-medium text-lg border-r border-gray-300 dark:border-gray-600 align-top">${label}</th>
                    <td class="py-2 px-3 text-lg whitespace-pre-line">${data.kompetensiKerja[field] ?? '-'}</td>
                </tr>
            `;
        });
    } else {
        html += `
            <tr>
                <td colspan="2" class="py-4 px-3 text-center text-red-600 italic">Data kompetensi saat bekerja belum tersedia</td>
            </tr>
        `;
    }

    // Jawaban Alumni dari Pertanyaan Survei
    html += `<tr class="bg-gray-100"><th colspan="2" class="py-2 px-3 font-bold text-blue-700">Jawaban Pertanyaan Survei</th></tr>`;
    if (Array.isArray(data.alumniAnswers) && data.alumniAnswers.length > 0) {
        data.alumniAnswers.forEach(({ question, answer }) => {
            html += `
                <tr class="border-b border-gray-300 dark:border-gray-600">
                    <th class="py-2 px-3 font-medium text-lg border-r border-gray-300 dark:border-gray-600 align-top">${question}</th>
                    <td class="py-2 px-3 text-lg whitespace-pre-line">${answer || '-'}</td>
                </tr>
            `;
        });
    } else {
        html += `
            <tr>
                <td colspan="2" class="bg-red-100 py-4 px-3 text-center text-red-600 italic">Jawaban pertanyaan belum tersedia</td>
            </tr>
        `;
    }

    html += `
                </tbody>
            </table>
        </div>
    `;

    modalContent.innerHTML = html;
    modal.classList.remove('hidden', 'pointer-events-none', 'opacity-0');
    modal.classList.add('flex');
    setTimeout(() => {
        modal.classList.remove('opacity-0');
        modal.classList.add('opacity-100');
    }, 50);
};


    //     function showAllColumns() {
    //     const table = document.getElementById('dataTable');
    //     const ths = table.querySelectorAll('thead th');
    //     ths.forEach((th, index) => {
    //         if (index > 5) { // mulai dari index 6 untuk kolom setelah 4 pertanyaan
    //             th.classList.remove('hidden');
    //         }
    //     });

    //     const trs = table.querySelectorAll('tbody tr');
    //     trs.forEach(tr => {
    //         const tds = tr.querySelectorAll('td');
    //         tds.forEach((td, index) => {
    //             if (index > 5) {
    //                 td.classList.remove('hidden');
    //             }
    //         });
    //     });
    // }

        function closeModal() {
            const modal = document.getElementById('detailModal');
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0','pointer-events-none');
            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 300); 
        }

        function searchTable() {
            const input = document.getElementById('tableSearchInput');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('dataTable');
            const trs = table.querySelectorAll('tbody tr');
            let found = false;

            trs.forEach(tr => {
                let match = false;
                const tds = tr.querySelectorAll('td');
                
                tds.forEach(td => {
                    // sembunyikan kolom
                    if (td.classList.contains('hidden')) return;

                    const text = td.textContent.toLowerCase();
                    if (text.includes(filter)) {
                        match = true;
                    }
                });

                if (match) {
                    tr.style.display = '';
                    found = true;
                } else {
                    tr.style.display = 'none';
                }
            });

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
