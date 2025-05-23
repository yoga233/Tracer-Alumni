<x-app-layout>
<<<<<<< HEAD
  <x-slot name="header" >
    <h2 class="text-3xl h-8 font-semibold text-gray-100">
      Dashboard Alumni
    </h2>
  </x-slot>
  
  <div class="bg-gray-300 min-h-screen py-8 text-gray-100">
    <div class="max-w-7xl mx-auto px-4">
      <!-- Cards Statistik -->
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gray-200 border-l-4 border-gray-700 p-6 rounded-xl shadow-lg flex items-center justify-between transition-transform hover:scale-105">
          <div>
            <p class="text-sm text-gray-700 font-bold">Total alumni</p>
            <h3 class="text-2xl  text-gray-700 font-bold">{{ $alumni }}</h3>
          </div>
          <span class="text-3xl  bg-gray-300 rounded-lg shadow-lg">👁️</span>
        </div>
        <div class="bg-gray-200 border-l-4 border-gray-700 p-6 rounded-xl shadow-lg flex items-center justify-between transition-transform hover:scale-105">
          <div>
            <p class="text-sm text-gray-700 font-bold">Dummy</p>
            <h3 class="text-2xl  text-gray-700 font-bold">80</h3>
          </div>
          <span class="text-3xl  bg-gray-300 rounded-lg shadow-lg">🛒</span>
        </div>
        <div class="bg-gray-200 border-l-4 border-gray-700 p-6 rounded-xl shadow-lg flex items-center justify-between transition-transform hover:scale-105">
          <div>
            <p class="text-sm text-gray-700 font-bold">Dummy</p>
            <h3 class="text-2xl text-gray-700 font-bold">284</h3>
          </div>
          <span class="text-3xl bg-gray-300 rounded-lg shadow-lg ">💬</span>
        </div>
        <div class="bg-gray-200 border-l-4  border-gray-700 p-6 rounded-xl shadow-lg flex items-center justify-between transition-transform hover:scale-105">
          <div>
            <p class="text-sm text-gray-700 font-bold">Dummy</p>
            <h3 class="text-2xl text-gray-700 font-bold ">$7,842</h3>
          </div>
          <span class="text-3xl  bg-gray-300 rounded-lg shadow-lg ">💵</span>
        </div>
      </div>

     <!-- Charts -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

  <div class=" bg-gray-200 border border-gray-700 p-6 rounded-xl shadow-lg transition-transform hover:scale-105">
    <h3 class="text-lg font-semibold text-gray-700 mb-4 text-center border-b border-gray-700 pb-2">
      📊 Statistik Status Alumni
    </h3>
    <canvas id="pieChart" class="w-full h-64"></canvas>
    @if($employment_status->isEmpty())
      <p class="text-center text-gray-700 mt-4 italic">Data alumni belum tersedia..</p>
    @endif
    <button id="downloadPieChart" class="mt-4 bg-indigo-600 hover:bg-indigo-700  py-2 px-6 rounded-lg shadow-md transition">
      Download Pie Chart
    </button>
  </div>

  <div class="bg-gray-200 border border-gray-700 p-6 rounded-xl shadow-lg transition-transform hover:scale-105">
    <h3 class="text-lg font-semibold text-gray-700 mb-4 text-center border-b border-gray-700 pb-2">
      📊 Jumlah Alumni per Status Pekerjaan
    </h3>
    <canvas id="barChart" class="w-full h-64"></canvas>
    <button id="downloadBarChart" class="mt-4  bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-6 rounded-lg shadow-md transition">
      Download Bar Chart
    </button>
  </div>

  <div class="bg-gray-200 border border-gray-700 p-6 rounded-xl shadow-lg transition-transform hover:scale-105">
    <h3 class="text-lg font-semibold text-gray-700 mb-4 text-center border-b border-gray-700 pb-2">
      📈 Perkembangan Alumni per Angkatan
    </h3>
    <canvas id="lineChart" class="w-full h-64"></canvas>
    <button id="downloadLineChart" class="mt-4  bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-6 rounded-lg shadow-md transition">
      Download Line Chart
    </button>
  </div>

  <div class="bg-gray-200 border border-gray-700 p-6 rounded-xl shadow-lg transition-transform hover:scale-105">
    <h3 class="text-lg font-semibold text-gray-700 mb-4 text-center border-b border-gray-700 pb-2">
      🧭 Perbandingan Alumni Berdasarkan Jurusan
    </h3>
    <canvas id="radarChart" class="w-full h-64"></canvas>
    <button id="downloadRadarChart" class="mt-4  bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-6 rounded-lg shadow-md transition">
      Download Radar Chart
    </button>
  </div>
