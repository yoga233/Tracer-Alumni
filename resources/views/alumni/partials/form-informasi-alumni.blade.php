<div class="space-y-6 w-full">
  <div class="w-full bg-white rounded shadow overflow-hidden">
    <!-- Header Identitas -->
    <div class="bg-orange-700 px-6 py-2">
      <h2 class="text-white text-sm font-semibold">Identitas</h2>
    </div>

    <!-- Isi Form -->
    <div class="p-9">
      <label for="tahun_lulus" class="block font-semibold text-base text-gray-700">
        Tahun Lulus <span class="text-red-600">*</span>
      </label>
      <input type="number" id="tahun_lulus" name="tahun_lulus" min="1900" max="2099"
        value="{{ old('tahun_lulus') }}" required
        class="w-1/2 mt-1 border-0 border-b border-gray-300 focus:ring-0 focus:border-orange-600 py-2 bg-transparent text-base placeholder-gray-500"
        placeholder="Jawaban Anda">
      @error('tahun_lulus') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
  </div>


  <div class="w-full bg-[#ffffff] p-9 rounded shadow">
    <label for="npm" class="block font-semibold text-base text-gray-700">
      Nomor Pokok Mahasiswa (NPM) <span class="text-red-600">*</span>
    </label>
    <input type="text" id="npm" name="npm" value="{{ old('npm') }}" required
      class="w-1/2 mt-1 border-0 border-b border-gray-300 focus:ring-0 focus:border-orange-600 py-2 bg-transparent text-base">
    @error('npm') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
  </div>

  <div class="w-full bg-[#ffffff] p-9 rounded shadow">
    <label for="nama_mahasiswa" class="block font-semibold text-base text-gray-700">
      Nama Mahasiswa <span class="text-red-600">*</span>
    </label>
    <input type="text" id="nama_mahasiswa" name="nama_mahasiswa" value="{{ old('nama_mahasiswa') }}" required
      class="w-1/2 mt-1 border-0 border-b border-gray-300 focus:ring-0 focus:border-orange-600 py-2 bg-transparent text-base">
    @error('nama_mahasiswa') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
  </div>

  <div class="w-full bg-[#ffffff] p-9 rounded shadow">
    <label for="nik" class="block font-semibold text-base text-gray-700">
      NIK / Nomor KTP <span class="text-red-600">*</span>
    </label>
    <input type="text" pattern="\d{16}" id="nik" name="nik" value="{{ old('nik') }}" required
      class="w-1/2 mt-1 border-0 border-b border-gray-300 focus:ring-0 focus:border-orange-600 py-2 bg-transparent text-base">
    @error('nik') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
  </div>

  <div class="w-full bg-[#ffffff] p-9 rounded shadow">
    <label for="tanggal_lahir" class="block font-semibold text-base text-gray-700">
      Tanggal Lahir <span class="text-red-600">*</span>
    </label>
    <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
      class="w-1/2 mt-1 border-0 border-b border-gray-300 focus:ring-0 focus:border-orange-600 py-2 bg-transparent text-base">
    @error('tanggal_lahir') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
  </div>

  <div class="w-full bg-[#ffffff] p-9 rounded shadow">
    <label for="email" class="block font-semibold text-base text-gray-700">
      Alamat Email <span class="text-red-600">*</span>
    </label>
    <input type="email" id="email" name="email" value="{{ old('email') }}" required
      class="w-1/2 mt-1 border-0 border-b border-gray-300 focus:ring-0 focus:border-orange-600 py-2 bg-transparent text-base">
    @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
  </div>

  <div class="w-full bg-[#ffffff] p-9 rounded shadow">
    <label for="nomor_telepon" class="block font-semibold text-base text-gray-700">
      Nomor Telepon / HP
    </label>
    <input type="text" id="nomor_telepon" name="nomor_telepon" value="{{ old('nomor_telepon') }}"
      class="w-1/2 mt-1 border-0 border-b border-gray-300 focus:ring-0 focus:border-orange-600 py-2 bg-transparent text-base">
    @error('nomor_telepon') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
  </div>

  <div class="w-full bg-[#ffffff] p-9 rounded shadow">
    <label for="npwp" class="block font-semibold text-base text-gray-700">
      NPWP
    </label>
    <input type="text" id="npwp" name="npwp" value="{{ old('npwp') }}"
      class="w-1/2 mt-1 border-0 border-b border-gray-300 focus:ring-0 focus:border-orange-600 py-2 bg-transparent text-base">
    @error('npwp') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
  </div>

  <div class="w-full bg-[#ffffff] p-9 rounded shadow">
    <label for="nama_dosen_pembimbing" class="block font-semibold text-base text-gray-700">
      Nama Dosen Pembimbing <span class="text-red-600">*</span>
    </label>
    <input type="text" id="nama_dosen_pembimbing" name="nama_dosen_pembimbing" value="{{ old('nama_dosen_pembimbing') }}" required
      class="w-1/2 mt-1 border-0 border-b border-gray-300 focus:ring-0 focus:border-orange-600 py-2 bg-transparent text-base">
    @error('nama_dosen_pembimbing') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
  </div>

  <div class="w-full bg-[#ffffff] p-9 rounded shadow"> <label class="block font-semibold text-base text-gray-700 mb-2"> Sumber Pembiayaan Kuliah </label> @php $sumberOptions = [ 'Biaya Sendiri / Keluarga', 'Beasiswa ADIK', 'Beasiswa BIDIK MISI', 'Beasiswa PPA', 'Beasiswa AFIRMASI', 'Beasiswa Perusahaan/Swasta', 'Yang lain', ]; $oldValue = old('sumber_pembiayaan_kuliah'); @endphp @foreach ($sumberOptions as $index => $option) <div class="flex items-center mb-2"> <input type="radio" id="sumber_{{ $index }}" name="sumber_pembiayaan_kuliah" value="{{ $option }}" {{ $oldValue === $option ? 'checked' : '' }} class="text-blue-500 focus:ring-blue-500 border-gray-300"> <label for="sumber_{{ $index }}" class="ml-2 text-sm text-gray-700"> {{ $option }} </label> </div> @endforeach <div id="input_lainnya_container" class="{{ $oldValue === 'Yang lain' ? '' : 'hidden' }}"> <label for="sumber_lainnya" class="block mt-2 text-sm text-gray-700"> Tuliskan sumber lainnya: </label> <input type="text" name="sumber_lainnya" id="sumber_lainnya" value="{{ old('sumber_lainnya') }}" class="w-full mt-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-base"> </div> @error('sumber_pembiayaan_kuliah') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror </div>


  <div class="w-full bg-[#ffffff] p-9 rounded shadow">
    <label for="status_saat_ini" class="block font-semibold text-base text-gray-700">
      Status Saat Ini <span class="text-red-600">*</span>
    </label>
        <select id="status_saat_ini" name="status_saat_ini" required
            class="w-1/2 mt-1 border-0 border-b border-gray-300 focus:ring-0 focus:border-orange-600 py-2 bg-transparent text-base">
            <option value="" disabled {{ old('status_saat_ini') ? '' : 'selected' }}>Pilih status</option>
            <option value="Bekerja (full time/part time)" {{ old('status_saat_ini') == 'Bekerja (full time/part time)' ? 'selected' : '' }}>
                Bekerja (full time/part time)
            </option>
            <option value="Belum Memungkinkan Bekerja" {{ old('status_saat_ini') == 'Belum Memungkinkan Bekerja' ? 'selected' : '' }}>
                Belum Memungkinkan Bekerja
            </option>
            <option value="Wiraswasta" {{ old('status_saat_ini') == 'Wiraswasta' ? 'selected' : '' }}>
                Wiraswasta
            </option>
            <option value="Melanjutkan Pendidikan" {{ old('status_saat_ini') == 'Melanjutkan Pendidikan' ? 'selected' : '' }}>
                Melanjutkan Pendidikan
            </option>
            <option value="Tidak Kerja tetapi sedang mencari kerja" {{ old('status_saat_ini') == 'Tidak Kerja tetapi sedang mencari kerja' ? 'selected' : '' }}>
                Tidak Kerja tetapi sedang mencari kerja
            </option>
        </select>

    @error('status_saat_ini') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
  </div>
