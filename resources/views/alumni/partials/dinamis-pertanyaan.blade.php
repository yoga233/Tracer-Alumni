<div class="space-y-6">
    @foreach ($questions as $index => $question)
        @php
            $conditions = $question->questionConditions
                ?->filter(fn($c) => $c->field === 'employment_status')
                ?->pluck('value_status_kerja')
                ?->toArray() ?? [];
        @endphp

        <div class="space-y-2 conditional-question {{ !empty($conditions) ? 'hidden' : '' }}" 
             data-condition-field="employment_status" 
             data-condition-values="{{ implode(',', $conditions) }}">
             
            <label class="block font-medium text-gray-700">
                <span class="font-bold text-lg">{{ $index + 1 }}. </span>{{ $question->question_text }}
                @if ($question->is_required)
                    <span class="text-red-600">*</span>
                @endif
            </label>

            @switch($question->questiontype?->name)
                @case('text')
                    <input type="text" name="answers[{{ $question->id }}]" 
                        {{ $question->is_required ? 'required' : '' }}
                        class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
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
                                <input type="checkbox" name="answers[{{ $question->id }}][]" value="{{ $option->option_text }}" class="w-5 h-5 text-blue-600">
                                <span class="ml-2">{{ $option->option_text }}</span>
                            </label>
                        @endforeach
                    </div>
                    @break

                @case('select')
                    <select name="answers[{{ $question->id }}]" 
                        {{ $question->is_required ? 'required' : '' }}
                        class="w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Pilih --</option>
                        @foreach ($question->options as $option)
                            <option value="{{ $option->option_text }}">{{ $option->option_text }}</option>
                        @endforeach
                    </select>
                    @break

                @case('scale')
                    <div class="flex flex-wrap gap-4">
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
                            <table class="min-w-full border border-gray-300">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Pernyataan</th>
                                        @foreach ($columns as $column)
                                            <th class="px-4 py-2 text-center text-sm font-medium text-gray-700">{{ $column }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rows as $row)
                                        <tr>
                                            <td class="px-4 py-2 text-sm text-gray-800">{{ $row }}</td>
                                            @foreach ($columns as $column)
                                                <td class="text-center">
                                                    <input type="radio" 
                                                        name="answers[{{ $question->id }}][{{ $row }}]" 
                                                        value="{{ $column }}"
                                                        {{ $question->is_required ? 'required' : '' }}
                                                        class="text-indigo-600 focus:ring-indigo-500">
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

            @error('answers.' . $question->id)
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>
    @endforeach
</div>
