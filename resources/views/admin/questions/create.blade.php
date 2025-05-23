<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-semibold text-gray-800 dark:text-gray-100">
            Tambah Pertanyaan Baru
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6">

                <form action="{{ route('admin.questions.store') }}" method="POST">
                    @csrf
                    <div class="space-y-6">

                        <!-- Pertanyaan -->
                        <div>
                            <label for="question_text" class="block text-lg font-medium text-gray-700 dark:text-gray-200">Pertanyaan</label>
                            <input type="text" id="question_text" name="question_text" value="{{ old('question_text') }}" required
                                class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-md shadow-md focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 placeholder-gray-500">
                            @error('question_text') 
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tipe Pertanyaan -->
                        <div>
                            <label for="question_type_id" class="block text-lg font-medium text-gray-700 dark:text-gray-200">Tipe Pertanyaan</label>
                            <select id="question_type_id" name="question_type_id" required
                                class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-md shadow-md focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                                <option value="">Pilih Tipe</option>
                                @foreach ($questionTypes as $type)
                                    <option value="{{ $type->id }}" {{ old('question_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                @endforeach
                            </select>
                            @error('question_type_id') 
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Opsi (untuk radio, checkbox, select) -->
                        <div id="options-container" class="hidden">
                            <label for="options" class="block text-lg font-medium text-gray-700 dark:text-gray-200">Opsi Jawaban</label>
                            <div id="options-list" class="space-y-2">
                                <div class="flex items-center">
                                    <input type="text" name="options[]" class="flex-1 border-b border-gray-300 focus:border-blue-500 px-1 py-2 bg-transparent placeholder-gray-500 dark:placeholder-gray-400 transition" placeholder="Opsi 1">
                                    <button type="button" class="ml-3 remove-option" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500 hover:text-red-700 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <button type="button" id="add-option" class="mt-2 text-blue-600 hover:underline focus:outline-none">
                                + Tambah opsi
                            </button>
                        </div>

                        <!-- Skala (untuk scale) -->
                        <div id="scale-container" class="hidden">
                            <label for="scale_range" class="block text-lg font-medium text-gray-700 dark:text-gray-200">Skala (misalnya: 1-5)</label>
                            <input type="text" name="scale_range" id="scale_range"
                                value="{{ old('scale_range') }}"
                                class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-md shadow-md focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
                                placeholder="Contoh: 1-5">
                            <p class="mt-2 text-sm text-gray-500">Rentang yang digunakan untuk skala penilaian</p>
                        </div>

                       {{-- Matrix --}}
                        <div id="matrix-container" class="hidden space-y-6">
                            <div>
                                <label class="block text-lg font-medium text-gray-700 dark:text-gray-200">Kolom</label>
                                <div id="matrix-columns" class="space-y-2">
                                    <div class="flex items-center">
                                        <input type="text" name="matrix_columns[]" class="flex-1 border-b border-gray-300 focus:border-blue-500 px-1 py-2 bg-transparent placeholder-gray-500 dark:placeholder-gray-400 transition" placeholder="Kolom 1">
                                        <button type="button" class="ml-3 remove-column" title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500 hover:text-red-700 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <button type="button" id="add-column" class="mt-2 text-blue-600 hover:underline focus:outline-none">+ Tambah kolom</button>
                            </div>

                            <div>
                                <label class="block text-lg font-medium text-gray-700 dark:text-gray-200">Baris</label>
                                <div id="matrix-rows" class="space-y-2">
                                    <div class="flex items-center">
                                        <input type="text" name="matrix_rows[]" class="flex-1 border-b border-gray-300 focus:border-blue-500 px-1 py-2 bg-transparent placeholder-gray-500 dark:placeholder-gray-400 transition" placeholder="Baris 1">
                                        <button type="button" class="ml-3 remove-row" title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500 hover:text-red-700 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <button type="button" id="add-row" class="mt-2 text-blue-600 hover:underline focus:outline-none">+ Tambah baris</button>
                            </div>
                        </div>


                        {{-- Wajib diisi --}}
                        <div class="mt-4"></div>
                            <label class="block text-lg font-medium text-gray-700 dark:text-gray-200">Wajib Diisi</label>
                            <div class="flex items-center">
                                <input type="checkbox" name="is_required" id="is_required" value="1" class="mr-2" {{ old('is_required') ? 'checked' : '' }}>
                                <label for="is_required" class="text-gray-700 dark:text-gray-200">Ya</label>
                            </div>
                        
                        <!-- Tombol Submit -->
                        <div class="flex justify-end mt-6">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full shadow-lg transition-all duration-300 transform hover:scale-105">
                                Simpan Pertanyaan
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        const typeSelect = document.getElementById('question_type_id');
        const optionsContainer = document.getElementById('options-container');
        const optionsList = document.getElementById('options-list');
        const addOptionBtn = document.getElementById('add-option');
        const scaleContainer = document.getElementById('scale-container');

        const matrixContainer = document.getElementById('matrix-container');
        const matrixColumns = document.getElementById('matrix-columns');
        const matrixRows = document.getElementById('matrix-rows');
        const addColumnBtn = document.getElementById('add-column');
        const addRowBtn = document.getElementById('add-row');

        const showOptions = ['radio', 'checkbox', 'select'];
        const showScale = ['scale'];

        function toggleFields() {
            const selected = typeSelect.options[typeSelect.selectedIndex]?.text.toLowerCase() || '';

            if (showOptions.includes(selected)) {
                optionsContainer.classList.remove('hidden');
            } else {
                optionsContainer.classList.add('hidden');
            }

            if (showScale.includes(selected)) {
                scaleContainer.classList.remove('hidden');
            } else {
                scaleContainer.classList.add('hidden');
            }
        }

        toggleFields(); // initial check saat halaman load
        typeSelect.addEventListener('change', toggleFields);

        addOptionBtn.addEventListener('click', () => {
            const count = optionsList.querySelectorAll('input[name="options[]"]').length + 1;
            optionsList.appendChild(createOptionInput(count));
        });

        optionsList.addEventListener('click', e => {
            if (e.target.closest('.remove-option')) {
                const container = e.target.closest('div.flex');
                container.remove();
                optionsList.querySelectorAll('input[name="options[]"]').forEach((inp, i) => {
                    inp.placeholder = `Opsi ${i + 1}`;
                });
            }
        });

        function createOptionInput(index) {
            const wrapper = document.createElement('div');
            wrapper.className = 'flex items-center';
            wrapper.innerHTML = `
                <input 
                    type="text" 
                    name="options[]" 
                    class="flex-1 border-b border-gray-300 focus:border-blue-500 px-1 py-2 bg-transparent placeholder-gray-500 dark:placeholder-gray-400 transition" 
                    placeholder="Opsi ${index}"
                >
                <button type="button" class="ml-3 remove-option" title="Hapus">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500 hover:text-red-700 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                    </svg>
                </button>
            `;
            return wrapper;
        }
    });
</script> --}}

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const typeSelect = document.getElementById('question_type_id');
        const optionsContainer = document.getElementById('options-container');
        const optionsList = document.getElementById('options-list');
        const addOptionBtn = document.getElementById('add-option');
        const scaleContainer = document.getElementById('scale-container');
        const matrixContainer = document.getElementById('matrix-container');
        const matrixColumns = document.getElementById('matrix-columns');
        const matrixRows = document.getElementById('matrix-rows');
        const addColumnBtn = document.getElementById('add-column');
        const addRowBtn = document.getElementById('add-row');
    
        const showOptions = ['radio', 'checkbox', 'select'];
        const showScale = ['scale'];
        const showMatrix = ['matrix'];
    
        function toggleFields() {
            const selected = typeSelect.options[typeSelect.selectedIndex]?.text.toLowerCase() || '';
    
            if (showOptions.includes(selected)) {
                optionsContainer.classList.remove('hidden');
            } else {
                optionsContainer.classList.add('hidden');
            }
    
            if (showScale.includes(selected)) {
                scaleContainer.classList.remove('hidden');
            } else {
                scaleContainer.classList.add('hidden');
            }
    
            if (showMatrix.includes(selected)) {
                matrixContainer.classList.remove('hidden');
            } else {
                matrixContainer.classList.add('hidden');
            }
        }
    
        toggleFields(); // initial check saat halaman load
        typeSelect.addEventListener('change', toggleFields);
    
        // ================= OPTIONS (radio, checkbox, select) =================
        addOptionBtn?.addEventListener('click', () => {
            const count = optionsList.querySelectorAll('input[name="options[]"]').length + 1;
            optionsList.appendChild(createOptionInput(count));
        });
    
        optionsList?.addEventListener('click', e => {
            if (e.target.closest('.remove-option')) {
                const container = e.target.closest('div.flex');
                container.remove();
                optionsList.querySelectorAll('input[name="options[]"]').forEach((inp, i) => {
                    inp.placeholder = `Opsi ${i + 1}`;
                });
            }
        });
    
        function createOptionInput(index) {
            const wrapper = document.createElement('div');
            wrapper.className = 'flex items-center';
            wrapper.innerHTML = `
                <input 
                    type="text" 
                    name="options[]" 
                    class="flex-1 border-b border-gray-300 focus:border-blue-500 px-1 py-2 bg-transparent placeholder-gray-500 dark:placeholder-gray-400 transition" 
                    placeholder="Opsi ${index}"
                >
                <button type="button" class="ml-3 remove-option" title="Hapus">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500 hover:text-red-700 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                    </svg>
                </button>
            `;
            return wrapper;
        }
    
        // ================= MATRIX (kolom & baris) =================
        addColumnBtn?.addEventListener('click', () => {
            const count = matrixColumns.querySelectorAll('input[name="matrix_columns[]"]').length + 1;
            matrixColumns.appendChild(createMatrixInput('matrix_columns[]', `Kolom ${count}`));
        });
    
        addRowBtn?.addEventListener('click', () => {
            const count = matrixRows.querySelectorAll('input[name="matrix_rows[]"]').length + 1;
            matrixRows.appendChild(createMatrixInput('matrix_rows[]', `Baris ${count}`));
        });
    
        matrixColumns?.addEventListener('click', e => {
            if (e.target.closest('.remove-column')) {
                const container = e.target.closest('div.flex');
                container.remove();
                matrixColumns.querySelectorAll('input[name="matrix_columns[]"]').forEach((inp, i) => {
                    inp.placeholder = `Kolom ${i + 1}`;
                });
            }
        });
    
        matrixRows?.addEventListener('click', e => {
            if (e.target.closest('.remove-row')) {
                const container = e.target.closest('div.flex');
                container.remove();
                matrixRows.querySelectorAll('input[name="matrix_rows[]"]').forEach((inp, i) => {
                    inp.placeholder = `Baris ${i + 1}`;
                });
            }
        });
    
        function createMatrixInput(name, placeholder) {
            const wrapper = document.createElement('div');
            wrapper.className = 'flex items-center';
            wrapper.innerHTML = `
                <input 
                    type="text" 
                    name="${name}" 
                    class="flex-1 border-b border-gray-300 focus:border-blue-500 px-1 py-2 bg-transparent placeholder-gray-500 dark:placeholder-gray-400 transition" 
                    placeholder="${placeholder}"
                >
                <button type="button" class="ml-3 ${name === 'matrix_columns[]' ? 'remove-column' : 'remove-row'}" title="Hapus">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500 hover:text-red-700 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                    </svg>
                </button>
            `;
            return wrapper;
        }
    });
    </script>
    
</x-app-layout>


