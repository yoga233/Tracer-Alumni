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
                <form action="{{ route('admin.questions.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <!-- Pertanyaan -->
                    <div>
                        <label for="question_text" class="block text-sm font-medium text-gray-700">Pertanyaan</label>
                        <input type="text" name="question_text" id="question_text" value="{{ old('question_text') }}" required
                            class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400">
                        @error('question_text')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tipe Pertanyaan -->
                    <div>
                        <label for="question_type_id" class="block text-sm font-medium text-gray-700">Tipe Pertanyaan</label>
                        <select name="question_type_id" id="question_type_id" required
                            class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white">
                            <option value="">Pilih Tipe</option>
                            @foreach ($questionTypes as $type)
                                <option value="{{ $type->id }}" {{ old('question_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('question_type_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Opsi Jawaban -->
                    <div id="options-container" class="hidden">
                        <label class="block text-sm font-medium text-gray-700">Opsi Jawaban</label>
                        <div id="options-list" class="space-y-2 mt-2">
                            <div class="flex items-center gap-2">
                                <input type="text" name="options[]"
                                    class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400"
                                    placeholder="Opsi 1">
                                <button type="button" class="text-red-600 hover:text-red-800 remove-option" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <button type="button" id="add-option"
                            class="mt-3 text-sm text-blue-600 hover:underline">+ Tambah opsi</button>
                    </div>

                    <!-- Opsi Lainnya -->
                    <div id="other-option" class="hidden flex items-center gap-2">
                        <input type="checkbox" name="other_option_enabled" id="other_option_enabled"
                            class="form-checkbox text-blue-600" {{ old('other_option_enabled') ? 'checked' : '' }}>
                        <label for="other_option_enabled" class="text-sm text-gray-700">Sertakan opsi "Lainnya"</label>
                    </div>

                    <!-- Skala -->
                    <div id="scale-container" class="hidden">
                        <label for="scale_range" class="block text-sm font-medium text-gray-700">Skala (misalnya: 1-5)</label>
                        <input type="text" name="scale_range" id="scale_range" value="{{ old('scale_range') }}"
                            class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400"
                            placeholder="Contoh: 1-5">
                        <p class="text-sm text-gray-500 mt-1">Gunakan format rentang, contoh: 1-10</p>
                    </div>

                    <!-- Matriks -->
                    <div id="matrix-container" class="hidden space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kolom</label>
                            <div id="matrix-columns" class="space-y-2 mt-2">
                                <div class="flex items-center gap-2">
                                    <input type="text" name="matrix_columns[]"
                                        class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400"
                                        placeholder="Kolom 1">
                                    <button type="button" class="text-red-600 hover:text-red-800 remove-column" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="button" id="add-column"
                                class="mt-2 text-sm text-blue-600 hover:underline">+ Tambah Kolom</button>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Baris</label>
                            <div id="matrix-rows" class="space-y-2 mt-2">
                                <div class="flex items-center gap-2">
                                    <input type="text" name="matrix_rows[]"
                                        class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400"
                                        placeholder="Baris 1">
                                    <button type="button" class="text-red-600 hover:text-red-800 remove-row" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="button" id="add-row"
                                class="mt-2 text-sm text-blue-600 hover:underline">+ Tambah Baris</button>
                        </div>
                    </div>

                    <!-- Status Kerja -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status Kerja</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 mt-2">
                            @foreach ($employmentStatuses as $status)
                                <label class="flex items-center gap-2 text-sm text-gray-800">
                                    <input type="checkbox" name="employment_conditions[]" value="{{ $status }}"
                                        class="text-blue-600 rounded"
                                        {{ is_array(old('employment_conditions')) && in_array($status, old('employment_conditions')) ? 'checked' : '' }}>
                                    {{ ucfirst($status) }}
                                </label>
                            @endforeach
                        </div>
                        <div class="flex gap-3 mt-3">
                            <button type="button" id="select-all"
                                class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700 transition">Pilih Semua</button>
                            <button type="button" id="reset-all"
                                class="px-3 py-1 text-sm bg-red-500 text-white rounded hover:bg-red-600 transition">Reset</button>
                        </div>
                        @error('employment_conditions')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Wajib Diisi -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Wajib Diisi?</label>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="is_required" id="is_required" value="1"
                                class="form-checkbox text-blue-600" {{ old('is_required') ? 'checked' : '' }}>
                            <label for="is_required" class="text-sm text-gray-700">Ya</label>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="flex justify-end pt-6">
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg shadow-md transition hover:scale-[1.02]">
                            Simpan Pertanyaan
                        </button>
                    </div>
                </form>

                
            </div>
        </div>
    </div>

    {{-- @push('scripts')
        @vite('resources/js/pages/question-form.js')
    @endpush --}}
</x-app-layout>
