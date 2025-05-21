<x-app-layout>
    <x-slot name="header">
        <div class="mb-6 flex items-start gap-4 animate-fancy-in">
            <div class="border-l-4 border-blue-600 pl-4">
                <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-chart-bar text-blue-600"></i>
                    Laporan Statistik
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Visualisasi data lulusan berdasarkan tahun, status pekerjaan, dan tipe grafik yang dipilih.
                </p>
            </div>
        </div>

    </x-slot>

    <!-- Head CDN -->
    <x-slot name="head">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
        
        <style>
            .choices__inner {
                background-color: #f9fafb !important; /* gray-50 */
                color: #1f2937 !important;            /* gray-800 */
                border: 1px solid #d1d5db !important; /* gray-300 */
            }


            .choices__list--multiple .choices__item {
                background-color: #3b82f6 !important; /* blue-500 */
                border: none !important;
                color: white;
                font-size: 0.875rem;
                padding: 0.3rem 0.75rem;
                border-radius: 0.375rem;
                margin: 0.2rem 0.3rem;
            }

            .choices__list--dropdown {
                background-color: #ffffff !important;
                color: #1f2937;
            }

            .choices__input {
                background-color: transparent !important;
                color: #1f2937 !important;
            }

            .choices[data-type*="select-multiple"] .choices__button {
                color: #1f2937 !important;
            }

            .choices__list--dropdown .choices__item--selectable::before {
                content: '';
                display: inline-block;
                width: 1rem;
                height: 1rem;
                margin-right: 0.75rem;
                border: 2px solid #9ca3af;
                border-radius: 0.2rem;
                background-color: transparent;
                vertical-align: middle;
            }

            .choices__list--dropdown .choices__item--selectable.is-highlighted::before {
                border-color: #3b82f6;
            }

            .choices__list--dropdown .choices__item--selectable[data-value].choices__item--selectable--checked::before {
                background-color: #3b82f6;
                border-color: #3b82f6;
                box-shadow: inset 0 0 0 2px #ffffff;
            }

            .choices__list--dropdown .choices__item--selectable {
                padding-left: 1.5rem;
                color: #1f2937;
            }
        </style>
    </x-slot>
    
    <div class="min-h-screen bg-gradient-to-br from-white via-gray-50 to-white text-gray-900 py-6 px-4 sm:px-6 lg:px-8 transition-all duration-300">
        <div class="w-full space-y-10 transition-all duration-300">

            <!-- FILTER PANEL -->
            <div class="bg-white bg-opacity-90 backdrop-blur-md rounded-2xl p-6 shadow-lg">
                <div class="w-full overflow-x-auto">
                    <form method="GET" action="{{ route('admin.reports.showReport') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 min-w-[320px]">

                        <!-- Jenis Chart -->
                        <div class="flex flex-col">
                            <label for="chart_type" class="mb-2 text-sm font-semibold text-gray-800">Jenis Chart</label>
                            <select id="chart_type" class="bg-white text-gray-800 border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm">
                                <option value="line">Line</option>
                                <option value="bar">Bar</option>
                                <option value="pie">Pie</option>
                            </select>
                        </div>

                        <!-- Tahun Lulus (Dropdown Multi-Select) -->
                        <div class="flex flex-col" x-data='multiYear(@json($graduationYears), @json($selectedYears))' x-cloak>
                            <label class="mb-2 text-sm font-semibold text-gray-800">Tahun Lulus</label>

                            <!-- Trigger Button -->
                            <button @click="open = !open" type="button"
                                class="w-full flex justify-between items-center bg-white text-gray-800 border border-gray-300 rounded-lg px-4 py-3 focus:outline-none shadow-sm">
                                <span x-text="selected.length ? `(${selected.length}) selected` : 'Pilih Tahun'"></span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform text-gray-500" :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown -->
                            <div x-show="open" @click.away="open = false"
                                class="mt-2 bg-white rounded-lg shadow-lg z-10 border border-gray-300" style="display: none;">
                                
                                <!-- Search -->
                                <div class="p-2">
                                    <input x-model="search" type="text" placeholder="Cari tahun..."
                                        class="w-full bg-white text-gray-800 border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                </div>

                                <!-- Options List -->
                                <ul class="max-h-60 overflow-auto divide-y divide-gray-100">
                                    <template x-for="year in filtered" :key="year">
                                        <li @click="toggle(year)" class="flex items-center px-4 py-2 cursor-pointer hover:bg-gray-100">
                                            <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-500" :checked="selected.includes(year)" @click.stop="toggle(year)" />
                                            <span class="ml-3 text-gray-800 select-none" x-text="year"></span>
                                        </li>
                                    </template>
                                    <template x-if="filtered.length === 0">
                                        <li class="px-4 py-2 text-gray-500">Tidak ada hasil</li>
                                    </template>
                                </ul>

                                <!-- Select All & Reset -->
                                <div class="flex justify-between items-center px-4 py-2 border-t border-gray-200 text-sm bg-gray-50">
                                    <button @click="selectAll()" class="text-blue-600 hover:underline">Pilih Semua</button>
                                    <button @click="reset()" class="text-red-600 hover:underline">Reset</button>
                                </div>
                            </div>

                            <!-- Hidden Input for Submission -->
                            <template x-for="year in selected" :key="year">
                                <input type="hidden" name="graduation_year[]" :value="year" />
                            </template>
                        </div>

                        <!-- Status Pekerjaan -->
                        <div class="flex flex-col">
                            <label for="employment_status" class="mb-2 text-sm font-semibold text-gray-800">Status Pekerjaan</label>
                            <select name="employment_status" id="employment_status"
                                class="bg-white text-gray-800 border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm">
                                <option value="semua" {{ $selectedStatus == 'semua' ? 'selected' : '' }}>Semua</option>
                                @foreach ($employmentStatuses as $status)
                                    <option value="{{ $status }}" {{ $selectedStatus == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-end">
                            <button type="submit"
                                class="w-full bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 hover:from-blue-500 hover:to-blue-700 text-white font-semibold py-3 rounded-xl shadow-md transition-transform transform hover:scale-105">
                                <i class="fa-solid fa-magnifying-glass mr-2"></i> Tampilkan Data
                            </button>
                        </div>
                    </form>
                </div>

                <!-- No Data Message -->
                <div id="no-data-message" class="hidden mt-6 px-6 py-4 rounded-xl bg-yellow-100 text-gray-900 text-center text-lg font-semibold shadow-md">
                    Tidak ada data yang tersedia dengan filter yang dipilih.
                </div>

                <!-- CHART CONTAINER -->
                <div id="chart-container" class="w-full overflow-x-auto mt-6">
                    <div class="relative w-full">
                        <canvas id="chart" class="!w-full h-[300px] sm:h-[400px] md:h-[500px] lg:h-[600px]"></canvas>
                    </div>
                </div>


                <!-- DOWNLOAD SECTION -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 w-full flex-wrap mt-10">
                    <div class="flex items-center space-x-4">
                        <label class="font-medium text-sm text-gray-700">Format Download</label>
                        <select id="download_format"
                            class="bg-white text-gray-800 border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-400 shadow-sm">
                            <option>PNG</option>
                            <option>JPEG</option>
                            <option>WebP</option>
                            <option>PDF</option>
                        </select>
                    </div>

                    <div class="flex gap-4">
                        <button id="download-btn"
                            class="flex items-center bg-green-500 hover:bg-green-600 text-white px-5 py-3 rounded-xl shadow-md transition-transform hover:scale-105">
                            <i class="fa-solid fa-download mr-2"></i> Download Grafik
                        </button>
                        <button onclick="window.print()"
                            class="flex items-center bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-3 rounded-xl shadow-md transition-transform hover:scale-105">
                            <i class="fa-solid fa-print mr-2"></i> Cetak Laporan
                        </button>
                    </div>
                </div>

            </div>
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

        // Tentukan warna berdasarkan tipe chart
        const colors = ['#3B82F6', '#9333EA', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#A3A3A3', '#F472B6'];
        const singleColor = '#3B82F6'; // warna default untuk line chart

        const datasetConfig = {
            label: chartLabel + " | status kerja : " + selectedStatus,
            data: datacounts,
            borderColor: singleColor,
            backgroundColor: type === 'line' ? 'transparent' : colors,
            fill: false,
            tension: 0.3,
            pointBackgroundColor: singleColor,
            pointBorderColor: '#fff',
            borderWidth: 3
        };

        chart = new Chart(ctx, {
            type: type,
            data: {
            labels: datalabels,
            datasets: [datasetConfig]
            },
            options: {
            responsive: true,
            animation: { duration: 1000, easing: 'easeOutBounce' },
            plugins: {
                legend: { labels: { color: '#374151' } },
                tooltip: {
                backgroundColor: '#f9fafb',
                titleColor: '#1f2937',
                bodyColor: '#1f2937'
                }
            },
            scales: {
                x: {
                ticks: { color: '#4B5563' },
                grid: { color: 'rgba(0,0,0,0.05)' }
                },
                y: {
                ticks: { color: '#4B5563' },
                grid: { color: 'rgba(0,0,0,0.05)' }
                }
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
      window.addEventListener('resize', () => {
        if (chart) {
            chart.resize();
        }
    });


    </script>
</x-app-layout>
