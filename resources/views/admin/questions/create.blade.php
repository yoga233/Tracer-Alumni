<x-app-layout>
    <x-slot name="header">
        <div class="mb-6 flex items-start gap-4 animate-fade-in">
            <div class="border-l-4 border-blue-600 pl-4">
                <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-plus-circle text-blue-600"></i>
                    Tambah Pertanyaan Baru
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Masukkan detail pertanyaan baru untuk digunakan dalam survei atau kuesioner.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen text-gray-800">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <form action="{{ route('admin.questions.store') }}" method="POST">
                    @csrf
                    <div class="space-y-6">

                        <!-- Pertanyaan -->
                        <div>
                            <label for="question_text" class="block text-base font-semibold text-gray-700 mb-1">Pertanyaan</label>
                            <input type="text" id="question_text" name="question_text" value="{{ old('question_text') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-500">
                            @error('question_text') 
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tipe Pertanyaan -->
                        <div>
                            <label for="question_type_id" class="block text-base font-semibold text-gray-700 mb-1">Tipe Pertanyaan</label>
                            <select id="question_type_id" name="question_type_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Tipe</option>
                                @foreach ($questionTypes as $type)
                                    <option value="{{ $type->id }}" {{ old('question_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                @endforeach
                            </select>
                            @error('question_type_id') 
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Opsi -->
                        <div id="options-container" class="hidden">
                            <label class="block text-base font-semibold text-gray-700 mb-1">Opsi Jawaban</label>
                            <div id="options-list" class="space-y-2">
                                <div class="flex items-center">
                                    <input type="text" name="options[]" class="flex-1 border-b border-gray-300 focus:border-blue-500 px-2 py-2 placeholder-gray-500 bg-transparent transition" placeholder="Opsi 1">
                                    <button type="button" class="ml-3 remove-option" title="Hapus">
                                        <i class="fas fa-trash text-red-500 hover:text-red-700"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="button" id="add-option" class="mt-2 text-blue-600 hover:underline focus:outline-none">+ Tambah opsi</button>
                        </div>

                        <!-- Opsi "Lainnya" (hanya untuk radio & checkbox) -->
                        <div id="other-option" class="hidden flex items-center gap-2">
                            <input type="checkbox" name="other_option_enabled" id="other_option_enabled" class="form-checkbox text-blue-600" {{ old('other_option_enabled') ? 'checked' : '' }}>
                            <label for="other_option_enabled" class="text-gray-700 select-none">Lainnya</label>
                        </div>




                        <!-- Skala -->
                        <div id="scale-container" class="hidden">
                            <label for="scale_range" class="block text-base font-semibold text-gray-700 mb-1">Skala (misalnya: 1-5)</label>
                            <input type="text" name="scale_range" id="scale_range" value="{{ old('scale_range') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-500"
                                placeholder="Contoh: 1-5">
                            <p class="mt-2 text-sm text-gray-500">Rentang yang digunakan untuk skala penilaian</p>
                        </div>

                        <!-- Matrix -->
                        <div id="matrix-container" class="hidden space-y-6">
                            <div>
                                <label class="block text-base font-semibold text-gray-700 mb-1">Kolom</label>
                                <div id="matrix-columns" class="space-y-2">
                                    <div class="flex items-center">
                                        <input type="text" name="matrix_columns[]" class="flex-1 border-b border-gray-300 focus:border-blue-500 px-2 py-2 placeholder-gray-500 bg-transparent transition" placeholder="Kolom 1">
                                        <button type="button" class="ml-3 remove-column" title="Hapus">
                                            <i class="fas fa-trash text-red-500 hover:text-red-700"></i>
                                        </button>
                                    </div>
                                </div>
                                <button type="button" id="add-column" class="mt-2 text-blue-600 hover:underline focus:outline-none">+ Tambah kolom</button>
                            </div>

                            <div>
                                <label class="block text-base font-semibold text-gray-700 mb-1">Baris</label>
                                <div id="matrix-rows" class="space-y-2">
                                    <div class="flex items-center">
                                        <input type="text" name="matrix_rows[]" class="flex-1 border-b border-gray-300 focus:border-blue-500 px-2 py-2 placeholder-gray-500 bg-transparent transition" placeholder="Baris 1">
                                        <button type="button" class="ml-3 remove-row" title="Hapus">
                                            <i class="fas fa-trash text-red-500 hover:text-red-700"></i>
                                        </button>
                                    </div>
                                </div>
                                <button type="button" id="add-row" class="mt-2 text-blue-600 hover:underline focus:outline-none">+ Tambah baris</button>
                            </div>
                        </div>

                        <!-- Wajib Diisi -->
                        <div>
                            <label class="block text-base font-semibold text-gray-700 mb-1">Wajib Diisi</label>
                            <div class="flex items-center">
                                <input type="checkbox" name="is_required" id="is_required" value="1" class="mr-2" {{ old('is_required') ? 'checked' : '' }}>
                                <label for="is_required" class="text-gray-700">Ya</label>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="flex justify-end pt-4">
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-full shadow-lg transition-all duration-300 transform hover:scale-105">
                                Simpan Pertanyaan
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        @vite('resources/js/pages/question-form.js')
    @endpush
</x-app-layout>
