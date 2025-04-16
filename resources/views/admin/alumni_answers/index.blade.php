<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">
            Jawaban Alumni (Tampilan Tabel)
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="overflow-auto bg-white dark:bg-gray-900 shadow-xl rounded-xl border border-gray-200 dark:border-gray-700">
                <table class="min-w-full table-auto text-sm text-left text-gray-700 dark:text-gray-200">
                    <thead class="bg-gray-100 dark:bg-gray-800 border-b dark:border-gray-600">
                        <tr>
                            <th class="px-4 py-3 font-semibold whitespace-nowrap">ID</th>
                            @foreach ($questions->take(5) as $question)
                                <th class="px-4 py-3 font-semibold whitespace-nowrap">
                                    {{ $question->question_text }}
                                </th>
                            @endforeach
                            <th class="px-4 py-3 font-semibold whitespace-nowrap">Lainnya</th>
                            <th class="px-4 py-3 font-semibold whitespace-nowrap">Waktu Isi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($alumniRows as $index => $row)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                <td class="px-4 py-2 whitespace-nowrap">{{ $index + 1 }}</td>

                                @foreach ($questions->take(5) as $question)
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        {{ $row[$question->question_text] ?? '-' }}
                                    </td>
                                @endforeach

                                <td class="px-4 py-2 whitespace-nowrap">
                                    <button
                                        class="text-blue-600 hover:underline"
                                        data-row='@json($row)'
                                        onclick="showDetails(this)">
                                        Lihat Selengkapnya
                                    </button>
                                </td>

                                <td class="px-4 py-2 whitespace-nowrap">
                                    {{ optional($row['created_at'])->format('d M Y, H:i') ?? '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Tambahkan pagination jika perlu --}}
                <div class="p-4">
                    {{-- {{ $pagination->links() }} --}}
                </div>
            </div>
        </div>
    </div>

    <script>
        function showDetails(button) {
            const data = JSON.parse(button.getAttribute('data-row'));

            let detail = "Detail Jawaban Alumni:\n\n";
            Object.entries(data).forEach(([key, value]) => {
                if (!['created_at', 'submission_id'].includes(key)) {
                    detail += `${key}: ${value}\n`;
                }
            });

            alert(detail);
        }
    </script>
</x-app-layout>
