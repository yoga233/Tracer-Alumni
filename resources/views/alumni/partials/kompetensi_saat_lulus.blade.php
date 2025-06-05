<div class="w-full bg-[#ffffff] p-9 rounded shadow">
  <label class="block font-semibold text-base text-gray-700 mb-4">
    Pada saat lulus, pada tingkat mana kompetensi di bawah ini Anda kuasai?
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
                       name="kompetensi_lulus[{{ $field }}]"
                       value="{{ $opt }}"
                       {{ old("kompetensi_lulus.$field") === $opt ? 'checked' : '' }}
                       required
                       class="form-radio text-blue-600 focus:ring focus:ring-blue-300">
              </td>
            @endforeach
          </tr>
        @endforeach
      </tbody>
    </table>

    {{-- Tampilkan pesan error per field --}}
    @foreach ($kompetensiFields as $field => $label)
      @error("kompetensi_lulus.$field")
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
      @enderror
    @endforeach
  </div>
</div>