</div>




<script>
  document.addEventListener('DOMContentLoaded', function () {
    const radios = document.querySelectorAll('input[name="sumber_pembiayaan_kuliah"]');
    const inputLainnya = document.getElementById('input_lainnya_container');

    radios.forEach(radio => {
      radio.addEventListener('change', function () {
        if (this.value === 'Yang lain') {
          inputLainnya.classList.remove('hidden');
        } else {
          inputLainnya.classList.add('hidden');
          document.getElementById('sumber_lainnya').value = '';
        }
      });
    });
  });

  document.addEventListener('DOMContentLoaded', function () {
    const statusSelect = document.getElementById('status_saat_ini');
    const step2 = document.getElementById('step2');

    function updateConditionalQuestions() {
        const selectedStatus = statusSelect.value;
        const allQuestions = step2.querySelectorAll('.conditional-question');

        allQuestions.forEach(q => {
            const expectedValues = q.dataset.conditionValues?.split(',') ?? [];
            
            // Jika tidak ada kondisi atau status yang dipilih termasuk dalam kondisi
            if (expectedValues.length === 0 || expectedValues.includes(selectedStatus)) {
                q.classList.remove('hidden');
            } else {
                q.classList.add('hidden');
            }
        });
    }

    // Panggil saat status berubah
    statusSelect.addEventListener('change', updateConditionalQuestions);
    
    // Panggil saat berpindah halaman
    document.getElementById('nextBtn').addEventListener('click', function() {
        setTimeout(updateConditionalQuestions, 100);
    });

    // Inisialisasi awal
    updateConditionalQuestions();
});
</script>
