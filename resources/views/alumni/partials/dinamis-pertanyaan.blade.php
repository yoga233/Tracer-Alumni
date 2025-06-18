<div class="space-y-6">
    @foreach ($questions as $question)
        @php
        $conditions = optional($question->questionConditions)
            ->filter(fn($c) => $c->field === 'employment_status')
            ->pluck('value_status_kerja')
            ->toArray() ?? [];

        if (!is_array($conditions)) {
            $conditions = [];
        }

        @endphp

        {{-- WRAP SETIAP PERTANYAAN DENGAN CARD --}}
        <div class="w-full bg-white p-9 rounded shadow mb-6 conditional-question {{ !empty($conditions) ? 'hidden' : '' }}"
             data-condition-field="employment_status"
             data-condition-values="{{ implode(',', $conditions) }}">

            {{-- Label Pertanyaan --}}
            <label class="block font-semibold text-base text-gray-700 mb-3">
                {{ $question->question_text }}
                @if ($question->is_required)
                    <span class="text-red-600">*</span>
                @endif
            </label>

            {{-- Input Field Berdasarkan Tipe --}}
            @switch($question->questiontype?->name)
                @case('text')
                    <input type="text" name="answers[{{ $question->id }}]"
                        {{ $question->is_required ? 'required' : '' }}
                        class="w-full sm:w-1/2 border-0 border-b border-gray-300 focus:ring-0 focus:border-orange-600 py-2 bg-transparent text-base">
                    @break

                @case('textarea')
                    <textarea name="answers[{{ $question->id }}]" rows="4"
                        {{ $question->is_required ? 'required' : '' }}
                        class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                    @break

                @case('radio')
                    <div class="space-y-2">
                        @foreach ($question->options as $option)
                            <label class="inline-flex items-center">
                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->option_text }}"
                                    {{ $question->is_required ? 'required' : '' }} class="text-blue-600">
                                <span class="ml-2">{{ $option->option_text }}</span>
                            </label>
                        @endforeach
                    </div>
                    @break

                @case('checkbox')
                    <div class="space-y-2">
                        @foreach ($question->options as $option)
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="answers[{{ $question->id }}][]" value="{{ $option->option_text }}"
                                    class="w-5 h-5 text-blue-600">
                                <span class="ml-2">{{ $option->option_text }}</span>
                            </label>
                        @endforeach
                    </div>
                    @break

                @case('select')
                    <select name="answers[{{ $question->id }}]"
                        {{ $question->is_required ? 'required' : '' }}
                        class="w-full sm:w-1/2 mt-2 border-0 border-b border-gray-300 focus:ring-0 focus:border-orange-600 py-2 bg-transparent text-base">
                        <option value="">-- Pilih --</option>
                        @foreach ($question->options as $option)
                            <option value="{{ $option->option_text }}">{{ $option->option_text }}</option>
                        @endforeach
                    </select>
                    @break

                @case('scale')
                    <div class="flex flex-wrap gap-4 mt-2">
                        @foreach ($question->options as $option)
                            <label class="flex flex-col items-center w-16">
                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->option_text }}"
                                    {{ $question->is_required ? 'required' : '' }} class="text-blue-600">
                                <span class="mt-1 text-sm">{{ $option->option_text }}</span>
                            </label>
                        @endforeach
                    </div>
                    @break

                @case('matrix')
                    @if ($rows->count() && $columns->count())
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-300 text-sm">
                                <thead class="bg-gray-100 text-center">
                                    <tr>
                                        <th class="border px-4 py-2 text-left">Pernyataan</th>
                                        @foreach ($columns as $column)
                                            <th class="border px-4 py-2">{{ $column }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rows as $row)
                                        <tr class="even:bg-gray-50">
                                            <td class="border px-4 py-2">{{ $row }}</td>
                                            @foreach ($columns as $column)
                                                <td class="border px-4 py-2 text-center">
                                                    <input type="radio"
                                                        name="answers[{{ $question->id }}][{{ $row }}]"
                                                        value="{{ $column }}"
                                                        {{ $question->is_required ? 'required' : '' }}
                                                        class="form-radio text-orange-600 focus:ring-orange-500">
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @break
            @endswitch

            {{-- Error Message --}}
            @error('answers.' . $question->id)
                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>
    @endforeach
</div>
