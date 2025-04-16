<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">
            Edit Pertanyaan
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">

                <!-- Form Edit -->
                <form action="{{ route('admin.questions.update', $question->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">

                        <!-- Pertanyaan -->
                        <div>
                            <label for="question_text" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Pertanyaan</label>
                            <input type="text" id="question_text" name="question_text" value="{{ old('question_text', $question->question_text) }}" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                            @error('question_text') 
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tipe Pertanyaan -->
                        <div>
                            <label for="question_type_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Tipe Pertanyaan</label>
                            <select id="question_type_id" name="question_type_id" required class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                                @foreach ($questionTypes as $type)
                                    <option value="{{ $type->id }}" {{ old('question_type_id', $question->question_type_id) == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('question_type_id') 
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tombol Update -->
                        <div class="flex justify-end">
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md shadow-md">
                                Update Pertanyaan
                            </button>
                        </div>
                    </div>
                </form>


            </div>
        </div>
    </div>
</x-app-layout>
