<x-app-layout>
  <x-slot name="header">
    <h2 class="text-3xl font-semibold text-gray-100">
      Dashboard Alumni
    </h2>
  </x-slot>

  <div class="bg-gray-900 min-h-screen py-8 text-gray-100">
    <div class="max-w-7xl mx-auto px-4">
      <!-- Cards Statistik -->
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gray-800 border-l-4 border-indigo-500 p-6 rounded-xl shadow-lg flex items-center justify-between transition-transform hover:scale-105">
          <div>
            <p class="text-sm text-gray-400">Daily Views</p>
            <h3 class="text-2xl font-bold">1,504</h3>
          </div>
          <span class="text-3xl">👁️</span>
        </div>
        <div class="bg-gray-800 border-l-4 border-green-500 p-6 rounded-xl shadow-lg flex items-center justify-between transition-transform hover:scale-105">
          <div>
            <p class="text-sm text-gray-400">Sales</p>
            <h3 class="text-2xl font-bold">80</h3>
          </div>
          <span class="text-3xl">🛒</span>
        </div>
        <div class="bg-gray-800 border-l-4 border-yellow-500 p-6 rounded-xl shadow-lg flex items-center justify-between transition-transform hover:scale-105">
          <div>
            <p class="text-sm text-gray-400">Comments</p>
            <h3 class="text-2xl font-bold">284</h3>
          </div>
          <span class="text-3xl">💬</span>
        </div>
        <div class="bg-gray-800 border-l-4 border-pink-500 p-6 rounded-xl shadow-lg flex items-center justify-between transition-transform hover:scale-105">
          <div>
            <p class="text-sm text-gray-400">Earning</p>
            <h3 class="text-2xl font-bold">$7,842</h3>
          </div>
          <span class="text-3xl">💵</span>
        </div>
      </div>

      <!-- Charts -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Pie Chart -->
        <div class="bg-gray-800 border border-gray-700 p-6 rounded-xl shadow-lg transition-transform hover:scale-105">
          <canvas id="pieChart" class="w-full h-64"></canvas>
          <button id="downloadPieChart" class="mt-4 bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-6 rounded-lg shadow-md transition">
            Download Pie Chart
          </button>
        </div>

        <!-- Bar Chart -->
        <div class="bg-gray-800 border border-gray-700 p-6 rounded-xl shadow-lg transition-transform hover:scale-105">
          <canvas id="barChart" class="w-full h-64"></canvas>
          <button id="downloadBarChart" class="mt-4 bg-green-600 hover:bg-green-700 text-white py-2 px-6 rounded-lg shadow-md transition">
            Download Bar Chart
          </button>
        </div>

        <!-- Line Chart -->
        <div class="bg-gray-800 border border-gray-700 p-6 rounded-xl shadow-lg transition-transform hover:scale-105">
          <canvas id="lineChart" class="w-full h-64"></canvas>
          <button id="downloadLineChart" class="mt-4 bg-yellow-600 hover:bg-yellow-700 text-white py-2 px-6 rounded-lg shadow-md transition">
            Download Line Chart
          </button>
        </div>

        <!-- Radar Chart -->
        <div class="bg-gray-800 border border-gray-700 p-6 rounded-xl shadow-lg transition-transform hover:scale-105">
          <canvas id="radarChart" class="w-full h-64"></canvas>
          <button id="downloadRadarChart" class="mt-4 bg-pink-600 hover:bg-pink-700 text-white py-2 px-6 rounded-lg shadow-md transition">
            Download Radar Chart
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Chart.js & jsPDF -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const darkTick = '#E5E7EB';
      const darkGrid = 'rgba(229,231,235,0.2)';
      const cfg = (ctx,type,data,opts) => new Chart(ctx, { type, data, options: opts });

      // Pie Chart
      const pieCtx = document.getElementById('pieChart').getContext('2d');
      cfg(pieCtx, 'pie', {
        labels: ['Facebook','YouTube','Amazon'],
        datasets:[{ data:[300,500,400], backgroundColor:['#6366F1','#10B981','#FBBF24'] }]
      }, {
        plugins:{ legend:{ labels:{ color:darkTick } } }
      });

      // Bar Chart
      const barCtx = document.getElementById('barChart').getContext('2d');
      cfg(barCtx, 'bar', {
        labels: ['Facebook','YouTube','Amazon'],
        datasets:[{ label:'Earnings', data:[700,850,1000], backgroundColor:['#6366F1','#10B981','#FBBF24'] }]
      }, {
        scales: {
          x:{ ticks:{ color:darkTick }, grid:{ color:darkGrid } },
          y:{ beginAtZero:true, ticks:{ color:darkTick }, grid:{ color:darkGrid } }
        },
        plugins:{ legend:{ labels:{ color:darkTick } } }
      });

      // Line Chart
      const lineCtx = document.getElementById('lineChart').getContext('2d');
      cfg(lineCtx, 'line', {
        labels: ['Jan','Feb','Mar','Apr','May'],
        datasets:[{
          label:'Revenue',
          data:[65,59,80,81,56],
          borderColor:'#6366F1',
          backgroundColor:'rgba(99,102,241,0.2)',
          fill:true,
          tension:0.4
        }]
      }, {
        scales: {
          x:{ ticks:{ color:darkTick }, grid:{ color:darkGrid } },
          y:{ beginAtZero:true, ticks:{ color:darkTick }, grid:{ color:darkGrid } }
        },
        plugins:{ legend:{ labels:{ color:darkTick } } }
      });

      // Radar Chart
      const radarCtx = document.getElementById('radarChart').getContext('2d');
      cfg(radarCtx, 'radar', {
        labels: ['Facebook','YouTube','Amazon'],
        datasets:[{
          label:'Earnings',
          data:[400,500,700],
          borderColor:'#6366F1',
          backgroundColor:'rgba(99,102,241,0.2)',
          fill:true
        }]
      }, {
        plugins:{ legend:{ labels:{ color:darkTick } } }
      });

      // PDF Downloads
      const downloads = [
        { btn:'downloadPieChart',       canvas:'pieChart',   title:'Pie Chart - Traffic Source',  file:'pie_chart.pdf' },
        { btn:'downloadBarChart',       canvas:'barChart',   title:'Bar Chart - Earnings',        file:'bar_chart.pdf' },
        { btn:'downloadLineChart',      canvas:'lineChart',  title:'Line Chart - Revenue',        file:'line_chart.pdf' },
        { btn:'downloadRadarChart',     canvas:'radarChart', title:'Radar Chart - Earnings',       file:'radar_chart.pdf' }
      ];
      downloads.forEach(({btn,canvas,title,file}) => {
        document.getElementById(btn).addEventListener('click', () => {
          const { jsPDF } = window.jspdf;
          const doc = new jsPDF();
          const can = document.getElementById(canvas);
          doc.text(title,10,10);
          doc.addImage(can.toDataURL('image/png'),'PNG',10,20,180,160);
          doc.save(file);
        });
      });
    });
  </script>
</x-app-layout>
