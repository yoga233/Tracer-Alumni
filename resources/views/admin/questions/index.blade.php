<x-app-layout>
  <x-slot name="header">
    <div class="mb-6 flex items-start gap-4 animate-fade-in">
      <div class="border-l-4 border-blue-600 pl-4">
        <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
          <i class="fas fa-list-alt text-blue-600"></i>
          Daftar Pertanyaan
        </h2>
        <p class="text-sm text-gray-600 mt-1">
          Lihat dan kelola semua pertanyaan yang tersedia di sistem.
        </p>
      </div>
    </div>
  </x-slot>

  <div class="py-8 bg-gray-50 min-h-screen text-gray-800">
    <div class="max-w-7xl mx-auto px-4">
      <div class="bg-white shadow rounded-xl p-6">

      <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
          
        {{-- Form pencarian --}}
        <form method="GET" action="{{ route('admin.questions.index') }}" class="w-full md:w-auto">
          <div class="flex items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
              placeholder="Cari pertanyaan..." 
              class="w-full md:w-64 px-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
              Cari
            </button>
          </div>
        </form>

        {{-- Tombol Tambah --}}
        <a href="{{ route('admin.questions.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition-all whitespace-nowrap">
          + Tambah Pertanyaan
        </a>
      </div>


        @if (session('success'))
          <div class="mb-4 p-4 bg-green-100 text-green-700 border border-green-300 rounded-md shadow-sm">
            {{ session('success') }}
          </div>
        @endif

        <div class="overflow-x-auto">
          <table class="min-w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-100 text-xs font-semibold text-gray-600 uppercase border-b border-gray-200">
              <tr>
                <th class="px-6 py-3">No</th>
                <th class="px-6 py-3">Pertanyaan</th>
                <th class="px-6 py-3">Tipe</th>
                <th class="px-6 py-3">Wajib</th>
                <th class="px-6 py-3 text-center">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
              @forelse ($questions as $index => $question)
                <tr class="hover:bg-gray-50">
                  {{-- Nomor tetap urut --}}
                  <td class="px-6 py-4">
                    {{ ($questions->currentPage() - 1) * $questions->perPage() + $index + 1 }}
                  </td>
                  <td class="px-6 py-4">{{ $question->question_text }}</td>
                  <td class="px-6 py-4">
                    {{ $question->question_type_id ? $question->questiontype->name : 'Tipe tidak ditemukan' }}
                  </td>
                  <td class="px-6 py-4">
                    <span class="inline-block px-2 py-1 rounded-full text-xs font-medium {{ $question->is_required ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                      {{ $question->is_required ? 'Ya' : 'Tidak' }}
                    </span>
                  </td>
                  <td class="px-6 py-4 text-center space-x-2">
                    <a href="{{ route('admin.questions.edit', $question->id) }}"
                      class="inline-block text-blue-600 hover:text-blue-800 transition">
                      <i class="fas fa-edit"></i>
                    </a>

                    <form action="{{ route('admin.questions.destroy', $question->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="text-red-600 hover:text-red-800 transition">
                        <i class="fas fa-trash-alt"></i>
                      </button>
                    </form>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="px-6 py-4 text-center text-gray-500 italic">Belum ada pertanyaan</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6 flex justify-center">
          {{ $questions->withQueryString()->links('components.pagination-question') }}
        </div>

      </div>
    </div>
  </div>
</x-app-layout>
