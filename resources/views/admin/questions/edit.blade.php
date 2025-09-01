<x-app-layout>
  <x-slot name="header">
    <!-- HEADER: EDIT PERTANYAAN -->
    <div class="mb-6 flex items-start gap-4 animate-fancy-in">
        <div class="border-l-4 border-blue-600 pl-4">
            <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fas fa-edit text-blue-600"></i>
            Edit Pertanyaan
            </h2>
            <p class="text-sm text-gray-600 mt-1">
            Ubah isi, tipe, dan status pertanyaan sesuai kebutuhan data Anda.
            </p>
        </div>
    </div>
  </x-slot>

  <div class="py-8 bg-gray-50 min-h-screen text-gray-800">
    <div class="max-w-4xl mx-auto px-4">
      <div class="bg-white shadow rounded-xl p-6">

        <!-- Form Edit -->
        <form action="{{ route('admin.questions.update', $question->id) }}" method="POST" class="space-y-6">
          @csrf
          @method('PUT')

          <!-- Pertanyaan -->
          <div>
            <label for="question_text" class="block text-sm font-medium text-gray-700 mb-1">
              Pertanyaan
            </label>
            <input 
              type="text" 
              id="question_text" 
              name="question_text" 
              value="{{ old('question_text', $question->question_text) }}" 
              required 
              class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            >
            @error('question_text') 
              <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- Tipe Pertanyaan -->
          <div>
            <label for="question_type_id" class="block text-sm font-medium text-gray-700 mb-1">
              Tipe Pertanyaan
            </label>
            <select 
              id="question_type_id" 
              name="question_type_id" 
              required 
              class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            >
              @foreach ($questionTypes as $type)
                <option value="{{ $type->id }}" {{ old('question_type_id', $question->question_type_id) == $type->id ? 'selected' : '' }}>
                  {{ $type->name }}
                </option>
              @endforeach
            </select>
            @error('question_type_id') 
              <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <!-- Tombol Update -->
          <div class="flex justify-end pt-4">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-md shadow-md transition-all">
              Update Pertanyaan
            </button>
          </div>
        </form>

      </div>
    </div>
  </div>
</x-app-layout>
