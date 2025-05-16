<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-extrabold text-white tracking-tight">📊 Laporan Statistik</h2>
    </x-slot>

    <!-- Head CDN -->
    <x-slot name="head">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
        
        <style>
            .choices__inner {
                background-color: #374151 !important; /* gray-700 */
                color: #fff !important;
                border: 1px solid #4B5563 !important; /* gray-600 */
                border-radius: 0.5rem !important; /* rounded-lg */
                min-height: 3rem !important;
                padding-left: 1rem;
            }

            .choices__list--multiple .choices__item {
                background-color: #2563EB !important; /* blue-600 */
                border: none !important;
                color: white;
                font-size: 0.875rem;
                padding: 0.3rem 0.75rem;
                border-radius: 0.375rem;
                margin: 0.2rem 0.3rem;
            }

            .choices__list--dropdown {
                background-color: #1F2937 !important; /* gray-800 */
                color: white;
            }

            .choices__input {
                background-color: transparent !important;
                color: white !important;
            }

            .choices[data-type*="select-multiple"] .choices__button {
                color: white !important;
            }

            /* Tambahan styling agar opsi tampil seperti ada checkbox */
            .choices__list--dropdown .choices__item--selectable::before {
                content: '';
                display: inline-block;
                width: 1rem;
                height: 1rem;
                margin-right: 0.75rem;
                border: 2px solid #9CA3AF; /* gray-400 */
                border-radius: 0.2rem;
                background-color: transparent;
                vertical-align: middle;
            }

            .choices__list--dropdown .choices__item--selectable.is-highlighted::before {
                border-color: #3B82F6; /* blue-500 saat hover */
            }

            .choices__list--multiple .choices__item {
                background-color: #2563EB !important; /* blue-600 */
                border: none !important;
                color: white;
                font-size: 0.875rem;
                padding: 0.3rem 0.75rem;
                border-radius: 0.375rem;
                margin: 0.2rem 0.3rem;
            }

            /* Checklist aktif */
            .choices__list--dropdown .choices__item--selectable[data-value].choices__item--selectable--checked::before {
                background-color: #3B82F6;
                border-color: #3B82F6;
                box-shadow: inset 0 0 0 2px #1F2937;
            }

            /* Text item dropdown */
            .choices__list--dropdown .choices__item--selectable {
                padding-left: 1.5rem;
                color: white;
            }

            /* @media print {
                .no-print {
                    display: none;
                }
            } */
            
        </style>

    
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto space-y-10">

            <!-- FILTER PANEL -->
            <div class="bg-gray-800 bg-opacity-60 backdrop-blur-md rounded-2xl p-6 shadow-lg">
                <form method="GET" action="{{ route('admin.reports.showReport') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                    <!-- Jenis Chart -->
                    <div class="flex flex-col">
                        <label class="mb-2 text-sm font-semibold">Jenis Chart</label>
                        <select id="chart_type" class="bg-gray-700 text-white rounded-lg px-4 py-3">
                            <option value="line">Line</option>
                            <option value="bar" >Bar</option>
                            <option value="pie">Pie</option>
                        </select>
                    </div>

                    <!-- Tahun Lulus -->
                        <div class="flex flex-col"
                        x-data='multiYear(@json($graduationYears), @json($selectedYears))' x-cloak>
                       <label class="mb-2 text-sm font-semibold">Tahun Lulus</label>

                        {{-- tombol pemicu --}}
                        <button
                          @click="open = !open"
                          type="button"
                          class="w-full flex justify-between items-center bg-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none"
                        >
                          <span x-text="selected.length ? `(${selected.length}) selected` : 'Pilih Tahun'"></span>
                          <svg xmlns="http://www.w3.org/2000/svg" 
                              class="h-5 w-5 transform" 
                              :class="{'rotate-180': open}" 
                              fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M19 9l-7 7-7-7" />
                          </svg>
                        </button>

                        {{-- dropdown --}}
                        <div
                          x-show="open"
                          @click.away="open = false"
                          class="mt-2 bg-gray-800 rounded-lg shadow-lg z-10"
                          style="display: none;" >

                          {{-- search box --}}
                          <div class="p-2">
                            <input
                              x-model="search"
                              type="text"
                              placeholder="Cari tahun..."
                              class="w-full bg-gray-700 text-white rounded-md px-3 py-2 focus:outline-none" />
                          </div>

                          {{-- list opsi --}}
                          <ul class="max-h-60 overflow-auto">
                            <template x-for="year in filtered" :key="year">
                              <li
                                @click="toggle(year)"
                                class="flex items-center px-4 py-2 cursor-pointer hover:bg-gray-700">
                                <input
                                  type="checkbox"
                                  class="form-checkbox h-5 w-5 text-blue-500"
                                  :checked="selected.includes(year)"
                                  @click.stop="toggle(year)"
                                />
                                <span class="ml-3 text-white select-none" x-text="year"></span>
                              </li>
                            </template>
                            <template x-if="filtered.length === 0">
                              <li class="px-4 py-2 text-gray-400">Tidak ada hasil</li>
                            </template>
                          </ul>

                          {{-- pilih semua checkbox --}}
                           <div class="flex justify-between items-center px-4 py-2 border-t border-gray-700 text-sm">
                            <button @click="selectAll()" class="text-blue-400 hover:underline">Pilih Semua</button>
                            <button @click="reset()" class="text-red-400 hover:underline">Reset</button>
                          </div>
                        </div>

                        {{-- membuat hidden input --}}
                        <template x-for="year in selected" :key="year">
                          <input type="hidden" name="graduation_year[]" :value="year" />
                        </template>
                      </div>  

                      {{-- Status Pekerjaan --}}
                    <div class="flex flex-col">
                      <label class="mb-2 text-sm font-semibold">Status Pekerjaan</label>
                      <select name="employment_status" id="employment_status" class="bg-gray-700 text-white rounded-lg px-4 py-3">
                        <option value="semua" {{ $selectedStatus == 'semua' ? 'selected' : '' }}>Semua</option>
                      @foreach ($employmentStatuses as $status)
                        <option value="{{ $status }}" {{ $selectedStatus == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                      @endforeach
                    </select>                    
                  </div>

                  {{-- tombol tampil data --}}
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white font-bold py-3 rounded-xl shadow-lg transition transform hover:scale-105">
                            <i class="fa-solid fa-magnifying-glass mr-2"></i> Tampilkan Data
                        </button>
                    </div>
                </form>
            </div>

          
          <!-- Pesan jika tidak ada data -->
          <div id="no-data-message" class="hidden mt-6 px-6 py-4 rounded-xl bg-gray-500 text-white text-center text-lg font-semibold shadow-md">
            Tidak ada data yang tersedia dengan filter yang dipilih.
          </div>


            <!-- CHART CONTAINER -->
            <div class="bg-gray-800 rounded-2xl p-8 shadow-lg">
                <h3 class="text-xl font-bold mb-6 text-center">📈 Statistik Data</h3>
                <div id="chart-container" class="w-full h-97">
                    <canvas id="chart"></canvas>
                </div>
            </div>

            <!-- DOWNLOAD SECTION -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
                <div class="flex items-center space-x-4">
                    <label class="font-medium text-sm">Format Download</label>
                    <select id="download_format" class="bg-gray-700 text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-400">
                        <option>PNG</option>
                        <option>JPEG</option>
                        <option>WebP</option>
                        <option>PDF</option>
                    </select>
                </div>
                <div class="flex gap-4">
                    <button id="download-btn" class="flex items-center bg-green-500 hover:bg-green-600 text-white px-5 py-3 rounded-xl shadow-md transition transform hover:scale-105">
                        <i class="fa-solid fa-download mr-2"></i> Download Grafik
                    </button>
                    <button onclick="window.print()" class="flex items-center bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-3 rounded-xl shadow-md transition transform hover:scale-105">
                        <i class="fa-solid fa-print mr-2"></i> Cetak Laporan
                    </button>
                </div>
            </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
      const datalabels = @json($labels);
      const datacounts = @json($counts);
      const selectedStatus = @json($selectedStatus); 
  
      let chart;

      function toggleDownloadButton(isDisabled) {
          const downloadBtn = document.getElementById('download-btn');
          downloadBtn.disabled = isDisabled;
          downloadBtn.classList.toggle('opacity-50', isDisabled);
      }
  
  function renderChart(type) {
    const ctx = document.getElementById('chart').getContext('2d');
    const noDataMessage = document.getElementById('no-data-message');
    const canvas = document.getElementById('chart');

    if (chart) {
        chart.destroy();
    }
    // Jika data kosong, sembunyikan canvas dan tampilkan pesan
    const isEmpty = !Array.isArray(datacounts) || datacounts.length === 0 || datacounts.every(count => count === 0);

    if (isEmpty) {
        canvas.style.display = 'none';         
        noDataMessage.classList.remove('hidden');
        toggleDownloadButton(true);
        return;
    } else {
        canvas.style.display = 'block';        
        noDataMessage.classList.add('hidden'); 
        toggleDownloadButton(false);  
    }

    let chartLabel = 'Jumlah Alumni ';
    if (selectedStatus !== 'semua') {
        chartLabel += ' ' + selectedStatus;
    }

    if (Array.isArray(datalabels) && datalabels.length > 0) {
        chartLabel += ' Tahun: ' + datalabels.join(', ');
    }


    chart = new Chart(ctx, {
        type: type,
        data: {
            labels: datalabels,
            datasets: [{
                label: chartLabel + " | status kerja : "+selectedStatus,
                data: datacounts,
                backgroundColor: ['#3B82F6', '#9333EA', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#A3A3A3', '#F472B6'],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            animation: { duration: 1000, easing: 'easeOutBounce' },
            plugins: {
                legend: { labels: { color: 'white' } },
                tooltip: { backgroundColor: '#1f2937', titleColor: '#fff', bodyColor: '#fff' }
            },
            scales: {
                x: { ticks: { color: 'white' }, grid: { color: 'rgba(255,255,255,0.1)' } },
                y: { ticks: { color: 'white' }, grid: { color: 'rgba(255,255,255,0.1)' } },
            }
          }
        });
    }
        const chartTypeSelect = document.getElementById('chart_type');
        chartTypeSelect.value = 'bar';
        renderChart('bar');

      document.getElementById('chart_type').addEventListener('change', function () {
          renderChart(this.value);
      });
  
      // document.getElementById('employment_status').addEventListener('change', function () {
      //     this.form.submit(); 
      // });
      document.getElementById('download-btn').addEventListener('click', function () {
    let format = document.getElementById('download_format').value.toLowerCase();  // Biar pasti lowercase
    const canvas = document.getElementById('chart');

    if (format === 'pdf') {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF('landscape');
        const imgData = canvas.toDataURL('image/png');
        const pageWidth = pdf.internal.pageSize.getWidth();
        const pageHeight = pdf.internal.pageSize.getHeight();
        pdf.addImage(imgData, 'PNG', 10, 10, pageWidth - 20, pageHeight - 20);
        pdf.save('chart.pdf');
    } else {
        const validFormats = ['png', 'jpeg', 'webp'];
        if (!validFormats.includes(format)) {
            alert('Format tidak didukung untuk gambar.');
            return;
        }
        const mimeType = `image/${format}`;
        const dataUrl = canvas.toDataURL(mimeType);
        const link = document.createElement('a');
        link.href = dataUrl;
        link.download = `chart.${format}`;
        link.click();
    }
});
        // Fungsi untuk menampilkan tahun lulus
        function multiYear(allYears = [], preSelected = []) {
        return {
        open: false,
        all: allYears,
        selected: preSelected,
        search: '',
        get filtered() {
            //jika pencarian kosong maka tampilkan semua tahun
            return this.all.filter(year => 
            //nyari kolom year mengandung teks pencarian di searchnya
                year.toString().includes(this.search.toLowerCase())
            );
        },
        toggle(year) {
            if (this.selected.includes(year)) {
                //tahun sudah dipilih maka hapus dari daftar
                this.selected = this.selected.filter(y => y !== year);
            } else {
              //buat blm ada push ke variabel year
                this.selected.push(year);
            }
          },
        selectAll() {
            this.selected = [...this.all];
          },
        reset() {
            this.selected = [];
            this.search = '';
          }
        }
      }

    </script>
</x-app-layout>
