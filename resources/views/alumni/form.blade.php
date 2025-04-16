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

                    @if (!empty($questions) && $questions->count())
                        @foreach ($questions as $index => $question)
                            <div class="space-y-1">
                                <label class="block font-medium text-gray-700">
                                    <span class="font-bold text-lg">{{ $index + 1 }}. </span>{{ $question->question_text }} <span class="text-red-600">*</span>
                                </label>

                                @if ($question->type->name == 'text')
                                    <input type="text" name="answers[{{ $question->id }}]" required
                                        class="form-input w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">

                                @elseif ($question->type->name == 'textarea')
                                    <textarea name="answers[{{ $question->id }}]" rows="4" required
                                        class="form-textarea w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>

                                @elseif ($question->type->name == 'radio' && is_array($question->options))
                                    <div class="space-y-2">
                                        @foreach ($question->options as $option)
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option }}" required class="form-radio text-blue-600">
                                                <span class="ml-2">{{ $option }}</span>
                                            </label><br>
                                        @endforeach
                                    </div>

                                @elseif ($question->type->name == 'checkbox' && is_array($question->options))
                                    <div class="space-y-2">
                                        @foreach ($question->options as $option)
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" name="answers[{{ $question->id }}][]" value="{{ $option }}" class="form-checkbox text-blue-600">
                                                <span class="ml-2">{{ $option }}</span>
                                            </label><br>
                                        @endforeach
                                    </div>

                                @elseif ($question->type->name == 'select' && is_array($question->options))
                                    <select name="answers[{{ $question->id }}]" required
                                        class="form-select w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        @foreach ($question->options as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>

                                @elseif ($question->type->name == 'scale' && is_array($question->options))
                                    <div class="flex gap-4 items-center">
                                        @foreach ($question->options as $option)
                                            <label class="flex flex-col items-center">
                                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option }}" required class="form-radio text-blue-600">
                                                <span class="mt-1 text-sm">{{ $option }}</span>
                                            </label>
                                        @endforeach
                                    </div>

                                @elseif ($question->type->name == 'matrix' && is_array($question->options['rows']) && is_array($question->options['columns']))
                                    <div class="overflow-x-auto">
                                        <table class="table-auto border w-full text-sm text-center">
                                            <thead class="bg-gray-100">
                                                <tr>
                                                    <th class="border px-2 py-2 text-left">Pernyataan</th>
                                                    @foreach ($question->options['columns'] as $column)
                                                        <th class="border px-2 py-2">{{ $column }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($question->options['rows'] as $rowIndex => $rowText)
                                                    <tr>
                                                        <td class="border px-2 py-2 text-left">{{ $rowText }}</td>
                                                        @foreach ($question->options['columns'] as $colIndex => $column)
                                                            <td class="border px-2 py-2">
                                                                <input type="radio"
                                                                    name="answers[{{ $question->id }}][{{ $rowIndex }}]"
                                                                    value="{{ $column }}"
                                                                    required
                                                                    class="form-radio text-blue-600">
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif

                                @error('answers.' . $question->id)
                                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach
                    @else
                        <p class="text-center text-gray-500">Tidak ada pertanyaan yang tersedia saat ini.</p>
                    @endif

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
