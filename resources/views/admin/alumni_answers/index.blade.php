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
             @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        
        .gradient-border {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1px;
            border-radius: 12px;
        }
        
        .gradient-border-inner {
            background: white;
            border-radius: 11px;
        }
        
        .hover-scale {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .hover-scale:hover {
            transform: scale(1.02);
        }
        
        .floating-label {
            transition: all 0.2s ease-in-out;
        }
        
        .input-focused + .floating-label {
            transform: translateY(-1.5rem) scale(0.875);
            color: #667eea;
        }
        
        .custom-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }
        
        .filter-card {
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 4px 15px 0 rgba(102, 126, 234, 0.4);
        }
        
        .btn-primary:hover {
            box-shadow: 0 6px 20px 0 rgba(102, 126, 234, 0.6);
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            box-shadow: 0 4px 15px 0 rgba(245, 87, 108, 0.4);
        }
        
        .btn-secondary:hover {
            box-shadow: 0 6px 20px 0 rgba(245, 87, 108, 0.6);
            transform: translateY(-2px);
        }
        
        .slide-in {
            animation: slideIn 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .input-group input:focus,
        .input-group select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .input-group input:not(:placeholder-shown) + label,
        .input-group input:focus + label,
        .input-group select:not([value=""]) + label {
            transform: translateY(-1.25rem) scale(0.875);
            color: #667eea;
            font-weight: 500;
        }
        
        .stats-badge {
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            border-radius: 20px;
            padding: 0.25rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: #374151;
        }
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
        <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden transition-opacity duration-300"></div>
    
    <!-- Filter Sidebar -->
    <div id="filterSidebar" class="fixed inset-y-0 right-0 w-96 glass-effect shadow-2xl transform translate-x-full transition-all duration-500 z-50 overflow-y-auto slide-in">
        <div class="p-8">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-blue-500 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent">Smart Filter</h3>
                        <p class="text-sm text-gray-500">Temukan data dengan mudah</p>
                    </div>
                </div>
                
                <button 
                    type="button"
                    onclick="toggleFilter()" 
                    class="w-10 h-10 rounded-xl bg-gray-100 hover:bg-red-50 text-gray-400 hover:text-red-500 transition-all duration-200 flex items-center justify-center hover-scale"
                    aria-label="Tutup Filter">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Filter Form -->
            <form method="GET" action="#" class="space-y-6">
                
                <!-- Search Input -->
                <div class="input-group fade-in">
                    <div class="gradient-border">
                        <div class="gradient-border-inner">
                            <input
                                type="text"
                                id="filterKeyword"
                                name="keyword"
                                placeholder=" "
                                class="w-full px-4 py-3 border-0 rounded-xl bg-transparent text-gray-800 placeholder-transparent focus:outline-none peer"
                                value=""
                            >
                            <label for="filterKeyword" class="absolute left-4 top-3 text-gray-500 transition-all duration-200 peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-focus:top-1 peer-focus:text-xs peer-focus:text-purple-600 peer-focus:font-medium">
                                🔍 Keyword Pertanyaan
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Date Input -->
                <div class="input-group fade-in" style="animation-delay: 0.1s">
                    <div class="filter-card rounded-xl p-1">
                        <input
                            type="date"
                            name="start_date"
                            class="w-full px-4 py-3 border-0 rounded-xl bg-transparent text-gray-800 focus:outline-none"
                        >

                    </div>
                </div>

                <!-- Graduation Year Select -->
                <div class="input-group fade-in" style="animation-delay: 0.2s">
                    <div class="filter-card rounded-xl p-1">
                        <select
                            name="tahun_lulus"
                            class="w-full px-4 py-3 border-0 rounded-xl bg-transparent text-gray-800 focus:outline-none custom-select appearance-none"
                        >
                            <option value="all">Semua Tahun</option>
                            <option value="2024">2024</option>
                            <option value="2023">2023</option>
                            <option value="2022">2022</option>
                            <option value="2021">2021</option>
                            <option value="2020">2020</option>
                        </select>

                    </div>
                </div>

                <!-- Employment Status Select -->
                <div class="input-group fade-in" style="animation-delay: 0.3s">
                    <div class="filter-card rounded-xl p-1">
                        <select
                            name="status_kerja"
                            class="w-full px-4 py-3 border-0 rounded-xl bg-transparent text-gray-800 focus:outline-none custom-select appearance-none"
                        >
                            <option value="all">Semua Status</option>
                            <option value="bekerja">Bekerja</option>
                            <option value="wirausaha">Wirausaha</option>
                            <option value="kuliah">Melanjutkan Kuliah</option>
                            <option value="mencari_kerja">Mencari Kerja</option>
                        </select>
                        
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col space-y-3 pt-4 fade-in" style="animation-delay: 0.4s">
                    <button
                        type="submit"
                        class="btn-primary text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 hover-scale"
                    >
                        <span class="flex items-center justify-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <span>Terapkan Filter</span>
                        </span>
                    </button>

                    <button
                        type="button"
                        onclick="resetFilter()"
                        class="btn-secondary text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 hover-scale"
                    >
                        <span class="flex items-center justify-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            <span>Reset Filter</span>
                        </span>
                    </button>
                </div>
            </form>
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