=======
  <x-slot name="header">
    <div class="mb-6 flex flex-col gap-2 animate-fancy-in">
      <div class="flex items-center gap-3">
        <i class="fas fa-tachometer-alt text-blue-600 text-3xl"></i>
        <div>
          <h2 class="text-3xl font-bold text-gray-800">
            Dashboard Alumni
          </h2>
          <p class="text-sm text-gray-600 mt-1">
            Selamat datang di panel kontrol alumni, kelola data dan informasi dengan mudah.
          </p>
        </div>
      </div>
      <!-- Garis pemisah -->
      <div class="border-b-2 border-blue-600 w-32"></div>
>>>>>>> new-layout
</div>


  </x-slot>

  <div class="bg-gray-50 min-h-screen py-8 text-gray-800">
    <div class="max-w-7xl mx-auto px-4">

      <!-- Statistik Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white border-l-4 border-indigo-500 p-6 rounded-xl shadow hover:shadow-md transition-transform hover:scale-[1.02] flex items-center justify-between">
          <div>
            <p class="text-sm text-gray-500">Total Alumni</p>
            <h3 class="text-2xl font-bold">{{ $alumni }}</h3>
          </div>
          <span class="text-3xl text-indigo-500">👥</span>
        </div>

        <div class="bg-white border-l-4 border-green-500 p-6 rounded-xl shadow hover:shadow-md transition-transform hover:scale-[1.02] flex items-center justify-between">
          <div>
            <p class="text-sm text-gray-500">Pendaftaran</p>
            <h3 class="text-2xl font-bold">80</h3>
          </div>
          <span class="text-3xl text-green-500">🛒</span>
        </div>

        <div class="bg-white border-l-4 border-yellow-500 p-6 rounded-xl shadow hover:shadow-md transition-transform hover:scale-[1.02] flex items-center justify-between">
          <div>
            <p class="text-sm text-gray-500">Komentar</p>
            <h3 class="text-2xl font-bold">284</h3>
          </div>
          <span class="text-3xl text-yellow-500">💬</span>
        </div>

        <div class="bg-white border-l-4 border-pink-500 p-6 rounded-xl shadow hover:shadow-md transition-transform hover:scale-[1.02] flex items-center justify-between">
          <div>
            <p class="text-sm text-gray-500">Penghasilan</p>
            <h3 class="text-2xl font-bold">$7,842</h3>
          </div>
          <span class="text-3xl text-pink-500">💵</span>
        </div>
      </div>

      <!-- Charts -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        @php
          $cardClass = "bg-white border border-gray-200 p-6 rounded-xl shadow hover:shadow-md transition-transform hover:scale-[1.02]";
          $titleClass = "text-lg font-semibold text-gray-800 mb-4 text-center border-b border-gray-200 pb-2";
          $buttonClass = "mt-4 bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded-lg shadow transition";
        @endphp

        <div class="{{ $cardClass }}">
          <h3 class="{{ $titleClass }}">📊 Status Alumni</h3>
          <canvas id="pieChart" class="w-full h-64"></canvas>
          @if($employment_status->isEmpty())
            <p class="text-center text-gray-500 mt-4 italic">Data alumni belum tersedia..</p>
          @endif
          <button id="downloadPieChart" class="{{ $buttonClass }}">Download Pie Chart</button>
        </div>

        <div class="{{ $cardClass }}">
          <h3 class="{{ $titleClass }}">📊 Jumlah Alumni per Status Pekerjaan</h3>
          <canvas id="barChart" class="w-full h-64"></canvas>
          <button id="downloadBarChart" class="{{ str_replace('bg-blue', 'bg-green', $buttonClass) }}">Download Bar Chart</button>
        </div>

        <div class="{{ $cardClass }}">
          <h3 class="{{ $titleClass }}">📈 Perkembangan Alumni per Angkatan</h3>
          <canvas id="lineChart" class="w-full h-64"></canvas>
          <button id="downloadLineChart" class="{{ str_replace('bg-blue', 'bg-yellow', $buttonClass) }}">Download Line Chart</button>
        </div>

        <div class="{{ $cardClass }}">
          <h3 class="{{ $titleClass }}">🧭 Perbandingan Alumni per Jurusan</h3>
          <canvas id="radarChart" class="w-full h-64"></canvas>
          <button id="downloadRadarChart" class="{{ str_replace('bg-blue', 'bg-pink', $buttonClass) }}">Download Radar Chart</button>
        </div>

      </div>

    </div>
  </div>

  <!-- Script (tetap pakai Chart.js dan jsPDF) -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
