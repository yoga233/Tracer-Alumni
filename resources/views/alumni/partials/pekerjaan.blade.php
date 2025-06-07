@php
    $status = old('status_saat_ini', $statusSaatIni ?? null);
@endphp

{{-- Dropdown Waktu Tunggu Mendapatkan Pekerjaan Pertama --}}
<div class="mb-6">
    <label class="block mb-2 font-semibold text-gray-700">
        Berapa lama waktu tunggu Anda untuk mendapatkan pekerjaan pertama setelah lulus?
        <span class="text-red-600">*</span>
    </label>
    <select name="waktu_tunggu_pekerjaan" required class="w-full border-gray-300 rounded shadow-sm">
        <option value="">-- Pilih --</option>
        @foreach([
            'Kurang dari 1 bulan',
            '1 - 3 bulan',
            '4 - 6 bulan',
            '7 - 12 bulan',
            'Lebih dari 1 tahun',
            'Belum mendapatkan pekerjaan'
        ] as $opt)
            <option value="{{ $opt }}" {{ old('waktu_tunggu_pekerjaan') === $opt ? 'selected' : '' }}>
                {{ $opt }}
            </option>
        @endforeach
    </select>
    @error('waktu_tunggu_pekerjaan')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>


{{-- Dropdown Keeratan Studi dan Kerja --}}
<div class="mb-6">
    <label class="block mb-2 font-semibold text-gray-700">
        Seberapa erat bidang studi Anda dengan pekerjaan saat ini?
        <span class="text-red-600">*</span>
    </label>
    <select name="keeratan_bidang_studi[keeratan]" required class="w-full border-gray-300 rounded shadow-sm">
        <option value="">-- Pilih --</option>
        @foreach(['Sangat Erat', 'Erat', 'Cukup Erat', 'Kurang Erat'] as $opsi)
            <option value="{{ $opsi }}" {{ old('keeratan_bidang_studi.keeratan') === $opsi ? 'selected' : '' }}>
                {{ $opsi }}
            </option>
        @endforeach
    </select>
    @error('keeratan_bidang_studi.keeratan')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

{{-- Dropdown Jenis Perusahaan --}}
<div class="mb-6">
    <label class="block mb-2 font-semibold text-gray-700">
        Jenis Perusahaan <span class="text-red-600">*</span>
    </label>
    <select name="jenis_perusahaan" required class="w-full border-gray-300 rounded shadow-sm">
        <option value="">-- Pilih --</option>
        @foreach(['Lokal', 'Nasional', 'Internasional'] as $opsi)
            <option value="{{ $opsi }}" {{ old('jenis_perusahaan') === $opsi ? 'selected' : '' }}>
                {{ $opsi }}
            </option>
        @endforeach
    </select>
    @error('jenis_perusahaan')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

{{-- Kompetensi Kerja --}}
    <div class="w-full bg-[#ffffff] p-9 rounded shadow">
  <label class="block font-semibold text-base text-gray-700 mb-4">
    Dalam pekerjaan Anda saat ini, seberapa penting kompetensi berikut?
    <span class="text-red-600">*</span>
  </label>

  <div class="overflow-x-auto">
    <table class="min-w-full text-sm text-gray-800 border border-gray-300 table-auto">
      <thead class="bg-gray-100 text-center">
        <tr>
          <th class="border px-4 py-2 text-left">Kompetensi</th>
          @foreach ($kompetensiOptions as $opt)
            <th class="border px-4 py-2">{{ $opt }}</th>
          @endforeach
        </tr>
      </thead>
      <tbody>
        @foreach ($kompetensiFields as $field => $label)
          <tr class="even:bg-gray-50">
            <td class="border px-4 py-2">{{ $label }}</td>
            @foreach ($kompetensiOptions as $opt)
              <td class="border px-4 py-2 text-center">
                <input type="radio"
                  name="kompetensi_kerja[{{ $field }}]"
                  value="{{ $opt }}"
                  {{ old("kompetensi_kerja.$field") === $opt ? 'checked' : '' }}
                  required
                  class="form-radio text-blue-600 focus:ring focus:ring-blue-300">
              </td>
            @endforeach
          </tr>
        @endforeach
      </tbody>
    </table>

    {{-- Error per field kompetensi_kerja --}}
    @foreach ($kompetensiFields as $field => $label)
      @error("kompetensi_kerja.$field")
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
      @enderror
    @endforeach
  </div>
</div>

