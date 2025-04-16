<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">
            Tambah Pertanyaan Baru
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">

                <!-- Form untuk menambahkan pertanyaan -->
                <form action="{{ route('admin.questions.store') }}" method="POST">
                    @csrf
                    <div class="space-y-6">

                        <!-- Pertanyaan -->
                        <div>
                            <label for="question_text" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Pertanyaan</label>
                            <input type="text" id="question_text" name="question_text" value="{{ old('question_text') }}" required
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                            @error('question_text') 
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tipe Pertanyaan -->
                        <div>
                            <label for="question_type_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Tipe Pertanyaan</label>
                            <select id="question_type_id" name="question_type_id" required
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                                <option value="">Pilih Tipe</option>
                                @foreach ($questionTypes as $type)
                                    <option value="{{ $type->id }}" {{ old('question_type_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('question_type_id') 
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Opsi (untuk radio, checkbox, select) -->
                        <div id="options-container" class="hidden">
                            <label for="options" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Opsi Jawaban (pisahkan dengan koma)</label>
                            <textarea id="options" name="options" rows="3"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">{{ old('options') }}</textarea>
                        </div>

                        <!-- Skala (untuk scale) -->
                        <div id="scale-container" class="hidden">
                            <label for="scale_range" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Rentang Skala (contoh: 1-5)</label>
                            <input type="text" name="scale_range" id="scale_range"
                                value="{{ old('scale_range') }}"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
                                placeholder="Contoh: 1-5">
                        </div>

                        <!-- Matrix (untuk matrix) -->
                        <div id="matrix-container" class="hidden">
                            <label for="matrix_rows" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Baris Matrix (pisahkan dengan koma)</label>
                            <textarea name="matrix_rows" id="matrix_rows" rows="2"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">{{ old('matrix_rows') }}</textarea>

                            <label for="matrix_columns" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mt-4">Kolom Matrix (pisahkan dengan koma)</label>
                            <textarea name="matrix_columns" id="matrix_columns" rows="2"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">{{ old('matrix_columns') }}</textarea>
                        </div>

                        <!-- Label Skala (untuk scale) -->
                        <div id="scale-labels-container" class="hidden mt-4">
                            <label for="scale_labels" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Label Skala (Pisahkan dengan koma)</label>
                            <textarea id="scale_labels" name="scale_labels" rows="2"
                                class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">{{ old('scale_labels') }}</textarea>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow-md">
                                Simpan Pertanyaan
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Script untuk toggle input berdasarkan tipe pertanyaan -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const typeSelect = document.getElementById('question_type_id');
            const optionsContainer = document.getElementById('options-container');
            const scaleContainer = document.getElementById('scale-container');
            const matrixContainer = document.getElementById('matrix-container');
            const scaleLabelsContainer = document.getElementById('scale-labels-container');

            const showOptions = ['radio', 'checkbox', 'select'];
            const showScale = ['scale'];
            const showMatrix = ['matrix'];

            function toggleFields() {
                const selected = typeSelect.options[typeSelect.selectedIndex]?.text.toLowerCase() || '';

                optionsContainer.classList.toggle('hidden', !showOptions.includes(selected));
                scaleContainer.classList.toggle('hidden', !showScale.includes(selected));
                matrixContainer.classList.toggle('hidden', !showMatrix.includes(selected));
                scaleLabelsContainer.classList.toggle('hidden', selected !== 'scale');
            }

            toggleFields(); // jalankan saat load
            typeSelect.addEventListener('change', toggleFields);
        });
    </script>
</x-app-layout>
