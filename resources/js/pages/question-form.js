function initOptionAndScale() {
    const typeSelect = document.getElementById('question_type_id');
    const optionsContainer = document.getElementById('options-container');
    const optionsList = document.getElementById('options-list');
    const addOptionBtn = document.getElementById('add-option');
    const scaleContainer = document.getElementById('scale-container');

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

    toggleFields();
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
}

function initMatrix() {
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

    toggleFields(); 
    typeSelect.addEventListener('change', toggleFields);

    // ========== OPTIONS ulang ==========
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

    // ========== MATRIX ==========
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
}

// ✅ DOMContentLoaded satu saja, jalankan dua fungsi:
document.addEventListener('DOMContentLoaded', function () {
    initOptionAndScale();
    initMatrix();

    const questionTypeSelect = document.getElementById('question_type_id');
    const otherOption = document.getElementById('other-option');

    function toggleOtherOption() {
        const selectedType = questionTypeSelect.options[questionTypeSelect.selectedIndex].text.toLowerCase();
        if (selectedType.includes('radio') || selectedType.includes('checkbox')) {
            otherOption.classList.remove('hidden');
        } else {
            otherOption.classList.add('hidden');
            // Kalau opsi lainnya disembunyikan, reset checkboxnya juga supaya tidak tercentang
            const otherCheckbox = otherOption.querySelector('input[type="checkbox"]');
            if (otherCheckbox) {
                otherCheckbox.checked = false;
            }
        }
    }

    questionTypeSelect.addEventListener('change', toggleOtherOption);
    toggleOtherOption(); // Jalankan saat pertama load

});

document.addEventListener('DOMContentLoaded', () => {
    const selectAllBtn = document.getElementById('select-all');
    const resetBtn = document.getElementById('reset-all');
    const checkboxes = document.querySelectorAll('input[name="employment_conditions[]"]');

    selectAllBtn.addEventListener('click', () => {
        checkboxes.forEach(fullchecklist => fullchecklist.checked = true);
    });

    resetBtn.addEventListener('click', () => {
        checkboxes.forEach(reset => reset.checked = false);
    });
});