<<<<<<< HEAD
      const darkTick = '#000';
      const darkGrid = 'rgba(229,231,235,0.2)';
      const cfg = (ctx, type, data, opts) => new Chart(ctx, { type, data, options: opts });
  
      const pieCtx = document.getElementById('pieChart').getContext('2d');
      cfg(pieCtx, 'pie', {
        labels: @json($employment_status->keys()), 
        datasets: [{
          data: @json($employment_status->values()),
          backgroundColor: ['#6399', '#10B981', '#FBBF24', '#EC4899', '#3B82F6']
        }]
      }, {
        plugins: { legend: { labels: { color: darkTick } } }
      });
  
      const barCtx = document.getElementById('barChart').getContext('2d');
      cfg(barCtx, 'bar', {
=======
      const textColor = '#374151'; // text-gray-700
      const gridColor = 'rgba(55,65,81,0.1)'; // lighter gray

      const createChart = (ctx, type, data, options) => new Chart(ctx, { type, data, options });

      // PIE
      createChart(document.getElementById('pieChart'), 'pie', {
>>>>>>> new-layout
        labels: @json($employment_status->keys()),
        datasets: [{
          data: @json($employment_status->values()),
          backgroundColor: ['#60A5FA', '#34D399', '#FBBF24', '#F472B6', '#818CF8']
        }]
      }, {
        plugins: { legend: { labels: { color: textColor } } }
      });

      // BAR
      createChart(document.getElementById('barChart'), 'bar', {
        labels: @json($employment_status->keys()),
        datasets: [{
          label: 'Status',
          data: @json($employment_status->values()),
          backgroundColor: ['#3B82F6', '#10B981', '#F59E0B', '#EC4899', '#8B5CF6']
        }]
      }, {
        scales: {
          x: { ticks: { color: textColor }, grid: { color: gridColor } },
          y: { beginAtZero: true, ticks: { color: textColor }, grid: { color: gridColor } }
        },
        plugins: { legend: { labels: { color: textColor } } }
      });

      // LINE
      createChart(document.getElementById('lineChart'), 'line', {
        labels: @json($graduationChart->keys()),
        datasets: [{
          label: 'Jumlah Alumni per Angkatan',
          data: @json($graduationChart->values()),
          borderColor: '#3B82F6',
          backgroundColor: 'rgba(59,130,246,0.1)',
          fill: true,
          tension: 0.4
        }]
      }, {
        scales: {
          x: { ticks: { color: textColor }, grid: { color: gridColor } },
          y: { beginAtZero: true, ticks: { color: textColor }, grid: { color: gridColor } }
        },
        plugins: { legend: { labels: { color: textColor } } }
      });

<<<<<<< HEAD
        const radarCtx = document.getElementById('radarChart').getContext('2d');
        cfg(radarCtx, 'radar', {
          labels: @json($majorChart->keys()),
          datasets: [{
            label: 'Jumlah Alumni per Jurusan',
            data: @json($majorChart->values()),
            borderColor: '#6366F1',
            backgroundColor: 'rgba(99,102,241,0.2)',
            fill: true
          }]
        }, {
          plugins: {
            legend: {
              labels: {
                color: darkTick
              }
            }
          },
          scales: {
            r: {
              pointLabels: {
                color: darkTick,
                font: { size: 14 }
              },
              ticks: {
                color: darkTick
              },
              grid: {
                color: '#000'
              }
            }
=======
      // RADAR
      createChart(document.getElementById('radarChart'), 'radar', {
        labels: @json($majorChart->keys()),
        datasets: [{
          label: 'Alumni per Jurusan',
          data: @json($majorChart->values()),
          borderColor: '#3B82F6',
          backgroundColor: 'rgba(59,130,246,0.2)',
          fill: true
        }]
      }, {
        plugins: { legend: { labels: { color: textColor } } },
        scales: {
          r: {
            pointLabels: { color: textColor, font: { size: 13 } },
            ticks: { color: textColor },
            grid: { color: 'rgba(0,0,0,0.1)' }
>>>>>>> new-layout
          }
        }
      });

      // EXPORT CHART
      const { jsPDF } = window.jspdf;
      const downloadChart = (btnId, canvasId, title, filename) => {
        document.getElementById(btnId).addEventListener('click', () => {
          const canvas = document.getElementById(canvasId);
          const pdf = new jsPDF();
          pdf.text(title, 10, 10);
          pdf.addImage(canvas.toDataURL('image/png'), 'PNG', 10, 20, 180, 160);
          pdf.save(filename);
        });
      };

      downloadChart('downloadPieChart', 'pieChart', 'Status Alumni', 'pie_chart.pdf');
      downloadChart('downloadBarChart', 'barChart', 'Alumni per Status Pekerjaan', 'bar_chart.pdf');
      downloadChart('downloadLineChart', 'lineChart', 'Perkembangan Alumni', 'line_chart.pdf');
      downloadChart('downloadRadarChart', 'radarChart', 'Perbandingan Jurusan', 'radar_chart.pdf');
    });
  </script>
</x-app-layout>
