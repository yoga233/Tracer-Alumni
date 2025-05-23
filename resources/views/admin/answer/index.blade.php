{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">
            Jawaban untuk Pertanyaan: {{ $question->question_text }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <a href="{{ route('admin.answers.create', $question) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md">Tambah Jawaban</a>
                <table class="min-w-full mt-4">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left">Jawaban</th>
                            <th class="px-6 py-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($answers as $answer)
                            <tr>
                                <td class="px-6 py-3">{{ $answer->answer_text }}</td>
                                <td class="px-6 py-3">
                                    <a href="{{ route('admin.answers.edit', [$question, $answer]) }}" class="text-blue-600">Edit</a>
                                    <form action="{{ route('admin.answers.destroy', [$question, $answer]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600">Happus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout> --}}
