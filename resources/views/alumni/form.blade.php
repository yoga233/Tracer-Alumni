<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Alumni - Tracer Study ITATS</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen flex flex-col">

    <div class="flex-1 w-full">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header & Logo -->
            <nav class="bg-white shadow-sm py-4 relative">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <img src="{{ asset('assets/OIP.jpg') }}" alt="Logo ITATS" class="h-12 w-12 object-contain">
                            <div>
                                <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Tracer Study Lulusan ITATS</h1>
                                <p class="text-sm text-gray-600">Program Studi Teknik Informatika</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="absolute inset-x-0 bottom-0 mx-auto w-full h-px bg-gray-200"></div>
            </nav>

            <div class="bg-white shadow-sm sm:rounded-lg p-6 mt-6">

                <!-- Box sambutan -->
                <div class="mb-8 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-4 rounded">
                    <h3 class="font-bold text-lg mb-2">Selamat Datang!</h3>
                    <p>Terima kasih atas partisipasi Anda dalam mengisi Tracer Study Lulusan ITATS</p>
                    <p class="mt-2">Tracer study ini hanya untuk program studi / jurusan yang masih aktif. Isi semua pertanyaan sesuai dengan kondisi Anda saat ini.</p>
                    <ul class="list-disc list-inside mt-2 space-y-1">
                        <li>1. Mengevaluasi kualitas program pendidikan di ITATS.</li>
                        <li>2. Memahami pengembangan karir lulusan.</li>
                        <li>3. Meningkatkan kualitas pendidikan dan layanan kemahasiswaan.</li>
                    </ul>
                    <p class="mt-4">Jika ada pertanyaan, hubungi <strong>Pak Isa Albanna</strong> via WA <strong>0858-1568-3477</strong> atau email <strong>isaalbanna@itats.ac.id</strong>.</p>
                </div>

                <p class="text-red-600 font-semibold italic mb-6">* Wajib diisi</p>

                <form action="{{ route('alumni.form.submit') }}" method="POST" class="space-y-6">
                    @csrf
                {{-- === Informasi Alumni === --}}
                  <div class="grid md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block font-semibold text-sm text-gray-700">Nama <span class="text-red-600">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                class="w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:border-blue-500 px-3 py-2">
                            @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="email" class="block font-semibold text-sm text-gray-700">Email <span class="text-red-600">*</span></label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:border-blue-500 px-3 py-2">
                            @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label for="major" class="block font-semibold text-sm text-gray-700">Program Studi / Major <span class="text-red-600">*</span></label>
                            <input type="text" id="major" name="major" value="{{ old('major') }}" required
                                class="w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:border-blue-500 px-3 py-2">
                            @error('major') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="graduation_year" class="block font-semibold text-sm text-gray-700">Tahun Lulus <span class="text-red-600">*</span></label>
                            <input type="number" id="graduation_year" name="graduation_year" min="1900" max="2099" step="1"
                                value="{{ old('graduation_year') }}" required
                                class="w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:border-blue-500 px-3 py-2">
                            @error('graduation_year') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- === Informasi Pekerjaan === --}}
                <div class="grid md:grid-cols-2 gap-6 mt-6">
                    <div class="space-y-4">
                        <div>
                            <label for="employment_status" class="block font-semibold text-sm text-gray-700">Status Pekerjaan <span class="text-red-600">*</span></label>
                            <select id="employment_status" name="employment_status" required
                                class="w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:border-blue-500 px-3 py-2">
                                <option value="" disabled {{ old('employment_status') ? '' : 'selected' }}>- Pilih Status -</option>
                                @foreach(['Belum Bekerja', 'Bekerja', 'Wirausaha', 'Freelance', 'Studi Lanjut'] as $status)
                                    <option value="{{ $status }}" {{ old('employment_status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                                @endforeach
                            </select>
                            @error('employment_status') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="mounth_waiting" class="block font-semibold text-sm text-gray-700">Waktu Tunggu <span class="text-red-600">*</span></label>
                            <select id="mounth_waiting" name="mounth_waiting" required
                                class="w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:border-blue-500 px-3 py-2">
                                <option value="" disabled {{ old('mounth_waiting') ? '' : 'selected' }}>- Pilih Waktu Tunggu -</option>
                                @foreach(['<= 3 bulan', '<= 6 bulan', '<= 9 bulan', '<= 12 bulan'] as $mw)
                                    <option value="{{ $mw }}" {{ old('mounth_waiting') == $mw ? 'selected' : '' }}>{{ $mw }}</option>
                                @endforeach
                            </select>
                            @error('mounth_waiting') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="type_company" class="block font-semibold text-sm text-gray-700">Jenis Perusahaan <span class="text-red-600">*</span></label>
                            <select id="type_company" name="type_company" required
                                class="w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:border-blue-500 px-3 py-2">
                                <option value="" disabled {{ old('type_company') ? '' : 'selected' }}>- Pilih Jenis -</option>
                                @foreach(['Lokal', 'Nasional', 'Internasional'] as $tc)
                                    <option value="{{ $tc }}" {{ old('type_company') == $tc ? 'selected' : '' }}>{{ $tc }}</option>
                                @endforeach
                            </select>
                            @error('type_company') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="closeness_workfield" class="block font-semibold text-sm text-gray-700">Keterkaitan dengan Bidang Ilmu <span class="text-red-600">*</span></label>
                            <select id="closeness_workfield" name="closeness_workfield" required
                                class="w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:border-blue-500 px-3 py-2">
                                <option value="" disabled {{ old('closeness_workfield') ? '' : 'selected' }}>- Pilih Tingkat Keterkaitan -</option>
                                @foreach(['Sangat erat', 'Erat', 'Cukup erat', 'Tidak erat'] as $cw)
                                    <option value="{{ $cw }}" {{ old('closeness_workfield') == $cw ? 'selected' : '' }}>{{ $cw }}</option>
                                @endforeach
                            </select>
                            @error('closeness_workfield') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label for="phone_number" class="block font-semibold text-sm text-gray-700">Nomor Telepon <span class="text-red-600">*</span></label>
                            <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required
                                class="w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:border-blue-500 px-3 py-2">
                            @error('phone_number') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="address" class="block font-semibold text-sm text-gray-700">Alamat <span class="text-red-600">*</span></label>
                            <textarea id="address" name="address" rows="3" required
                                class="w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:border-blue-500 px-3 py-2">{{ old('address') }}</textarea>
                            @error('address') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>


                  {{-- Tempat semua pertanyaan akan dirender --}}
                    <div id="questionContainer">
                    </div>

                    {{-- === Kompetensi saat Lulus === --}}
                    <div class="mt-8">
                        <h3 class="text-lg font-bold mb-4">Kompetensi saat Lulus</h3>
                        <div class="grid md:grid-cols-2 gap-6">
                            @foreach($kompetensiFields as $field => $label)
                                <div>
                                    <label class="block font-semibold text-sm text-gray-700">{{ $label }}</label>
                                    <select name="graduate_competency[{{ $field }}]" required
                                        class="w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:border-blue-500 px-3 py-2">
                                        <option value="" disabled {{ old("graduate_competency.$field") ? '' : 'selected' }}>-- Pilih --</option>
                                        @foreach($kompetensiOptions as $opt)
                                            <option value="{{ $opt }}" {{ old("graduate_competency.$field") == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                        @endforeach
                                    </select>
                                    @error("graduate_competency.$field")
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- === Kompetensi di Tempat Kerja === --}}
                    <div class="mt-8">
                        <h3 class="text-lg font-bold mb-4">Kompetensi di Tempat Kerja</h3>
                        <div class="grid md:grid-cols-2 gap-6">
                            @foreach($kompetensiFields as $field => $label)
                                <div>
                                    <label class="block font-semibold text-sm text-gray-700">{{ $label }}</label>
                                    <select name="work_competency[{{ $field }}]" required
                                        class="w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:border-blue-500 px-3 py-2">
                                        <option value="" disabled {{ old("work_competency.$field") ? '' : 'selected' }}>-- Pilih --</option>
                                        @foreach($kompetensiOptions as $opt)
                                            <option value="{{ $opt }}" {{ old("work_competency.$field") == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                        @endforeach
                                    </select>
                                    @error("work_competency.$field")
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endforeach
                        </div>
                    </div>


                    <div class="flex justify-end pt-4">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-md shadow-md transition">
                            Kirim Formulir
                        </button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>

</body>
</html>
<script>
    
function toggleOtherRadioInput(inputId, radioEl, inputName) {
    const input = document.getElementById(inputId);
    if (!input) return;

    if (radioEl.checked) {
        input.classList.remove('hidden');
        input.name = inputName;

        const radios = document.querySelectorAll(`input[type=radio][name="${inputName}"]`);
        radios.forEach(r => {
            if (r !== radioEl) {
                r.removeAttribute('name');
            }
        });
    } else {
        input.classList.add('hidden');
        input.value = '';
        input.removeAttribute('name');

        const radios = document.querySelectorAll(`input[type=radio]`);
        radios.forEach(r => {
            if (!r.hasAttribute('name')) {
                r.name = inputName;
            }
        });
    }
}

function toggleOtherCheckboxInput(inputId, checkboxEl, inputName) {
    const input = document.getElementById(inputId);
    if (!input) return;

    if (checkboxEl.checked) {
        input.classList.remove('hidden');
        input.name = inputName + '[]';
    } else {
        input.classList.add('hidden');
        input.value = '';
        input.removeAttribute('name');
    }
}

function toggleOtherSelect(selectId, inputId, inputName) {
    const select = document.getElementById(selectId);
    const input = document.getElementById(inputId);
    if (!select || !input) return;

    if (select.value === 'lainnya') {
        input.classList.remove('hidden');
        input.name = inputName;
        select.removeAttribute('name');
        select.value = '';
    } else {
        input.classList.add('hidden');
        input.value = '';
        input.removeAttribute('name');
        select.name = inputName;
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const questions = @json($questions);
    const statusSelect = document.getElementById('employment_status');
    const questionContainer = document.getElementById('questionContainer');

    if (!statusSelect || !questionContainer) return;

    statusSelect.addEventListener('change', function () {
        const selectedStatus = this.value;
        const filteredQuestions = filterQuestionsByStatus(questions, selectedStatus);
        renderQuestions(filteredQuestions);
    });

    function filterQuestionsByStatus(questions, status) {
        return questions.filter(q => {
            if (!q.question_conditions || q.question_conditions.length === 0) return true;
            return q.question_conditions.some(cond =>
                cond.field === 'employment_status' && cond.value_status_kerja === status
            );
        });
    }

    function renderQuestions(questions) {
        questionContainer.innerHTML = '';

        if (!questions.length) {
            questionContainer.innerHTML = '<p class="text-gray-500">Tidak ada pertanyaan untuk status kerja ini.</p>';
            return;
        }

        questions.forEach((question, index) => {
            const wrapper = document.createElement('div');
            wrapper.className = 'question-container space-y-2 mb-6';

            const label = document.createElement('label');
            label.className = 'block font-medium text-gray-700';
             const isRequired = question.is_required === true || question.is_required === 1 || question.is_required === '1' || question.is_required === 'true';
            label.innerHTML = `<span class="font-bold text-lg">${index + 1}.</span> ${question.question_text} ${isRequired ? ' <span class="text-red-600">*</span>' : ''}`;
            wrapper.appendChild(label);
            

            const inputName = `answers[${question.id}]`;
            const type = question.questiontype?.name || 'text';
            const otherInputId = `other-${question.id}`;
            let inputHtml = '';

            if (type === 'text') {
                inputHtml = `<input type="text" name="${inputName}" ${isRequired ? 'required' : ''} class="form-input w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">`;

            } else if (type === 'textarea') {
                inputHtml = `<textarea name="${inputName}" rows="4" ${isRequired ? 'required' : ''} class="form-textarea w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>`;

            } else if (type === 'radio') {
                inputHtml = question.options.map(option => `
                    <label class="inline-flex items-center">
                        <input type="radio" name="${inputName}" value="${option.option_text}" ${isRequired ? 'required' : ''} class="form-radio text-blue-600">
                        <span class="ml-2">${option.option_text}</span>
                    </label><br>`).join('');

                if (question.other_option) {
                    inputHtml += `
                        <label class="inline-flex items-center">
                            <input type="radio" value="lainnya" class="form-radio text-blue-600" onchange="toggleOtherRadioInput('${otherInputId}', this, '${inputName}')">
                            <span class="ml-2">Lainnya</span>
                        </label>
                        <input type="text" id="${otherInputId}" class="form-input w-full mt-2 hidden border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Tuliskan jawaban lain">`;
                }

            } else if (type === 'checkbox') {
                inputHtml = question.options.map(option => `
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="${inputName}[]" value="${option.option_text}" ${isRequired ? 'required' : ''} class="form-checkbox w-5 h-5 text-blue-600">
                        <span class="ml-2">${option.option_text}</span>
                    </label><br>`).join('');

                if (question.other_option) {
                    inputHtml += `
                        <label class="inline-flex items-center">
                            <input type="checkbox" value="lainnya" class="form-checkbox w-5 h-5 text-blue-600" onchange="toggleOtherCheckboxInput('${otherInputId}', this, '${inputName}')">
                            <span class="ml-2">Lainnya</span>
                        </label>
                        <input type="text" id="${otherInputId}" class="form-input w-full mt-2 hidden border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Tuliskan jawaban lain">`;
                }

            } else if (type === 'select') {
                const selectId = `select-${question.id}`;
                inputHtml = `
                    <select id="${selectId}" name="${inputName}" ${isRequired ? 'required' : ''} class="form-select w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" onchange="toggleOtherSelect('${selectId}', '${otherInputId}', '${inputName}')">
                        ${question.options.map(option => `<option value="${option.option_text}">${option.option_text}</option>`).join('')}
                        ${question.other_option ? '<option value="lainnya">Lainnya</option>' : ''}
                    </select>`;

                if (question.other_option) {
                    inputHtml += `
                        <input type="text" id="${otherInputId}" class="form-input w-full mt-2 hidden border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Tuliskan jawaban lain">`;
                }

            } else if (type === 'scale') {
                inputHtml = `<div class="flex gap-4 items-center">` +
                    question.options.map(option => `
                        <label class="flex flex-col items-center">
                            <input type="radio" name="${inputName}" value="${option.option_text}" ${isRequired ? 'required' : ''} class="form-radio text-blue-600">
                            <span class="mt-1 text-sm">${option.option_text}</span>
                        </label>`).join('');

                if (question.other_option) {
                    inputHtml += `
                        <label class="flex flex-col items-center">
                            <input type="radio" value="lainnya" class="form-radio text-blue-600" onchange="toggleOtherRadioInput('${otherInputId}', this, '${inputName}')">
                            <input type="text" id="${otherInputId}" class="form-input mt-2 hidden border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Lainnya">
                        </label>`;
                }

                inputHtml += `</div>`;

            } else if (type === 'matrix') {
                const rows = question.rows || [];
                const columns = question.columns || [];
                inputHtml = `
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pernyataan</th>
                                    ${columns.map(col => `<th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">${col}</th>`).join('')}
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                ${rows.map(row => `
                                    <tr>
                                        <td class="px-4 py-2 text-sm font-semibold text-gray-700">${row}</td>
                                        ${columns.map(col => `
                                            <td class="px-4 py-2 text-center">
                                                <input type="radio" name="${inputName}[${row}]" value="${col}" ${isRequired ? 'required' : ''} class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                            </td>`).join('')}
                                    </tr>`).join('')}
                            </tbody>
                        </table>
                    </div>`;
            }

            wrapper.innerHTML += inputHtml;
               // Tambahkan validasi khusus untuk checkbox yang required
                if (type === 'checkbox' && isRequired) {
                    setTimeout(() => {
                        const checkboxes = wrapper.querySelectorAll(`input[type="checkbox"][name="${inputName}[]"]`);

                        // Fungsi pengecekan manual
                        const validateCheckboxes = () => {
                            const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
                            checkboxes.forEach(cb => {
                                cb.setCustomValidity(anyChecked ? '' : 'Silakan pilih minimal satu jawaban.');
                            });
                        };

                        // Panggil saat halaman dimuat
                        validateCheckboxes();

                        // Panggil setiap kali ada perubahan pada checkbox
                        checkboxes.forEach(cb => {
                            cb.addEventListener('change', validateCheckboxes);
                        });

                    }, 0);
                }
            questionContainer.appendChild(wrapper);
        });
    }

    const defaultStatus = statusSelect.value;
    if (defaultStatus) {
        const filtered = filterQuestionsByStatus(questions, defaultStatus);
        renderQuestions(filtered);
    }
});
</script>
