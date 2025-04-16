<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">
            Daftar Pertanyaan
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-700 dark:text-gray-200">Pertanyaan</h3>
                    <a href="{{ route('admin.questions.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow transition-all">
                        + Tambah Pertanyaan
                    </a>
                </div>

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-gray-600 dark:text-gray-200">
                        <thead class="bg-gray-100 dark:bg-gray-700 uppercase text-xs font-semibold">
                            <tr>
                                <th class="px-6 py-3">No</th>
                                <th class="px-6 py-3">Pertanyaan</th>
                                <th class="px-6 py-3">Tipe</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800">
                            @forelse ($questions as $index => $question)
                                <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4">{{ $question->question_text }}</td>
                                    <td class="px-6 py-4">
                                        {{ $question->type ? $question->type->name : 'Tipe tidak ditemukan' }}
                                    </td>
                                    <td class="px-6 py-4 text-center space-x-2">
                                        <a href="{{ route('admin.questions.edit', $question->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                        <form action="{{ route('admin.questions.destroy', $question->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Belum ada pertanyaan</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
